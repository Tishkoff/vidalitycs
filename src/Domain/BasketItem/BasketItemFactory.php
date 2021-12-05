<?php

namespace Vidalitycs\Domain\BasketItem;

use Vidalitycs\Domain\Catalog\CatalogItem;
use Vidalitycs\Domain\Catalog\CatalogService;

/**
 * Class BasketItemFactory
 * @package Vidalitycs\Domain\BasketItem
 */
class BasketItemFactory
{
    /**
     * @var CatalogItem[]
     */
    private $catalog;

    /**
     * BasketItemFactory constructor.
     *
     * @param CatalogService $catalogService
     */
    public function __construct(CatalogService $catalogService)
    {
        $this->catalog = $catalogService->getCatalog();
    }

    /**
     * @param string $productCode
     * @param int    $quantity
     *
     * @return BasketItem
     */
    public function createBasketItem(string $productCode, int $quantity = 1): BasketItem
    {
        return new BasketItem(
            $this->catalog[$productCode],
            $quantity
        );
    }
}