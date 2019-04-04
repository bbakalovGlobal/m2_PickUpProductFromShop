<?php

namespace Bforward\PickUpProductFromShop\Controller\Adminhtml\ShopList;

use Bforward\PickUpProductFromShop\Api\ShopListRepositoryInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Bforward\PickUpProductFromShop\Model\ResourceModel\ShopList\CollectionFactory;

class MassDelete extends \Magento\Backend\App\Action
{

    /**
     * Massactions filter.​
     *
     * @var Filter
     */
    protected $_filter;

    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;
    /**
     * @var \Bforward\PickUpProductFromShop\Api\ShopListRepositoryInterface
     */
    private $shopListRepository;

    /**
     * @param Context                                                         $context
     * @param Filter                                                          $filter
     * @param CollectionFactory                                               $collectionFactory
     * @param \Bforward\PickUpProductFromShop\Api\ShopListRepositoryInterface $shopListRepository
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ShopListRepositoryInterface $shopListRepository
    ) {

        $this->_filter            = $filter;
        $this->_collectionFactory = $collectionFactory;
        $this->shopListRepository = $shopListRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        $shopListCollection = $this->_filter->getCollection($this->_collectionFactory->create());
        $recordDeleted      = 0;
        /**
         * @var $shop \Bforward\PickUpProductFromShop\Model\ShopList
         */
        foreach ($shopListCollection->getItems() as $shop) {
            $this->shopListRepository->delete($shop);
            $recordDeleted++;
        }
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $recordDeleted));

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/*/index');
    }

    /**
     * Check Category Map recode delete Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Bforward_PickUpProductFromShop::sholist_mass_delete');
    }
}
