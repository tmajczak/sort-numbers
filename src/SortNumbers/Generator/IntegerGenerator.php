<?php

namespace SortNumbers\Generator;

class IntegerGenerator extends BaseNumberGeneratorInterface
{
    /**
     * @return float
     */
    public function generate(): float
    {
        return mt_rand($this->min, $this->max);
    }
}
