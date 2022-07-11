<?
include "cookie.php";

$page_name = "data_center.php";
$folder="Uploads";

if ($_POST[act]=="add")
{
         $file_name = $HTTP_POST_FILES['file']['name'];
         $file_temp = $HTTP_POST_FILES['file']['tmp_name'];

		 $stamp=date("Y_m_d");	

         if ($_POST["name"] !=""){

                 $pic=$_POST[oldpic];
                 }else{	
					$pic= $stamp."_".$file_name;
					if(preg_match("/swf$/",$file_name)){
						move_uploaded_file($file_temp,"../".$folder."/".$pic);
					}else{
						createthumb($file_temp,"../".$folder."/".$pic,800,"");
					}
					@unlink("../".$folder."/".$_POST[oldpic]);
                 }
		 header("location:".$page_name);
		 exit;
}
include "head.php";
include "navigation.php";
?>
<form method="POST" enctype="multipart/form-data">
<table border="0" width="770" id="table1" align=center dir="rtl" class="ftab" >
<tr>
<td>
<table border="0" width="100%" id="table2" align="center" dir="rtl" >
        <tr>
        <td dir="rtl"  align="center" class="text"> تحميل ملف: </td>
        <td  dir="rtl" class="text" >
        <input type="file" name="file" size="19" class="form1">
        <input name="oldpic" type=hidden value="<?=$row[src]?>">
        </tr>

        <tr>
        <td></td>
                <td align="right"  height="50">
                    <input name="act" type=hidden value=add>
                    <input name="page" type=hidden value="<?=$_GET[page]?>">
                    <input name="id" type=hidden value="<?=$_GET[id]?>">
                    <input name="cat_id" type=hidden value="<?=$_GET[id]?>">
                <input type="submit" value="<?=$_GET[id]==''?'اضافة':'تعديل'?>"  name="B1" class="form1">
				<input type="button" name="button" value="عودة" class=form1 onclick="javascript:location.href='<?=$page_name?>?page=<?=$_GET[page]?>&id=<?=$_GET[id]?>'"></td>
        </tr>
</table>
</td></tr></table></form>
<? include"foot.php"?>