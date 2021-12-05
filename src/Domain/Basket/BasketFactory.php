<?php

namespace Vidalitycs\Domain\Basket;

use Vidalitycs\Domain\DeliveryChargeRule\DeliveryChargeRule;
use Vidalitycs\Domain\DeliveryChargeRule\DeliveryChargeRulesService;
use Vidalitycs\Domain\Offer\Offer;
use Vidalitycs\Domain\Offer\OffersService;

/**
 * Class BasketFactory
 * @package Vidalitycs\Domain\Basket
 */
class BasketFactory
{
    /**
     * @var DeliveryChargeRule[]
     */
    private $deliveryChargeRules;

    /**
     * @var Offer[]
     */
    private $offers;

    /**
     * BasketFactory constructor.
     * @param OffersService              $offersService
     * @param DeliveryChargeRulesService $deliveryChargeRulesService
     */
    public function __construct(
        OffersService $offersService,
        DeliveryChargeRulesService $deliveryChargeRulesService
    )
    {
        $this->offers = $offersService->getOffers();
        $this->deliveryChargeRules = $deliveryChargeRulesService->getDeliveryChargeRules();
    }

    /**
     * @return Basket
     */
    public function createBasket(): Basket
    {
        return new Basket($this->deliveryChargeRules, $this->offers);
    }
}