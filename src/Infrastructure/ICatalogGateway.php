<?php

namespace Vidalitycs\Infrastructure;

/**
 * Interface ICatalogGateway
 * @package Vidalitycs\Infrastructure
 */
interface ICatalogGateway
{
    /**
     * @return array
     */
    public function getCatalog(): array;
}