<?php

namespace App\Application\Proxies;

use App\Application\ApplicationInterface;

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
