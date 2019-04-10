<?php

namespace Bforward\PickUpProductFromShop\Model;


use Bforward\PickUpProductFromShop\Api\Data\ProductShopStockInterface;
use Bforward\PickUpProductFromShop\Api\Data\ProductShopStockSearchResultInterface;
use Bforward\PickUpProductFromShop\Api\Data\ProductShopStockSearchResultInterfaceFactory;
use Bforward\PickUpProductFromShop\Api\ProductShopStockRepositoryInterface;
use Bforward\PickUpProductFromShop\Model\ResourceModel\ProductShopStock;
use Bforward\PickUpProductFromShop\Model\ResourceModel\ProductShopStock\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
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
     * @var CollectionFactory
     */
    private $productShopStockCollectionFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var ProductShopStockSearchResultInterface
     */
    private $searchResultInterfaceFactory;
    /**
     * @var \Bforward\PickUpProductFromShop\Model\ResourceModel\ProductShopStock
     */
    private $productShopStockResource;

    /**
     * ProductShopStockRepository constructor.
     *
     * @param \Magento\Framework\ObjectManagerInterface                                              $objectManager
     * @param \Bforward\PickUpProductFromShop\Model\ProductShopStockFactory                          $productShopStock
     * @param \Bforward\PickUpProductFromShop\Model\ResourceModel\ProductShopStock\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface                     $collectionProcessor
     * @param \Bforward\PickUpProductFromShop\Api\Data\ProductShopStockSearchResultInterfaceFactory  $searchResultInterfaceFactory
     * @param \Bforward\PickUpProductFromShop\Model\ResourceModel\ProductShopStock                   $productShopStockResource
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        ProductShopStockFactory $productShopStock,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        ProductShopStockSearchResultInterfaceFactory $searchResultInterfaceFactory,
        ProductShopStock $productShopStockResource
    ) {
        $this->objectManager    = $objectManager;
        $this->productShopStock = $productShopStock;
        $this->productShopStockCollectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultInterfaceFactory = $searchResultInterfaceFactory;
        $this->productShopStockResource = $productShopStockResource;
    }


    /**
     * @param \Bforward\PickUpProductFromShop\Api\Data\ProductShopStockInterface $shop
     *
     * @return mixed|void
     */
    public function save(ProductShopStockInterface $shop)
    {
        try {
            $this->productShopStockResource->save($shop);
        } catch (\Exception $e) {
            //            throw $e;
        }
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return \Bforward\PickUpProductFromShop\Api\Data\ProductShopStockSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->productShopStockCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultInterfaceFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @param int $shopId
     *
     * @return \Bforward\PickUpProductFromShop\Model\ProductShopStock
     */
    public function getById(int $shopId)
    {
        $productShopStockModel = $this->productShopStock->create();
        $this->productShopStockResource->load($productShopStockModel, $shopId);

        return $productShopStockModel;
    }

    /**
     * @param \Bforward\PickUpProductFromShop\Api\Data\ProductShopStockInterface $productShopStock
     *
     * @return bool|void
     * @throws \Exception
     */
    public function delete(ProductShopStockInterface $productShopStock)
    {
        $this->productShopStockResource->delete($productShopStock);
    }

    /**
     * @param $shopId
     *
     * @return bool|void
     * @throws \Exception
     */
    public function deleteById($shopId)
    {
        $this->delete($this->getById($shopId));
    }
}
