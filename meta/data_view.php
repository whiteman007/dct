<?
include "config.php";
include $meta->admin_path."/cookie.php";

if ($_POST["act"]=="add"){
         if ($_POST['the_order'] ==""){
		 $arr =array($_POST["descriptione"],$_POST["keyworde"]);
         AddUpdate($meta->table,"1",$arr,"process.php?err=5","?page=$_POST[page]&id=".$_POST[id]."&pa_id=".$_POST["pa_id"]);
         }else{
         	header("location:".$meta->admin_path."/process.php?err=1");
         }
}

include $meta->admin_path."/head.php";
include $meta->admin_path."/navigation.php";

$c_mains=mysqli_query2("select * from ".$meta->table."  where id='1' ");
$row=mysqli_fetch_array($c_mains);
?>


                    <form method="POST" name="f1" enctype="multipart/form-data"  action=""  class="m_right"  dir="<?=$dir?>">
 	                   <input type="hidden" name="lang" value="en">						
                        <table border="0" width="600" cellpadding="8" dir="rtl" align="center"  class="ftab">                            


                            <tr>
                                <td align="center" class="text_head" dir="rtl">الوصف</td>
                                <td align="right">
                                    <textarea name="descriptione" rows="3" cols="40"><?=$row["descriptione"]?></textarea></td>
                            </tr>
                            <tr>
                                <td align="center" class="text_head" dir="rtl">الكلمات المفتاحية</td>
                                <td align="right">
                                    <textarea name="keyworde" rows="3" cols="40"><?=$row["keyworde"]?></textarea></td>
                            </tr>
                            <tr>
                                    <td></td>
                                <td align="right"  height="50">
                                        <input name="act" type="hidden" value="add">
                                            <input name="id" type="hidden" value="<?=$_GET[id]?>">
                                            <input name="page" type="hidden" value="<?=$_GET[page]?>">
                                            <input type="submit" value="<?=$_GET[id] !=''?'اضافة':'تعديل'?>"  name="B1" class="form1">
                              <input type="button" name="button" value="عودة" class="form1" onclick="javascript:location.href='<?=$meta->page_name?>?pa_id=<?=$_GET["pa_id"]?>&page=<?=$_GET[page]?>&id=<?=$_GET[id]?>'"></td>
                              </tr>
            </table>
        </td></tr></table></form>
<? include $meta->admin_path."/foot.php"?>