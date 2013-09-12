<?php
namespace Cms\Twig\Loader;

use Twig_LoaderInterface;
use Twig_Error_Loader;

class DatabaseLoader implements Twig_LoaderInterface
{
    protected $dm;
	
    public function __construct($dm)
    {
        $this->dm = $dm;
    }

    public function getSource($name)
    {
        $template = $this->dm->getRepository('Ext\Document\Template')->findOneById($name);
		if(is_null($template)) {
			$template = $this->dm->getRepository('Ext\Document\Template')->findOneByScriptName($name);
		}
        if(!is_null($template)) {
            return $template->getContent();
        }
        
        return new Twig_Error_Loader("database template not found with given id: ".$name);
    }


    public function getCacheKey($name)
    {
        return "extension-cache-".$name;
    }

    public function isFresh($name, $time)
    {
    	return true;
    }
}