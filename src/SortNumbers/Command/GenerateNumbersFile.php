<?php

namespace SortNumbers\Command;

use SortNumbers\FileGenerateProcessor;
use SortNumbers\Generator\Factory\NumberGeneratorFactory;
use SortNumbers\Prompt\DecimalsPrompt;
use SortNumbers\Prompt\OutputFilePrompt;
use SortNumbers\Prompt\FileSizePrompt;
use SortNumbers\Prompt\MaximumNumberPrompt;
use SortNumbers\Prompt\MinimumNumberPrompt;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateNumbersFile extends Command
{
    const PROGRESS_BAR_PARTS = 50;
    
    protected function configure(): void
    {
        $this
            ->setName('generate-numbers-file')
            ->setDescription('Generate random numbers (float or decimal) and write them into a file.')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $helper = $this->getHelper('question');

        $maxNumber = (new MaximumNumberPrompt($helper, $input, $output))
            ->doPrompt()
            ->getValue()
        ;
        $minNumber = (new MinimumNumberPrompt($helper, $input, $output))
            ->doPrompt($maxNumber)
            ->getValue()
        ;
        $decimals = (new DecimalsPrompt($helper, $input, $output))
            ->doPrompt()
            ->getValue()
        ;
        $fileSize = (new FileSizePrompt($helper, $input, $output))
            ->doPrompt()
            ->getValue()
        ;
        $filePath = (new OutputFilePrompt($helper, $input, $output))
            ->doPrompt()
            ->getValue()
        ;

        $output->writeln('Generating...');

        $NumberGenerator = NumberGeneratorFactory::create($decimals);
        $NumberGenerator
            ->setMin($minNumber)
            ->setMax($maxNumber)
        ;

        $Processor = new FileGenerateProcessor(
            $NumberGenerator,
            new ProgressBar($output, self::PROGRESS_BAR_PARTS)
        );
        $Processor->process($filePath, $fileSize);

        $output->writeln(sprintf(
            '%sFile generated in %.2f seconds',
            PHP_EOL,
            $Processor->getProcessTime()
        ));
    }
}
