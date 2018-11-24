<?php


namespace App\Structs;


use App\Application\ApplicationInterface;
use Symfony\Component\Finder\SplFileInfo;

class Build extends AbstractBuild
{
    /**
     * @var ApplicationInterface
     */
    protected $application;

    /**
     * @var SplFileInfo
     */
    protected $file;

    /**
     * @var string
     */
    protected $directLink;

    /**
     * @var string
     */
    protected $grabLink;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var int
     */
    protected $downloadCounter;

    /**
     * Build constructor.
     * @param ApplicationInterface $application
     * @param SplFileInfo $file
     * @param string $directLink
     * @param string $grabLink
     * @param int $downloadCounter
     */
    public function __construct(ApplicationInterface $application, SplFileInfo $file, string $directLink, string $grabLink, int $downloadCounter = 0)
    {
        $this->application = $application;
        $this->file = $file;
        $this->directLink = $directLink;
        $this->grabLink = $grabLink;
        $this->version = $this->readMinecraftVersion($application, $file);
        $this->downloadCounter = $downloadCounter;
    }

    public function getHumanSize(): string
    {
        return $this->getHumanFilesize($this->file->getSize());
    }

    public function getByteSize(): int
    {
        return $this->file->getSize();
    }

    public function getHumanDate(): string
    {
        return date('F d, Y', $this->file->getMTime());
    }

    public function getEpochDate(): int
    {
        return $this->file->getMTime();
    }

    public function getMinecraftVersion(): string
    {
        return $this->version;
    }

    public function getDirectLink(): string
    {
        return $this->directLink;
    }

    public function getGrabLink(): string
    {
        return $this->grabLink;
    }

    public function getFileName(): string
    {
        return $this->file->getFilename();
    }

    public function getDownloadCounter(): int
    {
        return $this->downloadCounter;
    }

    public function setDownloadCounter(int $downloadAmount): void
    {
        $this->downloadCounter = $downloadAmount;
    }

    public function getFile(): SplFileInfo
    {
        return $this->file;
    }

    protected function readMinecraftVersion(ApplicationInterface $application, SplFileInfo $file): string
    {
        $versionRegex = $application->getVersionRegex();

        if (!\is_array($versionRegex)) {
            $versionRegex = [$versionRegex];
        }

        $version = null;
        foreach ($application->getVersionGroupOverride() as $group => $regex) {
            if (preg_match($regex, $file->getFilename()) === 1) {
                $version = $group;
                break;
            }
        }

        if ($version === null) {
            foreach ($versionRegex as $regex) {
                preg_match($regex, $file->getFilename(), $version);

                if (isset($version[1])) {
                    $version = $version[1];
                    break;
                }
            }
        }

        if ($version === null || \is_array($version)) {
            $version = $file->getBasename();
        }

        return $version;
    }

    protected function getHumanFilesize($bytes, $decimals = 2): string
    {
        $sz = 'BKMGTP';
        $factor = (int)floor((\strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / (1024 ** $factor)) . @$sz[$factor];
    }
}