<?php

namespace Vidalitycs\Domain\Offer;

use Vidalitycs\Infrastructure\IOffersGateway;

/**
 * Class CatalogService
 * @package Vidalitycs\Domain\Offer
 */
class OffersService
{
    /**
     * @var IOffersGateway
     */
    private $offerGateway;

    /**
     * OffersService constructor.
     *
     * @param IOffersGateway $offersGateway
     */
    public function __construct(IOffersGateway $offersGateway)
    {
        $this->offerGateway = $offersGateway;
    }

    /**
     * @return Offer[]
     */
    public function getOffers(): array
    {
        $offers = [];
        $rawOffers = $this->offerGateway->getOffers();
        foreach ($rawOffers as $rawOffer) {
            $offer = new Offer(
                $rawOffer['source_product_code'],
                $rawOffer['product_quantity'],
                $rawOffer['target_product_code'],
                $rawOffer['target_product_quantity'],
                $rawOffer['discount_percentage']
            );

            $offers[$offer->getSourceProductCode()][$offer->getProductQuantity()] = $offer;
        }

        return $offers;
    }
}