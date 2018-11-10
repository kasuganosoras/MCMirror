<?php

namespace App\Applications\Forge;

use App\Applications\ApplicationInterface;

class SpongeForge implements ApplicationInterface
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
        return 'https://www.spongepowered.org/downloads/spongeforge';
    }

    public function getName(): string
    {
        return 'Sponge Forge';
    }

    public function getCategory(): string
    {
        return 'Forge';
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
