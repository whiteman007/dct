<?
class  meta{
		var $root = "../meta";
		var $admin_path = "../admincpanel";
		var $table="meta";
		var $page_name = "view.php";
		var $title = "رابط";
		var $folder_name = "photos";	
//////////////////////////////////////////////////////////////////
	function search($table, $page_name){

		if($_GET['f2'] == 2){
			setcookie($table."_search", $_GET['search']);
			header("location:". $page_name);
			exit;
		}

			$search = $_COOKIE[$table."_search"];
			if($search !=""){
		$q = "";
		$q1="";
		$search=trim($search);
		$s1=strsplt($search, 2);
		$q1.=" and (src like '%$search%' or ";
		for($j=0;$j< count($s1);$j++){
		if($s1[$j]=="أ" or $s1[$j]=="ا" or $s1[$j]=="إ" or $s1[$j]=="آ"){
		$k1=$s1;$k1[$j]="ا";$k1 = implode("", $k1);
		$k2=$s1;$k2[$j]="أ";$k2 = implode("", $k2);
		$k3=$s1;$k3[$j]="آ";$k3 = implode("", $k3);
		$k4=$s1;$k4[$j]="إ";$k4 = implode("", $k4);$s1 = implode("", $s1);
		$q1 .="src  like '%$s1%' or src  like '%$k1%' or src  like '%$k2%' or src  like '%$k3%' or src  like '%$k4%'  or  ";
		}
		}
		//$s1 = implode("", $s1);
		$q1 .=" src  like '%$s1%'";
		$q.=$q1.	")";
		}
		return $q;
	}



////////////////////////////////////////////////////////////////
function search_form($table){
		?>
        <form method="get" action="">
        <input type="hidden" name="f2" value="2" />
        <table width="800">
        <tr>
        <td align="right" dir="rtl" class="text"> الاسم <input type="text" value="<?=$_COOKIE[$table.'_search']?>"  size="60"  name="search" class="form1"> <input type="submit" value="بحث"    name="B1" class="form1"></td>
        </tr>
          <tr>
          <td valign="top" height="60" colspan="2"><div align="right" style="margin-right:0px" class="text_head" >
        
            </div>
            <div align="right"><hr align="right" width="100%" /></div>
            </td>
          </tr>        
        </table>
        </form>
		<?	
	}
			/////////////////////////////////// for delete more than one record
			function deleteAll($tab,$arr,$page,$f=showw){
			if(is_array($arr)){
			foreach($arr as $key => $value){
			//mysqli_query2("delete from $tab  where id ='".$key."' ");
			$this->delAction($tab, $key);
			}
			}
					 if(mysqli_affected_rows($GLOBALS["db_link"]) >=1){
					 header("location:$page");
					 exit;
					 }
			}
			
			////////////////////////////// add all ids to query
			function del_All_IDs($table, $res,$parent){
			$q=mysqli_query2("select id from ".$table." where parent_id=$parent");
			while ($row=mysqli_fetch_array($q)){
			$res .=" or id=$row[id]";
			$res=$this->del_All_IDs($table, $res,$row['id']);
			}
			return $res;
			}
			
			/////////////////////////////delete Action
			function delAction($table, $id){

						//$q1=$this->del_All_IDs($table, "", $id);
						$q=mysqli_query2("select * from ".$table." where id='".$id."' ".$q1."");
						while($r=mysqli_fetch_array($q)){
							//die("/photos/".$r["src"]);
							@unlink("photos/".$r["src"]);
							@unlink("photos/".$r["src_2"]);
							mysqli_query2("delete from ".$table." where id = '".$r[id]."'");
						}			
			}
			//////////////////////////////////////////
	
	}
$meta = new meta;
?>
