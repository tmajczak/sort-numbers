<?php

namespace SortNumbers\Prompt;

use SortNumbers\Helper\DigitalInformationUnit;
use SortNumbers\Question\Factory\QuestionFactory;
use SortNumbers\Question\Question;
use SortNumbers\Question\Validator\FileSizeStringValidator;

class FileSizePrompt extends Prompt
{
    const QUESTION = 'Please enter file size to generate (ex. 5KB, 5MB, 5GB): ';

    /**
     * @return FileSizePrompt
     */
    public function doPrompt(): FileSizePrompt
    {
        $this->promptValue = $this->getAskValue($this->createQuestion());

        return $this;
    }

    /**
     * @return Question
     */
    protected function createQuestion(): Question
    {
        $Question = QuestionFactory::create(self::QUESTION);
        $Question->addQuestionValidator(new FileSizeStringValidator());

        return $Question;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return DigitalInformationUnit::getSizeInBytesFromString($this->promptValue);
    }
}
