<?php


namespace App\Applications\Proxies;

use App\Applications\ApplicationInterface;


class Travertine implements ApplicationInterface
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
        return 'https://papermc.io/downloads#Travertine';
    }

    public function getName(): string
    {
        return 'Travertine';
    }

    public function getCategory(): string
    {
        return 'Proxies';
    }
}