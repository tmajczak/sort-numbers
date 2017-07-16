<?php

namespace SortNumbers\Prompt;

use SortNumbers\Question\Question;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Prompt
{
    /**
     * @var QuestionHelper
     */
    private $Helper;

    /**
     * @var InputInterface
     */
    private $Input;

    /**
     * @var OutputInterface
     */
    private $Output;

    /**
     * @var mixed
     */
    protected $promptValue;

    /**
     * @param QuestionHelper $Helper
     * @param InputInterface $Input
     * @param OutputInterface $Output
     */
    public function __construct(QuestionHelper $Helper, InputInterface $Input, OutputInterface $Output)
    {
        $this->Helper = $Helper;
        $this->Input = $Input;
        $this->Output = $Output;
    }

    /**
     * @param Question $Question
     *
     * @return mixed
     */
    protected function getAskValue(Question $Question)
    {
        return $this->Helper->ask($this->Input, $this->Output, $Question);
    }
}
