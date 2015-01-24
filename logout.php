<?php
session_start();
session_destroy();
header("Location: .");
//header("Location: " . $_SERVER['HTTP_REFERER']);
?>
