<?
include "config.php";

include $register->admin_path."/cookie.php";
		
$q_search = $register->search($register->table, $register->page_name);

if (!empty($_GET[p])) ////publish content
{
	fun_active($register->table,$_GET['p'],"?page=".$_GET[page]);
}

if ($_POST['d_all'] == "d_all"){
	////Del MORE OF RECORD
	$register->deleteAll($register->table,$_POST['ArrId'],$register->page_name."?page=".$_POST[page]."&pa_id=".$_POST["pa_id"] );
}
if ($_POST['d_once']){
	//alert("عفواً, لا يمكن إجراء هذه العملية");
	////Del ONE RECORD
	$register->delAction($register->table,$_POST["d_once"]);
}

include $register->admin_path."/head.php";
include $register->admin_path."/navigation.php";

$page = $_GET['page'];
if($page < 1)  $page = 1;
$registerize = 60;
$start=(($page*$registerize)-$registerize);
$name_sort="sort_$register->table";
if($_SESSION[$name_sort] !=""){
	$sort=$_SESSION[$name_sort];
}else{
	$sort="id desc";
}

$the_title="";

?>
<div align="center"><?=$the_title?></div>
<br />
<script>
$(document).ready(function(){
		$("#email").dblclick(function(){
				$("#email").html("<form id=fd><input type='text' name='email' value='"+ $("#email").text() +"'> </form>")
				
			})
	})
</script>

<table width="100%" align="center">
    <tr>
        <td align="center">	<? $register->search_form($register->table); ?></td>
    </tr>
</table>
<form name="form1" method="post"  action="">
    <input type="hidden" name="d_all" value="" />
    <input type="hidden" name="d_once" value="" />
    <input type="hidden" name="page_id" value="<?=$page?>" />
    
    <table width="99%" align="center">
        <tr>
            <td align="left" class="nav"><?  nav($register->table ."  order by  ".$sort,$registerize,$register->page_name."?", $_GET[page], "add", "fixadd")?></td>
            <td align="right" class="nav"><div><a href="data_<?=$register->page_name?>?page=<?=$_GET[page]?>" class="add"> اضغط هنا للاضافة</a></div></td>
        </tr>
    </table>
    <table width="99%" dir="rtl" cellpadding="5" align="center">
        <tr>
            <td align="center" width="5%" class="th"><input name="All" id="All" onclick="selectAll(this);" type="checkbox" /></td>
            <td class="th" align="center"><span style="white-space:nowrap"><a href="<?=$register->admin_path?>/sort_s.php?field_name=id&type=ar&table=<?=$register->table?>&page=<?=$register->root?>/<?=$register->page_name?>" class="link_sort"> الرقم <?=image_sort($sort,"id")?></a></span></td>

            <td class="th" align="center"><span style="white-space:nowrap"><a href="<?=$register->admin_path?>/sort_s.php?field_name=email&table=<?=$register->table?>&page=<?=$register->root?>/<?=$register->page_name?>" class="link_sort"> الاسم <?=image_sort($sort,"email")?></a></span></td>            
            <td class="th" align="center"><span style="white-space:nowrap">كلمة السر</span></td>
			<td class="th" align="center"><span style="white-space:nowrap"><a href="<?=$register->admin_path?>/sort_s.php?field_name=showw&table=<?=$register->table?>&page=<?=$register->root?>/<?=$register->page_name?>" class="link_sort"> الحالة <?=image_sort($sort,"showw")?></a></span></td>
            <td class="th" align="center">تعديل</td>
            <td class="th" align="center" width="50">حذف</td>
        </tr>
        <? 
		if($q_search !=""){
			$res=mysqli_query2("select * from ".$register->table." where 1=1  $q_search order by ".$sort." limit $start,$registerize");
		}else{
			$res=mysqli_query2("select * from ".$register->table."  order by ".$sort." limit $start,$registerize");
		}
        $i=0;
        while ($row=mysqli_fetch_array($res)){
        if($i==0){
			$i++;
			$style='style="background-color:#FFFFFF"';
        }else{
			$style='';
			$i--;
        }
        $ids=$row['id'];
    
        ?>
        <tr>
            <td align="center"  class="td" <?=$style?> ><input name="ArrId[<?=$ids?>]"  value="1" type="checkbox"/></td>
            <td <?=$style?> <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> align="center" valign="middle" ><?=$row[id]?></td>
            <td <?=$style?> <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> align="center" valign="middle" id="email"><?=$row[email]?></td>            
            <td <?=$style?> <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> align="center" valign="middle" ><?= base64_decode($row[password])?></td>            
			<td <?=$style?> <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> align="center" valign="middle"><a href="?p=<?=$row['id']?>&page=<?=$_GET[page]?>" class="link"><? if($row['showw']=="1"){print'<img src="images/yes.png" alt="فعال" border="0" />';}else{print'<img src="images/no.png" alt="غير فعال" border="0" />';} ?></a></td>            
            <td <?=$style?> class="td" align="center"> <a href="data_view.php?id=<?=$row[id]?>" class="link"> تعديل بيانات الزبون </a></td>
            <td <?=$style?> class="td" align="center">
                <input type="submit" name="del_once" onclick="a=confirm('هل أنت متأكد أنك تريد الحذف ؟') ;if (a==true){form1.d_once.value='<?=$row[id]?>';form1.submit();};return false" value="حذف" class="form1"/></td>
        </tr>
        <? }
			$p = $register->admin_path ."/members.php";
		?>
            <tr>
            <td valign="top" colspan="1" align="left"><img src="images/arrow_rtl.png" /></td><td valign="top" colspan="100" align="right"><table><tr><td height="3px"></td></tr></table> <input type="submit" name="del_all" onclick="a=confirm('هل أنت متأكد أنك تريد الحذف ؟') ;if (a==true){form1.d_all.value='d_all';form1.submit();};return false" value="حذف" class="form1"/><br /><br /></td>
            </tr>
        <tr>
        <td height="100" colspan="20" align="center"><input type="button" name="button" value="عودة" class="form1" onclick="javascript:location.href='<?=$p?>'"></td></td>
        </tr>
    </table>
</form>
<?
include $register->admin_path."/foot.php";
?>