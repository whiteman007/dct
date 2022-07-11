<?
if($_COOKIE["register"] == ""){
    setcookie("register","ok");
}
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<?
if($_POST["lang"] == ""){
$ext="";
$ext_page="";
}else{
$ext="_en";
$ext_page="_en";
}
include "../../logs/function_2.php";
$email =  mysqli_real_escape_string($GLOBALS["db_link"],$_POST['email']);
$qc= mysqli_query2("select * from emails where email like '".$email."'");
if (!trim($_POST["email"]) == "" ){
if($_COOKIE["register"] == "" and mysqli_affected_rows($GLOBALS["db_link"])< 1){

         $arr =array($email);
         $BaseMain->AddUpdate("emails","",$arr,"","");
}
}
	?>
			<script language="javascript">
				alert("تم الارسال بنجاح, شكراً لك.");
				location.href="../../الصفحة الرئيسية";
			</script>

    <?


?>
</body>
</html>