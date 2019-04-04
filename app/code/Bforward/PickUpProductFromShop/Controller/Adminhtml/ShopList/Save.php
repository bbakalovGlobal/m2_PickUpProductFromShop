<?php

namespace Bforward\PickUpProductFromShop\Controller\Adminhtml\ShopList;

use Bforward\PickUpProductFromShop\Api\Data\ShopListInterfaceFactory;
use Bforward\PickUpProductFromShop\Api\ShopListRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\AlreadyExistsException;

class Save extends Action
{

    /**
     * @var \Bforward\PickUpProductFromShop\Model\ShopListFactory
     */
    private $shopListFactory;
    /**
     * @var \Bforward\PickUpProductFromShop\Model\ShopListRepository
     */
    private $shopListRepository;

    /**
     * @param Context                     $context
     * @param ShopListInterfaceFactory    $shopListFactory
     * @param ShopListRepositoryInterface $shopListRepository
     */
    public function __construct(
        Context $context,
        ShopListInterfaceFactory $shopListFactory,
        ShopListRepositoryInterface $shopListRepository
    ) {
        parent::__construct($context);
        $this->shopListFactory    = $shopListFactory;
        $this->shopListRepository = $shopListRepository;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('*/*/addshop');

            return;
        }
        try {
            $shopListModel = $this->shopListFactory->create()->setData($data);
            $this->shopListRepository->save($shopListModel);
            $this->messageManager->addSuccessMessage(__('Row data has been successfully saved.'));
        } catch (AlreadyExistsException $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }
        $this->_redirect('*/*/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Bforward_PickUpProductFromShop::shoplist_save');
    }
}
