<?php

namespace Bforward\PickUpProductFromShop\Model;

use Bforward\PickUpProductFromShop\Api\Data\ShopListInterface;
use Magento\Framework\Model\AbstractModel;

class ShopList extends AbstractModel implements \Magento\Framework\DataObject\IdentityInterface, ShopListInterface
{

    const CACHE_TAG = 'bforward_pickupproductfromshop_shoplist';

    protected $_cacheTag = 'bforward_pickupproductfromshop_shoplist';

    protected $_eventPrefix = 'bforward_pickupproductfromshop_shoplist';

    protected function _construct()
    {
        $this->_init('Bforward\PickUpProductFromShop\Model\ResourceModel\ShopList');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        return [];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getData('name');
    }
}