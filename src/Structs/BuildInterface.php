<?php


namespace App\Structs;


interface BuildInterface
{
    public function getHumanSize(): string;

    public function getByteSize(): int;

    public function getHumanDate(): string;

    public function getEpochDate(): int;

    public function getMinecraftVersion(): string;

    public function getDirectLink(): string;

    public function getGrabLink(): string;

    public function getFileName(): string;

    public function getApiAnswer(): array;

    public function getDownloadCounter(): int;
}