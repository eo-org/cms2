<?php
return array(
    'mongo_db' => array(
        'driver'	=> 'MongoDb',
        'host'		=> '127.0.0.1',
    	'dbName'	=> 'cms',
    ),
    'service_manager' => array(
    	'invokables' => array(
    		'Core\Mongo\Factory' => 'Core\Mongo\Factory'
    	),
        'factories' => array(
			'Core\Mongo\Db\Adapter'		=> 'Core\Mongo\Db\AdapterServiceFactory',
    		'Zend\Db\Adapter\Adapter'	=> 'Zend\Db\Adapter\AdapterServiceFactory'
        ),
    ),
);