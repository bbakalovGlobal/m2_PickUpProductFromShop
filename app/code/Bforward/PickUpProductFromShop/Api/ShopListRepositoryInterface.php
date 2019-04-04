<?php

namespace Bforward\PickUpProductFromShop\Api;

use Bforward\PickUpProductFromShop\Api\Data\ShopListInterface;
use Bforward\PickUpProductFromShop\Model\ShopList;

/**
 * Interface SampleInterface
 *
 * @package Academy\Database\Api\Data
 */
interface ShopListRepositoryInterface
{

    /**
     * @param ShopListInterface $shopList
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
     * @return ShopList[]
     */
    public function getList() : array;

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