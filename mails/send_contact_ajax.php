<?
//session_start();
//$_COOKIE["send_once"] = "ok";
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<?
if ( !trim($_POST["name"]) == "" && $_COOKIE["send_once"] !="ok"){
/*
if (empty($_SESSION['captcha']) || trim(strtolower($_REQUEST['captcha'])) != $_SESSION['captcha']) {
    //unset($_SESSION['captcha']);
    ?>
    <script language="javascript">
        alert("Confirmation Code Error ...");
        history.go(-1);
    </script>
<?
die();
}
*/
$name = $_POST["name"];
$to = "info@dadoush.com.eg";
$subject = "Inquiry from $name";

$body= "
<div dir='rtl' align='right' class='text'>========================</div>";
$body .= "<div dir='rtl' align='right' class='text'><b>لقد تلقيت رسالة من   :</b> ".$_POST[name]."</div>";
$body .= "<div dir='rtl' align='right' class='text'><b>الإسم : </b>".$_POST['name']."</div>";
$body .= "<div dir='rtl' align='right' class='text'><b>البريد الالكتروني : </b>".$_POST['email']."</div>";
$body .= "<div dir='rtl' align='right' class='text'><b>رقم الهاتف: </b>".$_POST['phone']."</div>";
$body .= "<div dir='rtl' align='right' class='text'><b>العنوان : </b>".$_POST['address']."</div>";
if($_POST['comment'] !=""){
	$body .= "<div dir='rtl' align='right' class='text'><b>التعليق :</b><br> ".nl2br($_POST['comment'])."</div>";
}

$body .= "<div dir='rtl' align='right' class='text'>=======================</div>";


    $headers = "From: \"".$_POST["name"]."\" <info@dadoush.com.eg>\r\n";
         //specify MIME version 1.0
    $headers .= "MIME-Version: 1.0\r\n";
         //unique boundary
    $boundary = uniqid("COREPHP");
         //tell e-mail client this e-mail contains
            //HTML version of message
    $headers .="Content-Type: text/html; charset=utf-8\r\n" .
    "Content-Transfer-Encoding: base64\r\n\r\n";
    $headers .= chunk_split(base64_encode($body));
	@mail($to,$subject,"",$headers);
}else{
    print "Can't Sent" ;
}
print "Thank you, we will contact you with 2 business days.";
?>
</body>
</html>