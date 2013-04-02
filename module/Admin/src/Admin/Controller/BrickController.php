<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Form\Brick\EditForm;
use Admin\Form\Brick\EditTplForm;

class BrickController extends AbstractActionController
{
    protected $_pageSize = 20;
    
    public function indexAction()
    {
        $this->brickConfig()->setActionMenu(array())
			->setActionTitle('模块管理');
    }
    
    public function createAction()
    {
    	$layoutId = $this->params()->fromRoute('layoutId');
    	$stageId = $this->params()->fromRoute('stageId');
    	$spriteName = $this->params()->fromRoute('spriteName');
    	
    	if(empty($layoutId) || is_null($stageId) || empty($spriteName)) {
    		throw new Exception('url error');
    	}
    	
    	$config = $this->getServiceLocator()->get('Config');
    	$brickConfig = $config['brick'];
    	
// 		$centerDbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
// 		$tb = new \Zend\Db\TableGateway\TableGateway('extension_group', $centerDbAdapter);
// 		$rowset = $tb->select();
	    
		$this->brickConfig()->setActionMenu(array())
			->setActionTitle('选择模块类型');
		
		return array(
			'layoutId'		=> $layoutId,
			'stageId'		=> $stageId,
			'spriteName'	=> $spriteName,
			'rowset'		=> array(),
			'brickConfig'	=> $brickConfig
		);
    }
    
    public function listGroupAction()
    {
    	$layoutId = $this->params()->fromRoute('layoutId');
    	$stageId = $this->params()->fromRoute('stageId');
    	$spriteName = $this->params()->fromRoute('spriteName');
    	$groupName = $this->params()->fromRoute('groupName');
    	
    	if(empty($layoutId) || is_null($stageId) || empty($spriteName) || empty($groupName)) {
    		throw new Exception('url error');
    	}
	    
    	$config = $this->getServiceLocator()->get('Config');
    	$brickConfig = $config['brick'];
    	$groupConfig = array();
    	if(isset($brickConfig[$groupName])) {
    		$groupConfig = $brickConfig[$groupName]['ext'];
    	}
    	
// 	    $centerDbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
// 		$tb = new \Zend\Db\TableGateway\TableGateway('extension_v2', $centerDbAdapter);
//     	$rowset = $tb->selectWith($tb->getSql()->select()
//     		->where(array('deprecated' => 0))
//     		->where(array('groupName' => $groupName))
//     		->order('sort'));
    	
    	$this->brickConfig()->setActionMenu(array())
			->setActionTitle($groupName);
		return array(
			'layoutId'		=> $layoutId,
	    	'stageId'		=> $stageId,
	    	'spriteName'	=> $spriteName,
	    	'rowset'		=> array(),
			'groupConfig'	=> $groupConfig
    	);
    }
    
