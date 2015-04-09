<?php

namespace com\sgtinc;

//class User implements \JsonSerializable { Curren
class LdapRecord {
	protected $dn;
	protected $employeeNumber;
	protected $agencyUid;
	protected $uid;
	protected $x500Uid;
	protected $ou;
	protected $nasaEmployer;
	protected $nasaIdentityStatus;
	protected $nasaIEmpUserId;
	protected $nasaMailStop;
	protected $cn;
	protected $sn;
	protected $displayName;
	protected $givenName;
	protected $initials;
	protected $nasaPrimaryEmail;
	protected $nasaOrgCode;
	protected $nasaOrgName;
	protected $nasaUsCitizen;
	protected $postalAddress;
	protected $title;
	protected $telephonenumber;
	
	public function __construct() {
		//Nothing to do
	}

	public function __get($property) {
		return $this->$property;
	}

	public function __set($property,$value) {
		$this->$property = $value;
	}

	public function populate($recordIn) {
		$this->dn = array_key_exists('dn',$recordIn)? $recordIn['dn'] : NULL;
		$this->employeeNumber = array_key_exists('employeenumber',$recordIn)? $recordIn['employeenumber'][0] : NULL;
		$this->agencyUid = array_key_exists('agencyuid',$recordIn)? $recordIn['agencyuid'][0] : NULL;
		$this->uid = array_key_exists('uid',$recordIn)? $recordIn['uid'] : NULL;
		$this->x500Uid = array_key_exists('x500uid',$recordIn)? $recordIn['x500uid'][0] : NULL;
		$this->ou = array_key_exists('ou',$recordIn)? $recordIn['ou'][0] : NULL;
		$this->nasaEmployer = array_key_exists('nasaemployer',$recordIn)? $recordIn['nasaemployer'][0] : NULL;
		$this->nasaIdentityStatus = array_key_exists('nasaidentitystatus',$recordIn)? $recordIn['nasaidentitystatus'][0] : NULL;
		$this->nasaIEmpUserId = array_key_exists('nasaiempuserid',$recordIn)? $recordIn['nasaiempuserid'][0] : NULL;
		$this->nasaMailStop = array_key_exists('nasamailstop',$recordIn)? $recordIn['nasamailstop'][0] : NULL;
		$this->cn = array_key_exists('cn',$recordIn)? $recordIn['cn'][0] : NULL;
		$this->sn = array_key_exists('sn',$recordIn)? $recordIn['sn'][0] : NULL;
		$this->displayName = array_key_exists('displayname',$recordIn)? $recordIn['displayname'][0] : NULL;
		$this->givenName = array_key_exists('givenname',$recordIn)? $recordIn['givenname'][0] : NULL;
		$this->initials = array_key_exists('initials',$recordIn)? $recordIn['initials'][0] : NULL;
		$this->nasaPrimaryEmail = array_key_exists('nasaprimaryemail',$recordIn)? $recordIn['nasaprimaryemail'][0] : NULL;
		$this->nasaOrgCode = array_key_exists('nasaorgcode',$recordIn)? $recordIn['nasaorgcode'][0] : NULL;
		$this->nasaOrgName = array_key_exists('nasaorgname',$recordIn)? $recordIn['nasaorgname'][0] : NULL;
		$this->nasaUsCitizen = array_key_exists('nasauscitizen',$recordIn)? $recordIn['nasauscitizen'][0] : NULL;
		$this->postalAddress = array_key_exists('postaladdress',$recordIn)? $recordIn['postaladdress'][0] : NULL;
		$this->title = array_key_exists('title',$recordIn)? $recordIn['title'][0] : NULL;
		$this->telephonenumber = array_key_exists('telephonenumber',$recordIn)? $recordIn['telephonenumber'][0] : NULL;
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
