<?php

namespace SortNumbers\Prompt;

use SortNumbers\Question\Factory\QuestionFactory;
use SortNumbers\Question\Question;
use SortNumbers\Question\Validator\ReadableFileValidator;

class InputFilePrompt extends Prompt
{
    const QUESTION = 'Please enter absolute path of the input file: ';

    /**
     * @return InputFilePrompt
     */
    public function doPrompt(): InputFilePrompt
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
        $Question->addQuestionValidator(new ReadableFileValidator());

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
