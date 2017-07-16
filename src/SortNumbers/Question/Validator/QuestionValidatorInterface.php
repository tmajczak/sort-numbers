<?php

namespace SortNumbers\Question\Validator;

interface QuestionValidatorInterface
{
    /**
     * @param mixed $value
     *
     * @throws \RuntimeException
     */
    public function validate($value): void;
}
