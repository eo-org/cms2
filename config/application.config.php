<?php
return array(
    'modules' => array(
/*******basic modules*******/
    	'DoctrineMongo',
    	'Ext',
		'Application',
		'Admin',
		'Rest',
/*******extra modules*******/
    	'User',
    	'Disqus',
    	'Location',
    	'Message'
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php'
        ),
        'module_paths' => array(
            './module',
        	'./extra'
        ),
    ),
);
