<?php
namespace Admin\Form\Product\Brand;

use Zend\Form\Form;

class EditForm extends Form
{
	public $tabSettings = array(
		array('code', 'label', 'logo'),
		array('fulltext', 'introtext', 'category')
	);
	
    public function __construct()
    {
    	parent::__construct('product-brand-edit');
    	
    	$this->add(array(
    		'name' => 'code',
    		'attributes' => array('type' => 'text'),
    		'options' => array(
    			'label' => '商标/品牌编码',
    			'description' => '商标/品牌的英文编码，内部使用，一旦建立不要更改'
    		)
    	));
    	
    	$this->add(array(
    		'name' => 'label',
    		'attributes' => array('type' => 'text'),
    		'options' => array(
    			'label' => '商标/品牌名',
    			'description' => '商标/品牌的中文名或英文名，方便客户的记忆和购买'
    		)
    	));
    	$this->add(array(
    		'name' => 'logo',
    		'attributes' => array('type' => 'text'),
    		'options' => array(
    			'label' => 'LOGO'
    		),
    		'attributes' => array(
    			'class' => 'icon-selector',
    			'data-callback' => 'appendToInput'
    		),
    	));
    	$this->add(array(
    		'name' => 'fulltext',
    		'attributes' => array(
    			'type' => 'textarea',
    			'class' => 'ckeditor',
    		),
    		'options' => array('label' => '详细说明')
    	));
    	$this->add(array(
    		'name' => 'introtext',
    		'attributes' => array('type' => 'textarea'),
    		'options' => array('label' => '摘要说明')
    	));
        $this->add(array(
        	'name' => 'category',
    		'type' => 'Zend\Form\Element\Select',
        	'options' => array(
        		'label' => '归类',
        		'value_options' => array(
        			'num' => '0 ~ 9',
        			'a' => 'A',
        			'b' => 'B',
        			'c' => 'C',
        			'd' => 'D',
        			'e' => 'E',
        			'f' => 'F',
        			'g' => 'G',
        			'h' => 'H',
        			'i' => 'I',
        			'j' => 'J',
        			'k' => 'K',
        			'l' => 'L',
        			'm' => 'M',
        			'n' => 'N',
        			'o' => 'O',
        			'p' => 'P',
        			'q' => 'Q',
        			'r' => 'R',
        			's' => 'S',
        			't' => 'T',
        			'u' => 'U',
        			'v' => 'V',
        			'w' => 'W',
        			'x' => 'X',
        			'y' => 'Y',
        			'z' => 'Z',
        			'other' => 'OTHER'
        		)
        	),
        ));
    }
    
    public function getTabSettings()
    {
    	return array(
    		array('handleLabel' => '基本信息', 'content' => $this->tabSettings[0]),
    		array('handleLabel' => '选填信息', 'content' => $this->tabSettings[1])
    	);
    }
}