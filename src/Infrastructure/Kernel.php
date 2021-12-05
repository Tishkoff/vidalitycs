<?php

namespace Vidalitycs\Infrastructure;

use Vidalitycs\Application\BasketApplicationService;
use Vidalitycs\Domain\Basket\BasketFactory;
use Vidalitycs\Domain\BasketItem\BasketItemFactory;
use Vidalitycs\Domain\Catalog\CatalogService;
use Vidalitycs\Domain\DeliveryChargeRule\DeliveryChargeRulesService;
use Vidalitycs\Domain\Offer\OffersService;

/**
 * Class Kernel
 * @package Vidalitycs\Infrastructure
 */
class Kernel
{
    /**
     * @var BasketApplicationService
     */
    private $application;

    /**
     * Kernel constructor.
     * @param ICatalogGateway             $catalogGateway
     * @param IOffersGateway              $offersGateway
     * @param IDeliveryChargeRulesGateway $deliveryChargeRulesGateway
     */
    public function __construct(
        ICatalogGateway $catalogGateway,
        IOffersGateway $offersGateway,
        IDeliveryChargeRulesGateway $deliveryChargeRulesGateway
    )
    {
        $catalogService = new CatalogService($catalogGateway);
        $offersService = new OffersService($offersGateway);
        $deliveryChargeRulesService = new DeliveryChargeRulesService($deliveryChargeRulesGateway);

        $basketFactory = new BasketFactory($offersService, $deliveryChargeRulesService);
        $basketItemFactory = new BasketItemFactory($catalogService);

        $this->application = new BasketApplicationService($basketFactory, $basketItemFactory);
    }

    /**
     * @return BasketApplicationService
     */
    public function getApplication(): BasketApplicationService
    {
        return $this->application;
    }
}