<?php

namespace App\Service;

use App\Application\ApplicationInterface;
use App\Structs\Build;
use App\Structs\BuildInterface;
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
     * @var DownloadCounterService
     */
    private $downloadCounter;

    /**
     * BuildsService constructor.
     *
     * @param RouterInterface $router
     * @param DownloadCounterService $downloadCounter
     */
    public function __construct(RouterInterface $router, DownloadCounterService $downloadCounter)
    {
        $this->router = $router;
        $this->downloadCounter = $downloadCounter;
    }

    /**
     * @param ApplicationInterface $application
     * @return BuildInterface[]
     */
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

    public function getBuildForApplication(ApplicationInterface $application, string $fileName): BuildInterface
    {
        return $this->getBuildForFile($application, $this->getSplFile($application, $fileName));
    }

    private function getBuildForFile(ApplicationInterface $application, SplFileInfo $file): BuildInterface
    {
        $directLink = $this->router->generate('files', [
            'applicationName' => $application->getName(),
            'fileName' => $file->getFilename(),
        ], RouterInterface::ABSOLUTE_URL);

        $grabLink = $this->router->generate('grab', [
            'applicationName' => $application->getName(),
            'fileName' => $file->getFilename(),
        ], RouterInterface::ABSOLUTE_URL);

        $build = new Build($application, $file, $directLink, $grabLink);

        $build->setDownloadCounter($this->downloadCounter->getCounter($application, $build));

        return $build;
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
}
