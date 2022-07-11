<?
session_start();
session_destroy();
//setcookie("name", "");
//setcookie("pass", "");
header("location:index.php");
exit;
?>