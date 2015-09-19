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
<?php
generateFormInput("old", "password", "Your current password", "*****************************");
generateFormInput("new", "password", "Your desired password", "*****************************");
generateFormInput("new_confirm", "password", "Again", "*****************************");
generateFormInput("btn", "submit", "If you are ready to proceed with this...", "Do it");
?>
    </form>

</div>

<?php echo($template["footer"]); ?>

