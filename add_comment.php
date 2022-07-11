<?
include "../admincpanel/cookie.php";
secure_website();
$id = intval($_POST["comm"]);
$manager_comment = strip_tags($_POST["manager_comment"]);
if($id){
    mysqli_query2("update vote set manager_comment ='".$manager_comment."' where id = ".$id);
    print "success";
}

