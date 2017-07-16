<?php

namespace SortNumbers\Question\Validator;

class MaximumValidator implements QuestionValidatorInterface
{
    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $maxField;

    /**
     * @var int
     */
    private $maxFieldValue;

    /**
     * @param string $field
     * @param string $maxField
     * @param int $maxFieldValue
     */
    public function __construct(string $field, string $maxField, int $maxFieldValue)
    {
        $this->field = $field;
        $this->maxField = $maxField;
        $this->maxFieldValue = $maxFieldValue;
    }

    /**
     * @param mixed $value
     *
     * @throws \RuntimeException
     */
    public function validate($value): void
    {
        if ((int)$value > $this->maxFieldValue) {
            throw new \RuntimeException(sprintf(
                'The %s should be smaller than %s.',
                $this->field,
                $this->maxField
            ));
        }
    }
}
