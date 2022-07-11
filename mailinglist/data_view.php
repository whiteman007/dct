<?
include "config.php";
include $register->admin_path."/cookie.php";

if ($_POST["act"]=="add"){
         if ($_POST['email']!="" and $_POST['password']!="" and $_POST['password'] == $_POST["password_2"]){
		    $arr =array($_POST["email"], base64_encode($_POST['password']), $_POST["showw"]);
         	AddUpdate($register->table, $_POST["id"], $arr, $register->admin_path."/process.php?err=5", $register->page_name."?page=$_POST[page]&id=".$_POST[id]."&pa_id=".$_POST["pa_id"]);
         }else{
         	header("location:".$register->admin_path."/process.php?err=1");
         }
}

include $register->admin_path."/head.php";
include $register->admin_path."/navigation.php";

$c_mains=mysqli_query2("select * from ".$register->table."  where id='".$_GET[id]."' ");
$row=mysqli_fetch_array($c_mains);
?>
<!-- TinyMCE -->
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "right",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "SomesUser",
			staffid : "99123s4"
		}
	});
</script>
<!-- /TinyMCE -->
                    <form method="POST" name="f1" enctype="multipart/form-data"  action=""  class="m_right"  dir="<?=$dir?>">
 	                   <input type="hidden" name="lang" value="en">						
                        <table border="0" width="600" cellpadding="4" dir="rtl" align="center"  class="ftab">                            
                        <tr>
                                <td class="text_head">اسم الدخول للزبون: <font class="star">*</font></td>
                                <td align="<?=$align?>"><input type="text" name="email" value="<?=$row[email]?>"  style="direction:<?=$dir?>" size="45" class="form1"></td>
                            </tr>
							<tr  id="tr1">
                            <td><div align="right" class="text_head">كلمة السر<span class="star">*</span></div></td>
                            <td><div align="center">
                                <label></label>
                                <div align="right" class="label2">
                                  <input class="form1" name="password" value="<?= base64_decode($row[password])?>"  dir="ltr" id="password" size="30"  type="text">
                                </div>
                            </div></td>
                          </tr>
                          <tr   id="minustr1">
                            <td><div align="right" class="text_head"> تأكيد كلمة السر<span class="star"> *</span></div></td>
                            <td><div align="center">
                                <label></label>
                                <div align="right" class="label2">
                                  <input class="form1" name="password_2" value="<?=base64_decode($row[password])?>"   dir="ltr" id="password_2" size="30"  type="text">
                                </div>
                            </div></td>
                          </tr>   

                            <tr>
                                <td align="right" class="text_head" dir="rtl"> تفعيل: </td>
                              <td align="right">
                                <select name="showw" class="form1">
                                  <option value="1" <?=$row["showw"]== "1" ? "selected" : ""?>>نعم</option>
                                  <option value="-1" <?=$row["showw"]== "-1" ? "selected" : ""?>>لا</option>
                                </select>
                              </td>
                            </tr>                              
                            <tr>
                                    <td></td>
                                <td align="right"  height="50">
                                        <input name="act" type="hidden" value="add">
                                            <input name="id" type="hidden" value="<?=$_GET[id]?>">
                                            <input type="submit" value="<?=$_GET[id]==''?'اضافة':'تعديل'?>"  name="B1" class="form1">
                              <input type="button" name="button" value="عودة" class="form1" onclick="javascript:location.href='<?=$register->page_name?>?pa_id=<?=$_GET["pa_id"]?>&page=<?=$_GET[page]?>&id=<?=$_GET[id]?>'"></td>
                              </tr>
            </table>
        </td></tr></table></form>
<? include $register->admin_path."/foot.php"?>