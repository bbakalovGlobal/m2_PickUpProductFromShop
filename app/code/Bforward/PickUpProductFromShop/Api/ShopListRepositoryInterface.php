<?php

namespace Bforward\PickUpProductFromShop\Api;

use Bforward\PickUpProductFromShop\Api\Data\ShopListInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface SampleInterface
 *
 * @package Academy\Database\Api\Data
 */
interface ShopListRepositoryInterface
{

    /**
     * @param \Bforward\PickUpProductFromShop\Api\Data\ShopListInterface $shopList
     *
     * @return mixed
     */
    public function save(ShopListInterface $shopList);

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function getById(int $id);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return \Bforward\PickUpProductFromShop\Api\Data\ShopListSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param \Bforward\PickUpProductFromShop\Api\Data\ShopListInterface $shopList
     *
     * @return bool true on success
     */
    public function delete(ShopListInterface $shopList);

    /**
     *
     * @param $shopId
     *
     * @return bool true on success
     */
    public function deleteById($shopId);
}