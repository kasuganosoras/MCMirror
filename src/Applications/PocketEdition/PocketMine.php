<?php


namespace App\Applications\PocketEdition;

use App\Applications\ApplicationInterface;


class PocketMine implements ApplicationInterface
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
        return 'https://github.com/pmmp/PocketMine-MP/releases';
    }

    public function getName(): string
    {
        return 'PocketMine';
    }

    public function getCategory(): string
    {
        return 'Pocket Edition';
    }

    public function getOfficialLinks(): array
    {
        return [];
    }
}