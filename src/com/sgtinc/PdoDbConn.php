<?php

namespace com\sgtinc;

class PdoDbConn {
	protected $pdoDbConnString;
	protected $pdoDbUser;
	protected $pdoDbPwd;
	protected $pdoWrapper;

	public static function getInstance() {
		static $instance = null;
		if (null === $instance) {
			$instance = new static();
		}

		return $instance;
	}

	/**
	 * Protected constructor to prevent creating a new instance of the
	 * *Singleton* via the `new` operator from outside of this class.
	 */
	protected function __construct() { }

	/**
	 * Private clone method to prevent cloning of the instance of the
	 * *Singleton* instance.
	 *
	 * @return void
	 */
	private function __clone() { }

	private function __sleep() {
        return array_diff(array_keys(get_object_vars($this)), array('pdoWrapper'));
    }
    
    private function __wakeup() {
        $this->createConnection($this->$pdoDbConnString,$this->pdoDbUser,$this->$pdoDbPwd);
    }

	public function createConnection($pdoDbConnString, $pdoDbUser, $pdoDbPwd) {
		$this->pdoDbConnString = $pdoDbConnString;
		$this->pdoDbUser = $pdoDbUser;
		$this->pdoDbPwd = $pdoDbPwd;
		$this->pdoWrapper = new \Imavex\PdoWrapper($pdoDbConnString, $pdoDbUser, $pdoDbPwd);
	}

	public function getPdoWrapper() {
		return $this->pdoWrapper;
	}

}
