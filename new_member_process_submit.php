<?php require_once("app.php");
$auth = new Authenticator();
$auth->requireBoardUser();

// XXX add member to pending tab

// XXX send vote announcement emails

// XXX send potential member notification email

// XXX add calendar events for voting

die(header("Location: ./index.php"));
?>
