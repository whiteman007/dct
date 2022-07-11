<?
session_start();
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<?
$name = strip_tags($_POST["name"]);
$email = strip_tags($_POST["email"]);
if ( !trim($name) == ""){

$to = "info@artists-syndicate.sy";
$subject = "اشتراك في القائمة البريدية من  $name";

$body= "
<div dir='rtl' align='right' class='text'>========================</div>";
$body .= "<div dir='rtl' align='right' class='text'><b>لقد جاءك اشتراك في القائمة البريدية من     :</b> ".$name."</div>";
$body .= "<div dir='rtl' align='right' class='text'><b>الإسم : </b>".$name."</div>";
$body .= "<div dir='rtl' align='right' class='text'><b>البريد الالكتروني : </b>".$email."</div>";
$body .= "<div dir='rtl' align='right' class='text'>=======================</div>";


$headers = "From: \"".$name."\" <info@gsoncology.com>\r\n";
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
        alert("لم يتم الاشتراك.. هناك خطأ ما");
        location.href="../index.php";
    </script>
<?
}
?>

<script language="javascript">
    alert("شكراً لك لاشتراكك في القائمة البريدية");
    location.href="../index.php";
</script>


</body>
</html>