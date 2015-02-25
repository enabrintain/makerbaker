<?php
require_once("app.php");
$auth = new Authenticator();
$auth->requireUnauthenticatedUser();
echo($template["header"]);
?>

<div class="row"><div class="col-md-3"></div><div class="col-md-6">

<h1><?php echo $config["app_name"]; ?></h1>
<form action="login_target.php?next=<?php if ( array_key_exists("next",$_REQUEST) ) { echo urlencode($_REQUEST["next"]); } ?>" method="POST" class="form-horizontal">
	<fieldset>
		<legend>Please authenticate (LDAP) in order to use this tool.</legend>
		<p>
		<?php
			if (array_key_exists("status",$_REQUEST)) {
				if ( $_REQUEST["status"] == "loginFailed" ) {
					echo("Those credentials seemed to be incorrect.");
				} else {
					echo("Authentication failed for some reason." . $config["error_text"]);
				}
			} else {
				echo('You use this login for the wiki, donation system, and Web site.');
			}
			?>
		</p>

		<div class="form-group">
			<label for="uid">LDAP uid</label>
			<input name="uid" type="text" placeholder="hfuller" required <?php
				if (array_key_exists("uid",$_REQUEST)) {
					echo(' value="' . urlencode($_REQUEST["uid"]) . '"');
				}
				?>>
		</div>

		<div class="form-group">
			<label for="password">Password</label>
			<input name="password" type="password" placeholder="*************************" required>
		</div>
				
		<button type="submit">Submit</button>
	</fieldset>
</form>

</div>

<?php echo($template["footer"]); ?>
