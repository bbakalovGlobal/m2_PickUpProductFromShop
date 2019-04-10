<?php

namespace Bforward\PickUpProductFromShop\Model\Source;

use Bforward\PickUpProductFromShop\Api\ShopListRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class PickupShopList implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var \Bforward\PickUpProductFromShop\Api\ShopListRepositoryInterface
     */
    private $shopListRepository;

    /**
     * PickupShopList constructor.
     *
     * @param \Bforward\PickUpProductFromShop\Api\ShopListRepositoryInterface $shopListRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder                    $searchCriteriaBuilder
     */
    public function __construct(
        ShopListRepositoryInterface $shopListRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->shopListRepository = $shopListRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $searchCriteria = $this->searchCriteriaBuilder->addFilter(
            'is_active', true, 'eq'
        )->create();
        $shopList       = $this->shopListRepository->getList($searchCriteria);
        $shops          = [];
        foreach ($shopList->getItems() as $shop) {
            $shops[] = [
                'label' => $shop->getName(),
                'value' => $shop->getId(),
            ];
        }

        return $shops;
    }
}
