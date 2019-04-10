<?php

namespace Bforward\PickUpProductFromShop\Api\Data;

/**
 * Shop list Interface
 */
interface ShopListSearchResultInterface
//    extends \Magento\Framework\Api\SearchResultsInterface
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
