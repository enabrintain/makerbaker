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

if ( strlen($_REQUEST["next"]) == 0 ) die(header("Location: ."));
die(header("Location: " . str_replace(array('.', ':'), '' , $_REQUEST["next"])));

//if we made it here something crazy is going on
die(header("Location: ./?status=unknownError&uid=" . $uid));

?>
