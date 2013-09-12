<?php
namespace Ext\Brick;

use Exception;
use Zend\View\Model\ViewModel;
use Cms\Session\Admin;

abstract class AbstractExt
{
	protected $_brick = null;
	
	protected $params = null;
	
	protected $controller;
	
	protected $layoutFront;
	
	protected $sm;
	
    protected $disableRender = false;
    
    protected $effectFiles = null;

    protected $view;
    
    public function initParam($brick, $controller)
    {
    	$this->_brick = $brick;
    	$this->params = $brick->params;
    	$this->controller = $controller;
    	$this->sm = $controller->getServiceLocator();
    	$this->view = new ViewModel();
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
    
    public function getBrickId()
    {
    	return $this->_brick->getId();
    }
    
    public function getExtName()
    {
    	return $this->_brick->extName;
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
    
    public function getClassSuffix()
    {
    	if(empty($this->_brick->cssSuffix)) {
    		return "";
    	} else {
    		return " ".$this->_brick->cssSuffix;
    	}
    }
    
    public function getEffectFiles()
    {
    	return $this->effectFiles;
    }
    
	public function getParam($key, $defaultValue = NULL)
    {
    	$params = $this->params;
    	if(isset($params[$key])) {
    		$temp = $params[$key];
    		return $temp;
    	}
    	return $defaultValue;
    }
    
    public function setParam($key, $value)
    {
    	$this->params[$key] = $value;
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
	    			$this->params[$key] = $value;
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
    		}
    		
    		$this->prepare();
    		
			$variables = $this->view->getVariables()->getArrayCopy();
			
			if(is_null($this->params)) {
				$this->params = array();
			}
			if(is_null($variables)) {
				$variables = array();
			}
			$values = array_merge($this->params, $variables, array(
				'brickName'	=> $this->_brick->brickName,
				'brickId'	=> $this->_brick->getId(),
			));
			
			if(is_null($values)) {
				$values = array();
			}
			
			$twigEnv = $this->sm->get('Twig\Environment');
			if($template = $twigEnv->loadTemplate($tplName)) {
				$sessionAdmin = new Admin();
				$templateHTML = "";
				try {
					$templateHTML =  $template->render($values);
				} catch(Exception $e) {
					$templateHTML =  $e->getMessage()." critical error within brick id: ".$this->_brick->getId().'!!<br /><a href="#/admin/brick.ajax/edit/brick-id/'.$this->_brick->getId().'">reset parameters</a>';
				}
				$className = strtolower(substr($this->getExtName(), 4)).$this->getClassSuffix();
				if($sessionAdmin->isLogin()) {
					$tHead = '<div class="'.$className.'" brick-id="'.$this->getBrickId().'" ext-name="'.$this->getExtName().'" >';
				} else {
					$tHead = '<div class="'.$className.'">';
				}
				$tTail = "</div>";
				return $tHead.$templateHTML.$tTail;
			} else {
				return 'tpl not found with name '.$tplName;
			}
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