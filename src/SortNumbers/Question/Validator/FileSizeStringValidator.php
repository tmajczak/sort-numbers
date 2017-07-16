<?php

namespace SortNumbers\Question\Validator;

class FileSizeStringValidator implements QuestionValidatorInterface
{
    /**
     * @param mixed $value
     *
     * @throws \RuntimeException
     */
    public function validate($value): void
    {
        preg_match('/^(\d+)(KB|MB|GB)$/i', $value, $matches);

        if (!isset($matches[1]) || !isset($matches[2])) {
            throw new \RuntimeException('File size should be in format [value][KB|MB|GB].');
        }
    }
}
