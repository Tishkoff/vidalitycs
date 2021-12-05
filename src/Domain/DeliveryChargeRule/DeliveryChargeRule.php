<?php

namespace Vidalitycs\Domain\DeliveryChargeRule;

/**
 * Class DeliveryChargeRule
 * @package Vidalitycs\Domain\DeliveryChargeRule
 */
class DeliveryChargeRule
{
    /**
     * @var int
     */
    private $validFromAmount;

    /**
     * @var int
     */
    private $fee;

    /**
     * DeliveryChargeRule constructor.
     *
     * @param int $validFromAmount
     * @param int $fee
     */
    public function __construct(int $validFromAmount, int $fee)
    {
        $this->validFromAmount = $validFromAmount;
        $this->fee = $fee;
    }

    /**
     * @return int
     */
    public function getValidFromAmount(): int
    {
        return $this->validFromAmount;
    }

    /**
     * @return int
     */
    public function getFee(): int
    {
        return $this->fee;
    }
}