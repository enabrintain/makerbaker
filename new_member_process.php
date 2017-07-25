<?php require_once("app.php");
$auth = new Authenticator();
$auth->requireMemberOf('board');

$board_members = $ldap->getGroupMembers("board");
if ($board_members === false) {
	die('Unable to retrieve board members from LDAP');
}
$board_members = array_map(function($el){
	return($el["cn"][0]);
}, $board_members);


echo($template["header"]);
?>

<div class="row"><div class="col-sm-2"></div><div class="col-sm-8">

<div class="row">
	<div>
		<h1>Submit a New Member Application</h1>
	</div>
</div>

    <form name="application_form" class="form-horizontal" action="new_member_process_submit.php" method="POST">
<?php
TemplateEngine::generateFormInput("name", "text", "Full Name", true);
TemplateEngine::generateFormInput("phone", "tel", "Phone", true);
TemplateEngine::generateFormInput("emergency_name", "text", "Emergency Contact Name", true);
TemplateEngine::generateFormInput("emergency_phone", "tel", "Emergency Contact Phone", true);
TemplateEngine::generateFormInput("username", "text", "Desired Username", true);
TemplateEngine::generateFormInput("donation", "number", "Monthly Donation", true, 1);
TemplateEngine::generateFormInput("email", "email", "Email Address", true);
TemplateEngine::generateFormInput("board1", "select", "Board Sponsor #1", true, $board_members);
TemplateEngine::generateFormInput("board2", "select", "Board Sponsor #2", true, $board_members);
TemplateEngine::generateFormInput("pronoun", "radio", "Desired Pronoun", true, array("his", "her", "other"));
TemplateEngine::generateFormSubmit("Submit");
?>
    </form>

<script type="text/javascript">
var board2 = document.forms["application_form"]["board2"];
board2.setAttribute("onchange", "checkValid()");
var board1 = document.forms["application_form"]["board1"];
board1.setAttribute("onchange", "checkValid()");
board1.setCustomValidity("");
function checkValid() {
    var board2_element = document.forms["application_form"]["board2"];
    var board1 = document.forms["application_form"]["board1"].value;
    var board2 = board2_element.value;
    if (board1 == board2) {
        board2_element.setCustomValidity("Board members must be different");
        return false;
    } else {
        board2_element.setCustomValidity("");
        return true;
    }
}
checkValid();
</script>
</div>

<?php echo($template["footer"]); ?>

