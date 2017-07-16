<?php

namespace SortNumbers\Generator;

interface NumberGeneratorInterface
{
    /**
     * @param int $value
     *
     * @return NumberGeneratorInterface
     */
    public function setMin(int $value): NumberGeneratorInterface;

    /**
     * @param int $value
     *
     * @return NumberGeneratorInterface
     */
    public function setMax(int $value): NumberGeneratorInterface;

    /**
     * @return float
     */
    public function generate(): float;
}
