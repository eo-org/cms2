<?php
namespace Cms\Form\Element;

use Zend\Form\Element\Select;

class Brand extends Select
{
    public function loadValueOptions($attributesetId, $dm)
    {
    	$brandDocs = $dm->getRepository('Cms\Document\Product\Brand')->findByAttributesetId($attributesetId);
    	$valueOptions = array();
    	foreach($brandDocs as $bd) {
    		$valueOptions[$bd->getCode()] = $bd->getLabel();
    	}
    	$this->setValueOptions($valueOptions);
    	
    	return $valueOptions;
    }
}
