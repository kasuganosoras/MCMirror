<?php

namespace App\Application\Vanilla;

use App\Application\ApplicationInterface;

class Glowstone implements ApplicationInterface
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
        return 'https://glowstone.net/#downloads';
    }

    public function getName(): string
    {
        return 'Glowstone';
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
