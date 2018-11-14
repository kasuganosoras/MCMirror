<?php


namespace App\Service;


use App\Application\ApplicationInterface;
use App\Structs\BuildInterface;

class RedisDownloadCounter implements DownloadCounterInterface
{

    /** @var \Redis */
    private $redis;

    public function boot(): void
    {
        $this->redis = new \Redis();
        $this->redis->connect(getenv('REDIS_HOST'));
    }

    public function getName(): string
    {
        return 'redis';
    }

    public function increaseCounter(ApplicationInterface $application, BuildInterface $build): void
    {
        $this->redis->incr($this->getKey($application, $build));
    }

    public function getCounter(ApplicationInterface $application, BuildInterface $build): int
    {
        return $this->redis->get($this->getKey($application, $build));
    }


    private function getKey(ApplicationInterface $application, BuildInterface $build): string
    {
        return 'dl_cnt_' . $application->getName() . '_' . $build->getFileName();
    }
}