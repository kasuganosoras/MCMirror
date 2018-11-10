<?php

namespace App\EventSubscriber;

use App\Service\ApplicationService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Twig\Environment;

class SetSortedApplicationsSubscriber implements EventSubscriberInterface
{
    /**
     * @var ApplicationService
     */
    private $applicationService;
    /**
     * @var Environment
     */
    private $environment;

    public function __construct(ApplicationService $applicationService, Environment $environment)
    {
        $this->applicationService = $applicationService;
        $this->environment = $environment;
    }


    public function onKernelRequest(GetResponseEvent $event)
    {
        $this->environment->addGlobal('sortedApplications', $this->applicationService->getApplicationOrderedByCategory());
    }

    public static function getSubscribedEvents()
    {
        return [
           'kernel.request' => 'onKernelRequest',
        ];
    }
}
