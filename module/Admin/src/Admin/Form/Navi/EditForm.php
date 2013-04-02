<?php
namespace Admin\Form\Navi;

use Zend\Form\Form;

class EditForm extends Form
{
    public function __construct()
    {
    	parent::__construct('navi-edit');
    	
        $this->add(array(
    		'name' => 'label',
    		'attributes' => array('type' => 'text'),
    		'options' => array('label' => '目录组名')
    	));
    }

	public function getTabSettings()
    {
    	return array(array('handleLabel' => '基本信息', 'content' => array('label')));
    }
}