<?php

namespace SortNumbers\Generator;

abstract class BaseNumberGeneratorInterface implements NumberGeneratorInterface
{
    /**
     * @var int
     */
    protected $min;

    /**
     * @var int
     */
    protected $max;

    /**
     * @param int $value
     *
     * @return NumberGeneratorInterface
     */
    public function setMin(int $value): NumberGeneratorInterface
    {
        $this->min = $value;

        return $this;
    }

    /**
     * @param int $value
     *
     * @return NumberGeneratorInterface
     */
    public function setMax(int $value): NumberGeneratorInterface
    {
        $this->max = $value;

        return $this;
    }

    /**
     * @return float
     */
    abstract public function generate(): float;
}
