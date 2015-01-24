<?php require_once("app.php");
$auth = new Authenticator();
$auth->requireAuthenticatedUser();
echo($template["header"]);
?>

<div class="row"><div class="col-md-3"></div><div class="col-md-6">

<div class="row">
	<div>
		<h1>Password change status</h1>
	</div>
</div>
<div class="row">
        <div>
		<p><?php
			if ( $_REQUEST["status"] == "success" ) {
				echo("You changed your password. Congrats.");
			} else if ( $_REQUEST["status"] == "loginFailed" ) {
				echo("You didn't type your old password correctly, so I couldn't change your password.");
			} else {
				echo('Something went horribly, horribly wrong. Please email <a href"mailto:netadmin@lists.makerslocal.org">the netadmins.</a>');
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

