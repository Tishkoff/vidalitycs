<?php

namespace Vidalitycs\Domain\Offer;

/**
 * Class Offer
 * @package Vidalitycs\Domain\Offer
 */
class Offer
{
    /**
     * @var string
     */
    private $sourceProductCode;

    /**
     * @var int
     */
    private $productQuantity;

    /**
     * @var string
     */
    private $targetProductCode;

    /**
     * @var int
     */
    private $targetProductQuantity;

    /**
     * @var int
     */
    private $discountPercentage;

    /**
     * Offer constructor.
     *
     * @param string $sourceProductCode
     * @param int    $productQuantity
     * @param string $targetProductCode
     * @param int    $targetProductQuantity
     * @param int    $discountPercentage
     */
    public function __construct(
        string $sourceProductCode,
        int $productQuantity,
        string $targetProductCode,
        int $targetProductQuantity,
        int $discountPercentage
    )
    {
        $this->sourceProductCode = $sourceProductCode;
        $this->productQuantity = $productQuantity;
        $this->targetProductCode = $targetProductCode;
        $this->targetProductQuantity = $targetProductQuantity;
        $this->discountPercentage = $discountPercentage;
    }

    /**
     * @return string
     */
    public function getSourceProductCode(): string
    {
        return $this->sourceProductCode;
    }

    /**
     * @return int
     */
    public function getProductQuantity(): int
    {
        return $this->productQuantity;
    }

    /**
     * @return string
     */
    public function getTargetProductCode(): string
    {
        return $this->targetProductCode;
    }

    /**
     * @return int
     */
    public function getTargetProductQuantity(): int
    {
        return $this->targetProductQuantity;
    }

    /**
     * @return int
     */
    public function getDiscountPercentage(): int
    {
        return $this->discountPercentage;
    }

}