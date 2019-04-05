<?php

namespace Bforward\PickUpProductFromShop\Api;

use Bforward\PickUpProductFromShop\Api\Data\ProductShopStockInterface;
use Bforward\PickUpProductFromShop\Model\ProductShopStock;

/**
 * Interface SampleInterface
 * @package Academy\Database\Api\Data
 */
interface ProductShopStockRepositoryInterface
{
    /**
     * @param \Bforward\PickUpProductFromShop\Model\ProductShopStock $productShopStock
     * @return mixed
     */
    public function save(ProductShopStock $productShopStock);

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id);

    /**
     * @return \Bforward\PickUpProductFromShop\Model\ProductShopStock[]
     */
    public function getList(): array;

    /**
     * @param \Bforward\PickUpProductFromShop\Api\Data\ProductShopStockInterface $shopList
     *
     * @return bool
     */
    public function delete(ProductShopStockInterface $shopList);

    /**
     *
     * @param $shopId
     *
     * @return bool
     */
    public function deleteById($shopId);
}