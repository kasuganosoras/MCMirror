<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class SetLocaleFromCookieSubscriber implements EventSubscriberInterface
{
    private $defaultLocale;

    public function __construct(string $defaultLocale)
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        if ($request->getSession() === null) {
            $request->setSession(new Session());
        }

        if ($locale = $request->query->get('lang')) {
            $request->getSession()->set('lang', $locale);
        } elseif ($locale = $request->attributes->get('lang')) {
            $request->getSession()->set('lang', $locale);
        }

        $request->setLocale($request->getSession()->get('lang', $this->defaultLocale));
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => ['onKernelRequest', 20],
        ];
    }
}
