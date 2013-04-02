<?php
namespace Ext\Twig;

use Twig_LoaderInterface;
use Twig_Error_Loader;

class DatabaseLoader implements Twig_LoaderInterface
{
    protected $dm;
	protected $fileLoader;
	
    public function __construct($dm, $fileLoader)
    {
        $this->dm = $dm;
        $this->fileLoader = $fileLoader;
    }

    public function getSource($name)
    {
    	if(substr($name, -4) == '.tpl') {
    		$templateFileContent = $this->fileLoader->getSource($name);
    	} else {
    		$template = $this->dm->getRepository('Ext\Document\Template')->findOneById($name);
    		if(is_null($template)) {
    			$template = $this->dm->getRepository('Ext\Document\Template')->findOneByScriptName($name);
    		}
    		if(is_null($template)) {
    			die('ext template '.$name.' not found');
    		}
    		$templateFileContent = $template->getContent();
    	}
        return $templateFileContent;

//         if(!is_null($template)) {
//             return $template->getContent();
//         } else {
// 			$newTemplate = $this->createDatabaseTemplate($name);
// 			//return $newTemplate;
// 			return $newTemplate->getContent();
//         }
    }

    public function isFresh($name, $time)
    {
		return true;
    }

    public function getCacheKey($name)
    {
        return "cache-1-extension-".$name;
    }
    
//     protected function createDatabaseTemplate($name)
//     {
//     	//return $templateFileContent = $this->fileLoader->getSource($name);
//     	$template = new \Cms\Document\Template();
    	
//     	$template->setName($name);
//     	$template->setContent($templateFileContent);
//     	$this->dm->persist($template);
//     	$this->dm->flush();
//     	return $template;
//     }
}