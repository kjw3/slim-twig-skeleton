<?php

namespace com\sgtinc;

//class LdapService implements \JsonSerializable {
class LdapService {

	protected static $ldapHost = "ldap://localhost";
	protected static $ldapPort = "636";

	public static function setHost($host) {
		self::$ldapHost = $host;
	}

	public static function setPort($port) {
		self::$ldapPort = $post;
	}

	public static function findByEmail($email) {
		$filter = "(nasaPrimaryEmail={$email})";
		return self::findByFilter($filter);
	}

	public static function findByAuid($auid) {
		$filter = "(agencyUID={$auid})";
		return self::findByFilter($filter);
	}

	public static function findByLookup($query,$centerAcronym="LARC") {
		$filter = "(&(ou={$centerAcronym})(|(displayname={$query}*)(cn={$query}*)(sn={$query}*)(agencyUID={$query})(nasaPrimaryEmail={$query}*)))";
		return self::findByFilter($filter);
	}

	protected static function findByFilter($filter) {
		$ldapRecords = array();
		$ds = ldap_connect(self::$ldapHost,self::$ldapPort);
		$dn = "ou=people,dc=NASA,dc=gov";

		ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);

		$bound = ldap_search($ds, $dn, "(&(objectClass=person){$filter})", array(
			"dn",
			"employeeNumber",
			"agencyUID",
			"uid",
			"X500UID",
			"ou",
			"nasaEmployer",
			"nasaIdentityStatus",
			"nasaIEMPUserid",
			"nasaMailStop",
			"cn",
			"sn",
			"displayName",
			"givenname",
			"initials",
			"nasaPrimaryEmail",
			"nasaorgCode",
			"nasaOrgName",
			"NASAUSCitizen",
			"postalAddress",
			"title",
			"telephonenumber"
			)
		);
		ldap_sort($ds, $bound, "sn");
		ldap_sort($ds, $bound, "givenname");

		$info = ldap_get_entries($ds, $bound);

		for($i=0;$i<$info['count'];$i++) {
			$tempLdapRecord = new LdapRecord();
			$tempLdapRecord->populate($info[$i]);
			array_push($ldapRecords, $tempLdapRecord);
		}

		ldap_close($ds);

		return $ldapRecords;
	}

	public static function authenticate($uupic,$pwd){
		$results['success'] = false;
		$results['message'] = '';

		$ds = ldap_connect(self::$ldapHost,self::$ldapPort);
		$dn = "employeenumber=$uupic,ou=people,dc=NASA,dc=gov";

		ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);

		try {
			$ldapResult = ldap_bind($ds, $dn, $pwd);

			if ($ldapResult === -1) {
				$results['message'] = "Error: " . ldap_error($ds);
			} elseif ($ldapResult === true) {
				$results['success'] = true;
				$results['message'] = "Successfully authenticated";
			} elseif ($ldapResult === false) {
				$results['message'] = "Username/Password combination incorrect";
			}
		} catch (\Exception $e) {
			$results['message'] = "Error: " . $e->getMessage();
		}

		ldap_close($ds);

		return $results;
	}
}
