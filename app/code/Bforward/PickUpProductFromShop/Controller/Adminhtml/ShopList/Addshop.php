<?php

namespace Bforward\PickUpProductFromShop\Controller\Adminhtml\ShopList;

use Bforward\PickUpProductFromShop\Api\Data\ShopListInterfaceFactory;
use Bforward\PickUpProductFromShop\Api\ShopListRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;

class Addshop extends Action
{
    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @var \Bforward\PickUpProductFromShop\Model\ShopListFactory
     */
    private $shopListFactory;
    /**
     * @var \Bforward\PickUpProductFromShop\Api\ShopListRepositoryInterface
     */
    private $shopListRepository;
    /**
     * @var \Bforward\PickUpProductFromShop\Api\ProductShopStockRepositoryInterface
     */

    /**
     * Addshop constructor.
     *
     * @param \Magento\Backend\App\Action\Context                               $context
     * @param \Magento\Framework\Registry                                       $coreRegistry
     * @param \Bforward\PickUpProductFromShop\Api\Data\ShopListInterfaceFactory $shopListFactory
     * @param \Bforward\PickUpProductFromShop\Api\ShopListRepositoryInterface   $shopListRepository
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        ShopListInterfaceFactory $shopListFactory,
        ShopListRepositoryInterface $shopListRepository
    ) {
        parent::__construct($context);
        $this->coreRegistry       = $coreRegistry;
        $this->shopListFactory    = $shopListFactory;
        $this->shopListRepository = $shopListRepository;
    }

    /**
     * Mapped Grid List page.
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $shopId = (int) $this->getRequest()->getParam('id');
        $shopListModel = $this->shopListFactory->create();

        if ($shopId) {
            $shopListModel = $this->shopListRepository->getById($shopId);
            $shopName = $shopListModel->getName();
            if (!$shopListModel->getId()) {
                $this->messageManager->addError(__('Shop no longer exist.'));
                $this->_redirect('*/*/index');
                return;
            }
        }

        $this->coreRegistry->register('shop_list_model', $shopListModel);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title = $shopId ? __('Edit Shop ') . $shopName : __('Add New Shop');

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage->getConfig()->getTitle()->prepend($title);

        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Bforward_PickUpProductFromShop::shoplist_addshop');
    }
}
