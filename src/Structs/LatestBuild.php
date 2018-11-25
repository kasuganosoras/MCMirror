<?php declare(strict_types=1);

namespace App\Structs;

class LatestBuild extends Build
{
    public function getFileName(): string
    {
        return strtolower($this->application->getName()) . '-latest.jar';
    }
}
