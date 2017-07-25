<?php require_once("app.php");
$auth = new Authenticator();
$auth->requireMemberOf('board');
$board_members = $ldap->getGroupMembers("board");
if ($board_members === false) {
	die('Unable to retrieve board members from LDAP');
}
echo($template["header"]);
?>

<div class="row"><div class="col-sm-2"></div><div class="col-sm-8">

<div class="row">
	<div>
		<h1>End the Vote for a New Member Application</h1>
	</div>
</div>

    <form class="form-horizontal" action="new_member_vote_end_submit.php" method="POST">
<?php
TemplateEngine::generateFormInput("pending_member", "select", "Pending Member", true, getPendingMembers());
foreach ($board_members as $board_member) {
	TemplateEngine::generateFormInput($board_member["uid"][0], "select", $board_member["cn"][0], true, $vote_options['proposal']);
}
TemplateEngine::generateFormSubmit("Submit");
?>
    </form>

</div>

<?php echo($template["footer"]); ?>

