<?php

namespace Vidalitycs\Utils;

/**
 * Class PriceConverter
 * @package Vidalitycs\Utils
 */
class PriceConverter
{
    /**
     * @param string $price
     *
     * @return int
     */
    public static function toInt(string $price): int
    {
        [$whole, $fraction] = explode('.', $price);

        return (int)$whole * 100 + (int)$fraction;
    }

    /**
     * @param int $price
     *
     * @return string
     */
    public static function toString(int $price): string
    {
        return (int)($price / 100) . '.' . substr(($price % 100) . '00', 0, 2);
    }
}