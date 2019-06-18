<?php

namespace Bforward\PickUpProductFromShop\Model;


use Bforward\PickUpProductFromShop\Api\Data\ShopListInterface;
use Bforward\PickUpProductFromShop\Api\Data\ShopListSearchResultInterfaceFactory;
use Bforward\PickUpProductFromShop\Api\ShopListRepositoryInterface;
use Bforward\PickUpProductFromShop\Model\ResourceModel\ShopList;
use Bforward\PickUpProductFromShop\Model\ResourceModel\ShopList\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\ObjectManagerInterface;

class ShopListRepository implements ShopListRepositoryInterface
{

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var ShopListFactory
     */
    private $shopList;
    /**
     * @var ShopList
     */
    private $shopListResource;

    /**
     * @var \Bforward\PickUpProductFromShop\Model\ResourceModel\ShopList\CollectionFactory
     */
    private $shopListCollectionFactory;
    /**
     * @var \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var \Bforward\PickUpProductFromShop\Api\Data\ShopListSearchResultInterfaceFactory
     */
    private $searchResultInterfaceFactory;

    /**
     * ShopListRepository constructor.
     *
     * @param \Bforward\PickUpProductFromShop\Model\ShopListFactory                          $shopList
     * @param \Bforward\PickUpProductFromShop\Model\ResourceModel\ShopList                   $shopListResource
     * @param \Bforward\PickUpProductFromShop\Model\ResourceModel\ShopList\CollectionFactory $shopListCollectionFactory
     * @param \Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface             $collectionProcessor
     * @param \Bforward\PickUpProductFromShop\Api\Data\ShopListSearchResultInterfaceFactory  $searchResultInterfaceFactory
     */
    public function __construct(
        ShopListFactory $shopList,
        ShopList $shopListResource,
        CollectionFactory $shopListCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        ShopListSearchResultInterfaceFactory $searchResultInterfaceFactory
    ) {
        $this->shopList                     = $shopList;
        $this->shopListResource             = $shopListResource;
        $this->shopListCollectionFactory    = $shopListCollectionFactory;
        $this->collectionProcessor          = $collectionProcessor;
        $this->searchResultInterfaceFactory = $searchResultInterfaceFactory;
    }

    /**
     * @param ShopListInterface $shop
     *
     * @return void
     *
     * @throws \Exception
     */
    public function save(ShopListInterface $shop)
    {
        try {
            $this->shopListResource->save($shop);
        } catch (\Exception $e) {
//            throw $e;
        }
    }

//    /**
//     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
//     *
//     * @return \Bforward\PickUpProductFromShop\Api\Data\ShopListSearchResultInterface
//     */
//    public function getList(SearchCriteriaInterface $searchCriteria)
//    {
//        $collection = $this->shopListCollectionFactory->create();
//        $this->collectionProcessor->process($searchCriteria, $collection);
//
//        $searchResults = $this->searchResultInterfaceFactory->create();
//        $searchResults->setSearchCriteria($searchCriteria);
//        $searchResults->setItems($collection->getItems());
//        $searchResults->setTotalCount($collection->getSize());
//
//        return $searchResults;
//    }

    /**
     * @param int $shopId
     *
     * @return \Bforward\PickUpProductFromShop\Model\ShopList
     */
    public function getById(int $shopId)
    {
        $shopListModel = $this->shopList->create();
        $this->shopListResource->load($shopListModel, $shopId);

        return $shopListModel;
    }


    /**
     * @param ShopListInterface $shopList
     *
     * @return void
     *
     * @throws \Exception
     */
    public function delete(ShopListInterface $shopList)
    {
        $this->shopListResource->delete($shopList);
    }

    /**
     *
     * @param $shopId
     *
     * @return bool true on success
     * @throws \Exception
     */
    public function deleteById($shopId)
    {
        $this->delete($this->getById($shopId));
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->shopListCollectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    private function addFiltersToCollection(
        SearchCriteriaInterface $searchCriteria,
        \Bforward\PickUpProductFromShop\Model\ResourceModel\ShopList\Collection $collection
    ) {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    private function addSortOrdersToCollection(
        SearchCriteriaInterface $searchCriteria,
        \Bforward\PickUpProductFromShop\Model\ResourceModel\ShopList\Collection $collection
    ) {
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() === SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    private function addPagingToCollection(
        SearchCriteriaInterface $searchCriteria,
        \Bforward\PickUpProductFromShop\Model\ResourceModel\ShopList\Collection $collection
    ) {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    private function buildSearchResult(
        SearchCriteriaInterface $searchCriteria,
        \Bforward\PickUpProductFromShop\Model\ResourceModel\ShopList\Collection $collection
    ) {
        $searchResults = $this->searchResultInterfaceFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
