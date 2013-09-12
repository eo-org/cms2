<?php
namespace Cms\Twig\Service;

use RuntimeException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Twig_Environment;
use Twig_Loader_Chain;
use Twig_Loader_Filesystem;
use Cms\Twig\Loader\TemplateMap;
use Cms\Twig\Loader\DatabaseLoader;

class EnvironmentFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config  = $serviceLocator->get('Config');
        $twigConfig  = $config['twig'];
        
        $env	= new Twig_Environment(null, array());
        
        //twig loader define
        $layoutFront = $serviceLocator->get('Cms\Layout\Front');
        $templateMapLoader = new TemplateMap($layoutFront);
        $templateMapArr = $twigConfig['application_layout_map'];
        foreach($templateMapArr as $name => $path) {
        	$templateMapLoader->add($name, $path);
        }
        
        $brickPathStackConfig = $config['brick_path_stack'];
        $brickStackLoader = new Twig_Loader_Filesystem($brickPathStackConfig);
        
        $dm = $serviceLocator->get('documentManager');
        
        $databaseLoader = new DatabaseLoader($dm);
        
        //add loaders to chain loader
        $chain	= new Twig_Loader_Chain();
        $chain->addLoader($templateMapLoader);
        $chain->addLoader($brickStackLoader);
        $chain->addLoader($databaseLoader);
        $env->setLoader($chain);
        
        

        // 		Twig\View::setFileLoader($fileLoader);
        
        // 		$dm = $sm->get('DocumentManager');
        // 		$loader = new Twig\DatabaseLoader($dm, $fileLoader);
        
        // 		$twigEnv->setLoader($loader);
        
        
        return $env;
    }
}
