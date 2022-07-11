<?
if(is_file("../logs/function_2.php"))
	include_once "../logs/function_2.php";
$ClassName = "poll";
class poll extends BaseMain{
		public $root;
		public $admin_path = "../admincpanel";
		public $table;
		public $page_name = "view.php";
		public $title = "استفتاء";
		public $pagesize = 30;
		public $folder_name = "photos";
        //////////////
        public $search_autocomplete_fields = "qu";
        public $search_fields_array = array("qu");
        public $search_title = "بحث بحسب السؤال";

//////////////////////////////////////////////////////////////////
	public function poll(){
			$this->root = "../app_$GLOBALS[ClassName]";
			$this->table = "poll_questions";
		}
//////////////////////////////////////////////////////////////////
	public function search($table, $page_name, $arr){
		$q = "";
		$q1="";
		$q1.=" and (";
		$search = $_GET["search"];
		if($search !=""){
			$search=trim($search);
			$s1=$this->strsplt($search, 2);
			foreach($arr as $val){ 	
				for($j=0;$j< count($s1);$j++){
					if($s1[$j]=="أ" or $s1[$j]=="ا" or $s1[$j]=="إ" or $s1[$j]=="آ"){
						$k1=$s1;$k1[$j]="ا";$k1 = implode("", $k1);
						$k2=$s1;$k2[$j]="أ";$k2 = implode("", $k2);
						$k3=$s1;$k3[$j]="آ";$k3 = implode("", $k3);
						$k4=$s1;$k4[$j]="إ";$k4 = implode("", $k4);
						$q1 .=" $val like BINARY '%$k1%' or $val like BINARY '%$k2%' or $val like BINARY '%$k3%' or $val like BINARY '%$k4%'  or  ";
					}
				}
				
				//alert(gettype($s1));
				$s2 = implode("", $s1);
				$q1 .=" $val like BINARY '%$s2%' or ";
			}
			
			$q.=$q1.	" 1<>1)";
		}
		// auto complete
		return $q;
	}
////////////////////////////////////////////////////////////////
	public function search_form($table,$label = "الاسم"){
		?>
        <form method="get" action="" id="form_search">
        <input type="hidden" name="f2" value="2" />
        <table width="800">
        <tr>
        <td align="center" dir="rtl" class="text"> <h4><?=$label?></h4><input type="text" value="<?=$_COOKIE[$table.'_search']?>"  size="60"  name="search" id="search" class="form1"> <input type="submit" value="بحث"    name="B1" class="form1  w3-btn w3-green"></td>
        </tr>
          <tr>
          <td valign="top" height="60" colspan="2"><div align="right" style="margin-right:0px" class="text_head" >
        
            </div>
            <div align="right"><hr align="right" size="2" width="100%" /></div>
            </td>
          </tr>        
        </table>
        </form>
		<?	
	}
////////////////////////////////////////////////////////////////
	public function search_autoComplete($name){
		$q_autocomplete = mysqli_query2("select * from ".$this->table." order by BINARY $name");
		$source="[";
		while($r_autocomplete = mysqli_fetch_array($q_autocomplete)){
			$source .="'".$r_autocomplete["$name"]."',"; 
		}
		$source .="'']";
		//die($source);		
		?>
		<script type="text/livescript">
        $(document).ready(function(){
                $("#search").autocomplete({
                    source : <?=$source?>,
                    open:function(){
                        $(".ui-autocomplete").css("opacity","0.95");
                    },
                });
            })
            
            </script>
			<?	
		}

	/////////////////////////////////// for Action delete for image, value or more 	
	public function delAction($table,$var,$type="once"){
		if($type == "all"){
			if(is_array($var)){
				foreach($var as $key => $value){
				//mysqli_query2("delete from $tab  where id ='".$key."' ");
					$this->delAction($table, $key,"once");
				}
			}
		}elseif($type=="image"){
			$q=mysqli_query2("select * from ".$table." where id='".$var."'");
			while($r=mysqli_fetch_array($q)){
				
				if($r["src"] !=""){ 
					@unlink($this->folder_name."/".$r["src"]);
					mysqli_query2("update  ".$table." set src='' where id = '".$r[id]."'");
				}
				if($r["src_1"] !=""){ 
					@unlink($this->folder_name."/".$r["src_1"]);
					mysqli_query2("update  ".$table." set src_1='' where id = '".$r[id]."'");
				}
				if($r["src_2"] !=""){ 
					@unlink($this->folder_name."/".$r["src_2"]);
					mysqli_query2("update  ".$table." set src_2='' where id = '".$r[id]."'");
				}			
			}				
		}else{

			//$q1=$this->del_All_IDs($table, "", $id);

            //////////  to delete sub categories for this id
            $cat = substr($this->table,-4);
            if($cat == "_cat"){
                $table_2 = substr($this->table,0,-4);
                $q=mysqli_query2("select * from ".$table_2." where category='".$var."'");
                while($r=mysqli_fetch_array($q)){

                    if($r["src"] !="") @unlink("../".$table_2."/".$this->folder_name."/".$r["src"]);
                    if($r["src_1"] !="") @unlink("../".$table_2."/".$this->folder_name."/".$r["src_1"]);
                    if($r["src_2"] !="") @unlink("../".$table_2."/".$this->folder_name."/".$r["src_2"]);

                    mysqli_query2("delete from ".$table_2." where id = '".$r[id]."'");
                }
            }
            ////////////////////////////////////////////////////


            $q=mysqli_query2("select * from ".$table." where id='".$var."' ".$q1."");
			while($r=mysqli_fetch_array($q)){
				
				if($r["src"] !="") @unlink($this->folder_name."/".$r["src"]);
				if($r["src_1"] !="") @unlink($this->folder_name."/".$r["src_1"]);
				if($r["src_2"] !="") @unlink($this->folder_name."/".$r["src_2"]);
				
				mysqli_query2("delete from ".$table." where id = '".$r[id]."'");
			}			
		}
			
	}

	
	////////////////////////////// add all ids to query
	public function del_All_IDs($table, $res,$parent){
		$q=mysqli_query2("select id from ".$table." where parent_id=$parent");
		while ($row=mysqli_fetch_array($q)){
			$res .=" or id=$row[id]";
			$res=$this->del_All_IDs($table, $res,$row['id']);
		}
		return $res;
	}

