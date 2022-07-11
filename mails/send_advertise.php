<?
session_start();
if(preg_match("/ar\//",$_SERVER["HTTP_REFERER"])){
    $ext_page = "_ar";
}
$name = strip_tags($_POST["name"]);
$phone = strip_tags($_POST["phone"]);
$email = strip_tags($_POST["email"]);
include_once "../logs/function.php";
///////////////
$qsettings = mysqli_query2("select * from settings where id= 1");
$rsettings = mysqli_fetch_array($qsettings);
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<body>
<?
include("mailer.class.php");
if ( !trim($name) == ""){
if (empty($_SESSION['captcha']) || trim(strtolower($_REQUEST['captcha'])) != $_SESSION['captcha']) {
    //unset($_SESSION['captcha']);
    ?>
    <script language="javascript">
        alert("Error Confirmation Code");
        history.go(-1);
    </script>
<?
die();
}
         $src_name = $_FILES['input-file-preview']['name'];
         $src_size = $_FILES['input-file-preview']['size'];
         $src_type = $_FILES['input-file-preview']['type'];
         $src_temp = $_FILES['input-file-preview']['tmp_name'];


		if($src_size <= 6048576 or $src_size!="0" ){
			if($src_size > 0){
				$stamp=time();
				$pic= $stamp."_".$src_name;
				move_uploaded_file($src_temp,"../images/".$pic);
				
			}
		}else{
			print "<script>alert('الرجاء ادخال ملف صغير الحجم');history.go(-1)</script>";
		}		 



$to = $rsettings["contact_email"];
$subject = "Inquiry from ".$name;
$body = "
<div dir='ltr' align='left' class='text'>========================</div>";
$body .= "<div dir='ltr' align='left' class='text'><b>This is  an job message from  :</b> ".$name."</div>";
$body .= "<div dir='ltr' align='left' class='text'><b>Name : </b>".$name."</div>";
$body .= "<div dir='ltr' align='left' class='text'><b>Phone Number : </b>".$phone."</div>";
$body .= "<div dir='ltr' align='left' class='text'><b>Email : </b>".$email."</div>";




$body .= "<div dir='ltr' align='left' class='text'>=======================</div>";




$mailer=new mailer($to, $subject, $body, "From: ".$name." <".$email.">");
if($pic !=""){
    $mailer->file("../images/".$pic);
}
//$mailer->file("text/plain","see.txt","tada 2 attachments");
    $test = $mailer->send();
    if(!$test) {
        ?>
            <script language="javascript">
            alert("The message not sent.");
            location.href="../index<?=$ext_page?>.php";
            </script>
        <?
    }
}

@unlink("../images/".$pic);
if($ext_page =="_ar"){
        ?>
            <script language="javascript">
            alert("شكراً لك, سيتم معالجة طلبك في غضون يومين.");
            location.href="../index<?=$ext_page?>.php";
            </script>
        <?
}else{
        ?>
            <script language="javascript">
            alert("Thank you, your application will be processed within two days.");
            location.href="../index<?=$ext_page?>.php";
            </script>
        <?
}
?>

</body>
</html>