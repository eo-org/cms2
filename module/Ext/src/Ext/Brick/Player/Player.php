<?php
namespace Ext\Brick\Player;

use Ext\Brick\AbstractExt;

class Player extends AbstractExt
{
	protected $_effectFiles = array(
		'player/plugin.js',
	);
	
    public function prepare()
    {
    	$fileurl = $this->getParam('fileurl');
    	$this->view->fileurl = $fileurl;
    }
    
	public function getFormClass()
    {
    	return 'Ext\Form\Player\Player';
    }
    
    public function getTplList()
    {
    	return array(
    		'view' => 'player\player\view.tpl'
    	);
    }
}