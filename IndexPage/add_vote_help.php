<?
include "../logs/function_2.php";
$q_vote=mysqli_query2("select * from vote where user_id='".base64_decode($_COOKIE[mid])."' and a_z='".$_POST[a_z]."'");
if($_POST['openion'] == "" or $_POST['note'] == ""){
header("location:../index.php?type=process&err=1&page=");
exit;
}
if(mysqli_affected_rows2()>0){
header("location:../index.php?type=process&err=10&page=");
exit;
}

$mid= base64_decode($_COOKIE['mid']);
$date_added=date('Y-m-d');
if ($mid!=""){
if($_POST['note']!="" and $_POST['openion']!=""){
         $arr =array("0",$mid,$_POST['openion'],$_POST['note'],$date_added,$_POST['a_z']);
         add("vote","",$arr,6,"process.php?err=5","../index.php?type=help");
}

}
?>