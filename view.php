<?
include "config.php";

include $pages->admin_path."/cookie.php";

if($_GET['reset'] =="1"){
    setcookie("parent_id", "0");
    $_SESSION["parent_id"] = "0";
    header("location: view.php");
    exit;
}

if($_GET['pa_id'] !=""){
    setcookie("parent_id", $_GET['pa_id']);
    $_SESSION["parent_id"] = $_GET['pa_id'];
    header("location: view.php");
    exit;
}

$q_search = $pages->search($pages->table, $pages->page_name);

if ($_POST['d_all'] == "d_all"){
	//alert("عفواً, لا يمكن إجراء هذه العملية");
	////Del MORE OF RECORD
	$pages->deleteAll($pages->table,$_POST['ArrId'],$pages->page_name."?page=".$_POST[page]."&pa_id=".$_POST["pa_id"] );
}
if ($_POST['d_once']){
	//alert("عفواً, لا يمكن إجراء هذه العملية");
	////Del ONE RECORD
	$pages->delAction($pages->table,$_POST["d_once"]);
}

include $pages->admin_path."/head.php";
include $pages->admin_path."/navigation.php";



$page = $_GET['page'];
if($page < 1)  $page = 1;
$pagesize = 50;
$start=(($page*$pagesize)-$pagesize) ;

$name_sort="sort_$pages->table";
if($_SESSION[$name_sort] !=""){
	$sort=$_SESSION[$name_sort];
}else{
	$sort="the_order";
}
$the_title="";
?>
<div align="center"><?=$the_title?></div>
<br />

<table width="100%" align="center">
    <tr>
        <td align="center">	<? $pages->search_form($pages->table); ?></td>
    </tr>
</table>
    <table width="700" align="center">
        <tr>
            <td align="right" class="nav" style="height: 50px;direction: rtl" colspan="2"><?  head_pages("label",$_COOKIE["parent_id"],"-1","0")?></td>
        </tr>
    </table>
