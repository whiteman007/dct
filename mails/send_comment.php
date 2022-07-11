<?
session_start();
//$_COOKIE["send_once"] = "ok";
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<?
if ( !trim($_POST["name"]) == ""){

$name = $_POST["name"];
$to = "saer.alabdallah@chamcontracting.com,hanadi.khiar@chamcontracting.com";
$subject = "Inquiry from $name";

$body= "
<div dir='rtl' align='right' class='text'>========================</div>";
$body .= "<div dir='rtl' align='right' class='text'><b>لقد تلقيت رسالة من   :</b> ".$_POST[name]."</div>";
$body .= "<div dir='rtl' align='right' class='text'><b>الإسم : </b>".$_POST['name']."</div>";
$body .= "<div dir='rtl' align='right' class='text'><b>البريد الالكتروني : </b>".$_POST['email']."</div>";


if($_POST['message'] !=""){
	$body .= "<div dir='rtl' align='right' class='text'><b>التعليق :</b><br> ".nl2br($_POST['message'])."</div>";
}

$body .= "<div dir='rtl' align='right' class='text'>=======================</div>";

    $headers = "From: \"".$_POST["name"]."\" <info@".$_SERVER['HTTP_HOST'].">\r\n";
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
?>
<script language="javascript">
alert("The message not sent!");
location.href="../index.php";
</script>
<?
}
?>

<script language="javascript">
alert("شكرا لك سيتم معالجة الموضوع.");
location.href="../index.php";
</script>


</body>
</html>