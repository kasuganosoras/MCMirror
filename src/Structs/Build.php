<?php declare(strict_types=1);

namespace App\Structs;

use App\Application\ApplicationInterface;
use Symfony\Component\Finder\SplFileInfo;

class Build extends AbstractBuild
{
    public const REGEX = '/([0-9.]+)-(\w+)-(\d+)-(\d+).jar/m';

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
     * @var string
     */
    protected $buildDate;

    /**
     * @var string
     */
    protected $buildHash;

    /**
     * Build constructor.
     *
     * @param ApplicationInterface $application
     * @param SplFileInfo          $file
     * @param string               $directLink
     * @param string               $grabLink
     * @param int                  $downloadCounter
     */
    public function __construct(ApplicationInterface $application, SplFileInfo $file, string $directLink, string $grabLink, int $downloadCounter = 0)
    {
        $this->application = $application;
        $this->file = $file;
        $this->directLink = $directLink;
        $this->grabLink = $grabLink;
        $this->downloadCounter = $downloadCounter;

        preg_match_all(static::REGEX, $file->getFilename(), $matches, PREG_SET_ORDER, 0);

        [, $this->version, $this->buildHash, $buildDate, $buildTime] = $matches[0];

        $this->buildDate = \DateTime::createFromFormat('Ymd-Hi', $buildDate . '-' . $buildTime);
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
        return $this->getBuildDate()->format('F d, Y');
    }

    public function getEpochDate(): int
    {
        return $this->getBuildDate()->getTimestamp();
    }

    public function getMinecraftVersion(): string
    {
        return $this->version;
    }

    public function getBuildHash(): string
    {
        return $this->buildHash;
    }

    public function getBuildDate(): \DateTime
    {
        return $this->buildDate;
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

    protected function getHumanFilesize($bytes, $decimals = 2): string
    {
        $sz = 'BKMGTP';
        $factor = (int) floor((\strlen((string) $bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / (1024 ** $factor)) . @$sz[$factor];
    }
}
