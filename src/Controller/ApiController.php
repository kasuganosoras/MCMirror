<?php

namespace App\Controller;

use App\Application\ApplicationInterface;
use App\Service\ApplicationService;
use App\Service\BuildsService;
use App\Service\DownloadCounterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class ApiController extends AbstractController
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
     * ApiController constructor.
     * @param ApplicationService $applicationService
     * @param BuildsService $buildsService
     * @param DownloadCounterService $downloadCounter
     */
    public function __construct(ApplicationService $applicationService, BuildsService $buildsService, DownloadCounterService $downloadCounter)
    {
        $this->applicationService = $applicationService;
        $this->buildsService = $buildsService;
        $this->downloadCounter = $downloadCounter;
    }


    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function indexAction(): Response
    {
        return $this->render('api/index.html.twig', [
            'title' => 'API'
        ]);
    }

    /**
     * @Route("/list/{option?all}/{fileName}", name="list")
     * @param string $option
     * @param null|string $fileName
     * @return JsonResponse
     */
    public function listAction(string $option, ?string $fileName = null): JsonResponse
    {
        $response = null;

        if ($option === 'all') {
            $response = array_map(function (ApplicationInterface $application) {
                return $application->getName();
            }, $this->applicationService->getApplications());
        } else if ($this->applicationService->getApplication($option) !== null) {
            $response = $this->getForApplication($option);
        }

        if ($response === null) {
            throw $this->createNotFoundException('Unknown Option');
        }

        return new JsonResponse($response);
    }

    /**
     * @Route("/file/{applicationName}/{fileName}", name="file")
     * @param string $applicationName
     * @param null|string $fileName
     * @return JsonResponse
     */
    public function fileAction(string $applicationName, string $fileName): JsonResponse
    {
        $response = null;

        $application = $this->applicationService->getApplication($applicationName);

        if (null === $application) {
            throw $this->createNotFoundException(sprintf('Could not find Application %s', $applicationName));
        }

        if (!$this->buildsService->doesBuildExist($application, $fileName)) {
            throw $this->createNotFoundException(sprintf('Could not find File %s for Application %s', $fileName, $fileName));
        }

        $build = $this->buildsService->getBuildForApplication($application, $fileName);

        $this->downloadCounter->increaseCounter($application, $build);

        return new JsonResponse($build->getApiAnswer());
    }

    private function getForApplication(string $applicationName)
    {
        return array_map(function (array $build) {
            return $build['fileName'];
        }, $this->buildsService->getBuildsForApplication($this->applicationService->getApplication($applicationName)));
    }
}
