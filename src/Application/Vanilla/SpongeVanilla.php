<?php

namespace App\Application\Vanilla;

use App\Application\ApplicationInterface;

class SpongeVanilla implements ApplicationInterface
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
        return 'https://www.spongepowered.org/downloads/spongevanilla';
    }

    public function getName(): string
    {
        return 'Sponge Vanilla';
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
