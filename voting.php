<?
include "cookie.php";

if($_POST[submit] !=""){

if($_POST[qa] !=""){
$question=$_POST["qa"];
$vote1=$_POST[a1a];
$vote2=$_POST[a2a];
$vote3=$_POST[a3a];
$vote4=$_POST[a4a];
$vote5=$_POST[a5a];
$arr= array($question,$vote1,$vote2,$vote3,$vote4,$vote5,date('d/m/Y'));


AddUpdate("voting",$_POST[id],$arr,"?res=failed","?res=success");
}else{
//header("location:"."process.php?err=1");
exit;
}
}
include "head.php";
include "navigation.php";
$q= mysqli_query2("select * from voting where id='1'");
$q1= mysqli_query2("select * from count_voting where id='1'");
$row=mysqli_fetch_array($q);
$row1=mysqli_fetch_array($q1);
if($row1[question]==$row[question]){
$flag='1';
}else{
$flag='';
}
 ?>
<form action="" method="post" name="form1"  enctype="multipart/form-data">
<table width="100%" cellspacing="0" cellpadding="0" class="border">
  <tr>
    <td width="10%">
        </td>
        <td align="right">
<table width="100%" dir="<?=$dir?>" height="400" cellspacing="0" cellpadding="0">
  <tr>
    <td  colspan="2" align="center" <?=$_GET[res]=="success" ? "class='orange'" : ""?>  dir="<?=$dir?>" height="20"><?=$_GET[res]=="success" ? "تم التعديل بنجاح." : ""?></td>
  </tr>
  <tr>
    <td align="center" colspan="2" class="text" height="100">إدارة التصويت</td>
  </tr>
  <tr>
  <?
$qs=explode(";",$row["question"]);
$qa=$qs[0];
$qe=$qs[1];
?>
    <td   align="right" class="text" dir="<?=$dir?>">السؤال : </td><td   colspan="2"  dir="<?=$dir?>"><div dir="<?=$dir?>"> <input type="text" size="30" class="form1" name="qa" value="<?=$qa?>"></div></td>
 </tr>


  <tr>

<?
$a1s=explode(";",$row[vote1]);
$a1a=$a1s[0];
$a1e=$a1s[1];
?>
    <td  align="right" class="text" dir="<?=$dir?>">الجواب الأول: </td><td  dir="<?=$dir?>"> <input type="text" size="20" class="form1" name="a1a" value="<?=$a1a?>"> </td><td   align="right"> <?=$flag=="1" ? $row1[vote1] : ''?></td>
 </tr>
  <tr>
<?
$a2s=explode(";",$row[vote2]);
$a2a=$a2s[0];
$a2e=$a2s[1];
?>

    <td  align="right" class="text" dir="<?=$dir?>">الجواب الثاني: </td><td dir="<?=$dir?>"> <input type="text" size="20" class="form1" name="a2a" value="<?=$a2a?>"> </td><td> <?=$flag=="1" ? $row1[vote2] : ''?></td>
 </tr>
  <tr>
<?
$a3s=explode(";",$row[vote3]);
$a3a=$a3s[0];
$a3e=$a3s[1];
?>
    <td  align="right" class="text" dir="<?=$dir?>">الجواب الثالث: </td><td dir="<?=$dir?>"> <input type="text" size="20" class="form1" name="a3a" value="<?=$a3a?>"></td><td> <?=$flag=="1" ? $row1[vote3] : ''?></td>
 </tr>
  <tr>
<?
$a4s=explode(";",$row[vote4]);
$a4a=$a4s[0];
$a4e=$a4s[1];
?>
    <td  align="right" class="text" dir="<?=$dir?>">الجواب الرابع: </td><td dir="<?=$dir?>"> <input type="text" size="20" class="form1" name="a4a" value="<?=$a4a?>"></td><td> <?=$flag=="1" ? $row1[vote4] : ''?></td>
 </tr>
  <tr>
<?
$a5s=explode(";",$row[vote5]);
$a5a=$a5s[0];
$a5e=$a5s[1];
?>
    <td  align="right" class="text" dir="<?=$dir?>">الجواب الخامس: </td><td dir="<?=$dir?>"> <input type="text" size="20" class="form1" name="a5a" value="<?=$a5a?>"> </td><td> <?=$flag=="1" ? $row1[vote5] : ''?></td>
 </tr>
  <tr>
  <td></td>
    <td align="center" height="50">
        <input type="hidden" class="form1" name="id" value="<?=$row[id]?>" />
        <input type="submit" name="submit" class="form1" value="تعديل" /></td>
          <td></td>
  </tr>
</table>
</td>
        <td width="10%"></td>
  </tr>
</table>
</form>