<?php

namespace SortNumbers;

use SortNumbers\Generator\NumberGeneratorInterface;
use Symfony\Component\Console\Helper\ProgressBar;

class FileGenerateProcessor
{
    /**
     * @var NumberGeneratorInterface
     */
    private $NumberGenerator;

    /**
     * @var ProgressBar
     */
    private $ProgressBar;

    /**
     * @var int
     */
    private $chunkSize;

    /**
     * @var float
     */
    private $start;

    /**
     * @var float
     */
    private $end;

    /**
     * @param NumberGeneratorInterface $NumberGenerator
     * @param ProgressBar $ProgressBar
     */
    public function __construct(NumberGeneratorInterface $NumberGenerator, ProgressBar $ProgressBar)
    {
        $this->NumberGenerator = $NumberGenerator;
        $this->ProgressBar = $ProgressBar;
    }

    /**
     * @param string $filePath
     * @param int $fileSize
     */
    public function process(string $filePath, int $fileSize): void
    {
        $file = $this->start($filePath, $fileSize);
        while(($filePosition = ftell($file)) <= $fileSize) {
            if ($filePosition > $this->chunkSize) {
                $this->advanceProgress($fileSize);
            }

            fwrite($file, $this->NumberGenerator->generate() . PHP_EOL);
        }

        $this->end($file);
    }

    /**
     * @param string $filePath
     * @param int $fileSize
     *
     * @return mixed
     */
    private function start(string $filePath, int $fileSize)
    {
        $this->start = microtime(true);
        $this->ProgressBar->start();
        $this->chunkSize = $fileSize / $this->ProgressBar->getMaxSteps();

        return fopen($filePath, 'w');
    }

    /**
     * @param int $fileSize
     */
    private function advanceProgress(int $fileSize): void
    {
        $this->ProgressBar->advance();
        $this->chunkSize += $fileSize / $this->ProgressBar->getMaxSteps();
    }

    /**
     * @param resource $file
     */
    private function end($file): void
    {
        fclose($file);
        $this->ProgressBar->finish();
        $this->end = microtime(true);
    }

    /**
     * @return float
     */
    public function getProcessTime(): float
    {
        return $this->end - $this->start;
    }
}
