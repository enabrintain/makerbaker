<?php require_once("app.php");
$auth = new Authenticator();
$auth->requireAuthenticatedUser();

$uid = $_SESSION["uid"];
$password = $_REQUEST["old"];

//check login
try {
	$user_ldap = new Ldap("uid=" . $uid . "," . LdapInfo::base_dn,  $password);
} catch (ErrorException $e) {
	//wrong login
	die(header("Location: ./passwd_done.php?status=loginFailed"));
}

if ( $_REQUEST["new"] !== $_REQUEST["new_confirm"] ) {
	die("Your new password fields didn't match and I'm too lazy to make a proper error message.");
}
if ( $_REQUEST["new"] == "" ) {
	die("Not only did you not enter a password, you didn't enter a password and then you didn't enter it again. Well done.");
}

//HACK to make LDAP password changeable - users can't change their own passwords atm
//using global admin ldap

$ldap->changePassword($uid,$_REQUEST["new"]);
die(header("Location: ./passwd_done.php?status=success"));

//if we made it here something crazy is going on
die(header("Location: ./passwd_done.php?status=unknownError"));

?>
