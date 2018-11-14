<?php

namespace App\Controller;

use App\Service\ApplicationService;
use App\Service\BuildsService;
use App\Service\DownloadCounterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FilesController extends AbstractController
{
    /**
     * @var ApplicationService
     */
    private $applicationService;
    /**
     * @var BuildsService
     */
    private $buildsService;
    /**
     * @var DownloadCounterService
     */
    private $downloadCounter;

    /**
     * FilesController constructor.
     *
     * @param ApplicationService $applicationService
     * @param BuildsService      $buildsService
     */
    public function __construct(ApplicationService $applicationService, BuildsService $buildsService, DownloadCounterService $downloadCounter)
    {
        $this->applicationService = $applicationService;
        $this->buildsService = $buildsService;
        $this->downloadCounter = $downloadCounter;
    }

    /**
     * @Route("/files/{applicationName}/{fileName}", name="files")
     *
     * @param string $applicationName
     * @param string $fileName
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index(string $applicationName, string $fileName)
    {
        $application = $this->applicationService->getApplication($applicationName);

        if (null === $application) {
            throw $this->createNotFoundException(sprintf('Could not find Application %s', $applicationName));
        }

        if (!$this->buildsService->doesBuildExist($application, $fileName)) {
            throw $this->createNotFoundException(sprintf('Could not find File %s for Application %s', $fileName, $applicationName));
        }

        $build = $this->buildsService->getBuildForApplication($application, $fileName);

        $this->downloadCounter->increaseCounter($application, $build);

        return $this->file($this->buildsService->getPathForBuild($application, $fileName));
    }
}
