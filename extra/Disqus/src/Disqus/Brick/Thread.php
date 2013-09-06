<?php
namespace Disqus\Brick;

use Ext\AbstractExt;

class Thread extends AbstractExt
{
	protected $_effectFiles = array(
		'common/underscore.1.3.1.min.js',
		'disqus/thread/plugin.js',
	);
	
	public function prepare()
	{
		$sm = $this->_controller->getServiceLocator();
		
		$layout = $sm->get('Fucms\LayoutFront');
		$context = $layout->getContext();
		
		$this->view->topic = $context->getTitle();
		$this->view->resourceId = $context->getResourceId();
	}
	
	public function getTplList()
	{
		return array('view' => 'thread/view.tpl');
	}
}