<?php

namespace App\Applications\Proxies;

use App\Applications\ApplicationInterface;

class BungeeCord implements ApplicationInterface
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
        return 'https://ci.md-5.net/job/BungeeCord/';
    }

    public function getName(): string
    {
        return 'BungeeCord';
    }

    public function getCategory(): string
    {
        return 'Proxies';
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
