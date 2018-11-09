<?php


namespace App\Applications\Forge;

use App\Applications\ApplicationInterface;


class Thermos implements ApplicationInterface
{
    public function isRecommended(): bool
    {
        return true;
    }

    public function isAbandoned(): bool
    {
        return true;
    }

    public function isExternal(): bool
    {
        return false;
    }

    public function getUrl(): ?string
    {
        return null;
    }

    public function getName(): string
    {
        return 'Thermos';
    }

    public function getCategory(): string
    {
        return 'Forge';
    }
}