<?php

namespace Vidalitycs\Domain\BasketItem;

use Vidalitycs\Domain\Offer\Offer;

/**
 * Class BasketOffer
 * @package Vidalitycs\Domain\BasketItem
 */
class BasketOffer
{
    /**
     * @var Offer
     */
    private $offer;

    /**
     * @var int
     */
    private $discountApplied;

    /**
     * BasketOffer constructor.
     *
     * @param Offer $offer
     */
    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    /**
     * @return Offer
     */
    public function getOffer(): Offer
    {
        return $this->offer;
    }

    /**
     * @return int
     */
    public function getDiscountApplied(): int
    {
        return $this->discountApplied;
    }

    /**
     * @param int $discountApplied
     */
    public function setDiscountApplied(int $discountApplied): void
    {
        $this->discountApplied = $discountApplied;
    }
}