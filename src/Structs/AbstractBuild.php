<?php declare(strict_types=1);

namespace App\Structs;

abstract class AbstractBuild implements BuildInterface
{
    public function getApiAnswer(): array
    {
        return [
            'size_human'  => $this->getHumanSize(),
            'size_bytes'  => $this->getByteSize(),
            'date_human'  => $this->getHumanDate(),
            'date_epoch'  => $this->getEpochDate(),
            'mc_version'  => $this->getMinecraftVersion(),
            'direct_link' => $this->getDirectLink(),
            'grab_link'   => $this->getGrabLink(),
        ];
    }
}
