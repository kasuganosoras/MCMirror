<?php


namespace App\Applications\Proxies;

use App\Applications\ApplicationInterface;


class Velocity implements ApplicationInterface
{
    public function isRecommended(): bool
    {
        return true;
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
        return 'https://www.velocitypowered.com/downloads';
    }

    public function getName(): string
    {
        return 'Velocity';
    }

    public function getCategory(): string
    {
        return 'Proxies';
    }

    public function getOfficialLinks(): array
    {
        return [];
    }
}