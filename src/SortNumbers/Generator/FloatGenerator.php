<?php

namespace SortNumbers\Generator;

class FloatGenerator extends BaseNumberGeneratorInterface
{
    /**
     * @var int
     */
    private $decimals;

    /**
     * @param int $decimals
     */
    public function __construct(int $decimals)
    {
        $this->decimals = $decimals;
    }

    /**
     * @return float
     */
    public function generate(): float
    {
        return round($this->min + lcg_value() * ($this->max - $this->min), $this->decimals);
    }
}
