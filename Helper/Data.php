<?php
namespace FPTCorp\Recommendation\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Data
{
    const XML_PATH_IS_ENABLED = 'fptcorp_recommendation/general/enabled';
    const XML_PATH_SITE_ID    = 'fptcorp_recommendation/general/site_id';
    const XML_PATH_APP_ID    = 'fptcorp_recommendation/general/app_id';
    /**
     * @var ScopeConfigInterface
     */
    private $config;

    public function __construct(
        ScopeConfigInterface $config
    ) {
        $this->config = $config;
    }

    public function isEnabled()
    {
        return $this->config->isSetFlag(self::XML_PATH_IS_ENABLED) && $this->getSiteId();
    }

    public function getSiteId()
    {
        return $this->config->getValue(self::XML_PATH_SITE_ID);
    }
    public function getAppId()
    {
        return $this->config->getValue(self::XML_PATH_APP_ID);
    }
}
