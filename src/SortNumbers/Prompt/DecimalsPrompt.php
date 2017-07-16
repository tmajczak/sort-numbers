<?php

namespace SortNumbers\Prompt;

use SortNumbers\Question\Factory\QuestionFactory;
use SortNumbers\Question\Question;
use SortNumbers\Question\Validator\NumericValidator;
use SortNumbers\Question\Validator\PositiveNumberWithZeroValidator;

class DecimalsPrompt extends Prompt
{
    const QUESTION = 'Please enter number of decimal places: ';
    const DEFAULT_VALUE = 0;
    const FIELD = 'number of decimal places';

    /**
     * @return DecimalsPrompt
     */
    public function doPrompt(): DecimalsPrompt
    {
        $this->promptValue = $this->getAskValue($this->createQuestion());

        return $this;
    }

    /**
     * @return Question
     */
    protected function createQuestion(): Question
    {
        $Question = QuestionFactory::create(self::QUESTION, self::DEFAULT_VALUE);
        $Question
            ->addQuestionValidator(new NumericValidator(self::FIELD))
            ->addQuestionValidator(new PositiveNumberWithZeroValidator(self::FIELD))
        ;

        return $Question;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return (int)$this->promptValue;
    }
}
