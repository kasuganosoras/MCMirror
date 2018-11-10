<?php

namespace App\Controller;

use App\Service\ApplicationService;
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
     * DownloadsController constructor.
     * @param ApplicationService $applicationService
     */
    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
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

        if (false) {//TODO: Not found file
            throw $this->createNotFoundException(sprintf('Could not find File %s for Application %s', $fileName, $applicationName));
        }

        return $this->render('grab/index.html.twig', [
            'title' => 'Download ' . $fileName,
            'application' => $application,
            'filename' => $fileName,
        ]);
    }
}
