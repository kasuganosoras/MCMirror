<?php


namespace App\Applications;


interface ApplicationInterface
{

    public function isRecommended(): bool;

    public function isAbandoned(): bool;

    public function isExternal(): bool;

    public function getUrl(): ?string;

    public function getName(): string;

    public function getCategory(): string;

}