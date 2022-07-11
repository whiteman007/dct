<?
include "cookie.php";
////////////////////p_id parent id for set cookie

if($_GET[p]){
fun_active("user",$_GET[id],"users.php?page=$_GET[page]","user_is_active");
}
include "head.php";
include "navigation.php";

$page=$_GET['page'];

if($page=="")  $page=1;
$pagesize=50;
$start=(($page*$pagesize)-$pagesize) ;

$name_sort="sort_user";
if($_COOKIE[$name_sort] !=""){
$sort=$_COOKIE[$name_sort];
}else{
$sort="  add_date desc";
}
include "user/filter.php";

include "user/user_table.php";


include "foot.php";
?>