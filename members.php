<?
include "cookie.php";
if(( $l_logout < $logout ) or ( mysql_num_row() <= 0 ) ){
header("location:".$_COOKIE[defaultPage]."");
exit;
}
include "head.php";
include "navigation.php";
?>
<p align='center' class='text' style="text-align: center">
<?=$label_members?>
</p>
<?
include "foot.php";
?>