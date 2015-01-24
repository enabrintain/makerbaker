<?php

class Ldap {
	
	private $ds;
	private $bound_dn;
	
	public function __construct($bind_dn = LdapInfo::bind_dn, $bind_pass = LdapInfo::bind_pass, $version = LdapInfo::version) {
		global $config;
		
		$this->ds = ldap_connect(LdapInfo::uri);
		ldap_set_option($this->ds, LDAP_OPT_PROTOCOL_VERSION, $version);
		if ( !$this->ds ) { die("LDAP failed to connect." . $config["error_text"]); }
		$r = ldap_bind($this->ds, $bind_dn, $bind_pass);
		if ( $r == false ) {
			ldap_get_option($this->ds,LDAP_OPT_ERROR_NUMBER,$err);
			if ( $err == 32 or $err == 49 ) { //invalid user or password
				throw new ErrorException("Bad login");
			}
			else { throw new ErrorException("Unknown error"); }
		}
		$this->bound_dn = $bind_dn;
	}
	
	public function search($filter) {
		$sr=ldap_search($this->ds, LdapInfo::base_dn, $filter);  
		return(ldap_get_entries($this->ds, $sr));
	}
	
	public function getUserFromEmail($email) {
		$f = "(|(zimbraPrefMailForwardingAddress=" . $email . ")(mail=" . $email . ")(uid=" . $email . "))";
		$r = $this->search($f);
		if ( $r["count"] > 0 ) { return $r[0]; }
		return false;
	}
	public function getUserFromUid($uid) { return $this->getUserFromEmail($uid); }

	public function changePassword($uid, $pw) {

		$userPassword = "{SHA}" . base64_encode( pack( "H*", sha1( $pw ) ) );
		return $this->changeAttribute($uid, "userPassword", $userPassword);

	}

	public function changeAttribute($uid, $attribute, $value) {
		$dn = null;
		if ( $uid === null ) {
			$dn = $this->bound_dn;
		} else {
			$dn = "uid=" . $uid . "," . LdapInfo::base_dn;
		}

		//die($dn . "," . $attribute . "," . $value);

		$entry[$attribute] = array($value);
		$result = ldap_mod_replace($this->ds, $dn, $entry);

		if ( $result !== true ) {
			throw new ErrorException("Couldn't change password for some reason");
		}

		return $result;

	}

}
