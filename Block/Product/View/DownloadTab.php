<?php
/**
 * Copyright © Konatsu.pl Robert Rupa.
 */

namespace RobertRupa\DownloadTab\Block\Product\View;

use Magento\Catalog\Block\Product\View\AbstractView;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Catalog\Model\Product;

/**
 * Product details block.
 */
class DownloadTab extends \Magento\Framework\View\Element\Template
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
     * @var AbstractView
     */
    protected $product;

    /**
     * DownloadTab constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        AbstractView  $abstractView,
        Product  $product,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->abstractView = $abstractView;
        $this->product = $product;

        parent::__construct($context, $data);
    }

    /**
     * @return mixed
     * @throws LocalizedException
     */
    public function getUniqueID()
    {
        $uniqueID = [];
        $product = $this->abstractView->getProduct();
        if (in_array($product->getTypeId(), ['configurable'])) {
            $_children = $product->getTypeInstance()->getUsedProducts($product);
            foreach ($_children as $child) {
                $child = $this->product->load($child->getEntityId());
                $uniqueID[] = $child->getResource()->getAttribute($this->getUniqueIDAttribute())->getFrontend()->getValue($child);
            }
        }
        else if (in_array($product->getTypeId(), ['grouped'])) {
            $_children = $product->getTypeInstance()->getAssociatedProducts($product);
            foreach ($_children as $child) {
                $child = $this->product->load($child->getEntityId());
                $uniqueID[] = $child->getResource()->getAttribute($this->getUniqueIDAttribute())->getFrontend()->getValue($child);
            }
        }
        else if (in_array($product->getTypeId(), ['bundle'])) {
            $_children = $product->getTypeInstance()->getChildrenIds($product->getEntityID());
            foreach ($_children as $child) {
                $child = $this->product->load($child);
                $uniqueID[] = $child->getResource()->getAttribute($this->getUniqueIDAttribute())->getFrontend()->getValue($child);
            }
        }
        else{
            $uniqueID[] = $product->getData($this->getUniqueIDAttribute());            
        }
        return json_encode($uniqueID);
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
     * @return string
     */
    public function getUniqueIDAttribute()
    {
        return $this->getConfig("download_tab/general/attribute");
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
