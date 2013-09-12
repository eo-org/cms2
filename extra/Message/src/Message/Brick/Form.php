<?php
namespace Message\Brick;

use Ext\Brick\AbstractExtension;

class Form extends AbstractExtension
{	
	public function prepare()
	{
		$dm = $this->documentManager();
		$messageFormId = $this->getParam('messageFormId');
		
		$messageForm = $dm->getRepository('Message\Document\MessageForm')->find($messageFormId);
		
		$this->view->messageForm = $messageForm;
	}
	
	public function getTplList()
	{
		return array('view' => 'message-form/view.tpl');
	}
	
	public function getFormClass()
	{
		return 'Message\Brick\Form\Form';
	}
}