<?php require_once("app.php");
$auth = new Authenticator();
$auth->requireAuthenticatedUser();

if ($_REQUEST["type"] === "unlock") {
	if ( 0 !== strpos($_SERVER["REMOTE_ADDR"],$config["local"]) ) {
		#we are not at the shop
		die("You can't do this when you're not at the shop.");
	}
	$cmd = "timeout 6 ssh -tt makerbaker@doorpi \"sudo /home/pi/DoorAuth/DoorAuth1.7/src/CLI_Unlock.py " . $_SESSION["uid"] . "\"";
	$ret = exec($cmd);
	if ( strlen($ret) > 0 ) {
		header("Location: unlock_done.php?status=done&out=" . $ret);
	} else {
		die("Couldn't connect to the machine. So sorry.");
	}
}

