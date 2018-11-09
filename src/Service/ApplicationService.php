<?php

namespace App\Service;

use App\Applications\ApplicationInterface;

class ApplicationService
{
    /**
     * @var ApplicationInterface[]
     */
    private $applications;

    /**
     * ApplicationService constructor.
     * @param iterable $applications
     */
    public function __construct(iterable $applications)
    {
        $this->applications = [];

        foreach ($applications as $application) {
            $this->applications[] = $application;
        }
    }

    /**
     * @return ApplicationInterface[]|array
     */
    public function getApplications()
    {
        return $this->applications;
    }

    public function getApplication(string $applicationName) {
        foreach ($this->applications as $application) {
            if ($application->getName() === $applicationName) {
                return $application;
            }
        }

        return null;
    }

    public function getApplicationOrderedByCategory()
    {
        $orderedApplications = [];

        foreach ($this->applications as $application) {
            $orderedApplications[$application->getCategory()][] = $application;
        }

        return $orderedApplications;
    }
}