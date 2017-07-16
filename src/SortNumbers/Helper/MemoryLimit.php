<?php

namespace SortNumbers\Helper;

class MemoryLimit
{
    /**
     * @return int
     */
    public static function getSizeInBytes(): int
    {
        $memoryLimit = ini_get('memory_limit');
        $memoryLimitString = $memoryLimit === '-1' ? '256MB' : $memoryLimit . 'B';

        return  DigitalInformationUnit::getSizeInBytesFromString($memoryLimitString);
    }
}
