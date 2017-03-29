<?php
namespace FPTCorp\Recommendation\Block\ProductList;

class Recommended extends \Magento\Catalog\Block\Product\ProductList\Related
{
    const API_URL = 'http://api.knowlead.io/';

    const LIMIT = 10;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var \Magento\Framework\HTTP\ZendClientFactory
     */
    private $httpClientFactory;
    /**
     * @var \FPTCorp\Recommendation\Helper\Data
     */
    private $helper;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Checkout\Model\ResourceModel\Cart $checkoutCart,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Module\Manager $moduleManager,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory,
        \FPTCorp\Recommendation\Helper\Data $helper,
        \Psr\Log\LoggerInterface $logger,
        array $data
    ) {
        parent::__construct(
            $context,
            $checkoutCart,
            $catalogProductVisibility,
            $checkoutSession,
            $moduleManager,
            $data
        );
        $this->collectionFactory = $collectionFactory;
        $this->httpClientFactory = $httpClientFactory;
        $this->helper = $helper;
        $this->logger = $logger;
    }

    protected function _prepareData()
    {
        $productIds = $this->getRecommendedProductIds();
        if (!$productIds) {
            return $this;
        }
        $this->_itemCollection = $this->collectionFactory->create()->addIdFilter($productIds)->addStoreFilter();

        if ($this->moduleManager->isEnabled('Magento_Checkout')) {
            $this->_addProductAttributesAndPrices($this->_itemCollection);
        }
        $this->_itemCollection->setVisibility($this->_catalogProductVisibility->getVisibleInCatalogIds());

        $this->_itemCollection->load();

        foreach ($this->_itemCollection as $product) {
            $product->setDoNotUseCategoryId(true);
        }

        return $this;
    }

    protected function getRecommendedProductIds()
    {
        /** @var \Magento\Framework\HTTP\ZendClient $client */
        $client = $this->httpClientFactory->create();
        $client->setUri(self::API_URL . $this->getKlSessionId())
            ->setMethod(\Zend_Http_Client::GET)
            ->setParameterGet([
                'logType' => $this->getType(),
                'limit' => self::LIMIT,
                'productIds' => $this->getProductIds(),
                'apiKey' => $this->helper->getAPIkey(),
                'siteId' => $this->helper->getSiteId()
            ]);

        $productIds = [];

        try {
            $response = $client->request();
            if ($response->getStatus() == 200) {
                $result = json_decode($response->getBody(), true);

                if (!empty($result['message'])) {
                    $messages = json_decode($result['message'], true);
                    if (is_array($messages)) {
                        foreach ($messages as $product) {
                            $productIds[] = $product['productId'];
                        }
                    }
                }
            }
        } catch (\Zend_Http_Client_Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return $productIds;
    }
    public function getProductUrl($product, $additional = [])
    {
        if (strpos(parent::getProductUrl($product, $additional), '?') !== false) {
            return parent::getProductUrl($product, $additional)."&_utm=recommendation";
        } else {
            return parent::getProductUrl($product, $additional) . "?_utm=recommendation";
        }
    }
}
