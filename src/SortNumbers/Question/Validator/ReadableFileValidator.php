<?php

namespace SortNumbers\Question\Validator;

class ReadableFileValidator implements QuestionValidatorInterface
{
    /**
     * @param mixed $value
     *
     * @throws \RuntimeException
     */
    public function validate($value): void
    {
        if (!file_exists($value)) {
            throw new \RuntimeException('File not exists.');
        }

        if (!is_readable($value)) {
            throw new \RuntimeException('File is not readable.');
        }
    }
}
