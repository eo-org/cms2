<?php
namespace Ext\Brick;

use Exception;

abstract class AbstractExt
{
	protected $_brick = null;
	
	protected $params = null;
	
	protected $controller;
	
	protected $layoutFront;
	
	protected $sm;
	
    protected $disableRender = false;
    
    protected $effectFiles = null;

    public function initParam($brick, $controller)
    {
    	$this->_brick = $brick;
    	$this->params = (object)$brick->params;
    	$this->controller = $controller;
    	$this->sm = $controller->getServiceLocator();
    }
    
    public function setLayoutFront($lf)
    {
    	$this->layoutFront = $lf;
    }
    
    public function getLayoutFront()
    {
    	return $this->layoutFront;
    }
    
    abstract public function getTplList();
    
    public function getFormClass()
    {
    	return null;
    }
	
    public function getCacheId()
    {
    	return null;
    }
    
    public function documentManager()
    {
    	return $this->sm->get('DocumentManager');
    }
    
    public function dbFactory()
    {
    	return $this->sm->get('Core\Mongo\Factory');
    }
    
    public function getController()
    {
    	return $this->controller;
    }
    
	public function configParam($form)
    {
    	$formClassName = $this->getFormClass();
    	
    	if(!is_null($formClassName)) {
	    	$paramForm = new $formClassName($this->dbFactory());
	    	$form->add($paramForm);
    	}
    	return $form;
    }
    
    public function getExtName()
    {
    	return $this->_brick->extName;
    }
    
	public function getBrickId()
    {
    	return $this->_brick->brickId;
    }
    
    public function getBrickName()
    {
    	return $this->_brick->brickName;
    }
    
    public function getPosition()
    {
    	return $this->_brick->position;
    }
    
    public function getSpriteName()
    {
    	return $this->_brick->spriteName;
    }
    
    public function getEffectFiles()
    {
    	return $this->effectFiles;
    }
    
	public function getParam($key, $defaultValue = NULL)
    {
    	$params = $this->params;
    	if(isset($params->$key)) {
    		$temp = $params->$key;
    		return $temp;
    	}
    	return $defaultValue;
    }
    
    public function setParam($key, $value)
    {
    	$this->params->$key = $value;
    	return true;
    }
    
    public function setParams($src, $type = 'array')
    {
    	if(!empty($src)) {
	    	if($type == 'json') {
	    		$src = Zend_Json_Decoder::decode($src);
	    	}
	    	foreach($src as $key => $value) {
	    		if(!empty($value)) {
	    			$this->params->$key = $value;
	    		}
	    	}
    	}
    }
    
    public function render($type = null)
    {
    	if($this->disableRender === true) {
	        return "<div class='no-render'></div>";
    	} else if(is_string($this->disableRender)) {
    		return "<div class='".$this->disableRender."' brickId='".$this->_brick->getId()."'>无法找到对应的URL，此模块内容为空</div>";
    	} else {
    		$tplName = $this->_brick->tplName;
    		$systemTplList = $this->getTplList();
    		$templateName = $tplName;
    		
    		if(isset($systemTplList[$tplName])) {
    			$tplName = $systemTplList[$tplName];
    			//return $this->view->render($systemTplList[$tplName]);
    		} //else {
    			//return $this->view->render($tplName);
    		//}
    		
    		
    		$this->prepare();
    		
    		
    		
    		
// 	    	$this->view = new View();
	    	
// 			$this->view->assign($this->params);
			
			
// 			$this->view->setBrickId($this->_brick->getId())
// 				->setExtName($this->_brick->extName)
// 				->setClassSuffix($this->_brick->cssSuffix);
			
// 			$this->view->brickName = $this->_brick->brickName;
// 			$this->view->brickId = $this->_brick->getId();
// 			$this->view->displayBrickName = $this->_brick->displayBrickName;
			
			
// 			$values = array_merge($this->params, array(
// 				'brickName'	=> $this->_brick->brickName,
// 				'brickId'	=> $this->_brick->getId(),
// 			));
			
			
			$twigEnv = $this->sm->get('Twig\Environment');
			if($template = $twigEnv->loadTemplate($tplName)) {
				return $template->render($values);
				try {
					return $template->render($values);
					// 				if(isset($systemTplList[$tplName])) {
					// 					return $this->view->render($systemTplList[$tplName]);
					// 				} else {
					// 					return $this->view->render($tplName);
					// 				}
				} catch(Exception $e) {
					return $e->getMessage()." critical error within brick id: ".$this->_brick->getId().'!!<br /><a href="#/admin/brick.ajax/edit/brick-id/'.$this->_brick->getId().'">reset parameters</a>';
				}
			} else {
				return 'tpl not found with name '.$tplName;
			}
			
			
			
			
// 			try {
// 				if(isset($systemTplList[$tplName])) {
// 					return $this->view->render($systemTplList[$tplName]);
// 				} else {
// 					return $this->view->render($tplName);
// 				}
// 			} catch(Exception $e) {
// 				return $e->getMessage()." critical error within brick id: ".$this->_brick->getId().'!!<br /><a href="#/admin/brick.ajax/edit/brick-id/'.$this->_brick->getId().'">reset parameters</a>';
// 			}
    	}
    }
    
    public function getTplArray()
    {
    	$sysTplArray = $this->getTplList();
		
		$tplArray = array(
			array('label' => 'system', 'options' => $sysTplArray,),
			array('label' => 'user', 'options' => array())
		);
    	return $tplArray;
    }
}