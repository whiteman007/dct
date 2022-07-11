<?
include "cookie.php";
$key = $_GET['key'];
$type = $_GET['type'];
$table = $_GET['tab'];
$page = $_GET['page'];
$pagehome = $_GET['pagehome'];
$src = $_GET['src'];
$id = $_GET['id'];
$pa_id = $_GET['pa_id'];
$path = $_GET['path'];

if($table == "model"){
  $name_field = "mod_id"; 
}

if($_POST["act"] == "yes"){
  if(empty($_POST["no"])){

		if($table=="products"){
			//   $q1=mysqli_query2("select * from products where parent_id ");
			$q1=sel_cat("", $_GET['id']);
			$q2=sel_cat_2("", $_GET['id']);
			
			$q=mysqli_query2("select * from p_photo where p_id='".$_GET[id]."' ".$q1."");
			while($r=mysqli_fetch_array($q)){
				del_all("p_photo", $r['id'],$page, "", "c");
			}
			$q=mysqli_query2("select * from products where id='".$_GET[id]."' ".$q2."");
			while($r=mysqli_fetch_array($q)){
				del_all($table, $r['id'],$page, "", "c");
			}
			header("location:". $page ."&pa_id=". $pa_id);
			exit;				
		}else{
							del_all($table, $id, $page."&pa_id=". $pa_id, $name_field);
		}    
    }else{
		header("location:"."$_GET[page]&pagehome=$_GET[pagehome]&parent=$_GET[parent]&id=$_GET[id]&pa_id=$_GET[pa_id]&src=$_GET[src]&key=$_GET[key]&type=$_GET[type]");
		exit;
    }

}
include "head.php";
include "navigation.php";
?>
<p align='center' class='text'>
سيتم حذف البيانات هل تريد الاستمرار ؟
</p>
<form  method="post" action="confirm.php?id=<?=$id?>&src=<?=$src?>&num_cat=<?=$num_cat?>&id=<?=$_GET[id]?>&pa_id=<?=$_GET[pa_id]?>&page=<?=$page?>&pagehome=<?=$pagehome?>&tab=<?=$table?>&type=<?=$type?>&key=<?=$key?>&cat_id=<?=$cat_id?>&mar_id=<?=$mar_id?>&path=<?=$path?>&parent=<?=$parent?>&com_id=<?=$com_id?>">
<input type="hidden"  name="act" value="yes">
<input type="submit" value=" لا "   class="form1" size=8  name="no">
<input type="submit" value=" نعم  " class="form1"  size=8  name="yes">
</form>
<?
include "foot.php";
?>