    ///////////////to publish some thing
    public function fun_active($tab,$id,$page,$f=showw){
        $q= mysqli_query2("select $f from $tab where id ='".$id."'");
        $r = mysqli_fetch_array($q);
        if($r[$f]=="-1"){
            mysqli_query2("update $tab set $f = -1");
        }
        mysqli_query2("update $tab set $f = $f* -1 where id ='".$id."'");
        if(mysqli_affected_rows2() >=1){
            if($page !=""){
                header("location:$page");
                exit;
            }
        }
    }

    ////////////////////////////////////////////////////////////////////
    public function uploadFiles($files){
        if(is_array($files)){
            foreach($files as $key =>$file){
                $key_or = $key;
                $key = explode("_",$key);
                $k = $key[0];
                $k1 = $key[1];
                if($k == "d2"){
                    $pic1[$key_or] = $this->AddUpdateImage_2($file,$this->folder_name,"150","90","",$k1);
                    //$pic1[$key_or] = $this->AddUpdateFile($file,$this->folder_name,$_GET["oldpic_2"][$k1],$k1);
                }else{

                    if($_GET["type"][$k1]=="بانر علوي"){
                        $width="622"; $height="366";
                    }elseif($_GET["type"][$k1]=="بانر جانبي"){
                        $width="272"; $height="157";
                    }else{
                        $width="150"; $height="150";
                    }

                    $pic1[$key_or] = $this->AddUpdateImage_2($file,$this->folder_name,$width,$height,"",$k1);

                }
            }
            if(is_array($pic1)){
                foreach($pic1 as $key => $val){
                    print "$key:$val-";
                }
            }
        }
        die();
    }
	//////////////////////////////////////////
	public function addAction(){		
		if ($_POST["act"]=="add"){
            //////////////////////////////// array files names
            if($_POST["upnames"]){
                $arr1 = explode("-",$_POST["upnames"]);
                $arr3 = array();
                $arr4 = array();

                for($i=0;$i<sizeof($arr1)-1;$i++){
                    $arr2 = explode(":",$arr1[$i]);
                    $arr2_2 = explode("_",$arr2[0]);
                    $index =  $arr2_2[1];
                    if($arr2_2[0]=="d2"){
                        $arr4[$index] = $arr2[1];
                    }else{
                        $arr3[$index] = $arr2[1];
                    }
                }
            }
			/////////////////////////////////////////////////	
			if(is_array($_POST["id"])){
				foreach($_POST["id"] as $key =>  $val){
						if($_POST["qu"][$key] !=""){

                            if($arr3[$key]!=""){$pic = $arr3[$key];}else{$pic = $_POST["oldpic"][$key];}
                            if($arr4[$key]!=""){$pic_2 = $arr4[$key];}else{$pic_2 = $_POST["oldpic_2"][$key];}

                            if(is_array($_POST['choices'])) $choices = array_reverse($_POST['choices']);

                            if($_POST["showw"][$key] == "1"){
                                $q= mysqli_query2("update ".$this->table." set showw='-1'");
                            }

                            $arr = array($_POST["qu"][$key],"",$_POST["showw"][$key]);
							$qid = $this->AddUpdate($this->table, $_POST["id"][$key], $arr, "", "");


                            mysqli_query2("delete from poll_choices where qu_id = '".$qid."'");
                            if(is_array($choices)){
                                for($i=0; $i < sizeof($choices); $i++){
                                    if($choices[$i] == "") continue;
                                    $arr1 = array($qid, $choices[$i],"","","");
                                    $gid = $this->AddUpdate("poll_choices","",$arr1,"process.php?err=5","");
                                }
                            }

						}else{
							print "error";
							die("");
						}
				}
							//success
							print "success";
							die("");										
			}
		}
	}	
}
${$ClassName} = new $ClassName;
?>