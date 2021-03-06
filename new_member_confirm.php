<?php require_once("app.php");
$auth = new Authenticator();
$auth->requireMemberOf('board');
echo($template["header"]);
?>

<div class="row"><div class="col-sm-2"></div><div class="col-sm-8">

<div class="row">
	<div>
		<h1>End the Vote for a New Member Application</h1>
	</div>
</div>

    <form class="form-horizontal" action="new_member_confirm_submit.php" method="POST">
<?php
$pending_members = array_map(function($x) {
	        return $x['cn'][0];
}, $ldap->getObjectClassMembers("Friend"));

TemplateEngine::generateFormInput("pending_member", "select", "Pending Member", true, $pending_members);
TemplateEngine::generateFormSubmit("Confirm");
?>
    </form>

</div>

<?php echo($template["footer"]); ?>

