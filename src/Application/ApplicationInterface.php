<?php declare(strict_types=1);

namespace App\Application;

interface ApplicationInterface
{
    public function isRecommended(): bool;

    public function isAbandoned(): bool;

    public function isExternal(): bool;

    public function getUrl(): ?string;

    public function getName(): string;

    public function getCategory(): string;

    public function getOfficialLinks(): array;
}
