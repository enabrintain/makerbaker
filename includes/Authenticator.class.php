<?php @session_start();

class Authenticator {
	
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

	public function setBoardMember($isMember) {
		$_SESSION["board"] = $isMember;
	}
	public function isBoardMember() {
		return $_SESSION["board"];
	}

	public function requireBoardUser() {
		$this->requireAuthenticatedUser();
		if ( !$this->isBoardMember() ) {
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
