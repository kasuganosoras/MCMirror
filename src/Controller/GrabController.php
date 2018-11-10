<?php

namespace App\Controller;

use App\Service\ApplicationService;
use App\Service\BuildsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GrabController extends AbstractController
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
     * DownloadsController constructor.
     * @param ApplicationService $applicationService
     * @param BuildsService $buildsService
     */
    public function __construct(ApplicationService $applicationService, BuildsService $buildsService)
    {
        $this->applicationService = $applicationService;
        $this->buildsService = $buildsService;
    }

    /**
     * @Route("/grab/{applicationName}/{fileName}", name="grab")
     * @param string $applicationName
     * @param string $fileName
     * @return Response
     */
    public function index(string $applicationName, string $fileName): Response
    {
        $application = $this->applicationService->getApplication($applicationName);

        if ($application === null) {
            throw $this->createNotFoundException(sprintf('Could not find Application %s', $applicationName));
        }

        if (!$this->buildsService->doesBuildExist($application, $fileName)) {
            throw $this->createNotFoundException(sprintf('Could not find File %s for Application %s', $fileName, $applicationName));
        }

        return $this->render('grab/index.html.twig', [
            'title' => 'Download ' . $fileName,
            'application' => $application,
            'filename' => $fileName,
        ]);
    }
}
