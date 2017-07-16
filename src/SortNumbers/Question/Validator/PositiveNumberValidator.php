<?php

namespace SortNumbers\Question\Validator;

class PositiveNumberValidator implements QuestionValidatorInterface
{
    /**
     * @var string
     */
    private $field;

    /**
     * @param string $field
     */
    public function __construct(string $field)
    {
        $this->field = $field;
    }

    /**
     * @param mixed $value
     *
     * @throws \RuntimeException
     */
    public function validate($value): void
    {
        if ($value <= 0) {
            throw new \RuntimeException(sprintf('The %s should be higher than 0.', $this->field));
        }
    }
}
