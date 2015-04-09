<?php
date_default_timezone_set('US/Eastern');

session_start();

require_once '../vendor/autoload.php';
require_once '../config.php';

$app = new \Slim\Slim(array(
	'mode' => 'development',
	'templates.path' => '../templates'
));

$app->setName($appConf->__get('title'));

$app->container->singleton('log', function () {
	$log = new \Monolog\Logger('contractportfolio');
	$log->pushHandler(new \Monolog\Handler\StreamHandler('../logs/app.log', \Monolog\Logger::DEBUG));
	return $log;
});

// Only invoked if mode is "production"
$app->configureMode('production', function () use ($app) {
	$app->config(array(
		'log.enable' => true,
		'debug' => false
	));
});

// Only invoked if mode is "development"
$app->configureMode('development', function () use ($app) {
	$app->config(array(
		'log.enable' => false,
		'debug' => true
	));
});

//Inject singleton pdoDbConn for database connection
$app->container->singleton('pdoDbConn', function ($appConf) {
	$dbConn = \com\sgtinc\PdoDbConn::getInstance();
	$dbConn->createConnection($appConf->__get('dbConnString'),$appConf->__get('dbUsername'),$appConf->__get('dbPassword'));
	return $dbConn->getPdoWrapper();
});

//Setup and Configure TWIG Views
$app->view(new \Slim\Views\Twig());
$app->view->parserOptions = array(
	'charset' => 'utf-8',
	'cache' => realpath('../templates/cache'),
	'auto_reload' => true,
	'debug' => true,
	'strict_variables' => false,
	'autoescape' => true
);
$app->view->parserExtensions = array(new \Slim\Views\TwigExtension());
$twig = $app->view()->getEnvironment();

//Injecting PHP SESSION and GLOBALS into TWIG
$twig->addGlobal("session", $_SESSION);
$twig->addGlobal("globals", $GLOBALS);

//include_once '../routes/middleware.php';

//Include API route files
include_once '../routes/application.php';

$app->run();
