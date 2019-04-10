<?php

namespace Bforward\PickUpProductFromShop\Model;

use Bforward\PickUpProductFromShop\Api\ShopListManagementInterface;
use Bforward\PickUpProductFromShop\Api\ShopListRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class ShopListManagement implements ShopListManagementInterface
{

    /**
     * @var \Bforward\PickUpProductFromShop\Model\ShopListFactory
     */
    private $shopList;
    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var \Bforward\PickUpProductFromShop\Api\ShopListRepositoryInterface
     */
    private $shopListRepository;

    /**
     * ShopListManagement constructor.
     *
     * @param \Bforward\PickUpProductFromShop\Model\ShopListFactory           $shopList
     * @param \Bforward\PickUpProductFromShop\Api\ShopListRepositoryInterface $shopListRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder                    $searchCriteriaBuilder
     */
    public function __construct(
        ShopListFactory $shopList,
        ShopListRepositoryInterface $shopListRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->shopList              = $shopList;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->shopListRepository    = $shopListRepository;
    }

    /**
     * @return \Bforward\PickUpProductFromShop\Api\Data\ShopListInterface[]
     */
    public function fetchShops()
    {
        $searchCriteria = $this->searchCriteriaBuilder->addFilter(
            'is_active', true, 'eq'
        )->create();

        return $this->shopListRepository->getList($searchCriteria)->getItems();
    }
}