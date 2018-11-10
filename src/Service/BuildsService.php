<?php

namespace App\Service;

use App\Applications\ApplicationInterface;
use Symfony\Component\Finder\Finder;
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

    public function getBuildsForApplication(ApplicationInterface $application)
    {
        $applicationPath = $this->getPathForApplication($application);

        $finder = new Finder();
        $finder->files()->in($applicationPath);

        $builds = [];
        foreach ($finder as $file) {
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

            $builds[] = [
                'fileName' => $file->getFilename(),
                'version' => $version,
                'size' => $file->getSize(),
                'date' => date('Y-m-d', $file->getMTime()),
                'downloadUrl' => $this->router->generate('files', [
                    'applicationName' => $application->getName(),
                    'fileName' => $file->getFilename(),
                ]),
            ];
        }

        return $builds;
    }

    public function getPathForBuild(ApplicationInterface $application, string $fileName): string
    {
        return $this->getPathForApplication($application).DIRECTORY_SEPARATOR.$fileName;
    }

    public function getPathForApplication(ApplicationInterface $application): string
    {
        return getenv('DATA_PATH').DIRECTORY_SEPARATOR.$application->getName();
    }

    public function doesBuildExist(ApplicationInterface $application, string $fileName): bool
    {
        $applicationPath = $this->getPathForApplication($application);

        $finder = new Finder();
        $finder->files()->in($applicationPath)->name($fileName);

        return 1 === $finder->count();
    }
}
