<?php
namespace Admin\Form\Product;

use Zend\Form\Form;

class EditForm extends Form
{
	public $tabSettings = array(
		array('label', 'name', 'groupId', 'sku', 'fulltext', 'appendImage', 'price', 'status', 'attributes'),
		array('introtext', 'metakey', 'sort', 'introicon')
	);
	
	public $attributesFieldset;
	
    public function __construct()
    {
    	parent::__construct('product-edit');
    	
    	$this->attributesFieldset = new \Zend\Form\Fieldset('attributes');
    	
    	$this->add(array(
    		'name' => 'label',
    		'attributes' => array('type' => 'text'),
    		'options' => array(
    			'label' => '产品名',
    			'description' => '产品的中文名或英文名，方便客户的记忆和购买'
    		)
    	));
    	$this->add(array(
    		'name' => 'name',
    		'attributes' => array('type' => 'text'),
    		'options' => array(
    			'label' => '产品型号',
    			'description' => '产品的唯一编码，方便工作人员进行对应的查找'
    		)
    	));
    	$this->add(array(
    		'name' => 'groupId',
    		'type' => 'Zend\Form\Element\Select',
    		'options' => array('label' => '产品分类')
    	));
    	$this->add(array(
    		'name' => 'sku',
    		'attributes' => array('type' => 'text'),
    		'options' => array(
    			'label' => '产品库存代码(SKU)',
    			'description' => '产品的库存编码 - 可以不填'
    		)
    	));
    	$this->add(array(
    		'name' => 'fulltext',
    		'attributes' => array(
    			'type' => 'textarea',
    			'class' => 'ckeditor',
    		),
    		'options' => array('label' => '产品说明')
    	));
    	$this->add(array(
    		'name' => 'appendImage',
    		'type' => 'Zend\Form\Element\Button',
    		'attributes' => array(
    			'class' => 'icon-selector',
    			'data-callback' => 'appendToEditor'
    		),
    		'options' => array('label' => '插入图片')
    	));
    	$this->add(array(
    		'name' => 'status',
    		'attributes' => array('type' => 'hidden')
    	));
    	$this->add($this->attributesFieldset);
    	
    	/*page two*/
    	$this->add(array(
    		'name' => 'price',
    		'attributes' => array('type' => 'text'),
    		'options' => array('label' => '产品单价')
    	));
    	
    	$this->add(array(
    		'name' => 'introtext',
    		'attributes' => array('type' => 'textarea'),
    		'options' => array('label' => '产品摘要')
    	));
    	$this->add(array(
    		'name' =>'metakey',
			'attributes' => array('type' => 'textarea'),
    		'options' => array('label' => '产品关键词')
        ));
        $this->add(array(
        	'name' => 'sort',
        	'attributes' => array('type' => 'text', 'value' => 1),
        	'options' => array('label' => '权重', 'description' => '-10000 ~ 10000, 数字越小排序越靠前'),
        ));
        $this->add(array(
        	'name' => 'introicon',
        	'attributes' => array('type' => 'hidden', 'id' => 'introicon')
        ));
    }
    
    public function addTabElement($tabIdx, $elementName)
    {
    	array_push($this->tabSettings[$tabIdx], $elementName);
    }
    
    public function getTabSettings()
    {
    	return array(
    		array('handleLabel' => '基本信息', 'content' => $this->tabSettings[0]),
    		array('handleLabel' => '选填信息', 'content' => $this->tabSettings[1])
    	);
    }
}