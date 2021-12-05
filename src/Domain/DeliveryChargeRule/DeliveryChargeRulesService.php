<?php

namespace Vidalitycs\Domain\DeliveryChargeRule;

use Vidalitycs\Infrastructure\IDeliveryChargeRulesGateway;
use Vidalitycs\Utils\PriceConverter;

/**
 * Class CatalogService
 * @package Vidalitycs\Domain\Catalog
 */
class DeliveryChargeRulesService
{
    /**
     * @var IDeliveryChargeRulesGateway
     */
    private $deliveryChargeRulesGateway;

    /**
     * DeliveryChargeRulesService constructor.
     *
     * @param IDeliveryChargeRulesGateway $deliveryChargeRulesGateway
     */
    public function __construct(IDeliveryChargeRulesGateway $deliveryChargeRulesGateway)
    {
        $this->deliveryChargeRulesGateway = $deliveryChargeRulesGateway;
    }

    /**
     * @return DeliveryChargeRule[]
     */
    public function getDeliveryChargeRules(): array
    {
        $rules = [];
        $rawRules = $this->deliveryChargeRulesGateway->getDeliveryChargeRules();
        foreach ($rawRules as $rawRule) {
            $deliveryChargeRule = new DeliveryChargeRule(
                PriceConverter::toInt($rawRule['valid_from_amount']),
                PriceConverter::toInt($rawRule['fee'])
            );

            $rules[$deliveryChargeRule->getValidFromAmount()] = $deliveryChargeRule;
        }
        krsort($rules, SORT_NUMERIC);

        return $rules;
    }
}