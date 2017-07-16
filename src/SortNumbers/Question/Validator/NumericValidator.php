<?php

namespace SortNumbers\Question\Validator;

class NumericValidator implements QuestionValidatorInterface
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
        if (!is_numeric($value)) {
            throw new \RuntimeException(sprintf('The %s should be numeric value.', $this->field));
        }
    }
}
