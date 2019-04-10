<?php

namespace Bforward\PickUpProductFromShop\Model\ResourceModel\ShopList;

use Bforward\PickUpProductFromShop\Api\Data\ShopListSearchResultInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
    implements ShopListSearchResultInterface
{

    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'bforward_pickupproductfromshop_shoplist_collection';
    protected $_eventObject = 'shoplist_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Bforward\PickUpProductFromShop\Model\ShopList::class,
            \Bforward\PickUpProductFromShop\Model\ResourceModel\ShopList::class);
    }

    /**
     * Sets collection items.
     *
     * @param \Bforward\PickUpProductFromShop\Api\Data\ShopListInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items = null)
    {
        if (!$items) {
            return $this;
        }
        foreach ($items as $item) {
            $this->addItem($item);
        }
        return $this;
    }

    /**
     * @return \Bforward\PickUpProductFromShop\Api\Data\ShopListInterface[] $items
     */
    public function getItems() : array
    {
        $this->load();
        return $this->_items;
    }
}

