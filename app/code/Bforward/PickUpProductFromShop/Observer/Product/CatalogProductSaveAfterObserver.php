<?php

namespace Bforward\PickUpProductFromShop\Observer\Product;

use Bforward\PickUpProductFromShop\Api\ProductShopStockRepositoryInterface;
use Bforward\PickUpProductFromShop\Model\ProductShopStockFactory;
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

    public function __construct(
        ProductShopStockFactory $productShopStock,
        ProductShopStockRepositoryInterface $productShopStockRepository
    ) {
        $this->productShopStock           = $productShopStock;
        $this->productShopStockRepository = $productShopStockRepository;
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
            //Delete all products shop stock
            $this->productShopStockRepository->deleteByProductId($productId);
            if (\is_array($pickupShopData) && !empty($pickupShopData)) {
                foreach ($pickupShopData as $shopData) {
                    //TODO: think to preventing same duplicate shops
                    $shopStock = $this->productShopStock->create();
                    $shopStock->setData([
                        'product_id' => $productId,
                        'qty'        => $shopData['qty'],
                        'shop_id'    => $shopData['shop_id'],
                    ]);
                    $this->productShopStockRepository->save($shopStock);
                }
            }
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            die;
        }
    }
}
