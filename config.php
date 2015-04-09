<?php

$appConf = \com\sgtinc\ApplicationConfig::getInstance();

$appConf->__set('environment','production');
$appConf->__set('title','Slim Skeleton');
$appConf->__set('uriRoot','/');

//TODO: Should the DB Connection Info be configurable on init and within admin?
$appConf->__set('dbHost','localhost');
$appConf->__set('dbPort','3306');
$appConf->__set('dbName','skeleton');
$appConf->__set('dbUsername','skeleton');
$appConf->__set('dbPassword','...');

//TODO: Make LDAP configurable in the application
$appConf->__set('ldapHost','ldap://localhost');
$appConf->__set('ldapPort','636');

//TODO: Make SMTP configurable in the application
$appConf->__set('smtpHost','localhost');
$appConf->__set('smtpPort','25');
$appConf->__set('smtpFromEmail','no-reply@sgt-inc.com');
$appConf->__set('smtpFromName','SGT Slim Skeleton');

switch($_SERVER['SERVER_NAME']) {
	case "localhost":
	case "127.0.0.1":
		$appConf->__set('environment','local');
		$appConf->__set('title',$appConf->__get('title').' - local');
		$appConf->__set('uriRoot','/lites/slim-twig-skeleton/public/');

		$appConf->__set('smtpHost','localhost');
		$appConf->__set('smtpPort','8025');

		break;
	default:
		break;
}

//Instantiate MySQL DB connection
$appConf->__set('dbConnString','mysql:host=' . $appConf->__get('dbHost') . ';port=' . $appConf->__get('dbPort') . ';dbname=' . $appConf->__get('dbName'));

$GLOBALS['appConf'] = $appConf;
