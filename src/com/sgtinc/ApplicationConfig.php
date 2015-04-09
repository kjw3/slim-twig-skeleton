<?php

namespace com\sgtinc;

//class User implements \JsonSerializable {
class ApplicationConfig {

	protected $environment;
	protected $title;
	protected $uriRoot;
	protected $dbHost;
	protected $dbPort;
	protected $dbName;
	protected $dbUsername;
	protected $dbPassword;
	protected $dbConnString;
	protected $ldapHost;
	protected $ldapPort;
	protected $smtpHost;
	protected $smtpPort;
	protected $smtpUsername;
	protected $smtpPassword;
	protected $smtpFromEmail;
	protected $smtpFromName;

	public static function getInstance() {
		static $instance = null;
		if (null === $instance) {
			$instance = new static();
		}

		return $instance;
	}

	protected function __construct() { }
	private function __clone() { }
	private function __wakeup() { }

	public function __get($property) {
		return $this->$property;
	}

	public function __set($property,$value) {
		$this->$property = $value;
	}

	public function jsonSerialize() {
		return $this->toArray();
	}

	public function toArray() {
		$var = get_object_vars($this);
		foreach($var as &$value){
			if(is_object($value) && method_exists($value,'toArray')){
				$value = $value->toArray();
			}
		}
		return $var;
	}

}
