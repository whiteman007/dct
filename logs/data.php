<?
$IM_host="localhost";
$IM_username="monstert_dct_sy";
$IM_pass="Omarh2006";
$IM_db="monstert_dct_sy";
$dbLink=$GLOBALS["db_link"]=mysqli_connect("$IM_host","$IM_username","$IM_pass") or die ("Can not connect");
mysqli_select_db($GLOBALS["db_link"],"$IM_db")  or die ("Can not connect");
mysqli_query($GLOBALS["db_link"],"SET NAMES 'utf8'");