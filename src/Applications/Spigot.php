<?php


namespace App\Applications;


class Spigot implements ApplicationInterface
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
        return 'Spigot';
    }

    public function getCategory(): string
    {
        return 'Vanilla';
    }
}