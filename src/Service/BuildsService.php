<?php

namespace App\Service;

use App\Application\ApplicationInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Routing\RouterInterface;

class BuildsService
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * BuildsService constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getBuildsForApplication(ApplicationInterface $application): array
    {
        $applicationPath = $this->getPathForApplication($application);

        $finder = new Finder();
        $finder->files()->in($applicationPath);

        $builds = [];
        foreach ($finder as $file) {
            $builds[] = $this->getBuildForFile($application, $file);
        }

        return $builds;
    }

    public function getBuildForApplication(ApplicationInterface $application, string $fileName): array
    {
        return $this->getBuildForFile($application, $this->getSplFile($application, $fileName));
    }

    private function getBuildForFile(ApplicationInterface $application, SplFileInfo $file): array
    {
        $versionRegex = $application->getVersionRegex();

        if (!\is_array($versionRegex)) {
            $versionRegex = [$versionRegex];
        }

        $version = '';
        foreach ($versionRegex as $regex) {
            preg_match($regex, $file->getFilename(), $version);

            if (isset($version[1])) {
                $version = $version[1];
                break;
            }
        }

        if (\is_array($version)) {
            $version = $file->getBasename();
        }

        return [
            'fileName' => $file->getFilename(),
            'version' => $version,
            'size' => $file->getSize(),
            'date' => date('Y-m-d', $file->getMTime()),
            'downloadUrl' => $this->router->generate('files', [
                'applicationName' => $application->getName(),
                'fileName' => $file->getFilename(),
            ], RouterInterface::ABSOLUTE_URL),


            'size_bytes' => $file->getSize(),
            'size_human' => $this->getHumanFilesize($file->getSize()),
            'date_epoch' => $file->getMTime(),
            'date_human' => date('F d, Y', $file->getMTime()),
            'mc_version' => $version,
            'direct_link' => $this->router->generate('files', [
                'applicationName' => $application->getName(),
                'fileName' => $file->getFilename(),
            ], RouterInterface::ABSOLUTE_URL),
            'grab_link' => $this->router->generate('grab', [
                'applicationName' => $application->getName(),
                'fileName' => $file->getFilename(),
            ], RouterInterface::ABSOLUTE_URL),
        ];
    }

    public function getPathForBuild(ApplicationInterface $application, string $fileName): string
    {
        return $this->getPathForApplication($application) . DIRECTORY_SEPARATOR . $fileName;
    }

    public function getPathForApplication(ApplicationInterface $application): string
    {
        return getenv('DATA_PATH') . DIRECTORY_SEPARATOR . $application->getName();
    }

    public function doesBuildExist(ApplicationInterface $application, string $fileName): bool
    {
        return $this->getSplFile($application, $fileName) !== null;
    }

    private function getSplFile(ApplicationInterface $application, string $fileName): ?SplFileInfo
    {
        $applicationPath = $this->getPathForApplication($application);

        $finder = new Finder();
        $finder->files()->in($applicationPath)->name($fileName);

        if ($finder->count() === 1) {
            foreach ($finder as $file) {
                return $file;
            }
        }

        return null;
    }

    private function getHumanFilesize($bytes, $decimals = 2) {
        $sz = 'BKMGTP';
        $factor = (int) floor((\strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / (1024 ** $factor)) . @$sz[$factor];
    }
}
