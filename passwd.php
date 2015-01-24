<?php require_once("app.php");
$auth = new Authenticator();
$auth->requireAuthenticatedUser();
echo($template["header"]);
?>

<div class="row"><div class="col-sm-2"></div><div class="col-sm-8">

<div class="row">
	<div>
		<h1>Change your password</h1>
		<p>Passwords are case-sensitive.</p>
	</div>
</div>
<!--
<div class="row">
        <div>
		<p>Passwords are case-sensitive.</p>
        </div>
</div>
-->

    <form class="form-horizontal" action="passwd_change.php" method="POST">
	<div class="form-group">
		<label class="col-sm-4 x control-label" for="old">Your current password</label>
		<div class="col-sm-8">
			<input class="form-control" type="password" name="old" placeholder="*****************************">
		</div>
	</div>
	<div class="form-group">
                <label class="col-sm-4 x control-label" for="new">Your desired password</label>
                <div class="col-sm-8">
			<input class="form-control" type="password" name="new" placeholder="*****************************">
		</div>
        </div>
        <div class="form-group">
                <label class="col-sm-4 x control-label" for="new_confirm">Again</label>
		<div class="col-sm-8">
	                <input class="form-control" type="password" name="new_confirm" placeholder="*****************************">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-4 x control-label" for="btn">If you are ready to proceed with this...</label>
		<div class="col-sm-8">
			<input type="submit" name="btn" value="Do it">
		</div>
        </div>
    </form>

</div>

<?php echo($template["footer"]); ?>

