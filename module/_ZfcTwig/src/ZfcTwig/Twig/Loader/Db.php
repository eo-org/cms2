<?php
namespace ZfcTwig\Twig\Loader;

use Zend\ServiceManager\ServiceLocatorAwareInterface, Zend\ServiceManager\ServiceLocatorInterface;
use Twig_Error_Loader;
use Twig_ExistsLoaderInterface;
use Twig_LoaderInterface;

class Db implements Twig_ExistsLoaderInterface, Twig_LoaderInterface, ServiceLocatorAwareInterface
{
	protected $sm;
	
	protected $layoutDoc;
	
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->sm = $serviceLocator;
	}
	
	public function getServiceLocator()
	{
		return $this->sm;
	}
	
	public function getLayoutDoc()
	{
		if(!$this->layoutDoc) {
			$layoutFront = $this->sm->get('Cms\Layout\Front');
			$this->layoutDoc = $layoutFront->getLayoutDoc();
		}
		return $this->layoutDoc;
	}
	
    /**
     * Check if we have the source code of a template, given its name.
     *
     * @param string $name The name of the template to check if we can load
     *
     * @return boolean If the template source code is handled by this loader or not
     */
    public function exists($name)
    {
    	if($name == 'layout/layout') {
    		
    		if($this->getLayoutDoc()->useTpl == 1) {
    			return true;
    		} else {
    			return false;
    		}
        	
    	}
    	return false;
    }

    /**
     * Gets the source code of a template, given its name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The template source code
     *
     * @throws Twig_Error_Loader When $name is not found
     */
    public function getSource($name)
    {
        if (!$this->exists($name)) {
            throw new Twig_Error_Loader(sprintf(
                'Unable to find template "%s" from template map',
                $name
            ));
        }
		
        return $this->getLayoutDoc()->getTplFileContent();
    }

    /**
     * Gets the cache key to use for the cache for a given template name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The cache key
     *
     * @throws Twig_Error_Loader When $name is not found
     */
    public function getCacheKey($name)
    {
        return $name;
    }

    /**
     * Returns true if the template is still fresh.
     *
     * @param string    $name The template name
     * @param int       $time The last modification time of the cached template
     *
     * @return Boolean true if the template is fresh, false otherwise
     *
     * @throws Twig_Error_Loader When $name is not found
     */
    public function isFresh($name, $time)
    {
        return true;
    }
}