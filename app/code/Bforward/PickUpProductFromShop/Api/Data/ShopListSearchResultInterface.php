<?php

namespace Bforward\PickUpProductFromShop\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Shop list Interface
 */
interface ShopListSearchResultInterface extends SearchResultsInterface
{

    /**
     * Gets collection items.
     *
     * @return \Bforward\PickUpProductFromShop\Api\Data\ShopListInterface[] Array of collection items.
     */
    public function getItems(): array;

    /**
     * Sets collection items.
     *
     * @param \Bforward\PickUpProductFromShop\Api\Data\ShopListInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
