<?php


namespace App\Applications\Vanilla;

use App\Applications\ApplicationInterface;


class Paper implements ApplicationInterface
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
        return false;
    }

    public function getUrl(): ?string
    {
        return null;
    }

    public function getName(): string
    {
        return 'Paper';
    }

    public function getCategory(): string
    {
        return 'Vanilla';
    }
}