<form name="form1" method="post"  action="">
    <input type="hidden" name="d_all" value="" />
    <input type="hidden" name="d_once" value="" />
    <input type="hidden" name="page_id" value="<?=$page?>" />
    <table width="700" align="center" dir="<?=$dir_r?>">
        <tr>
            <td align="<?=$align_r?>" class="nav" dir="<?=$dir?>"><?  nav($pages->table ." where parent_id = '".$_COOKIE["parent_id"]."'  order by  ".$sort,$pagesize,$pages->page_name."?", $_GET[page], "add", "fixadd")?></td>
            <td align="<?=$align?>" class="nav" dir="<?=$dir_r?>"><div ><a href="data_<?=$pages->page_name?>?page=<?=$_GET[page]?>" class="add"> <?=$label_add_content?></a></div></td>
        </tr>
    </table>
    <table width="700" dir="<?=$dir?>" cellpadding="5" align="center">
        <tr>
            <td align="center" width="5%" class="th"><input name="All" id="All" onclick="selectAll(this);" type="checkbox" /></td>
            <td class="th" align="center" width="50"><span style="white-space:nowrap"><a href="<?=$pages->admin_path?>/sort_s.php?field_name=id&table=<?=$pages->table?>&page=<?=$pages->root?>/<?=$pages->page_name?>?pa_id=<?=$_GET[pa_id]?>" class="link_sort"> الرقم <?=image_sort($sort,"id")?></a></span></td>
            <td class="th" align="center"><span style="white-space:nowrap"><a href="<?=$pages->admin_path?>/sort_s.php?field_name=name&table=<?=$pages->table?>&page=<?=$pages->root?>/<?=$pages->page_name?>?pa_id=<?=$_GET[pa_id]?>" class="link_sort"> <?=$label_content?> <?=image_sort($sort,"name")?></a></span></td>
            <td class="th" align="center" width="80"><span style="white-space:nowrap"><a href="<?=$pages->admin_path?>/sort_s.php?field_name=the_order&table=<?=$pages->table?>&page=<?=$pages->root?>/<?=$pages->page_name?>?pa_id=<?=$_GET[pa_id]?>" class="link_sort"><?=$label_sort?> <?=image_sort($sort,"the_order")?></a></span></td>
            <td class="th" align="center" width="50"><?=$label_update?></td>
            <td class="th" align="center" width="50"><?=$label_delete?></td>
        </tr>
        <?
        if(!$check_admin){

            $ser = top_category(0,$_COOKIE["parent_id"]);
            $ser  = array_filter(explode(",",$ser));

            if($r_c_admin['pages'] !=""){
                $arr2 = array_filter(explode(",",$r_c_admin['pages']));
                foreach($arr2 as $key => $val){
                    if(array_search($val,$ser) > -1){
                        $flag  = "ok";
                        break;
                    }
                }
            }

            if($r_c_admin['pages'] !=""){
                if($flag == "ok" && $q_search ==""){
                    $add_query =" ";
                }else{
                    $add_query = " and id in (".$r_c_admin['pages'].")";
                }

            }else{
                $add_query = " and id in (-10)";
            }
        }


		if($q_search !=""){
			$res=mysqli_query2("select * from ".$pages->table." where 1=1 $add_query $q_search order by ".$sort." limit $start,$pagesize");
		}else{
			$res=mysqli_query2("select * from ".$pages->table." where parent_id='".$_COOKIE["parent_id"]."' $add_query  order by ".$sort." limit $start,$pagesize");

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
            <td align="center"  <?=$style?> <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> >
                <span class="<?=hide_top_level(2,71)?>"><input name="ArrId[<?=$ids?>]"  value="1" type="checkbox"/></span></td>
            <td <?=$style?> <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> align="center" valign="middle" ><?=$row["id"]?></td>
            <td <?=$style?> <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> align="center" valign="top" >

				<a <?=disable(344,765,766,767,830)?>  <?=disable_top_level(159,2,797,798,829,843,822)?>

                    href="<?=$pages->page_name?>?pa_id=<?=$row[id]?>"


                    style="text-decoration:underline"  <? if($row[id]==$_GET[id]) print "class='link_highlight'"; else print "class='link'" ?>>
                <span <? if($row[id]==$_GET[id]) print "class='link_highlight'"; else print "class='link'" ?>>
				<?php
                if($row["src"]!="") print "<img style='margin: 0' src='photos/".$row[src]."' width='150'><br>";
                elseif ($row["src_2"]!="") print "<img style='margin: 10px 0' src='photos/".$row[src_2]."' width='150'><br>";
                ?>

				<?=$row["name"] !="" ? $row["name"] : $row["name_en"] ?></span>
                </a>
                </td>
            <td <?=$style?> <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> align="center" valign="middle" ><?=$row[the_order]?></td>
            <td <?=$style?> <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> align="center">
               <span class="<?=hide_top_level(175);?>"> <? per_edit($pages->admin_path."/images/edit.gif",$pages->admin_path."/images/disedit.gif","data_".$pages->page_name."?id=".$row[id]."&pa_id=".$_GET[pa_id]."&page=".$_GET[page]);?></span></td>
            <td <?=$style?> <? if($row[id]==$_GET[id]) print "class='td_highlight'"; else print "class='td'"  ?> align="center">
                <span class="<?=hide_top_level(1,159,2,73,344,765,766,767,797,798,822,815,829,830,835,840,843)?>"><input type="submit" name="del_once" onclick="a=confirm('<?=$label_confirm_delete?>') ;if (a==true){form1.d_once.value='<?=$row[id]?>';form1.submit();};return false" value="<?=$label_delete?>" class="form1"/></span></td>
        </tr>
        <? }
        $q = mysqli_query2("select * from ".$pages->table." where id= '".$_COOKIE['parent_id']."' ");
        $r = mysqli_fetch_array($q);
        $p = "view.php?pa_id=". $r["parent_id"];
		?>
            <tr>
            <td valign="top" colspan="1" align="left"><img src="images/arrow_<?=$dir?>.png" /></td><td valign="top" colspan="100" align="right"><table><tr><td height="3px"></td></tr></table> <input style="margin-right: 12px" type="submit" name="del_all" onclick="a=confirm('<?=$label_confirm_delete?>') ;if (a==true){form1.d_all.value='d_all';form1.submit();};return false" value="<?=$label_delete?>" class="form1"/><br /><br /></td>
            </tr>
        <tr>
            <td height="100" colspan="7" align="center"><input type="button" name="button" value="عودة" class="form1" onclick="javascript:location.href='<?=$p?>'"></td></td>
        </tr>
    </table>
</form>
<?
include $pages->admin_path."/foot.php";
?>