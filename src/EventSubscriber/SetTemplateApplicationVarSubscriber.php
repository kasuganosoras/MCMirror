<?php

namespace App\EventSubscriber;

use App\Service\ApplicationService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\VarDumper\VarDumper;
use Twig\Environment;

class SetTemplateApplicationVarSubscriber implements EventSubscriberInterface
{
    /**
     * @var ApplicationService
     */
    private $applicationService;
    /**
     * @var Environment
     */
    private $environment;
    /**
     * @var iterable
     */
    private $availableLanguages;

    public function __construct(ApplicationService $applicationService, Environment $environment, iterable $availableLanguages)
    {
        $this->applicationService = $applicationService;
        $this->environment = $environment;
        $this->availableLanguages = $availableLanguages;
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }

    public function onKernelRequest()
    {
        $this->environment->addGlobal('sortedApplications', $this->applicationService->getApplicationOrderedByCategory());
        $this->environment->addGlobal('allApplications', $this->applicationService->getApplications());
        $this->environment->addGlobal('availableLanguages', $this->availableLanguages);
    }
}
