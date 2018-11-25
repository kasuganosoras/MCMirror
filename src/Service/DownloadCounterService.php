<?php declare(strict_types=1);

namespace App\Service;

use App\Application\ApplicationInterface;
use App\Structs\BuildInterface;

class DownloadCounterService
{
    /**
     * @var DownloadCounterInterface|null
     */
    private $downloadCounter;

    /**
     * DownloadCounterService constructor.
     *
     * @param iterable $downloadCounters
     */
    public function __construct(iterable $downloadCounters)
    {
        $downloadCounterName = getenv('DOWNLOAD_COUNTER');

        /** @var DownloadCounterInterface $downloadCounter */
        foreach ($downloadCounters as $downloadCounter) {
            if ($downloadCounterName === $downloadCounter->getName()) {
                $this->downloadCounter = $downloadCounter;
                $this->downloadCounter->boot();
            }
        }
    }

    public function increaseCounter(ApplicationInterface $application, BuildInterface $build): void
    {
        if ($this->downloadCounter === null) {
            return;
        }

        $this->downloadCounter->increaseCounter($application, $build);
    }

    public function getCounter(ApplicationInterface $application, BuildInterface $build): int
    {
        if ($this->downloadCounter === null) {
            return 0;
        }

        return $this->downloadCounter->getCount($application, $build);
    }

    public function getCountForApplication(ApplicationInterface $application): int
    {
        if ($this->downloadCounter === null) {
            return 0;
        }

        return $this->downloadCounter->getCountForApplication($application);
    }

    public function getTotalCount(): int
    {
        if ($this->downloadCounter === null) {
            return 0;
        }

        return $this->downloadCounter->getTotalCount();
    }
}
