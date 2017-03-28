<?php
namespace FPTCorp\Recommendation\Controller\Ajax;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

class Listproduct extends Action
{
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Layout $layoutResult */
        $layoutResult =  $this->resultFactory->create(ResultFactory::TYPE_LAYOUT);
        $request = $this->getRequest();
        $layoutResult->addHandle(['empty', 'fptrecommendation_ajax']);
        $layoutResult->getLayout()
            ->getBlock('fptcorp.product.recommended')
            ->setType($request->getParam('type'))
            ->setKlSessionId($request->getParam('kl_session_id'))
            ->setProductIds($request->getParam('product_ids'));

        return $layoutResult;
    }
}
