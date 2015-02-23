<?php require_once("app.php");
$auth = new Authenticator();
$auth->requireAuthenticatedUser();
echo($template["header"]);
?>

<div class="row"><div class="col-md-3"></div><div class="col-md-6">

<div class="row">
	<div>
		<h1>Door unlock status</h1>
	</div>
</div>
<div class="row">
        <div>
		<p><?php
			if ( $_REQUEST["status"] === "notatshop" ) {
				echo("You have to be at the shop to unlock the door. (You'll need to access this from a device connected to Wi-Fi.)");
			} else {
				echo("<pre>" . $_REQUEST["out"] . "</pre>");
			}
		?></p>
        </div>
</div>
<div class="row">
	<div>
		<form action=".">
			<button type="submit">k</button>
		</form>
	</div>
</div>

</div>
<?php echo($template["footer"]); ?>

