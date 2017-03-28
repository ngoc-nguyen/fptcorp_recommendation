<?php
namespace FPTCorp\Recommendation\Block;

use FPTCorp\Recommendation\Helper\Data;
use Magento\Framework\View\Element\Template;

class Js extends Template
{
    /**
     * @var Data
     */
    private $helper;
    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    public function __construct(
        Template\Context $context,
        Data $helper,
        \Magento\Framework\Registry $registry,
        array $data
    ) {
        parent::__construct($context, $data);
        $this->helper = $helper;
        $this->registry = $registry;
    }

    public function getProductId()
    {
        $product = $this->registry->registry('current_product');
        return $product ? $product->getId() : '';
    }

    public function getSiteId()
    {
        return $this->helper->getSiteId();
    }

    public function toHtml()
    {
        if ($this->helper->isEnabled()) {
            return parent::toHtml();
        }
        return '';
    }
    public function getAppId()
    {
        return $this->helper->getAppId();
    }
}
