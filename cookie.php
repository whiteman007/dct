<?
session_start();
$name = $_SESSION['name_p'];
$pass = $_SESSION['pass_p'];
$l_logout = $_SESSION['last_login'];
$logout = $_SESSION['login'];
$defaultPage = $_SESSION['defaultPage'];
$session_1 = $_SESSION['session'];
if($name == "" || $pass == ""){
header("location:"."process.php?err=3");
exit;
}
include "../logs/function.php";
    $q_c_admin=mysqli_query2("select * from t_users where t_username = '".$name."' and t_pass = '".$pass."'");
    $r_c_admin=mysqli_fetch_array($q_c_admin);

    if(mysqli_affected_rows($GLOBALS["db_link"]) <= 0 or  mysql_num_row()<=0 ){
    @header("location:"."process.php?err=2");
    exit;
}

$main_pages = explode(",",$r_c_admin["main_pages"]);


if($r_c_admin["is_admin"] == 1){
    $check_admin = 1;
}else{
    $check_admin = 0;
}
if(!in_array("content",$main_pages) and !$check_admin){
    $is_content = "hide";
    if(preg_match("/\/pages\//",$_SERVER['REQUEST_URI'])){
        header("location:../admincpanel/members.php");
    }
}
if(!in_array("settings",$main_pages) and !$check_admin){
    $is_settings = "hide";
    if(preg_match("/\/settings\//",$_SERVER['REQUEST_URI'])){
        header("location:../admincpanel/members.php");
    }
}
if(!in_array("app_poll",$main_pages) and !$check_admin){
    $is_app_poll = "hide";
    if(preg_match("/\/app_poll\//",$_SERVER['REQUEST_URI'])){
        header("location:../admincpanel/members.php");
    }
}
if(!in_array("mailinglist",$main_pages) and !$check_admin){
    $is_mailinglist = "hide";
    if(preg_match("/\/mailinglist\//",$_SERVER['REQUEST_URI'])){
        header("location:../admincpanel/members.php");
    }
}
if(!in_array("comments",$main_pages) && !in_array("technical",$main_pages) && !in_array("administrative",$main_pages) && !$check_admin){
    $is_comments = "hide";
    if(preg_match("/\/comments\//",$_SERVER['REQUEST_URI'])){
        header("location:../admincpanel/members.php");
    }
}

if( !$check_admin){
    if(preg_match("/\/t_users\//",$_SERVER['REQUEST_URI'])){
        header("location:../admincpanel/members.php");
    }
}

?>
