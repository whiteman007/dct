<?
include "../logs/function.php";
$q=mysqli_query2("delete from emails where id='".intval($_GET["id"])."'");

header("location:send_create.php");
exit;
///تعليق
?>
