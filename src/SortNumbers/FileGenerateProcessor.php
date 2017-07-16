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
    private $chunk;

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
        $file = $this->start($filePath);
        while(($filePosition = ftell($file)) <= $fileSize) {
            if ($this->shouldAdvanceProgress($filePosition, $fileSize)) {
                $this->advanceProgress();
            }

            $this->writeNumberToFile($file);
        }

        $this->end($file);
    }

    /**
     * @param string $filePath
     *
     * @return mixed
     */
    private function start(string $filePath)
    {
        $this->start = microtime(true);
        $this->ProgressBar->start();
        $this->chunk = 1;

        return fopen($filePath, 'w');
    }

    /**
     * @param int $filePosition
     * @param int $fileSize
     *
     * @return bool
     */
    private function shouldAdvanceProgress(int $filePosition, int $fileSize): bool
    {
        return $filePosition > ($fileSize / $this->ProgressBar->getMaxSteps() * $this->chunk);
    }

    private function advanceProgress(): void
    {
        $this->ProgressBar->advance();
        $this->chunk++;
    }

    /**
     * @param resource $file
     */
    private function writeNumberToFile($file): void
    {
        fwrite($file, $this->NumberGenerator->generate() . PHP_EOL);
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
