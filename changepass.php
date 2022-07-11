<?
include "cookie.php";
$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];
if($pass1 == "" || $pass2 == ""){
header("location:"."process.php?err=1");
exit;
}
if($pass1 != $pass2){
header("location:"."process.php?err=4");
exit;
}
if($r_c_admin['t_pass'] != base64_encode($_POST['admin_pass'])){
header("location:"."process.php?err=16");
exit;
}

mysqli_query2("update t_users	 set t_pass = '". base64_encode($pass1)."'  ,t_username = '".strip_tags($_POST["admin_name"])."' where id=".$r_c_admin['id']) or die('dasdas');
session_destroy();
header("location:"."index.php?pass=ok");
?>
