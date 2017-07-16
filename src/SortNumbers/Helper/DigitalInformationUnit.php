<?php

namespace SortNumbers\Helper;

class DigitalInformationUnit
{
    /**
     * @param string $string
     *
     * @return int
     */
    public static function getSizeInBytesFromString(string $string): int
    {
        $sizeType = strtoupper(substr($string, -2));
        $methodName = sprintf('calculate%s', $sizeType);

        return call_user_func([__CLASS__, $methodName], $string);
    }

    /**
     * @param string $string
     *
     * @return int
     */
    public static function calculateKB(string $string): int
    {
        $bytes = substr($string, 0, -2);

        return (int)$bytes * 1024;
    }

    /**
     * @param string $string
     *
     * @return int
     */
    public static function calculateMB(string $string): int
    {
        return self::calculateKB($string) * 1024;
    }

    /**
     * @param string $string
     *
     * @return int
     */
    public static function calculateGB(string $string): int
    {
        return self::calculateMB($string) * 1204;
    }
}
