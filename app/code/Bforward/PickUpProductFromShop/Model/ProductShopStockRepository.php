<?php

namespace Bforward\PickUpProductFromShop\Model;


use Bforward\PickUpProductFromShop\Api\Data\ProductShopStockInterface;
use Bforward\PickUpProductFromShop\Api\ProductShopStockRepositoryInterface;
use Magento\Framework\ObjectManagerInterface;

class ProductShopStockRepository implements ProductShopStockRepositoryInterface
{

    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var ProductShopStockFactory
     */
    private $productShopStock;

    /**
     * ProductShopStockRepository constructor.
     *
     * @param ObjectManagerInterface $objectManager
     * @param ProductShopStockFactory       $productShopStock
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ProductShopStockFactory $productShopStock
    ) {
        $this->objectManager    = $objectManager;
        $this->productShopStock = $productShopStock;
    }


    /**
     * @param ProductShopStock $shop
     *
     * @return $this|mixed
     * @throws \Exception
     */
    public function save(ProductShopStock $shop)
    {
        return $shop->save();
    }

    /**
     * @return array
     */
    public function getList() : array
    {
        $list = [];
        foreach ($this->productShopStock->create()->getCollection() as $shop) {
            $list [$shop->getId()] = $shop;
        }

        return $list;
    }

    /**
     * @param int $id
     *
     * @return ProductShopStock
     */
    public function getById(int $id)
    {
        return $this->productShopStock->create()->load($id);
    }

    /**
     * @param ProductShopStockInterface $shopList
     *
     * @return bool true on success
     */
    public function delete(ProductShopStockInterface $shopList)
    {
        // TODO: Implement delete() method.
    }

    /**
     *
     * @param $shopId
     *
     * @return bool true on success
     */
    public function deleteById($shopId)
    {
        // TODO: Implement deleteById() method.
    }
}
