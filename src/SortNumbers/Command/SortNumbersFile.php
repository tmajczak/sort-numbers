<?php

namespace SortNumbers\Command;

use SortNumbers\FileSortProcessor;
use SortNumbers\Prompt\InputFilePrompt;
use SortNumbers\Prompt\OutputFilePrompt;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SortNumbersFile extends Command
{
    protected function configure()
    {
        $this
            ->setName('sort-numbers-file')
            ->setDescription('Sort file with random numbers (float or decimal).')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $helper = $this->getHelper('question');

        $inputFilePath = (new InputFilePrompt($helper, $input, $output))
            ->doPrompt()
            ->getValue()
        ;
        $outputFilePath = (new OutputFilePrompt($helper, $input, $output))
            ->doPrompt()
            ->getValue()
        ;

        $output->writeln('Sorting...');

        $Processor = new FileSortProcessor();
        $Processor->process($inputFilePath, $outputFilePath);

        $output->writeln(sprintf(
            '%sFile sorted in %.2f seconds',
            PHP_EOL,
            $Processor->getProcessTime()
        ));
    }
}
