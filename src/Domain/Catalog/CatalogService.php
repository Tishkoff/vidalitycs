<?php

namespace Vidalitycs\Domain\Catalog;

use Vidalitycs\Infrastructure\ICatalogGateway;
use Vidalitycs\Utils\PriceConverter;

/**
 * Class CatalogService
 * @package Vidalitycs\Domain\Catalog
 */
class CatalogService
{
    /**
     * @var ICatalogGateway
     */
    private $catalogGateway;

    /**
     * CatalogService constructor.
     *
     * @param ICatalogGateway $catalogGateway
     */
    public function __construct(ICatalogGateway $catalogGateway)
    {
        $this->catalogGateway = $catalogGateway;
    }

    /**
     * @return CatalogItem[]
     */
    public function getCatalog(): array
    {
        $catalog = [];
        $rawCatalog = $this->catalogGateway->getCatalog();
        foreach ($rawCatalog as $rawCatalogItem) {
            $catalogItem = new CatalogItem(
                $rawCatalogItem['code'],
                $rawCatalogItem['name'],
                PriceConverter::toInt($rawCatalogItem['price'])
            );

            $catalog[$catalogItem->getCode()] = $catalogItem;
        }

        return $catalog;
    }
}