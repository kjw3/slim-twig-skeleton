<?php

namespace com\sgtinc;

class LdapServiceTest extends \PHPUnit_Framework_TestCase {

	public function testFindByEmailSuccess() {

		//Check that given a valid auid, ldap does return a user
		$email = 'kevin.d.jones@nasa.gov';
		$ldapRecords = \com\sgtinc\LdapService::findByEmail($email);

		$this -> assertGreaterThanOrEqual(1, count($ldapRecords));

		//Check that given a valid auid, ldap does return the requested user
		$this -> assertEquals('kevin.d.jones@nasa.gov', $ldapRecords[0]->__get('nasaPrimaryEmail'));
	}

	public function testFindByEmailFailure() {

		//Check that given an invalid auid, ldap doesn't return a user
		$email = 'Im.not.a.valid.email@nasa.gov';
		$ldapRecords = \com\sgtinc\LdapService::findByAuid($email);

		$this -> assertEquals(0, count($ldapRecords));
	}

	public function testFindByAuidSuccess() {

		//Check that given a valid auid, ldap does return a user
		$auid = 'kdjones1';
		$ldapRecords = \com\sgtinc\LdapService::findByAuid($auid);

		$this -> assertEquals(1, count($ldapRecords));

		//Check that given a valid auid, ldap does return the requested user
		$this -> assertEquals('kdjones1', $ldapRecords[0]->__get('agencyUid'));
	}

	public function testFindByAuidFailure() {

		//Check that given an invalid auid, ldap doesn't return a user
		$auid = 'Im not a valid auid';
		$ldapRecords = \com\sgtinc\LdapService::findByAuid($auid);

		$this -> assertEquals(0, count($ldapRecords));
	}

	public function testFindByLookupSuccess() {

		//Check that given a valid search, ldap does return a user
		$centerAcronym = "LARC";
		$query = 'Jones';
		$ldapRecords = \com\sgtinc\LdapService::findByLookup($query,$centerAcronym);

		$this -> assertGreaterThanOrEqual(1, count($ldapRecords));
	}

	public function testFindByLookupFailure() {

		//Check that given an invalid search, ldap doesn't return a user
		$centerAcronym = "LARC";
		$query = 'Im not a valid user';
		$ldapRecords = \com\sgtinc\LdapService::findByLookup($query,$centerAcronym);

		$this -> assertEquals(0, count($ldapRecords));
	}

	/*
	public function testAuthenticateSuccess() {

		//Check that given a valid auid, ldap does return a user
		// NOTE: The credentials here need to be modified to a valid user
		//       uupic and password for the test to succeed
		$uupic = 'your uupic here';
		$pwd = 'your launchpad password here';
		$results = \com\sgtinc\LdapService::authenticate($uupic,$pwd);

		$this -> assertEquals(true, $results['success']);
	}
	*/

	public function testAuthenticateFailure() {

		//Check that given an invalid auid, ldap does not return a user
		$uupic = '9999999999';
		$pwd = '123456789012345';
		$results = \com\sgtinc\LdapService::authenticate($uupic,$pwd);

		$this -> assertEquals(false, $results['success']);
	}

}
