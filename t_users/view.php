<?
include "config.php";

$pid= $_GET["pid"];
if($pid !=""){
	setcookie("pid",$pid);
	header("location: view.php");
	exit;
}
include $t_users->admin_path."/cookie.php";
		
$q_search = $t_users->search($t_users->table, $t_users->page_name);



if (!empty($_GET[p])) ////publish content
{
	fun_active($t_users->table,$_GET['p'],"?page=".$_GET[page]);
}

if ($_POST['d_all'] == "d_all"){
	//alert("عفواً, لا يمكن إجراء هذه العملية");
	////Del MORE OF RECORD
	$t_users->deleteAll($t_users->table,$_POST['ArrId'],$t_users->page_name."?page=".$_POST[page]."&pa_id=".$_POST["pa_id"] );
}
if ($_POST['d_once']){
	//alert("عفواً, لا يمكن إجراء هذه العملية");
	////Del ONE RECORD
	$t_users->delAction($t_users->table,$_POST["d_once"]);
}

include $t_users->admin_path."/head.php";
include $t_users->admin_path."/navigation.php";

$page = $_GET['page'];
if($page < 1)  $page = 1;
$productize = 60;
$start=(($page*$productize)-$productize) ;

$name_sort="sort_$t_users->table";
if($_SESSION[$name_sort] !=""){
	$sort=$_SESSION[$name_sort];
}else{
	$sort="id desc";
}

$the_title="";
?>
<script>
$(document).ready(function(){
	$(".b1").click(function(){
			location.href=$(this).parents("a").attr("href");
			return false;
		})
	
	})
</script>
<style>
.b1{ width:100px; background:#090; color:#FFF }
.b2{ width:100px; background:#ff0000; color:#FFF }
</style>
<div align="center"><?=$the_title?></div>
<br />

<table width="800px" align="center">
    <tr>
        <td align="center">	<? $t_users->search_form($t_users->table); ?></td>
    </tr>
</table>
<form name="form1" method="post"  action="">
    <input type="hidden" name="d_all" value="" />
    <input type="hidden" name="d_once" value="" />
    <input type="hidden" name="page_id" value="<?=$page?>" />
    <table width="99%" align="center">
        <tr>
            <td align="left" class="nav"><?  nav($t_users->table ."  order by  ".$sort,$productize,$t_users->page_name."?", $_GET[page], "add", "fixadd")?></td>
            <td align="right" class="nav"><div><a href="data_<?=$t_users->page_name?>?page=<?=$_GET[page]?>" class="add"> اضغط هنا للاضافة</a></div></td>
        </tr>
    </table>
    <table width="99%"  dir="rtl" cellpadding="5" align="center">
        <tr>
            <td class="th" align="center" width="10px"><input name="All" id="All" onclick="selectAll(this);" type="checkbox" /></td>
            <td class="th" align="center" width="45px"><span><a href="<?=$t_users->admin_path?>/sort_s.php?field_name=id&table=<?=$t_users->table?>&page=<?=$t_users->root?>/<?=$t_users->page_name?>" class="link_sort"> الرقم <?=image_sort($sort,"id")?></a></span></td>
            <td class="th" align="center"><span><a href="<?=$t_users->admin_path?>/sort_s.php?field_name=t_username&type=ar&table=<?=$t_users->table?>&page=<?=$t_users->root?>/<?=$t_users->page_name?>" class="link_sort"> ال<?=$t_users->title?> <?=image_sort($sort,"name")?></a></span></td>
			<td class="th" align="center"><span><a  class="link_sort"> كلمة السر <?=image_sort($sort,"the_order")?></a></span></td>
            <td class="th" align="center"><span><a href="<?=$t_users->admin_path?>/sort_s.php?field_name=add_date&table=<?=$t_users->table?>&page=<?=$t_users->root?>/<?=$t_users->page_name?>" class="link_sort"> تاريخ الاضافة <?=image_sort($sort,"add_date")?></a></span></td>
            <td class="th" align="center">تعديل</td>
            <td class="th" align="center" width="50">حذف</td>
        </tr>
        <? 
		if($q_search !=""){
			$res=mysqli_query2("select * from ".$t_users->table." where 1=1 $q_search order by ".$sort." limit $start,$productize");
		}else{
			$res=mysqli_query2("select * from ".$t_users->table."  order by ".$sort." limit $start,$productize");
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
            <td align="center" <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> <?=$style?> ><input name="ArrId[<?=$ids?>]"  value="1" type="checkbox"/></td>
                        <td <?=$style?> <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> align="center" valign="middle" ><?=$row[id]?></td>
            
            <td <?=$style?> <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> align="center" valign="middle" >		
                <?php
                print $row["t_username"];
                ?>
                    
				</td>        
            <td <?=$style?> <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> align="center" valign="middle" ><?=base64_decode($row["t_pass"])?></td>
            <td <?=$style?> <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> align="center" valign="middle" ><?=$row[add_date]?></td>
            <td <?=$style?> <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> align="center"> <a href="data_view.php?id=<?=$row[id]?>&page=<?=$page?>" class="link" style="text-decoration:underline"> تعديل</a></td>
            <td <?=$style?> <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> align="center">
                <input type="submit" name="del_once" onclick="a=confirm('هل أنت متأكد أنك تريد الحذف ؟') ;if (a==true){form1.d_once.value='<?=$row[id]?>';form1.submit();};return false" value="حذف" class="form1"/></td>
        </tr>
        <? }
			$p = "../news/view.php";
		?>
            <tr>
            <td valign="top" colspan="1" align="left"><img src="images/arrow_rtl.png" /></td><td valign="top" colspan="100" align="right"><table><tr><td height="3px"></td></tr></table> <input type="submit" name="del_all" onclick="a=confirm('هل أنت متأكد أنك تريد الحذف ؟') ;if (a==true){form1.d_all.value='d_all';form1.submit();};return false" value="حذف" class="form1"/><br /><br /></td>
            </tr>

        <tr>
	        <td height="100" colspan="20" align="center"><input type="button" name="button" value="عودة" class="form1" onclick="javascript:location.href='<?=$p?>'"></td></td>
        </tr>
    </table>
</form>
<script type="application/javascript">
$(document).ready(function(){


	$(".tdssssss").each(function(k,v){
		//console.log($(v).text());
		if($(v).text().indexOf('11') != -1){
		   //do something or add element to an array
		}
	});
	$(window).scrollTop($(".td_highlight").offset().top - 200);
})
</script>
<?
include $t_users->admin_path."/foot.php";
?>