<?php

namespace SortNumbers\Prompt;

use SortNumbers\Question\Factory\QuestionFactory;
use SortNumbers\Question\Question;
use SortNumbers\Question\Validator\FilePathValidator;

class OutputFilePrompt extends Prompt
{
    const QUESTION = 'Please enter absolute path of the output file: ';

    /**
     * @return OutputFilePrompt
     */
    public function doPrompt(): OutputFilePrompt
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
        $Question->addQuestionValidator(new FilePathValidator(false));

        return $Question;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->promptValue;
    }
}
