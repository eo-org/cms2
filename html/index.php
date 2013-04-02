<?php
$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$starttime = $mtime;

/**
 * Validate Site Domains!
 * 
 */
define("BASE_PATH", getenv('BASE_PATH'));
define("CENTER_DB", getenv('CENTER_DB'));

$requestHost = $_SERVER['HTTP_HOST'];

$m = new MongoClient(CENTER_DB, array(
	'username' => 'craftgavin',
	'password' => 'whothirstformagic?',
	'db' => 'admin')
);

$db = $m->selectDb('service_account');
$siteArr = $db->site->findOne(array('domains.domainName' => $requestHost));

if(is_null($siteArr)) {
	header('Location: http://www.enorange.com/no-site/');
	exit(0);
}
if(!$siteArr['active']) {
	header('Location: http://www.enorange.com/site-expired/');
	exit(0);
}

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

//define("CACHE_PATH", BASE_PATH.'/cms-misc/cache');

include BASE_PATH.'/inc/Zend/Loader/StandardAutoloader.php';

$autoLoader = new Zend\Loader\StandardAutoloader(array(
    'namespaces' => array(
        'Zend'		=> BASE_PATH.'/inc/Zend',
		'Core'		=> BASE_PATH.'/inc/Core',
    	'Doctrine'	=> BASE_PATH.'/inc/Doctrine',
		'Fucms'		=> BASE_PATH.'/library-cms/Fucms',
		'Brick'		=> BASE_PATH.'/extension/Brick',
    	'Document'	=> BASE_PATH.'/library-cms/Document',
    	'Cms'		=> BASE_PATH.'/cms2/module/Application/src/Cms'
    ),
    'prefixes' => array(
    	'Twig'	=> BASE_PATH.'/inc/Twig',
    	'App'	=> BASE_PATH.'/inc/App',
    	'Class' => BASE_PATH.'/library-cms/Class'
    )
));
$autoLoader->register();

\Fucms\SiteConfig::setSiteArr($siteArr);

$application = Zend\Mvc\Application::init(include 'config/application.config.php');
$application->run();


$mtime = microtime();
$mtime = explode(" ",$mtime);
$mtime = $mtime[1] + $mtime[0];
$endtime = $mtime;
$totaltime = ($endtime - $starttime);

//echo $_SERVER['X-Requested-With'];
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	echo "<!--".$totaltime."-->";
}