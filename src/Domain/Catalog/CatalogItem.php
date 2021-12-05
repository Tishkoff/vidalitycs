<?php

namespace Vidalitycs\Domain\Catalog;

/**
 * Class CatalogItem
 * @package Vidalitycs\Domain\Catalog
 */
class CatalogItem
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $price;

    /**
     * CatalogItem constructor.
     *
     * @param string $code
     * @param string $name
     * @param int    $price
     */
    public function __construct(string $code, string $name, int $price)
    {
        $this->code = $code;
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }
}