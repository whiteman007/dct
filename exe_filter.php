<?
if($_POST['act']){
$user_id_1=$_POST['user_id_1'];
$user_fname_1=$_POST['user_fname_1'];
$user_lname_1=$_POST['user_lname_1'];
$nickname_1=$_POST['nickname_1'];
$email_1=$_POST['email_1'];
$dhtmlgoodies_country = $_POST['dhtmlgoodies_country'];
$dhtmlgoodies_city =$_POST['dhtmlgoodies_city'];
$d_1=$_POST['d_1'];
$m_1=$_POST['m_1'];
$y_1=$_POST['y_1'];
$d_2=$_POST['d_2'];
$m_2=$_POST['m_2'];
$y_2=$_POST['y_2'];
$star_1=$_POST['star_1'];
$phother_name_1=$_POST['phother_name_1'];
$mother_name_1=$_POST['mother_name_1'];
$eyes_color_1=$_POST['eyes_color_1'];
$hear_color_1=$_POST['hear_color_1'];
$weight_1=$_POST['weight_1'];
$weight_2=$_POST['weight_2'];
$the_long_1=$_POST['the_long_1'];
$the_long_2=$_POST['the_long_2'];
$sex_1=$_POST['sex_1'];
$social_state_1=$_POST['social_state_1'];
$study_1=$_POST['study_1'];
$job_1=$_POST['job_1'];
$user_is_active_1=$_POST['user_is_active_1'];
$test_id_1=$_POST['test_id_1'];
$result_5_1=$_POST['result_5_1'];
$result_6_1=$_POST['result_6_1'];
if($test_id_1 !="" and $_POST['label']==5){
$result_6_1="";
}elseif($test_id_1 !="" and $_POST['label'] =="6"){
$result_5_1="";
}else{

$result_5_1="";
$result_6_1="";
}

$vote_id_1=$_POST['vote_id_1'];
$type_search=$_POST['type_search'];


$arr= array();
$arr['user_id_1']=$user_id_1;
$arr['user_fname_1']=$user_fname_1;
$arr['user_lname_1']=$user_lname_1;
$arr['nickname_1']=$nickname_1;
$arr['email_1']=$email_1;
$arr['dhtmlgoodies_country'] = $dhtmlgoodies_country;
$arr['dhtmlgoodies_city']=$dhtmlgoodies_city;
$arr['d_1']=$d_1;
$arr['m_1']=$m_1;
$arr['y_1']=$y_1;
$arr['d_2']=$d_2;
$arr['m_2']=$m_2;
$arr['y_2']=$y_2;
$arr['star_1']=$star_1;
$arr['phother_name_1']=$phother_name_1;
$arr['mother_name_1']=$mother_name_1;
$arr['eyes_color_1']=$eyes_color_1;
$arr['hear_color_1']=$hear_color_1;
$arr['weight_1']=$weight_1;
$arr['weight_2']=$weight_2;
$arr['the_long_1']=$the_long_1;
$arr['the_long_2']=$the_long_2;
$arr['sex_1']=$sex_1;
$arr['social_state_1']=$social_state_1;
$arr['study_1']=$study_1;
$arr['job_1']=$job_1;
$arr['user_is_active_1']=$user_is_active_1;
$arr['test_id_1']=$test_id_1;
$arr['vote_id_1']=$vote_id_1;
$arr['type_search']=$type_search;
$arr['result_5_1']=$result_5_1;
$arr['result_6_1']=$result_6_1;
$arr['label_1']=$_POST['label'];
setcookie("filter_search",serialize($arr));
}
header("location:users.php");
?>
