<?
if($_POST["lang"] == ""){
$ext="";
$ext_page="";
}else{
$ext="_en";
$ext_page="_en";
}
include "../../logs/function.php";
if (!trim($_POST["name"]) == "" and  $_POST['email']!=""){
if($_COOKIE["register"] == ""){
//setcookie("register","ok");
         $arr =array($_POST['name'],$_POST['email'], $_POST["title"], $_POST["specialty"], $_POST["organization"], $_POST["country"], $_POST["city"], date('Y-m-d  H:i:s'));
         AddUpdate("register","",$arr,"","");
}
include "../../mails/send_register.php";

exit;
}else{
	?>
			<script language="javascript">
				alert("Thank you for your register for our website.");
				location.href="../../Home Page";
			</script>

    <?
exit;
}
?>