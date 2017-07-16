<?php

namespace SortNumbers\Question\Factory;

use SortNumbers\Question\Question;

class QuestionFactory
{
    /**
     * @param string $question
     * @param null $default
     *
     * @return Question
     */
    public static function create(string $question, $default = null): Question
    {
        return new Question($question, $default);
    }
}
