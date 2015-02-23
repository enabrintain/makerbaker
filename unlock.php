<?php require_once("app.php");
$auth = new Authenticator();
$auth->requireAuthenticatedUser();

if ( 0 !== strpos($_SERVER["REMOTE_ADDR"],$config["local"]) ) {
	//you have to be at the shop to unlock the door
	header("Location: unlock_done.php?status=notatshop");
	die("you have to be at the shop to unlock the door.");
}

echo($template["header"]);
?>

<div class="row"><div class="col-sm-2"></div><div class="col-sm-8">

<div class="row">
        <div>
		<h1>Unlock the door</h1>
		<p>When you click the button below, the shop's door will unlock. Only do this if you're standing in front of the door right now!</p>
	</div>
</div>

<form class="form-horizontal" action="connect_ready.php">
	<input type="text" name="type" value="unlock" style="display:none;">
	<div class="form-group">
		<label class="col-sm-4 x control-label" for="btn">Are you sure you want to unlock the door right now at this very exact moment?!</label>
		<div class="col-sm-8">
			<input type="submit" name="btn" value="Yes. Let me in!">
		</div>
	</div>
</form>

<?php echo($template["footer"]); ?>

