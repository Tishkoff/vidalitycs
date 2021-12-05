<?php

namespace Vidalitycs\Infrastructure;

/**
 * Interface IDeliveryChargeRulesGateway
 * @package Vidalitycs\Infrastructure
 */
interface IDeliveryChargeRulesGateway
{
    /**
     * @return array
     */
    public function getDeliveryChargeRules(): array;
}