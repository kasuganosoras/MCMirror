<?php

namespace App\Controller;

use App\Service\ApplicationService;
use App\Service\BuildsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DownloadsController extends AbstractController
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
     * @Route("/downloads", name="downloads")
     */
    public function index(): RedirectResponse
    {
        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/downloads/{applicationName}", name="application_overview")
     * @param string $applicationName
     * @return Response
     */
    public function applicationOverview(string $applicationName): Response
    {
        $application = $this->applicationService->getApplication($applicationName);

        if ($application === null) {
            throw $this->createNotFoundException(sprintf('Could not find Application %s', $applicationName));
        }

        $builds = $this->buildsService->getBuildsForApplication($application);

        $versions = array_unique(array_map(function ($build) {
            return $build['version'];
        }, $builds));

        return $this->render('downloads/index.html.twig', [
            'title' => $application->getName() . ' Downloads',
            'application' => $application,
            'officialLinks' => $application->getOfficialLinks(),
            'versions' => $versions,
            'builds' => $builds,
        ]);
    }
}
