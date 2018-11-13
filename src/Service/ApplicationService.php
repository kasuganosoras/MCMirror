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

        foreach ($orderedApplications as $categoryName => &$applications) {
            usort($applications, function (ApplicationInterface $applicationA, ApplicationInterface $applicationB) {

                $i = 0;
                if ($applicationA->isRecommended() && !$applicationB->isRecommended()) {
                    $i--;
                }

                if (!$applicationA->isRecommended() && $applicationB->isRecommended()) {
                    $i++;
                }

                if (!$applicationA->isAbandoned() && $applicationB->isAbandoned()) {
                    $i--;
                }

                if ($applicationA->isAbandoned() && !$applicationB->isAbandoned()) {
                    $i++;
                }

                return $i;
            });
        }

        return $orderedApplications;
    }

    public function getCategories(): array
    {
        return $this->categories;
    }
}
