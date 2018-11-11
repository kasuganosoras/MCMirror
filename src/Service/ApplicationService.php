<?php

namespace App\Service;

use App\Application\ApplicationInterface;
use Symfony\Component\VarDumper\VarDumper;

class ApplicationService
{
    /**
     * @var ApplicationInterface[]
     */
    private $applications;
    /**
     * @var array
     */
    private $categoryOrder;

    /**
     * ApplicationService constructor.
     *
     * @param iterable $applications
     * @param array $categoryOrder
     */
    public function __construct(iterable $applications, array $categoryOrder)
    {
        $this->applications = [];

        foreach ($applications as $application) {
            $this->applications[] = $application;
        }

        $this->categoryOrder = $categoryOrder;
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
            if ($application->getName() === $applicationName) {
                return $application;
            }
        }

        return null;
    }

    public function getApplicationOrderedByCategory(): array
    {
        $orderedApplications = [];
        foreach ($this->getCategoriesInOrder() as $category) {
            $orderedApplications[$category] = [];
        }

        foreach ($this->applications as $application) {
            $orderedApplications[$application->getCategory()][] = $application;
        }

        return $orderedApplications;
    }

    public function getCategories(): array
    {
        return array_map(function (ApplicationInterface $application) {
            return $application->getCategory();
        }, $this->getApplications());
    }

    public function getCategoriesInOrder(): array //TODO: This could be offloaded to a CompilerPass I think
    {
        $orderedCategories = [];
        $categories = $this->getCategories();

        foreach ($this->categoryOrder as $orderKey => $orderCategory)  {
            if (\in_array($orderCategory, $categories, true)) {
                $orderedCategories[$orderKey] = $orderCategory;
            }
        }
        foreach ($categories as $key => $category) {
            if (\in_array($category, $this->categoryOrder, true)) {
                unset($categories[$key]);
                continue;
            }

            $orderedCategories[] = $category;
        }

        return $orderedCategories;
    }
}
