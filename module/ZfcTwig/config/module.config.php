<?php
return array(
    'zfctwig' => array(
        /**
         * Service manager alias of the loader to use with ZfcTwig. By default, it uses
         * the included ZfcTwigLoaderChain which includes a copy of ZF2's TemplateMap and
         * TemplatePathStack.
         */
        'environment_loader' => 'ZfcTwigLoaderChain',

        /**
         * Options that are passed directly to the Twig_Environment.
         */
        'environment_options' => array(),

        /**
         * Service manager alias of any additional loaders to register with the chain. The default
         * has the TemplateMap and TemplatePathStack registered. This setting only has an effect
         * if the `environment_loader` key above is set to ZfcTwigLoaderChain.
         */
        'loader_chain' => array(
        	'ZfcTwigLoaderTemplateDb',
            'ZfcTwigLoaderTemplateMap',
        ),

        /**
         * Service manager alias or fully qualified domain name of extensions. ZfcTwigExtension
         * is required for this module to function!
         */
        'extensions' => array(
            'zfctwig' => 'ZfcTwigExtension'
        ),

        /**
         * The suffix of Twig files. Technically, Twig can load *any* type of file
         * but the templates in ZF are suffix agnostic so we must specify the extension
         * that's expected here.
         */
        //'suffix' => 'twig',

        /**
         * When enabled, the ZF2 view helpers will get pulled using a fallback renderer. This will
         * slightly degrade performance but must be used if you plan on using any of ZF2's view helpers.
         */
        'enable_fallback_functions' => true,

        /**
         * If set to true disables ZF's notion of parent/child layouts in favor of
         * Twig's inheritance model.
         */
        'disable_zf_model' => true
    ),

    'view_manager' => array(
        'template_map' => array(
            'layout/layout'				=> __DIR__ . '/../view/layout/layout.tpl',
        	'layout/head-client'		=> __DIR__ . '/../view/layout/head-client.tpl',
    		'layout/head-admin'			=> __DIR__ . '/../view/layout/head-admin.tpl',
    		'layout/toolbar'			=> __DIR__ . '/../view/layout/toolbar.tpl',
        	'layout/toolbar-tail'		=> __DIR__ . '/../view/layout/toolbar-tail.tpl',
        	'layout/body-head'			=> __DIR__ . '/../view/layout/body-head.tpl',
        	'layout/body-main'			=> __DIR__ . '/../view/layout/body-main.tpl',
        	'layout/body-tail'			=> __DIR__ . '/../view/layout/body-tail.tpl'
        ),
	)
);