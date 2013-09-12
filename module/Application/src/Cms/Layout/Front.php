<?php
namespace Cms\Layout;

use Zend\View\Helper\Doctype, Zend\View\Helper\HeadTitle, Zend\View\Helper\HeadMeta;
use Ext\Service\Register, Ext\Service\RegisterConfig;
use Cms\Session\Admin as SessionAdmin;

class Front
{
	protected $sm				= null;
	
	protected $context			= null;
	protected $generalSiteInfo	= null;
	protected $stageList		= null;
	protected $brickRegister	= null;
	protected $brickViewList	= null;
	
	public function __construct($sm)
	{
		$this->sm = $sm;
	}
	
	public function getGeneralSiteInfo()
	{
		if($this->generalSiteInfo == null) {
			$factory = $this->sm->get('Core\Mongo\Factory');
			$co = $factory->_m('Info');
			$this->generalSiteInfo = $co->fetchOne();
		}
		return $this->generalSiteInfo;
	}
	
	public function initActionController($controller)
	{
		$sm = $this->sm;
		$infoDoc = $this->getGeneralSiteInfo();
		
// 		$doctypeHelper = new Doctype();
// 		$doctypeHelper->setDoctype('HTML5');
		
		
		$layoutDoc = $this->getLayoutDoc();
		
 		$factory = $sm->get('Core\Mongo\Factory');
 		$brickRegister = new Register($controller, $this, new RegisterConfig($layoutDoc, $controller));
		$this->brickRegister = $brickRegister;
	
		$sessionAdmin	= new SessionAdmin();
		$viewModel		= $controller->layout();
		$jsList			= $brickRegister->getJsList();
		$cssList		= $brickRegister->getCssList();
		
		$userLayoutDocs = $factory->_m('layout')->addFilter('default', 0)
			->fetchDoc();
		
		$viewModel->setVariables(array(
			'factory' => $factory,
			'sessionAdmin' => $sessionAdmin,
			'layoutFront' => $this,
			'jsList' => $jsList,
			'cssList' => $cssList,
			'userLayoutDocs' => $userLayoutDocs
		));
		
		if(!is_null($infoDoc)) {
			$viewModel->setVariables(array(
				'title' => $infoDoc->pageTitle,
				'keywords' => $infoDoc->metakey,
				'description' => $infoDoc->metadesc
			));
		}
		
		/*
		 * @todo move all view model to controller!
		 * why we have it here in the first place ?
		 */
		$siteConfig = $sm->get('ConfigObject\EnvironmentConfig');
		$fileUrl = $siteConfig->fileFolderUrl;
		if($sessionAdmin->getUserData('localCssMode') == 'active') {
			$fileUrl = 'http://local.host/'.$siteConfig->globalSiteId;
		}
		
		$headFileCo = $factory->_m('HeadFile');
		$headFileDocs = $headFileCo->fetchDoc();
		
		$stylesheetArr = array();
		$scriptArr = array();
		$viewHelper = $sm->get('ViewHelperManager');
		foreach($headFileDocs as $doc) {
			if($doc->folder == 'helper') {
				if($doc->type == 'css') {
					//$viewHelper->get('HeadLink')->appendStylesheet();
					$stylesheetArr[] = $siteConfig->libUrl.'/front/script/helper/'.$doc->filename;
				} else {
					//$viewHelper->get('HeadScript')->appendFile();
					$scriptArr[] = $siteConfig->libUrl.'/front/script/helper/'.$doc->filename;
				}
			} else {
				if($doc->type == 'css') {
					//$viewHelper->get('HeadLink')->appendStylesheet($fileUrl.'/'.$doc->filename);
					$stylesheetArr[] = $fileUrl.'/'.$doc->filename;
				} else {
					//$viewHelper->get('HeadScript')->appendFile($fileUrl.'/'.$doc->filename);
					$scriptArr[] = $fileUrl.'/'.$doc->filename;
				}
			}
		}
		
		$viewModel->setVariables(array(
			'headlinks' => $stylesheetArr,
			'headscripts' => $scriptArr,
		));
		
		return $viewModel;
	}
	
	public function getStageList()
	{
		if($this->stageList == null) {
			$layoutDoc = $this->getLayoutDoc();
			$this->stageList = $layoutDoc->stage;
		}
		return $this->stageList;
	}
	
	public function getBrickViewList()
	{
		if($this->brickViewList == null) {
			$this->brickViewList = $this->brickRegister->renderAll();
		}
		return $this->brickViewList;
	}
	
	public function getBrickRegister()
	{
		return $this->brickRegister;
	}
	
	public function setContext(ContextAbstract $context)
	{
		$this->context = $context;
	}
	
	public function getContext()
	{
		return $this->context;
	}
	
	public function getContextId()
	{
		return $this->context->getId();
	}
	
	public function getLayoutDoc()
	{
		$context = $this->getContext();
		return $context->getLayoutDoc();
	}
	
	public function getLayoutId()
	{
		$layoutDoc = $this->getLayoutDoc();
		return $layoutDoc->getId();
	}

	public function getLayoutType()
	{
		$layoutDoc = $this->getLayoutDoc();
		return $layoutDoc->type;
	}

	public function getLayoutAlias()
	{
		$layoutDoc = $this->getLayoutDoc();
		if($layoutDoc->default == 1) {
			return $layoutDoc->type;
		} else {
			return $layoutDoc->alias;
		}
	}
	
	public function useLayoutTpl()
	{
		$layoutDoc = $this->getLayoutDoc();
		return $layoutDoc->useTpl;
	}
	
	public function getLayoutTpl()
	{
		$layoutDoc = $this->getLayoutDoc();
		return $layoutDoc->tplFileContent;
	}
}