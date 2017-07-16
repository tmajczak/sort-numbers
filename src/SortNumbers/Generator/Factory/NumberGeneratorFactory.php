<?php

namespace SortNumbers\Generator\Factory;

use SortNumbers\Generator\FloatGenerator;
use SortNumbers\Generator\IntegerGenerator;
use SortNumbers\Generator\NumberGeneratorInterface;

class NumberGeneratorFactory
{
    /**
     * @param int $decimals
     *
     * @return NumberGeneratorInterface
     */
    public static function create(int $decimals): NumberGeneratorInterface
    {
        if ($decimals > 0) {
            return new FloatGenerator($decimals);
        }

        return new IntegerGenerator($decimals);
    }
}
