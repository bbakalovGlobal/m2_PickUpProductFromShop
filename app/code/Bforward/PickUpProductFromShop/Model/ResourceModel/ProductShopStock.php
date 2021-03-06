<?php

namespace Bforward\PickUpProductFromShop\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\Context;

class ProductShopStock extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('product_shop_stock', 'id');
    }
}
