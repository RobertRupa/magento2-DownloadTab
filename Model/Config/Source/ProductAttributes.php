<?php
/**
 * Copyright © Konatsu.pl Robert Rupa.
 */

namespace RobertRupa\DownloadTab\Model\Config\Source;

use \Magento\Framework\Option\ArrayInterface;
use \Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection as AttributeCollection;
use \Magento\Eav\Model\Entity\Attribute\Set;

class ProductAttributes implements ArrayInterface
{
  /** @var AttributeCollection */
  private $attributeCollection;
  
  /**
   * __construct
   *
   * @param  mixed $attributeCollection
   *
   * @return void
   */
  public function __construct(AttributeCollection $attributeCollection)
  {
    $this->attributeCollection = $attributeCollection;
  }

  /**
   * toOptionArray
   *
   * @return array
   */
  public function toOptionArray()
  {
    $attributes = [];
    $productAttributes = $this->getProductAttributes();
    foreach($productAttributes as $attribute){
      $attributes[] = ['value' => $attribute->getAttributeCode(), 'label' => __($attribute->getDefaultFrontendLabel())];
    }
    return $attributes;
  }

  /**
   * getProductAttributes
   *
   * @return \Magento\Eav\Model\ResourceModel\Entity\Attribute\Collection
   */
  private function getProductAttributes(){
    $collectionAttributes = $this->attributeCollection->addFieldToFilter(Set::KEY_ENTITY_TYPE_ID, 4);
    $productAttributes = $collectionAttributes->load()->getItems();
    return $productAttributes;
  }

}
