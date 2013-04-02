<?php
namespace Cms\Twig;

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
        $template = $this->dm->getRepository('Cms\Document\Template')->findOneByName($name);

        if(!is_null($template)) {
            return $template->getContent();
        } else {
			$newTemplate = $this->createDatabaseTemplate($name);
			return $newTemplate->getContent();
        }
    }

    public function isFresh($name, $time)
    {
		return true;
    }

    public function getCacheKey($name)
    {
        return "cache-1-extension-".$name;
    }
    
    protected function createDatabaseTemplate($name)
    {
    	die('hao');
    	$template = new \Cms\Document\Template();
    	$templateFileContent = $this->fileLoader->getSource($name);
    	$template->setName($name);
    	$template->setContent($templateFileContent);
    	$this->dm->persist($template);
    	$this->dm->flush();
    	return $template;
    }
}