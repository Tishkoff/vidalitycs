<?php

namespace Vidalitycs\Application;

use Vidalitycs\Domain\Basket\BasketFactory;
use Vidalitycs\Domain\BasketItem\BasketItemFactory;
use Vidalitycs\Utils\PriceConverter;

/**
 * Class BasketApplicationService
 * @package Vidalitycs\Application
 */
class BasketApplicationService
{
    /**
     * @var BasketFactory
     */
    private $basketFactory;

    /**
     * @var BasketItemFactory
     */
    private $basketItemFactory;

    /**
     * BasketApplicationService constructor.
     *
     * @param BasketFactory     $basketFactory
     * @param BasketItemFactory $basketItemFactory
     */
    public function __construct(BasketFactory $basketFactory, BasketItemFactory $basketItemFactory)
    {
        $this->basketFactory = $basketFactory;
        $this->basketItemFactory = $basketItemFactory;
    }

    /**
     * @param string[] $productCodes
     *
     * @return string
     */
    public function addItemsToBasket(array $productCodes): string
    {
        $basket = $this->basketFactory->createBasket();
        foreach ($productCodes as $productCode) {
            $basketItem = $this->basketItemFactory->createBasketItem($productCode);
            $basket->addItem($basketItem);
        }

        return PriceConverter::toString($basket->getTotal());
    }
}