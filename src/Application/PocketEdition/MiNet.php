<?php

namespace App\Application\PocketEdition;

use App\Application\ApplicationInterface;

class MiNet implements ApplicationInterface
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
        return 'https://ci.appveyor.com/project/NiclasOlofsson/MiNET/branch/master/artifacts';
    }

    public function getName(): string
    {
        return 'BungeeCord';
    }

    public function getCategory(): string
    {
        return 'Pocket Edition';
    }

    public function getOfficialLinks(): array
    {
        return [];
    }

    public function getVersionRegex(): array
    {
        return [
            '/[a-zA-Z]+-([0-9.]+).*/',
            '/.*(latest).*/',
        ];
    }
}
