<?php
namespace Cms\Twig\Service;

use RuntimeException;
use Twig_Environment;
use Twig_Loader_Chain;
use Twig_Loader_Filesystem;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Cms\Twig\Loader\TemplateMap;

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
        $brickPathStackConfig = $config['brick_path_stack'];
        
        $env	= new Twig_Environment(null, array());
        $chain	= new Twig_Loader_Chain();
        
        $templateMapLoader = new TemplateMap();
        $templateMapArr = $twigConfig['application_layout_map'];
        
        foreach($templateMapArr as $name => $path) {
        	$templateMapLoader->add($name, $path);
        }
        
        
        
        
        $brickStackLoader = new Twig_Loader_Filesystem($brickPathStackConfig);
        
        
        $chain->addLoader($templateMapLoader);
        $chain->addLoader($brickStackLoader);
        // 		Twig\View::setFileLoader($fileLoader);
        
        // 		$dm = $sm->get('DocumentManager');
        // 		$loader = new Twig\DatabaseLoader($dm, $fileLoader);
        
        // 		$twigEnv->setLoader($loader);
        
        $env->setLoader($chain);
        
        return $env;
    }
}
