<?php

//complain loudly about errors if we are on dev.
if ( array_shift(explode('.',gethostname())) == "dev" ) {
	error_reporting(-1); ini_set("display_errors","TRUE");
}

//automatically include undefined objects 
spl_autoload_register(function ($class) {
	$filename = 'includes/' . $class . '.class.php';
	if ( file_exists($filename) ) {
		require_once($filename);
	} else {
		require_once('../' . $filename);
	}
});

//config
$config = array();
$config["app_name"] = "Maker Baker";
$config["app_path"] = ".";
$config["error_text"] = " Contact the netadmins at netadmin@lists.makerslocal.org for help with this.";
$config["timeout"] = 60;
$config["local"] = "10.56."; //if your IP starts with this, you're at the shop

//emails
$config["email_admins"] = "hfuller@pixilic.com";
$config["email_members"] = "hunterf@makerslocal.org";

//templates
$template = array();
$template["header"] = '<!DOCTYPE html>
<html lang="en">
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>' . $config["app_name"] . '</title>

        <!-- css -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/app.css" rel="stylesheet">


</head>
<body>
<img id="logo" src="img/makerbaker.svg">
';
$template["footer"] = '';

$vote_options = array();
$vote_options['proposal'] = array("Yea", "Nay", "Explicit Abstain", "Passive Abstain");
$vote_options['formal_complaint'] = array("Yea", "Nay", "Explicit Abstain", "Passive Abstain", "Forced Abstain");

//important objects
$ldap = new Ldap();

function getPendingMembers() {
	$results_array = array();
	$ldap = new Ldap(); //HACK HACK HACK
	$results = $ldap->search("objectclass=Pending");
	for ($i = 0; $i < $results['count']; $i+=1) {
		array_push($results_array, $results[$i]);
	}
	return $results_array;
}
