<?php require_once("app.php");
$auth = new Authenticator();
$auth->requireAuthenticatedUser();
echo($template["header"]);
?>

<div class="row"><div class="col-sm-2"></div><div class="col-sm-8">

<div class="row">
	<div>
		<h1>Member Information</h1>
	</div>
</div>
<style type="text/css">
th {
	text-align: center;
}
</style>

<table border="1px">
<tr>
<th>name</th>
<th>nick</th>
<th>email</th>
<th>phone</th>
<?php
if ($auth->isMemberOf('board')) {
?>
<th>usbserial</th>
<th>nfcid</th>
<?php
}
?>
</tr>
<?php
$members = $ldap->getGroupMembers("makers");
foreach ($members as $member) {
	echo("<tr>");
	echo("<td>".$member['displayname'][0]."</td>\n");
	echo("<td>".$member['uid'][0]."</td>\n");
	echo("<td>".$member['mail'][0]."</td>\n");
	echo("<td>");
	if (array_key_exists("telephonenumber", $member)) {
		for ($i = 0; $i < $member['telephonenumber']['count']; $i+=1) {
			echo($member['telephonenumber'][$i]."<br/>\n");
		}
	}
	echo("</td>");
	if ($auth->isMemberOf('board')) {
		echo("<td>");
		if (array_key_exists("usbserial", $member)) {
			for ($i = 0; $i < $member['usbserial']['count']; $i+=1) {
				echo($member['usbserial'][$i]."<br/>\n");
			}
		}
		echo("</td>");
		echo("<td>");
		if (array_key_exists("nfcid", $member)) {
			for ($i = 0; $i < $member['nfcid']['count']; $i+=1) {
				echo($member['nfcid'][$i]."<br/>\n");
			}
		}
		echo("</td>");
		// full dump for debugging
		/*echo("<td>");
		foreach ($member as $key => $value) {
			echo($key.":<br/>\n");
			foreach ($value as $innerk => $innerv) {
				echo("&nbsp;&nbsp;".$innerk.": ".$innerv."<br/>\n");
			}
		}
		echo("</td>");*/
	}
	echo("</tr>");
}
?>
</table>

</div>

<?php echo($template["footer"]); ?>

