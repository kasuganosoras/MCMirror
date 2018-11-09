<?php


namespace App\Applications\PocketEdition;

use App\Applications\ApplicationInterface;


class Nukkit implements ApplicationInterface
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
        return 'https://ci.nukkitx.com/job/NukkitX/job/Nukkit/job/master/';
    }

    public function getName(): string
    {
        return 'Nukkit';
    }

    public function getCategory(): string
    {
        return 'Pocket Edition';
    }

    public function getOfficialLinks(): array
    {
        return [];
    }
}