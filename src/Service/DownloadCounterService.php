<?php


namespace App\Service;


use App\Application\ApplicationInterface;
use App\Structs\BuildInterface;
use Symfony\Component\VarDumper\VarDumper;

class DownloadCounterService
{
    /**
     * @var DownloadCounterInterface|null
     */
    private $downloadCounter;

    /**
     * DownloadCounterService constructor.
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

        return $this->downloadCounter->getCounter($application, $build);
    }
}