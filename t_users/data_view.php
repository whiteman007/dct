<?
include "config.php";
include $t_users->admin_path."/cookie.php";

if ($_POST["act"]=="add"){
         if ($_POST['t_username']!=""){

            $pic = AddUpdateImage("file",$t_users->folder_name,"1024","462",$_POST["oldpic"]);


             //print_r($_POST["pages"]);
             $pages =  implode(",",$_POST["pages"]);
             $main_pages =  implode(",",$_POST["main_pages"]);

             //$s = explode(",",$pages);
             //print_r($s);

			//$pic = AddUpdateFile("file",$t_users->folder_name);
			if($_POST["the_order"] =="" ){ $the_order="1000"; }else{ $the_order = $_POST["the_order"];}
			if($_POST["add_date"] !=""){$add_date = $_POST["add_date"];}else{$add_date = date('Y-m-d'); }	



		    $arr =array($_POST["t_username"], base64_encode($_POST["t_pass"]),$pages,$main_pages, $_POST["is_admin"], $_POST["Active"], $the_order, $add_date);
         AddUpdate($t_users->table,$_POST["id"],$arr,"process.php?err=5",$t_users->page_name."?page=$_POST[page]&id=".$_POST[id]."&pa_id=".$_POST["pa_id"]);
         }else{
         	header("location:".$t_users->admin_path."/process.php?err=1");
         }
}

include $t_users->admin_path."/head.php";
include $t_users->admin_path."/navigation.php";

$c_mains=mysqli_query2("select * from ".$t_users->table."  where id='".$_GET[id]."' ");
$row=mysqli_fetch_array($c_mains);
?>

                    <form method="POST" name="f1" enctype="multipart/form-data"  action=""  class="m_right"  dir="<?=$dir?>">
 	                   <input type="hidden" name="lang" value="en">						
                        <table border="0" width="600" cellpadding="8" dir="rtl" align="center"  class="ftab">                            
                        	<tr>
                             <td colspan="2" height="20"></td>
                            </tr>
                            <tr>
                                <td align="center" class="text_head" dir="rtl"> اسم المشرف </td>
                                <td align="right"><input type="text" name="t_username" size="40" class="form1" style="direction:ltr"  value="<?=$row['t_username'] ?>"></td>
                            </tr>
                            <tr>
                                <td align="center" class="text_head" dir="rtl"> كلمة السر </td>
                                <td align="right"><input type="text" name="t_pass" size="40" class="form1" style="direction:ltr"  value="<?=base64_decode($row['t_pass']) ?>"></td>
                            </tr>
                            <tr>
                                <td align="center" class="text_head" dir="rtl"> هل هو أدمن ؟</td>
                                <td align="right">
                                    <input type="checkbox" name="is_admin" size="40" class="form1" value="1" style="direction:ltr; text-align:right" <?=($row['is_admin']==1 && $_GET["id"] !="")   ? "checked" : ""?> >
                                </td>
                            </tr>
                            <tr>
                                <td align="center" class="text_head" dir="rtl"> تحديد صفحات  </td>
                                <td align="right">
                                    <select class="form1" name="pages[]" multiple style="width: 100%;height: 400px">
                                        <option style="font-size: 18px;color: red" value="">تحديد الصفحات للاشراف</option>
                                        <?
                                        $qs = mysqli_query2("select * from page where parent_id = 0  order by the_order,BINARY name");
                                        while($r = mysqli_fetch_array($qs)){
                                            ?>
                                            <option <?php if(in_array($r["id"],explode(",",$row["pages"]))){print "selected";}?> style="font-size: 18px" value="<?=$r['id']?>"><?=$r['name']?></option>
                                            <?
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" class="text_head" dir="rtl"> تحديد تصنيفات  </td>
                                <td align="right">
                                    <select class="form1" name="main_pages[]" multiple style="width: 100%;height: 200px">
                                        <option style="font-size: 18px;color: red" value="">تحديد تصنيفات للاشراف</option>
                                        <option <?php if(in_array('content',explode(",",$row["main_pages"]))){print "selected";}?> style="font-size: 18px;" value="content"> ادارة المحتوى </option>
                                        <option <?php if(in_array('mailinglist',explode(",",$row["main_pages"]))){print "selected";}?> style="font-size: 18px;" value="mailinglist"> القائمة البريدية    </option>
                                        <option <?php if(in_array('settings',explode(",",$row["main_pages"]))){print "selected";}?> style="font-size: 18px;" value="settings"> اعدادات الموقع  </option>


                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td align="center" class="text_head" dir="rtl"> نشر</td>
                                <td align="right">
                                    <input type="checkbox" name="Active" size="40" class="form1" value="1" style="direction:ltr; text-align:right" <?=($row['Active']==0 && $_GET["id"] !="")   ? "" : "checked"?> >
                                </td>
                            </tr>
                            <tr>
                            	<td height="10px"></td>
                            </tr>


                            <tr>
                                    <td></td>
                                <td align="right"  height="50">
                                        <input name="act" type="hidden" value="add">
                                            <input name="add_date" type="hidden" value="<?=$row[add_date]?>">
                                            <input name="id" type="hidden" value="<?=$_GET[id]?>">
                                            <input name="page" type="hidden" value="<?=$_GET[page]?>">
                                            <input type="submit" value="<?=$_GET[id]==''?'اضافة':'تعديل'?>"  name="B1" class="form1">
                              <input type="button" name="button" value="عودة" class="form1" onclick="javascript:location.href='<?=$t_users->page_name?>?pa_id=<?=$_GET["pa_id"]?>&page=<?=$_GET[page]?>&id=<?=$_GET[id]?>'"></td>
                              </tr>
            </table>
        </td></tr></table></form>
<? include $t_users->admin_path."/foot.php"?>