<?php

namespace App\Application\Vanilla;

use App\Application\ApplicationInterface;

class TacoSpigot implements ApplicationInterface
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
        return 'Taco Spigot';
    }

    public function getCategory(): string
    {
        return 'Vanilla';
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
