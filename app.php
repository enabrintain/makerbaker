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

function proposalVotePassed($responses) {
	$num_yea = count($responses['Yea']);
	$num_nay = count($responses['Nay']);
	if ($num_nay > 1 || $num_nay >= $num_yea) {
		return false;
	}
	return true;
}

function complaintVotePassed($responses) {
	$num_yea = count($responses['Yea']);
	$num_nay = count($responses['Nay']);
	if ($num_nay >= $num_yea) {
		return false;
	}
	return true;
}

function getBoardObject($ldap) {
	$board_filter = "cn=board";
	$r = $ldap->search($board_filter, "ou=groups,dc=makerslocal,dc=org");
	if ( $r["count"] > 0 ) { return $r[0]; }
	return false;
}

function getNameFromDn($ldap, $dn) {
	$r = $ldap->search(explode(',', $dn)[0]);
	if ( $r["count"] == 0 ) { return false; }
	$user = $r[0];
	return $user['cn'][0];
}

function getBoardList() {
	try {
		$ldap = new Ldap();
	} catch (ErrorException $e) {
		//wrong login
		die('LDAP connection failed');
	}
	$board_members = array();
	$board_group = getBoardObject($ldap);
	for ($i = 0; $i < $board_group["uniquemember"]["count"]; $i+=1) {
		$board_member = $board_group["uniquemember"][$i];
		$member_name = getNameFromDn($ldap, $board_member);
		if ($member_name === false) {
			return false;
		}
		array_push($board_members, $member_name);
	}
	return $board_members;
}

function getMemberList() {
	try {
		$ldap = new Ldap();
	} catch (ErrorException $e) {
		//wrong login
		die('LDAP connection failed');
	}

	$results_array = array();
	$results = $ldap->search("objectclass=Maker");
	for ($i = 0; $i < $results['count']; $i+=1) {
		array_push($results_array, $results[$i]);
	}
	return $results_array;
}

function generateFormSubmit($btn_text=null) {
?>
<div class="form-group">
	<label class="col-sm-4 x control-label"> </label>
	<div class="col-sm-8">
		<input type="submit" <?php if ($btn_text != null) echo('value="'.$btn_text.'"'); ?>/>
	</div>
</div>
<?php
}

function generateFormInput($name, $type, $label, $required=false, $input_extra=null) {
	$required_text = "";
	if ($required) {
		$required_text = " required";
	}
?>
<div class="form-group">
	<label class="col-sm-4 x control-label" for="<?php echo($name); ?>"><?php echo($label); ?></label>
	<div class="col-sm-8">
<?php
	if (strcmp($type, "radio") && strcmp($type, "select")) {
		echo('<input class="form-control" type="'.$type.'" name="'.$name.'"');
		if ($input_extra != null) {
			if (!strcmp($type, "password")) {
				echo(' placeholder="'.$input_extra.'"');
			}
			if (!strcmp($type, "number")) {
				echo(' min='.$input_extra);
			}
		}
		echo($required_text." />");
	} else if (!strcmp($type, "radio")) {
		foreach ($input_extra as $option) {
?>
		<input id="<?php echo($type.$name.$option); ?>" type="radio" name="<?php echo($name); ?>" value="<?php echo($option); ?>"<?php echo($required_text); ?>>
			<label for="<?php echo($type.$name.$option); ?>">
<?php
			echo($option);
			if (!strcmp($option, "other")) {
?>
				<input class="form-control" type="text" name="<?php echo($name); ?>_other"/>
<?php
			}
?>
			</label>
		</input><br/>
<?php
		}
	} else if (!strcmp($type, "select")) {
?>
		<select class="form-control" name="<?php echo($name); ?>">
<?php
		foreach ($input_extra as $option) {
			echo('<option value="'.$option.'">'.$option.'</option>');
		}
?>
		</select>
<?php
	}
?>
	</div>
</div>
<?php
}

function sanitizeName($name) {
	$name = str_replace(",", "_", $name);
	$name = str_replace(" ", "_", $name);
	$name = str_replace("'", "_", $name);
	$name = str_replace('"', "_", $name);
	return $name;
}

function getPendingMembers() {
	try {
		$ldap = new Ldap();
	} catch (ErrorException $e) {
		//wrong login
		die('LDAP connection failed');
	}

	$results_array = array();
	$results = $ldap->search("objectclass=Pending");
	for ($i = 0; $i < $results['count']; $i+=1) {
		array_push($results_array, $results[$i]);
	}
	return $results_array;
}
