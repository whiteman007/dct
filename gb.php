<?
include "cookie.php";
$action=$_GET['action'];

include "head.php";
include "navigation.php";
$nr=$_GET['nr'];
echo "<p align=center><a href=$_SERVER[PHP_SELF] class=link2>تحديث الصفحة</a>";

// Connect zur Datenbank
include ("../gbook/config.php");


// Lِscht einen Eintrag aus der Datenbank

if ($action == "loeschen") {
  //die("delete from $table where nr = '$nr'");
  //mysqli_query2("delete from $table where nr = '$nr'");
  if(is_array($_GET['ArrId'])){
  foreach($_GET['ArrId'] as $key => $vale){

	  mysqli_query2("delete from $table where nr = '$key'");
	  }
  }
  ?>
  <script language="javascript">  
  location.href="gb.php";
  </script>
  <?

// Aktualisiert einen Datensatz

} elseif($action == "save") {
$name=$_POST["name"];
$email=$_POST["email"];
$hp=$_POST["hp"];
$inhalt=$_POST["inhalt"];
$kommentar=$_POST["kommentar"];
$showw=$_POST["showw"];
if($showw !=""){
$showw='1';
}
$nr=$_POST[nr];
  $sql = "UPDATE $table
             SET name      = '$name',
                 email     = '$email',
                 hp        = '$hp',
                 inhalt    = '$inhalt',
                 kommentar = '$kommentar',
				 showw = '$showw'
             WHERE nr = '$nr'";
  if (!mysqli_query2($sql))
    die(mysqli_error($GLOBALS["db_link"]) . '<br><pre>' . $sql . '</pre>');
  echo "<br>تم تنفيذ العملية بنجاح";


// Sucht den Bestimmten Datensatz herraus um sie zu aktualisieren

} elseif ($action == "updat") {

  $result = mysqli_query2("select * from $table where nr = '".$nr."' order by nr desc");
      $nr = mysql_result($result,$i,"nr");
      $name = mysql_result($result,$i,"name");
	  $open = mysql_result($result,$i,"open");
	  $email = mysql_result($result,$i,"email");
	  $hp = mysql_result($result,$i,"hp");
	  $inhalt = mysql_result($result,$i,"inhalt");
	  $kommentar = mysql_result($result,$i,"kommentar");
	  $showw = mysql_result($result,$i,"showw");
?>


<table width="500" dir=rtl style="text-align: center">
  <form action="<?php echo $PHP_SELF;?>?action=save" method=post>
    <input type=hidden name=nr VALUE="<? echo $nr ?>">
  <tr><td><b>الإسم</b></td>
    <td><input type=text name="name" value="<? echo $name ?>"></td>
  </tr><tr>
    <td><b>البريد</b></td>
    <td><input type=text name="email" value="<? echo $email ?>"></td>
  </tr><tr>
    <td><b>الموقع</b></td>
    <td><input type=text name="hp" value="<? echo $hp ?>"></td>
  </tr><tr>
    <td><b>التوقيع</b></td>
    <td><textarea name="inhalt"><? echo $inhalt ?></textarea></td>
  </tr>
  <tr>
    <td><b>تعليق المدير</b></td>
    <td><textarea name="kommentar" cols="30" rows="4"><? echo $kommentar ?></textarea></td>
  </tr>
    <tr>
    <td><b>الموافقة</b></td>
    <td><input type="checkbox" name="showw" <?=$showw=="1" ? "checked" : ""?>></td>
  </tr>
  <tr>
    <td> </td>
    <TD><input type=submit value="تنفيذ العملية"></form></td>
  </tr>
  </table><p>

<?php
// Gibt alle Datensنtze aus der Datenbank aus.

} else {

?><form action="" name="f3" method="get">
  <input type="hidden" name="action"  value="loeschen" />	 <?
  echo "<br><br><p align=".$align."><span dir=rtl><b>التواقيع :</b><br><br> ";
  echo "<center><table border='0' width='500' dir=rtl>";
  $result = mysqli_query2("select * from $table order by nr desc");
  if ($num = mysqli_num_rows($result)) {
    // Ausgabe der Datensنtze, wenn vorhanden

    for($i=0;$i < $num; $i++) {
      $nr = mysql_result($result,$i,"nr");
      $name = mysql_result($result,$i,"name");
	  $open = mysql_result($result,$i,"open");
	  $email = mysql_result($result,$i,"email");
	  $hp = mysql_result($result,$i,"hp");
	  $inhalt = mysql_result($result,$i,"inhalt");
	  $kommentar = mysql_result($result,$i,"kommentar");
	  $showw = mysql_result($result,$i,"showw");
	  $datum = mysql_result($result,$i,"datum");
	  
	  $ids=$nr;



	  $inhalt_fastfertig = nl2br($inhalt);
	  $inhalt_fertig = wordwrap( $inhalt_fastfertig,31," ",1);
	  ?>

	   <tr>

	    <td width="50">
		    <font size="2"  face="tahoma"><input name="ArrId[<?=$ids?>]"  value="1" type="checkbox"/>  <? echo $nr; ?></font>
		</td>
	     <td>
		    <font size="2" face="tahoma"><b><? echo $name; ?></b></font>
		</td>
	     <td align="<?=$align?>">
		    <?echo "<font size='1'><a class=link2 href='$PHP_SELF?nr=$nr&action=updat'>تحرير</a></font>"; ?>
		</td>
	     <td align="<?=$align?>">
		    <font size='1'><a class=link2 onclick="a=confirm('هل أنت متأكد أنك تريد الحذف ؟') ;if (a==true){f3.submit();};return false" href='#'>مسح</a></font>
		</td>
	   </tr>
	   <tr>
	   <td colspan="4">
	   <? echo "<font size='2' face='tahoma' >$inhalt_fertig";
	        echo "<br><br>";
	   if($kommentar !=""){
	        echo "<b>تعليق المدير :</b><br>$kommentar<br>";
	    }else{
	        echo "<b>لا يوجد تعليق للمدير.</b><br>";
	   }
	   if($showw=="1"){
	        echo "<b>تم الموافقة.</b><br>";
	    }else{
	        echo "<b>لم يتم الموافقة.</b><br>";
	   }
	  echo "<br><font size='2' face='tahoma' ><b>تاريخ الإضافة :</b> $datum</font><br><hr></td></tr>";
    }
 }else echo "لا يوجد مدخلات</font>";
 ?>
 </form>
 <?
}
?>
</table>
