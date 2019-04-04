<?php

namespace Bforward\PickUpProductFromShop\Model;

use Bforward\PickUpProductFromShop\Api\Data\ProductShopStockInterface;
use Bforward\PickUpProductFromShop\Model\ResourceModel\ProductShopStock as ProductShopStockResourceModel;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class ProductShopStock extends AbstractModel
    implements IdentityInterface, ProductShopStockInterface
{

    const CACHE_TAG = 'bforward_pickupproductfromshop_productshopstock';

    protected $_cacheTag = 'bforward_pickupproductfromshop_productshopstock';

    protected $_eventPrefix = 'bforward_pickupproductfromshop_productshopstock';

    protected function _construct()
    {
        $this->_init(ProductShopStockResourceModel::class);
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        return [];
    }
}