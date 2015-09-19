<?php require_once("app.php");

//LDAP emits warnings and it ruins our headers
//error_reporting(0); ini_set("display_errors","FALSE");


if( !(array_key_exists("uid",$_REQUEST) && array_key_exists("password",$_REQUEST)) ) {
	die("Login request was invalid." . $config["error_text"]);
}

$uid = urlencode($_REQUEST["uid"]);
$password = $_REQUEST["password"];

//check login
try {
	$ldap = new Ldap("uid=" . $uid . "," . LdapInfo::base_dn,  $password);
} catch (ErrorException $e) {
	//wrong login
	die(header("Location: ./login.php?status=loginFailed&uid=" . $uid));
}

$auth = new Authenticator();
$auth->setCurrentUid($uid);
$user = $ldap->getUserFromUid($uid);
function getBoardObject($ldap) {
	$board_filter = "cn=board";
	$r = $ldap->search($board_filter, "ou=groups,dc=makerslocal,dc=org");
	if ( $r["count"] > 0 ) { return $r[0]; }
	return false;
}
$board_group = getBoardObject($ldap);
$auth->setBoardMember(false);
for ($i = 0; $i < $board_group["uniquemember"]["count"]; $i+=1) {
	$board_member = $board_group["uniquemember"][$i];
	if (strcmp($board_member, $user["dn"])) {
		continue;
	}
	$auth->setBoardMember(true);
}
if ( strlen($_REQUEST["next"]) == 0 ) die(header("Location: ."));
die(header("Location: " . str_replace(array('.', ':'), '' , $_REQUEST["next"])));

//if we made it here something crazy is going on
die(header("Location: ./?status=unknownError&uid=" . $uid));

?>
