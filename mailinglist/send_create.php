<?
include "config.php";
include $mailinglist->admin_path."/cookie.php";
include $mailinglist->admin_path."/head.php";
include $mailinglist->admin_path."/navigation.php";
$reset = $_GET['reset'];
$title = $_POST['title'];
$body = $_POST['body'];
$email_replace = $_POST['email_replace'];
if($reset == 1){
mysqli_query2("update ".$mailinglist->table." set sent = 0");
}
?>
<div class="w3-right-align rtl">
    <a href="data_emails.php" class="w3-btn w3-green">
        اضافة ايميل
    </a>&nbsp;
    <a href="?show=all" class="w3-btn w3-white">
        عرض كل الايميلات
    </a>

</div>
<div>
<p align='center' class='text' dir="<?=$dir?>">

    <form action='send_email.php' method="POST"  enctype="multipart/form-data"  name="HyperTextAreaExample">
        <input type="text" name="email_replace" value="<?=$email_replace?>" required placeholder="Email of the sender " class="form1" size="80"><br><br>
        <input type="text" name="title" value="<?=$title?>" required placeholder="Title" class="form1" size="80"><br><br>
        <?php
        $CKEditor = new CKEditor();
        $CKEditor->editor("body", $body);
        ?>
    <br><br>

    <?
    if($_GET["show"] == "all"){
        $limit =  "";
    }else{
        $limit = "where sent = 0 LIMIT 0,50";
    }

    $buton = mysqli_query2("select * from ".$mailinglist->table."  $limit");
    if(mysqli_affected_rows($GLOBALS["db_link"]) <= "0"){
    ?>
    <?
    }else{
    ?>
    <input type='submit' value='<?=$label_send_newsletter?>' class='w3-btn w3-green' >
        <br><br>
        Or <br><br>
    <?
    }
    ?>
        <input type='button' value='<?=$label_send_new_newsletter?>' onclick="location.href='send_create.php?reset=1'" class='w3-btn w3-red'>
    <br><br>
    <table border=0 width=100% dir='<?=$dir?>' class="tabe">
    <?
    $resultss = mysqli_query2("select * from ".$mailinglist->table." $limit");
    if(mysqli_affected_rows($GLOBALS["db_link"]) <= "0"){
    ?>
    <tr>
    <td class='text'>
    <?=$label_send_finish?>
    </td>
    </tr>
    <?
    }else{
    ?>
    <tr>
    <td class='text'>
    <span style="font-weight: bold"><?=$label_will_send?></span>
    <br>
    <?=$label_will_comeback?>
    </td>
    </tr>
    <?
    }
    while($rowss = mysqli_fetch_array($resultss)){
    ?>
    <tr>
    <td class='text tahoma' dir="ltr">
    <input type='checkbox' name='<?=base64_encode($rowss['email'])?>' value='<?=base64_encode($rowss['email'])?>' checked>
    <?=$rowss['email']?> || <a href="del_email.php?id=<?=$rowss['id']?>" class="w3-text-red w3-slim w3-small"><?=$label_delete?></a> <?=$rowss['name']?>
    </td>
    </tr>
    <?
    }
    ?>
    </table>
    </form>
</p>
</div>
<?
//print $body;
include $mailinglist->admin_path."/foot.php";
?>