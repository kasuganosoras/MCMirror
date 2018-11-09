<?php


namespace App\Applications\Other;

use App\Applications\ApplicationInterface;


class Bukkit implements ApplicationInterface
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
        return false;
    }

    public function getUrl(): ?string
    {
        return null;
    }

    public function getName(): string
    {
        return 'Bukkit';
    }

    public function getCategory(): string
    {
        return 'Other';
    }
}