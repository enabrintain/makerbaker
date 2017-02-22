<?php require_once("app.php");
$auth = new Authenticator();
$auth->requireBoardUser();

function checkRequest($field) {
	if ( ! array_key_exists($field, $_REQUEST) || trim($_REQUEST[$field]) == "") {
	        die($field." not valid");
	}
}

// validate inputs
$validates = array(
	"name",
	"phone",
	"emergency_name",
	"emergency_phone",
	"username",
	"donation",
	"email",
	"board1",
	"board2",
	"pronoun");
foreach ($validates as $validate) {
	checkRequest($validate);
}
if (!strcmp($_REQUEST['board1'], $_REQUEST['board2'])) {
	die("board sponsors must be different");
}
$donation = intval($_REQUEST['donation']);
if ($donation <= 0) {
	die("donation must be positive");
}

$pronoun = $_REQUEST['pronoun'];
if (!strcmp($pronoun, "other")) {
	checkRequest("pronoun_other");
	$pronoun = $_REQUEST['pronoun_other'];
}

// XXX add member to pending tab
$add_row_cmd = "addrow.py"
                . " --date " . date('m/d/Y', time())
                . " --name '" . $_REQUEST["name"] . "'"
                . " --number " . $_REQUEST["phone"]
                . " --emergencyname '" . $_REQUEST["emergency_name"] . "'"
                . " --emergencynumber " . $_REQUEST["emergency_phone"]
                . " --user " . $_REQUEST["username"]
                . " --donation '" . $donation . "'"
                . " --email " . $_REQUEST["email"]
                . " --board1 '" . $_REQUEST["board1"] . "'"
                . " --board2 '" . $_REQUEST["board2"] . "'"
                . " --infile /tmp/membership.xlsx"
                . " --outfile /tmp/membership_tweak.xlsx";

$debug = true;
$mail_sender = '"Makers Local 256 Secretary" <secretary@makerslocal.org>';
if ($debug) $mail_sender = '"Makers Local 256 Secretary" <root@veighln>';
$mail_info_recipient = $_REQUEST['email'];
if ($debug) $mail_info_recipient = "root@veighln";
$mail_info_subject = "Makers Local 256 has received your membership application";
$mail_info_body = "Dear ".$_REQUEST['name'].",

Everyone at Makers Local 256 would like to thank you for your membership application. We will be voting on it three days from now and the vote will be final five days after that (a total of 8 days).

Makers Local 256 feels that membership isn't just about having your name on some paperwork. Its more about learning, teaching, and discovering new ideas as well as socializing with like minded individuals. That is why we would like to invite you to check out our wiki ( https://256.makerslocal.org/wiki ), collaborate on projects or stop by the shop whenever it's open. A good way to find out if the shop is open is to check the cams ( https://256.makerslocal.org/camera ), ask in chat ( irc.freenode.net #makerslocal ), ask on the general mailing list ( https://lists.makerslocal.org/mailman/listinfo/general ), or stop by on Saturday afternoons.

Again thank you for your application, we all look forward to seeing what interesting projects you come up with.

Makers Local 256 Secretary,

Kinsey Moore";
// send potential member notification email
if (mail($mail_info_recipient, $mail_info_subject, $mail_info_body, "From: ".$mail_sender)) {
	if ($debug) echo("Mail sent");
} else {
	if ($debug) echo("Mail not sent");
}



$mail_announce_recipient = "makers@lists.makerslocal.org";
if ($debug) $mail_announce_recipient = "root@veighln";
$mail_announce_subject = "Membership Application - ".$_REQUEST['name'];
$mail_announce_body = "Hello Makers,

We have a new person applying to become a member - ".$_REQUEST['name'].". Tonight begins public discussion about ".$pronoun." membership application, so now is the time for any praise or objections. You may comment publicly to the makers list or privately to the board list if you wish to remain anonymous. After 3 days begins the board's voting, and 5 days after that the vote will be announced.

This application was sponsored by ".$_REQUEST['board1']." and ".$_REQUEST['board2'].". Could those that signed tell us a little more about our applicant?

Your secretary,
Kinsey Moore";
// send vote announcement emails
if (mail($mail_announce_recipient, $mail_announce_subject, $mail_announce_body, "From: ".$mail_sender)) {
	if ($debug) echo("Mail sent");
} else {
	if ($debug) echo("Mail not sent");
}

// add calendar events for voting
function addCalendarEvent($title, $time, $description) {
	return "gcalcli --cal 'ML256 Board' --title '".$title."' --when '".$time."'"
		." --descr '".$description."' --where 'The Board List' --duration 60 --reminder 30 add";
}
// XXX actually do something with this
addCalendarEvent($_REQUEST['name']." Membership Vote Begin", date("m/d/Y H:i", strtotime("+3 days")), "The five day vote begins!");
addCalendarEvent($_REQUEST['name']." Membership Vote End", date("m/d/Y H:i", strtotime("+8 days")), "The five day vote ends!");

if (!$debug) die(header("Location: ./index.php"));
?>
