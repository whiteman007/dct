<?
include "../admincpanel/cookie.php";
$id = intval($_POST["id"]);
$table = strip_tags($_POST["table"]);
$field = strip_tags($_POST["f"]);

if( $field == ""){
	$field = "src";
}

$sp1 = mysqli_query2("select * from ".$table." where id = ".$id);
$rp1 = mysqli_fetch_array($sp1);
@unlink("../pages/photos/".$rp1[$field]);
mysqli_query2("update ".$table." set $field ='' where id = ".$id);
print "ok";