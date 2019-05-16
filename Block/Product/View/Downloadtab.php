<?php
/**
 * Copyright © Konatsu.pl Robert Rupa.
 */

namespace RobertRupa\DownloadTab\Block\Product\View;

use Magento\Catalog\Block\Product\View\AbstractView;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Product details block.
 */
class Downloadtab extends \Magento\Framework\View\Element\Template
{

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var AbstractView
     */
    protected $abstractView;

    /**
     * Downloadtab constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        AbstractView  $abstractView,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->abstractView = $abstractView;

        parent::__construct($context, $data);
    }

    /**
     * @return mixed
     * @throws LocalizedException
     */
    public function getProductSKU()
    {
        $sku = [];
        $product = $this->abstractView->getProduct();
        $sku[] = $product->getName();
        if (in_array($product->getTypeId(), ['configurable', 'grouped', 'bundle'])) {
            $_children = $product->getTypeInstance()->getUsedProducts($product);
            foreach ($_children as $child) {
                $sku[] = $child->getSKU();
            }
        }
        return json_encode($sku);
    }

    /**
     * @return string
     */
    public function getAdditionalStyles()
    {
        return $this->getConfig("download_tab/general/custom_styles");
    }

    /**
     * @return string
     */
    public function getApiEndpoint()
    {
        return $this->getConfig("download_tab/general/api_endpoint");
    }

    /**
     * @return string
     */
    public function getAdditionalGetParams()
    {
        return $this->getConfig("download_tab/general/additional_get_params");
    }

    /**
     * @param $config_path
     * @return string
     */
    private function getConfig($config_path)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
