<?php

namespace SortNumbers\Question\Validator;

class FilePathValidator implements QuestionValidatorInterface
{
    /**
     * @var bool
     */
    private $canExists;

    /**
     * @param bool $canExists
     */
    public function __construct(bool $canExists = true)
    {
        $this->canExists = $canExists;
    }

    /**
     * @param mixed $value
     *
     * @throws \RuntimeException
     */
    public function validate($value): void
    {
        preg_match('/^(\/[\w\/]+\/)([\w\.]+)$/', $value, $matches);

        if (!isset($matches[1]) || !isset($matches[2]) || !is_writeable($matches[1])) {
            throw new \RuntimeException('File should be absolute path to writable file.');
        }

        if (!$this->canExists && file_exists($value)) {
            throw new \RuntimeException('File already exists.');
        }
    }
}
