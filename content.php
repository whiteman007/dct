<?
include "config.php";
include ${$ClassName}->admin_path."/cookie.php";
$q_search = ${$ClassName}->search(${$ClassName}->table, ${$ClassName}->page_name, ${$ClassName}->search_fields_array);
////////////////////////////////////Active  content
if (!empty($_GET[p])) {
	${$ClassName}->fun_active(${$ClassName}->table,$_GET['p']);
	print "success";
	die();
}
if (!empty($_POST[p_all])){
	${$ClassName}->fun_active_all(${$ClassName}->table,$_POST['ArrId']);
	print "success";
	die();
}

///////////////////////////////////////
$page = $_GET['page'];
if($page < 1)  $page = 1;
$pagesize = ${$ClassName}->pagesize;
$start=(($page*$pagesize)-$pagesize);
$name_sort="sort_".${$ClassName}->table;
if($_SESSION[$name_sort] !=""){
	$sort=$_SESSION[$name_sort];
}else{
	$sort="id desc";
}
///////////////////// search header
?>
<script type="text/javascript">
	$(document).ready(function(){
		$.getScript("js/content.js");
	})
</script>
<form name="form1" id="form_main" method="post"  action="">
    <input type="hidden" name="d_all" value="" />
    <input type="hidden" name="p_all" value="" />
    <input type="hidden" name="edit_all" value="" />
    <input type="hidden" name="d_once" value="" />
    <input type="hidden" name="page_id" value="<?=$page?>" />
    <table width="99%" dir="rtl" cellpadding="5" align="center" id="ContentTable">
        <tr>
            <td align="center" width="5%" class="th"><input name="All" id="All" onclick="selectAll(this);" type="checkbox" /></td>
            <td class="th" align="center"><? ${$ClassName}->HeaderTable("الرقم","id") ?></td>
            <td class="th" align="center"><? ${$ClassName}->HeaderTable("السؤال","name") ?></td>
            <td class="th" align="center"> الخيارات </td>
            <td class="th" align="center"><? ${$ClassName}->HeaderTable("الحالة","showw") ?></td>

            <td class="th" align="center">تعديل</td>
            <td class="th" align="center" width="50">حذف</td>
        </tr>
        <?
		if($q_search !=""){
			$res=mysqli_query2("select * from ".${$ClassName}->table." where 1=1  $q_search order by ".$sort." limit $start,$pagesize");
		}else{

			$res=mysqli_query2("select * from ".${$ClassName}->table."  order by ".$sort." limit $start,$pagesize");
		}
        while ($row=mysqli_fetch_array($res)){
        $ids=$row['id'];
        ?>
        <tr class="tr">
            <td align="center"  class="td" <?=$style?> ><input name="ArrId[<?=$ids?>]"  value="1" type="checkbox"/></td>
            <td  <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> align="center" valign="middle" ><?=$row["id"]?></td>
            <td  <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> align="center" valign="middle"><span dir="rtl"><?=$row["qu"]?></span></td>
            <td class="td" dir="rtl" align="center">
                <?
                $qchoice = mysqli_query2("select * from poll_choices where qu_id = '".$row[id]."' order by id");
                ?>
                <table cellpadding="5" bgcolor="#888888" dir="rtl" class="text	" cellspacing="5" width="100%">
                    <?
                    while($rc = mysqli_fetch_array($qchoice)){?>
                        <tr>
                            <td width="250" style="color:#222222"><div align="justify" dir="rtl"><?=$rc[choice]?></div></td><td width="50"><? if(intval($rc[vote]) == "0"){print "--";}else{$vote = $rc[vote];print intval((intval($rc[value]) * 100)/ intval($rc[vote]))." %";} ?>  </td>
                        </tr>
                    <?
                    }?>
                </table>
            </td>

            <td  <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> align="center" valign="middle">
                <a href="" p="<?=$row['id']?>" class="link ActiveP"><? if($row['showw']=="1"){print'<img src="images/yes.png" alt="فعال" border="0" />';}else{print'<img src="images/no.png" alt="غير فعال" border="0" />';} ?></a></td>

            <td  class="td" align="center" width="50">
            	<input type="submit"  name="edit"  value="تعديل" onclick="form1.edit_all.value='<?=$row[id]?>'" class="button form1 edit"/></td>
            <td class="td" align="center" width="50">
                <input type="submit"  name="del_once"  value="حذف" d="<?=$ids?>" class="button form1"/><br /></td>
        </tr>
        <? }
			$p = ${$ClassName}->admin_path ."/members.php";
		?>
            <tr>
            <td valign="top" colspan="1" align="left"><img src="images/arrow_rtl.png" /></td><td valign="top" colspan="100" align="right"><table><tr><td height="3px"></td></tr></table>
            		<input  type="submit" name="edit"  value="تعديل"  onclick="form1.edit_all.value='edit_all';" class="form1 edit"/>
                    <input type="submit" name="del_all"  value="حذف"  class="form1"/>

                 <!--   <input  type="submit" name="activee"  value="تفعيل/الغاء" onclick="form1.p_all.value='p_all';" class="form1 activee"/>-->

                </td>
            </tr>
        <tr>
        <td height="100" colspan="20" align="center"><input type="button" name="button" value="عودة" class="form1" onclick="javascript:location.href='<?=$p?>'"></td></td>
        </tr>
    </table>
</form>
<div id="dialog"></div>