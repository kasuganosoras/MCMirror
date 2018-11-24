<?php


namespace App\Structs;


use App\Application\ApplicationInterface;
use Symfony\Component\Finder\SplFileInfo;

class LatestBuild extends Build
{
    public function getFileName(): string
    {
        return strtolower($this->application->getName()) . '-latest.jar';
    }

}