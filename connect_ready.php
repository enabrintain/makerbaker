<?php require_once("app.php");
$auth = new Authenticator();
$auth->requireAuthenticatedUser();
echo($template["header"]);
?>
<meta http-equiv="refresh" content="1; url=connect.php?type=<?php echo(escapeshellcmd($_REQUEST["type"])); ?>">
<h1>Contacting the automaton, please wait.</h1>
<?php echo($template["footer"]); ?>
