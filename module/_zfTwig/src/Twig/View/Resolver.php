<?php

namespace Cms\Twig\View;

use Twig_Environment;
use Twig_Error_Loader;
use Zend\View\Resolver\ResolverInterface;
use Zend\View\Renderer\RendererInterface;
use ZfTwig\View\Renderer as TwigRenderer;

class Resolver implements ResolverInterface
{
    /**
     * @var Twig_Environment
     */
    protected $environment;

    /**
     * Constructor.
     *
     * @param Twig_Environment $environment
     */
    public function __construct(Twig_Environment $environment)
    {
        $this->environment = $environment;
    }

    public function resolve($name, RendererInterface $renderer = null)
    {
        if ($renderer instanceof TwigRenderer) {
            try {
                return $this->environment->loadTemplate($name);
            } catch (Twig_Error_Loader $e) {
                return false;
            }
        }
        return false;
    }
}