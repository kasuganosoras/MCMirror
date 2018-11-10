<?php

namespace App\Controller;

use App\Service\ApplicationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FilesController extends AbstractController
{
    /**
     * @var ApplicationService
     */
    private $applicationService;

    /**
     * FilesController constructor.
     * @param ApplicationService $applicationService
     */
    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }


    /**
     * @Route("/files/{applicationName}/{fileName}", name="files")
     * @param string $applicationName
     * @param string $fileName
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index(string $applicationName, string $fileName)
    {
        $application = $this->applicationService->getApplication($applicationName);

        if ($application === null) {
            throw $this->createNotFoundException(sprintf('Could not find Application %s', $applicationName));
        }

        $basePath = getenv('DATA_PATH');
        $applicationPath = $basePath . DIRECTORY_SEPARATOR . $application->getName();
        $buildPath = $applicationPath . DIRECTORY_SEPARATOR . $fileName;

        return $this->file($buildPath);
    }
}
