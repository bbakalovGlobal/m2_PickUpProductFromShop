<?php

namespace Bforward\PickUpProductFromShop\Plugin\Catalog\Ui\DataProvider\Product\Form;


use Bforward\PickUpProductFromShop\Api\ProductShopStockRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Registry;

class ProductDataProvider
{

    /**
     * @var \Bforward\PickUpProductFromShop\Api\ProductShopStockRepositoryInterface
     */
    private $productShopStockRepository;
    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;
    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    public function __construct(
        ProductShopStockRepositoryInterface $productShopStockRepository,
        Registry $registry,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->productShopStockRepository = $productShopStockRepository;
        $this->registry                   = $registry;
        $this->searchCriteriaBuilder      = $searchCriteriaBuilder;
    }

    public function afterGetData(\Magento\Catalog\Ui\DataProvider\Product\Form\ProductDataProvider $subject, $result)
    {
        //TODO: check what need to be used instead of registry
        $productRegistry = $this->registry->registry('current_product');
        if ($productRegistry) {
            $productId      = $productRegistry->getId();
            $searchCriteria = $this->searchCriteriaBuilder->addFilter(
                'product_id', $productId, 'eq'
            )->create();
            foreach ($this->productShopStockRepository->getList($searchCriteria)->getItems() as $item) {
                $result[$productId]['product']['pickupshop_product_qty'][] = $item->getData();
            }
        }

        return $result;
    }
}
