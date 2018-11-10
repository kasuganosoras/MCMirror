<?php

namespace App\Controller;

use App\Service\ApplicationService;
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
     * DownloadsController constructor.
     * @param ApplicationService $applicationService
     */
    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
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

        $builds = [
            [
                'fileName' => 'bla.jar',
                'version' => '1.13.2',
                'size' => '1337',
                'date' => '1.1.1970',
                'downloadUrl' => '#'

            ], [
                'fileName' => 'bla.jar',
                'version' => '1.13.1',
                'size' => '1337',
                'date' => '1.1.1970',
                'downloadUrl' => '#'

            ]
        ];

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
