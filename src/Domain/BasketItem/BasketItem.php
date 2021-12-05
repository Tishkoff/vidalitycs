<?php

namespace Vidalitycs\Domain\BasketItem;

use Vidalitycs\Domain\Catalog\CatalogItem;

/**
 * Class BasketItem
 * @package Vidalitycs\Domain\BasketItem
 */
class BasketItem
{
    /**
     * @var CatalogItem
     */
    private $catalogItem;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var BasketOffer[]
     */
    private $offers = [];

    /**
     * @var int
     */
    private $amount;

    /**
     * @var int
     */
    private $offersDiscount;

    /**
     * @var int
     */
    private $quantityOffersCanBeAppliedFor;

    /**
     * @var int
     */
    private $totalAmount;

    /**
     * BasketItem constructor.
     *
     * @param CatalogItem $catalogItem
     * @param int         $quantity
     */
    public function __construct(CatalogItem $catalogItem, int $quantity)
    {
        $this->catalogItem = $catalogItem;
        $this->quantity = $quantity;

        $this->recalculateAmounts();
    }

    /**
     * @return int
     */
    public function getQuantityOffersCanBeAppliedFor(): int
    {
        return $this->quantityOffersCanBeAppliedFor;
    }

    /**
     * @return CatalogItem
     */
    public function getCatalogItem(): CatalogItem
    {
        return $this->catalogItem;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $increment
     *
     * @return BasketItem
     */
    public function addQuantity(int $increment = 1): BasketItem
    {
        $this->quantity += $increment;

        $this->recalculateAmounts();

        return $this;
    }

    /**
     * @param int $decrement
     *
     * @return BasketItem
     */
    public function substractQuantity(int $decrement = 1): BasketItem
    {
        $this->quantity -= $decrement;

        if ($this->quantity < 0) {
            $this->quantity = 0;
        }

        $this->recalculateAmounts();

        return $this;
    }

    /**
     * @param BasketOffer $offer
     *
     * @return BasketItem
     */
    public function addOffer(BasketOffer $offer): BasketItem
    {
        $this->offers[] = $offer;
        $this->recalculateAmounts();

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getOffersDiscount(): int
    {
        return $this->offersDiscount;
    }

    /**
     * @return int
     */
    public function getTotalAmount(): int
    {
        return $this->totalAmount;
    }

    /**
     * Recalculate amounts.
     */
    private function recalculateAmounts(): void
    {
        $this->amount = $this->getCatalogItem()->getPrice() * $this->getQuantity();
        $this->quantityOffersCanBeAppliedFor = $this->quantity;

        $this->offersDiscount = 0;
        foreach ($this->offers as $basketOffer) {
            $discount = (int)ceil($this->getCatalogItem()->getPrice()
                * $basketOffer->getOffer()->getTargetProductQuantity()
                * $basketOffer->getOffer()->getDiscountPercentage()
                / 100
            );

            $basketOffer->setDiscountApplied($discount);
            $this->offersDiscount += $discount;
            $this->quantityOffersCanBeAppliedFor -= $basketOffer->getOffer()->getTargetProductQuantity();
        }

        if ($this->quantityOffersCanBeAppliedFor < 0) {
            $this->quantityOffersCanBeAppliedFor = 0;
        }

        $this->totalAmount = $this->amount - $this->offersDiscount;
        if ($this->totalAmount < 0) {
            $this->totalAmount = 0;
        }
    }
}