<?php require_once("app.php");
$auth = new Authenticator();
$auth->requireAuthenticatedUser();
echo($template["header"]);
?>

<div class="row">
	<div class="col-sm-3"></div>
	<div class="col-sm-6">

		<h1>Your account</h1>
		<!-- <p>If it isn't a link, the functionality hasn't been written yet. Sorry about that.</p> -->

		<h3><a href="unlock.php">Unlock the door to the shop</a></h3>
		<h3><a href="passwd.php">Change your password</a></h3>
		<!--
		<h3><a href="nfc.php">Register an NFC tag</a></h3>
		<h3>Deregister an NFC tag</h3>
		<h3>Register a USB key</h3>
		<h3>Deregister a USB key</h3>
		-->
		<h3><a href="logout.php">Log out of this service</a></h3>
<?php
if ($auth->isBoardMember()) {
?>
		<h1>Secretarial Tasks</h1>
		<h3><a href="new_member_process.php">Process a new member application</a>:</h3>
		<ul>
			<li>adds the member to the pending tab on the member spreadsheet</li>
			<li>sends vote announcement emails</li>
			<li>adds calendar events for voting</li>
		</ul>
		<h3><a href="new_member_vote_end.php">End the vote for a member application</a>:</h3>
		<ul>
			<li>takes a vote tally for the selected member</li>
			<li>sends out vote end email for the selected member</li>
			<li>if the vote passed, it sends an email to root@makerslocal.org with member details</li>
			<li>if the vote failed, removes the selected member from pending</li>
		</ul>
		<h3><a href="new_member_confirm.php">Confirm that a new member has an account</a>:</h3>
		<ul>
			<li>moves the selected pending member to current members tab on the spreadsheet</li>
		</ul>
<?php
}
?>

	</div>
</div>


<?php echo($template["footer"]); ?>

