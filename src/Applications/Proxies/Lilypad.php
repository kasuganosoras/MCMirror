<?php


namespace App\Applications\Proxies;

use App\Applications\ApplicationInterface;


class Lilypad implements ApplicationInterface
{
    public function isRecommended(): bool
    {
        return false;
    }

    public function isAbandoned(): bool
    {
        return false;
    }

    public function isExternal(): bool
    {
        return true;
    }

    public function getUrl(): ?string
    {
        return 'http://ci.lilypadmc.org/';
    }

    public function getName(): string
    {
        return 'Lilypad';
    }

    public function getCategory(): string
    {
        return 'Proxies';
    }
}