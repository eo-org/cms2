<?php
namespace Ext\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Ext\FormController\Template\EditForm;
use Ext\Document\Template;

class TemplateController extends AbstractActionController
{
    public function indexAction()
    {
    	$brickId = $this->params()->fromRoute('brick-id');
        $extName = $this->params()->fromRoute('ext-name');
    	
    	$dm = $this->documentManager();
    	$tplList = $dm->getRepository('Ext\Document\Template')->findByExtName($extName);
    	
    	$this->actionTitle = "TPL文件管理";
    	$this->actionMenu = array('create-edit');
    	
    	return array(
    		'tplList' => $tplList,
    		'brickId' => $brickId,
    		'extName' => $extName
    	);
    }
    
    public function editAction()
    {
    	$brickId = $this->params()->fromRoute('brick-id');
    	$extName = $this->params()->fromRoute('ext-name');
    	$templateId = $this->params()->fromRoute('template-id');
    	
    	$templateDoc = new Template();
    	$dm = $this->documentManager();
    	if(!empty($templateId)) {
    		$templateDoc = $dm->getRepository('Ext\Document\Template')->findOneById($templateId);
    		if(is_null($templateDoc)) {
    			throw new \Exception('template not found!');
    		}
    		$extName = $templateDoc->getExtName();
    	}
    	
    	$extClassName = str_replace('_', '\\', $extName);
    	$solidBrick = new $extClassName();
    	$tplList = $solidBrick->getTplList();
    	
    	$form = new EditForm();
    	$form->setData($templateDoc->getArrayCopy());
    	if($this->getRequest()->isPost()) {
    		
    		$form->setInputFilter($templateDoc->getInputFilter());
    		$postData = $this->getRequest()->getPost();
        	$form->setData($postData);
        	if($form->isValid()) {
	        	$templateDoc->setFromArray($form->getData());
	        	$templateDoc->setExtName($extName);
	        	
	        	$dm->persist($templateDoc);
	        	$dm->flush();
	    		return $this->switchContext('brick', 'edit', array('id' => $brickId), true);
        	}
    	}
    	
    	
		$this->actionTitle = '编辑TPL文件:'.$extClassName;
		$this->actionMenu = array('save');
        
		return array(
			'brickId'		=> $brickId,
	    	'extName'		=> $extClassName,
			'tplList'		=> $tplList,
	    	'form'			=> $form,
	    );
    }
    
    public function getTplContentAction()
    {
    	$tplName = $this->params()->fromPost('tplName');
    	$fileLoader = \Ext\Twig\View::getFileLoader();
    	$tplContent = $fileLoader->getSource($tplName);
    	return array('tplContent' => $tplContent);
    }
    
    public function deleteAction()
    {
    	$brickId = $this->params()->fromRoute('id');
    	
    	$factory = $this->dbFactory();
    	$brick = $factory->_m('Brick')->find($brickId);
    	if(is_null($brick)) {
    		throw new Exception('brick not found');
    	}
    	
		$brick->delete();
    	return $this->switchContext('brick');
    }
}