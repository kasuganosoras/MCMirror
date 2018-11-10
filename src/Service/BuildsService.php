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
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function getBuildsForApplication(ApplicationInterface $application)
    {
        $basePath = getenv('DATA_PATH');
        $applicationPath = $basePath . DIRECTORY_SEPARATOR . $application->getName();

        $finder = new Finder();
        $finder->files()->in($applicationPath);


        $builds = [];
        foreach ($finder as $file) {
            $builds[] = [
                'fileName' => $file->getFilename(),
                'version' => '', //TODO: Get correct Version
                'size' => $file->getSize(),
                'date' => date('Y-m-d', $file->getMTime()),
                'downloadUrl' => $this->router->generate('files', [
                    'applicationName' => $application->getName(),
                    'fileName' => $file->getFilename(),
                ])
            ];

        }

        return $builds;
    }
}