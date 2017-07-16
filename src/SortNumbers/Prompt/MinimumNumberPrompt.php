<?php

namespace SortNumbers\Prompt;

use SortNumbers\Question\Factory\QuestionFactory;
use SortNumbers\Question\Question;
use SortNumbers\Question\Validator\MaximumValidator;
use SortNumbers\Question\Validator\NumericValidator;
use SortNumbers\Question\Validator\PositiveNumberValidator;

class MinimumNumberPrompt extends Prompt
{
    const QUESTION = 'Please enter minimum number: ';
    const FIELD = 'minimum number';
    const MAX_FIELD = 'maximum number';

    /**
     * @param int $maxValue
     *
     * @return MinimumNumberPrompt
     */
    public function doPrompt(int $maxValue): MinimumNumberPrompt
    {
        $this->promptValue = $this->getAskValue($this->createQuestion($maxValue));

        return $this;
    }

    /**
     * @param int $maxValue
     *
     * @return Question
     */
    protected function createQuestion(int $maxValue): Question
    {
        $Question = QuestionFactory::create(self::QUESTION);
        $Question
            ->addQuestionValidator(new NumericValidator(self::FIELD))
            ->addQuestionValidator(new PositiveNumberValidator(self::FIELD))
            ->addQuestionValidator(new MaximumValidator(self::FIELD, self::MAX_FIELD, $maxValue))
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
