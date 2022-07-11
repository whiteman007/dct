<?
session_start();
include("mailer.class.php");
//$_COOKIE["send_once"] = "ok";

if(preg_match("/ar\//",$_SERVER["HTTP_REFERER"])){
    $ext_page = "ar/";
}
if(preg_match("/en\//",$_SERVER["HTTP_REFERER"])){
    $ext_page = "en/";
}

include_once "../logs/function.php";
//secure_website();
///////////////
$qsettings = mysqli_query2("select * from settings where id= 1");
$rsettings = mysqli_fetch_array($qsettings);
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<?
if ( !trim($_POST["name"]) == ""){

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


$name = strip_tags($_POST["name"]);
$email = strip_tags($_POST["email"]);
$phone = strip_tags($_POST["phone"]);
$address = strip_tags($_POST["address"]);
$comment = strip_tags($_POST["comment"]);

$to = $rsettings["contact_email"];
$subject = "رسالة من  $name";

$body= "
    <div dir='rtl' align='right' class='text'>========================</div>";
    $body .= "<div dir='rtl' align='right' class='text'><b>لقد تلقيت رسالة من   :</b> ".$name."</div>";
    $body .= "<div dir='rtl' align='right' class='text'><b>الإسم : </b>".$name."</div>";
    $body .= "<div dir='rtl' align='right' class='text'><b>البريد الالكتروني : </b>".$email."</div>";
    $body .= "<div dir='rtl' align='right' class='text'><b> هاتف : </b>".$phone."</div>";
    $body .= "<div dir='rtl' align='right' class='text'><b>العنوان: </b>".$address."</div>";

if($comment !=""){
	$body .= "<div dir='rtl' align='right' class='text'><b>التعليق :</b><br> ".nl2br($comment)."</div>";
}
$body .= "<div dir='rtl' align='right' class='text'>=======================</div>";

    $headers = "From: \"".$name."\" <info@".$_SERVER['HTTP_HOST'].">\r\n";
         //specify MIME version 1.0
    $headers .= "MIME-Version: 1.0\r\n";
         //unique boundary
    $boundary = uniqid("COREPHP");
         //tell e-mail client this e-mail contains
            //HTML version of message
    $headers .="Content-Type: text/html; charset=utf-8\r\n" .
    "Content-Transfer-Encoding: base64\r\n\r\n";
    $headers .= chunk_split(base64_encode($body));
    $mailer=new mailer($to, $subject, $body, "From: <".$email.">");
    $test = $mailer->send();
    if(!$test) {
    ?>
        <script language="javascript">
            alert("The message not sent.");
            location.href="../index<?=$ext_page?>.php";
        </script>
    <?
    }

}else{
?>
<script language="javascript">
alert("The message not sent!");
location.href="<?=$ext_page?>";
</script>
<?
}

if($ext_page == "ar/"){
?>
    <script language="javascript">
        alert("شكراً لك, سيتم معالجة طلبك في غضون يومين عمل.");
        location.href="../<?=$ext_page?>";
    </script>
<?
}else{
   ?>
    <script language="javascript">
        alert("Thank you, we will contact you with 2 business days.");
        location.href="../<?=$ext_page?>";
    </script>

    <?
}

?>




</body>
</html>