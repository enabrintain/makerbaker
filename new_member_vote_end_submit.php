<?php require_once("app.php");
$auth = new Authenticator();
$auth->requireBoardUser();

// setup mapping from sanitized name to real name
$board_members = getBoardList();
$board_mapping = array();
foreach ($board_members as $board_member) {
	$board_mapping[sanitizeName($board_member)] = $board_member;
}

$pending_member = $_REQUEST['pending_member'];

// get list of possible responses
$responses = array();
foreach ($vote_options['proposal'] as $response) {
	$responses[$response] = array();
}

// collate responses
foreach ($_REQUEST as $key => $value) {
	if (!strcmp($key, "btn") || !strcmp($key, "pending_member")) {
		continue;
	}
	array_push($responses[$value], $board_mapping[$key]);
}

// render responses
$tally = "";
foreach ($responses as $response => $response_list) {
	if (count($response_list) > 0) {
		$tally .= $response.": ".implode(", ", $response_list)."\n";
	}
}

$vote_passed = proposalVotePassed($responses);
$vote_passed_text = "failed";
if ($vote_passed) {
	$vote_passed_text = "passed";
}

// XXX set signage properly
$signage = "BOARD1 and BOARD2 signed";

// XXX sent out vote end email
$email_title = "Vote End: Membership Application - ".$pending_member;
$email_body =
"Hello Makers,

The vote for ".$pending_member."'s membership has concluded and this proposal has ".$vote_passed_text.".

The board's votes are as follows:
".$tally."

".$signage." the application.

Your secretary,
Kinsey Moore";

echo("Vote end email:\n".$email_title."\n".$email_body."\n\n\n\n");

// select mailing address based on debug mode
//auto mail_from = Recipient(gmail_username~"@gmail.com", "Makers Local 256 Secretary");
//auto members_recipients = [Recipient("makers@lists.makerslocal.org", "Members")];


// determine pass/fail
if ($vote_passed) {
	// XXX send out email to root with details
	// XXX get info from spreadsheet
	$admin_title = "Vote Ended for ".$pending_member;
//string[]headers = ["Index", "Date", "Name", "Number", "Emergency Number", "Emergency Name", "Nickname", "Donation", "Email", "Signatories"];
//auto info = map!"a[0]~\": \"~a[1]"(zip(headers, selected_member));
	$info = "ALL THE MEMBER INFORMATION";
	$admin_body =
"Hi Admins!

".$pending_member." needs an account and this person's information is as follows:

".$info."

Courtesy of your lazy secretary's automated assistant";

// select mailing address based on debug mode
//auto admin_recipients = [Recipient("root@makerslocal.org", "Root")];
	echo("Admin email:\n".$admin_title."\n".$admin_body."\n\n");
} else {
	// XXX remove person from pending
}

//die(header("Location: ./index.php"));
?>
