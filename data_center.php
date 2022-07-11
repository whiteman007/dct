<?
include "cookie.php";
$dir = "../Uploads/";
$dir_2="Uploads";
$files = @scandir($dir);
if($_GET["action_type"]=="del" && $_GET["src"] != ""){
//die($dir.$_GET["src"]);
			@unlink($dir.$_GET["src"]);
         	header("location:data_center.php");
		 	exit;
}
include "head.php";
include "navigation.php";
$s=explode("/",$_SERVER['HTTP_HOST']."".$_SERVER['REQUEST_URI']);
$s1="http://";
for ($i=0;$i< sizeof($s) -2;$i++){
$s1 .=$s[$i]."/";
}
$s1 .=$dir_2."/";
?>

<table width="500">
	<tr>
		<td align="left" class="nav">&nbsp;</td>
		<td align="center" class="nav"><a href="download_center.php" class="add" style="font-weight:bold; font-size:12px; color:#FC0">إضافة ملف <br /><br /></a></td>
	</tr>
</table>
<table width="500" cellpadding="5" dir="rtl">
	<tr>
		<td class="th" align="center">الملف</td>    
		<td class="th" align="center" width="50">حذف</td>        
	</tr>

	<? 
	foreach ($files as &$file){ 
		if ($file !="." && $file !=".." &&  !preg_match("/.db|.ini|.exe|.bat|.dll|.rtf|.php|.js/i",$file)){
			?>
			<tr>
			<td class="td" align="center">
				<?
				$pieces = explode(".",$file);
				$ext = $pieces[count($pieces) - 1];
				$ext = strtolower($ext);
				if ((strtolower($ext) == "jpg") || (strtolower($ext) == "gif") || (strtolower($ext) == "bmp") || (strtolower($ext) == "png") || (strtolower($ext) == "tif") || (strtolower($ext) == "jpeg")){
					echo "<img src='../".$dir_2."/".$file."' border='0' width=100 >";
				}elseif (strtolower($ext) == "swf"){
					echo "<EMBED src=../".$dir_2."/".$file." menu=false quality=high  TYPE=\"application/x-shockwave-flash\"></embed>";
				}?><br /><span class="text_head"> <?=$s1?><?=$file?></span></td>
			<td class="td" align="center"><?
				per_del("images/del.gif","images/disdel.gif","data_center.php?action_type=del&src=".$file); ?></td>
			</tr>
			<?
		}
	}
		?>
</table>
<? include "foot.php"; ?>
