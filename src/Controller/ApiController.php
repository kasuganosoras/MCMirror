<?php

namespace App\Controller;

use App\Application\ApplicationInterface;
use App\Service\ApplicationService;
use App\Service\BuildsService;
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
     * ApiController constructor.
     * @param ApplicationService $applicationService
     * @param BuildsService $buildsService
     */
    public function __construct(ApplicationService $applicationService, BuildsService $buildsService)
    {
        $this->applicationService = $applicationService;
        $this->buildsService = $buildsService;
    }


    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index(): Response
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
    public function list(string $option, ?string $fileName = null): JsonResponse
    {
        $response = null;

        if ($option === 'all') {
            $response = $this->getAll();
        } else if (\in_array($option, $this->getAll(), true)) {
            if ($fileName !== null) {
                $response = $this->getForBuild($option, $fileName);
            } else {
                $response = $this->getForApplication($option);
            }
        }

        if ($response === null) {
            throw $this->createNotFoundException('Unknown Option');
        }

        return new JsonResponse($response);
    }

    private function getAll()
    {
        return array_map(function (ApplicationInterface $application) {
            return $application->getName();
        }, $this->applicationService->getApplications());
    }

    private function getForBuild(string $option, string $fileName): array
    {
        $application = $this->applicationService->getApplication($option);

        if (!$this->buildsService->doesBuildExist($application, $fileName)) {
            throw $this->createNotFoundException(sprintf('Could not find File %s for Application %s', $fileName, $option));
        }

        return $this->buildsService->getBuildForApplication($application, $fileName);
    }

    private function getForApplication(string $applicationName)
    {
        return array_map(function (array $build) {
            return $build['fileName'];
        }, $this->buildsService->getBuildsForApplication($this->applicationService->getApplication($applicationName)));
    }
}
