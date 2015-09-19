<?php require_once("app.php");
$auth = new Authenticator();
$auth->requireBoardUser();
$board_members = getBoardList();
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
generateFormInput("pending_member", "select", "Pending Member", getPendingMembers());
foreach ($board_members as $board_member) {
	generateFormInput(sanitizeName($board_member), "select", $board_member, $vote_options['proposal']);
}
generateFormInput("btn", "submit", "Submit vote", "Submit");
?>
    </form>

</div>

<?php echo($template["footer"]); ?>

