<?php

namespace Bforward\PickUpProductFromShop\Api;

use Bforward\PickUpProductFromShop\Api\Data\ProductShopStockInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface SampleInterface
 * @package Academy\Database\Api\Data
 */
interface ProductShopStockRepositoryInterface
{
    /**
     * @param \Bforward\PickUpProductFromShop\Api\Data\ProductShopStockInterface $productShopStock
     *
     * @return mixed
     */
    public function save(ProductShopStockInterface $productShopStock);

    /**
     * @param int $id
     * @return mixed
     */
    public function getById(int $id);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return \Bforward\PickUpProductFromShop\Api\Data\ProductShopStockSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param \Bforward\PickUpProductFromShop\Api\Data\ProductShopStockInterface $productShopStock
     *
     * @return bool
     */
    public function delete(ProductShopStockInterface $productShopStock);

    /**
     *
     * @param $shopId
     *
     * @return bool
     */
    public function deleteById($shopId);
}