    public function editAction()
    {
    	$brickId = $this->params()->fromRoute('id');
    	$extName = $this->params()->fromRoute('extName');
    	
    	$factory = $this->dbFactory();
    	$co = $factory->_m('Brick');
    	if(empty($brickId)) {
    		$brick = $co->create();
    		$brick->extName = $this->params()->fromRoute('extName');
    	} else {
    		$brick = $co->find($brickId);
    		$extName = $brick->extName;
    	}
    	$solidBrick = $brick->createSolid($this);
    	$tplArr = $solidBrick->getTplArray();
    	$dm = $this->documentManager();
    	$templateDocs = $dm->getRepository('Ext\Document\Template')->findByExtName($extName);
    	$userTplArr = array();
    	foreach($templateDocs as $t) {
    		$userTplArr[$t->getId()] = $t->getScriptName();
    	}
    	$tplArr[1]['options'] = $userTplArr;
    	$form = new EditForm();
    	$form = $solidBrick->configParam($form);
    	$form->get('tplName')->setValueOptions($tplArr);
    	
    	$form->setData($this->params()->fromRoute());
    	$form->setData($brick->toArray());
    	if($this->getRequest()->isPost()) {
    		$postData = $this->getRequest()->getPost();
        	$form->setData($postData);
        	
        	if($form->isValid()) {
	    		$brick->setFromArray($form->getData());
	    		if($brick->stageId == '0') {
	    			$brick->layoutId = '0';
	    		}
	    		
	    		$brick->active = 1;
				$brick->save();
			    $brickId = $brick->brickId;
	            return $this->switchContext('brick');
    		}
    		
    	}
    	
    	if(empty($brickId)) {
	        $this->brickConfig()->setActionTitle('编辑模块:'.$brick->extName)
	        	->setActionMenu(array('save'));
    	} else {
    		$this->brickConfig()->setActionTitle('编辑模块:'.$brick->extName)
	    		->setActionMenu(array('save', 'delete', 'edit-tpl' => array(
	    			'callback' => '/admin/extadmin-template.ajax/index/ext-name/'.$brick->extName.'/brick-id/'.$brickId,
	    			'label' => '管理TPL文件'
	    		)));
    	}
        
    	return array(
    		'form' => $form,
    	);
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
    
//     public function listTplAction()
//     {
//     	$extName = $this->params()->fromRoute('ext-name');
    	
//     	$dm = $this->documentManager();
//     	$tplList = $dm->getRepository('Ext\Document\Template')->findByExtName($extName);
    	
//     	$this->actionTitle = "TPL文件管理";
//     	$this->actionMenu = array('create');
    	
//     	return array(
//     		'tplList' => $tplList
//     	);
//     }
    
//     public function editTplAction()
//     {
//     	$brickId = $this->params()->fromRoute('brick-id');
//     	$tplName = $this->params()->fromRoute('tpl-name');
    	
//     	$factory = $this->dbFactory();
//     	$brick = $factory->_m('Brick')->find($brickId);
//     	if(is_null($brick)) {
//     		throw new Exception('Brick not found by id :'.$brickId);
//     	}
//     	$solidBrick = $brick->createSolid($this);
//     	$tplArr = $solidBrick->getTplArray();
    	
//     	$extName = substr($brick->extName, 6);
//     	$fileFolder = $solidBrick->twigPath();
    	
//     	$form = new EditTplForm();
//     	if(!empty($tplName)) {
//     		$filePath = $fileFolder.'/'.$tplName;
// 			$fh = fopen($filePath, 'r');
// 			$tplFileData = fread($fh, filesize($filePath));
// 			fclose($fh);
// 			$form->get('tplFileName')->setValue($tplName);
// 			$form->get('tplFileContent')->setValue($tplFileData);
//     	}
//     	$form->setData($this->params()->fromRoute());
//     	if($this->getRequest()->isPost()) {
//     		$postData = $this->getRequest()->getPost();
//         	$form->setData($postData);
//         	if($form->isValid()) {
// 	        	$sm = $this->getServiceLocator();
// 	    		$SiteConfig = $sm->get('ConfigObject\EnvironmentConfig');
// 	    		$siteId = $SiteConfig->globalSiteId;
	    		
// 	    		if(!is_dir($fileFolder)) {
// 	    			try {
// 	    				mkdir($fileFolder);
// 	    			} catch(Exception $e) {
// 	    				die('not able to create folder "'.$fileFolder.'"');
// 	    			}
// 	    		}
// 	    		$filePath = $fileFolder.'/'.$form->getInputFilter()->getValue('tplFileName');
// 	    		$fh = fopen($filePath, 'w');
// 	    		fwrite($fh, $form->get('tplFileContent')->getValue());
// 	    		fclose($fh);
// 	    		return $this->switchContext('brick', 'edit', array('id' => $brickId), true);
//         	}
//     	}
    	
//     	$extName = strtolower(str_replace('_', '/', $extName));
//     	$tplFile = BASE_PATH.'/extension/view/front/'.$extName.'/view.tpl';
// 		$fh = fopen($tplFile, 'r');
// 		$viewFileData = fread($fh, filesize($tplFile));
// 		fclose($fh);
    	
// 		$this->brickConfig()->setActionTitle('编辑TPL文件:'.$brick->extName)
//         	->setActionMenu(array('save'));
        
// 		return array(
// 			'brickId'		=> $brickId,
// 	    	'extName'		=> $extName,
// 			'tplArray'		=> $tplArr,
// 	    	'viewFileData'	=> $viewFileData,
// 	    	'form'			=> $form,
// 	    );
//     }
    
//     public function getTplContentAjaxAction()
//     {
//     	$this->brickConfig()->setActionTitle('')
//         	->setActionMenu(array());
    	
//     	$extName = $this->params()->fromPost('extName');
//     	$tplName = $this->params()->fromPost('tplName');
    	
//     	$tplFile = BASE_PATH.'/extension/view/front/'.$extName.'/'.$tplName;
// 		$fh = fopen($tplFile, 'r');
// 		$tplFileData = fread($fh, filesize($tplFile));
// 		fclose($fh);
//     	return array('tplFileData' => $tplFileData);
//     }
    
//     public function editCssAction()
//     {
//     	$brickId = $this->params()->fromRoute('brick-id');
//     	$db = Zend_Registry::get('db');
//     	try {
//     		$db->describeTable('css');
//     	} catch(Exception $e) {
//     		echo "<div style='padding: 25px;'>table not implemented!</div>";
//     		exit(0);
//     	}
//     	$brick = Class_Base::_('Brick')->find($brickId)->current();
//     	if(is_null($brick)) {
//     		throw new Exception('Brick not found');
//     	}
//     	$extName = substr($brick->extName, 6);
//     	$cssSuffix = empty($brick->cssSuffix) ? '' : '-'.$brick->cssSuffix;
//     	$cssName = 'brick-'.strtolower($extName).$cssSuffix;
    	
//     	$tb = new Zend_Db_Table('css');
//     	$row = $tb->fetchRow($tb->select()->where('id = ?', $cssName));
    	
//     	require_once APP_PATH.'/admin/forms/Brick/EditCss.php';
//     	$form = new Form_Brick_EditCss();
//     	if(is_null($row)) {
// 	    	$idField = $form->getElement('id');
// 	    	$idField->setValue($cssName);
// 	    	$row = $tb->createRow();
// 	    	$row->type = 'brick';
//     	} else {
//     		$form->populate($row->toArray());
//     	}
//     	if($this->getRequest()->isPost() && $form->isValid($this->params()->fromRoutes())) {
//     		$row->setFromArray($form->getValues());
//     		$row->inFile = false;
//     		$row->save();
//     	}
//     	$this->view->form = $form;
//     	$this->view->controls = array(
// 			'ajax-save' => array('callback' => '/admin/brick/edit-css/brick-id/'.$brickId)
//         );
//     }
    
    /*
    public function saveLocationJsonAction()
    {
    	$layoutId = $this->params()->fromRoute('layoutId');
    	$stageId = $this->params()->fromRoute('stageId');
    	$brickId = $this->params()->fromRoute('brickId');
    	$spriteName = $this->params()->fromRoute('spriteName');
    	
    	$tb = new Zend_Db_Table('layout_stage_brick');
    	$row = $tb->createRow();
    	$row->layoutId = $layoutId;
    	$row->stageId = $stageId;
    	$row->brickId = $brickId;
    	$row->spriteName = $spriteName;
    	
    	$row->save();
    	
    	$this->_helper->json(array('result' => 'success'));
    }
    */
}