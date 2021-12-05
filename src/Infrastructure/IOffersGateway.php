<?php

namespace Vidalitycs\Infrastructure;

/**
 * Interface IOffersGateway
 * @package Vidalitycs\Infrastructure
 */
interface IOffersGateway
{
    /**
     * @return array
     */
    public function getOffers(): array;
}