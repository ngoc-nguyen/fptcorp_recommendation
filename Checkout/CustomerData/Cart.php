<?php
namespace FPTCorp\Recommendation\Checkout\CustomerData;

class Cart extends \Magento\Checkout\CustomerData\Cart
{
    public function getSectionData()
    {
        $result = parent::getSectionData();
        $result['cart_id'] = $this->getQuote()->getId();
        return $result;
    }
}
