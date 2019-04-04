<?php

namespace Bforward\PickUpProductFromShop\Controller\Adminhtml\ShopList;

use Bforward\PickUpProductFromShop\Api\ShopListRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Delete extends Action
{

    /**
     * @var \Bforward\PickUpProductFromShop\Model\ShopListRepository
     */
    private $shopListRepository;

    /**
     * Delete constructor.
     *
     * @param \Magento\Backend\App\Action\Context                      $context
     * @param ShopListRepositoryInterface $shopListRepository
     */
    public function __construct(
        Context $context,
        ShopListRepositoryInterface $shopListRepository
    ) {
        parent::__construct($context);
        $this->shopListRepository = $shopListRepository;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        if ($id === null) {
            $this->_redirect('*/*/index');

            return;
        }
        try {
            $this->shopListRepository->deleteById($id);
            $this->messageManager->addSuccessMessage(__('Row data has been successfully deleted.'));
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
