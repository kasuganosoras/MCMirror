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

    public function getOfficialLinks(): array
    {
        return [
            'Downloads' => 'https://papermc.io/downloads',
            'Documentation' => 'https://paper.readthedocs.io/',
            'JavaDocs' => 'https://papermc.io/javadocs/',
            'GitHub' => 'https://github.com/PaperMC/Paper',
        ];
    }

    public function getVersionRegex(): array
    {
        return [
            '/[a-zA-Z]+-([0-9.]+).*/',
            '/.*(latest).*/',
        ];
    }
}