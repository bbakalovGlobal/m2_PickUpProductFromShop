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
     * @param ProductShopStock $productShopStock
     * @return mixed
     */
    public function save(ProductShopStock $productShopStock);

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id);

    /**
     * @return ProductShopStock[]
     */
    public function getList(): array;

    /**
     * @param ProductShopStockInterface $shopList
     *
     * @return bool true on success
     */
    public function delete(ProductShopStockInterface $shopList);

    /**
     *
     * @param $shopId
     *
     * @return bool true on success
     */
    public function deleteById($shopId);
}