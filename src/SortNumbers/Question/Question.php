<?php

namespace SortNumbers\Question;

use SortNumbers\Question\Validator\QuestionValidatorInterface;
use Symfony\Component\Console\Question\Question as BaseQuestion;

class Question extends BaseQuestion
{
    /**
     * @var QuestionValidatorInterface[]
     */
    protected $questionValidators = [];

    /**
     * @param QuestionValidatorInterface $QuestionValidator
     *
     * @return Question
     */
    public function addQuestionValidator(QuestionValidatorInterface $QuestionValidator): Question
    {
        $this->questionValidators[] = $QuestionValidator;

        return $this;
    }

    /**
     * @return callable
     */
    public function getValidator(): callable
    {
        $validators = $this->questionValidators;

        return function ($answer) use ($validators) {
            /** @var QuestionValidatorInterface $validator */
            foreach ($validators as $validator) {
                $validator->validate($answer);
            }

            return $answer;
        };
    }
}
