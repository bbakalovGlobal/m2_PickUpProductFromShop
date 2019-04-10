<?php

namespace Bforward\PickUpProductFromShop\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Shop list Interface
 */
interface ProductShopStockSearchResultInterface extends SearchResultsInterface
{

    /**
     * Gets collection items.
     *
     * @return \Bforward\PickUpProductFromShop\Api\Data\ProductShopStockInterface[] Array of collection items.
     */
    public function getItems(): array;

    /**
     * Sets collection items.
     *
     * @param \Bforward\PickUpProductFromShop\Api\Data\ProductShopStockInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
