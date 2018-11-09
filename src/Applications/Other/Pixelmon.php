<?php


namespace App\Applications\Other;

use App\Applications\ApplicationInterface;


class Pixelmon implements ApplicationInterface
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
        return 'Pixelmon';
    }

    public function getCategory(): string
    {
        return 'Other';
    }
}