<?php

namespace Bforward\PickUpProductFromShop\Model;


use Bforward\PickUpProductFromShop\Api\Data\ShopListInterface;
use Bforward\PickUpProductFromShop\Api\ShopListRepositoryInterface;
use Bforward\PickUpProductFromShop\Model\ResourceModel\ShopList;
use Magento\Framework\Exception\AlreadyExistsException;
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

    protected $news;

    protected $objectManager;
    /**
     * @var ShopListFactory
     */
    private $shopList;
    /**
     * @var ShopList
     */
    private $shopListResource;

    public function __construct(
        ObjectManagerInterface $objectManager,
        ShopListFactory $shopList,
        ShopList $shopListResource
    ) {
        $this->objectManager    = $objectManager;
        $this->shopList         = $shopList;
        $this->shopListResource = $shopListResource;
    }

    /**
     * @param ShopListInterface $shop
     *
     * @return void
     *
     * @throws AlreadyExistsException
     * @throws \Exception
     */
    public function save(ShopListInterface $shop)
    {
        try {
            $this->shopListResource->save($shop);
        } catch (AlreadyExistsException $e) {
//            throw new AlreadyExistsException(new Phrase('Unique constraint violation found'), $e);
        } catch (\Exception $e) {
//            throw $e;
        }
    }

    /**
     * @return array
     */
    public function getList() : array
    {
        $list = [];
        foreach ($this->shopList->get()->getCollection() as $shop) {
            $list [$shop->getId()] = $shop;
        }

        return $list;
    }

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
}
