<?php

namespace SortNumbers\Prompt;

use SortNumbers\Question\Factory\QuestionFactory;
use SortNumbers\Question\Question;
use SortNumbers\Question\Validator\NumericValidator;
use SortNumbers\Question\Validator\PositiveNumberValidator;

class MaximumNumberPrompt extends Prompt
{
    const QUESTION = 'Please enter maximum number: ';
    const FIELD = 'maximum number';

    /**
     * @return MaximumNumberPrompt
     */
    public function doPrompt(): MaximumNumberPrompt
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
        $Question
            ->addQuestionValidator(new NumericValidator(self::FIELD))
            ->addQuestionValidator(new PositiveNumberValidator(self::FIELD))
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
