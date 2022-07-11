<?
session_start();
include "../../logs/function_2.php";
include "../../logs/function.php";
include("../../mails/mailer.class.php");
secure_website();
$qsettings = mysqli_query2("select * from settings where id= 1");
$rsettings = mysqli_fetch_array($qsettings);
///////////////////////// input
$pro_name = $_POST["pro_name"];
$pro_id = intval($_POST["pro_id"]);
$qtest = mysqli_query2("select * from page where name like '".$pro_name."' and id = '".$pro_id."'");
if(mysqli_affected_rows2()>0){
    $tid= $pro_id;
}else{
    exit;
}
$note= trim($_POST["note"]);
$date_added=date('Y-m-d');
//////////////////////////////
if($note!="" && $_POST["reviewerEmail"] !=""){
if (empty($_SESSION['captcha']) || trim(strtolower($_REQUEST['captcha'])) != $_SESSION['captcha']) {
    //unset($_SESSION['captcha']);
    print "errorCaptcha";
    exit;
}
    $rand = $_POST["rand"];
    $file = $_POST["f"];
    $full_filename = $rand."-".$file;
    if(is_file("../../upload/upload/".$full_filename)){
        $f = $full_filename;
        $file_email = "../../upload/upload/".$full_filename;
    }else{
        $f = "";
        $file_email = "";
    }
if(mysqli_affected_rows2()>0){
        if($_POST["type"] == 1){
            $email_send = $rsettings["email_technical"];
        }elseif($_POST["type"] == 2){
            $email_send = $rsettings["email_administrative"];
        }else{
            $email_send = $rsettings["contact_email"];
        }
        $mailer=new mailer($email_send, "New Comment - dsdc.gov.sy ", "New comment from dsdc.gov.sy website  !!", "From: ".$_POST["reviewerName"]." <".$_POST["reviewerEmail"].">");
        if($file_email !=""){
            $mailer->file($file_email);
        }
        $test = $mailer->send();
}
        setcookie("vote_".$pro_id,"ok",time()+3600,"/");

         $arr =array($tid,$mid,$_POST["overall"],$_POST["comfort"],$_POST["style_1"],$_POST["reviewerName"],$_POST["reviewerEmail"],$_POST["reviewerLocation"],$_POST["otherShoes"],$note,$date_added,"-1",$f,$_POST["type"],$_POST["id_number"]);
         $BaseMain->AddUpdate("vote","",$arr,"","");
            print "success";
            die();
}else{

}

?>