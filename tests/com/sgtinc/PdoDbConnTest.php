<?php

namespace com\sgtinc;

class PdoDbConnTest extends \PHPUnit_Framework_TestCase {

	public function testCreateConnection() {

		/*
		 * NOTE: for this test you will need a local MySQL instance running with the following:
		 *       database named "test"
		 *       user named "test" with password "test"
		 *       Grant the test user ONLY select privileges on the test database
		 */

		$dbHost = "localhost";
		$dbName = "test";
		$dbUser = "test";
		$dbPwd = "test";

		$dbConnString = "mysql:host=".$dbHost.";port=3306;dbname=".$dbName;

		$dbConn = \com\sgtinc\PdoDbConn::getInstance();
		$dbConn->createConnection($dbConnString,$dbUser,$dbPwd);
		$pdoWrapper = $dbConn->getPdoWrapper();

		//Check that the database PdoWrapperObject is an object
		$this->assertInstanceOf('\Imavex\PdoWrapper', $pdoWrapper);

		$results = $pdoWrapper->run('select 1 from dual');

		//Check that we can select something with the \Imavex\PdoWrapper object
		$this->assertEquals(1,count($results));

	}

}
