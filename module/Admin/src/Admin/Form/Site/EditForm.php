<?php
namespace Admin\Form\Site;

use Zend\Form\Form;

class EditForm extends Form
{
	public function __construct()
    {
    	parent::__construct('site-edit');
    	
    	$this->add(array(
    		'name' => 'language',
    		'type' => 'Zend\Form\Element\Select',
    		'options' => array(
    			'label' => '网站语言',
    			'value_options' => array(
    				'zh_CN' => '中文_简体',
    				'en_US' => 'English_US'
    			)
    		)
    	));
    	$this->add(array(
    		'name' => 'logo',
    		'attributes' => array(
    			'type' => 'text',
    			'class' => 'icon-selector',
    			'data-callback' => 'appendToInput'
    		),
    		'options' => array('label' => '网站LOGO')
    	));
    	$this->add(array(
    		'name' => 'pageTitle',
    		'attributes' => array('type' => 'textarea'),
    		'options' => array('label' => '网站标题')
    	));
    	$this->add(array(
    		'name' => 'metakey',
    		'attributes' => array('type' => 'textarea'),
    		'options' => array('label' => 'Keywords')
    	));
    	$this->add(array(
    		'name' => 'metadesc',
    		'attributes' => array('type' => 'textarea'),
    		'options' => array('label' => 'Description')
    	));
    	$this->add(array(
    		'name' => 'thumbWidth',
    		'attributes' => array('type' => 'text'),
    		'options' => array('label' => '缩略图宽度(px)')
    	));
    	$this->add(array(
    		'name' => 'thumbHeight',
    		'attributes' => array('type' => 'text'),
    		'options' => array('label' => '缩略图高度(px)')
    	));
    }
    
    public function getTabSettings()
    {
    	return array(
    		array('handleLabel' => '基本信息', 'content' => array('language', 'logo', 'pageTitle', 'metakey', 'metadesc')),
    		array('handleLabel' => '缩略图设置', 'content' => array('thumbWidth', 'thumbHeight')),
    	);
    }
}