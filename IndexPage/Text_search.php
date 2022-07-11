<?
if(main != "true"){
die("Access Denied");
}
$pid=intval($pid);
if($pid < 1){
$pid="20";
}
$qsearch = mysqli_real_escape_string($GLOBALS["db_link"],$_GET["q"]);
$query=mysqli_query2("select * from page where name_en like '%".$qsearch."%' or text_en like '".$qsearch."' ")  ?>

    <?
     while($r=mysqli_fetch_array($query)){
        print $r['text'.$ext] ;
     }
    ?>

<?
if($pid=="222" or $pid==""){
	
}
elseif($pid=="54"){
?>
<div class="text" dir="<?=$dir?>" style="margin-top:10px; margin-<?=$align?>:10px" align="justify">

<form method="POST" name="f1" enctype="multipart/form-data"  action="mails/send_contact<?=$ext?>.php"  class="m_right"  dir="<?=$dir?>" onsubmit="return contact()">
						<table border="0" width="100%" cellpadding="4" class="label contact">
							<?
                            include "pages/IndexPage/p1".$ext.".php";
                            ?>                           
                            <tr>
                                <td></td>
                                <td height="40" align="<?=$align?>"><input type="submit" name="Send" value="<?=$label_send ?>"   class="btn btn-default"></td>
                            </tr>
						</table>
</form>
</div>
<?
}elseif($pid=="66"){
?>
<div class="text" dir="<?=$dir?>" style="margin-top:10px; margin-<?=$align?>:10px" align="justify">

							<?
                            include "pages/IndexPage/advertise_here.php";
                            ?>                           
</div>
<?
}
?>
<div>&nbsp;</div>
<!-- تعليق -->