<?
$table="vote";
$page_name="comments.php";
$titla_name_ar="التعليقات";



include "cookie.php";
if ($_POST['d_all']){ ////Del content
	delete_all($table,$_POST['ArrId'],$page_name."?page=".$_POST["page"]);}
if (!empty($_GET["p"])){ ////publish content
    fun_active($table,$_GET['p'],"?page=".$_GET["page"],"Active");
}
include "head.php";
include "navigation.php";


$page=$_GET['page'];
if( $page < 1)  $page=1;
$pagesize=300;
$start=(($page*$pagesize)-$pagesize) ;

$name_sort="sort_$table";
if($_COOKIE[$name_sort] !=""){
$sort=$_COOKIE[$name_sort];
}else{
$sort="id desc";
}

?>
<form name="form1" method="post"  action="">
<input type="hidden" name="d_all" value="" />
<input type="hidden" name="page_id" value="<?=$page?>" />

<script type="text/javascript">
	$(document).ready(function(){

			$(".detail").click(function(){
                $("#dialog").html(" <div style='text-align: center'><img src='images/load.gif'></div>")
					$("#dialog").load("data_comments.php?id=" + $(this).attr("ids"));
					$("#dialog").dialog({width:"900px", modal : "true"});
								
					return false;
				})
		})
</script>

<table width="100%" dir="rtl" cellpadding="0" cellspacing="0">
<tr>
<td align="right" class="nav"><a style="display:none" href="orders_data_<?=$page_name?>?page=<?=$_GET[page]?>" class="add"><img border="0" src="images/up.gif" align="absmiddle" /> إضافة <?=$titla_name_ar?> 	</a></td>
<td align="left" class="nav"><? nav($table." where parent_id=".$_COOKIE["parent_page_id"],$pagesize,$page_name."?",$_GET[page],"add","fixadd")?></td>
</tr>
</table>
<table width="100%" dir="rtl" cellpadding="5">
<tr>
<td align="center" width="5%" class="th"><input name="All" id="All" onclick="selectAll(this);" type="checkbox" /></td>

<td class="th" align="center"> المحتوى</span></td>
<td class="th" align="center"> رأي الزائر</span></td>
<td class="th" align="center"> نشر</span></td>
<td class="th" align="center" width="200">عرض التفاصيل</td>
<td class="th" align="center" width="50">حذف</td>
</tr>
<?
$filter = "";
if(!in_array("comments",$main_pages) and !$check_admin){
    $filter .=  " and type <> 0 ";
}
if(!in_array("technical",$main_pages) and !$check_admin){
    $filter .=  " and type <> 1 ";
}
if(!in_array("administrative",$main_pages) and !$check_admin){
    $filter .=  " and type <> 2 ";
}

$res=mysqli_query2("select * from ".$table."  where 1=1 ".$filter."  order by ".$sort."  limit $start,$pagesize");
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
<td class="td" <?=$style?> dir="rtl" align="center">
    <?
    $q_product = mysqli_query2("select * from page where id = '".$row["pro_id"]."'");
    $r_productst = mysqli_fetch_array($q_product);
    print $r_productst["name"];
    ?>
</td>
<td class="td" <?=$style?>  dir="rtl" align="center">
    <?
        print strword($row["vote"],500);
    ?>
</td>
<td <?=$style?> class="td"  align="center" valign="middle"><a href="?p=<?=$row['id']?>&page=<?=$_GET[page]?>" class="link"><? if($row['Active']=="1"){print'<img src="images/yes.png" alt="فعال" border="0" />';}else{print'<img src="images/no.png" alt="غير فعال" border="0" />';} ?></a></td>
<td class="td" <?=$style?> align="center"> <a href="#" id="detail" class="detail link" ids="<?=$row[id]?>">عرض التفاصيل</a>  </td>
<td class="td" <?=$style?> align="center">
											<? per_del("images/del.gif","images/disdel.gif","confirm.php?id=$row[id]&page=".$page_name."?page=$_GET[page]&tab=".$table);?></td>
</tr>
<? }

$p="pages.php";
?>
    <tr>
    <td valign="top" colspan="1" align="left"><img src="images/arrow_rtl.png" /></td><td valign="top" colspan="100" align="right"> <input type="submit" name="del_all" onclick="a=confirm('هل أنت متأكد أنك تريد الحذف ؟') ;if (a==true){form1.d_all.value='d_all';form1.submit();};return false" value="حذف" class="form1"/><br /><br /></td>
    </tr>

<tr>
<td height="100" colspan="7" align="center"><input type="button" name="button" value="عودة" class="form1" onclick="javascript:location.href='orders_menu.php'"></td></td>
</tr>
</table>
</form>
<div id="dialog" style="display:none">
 
</div>
<?
include "foot.php";
?>