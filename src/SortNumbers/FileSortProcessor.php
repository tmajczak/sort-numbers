<?php

namespace SortNumbers;

use SortNumbers\Helper\MemoryLimit;

class FileSortProcessor
{
    /**
     * @var int
     */
    private $chunkMaxSize;

    /**
     * @var int
     */
    private $chunkSize;

    /**
     * @var int
     */
    private $inputToTempLoop;

    /**
     * @var array
     */
    private $tempFiles;

    /**
     * @var array
     */
    private $inputData;

    /**
     * @var array
     */
    private $minNumbers;

    /**
     * @var float
     */
    private $start;

    /**
     * @var float
     */
    private $end;

    public function __construct()
    {
        $this->chunkMaxSize = MemoryLimit::getSizeInBytes() / 16;
        $this->inputToTempLoop = 1;
    }

    /**
     * @param string $inputFilePath
     * @param string $outputFilePath
     */
    public function process(string $inputFilePath, string $outputFilePath): void
    {
        $this->start = microtime(true);

        if ($this->isSmallFile($inputFilePath)) {
            $this->simpleSort($inputFilePath, $outputFilePath);
        } else {
            $this->writeInputToTempFiles($inputFilePath);

            $this->writeTempFilesToOutput($outputFilePath);
            $this->unlinkTempFiles($inputFilePath);
        }

        $this->end = microtime(true);
    }

    /**
     * @param string $inputFilePath
     *
     * @return bool
     */
    private function isSmallFile(string $inputFilePath): bool
    {
        return filesize($inputFilePath) <= $this->chunkMaxSize;
    }

    /**
     * @param string $inputFilePath
     * @param string $outputFilePath
     */
    private function simpleSort(string $inputFilePath, string $outputFilePath)
    {
        $data = explode("\n", file_get_contents($inputFilePath));
        sort($data);
        file_put_contents($outputFilePath, implode("\n", $data));
    }

    /**
     * @param string $inputFilePath
     */
    private function writeInputToTempFiles(string $inputFilePath)
    {
        $inputFile = fopen($inputFilePath, 'r');
        $this->openNewTempFile($inputFilePath);
        while (($line = fgets($inputFile)) !== false) {
            $this->inputData[] = rtrim($line);

            if (ftell($inputFile) >= $this->chunkSize) {
                $this->writeDataToTempFile();

                $this->advanceToNextTempFile($inputFilePath);
            }
        }

        $this->writeDataToTempFile();
        fclose($inputFile);
    }

    /**
     * @param string $inputFilePath
     */
    private function openNewTempFile(string $inputFilePath)
    {
        $fileName = sprintf('%s.%s', $inputFilePath, $this->inputToTempLoop);
        $this->tempFiles[$this->inputToTempLoop] = fopen($fileName, 'w+');
        $this->chunkSize = $this->chunkMaxSize * $this->inputToTempLoop;
    }

    private function writeDataToTempFile()
    {
        $file = $this->tempFiles[$this->inputToTempLoop];

        sort($this->inputData);
        foreach ($this->inputData as $line) {
            fwrite($file, $line . PHP_EOL);
        }

        $this->inputData = [];
    }

    /**
     * @param string $inputFilePath
     */
    private function advanceToNextTempFile(string $inputFilePath)
    {
        $this->inputToTempLoop++;
        $this->openNewTempFile($inputFilePath);
    }

    /**
     * @param string $outputFilePath
     */
    private function writeTempFilesToOutput(string $outputFilePath)
    {
        $this->populateMinNumbersByTempFiles();

        $outputFile = fopen($outputFilePath, 'w');
        while(!empty($this->minNumbers)) {
            $key = $this->getLowestMinNumberKey();
            fwrite($outputFile, $this->minNumbers[$key]);

            $this->populateNextMinNumber($key);
        }

        fclose($outputFile);
    }

    private function populateMinNumbersByTempFiles()
    {
        foreach ($this->tempFiles as $key => $file) {
            rewind($file);
            $this->minNumbers[$key] = fgets($file);
        }
    }

    /**
     * @return int
     */
    private function getLowestMinNumberKey(): int
    {
        return array_search(min($this->minNumbers), $this->minNumbers);
    }

    /**
     * @param int $key
     */
    private function populateNextMinNumber(int $key)
    {
        $nextValue = fgets($this->tempFiles[$key]);

        if ($nextValue === false) {
            unset($this->minNumbers[$key]);
        } else {
            $this->minNumbers[$key] = $nextValue;
        }
    }

    /**
     * @param string $inputFilePath
     */
    private function unlinkTempFiles(string $inputFilePath)
    {
        foreach ($this->tempFiles as $key => $file) {
            fclose($file);
            unlink(sprintf('%s.%s', $inputFilePath, $key));
        }
    }

    /**
     * @return float
     */
    public function getProcessTime(): float
    {
        return $this->end - $this->start;
    }
}
