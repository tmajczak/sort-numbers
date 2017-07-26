<?php

namespace SortNumbers\Generator;

class FloatGenerator extends BaseNumberGenerator
{
    /**
     * @var int
     */
    private $decimals;

    /**
     * @var int
     */
    private $maxSubMin;

    /**
     * @param int $decimals
     */
    public function __construct(int $decimals)
    {
        $this->decimals = $decimals;
        $this->maxSubMin = $this->max - $this->min;
    }

    /**
     * @return float
     */
    public function generate(): float
    {
        return round($this->min + lcg_value() * $this->maxSubMin, $this->decimals);
    }
}
