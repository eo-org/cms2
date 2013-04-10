<?php
namespace Ext\Brick\Player;

use Ext\Brick\AbstractExt;

class VideoPlayer extends AbstractExt
{
	protected $_effectFiles = array(
		'player/plugin.js',
		'player/jplayer.blue.monday.css'
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
    		'view' => 'player\videoplayer\view.tpl'
    	);
    }
}