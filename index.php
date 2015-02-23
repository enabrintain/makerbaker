<?php require_once("app.php");
$auth = new Authenticator();
$auth->requireAuthenticatedUser();
echo($template["header"]);
?>

<div class="row">
	<div class="col-sm-3"></div>
	<div class="col-sm-6">

<h1>Your account</h1>
<!-- <p>If it isn't a link, the functionality hasn't been written yet. Sorry about that.</p> -->

<h3><a href="unlock.php">Unlock the door to the shop</a></h3>
<h3><a href="passwd.php">Change your password</a></h3>
<!--
<h3><a href="nfc.php">Register an NFC tag</a></h3>
<h3>Deregister an NFC tag</h3>
<h3>Register a USB key</h3>
<h3>Deregister a USB key</h3>
-->
<h3><a href="logout.php">Log out of this service</a></h3>

	</div>
</div>


<?php echo($template["footer"]); ?>

