<?
if(isset($_POST['send_message'])){
include "send_1.php";
}elseif (isset($_POST['send'])){
include "send.php";
}elseif(isset($_POST['export'])){
include "excel/excel.php";
}
?>