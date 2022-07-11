<?
include "config.php";
include $mailinglist->admin_path."/cookie.php";
include $mailinglist->admin_path."/head.php";
include $mailinglist->admin_path."/navigation.php";
include "../mails/mailer.class.php";

$title = $_POST['title'];
$body = $_POST['body'];
$email_replace = $_POST['email_replace'];

while(list($a,$b) = each($_POST)){
      if($a != "title" && $a != "fontname" && $a != "fontsize" && $a != "body" && $a != "groupp" && $a != "num"){
        mysqli_query2("update ".$mailinglist->table." set sent = '1' where email = '".base64_decode($a)."'");
          $mailer=new mailer(base64_decode($a), $title, $body, "From: ".$_SERVER['HTTP_HOST']." <".$email_replace.">");
          $test = $mailer->send();
      }
}
?>
<form action="send_create.php" method="post">
    <input type="hidden" name="body" value="<?=$body?>">
    <input type="hidden" name="title" value="<?=$title?>">
    <input type="hidden" name="email_replace" value="<?=$email_replace?>">
    <input class="w3-btn w3-green form1" type="submit" value="Continuation of the newsletter">
</form>
