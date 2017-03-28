<?php
namespace FPTCorp\Recommendation\Block\Checkout;

use Magento\Framework\View\Element\Template;

class Js extends \Magento\Framework\View\Element\Template
{
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
        \Magento\Checkout\Model\Session $checkoutSession,
        \FPTCorp\Recommendation\Helper\Data $helper,
        array $data
    ) {
        parent::__construct($context, $data);
        $this->checkoutSession = $checkoutSession;
        $this->helper = $helper;
    }

    public function getPurchaseJs()
    {
        $quote = $this->checkoutSession->getQuote();
        $items = [];

        foreach ($quote->getAllVisibleItems() as $item) {
            $items[] = "{$item->getProductId()}:{$item->getQty()}";
        }

        return json_encode([
            'CartID' => $quote->getId(),
            'items' => implode(',', $items)
        ]);
    }

    public function toHtml()
    {
        if ($this->helper->isEnabled()) {
            return parent::toHtml();
        }
        return '';
    }
}
