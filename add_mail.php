<?
if($_COOKIE["register"] == ""){
    setcookie("register","ok");
}

?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<?

if(preg_match("/en\//",$_SERVER["HTTP_REFERER"])){
    $ext="en/";
    $ext_page="en/  ";
    $message = "Thank you for your subscription. ";
}else{
    $ext="";
    $ext_page="ar/";
    $message = "شكراً لاشتراكك معنا.";
}
include "logs/function.php";
secure_website();
$email = strip_tags($_POST['email']);
$email =  mysqli_real_escape_string2($email);
$qc= mysqli_query2("select * from emails where email like '".$email."'");

if (!trim($_POST["email"]) == "" ){
    if($_COOKIE["register"] =="" and mysqli_affected_rows2()< 1){
             $arr =array($email,"0");
             AddUpdate("emails","",$arr,"","");

    }
}
	?>
			<script language="javascript">
				alert("<?=$message?>");
				location.href="<?=$ext_page?>";
			</script>

    <?


?>
</body>
</html>