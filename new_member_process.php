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
		<h1>Submit a New Member Application</h1>
	</div>
</div>

    <form class="form-horizontal" action="new_member_process_submit.php" method="POST">
<?php
generateFormInput("name", "text", "Full Name");
generateFormInput("phone", "tel", "Phone");
generateFormInput("emergency_name", "text", "Emergency Contact Name");
generateFormInput("emergency_phone", "tel", "Emergency Contact Phone");
generateFormInput("username", "text", "Desired Username");
generateFormInput("monthly_pledge", "number", "Monthly Pledge Amount");
generateFormInput("email", "email", "Email Address");
generateFormInput("board1", "select", "Board Sponsor #1", $board_members);
generateFormInput("board2", "select", "Board Sponsor #2", $board_members);
generateFormInput("pronoun", "radio", "Desired Pronoun", array("his", "her", "other"));
generateFormInput("btn", "submit", "Submit application", "Submit");
?>
    </form>

</div>

<?php echo($template["footer"]); ?>

