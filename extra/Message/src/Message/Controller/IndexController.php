<?php
namespace Message\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Message\Document\Post;

class IndexController extends AbstractActionController
{
	public function index()
	{
		
	}
	
	public function createAction()
	{
		if($this->getRequest()->isPost()) {
			$postData = $this->getRequest()->getPost();
			$formId = $postData['formId'];
			$elementVals = $postData['elements'];
			
			$dm = $this->documentManager();
			$messageForm = $dm->getRepository('Message\Document\MessageForm')->findOneById($formId);
			if(is_null($messageForm)) {
				throw new \Exception('message form document not found with given id '.$formId);
			}
			
			$postContent = $messageForm->buildPostArr($elementVals);
			
			$postDoc = new Post();
			$postDoc->exchangeArray($postContent);
			
			$dm->persist($postDoc);
			$dm->flush();
			
			return $this->redirect()->toRoute('message');
		}
	}
}