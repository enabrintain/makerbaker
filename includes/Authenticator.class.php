<?php @session_start();

class Authenticator {

	public function __construct() {
		$this->ldap = new Ldap();
	}
	
	public function requireAuthenticatedUser() {
		if ( !(array_key_exists("valid",$_SESSION) && $_SESSION["valid"]) ) {
			die(header("Location: login.php?next=" . urlencode($_SERVER["REQUEST_URI"]) ));
		}
	}
	public function requireUnauthenticatedUser($o = "") {
		if ( (array_key_exists("valid",$_SESSION) && $_SESSION["valid"]) ) {
			if ( strlen($o) > 0 ) {
				die(header("Location: " . $o));
			} else {
				die('You\'re logged in. <a href="logout.php">Log out</a>?');
			}
		}
	}

	//TODO: Needs to move into ldap class
	public function isMemberOf($groupCn) {
		//return true;
		foreach ($this->ldap->getGroupMembers($groupCn) as $member) {
			if ( $member["uid"][0] == $_SESSION["uid"] ) {
				return true;
			}
		}
		return false;
	}

	public function requireMemberOf($groupCn) {
		$this->requireAuthenticatedUser();
		if ( !$this->isMemberOf($groupCn) ) {
			//TODO: Need to make better error handling.
			die('Access denied due to insufficient permissions');
		}
	}

	public function setCurrentUid($uid) {
		$_SESSION["valid"] = true;
		$_SESSION["uid"] = $uid;
		return true;
	}
	public function getCurrentUid() {
		if ( $_SESSION["valid"] ) return $_SESSION["uid"];
		return false;
	}

}
