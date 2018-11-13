<?php

namespace App\Service;

use App\Application\ApplicationInterface;

class ApplicationService
{
    /**
     * @var ApplicationInterface[]
     */
    private $applications;
    /**
     * @var array
     */
    private $categories;

    /**
     * ApplicationService constructor.
     *
     * @param iterable $applications
     * @param array $categories
     */
    public function __construct(iterable $applications, array $categories)
    {
        $this->applications = [];

        foreach ($applications as $application) {
            $this->applications[] = $application;
        }

        $this->categories = $categories;
    }

    /**
     * @return ApplicationInterface[]|array
     */
    public function getApplications(): array
    {
        return $this->applications;
    }

    public function getApplication(string $applicationName)
    {
        foreach ($this->applications as $application) {
            if (strtolower($application->getName()) === strtolower($applicationName)) {
                return $application;
            }
        }

        return null;
    }

    public function getApplicationOrderedByCategory(): array
    {
        $orderedApplications = [];
        foreach ($this->categories as $category) {
            $orderedApplications[$category] = [];
        }

        foreach ($this->applications as $application) {
            $orderedApplications[$application->getCategory()][] = $application;
        }

        return $orderedApplications;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }
}
