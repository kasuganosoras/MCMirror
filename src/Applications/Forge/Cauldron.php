<?php


namespace App\Applications\Forge;

use App\Applications\ApplicationInterface;

class Cauldron implements ApplicationInterface
{
    public function isRecommended(): bool
    {
        return false;
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
        return 'Cauldron';
    }

    public function getCategory(): string
    {
        return 'Forge';
    }

    public function getOfficialLinks(): array
    {
        return [];
    }
}