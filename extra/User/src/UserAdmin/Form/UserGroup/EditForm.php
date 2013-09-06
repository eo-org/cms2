<?php
namespace UserAdmin\Form\UserGroup;

use Zend\Form\Form;

class EditForm extends Form
{
    public function __construct()
    {
    	parent::__construct('user-group-edit');
    	
    	$this->add(array(
    		'name' => 'label',
    		'attributes' => array('type' => 'text'),
    		'options' => array(
    			'label' => '用户组名',
    			'description' => ''
    		)
    	));
//     	$this->add(array(
//     		'name' => 'previleges',
//     		'attributes' => array('type' => 'text'),
//     		'options' => array(
//     			'label' => '用户权限',
//     			'description' => '勾选用户能够访问的内容'
//     		)
//     	));
//     	$this->add(array(
//     		'name' => 'groupId',
//     		'type' => 'Zend\Form\Element\Select',
//     		'options' => array('label' => '产品分类')
//     	));
//     	$this->add(array(
//     		'name' => 'sku',
//     		'attributes' => array('type' => 'text'),
//     		'options' => array(
//     			'label' => '产品库存代码(SKU)',
//     			'description' => '产品的库存编码 - 可以不填'
//     		)
//     	));
//     	$this->add(array(
//     		'name' => 'fulltext',
//     		'attributes' => array(
//     			'type' => 'textarea',
//     			'class' => 'ckeditor',
//     		),
//     		'options' => array('label' => '产品说明')
//     	));
//     	$this->add(array(
//     		'name' => 'appendImage',
//     		'type' => 'Zend\Form\Element\Button',
//     		'attributes' => array(
//     			'class' => 'icon-selector',
//     			'data-callback' => 'appendToEditor'
//     		),
//     		'options' => array('label' => '插入图片')
//     	));
//     	$this->add(array(
//     		'name' => 'status',
//     		'attributes' => array('type' => 'hidden', 'value' => 'publish')
//     	));
//     	$this->add(array(
//     		'name' => 'price',
//     		'attributes' => array('type' => 'text'),
//     		'options' => array('label' => '产品单价')
//     	));
    	
//     	$this->add(array(
//     		'name' => 'introtext',
//     		'attributes' => array('type' => 'textarea'),
//     		'options' => array('label' => '产品摘要')
//     	));
//     	$this->add(array(
//     		'name' =>'metakey',
// 			'attributes' => array('type' => 'textarea'),
//     		'options' => array('label' => '产品关键词')
//         ));
//         $this->add(array(
//         	'name' => 'weight',
//         	'attributes' => array('type' => 'text', 'value' => 1),
//         	'options' => array('label' => '权重', 'description' => '-10000 ~ 10000, 数字越小排序越靠前'),
//         ));
//         $this->add(array(
//         	'name' => 'introicon',
//         	'attributes' => array('type' => 'hidden', 'id' => 'introicon')
//         ));
    }
    
//     public function getTabSettings()
//     {
//     	return array(
//     		array('handleLabel' => '基本信息', 'content' => array('label', 'name', 'groupId', 'sku', 'fulltext', 'appendImage', 'price', 'status')),
//     		array('handleLabel' => '选填信息', 'content' => array('introtext', 'metakey', 'weight', 'introicon'))
//     	);
//     }
}