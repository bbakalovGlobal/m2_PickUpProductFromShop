<?php

namespace Bforward\PickUpProductFromShop\Observer\Product;

use Bforward\PickUpProductFromShop\Api\ProductShopStockRepositoryInterface;
use Bforward\PickUpProductFromShop\Model\ResourceModel\ProductShopStock\CollectionFactory;
use Magento\Framework\Event\Observer;
use \Magento\Framework\Event\ObserverInterface;

class CatalogProductSaveAfterObserver implements ObserverInterface
{

    /**
     * @var \Bforward\PickUpProductFromShop\Model\ProductShopStockFactory
     */
    private $productShopStock;
    /**
     * @var \Bforward\PickUpProductFromShop\Api\ProductShopStockRepositoryInterface
     */
    private $productShopStockRepository;
    /**
     * @var \Bforward\PickUpProductFromShop\Model\ResourceModel\ProductShopStock\CollectionFactory
     */
    private $productShopStockCollectionFactory;

    public function __construct(
        \Bforward\PickUpProductFromShop\Model\ProductShopStockFactory $productShopStock,
        ProductShopStockRepositoryInterface $productShopStockRepository,
        CollectionFactory $productShopStockCollectionFactory
    ) {
        $this->productShopStock                  = $productShopStock;
        $this->productShopStockRepository        = $productShopStockRepository;
        $this->productShopStockCollectionFactory = $productShopStockCollectionFactory;
    }

    /**
     * Save chosen pickup shops and product qty there
     *
     * - event: catalog_product_save_after
     *
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $observer->getEvent()->getProduct();
        if (!$product) {
            return;
        }

        $productId      = $observer->getProduct()->getId();
        $pickupShopData = $product->getData('pickupshop_product_qty');

        try {
            if (\is_array($pickupShopData) && !empty($pickupShopData)) {
                foreach ($pickupShopData as $shopData) {
                    unset($shopData['record_id']);
                    //TODO: it's a little bit hardcode way, need to find best solution and implement it
                    $productShopStock = $this->productShopStockCollectionFactory
                        ->create()
                        ->addFieldToFilter('product_id', $productId)
                        ->addFieldToFilter('shop_id', $shopData['shop_id']);
                    if ($item = $productShopStock->getFirstItem()) {
                        //update product shop stock
                        $shopStock = $this->productShopStockRepository->getById($item->getId());
                        $shopStock->addData(['qty' => $shopData['qty']]);
                    } else {
                        //create new product shop stock
                        $shopStock              = $this->productShopStock->create();
                        $shopData['product_id'] = $productId;
                        $shopStock->setData($shopData);
                    }
                    $this->productShopStockRepository->save($shopStock);
                }
            }
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            die;
        }
    }
}
