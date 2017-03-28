<?php
namespace FPTCorp\Recommendation\Block\ProductList;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class Wrapper extends \Magento\Framework\View\Element\Template
{
    /**
     * @var Registry
     */
    private $registry;
    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $checkoutSession;
    /**
     * @var \FPTCorp\Recommendation\Helper\Data
     */
    private $helper;

    public function __construct(
        Template\Context $context,
        Registry $registry,
        \Magento\Checkout\Model\Session $checkoutSession,
        \FPTCorp\Recommendation\Helper\Data $helper,
        array $data
    ) {
        parent::__construct($context, $data);
        $this->registry = $registry;
        $this->checkoutSession = $checkoutSession;
        $this->helper = $helper;
    }

    public function getAjaxUrl()
    {
        return $this->getUrl('fptrecommendation/ajax/listproduct');
    }

    /**
     * @return string List of product id separated by comma
     */
    public function getProductIds()
    {
        switch ($this->getType()) {
            case 'view':
                if ($product = $this->registry->registry('product')) {
                    return $product->getId();
                }
                break;
            case 'purchase':
                $items = $this->checkoutSession->getQuote()->getAllVisibleItems();
                $productIds = [];
                foreach ($items as $item) {
                    $productIds[] = $item->getProductId();
                }
                return implode(',', $productIds);
        }
        return '';
    }

    public function toHtml()
    {
        if ($this->helper->isEnabled()) {
            return parent::toHtml();
        }
        return '';
    }
}
