<?php

namespace Vidalitycs\Domain\Basket;

use Vidalitycs\Domain\BasketItem\BasketItem;
use Vidalitycs\Domain\BasketItem\BasketOffer;
use Vidalitycs\Domain\DeliveryChargeRule\DeliveryChargeRule;
use Vidalitycs\Domain\Offer\Offer;

/**
 * Class Basket
 * @package Vidalitycs\Domain\Basket
 */
class Basket
{
    /**
     * @var BasketItem[]
     */
    private $items = [];

    /**
     * @var DeliveryChargeRule[]
     */
    private $allDeliveryChargeRules;

    /**
     * @var Offer[]
     */
    private $allOffers;

    /**
     * @var DeliveryChargeRule
     */
    private $deliveryChargeRule;

    /**
     * @var
     */
    private $totalItemsPrice;

    /**
     * @var
     */
    private $deliveryFee;

    /**
     * @var int
     */
    private $total;

    /**
     * Basket constructor.
     *
     * @param DeliveryChargeRule[] $allDeliveryChargeRules
     * @param Offer[]              $allOffers
     */
    public function __construct(array $allDeliveryChargeRules, array $allOffers)
    {
        $this->allDeliveryChargeRules = $allDeliveryChargeRules;
        $this->allOffers = $allOffers;
    }

    /**
     * @param BasketItem $item
     *
     * @return int
     */
    public function addItem(BasketItem $item): int
    {
        $this->addBasketItem($item)
            ->findMatchingOffers()
            ->recalculateDeliveryFee();

        return $this->getTotal();
    }

    /**
     * @return int
     */
    private function recalculateDeliveryFee(): int
    {
        $this->deliveryChargeRule = 0;
        $this->deliveryFee = null;

        foreach ($this->allDeliveryChargeRules as $validFromAmount => $deliveryChargeRule) {
            if ($this->totalItemsPrice >= $validFromAmount) {
                $this->deliveryChargeRule = $deliveryChargeRule;
                $this->deliveryFee = $deliveryChargeRule->getFee();

                break;
            }
        }

        $this->recalculateTotal();

        return $this->deliveryFee;
    }

    /**
     * @return int
     */
    private function recalculateTotal(): int
    {
        $this->total = $this->totalItemsPrice + $this->deliveryFee;

        return $this->total;
    }

    /**
     * @return $this
     */
    private function findMatchingOffers(): self
    {
        foreach ($this->items as $sourceBasketItemCode => $sourceBasketItem) {
            $itemOffers = $this->allOffers[$sourceBasketItemCode] ?? null;
            if ($itemOffers && count($itemOffers)) {
                krsort($itemOffers, SORT_NUMERIC);
                foreach ($itemOffers as $itemOfferQuantity => $itemOffer) {
                    /** @var Offer $itemOffer */
                    if ($sourceBasketItem->getQuantityOffersCanBeAppliedFor() >= $itemOfferQuantity) {
                        $targetBasketItem = $this->items[$itemOffer->getTargetProductCode()];
                        if ($targetBasketItem && $targetBasketItem->getQuantity() >= $itemOffer->getTargetProductQuantity()) {
                            $basketOffer = new BasketOffer($itemOffer);
                            $targetBasketItem->addOffer($basketOffer);

                            break;
                        }
                    }
                }
            }
        }

        $this->recalculateTotalItemsPrice();

        return $this;
    }

    /**
     * @return int
     */
    private function recalculateTotalItemsPrice(): int
    {
        $this->totalItemsPrice = 0;
        foreach ($this->items as $basketItem) {
            $this->totalItemsPrice += $basketItem->getTotalAmount();
        }

        $this->recalculateTotal();

        return $this->totalItemsPrice;
    }

    /**
     * @param BasketItem $item
     *
     * @return Basket
     */
    private function addBasketItem(BasketItem $item): self
    {
        if (array_key_exists($item->getCatalogItem()->getCode(), $this->items)) {
            $this->items[$item->getCatalogItem()->getCode()]->addQuantity();
        } else {
            $this->items[$item->getCatalogItem()->getCode()] = $item;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }
}