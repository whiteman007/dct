<?
include "cookie.php";
$name_sort="sort_".$_GET['table'];
if($_GET['type']=="ar"){
$value=" BINARY ".$_GET['field_name'];
}else{
$value=" ".$_GET['field_name'];
}
 
if(preg_match("/DESC/",$_SESSION[$name_sort])){
$value= str_replace("DESC","ASC",$value);
}elseif(preg_match("/ASC/",$_SESSION[$name_sort])){
$value= str_replace("ASC","DESC",$value);
}else{
$value .=" DESC";
} 
${$name_sort}= $value;
$_SESSION[$name_sort]=$value;
header("location:".$_GET[page]);
exit;
?>