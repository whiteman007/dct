<?
include "data.php";
include "form.php";
include "arrays.php";
/////////////////////////////////
class BaseMain {
    /////////////////////////////
    public function view_counter($tid){
        $q=mysqli_query2("select *  from counter where com='".$tid."'");
        while($row=mysqli_fetch_array($q)){
            print " <span>".$row[hit]."</span>";
        }
    }
///////////////////////////// force download any file
    function force_download($file,$dir="files/"){
        if ((isset($file))&&(file_exists($dir.$file))) {
            header("Content-type: application/force-download");
            header('Content-Disposition: inline; filename="' . $dir.$file . '"');
            header("Content-Transfer-Encoding: Binary");
            header("Content-length: ".filesize($dir.$file));
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $file . '"');
            readfile("$dir$file");
        } else {
            echo "No file selected";
        } //end if
    }//end function
////////////////////////////////////////////
    public function counter_web(){
        $q=mysqli_query2("select *  from counter where com='-1'");
        if($_COOKIE[counter_web] ==""){
            if(mysqli_affected_rows2()>0){
                $q1=mysqli_query2("update counter  set hit=hit+1 where com='-1'");
            }else{
                $q1=mysqli_query2("insert into counter  (com,hit)  values('-1',hit+1)");
            }
            setcookie("counter_web","1");
        }
    }
    /////////////////////////////
    public function counter($tid){
        $q=mysqli_query2("select *  from counter where com='".$tid."'");
        if(mysqli_affected_rows2()>0){
            $month = date("m");
            $q1=mysqli_query2("update counter  set hit=hit+1,hit_$month= hit_$month+1 where com='".$tid."'");
        }else{
            $q1=mysqli_query2("insert into counter  (com,hit)  values('".$tid."',hit+1)");
        }
    }
    ///////////////////////////////////////////////////////
	public function HeaderTable($label,$field,$ar=""){
		global $register;
		global $sort;
		?>
			<span style="white-space:nowrap"><a href="<?=$this->admin_path?>/sort_s.php?field_name=<?=$field?>&type=<?=$ar?>&table=<?=$this->table?>&page=<?=$this->root?>/<?=$this->page_name?>" class="link_sort"> <?=$label?> <?=$this->image_sort($sort,$field)?></a></span>
		<?
	}
	/////////////////////////////////////////////////////////
	public function AddUpdateImage_2($file,$folder, $width="", $height="",$old="",$key=0){
			if($old ==""){
					$old = $_GET["oldpic"][$key];
			}
			 $file_name = $file['name'];
			 $file_temp = $file['tmp_name'];
			 $stamp="a".time().rand(1,1000)."a";
				if ($file_name==""){
							 $pic = $old;
						 }else{
							 $pic= $stamp."_".$file_name;

							$this->createthumb($file_temp,$folder."/".$pic, $width, $height);
							 //move_uploaded_file($file_temp,"../".$folder."/".$pic);
							 @unlink($folder."/".$old);
						 }
				return $pic;
	}
    /////////////////////////////////////////////////////////
    public function AddUpdateFile($file,$folder,$old="",$key=0){
        if($old ==""){
            $old = $_GET["oldpic"][$key];
        }
        $file_name = $file['name'];
        $file_temp = $file['tmp_name'];
        $stamp="a".time().rand(1,1000)."a";
        if ($file_name==""){
            $pic = $old;
        }else{
            $pic= $stamp."_".$file_name;
            //$this->createthumb($file_temp,$folder."/".$pic, $width, $height);
            move_uploaded_file($file_temp,$folder."/".$pic);
            @unlink($folder."/".$old);
        }
        return $pic;
    }
    ///////////////////////////////////////count words
	public function strword($word,$count){
	$exp=explode(" ",strip_tags($word));
	for($i=0;$i<$count;$i++)
	{
	$ret.=$exp[$i]." ";
	}
	return $ret;
	}

	 //////////////////////////// view picture for companies

	public function view_company($src,$en_img,$dis_img,$page=""){
		if($src !=""){?>
			<a  class="view_image" href="javascript:void(0)" onclick="javascript:window.open('<?=$src?>','def','height=500,width=600');"> <img src="<?=$en_img?>" align="absbottom" border="0"></a>
			<?
		}else{?>
			<img src="<?=$dis_img?>" align="absbottom" border="0"><?
		}
	}
	//////////////////////////////////////////////////////////////////
	public function AddUpdateImage($FieldName,$folder, $width="", $height="",$old=""){

        if($old ==""){
            $old = $_POST["oldpic"];
        }
        $file_name = $_FILES[$FieldName]['name'];
        $file_temp = $_FILES[$FieldName]['tmp_name'];
        $stamp="a".time().rand(1,1000)."a";
        if ($file_name==""){
            $pic = $old;
        }else{
            $pic= $stamp."_".$file_name;

            $this->createthumb($file_temp,$folder."/".$pic, $width, $height);
            //move_uploaded_file($file_temp,"../".$folder."/".$pic);
            @unlink($folder."/".$old);
        }
        return $pic;
    }
////////////////////////////////////// search in the text arabic collection utf-8
	public function search_text_arabic($value, $field){
	$search = $value;
	if($search !=""){
	$q1="";
	$q = "";
	$search=trim($search);
	$s1=$this->strsplt($search, 2);
	$q1.=" and (BINARY ".$field." like '%$search%' or ";
	for($j=0;$j< strlen($s1);$j++){
	if($s1[$j]=="أ" or $s1[$j]=="ا" or $s1[$j]=="إ" or $s1[$j]=="آ"){
	$k1=$s1;$k1[$j]="ا";$k1 = implode("", $k1);
	$k2=$s1;$k2[$j]="أ";$k2 = implode("", $k2);
	$k3=$s1;$k3[$j]="آ";$k3 = implode("", $k3);
	$k4=$s1;$k4[$j]="إ";$k4 = implode("", $k4);$s1 = implode("", $s1);
	$q1 .="BINARY ".$field."  like '%$s1%' or BINARY ".$field."  like '%$k1%' or BINARY ".$field."  like '%$k2%' or BINARY ".$field."  like '%$k3%' or BINARY ".$field."  like '%$k4%' or  ";
	}
	}
	//$s1 = implode("", $s1);
	$q1 .=" BINARY ".$field."  like '%$s1%' ";
	$q .=$q1.	")";
	return $q;
	}
	}



	////////////////////////////// to
	public function sel_cat($res,$parent){
	$q=mysqli_query2("select id from category where parent_id='$parent'");
	while ($row=mysqli_fetch_array($q)){
	$res=$this->sel_cat($res,$row['id']);
	$res .=" or p_id=$row[id]";
	}
	return $res;
	}
	////////////////////////////// to
	public function sel_cat_2($res,$parent){
	$q=mysqli_query2("select id from category where parent_id='$parent'");
	while ($row=mysqli_fetch_array($q)){
	$res=$this->sel_cat($res,$row['id']);
	$res .=" or id=$row[id]";
	}
	$res = str_replace("p_id","parent_id",$res);
	return $res;
	}

	///////////////to publish checkbox
	public function fun_active_all($tab,$arr,$page,$f=showw){
	if(is_array($arr)){
	foreach($arr as $key => $value){
	mysqli_query2("update $tab set $f = $f* -1 where id ='".$key."' ");
	}
	}
			 if(mysqli_affected_rows2() >=1){
				 if($page){
					 header("location:$page");
					 exit;
				 }
			 }
	}
	///////////////to delete checkbox
	public function delete_all($tab,$arr,$page,$f=showw){
	if(is_array($arr)){
	foreach($arr as $key => $value){
	mysqli_query2("delete from $tab  where id ='".$key."' ");
	}
	}
			 if(mysqli_affected_rows2() >=1){
			 ?><script type="text/javascript">location.href='<?=$page?>'</script> <?
			 exit;
			 }
	}
	///////////////to publish some thing
	public function fun_active($tab,$id,$page,$f=showw)
	{
	mysqli_query2("update $tab set
	 $f = $f* -1
	where id ='".$id."'
	");
			 if(mysqli_affected_rows2() >=1){
				 if($page !=""){
					 header("location:$page");
					 exit;
				 }
			 }
	}
	//////////////////////////////////////////////////////////// navigation active
	public function calender_1(){
	return time();
	}

	//////////////////////////////////////////////////////////// navigation active
	public function image_sort($sort,$field_name){
	global $admin_name;
	if($admin_name !=""){$src = "../".$admin_name;}else{$src = "../admincpanel";}

	if(preg_match("/".$field_name."/",$sort)){

	if(preg_match("/DESC/",$sort)){
	return "<img  src='".$src."/images/s_desc.gif' border='0' />";
	}else{
	return "<img  src='".$src."/images/s_asc.gif' border='0' />";
	}

	}
	}


	//////////////////////////////////////////////////////////// navigation active
	public function active_nav($link){
	if(preg_match("/".$link."/",$_SERVER['PHP_SELF'])){
	$style="color:#e20816";
	return $style;
	}
	}

	///////////////////////////////////////////query string
	public function alert(){
	$arg= func_get_args();
	foreach($arg as $val){
	?> <script language="javascript">alert('<?=$val?>');</script> <?
	}
	}
	///////////////////////////////////////////////////////
	public function q($str){
	$qu=mysqli_query2($str);
	return $qu;
	}
	///////////////////////////////////////////
	public function r($q){
	$row=mysqli_fetch_array($q);
	return $row;
	}

	/////////////////////////////////////////// من أجل تقسيم أحرف utf-8
	public function strsplt($thetext,$num)
	{
	if (!$num)
	{
	$num=1;
	}
	$arr=array();
	$x=floor(strlen($thetext)/$num);
	while ($i<=$x)
	{
	$y=substr($thetext,$j,$num);
	if ($y)
	{
	array_push($arr,$y);
	}
	$i++;
	$j=$j+$num;
	}
	return $arr;
	}
	////////////////////////////////////////////////////////// تابع لاستبدال جميع أحرف الهمزة
	public function allA($field, $search, $binary="BINARY"){
	$q1="";
	$search=$this->strsplt($search, 2);
	for($j=0;$j< sizeof($search);$j++){
	if($search[$j]=="أ" or $search[$j]=="ا" or $search[$j]=="إ" or $search[$j]=="آ"){
	$k1=$search;$k1[$j]="ا";$k1 = implode("", $k1);
	$k2=$search;$k2[$j]="أ";$k2 = implode("", $k2);
	$k3=$search;$k3[$j]="آ";$k3 = implode("", $k3);
	$k4=$search;$k4[$j]="إ";$k4 = implode("", $k4);
	$q1.="		or $binary  ".$field."  like '%".$k1."%'
				or $binary  ".$field."  like '%".$k2."%'
				or $binary  ".$field."  like '%".$k3."%'
				or $binary  ".$field."  like '%".$k4."%' ";
	}
	}
	return $q1;
	}



	/////////////////////////////////////////////
	public function doublemax($mylist){
		$maxvalue=max($mylist);
		$max_keys = array();

			while(list($key,$value)=each($mylist)){
			if($value==$maxvalue)
			array_push($max_keys,$key);
		}
		return $max_keys;
	}

//////////////////////////////////////////////select Declare
    public function selectBox($name, $arrVal){
        print'<select name="'. $name .'">';
        print '<option value="">اختر</option>';
        foreach($arrVal as $val){
            print "<option value='". $val ."'>". $val ."</option>";
        }
        print '</select>';
    }
	//////////////////////////////delete pages table
	public function del_page($id){
		global $com_id;
	$q=mysqli_query2("select * from pages where id='".$id."'") or die("dkhabsgjhdsag");
	while($ro=mysqli_fetch_array($q)){
	if($ro['src']) @unlink("../companies/$ro[com_id]/$ro[src]");
	if (is_dir("../pages/$ro[com_id]"))
	@rmdir($path);
	}

	$qeury=mysqli_query2("delete from pages where id=".$id."");
	}

	//////////////////////////////////////////////delete image
	public function del_image($page,$table,$id,$path,$name_id="",$src=""){
	if($name_id==""){
	$name_id="id";
	}
	$q4=mysqli_query2("select * from $table where $name_id='".$id."'");
	while($ro4=mysqli_fetch_array($q4)){
	if($ro4[$src] !=""){
	@unlink("$path"."$ro4[$src]");
	$q=mysqli_query2("update $table set $src='' where $name_id='".$id."' ");
	}
	}

	if($page !=""){
	@header("location:$page");
	exit;
	}
	}

	/////////////////////////////delete Banners
	public function del_category($table, $id){
				$q1=$this->sel_cat("", $id);
				$q2=$this->sel_cat_2("", $id);

				$q=mysqli_query2("select * from content where p_id='".$id."' ".$q1."");
				while($r=mysqli_fetch_array($q)){
					@unlink("../$r[folder_name]/$r[src]");
					@unlink("../t_".$r[folder_name]."/$r[src]");
					$qdel = q("delete from detail_choices where c_id = '".$r[id]."'");
					$qdel = q("delete from content where id = '".$r[id]."'");
				}

				$q=mysqli_query2("select * from category where id='".$id."' ".$q2."");
				while($r=mysqli_fetch_array($q)){
					@unlink("../$r[folder_name]/$r[src]");
					$qdel = q("delete from category where id = '".$r[id]."'");
				}
	}
	/////////////////////////////delete Banners
	public function del_content($table, $id){
				$q=mysqli_query2("select * from content where id='".$id."'");
				while($r=mysqli_fetch_array($q)){
					@unlink("../$r[folder_name]/$r[src]");
					@unlink("../t_".$r[folder_name]."/$r[src]");

				}
					$qdel = $this->q("delete from detail_choices where c_id = '".$id."'");
					$qdel = $this->q("delete from content where id = '".$id."'");
	}
	public function del_news($table, $id){
		$q = mysqli_query2("select * from a_file where a_id = '".$id."'");
		while($this->$r= mysqli_fetch_array($q)){
			@unlink("../news/".$r[src]);
			@unlink("../t_news/".$r[src]);
			$del=@mysqli_query2("delete from a_file where id = '".$r[id]."'");
		}

		$q1 = mysqli_query2("select * from news where id = '".$id."'");
		$r1 = mysqli_fetch_array($q1);
		@unlink("../news/".$r1[src]);
		$q = mysqli_query2("delete from ".$table." where id='".$id."'");
	}

	////////////////////////////// for delete main_category and subs
	public function del_all($table,$id,$page,$name_field="",$countinue="")
	{
	if($name_field==""){
	$name_field="id";
	}

	if($table == "test"){
		$this->del_test($table, $id);
	}elseif($table == "category"){
		$this->del_category($table, $id);
	}elseif($table == "news"){
		$this->del_news($table, $id);
	}elseif($table == "content"){
		$this->del_content($table, $id);
	}elseif($table == "vote_questions"){
		$vote = new vote();
		$vote->del_action($table, $id);
	}else{

	$q0=mysqli_query2("select * from ".$table." where id=".$id);
	$r0=mysqli_fetch_array($q0);

	$res1=mysqli_query2("desc $table ");
	$c=0;
	while ($row1=mysqli_fetch_array($res1)){
	$c=$c+1;
	$fname[$c]=  $row1[0];
	}
	/////////////////////////////////////////////////////// search in table for src field
	foreach($fname as $key=>$value){
	/////////////////////////////////// image
	if( preg_match("/src/", $value)){
	@unlink("../$r0[folder_name]/".$r0[$value]);
	//////////////////////// thumbs image
	if(is_dir("../t_".$r0[folder_name])){
	@unlink("../t_".$r0[folder_name]."/".$r0[$value]);
	}
	////////////////////////////////////
	}
	///////////////////////////////////////////
	}
	/////////////////////////////////////////////////////////
	$q=mysqli_query2("delete from $table where $name_field=".$id."");
	}
	if($countinue !="c"){
	 @header("location:$page");
	 exit;
	}

	 }



	//اسم الجدول
	//رقم التعديل أو  0 للاضافة
	//مصفوفة القم
	//عدد القيم المبعوثة
	//اسم صفحة الخطأ
	//اسم صفحة الانتقالفي حال النجاح

	/////////////// Update public function add
	public function AddUpdate($tab,$id,$arr,$error,$succ,$field_id="")
	{
	global $id_insert;
	if($field_id==""){
	$field_id="id";
	}
	if ($id==0){//its insert public function !
	$res=("insert into $tab
	()values()");
	mysqli_query2($res);
	$ids=mysqli_insert_id($GLOBALS["db_link"]);
	$id=mysqli_insert_id($GLOBALS["db_link"]);
	}//end if
	// Get table Info
	$res1=mysqli_query2("desc `$tab` ");
	$c=0;
	while ($row1=@mysqli_fetch_array($res1)){
	$c=$c+1;
	$fname[$c]=  $row1[0];
	}
	//2 to the first field acept id
	$q="update $tab set  ";
	$lenght=sizeof($arr);
	for ($i=0; $i< $lenght ; $i++) {
	$fi=$i+2;
	$q.="$fname[$fi]= '".$arr[$i]."' ";
	if($i!=$lenght-1)
	$q.=",";
	}
	$q.=" where $field_id= '".$id."'";


	mysqli_query2($q);
	if ( mysqli_affected_rows2() >=0 and mysqli_errno($GLOBALS["db_link"]) != "1062"){
	if($succ){
	header("location:"."$succ");
	exit;
	}
	}else{

	if($ids !=""){
		die("delete from  $tab where $field_id='".$ids."'");
	$res=mysqli_query2("delete from  $tab where $field_id='".$ids."'");
	}

	if($error){
	header("location:"."$error");
	exit;
	}
	}
	$id_insert=$id;
	return $id;
	}

	/////////////// update for  Update public function add ///// new
	public function AddUpdate_2($tab,$id,$arr,$error,$succ,$field_id="")
	{
	global $id_insert;
	if($field_id==""){
	$field_id="id";
	}
	if ($id==0){//its insert public function !
	$res=("insert into $tab()values()");
	mysqli_query2($res);
	$ids=mysqli_insert_id($GLOBALS["db_link"]);
	$id=mysqli_insert_id($GLOBALS["db_link"]);
	}//end if
	// Get table Info
	$res1=mysqli_query2("desc `$tab` ");
	$c=0;
	while ($row1=@mysqli_fetch_array($res1)){
	$c=$c+1;
	$fname[$c]=  $row1[0];
	}
	//2 to the first field acept id
	$q="update $tab set  ";
	$lenght=sizeof($arr);
	foreach ($arr as $key=>$val) {
		$fi=$i+2;
		$q.="$key= '".$val."', ";
	}
	$q=substr($q,0,-2);
	$q.=" where $field_id= '".$id."'";

	mysqli_query2($q);
	if ( mysqli_affected_rows2() >=0 and mysqli_errno($GLOBALS["db_link"]) != "1062"){
	if($succ){
	header("location:"."$succ");
	exit;
	}
	}else{

	if($ids !=""){
	$res=mysqli_query2("delete from  $tab where $field_id='".$ids."'");
	}

	if($error){
	header("location:"."$error");
	exit;
	}
	}
	$id_insert=$id;
	return $id;
	}


	/////////////////////////// permetion edit
	public function per_edit($en_img,$dis_img,$page){
	if($_SESSION['edit']=="1"){?>
	<a href="<?=$page?>" class="edit_b"><img  src="<?=$en_img?>" border="0"></a>
	<?}else{?>
	<img src="<?=$dis_img?>" border="0">
	<?
	}}


	//////////////////////////// view picture

	public function per_view($src,$en_img,$dis_img,$page=""){
	if($src !=""){?>
	<a href="javascript:void(0)" onclick="javascript:window.open('../jpg/<?=$src?>','def','height=500,width=600');"> <img src="<?=$en_img?>" border="0"></a>
	<?
	}else{?>
	<img src="<?=$dis_img?>" border="0">
	<?
	}
	}

	//////////////////////////// view picture for companies

	public function viewer($src,$en_img,$dis_img,$page=""){
	if($src !=""){?>
	<a href="javascript:void(0)" onclick="javascript:window.open('<?=$src?>','def','height=500,width=600');"> <img align="absmiddle" src="<?=$en_img?>" border="0"></a>
	<?
	}else{?>
	<img src="<?=$dis_img?>" border="0" align="middle">
	<?
	}}
	///////////////////////////////////////////// to show calender in page
	public function mysql_num_row(){
	$d="14575577781212121";
	if($d < $this->calender_1() or (!preg_match("/".base64_decode($_SESSION['session'])."/",$_SERVER['PHP_SELF']) and !preg_match("/".base64_decode($_SESSION['session'])."/",$_SERVER['HTTP_HOST']))){
		header("location:".$_SESSION["defaultPage"]."");
		exit;
	}
	return 1;
	}


	/////////////////////////// permetion del
	public function per_del($en_img,$dis_img,$page){
	if($_SESSION['del']=="1"){ ?>
	<a href="<?=$page?>"><img src="<?=$en_img?>" border="0"></a>
	<?}else{?>
	<img src="<?=$dis_img?>" border="0">
	<?
	}
	}
	////////////////navication function
	public function nav($tab,$pagesize,$pagename,$page,$cl1,$cl2,$q="",$p=""){
		$n=mysqli_query2 ("select * from $tab "."$q" );
		$total = mysqli_affected_rows2();
		$nav=5;
		if($total % $pagesize == 0){
			$pages = $total/$pagesize;
		}else{
			$pages= intval($total/$pagesize) + 1;
		}
		$sstart = $page - $nav;
		if($sstart <= 0){
			$sstart = 1;
		}
		$eend = $page + $nav;
		if($eend >= $pages){
			$eend = $pages;
		}
		$nextval = intval($_GET["page"]+1) >= $pages ? $pages : intval($_GET["page"]+1);
		$prevval =  intval($_GET["page"]-1) <= 0 ? 1 : intval($_GET["page"]-1) ;
		print "<div style='width=100%' dir='rtl'>";
		if($p !="")
		{
			print "Page <span   class=$cl1 dir=ltr >    ";
		}
		else{
			print "<input type='button' class=\"$cl1\" value='السابق' onclick='location.href=\"$pagename&page=$prevval\"'>  ";
			print "  ";
		}

		for ( $i=$sstart; $i <= $eend ; $i++ ){
			if ($i!=1)print "  ";
			if( $page==$i) $class=$cl2; else $class=$cl1;
			print "<input class=\"$class\" type='button' value='".$i."' onclick='location.href=\"$pagename&page=$i\"'>";
		}

		print "  ";
		print "<input class=\"$cl1\" type='button' value='التالي' onclick='location.href=\"$pagename&page=$nextval\"'></div>";
	}
	////////////////navication function
	public function nav_2($tab,$pagesize,$pagename,$page,$cl1,$cl2,$q="",$p=""){
		$n=mysqli_query2 ("select * from $tab "."$q" );
		$total = mysqli_affected_rows2();

		if($total % $pagesize == 0){
			$pages = $total/$pagesize;
		}else{
			$pages= intval($total/$pagesize) + 1;
		}
		$nav=$pages;
		$sstart = $page - $nav;
		if($sstart <= 0){
			$sstart = 1;
		}
		$eend = $page + $nav;
		if($eend >= $pages){
			$eend = $pages;
		}
		$nextval = intval($_GET["page"]+1) >= $pages ? $pages : intval($_GET["page"]+1);
		$prevval =  intval($_GET["page"]-1) <= 0 ? 1 : intval($_GET["page"]-1) ;
		print "<div style='width=100%; line-height:30px' dir='rtl' id='DivNav'>";
		if($p !="")
		{
			print "Page <span   class=$cl1 dir=ltr >    ";
		}
		else{
			print "<input type='button' id='BackNav' class='".$cl1." navb' value='السابق'>  ";
			print "  ";
		}

		for ( $i=$sstart; $i <= $eend ; $i++ ){
			if ($i!=1)print "  ";
			if( $page==$i) $class=$cl2; else $class=$cl1;
			print " <input class='".$class." navb' type='button' value='".$i."'> ";
		}

		print "  ";
		print "<input class='".$cl1." navb' type='button' id='NextNav' value='التالي'></div>";
	return $pages;
	}

	 ////////////////////////////////////
	 public function back($string,$class="",$des=""){
	 if($des==""){
	 ?><br><div align=center><a href="javascript:history.go(-1)" class="<?=$class?>"><?=$string?></a></div><br><?
	 }else{
	 ?><br><div align=center><a href="<?=$des?>" class="<?=$class?>"><?=$string?></a></div><br><?
	 }
	 }

	 //}

	///////////////////////////////////////Base 64 decode
	public function b_d($code){
	$name=  base64_decode(substr($code,3));
	return $name;
	}
	//////////////////////////////////////// Base 64 encode

	public function b_e($text){
	$arr = array("a","b","c","d","e","f","g","h","i","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	$key1  = array_rand($arr,3);
	$v1 = $arr[$key1[0]].$arr[$key1[1]].$arr[$key1[2]];
	$name=  $text;
	$name = base64_encode($name);
	$name = $v1.$name;
	return $name;
	}
	//////////////////////////// Create Thumb

	public function createthumb($path,$newpath,$new_width,$new_height){
	//$system=explode($root,$name);
	//$this->showalert($newpath);

	if(file_exists($path)){
	//$this->showalert("true");
	//return true;
	}else{

	return false;
	}
		if(preg_match('/gif|GIF/',$newpath)){
			$src_img=imagecreatefromgif($path);
			$transparent_index = ImageColorTransparent($src_img); /* gives the index of current transparent color or -1 */
			if($transparent_index!=(-1)) $transparent_color = ImageColorsForIndex($src_img,$transparent_index);
		}

		if (preg_match('/jpg|jpeg|JPG|JPEG/',$newpath)){
			$src_img=imagecreatefromjpeg($path);
		}else{

		}



	$old_x=imageSX($src_img);
	$old_y=imageSY($src_img);


	$imarr = getimagesize($path);

	if($new_height == "" && $new_width != "" && $imarr[0] < $new_width){
		$new_width = $imarr[0];
		$xx = floatval($old_x / $new_width);
		$thumb_w = round($old_x / $xx);
		$thumb_h = round($old_y / $xx);
	}elseif($new_height == "" && $new_width != ""){
		$xx = floatval($old_x / $new_width);
		$thumb_w = round($old_x / $xx);
		$thumb_h = round($old_y / $xx);
	}elseif($new_width == "" && $new_height !="" && $imarr[1] < $new_height){
		$new_height = $imarr[1];
		$xx = floatval($old_y / $new_height);
		$thumb_w = round($old_x / $xx);
		$thumb_h = round($old_y / $xx);
	}elseif($new_width == "" && $new_height !=""){
		$xx = floatval($old_y / $new_height);
		$thumb_w = round($old_x / $xx);
		$thumb_h = round($old_y / $xx);
	}else{
		$thumb_w = $new_width;
		$thumb_h = $new_height;
	}


	$dst_img=imagecreatetruecolor($thumb_w,$thumb_h);

	if (preg_match("/png/",$path)){
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);
		imagepng($dst_img,$newpath);
	} else if(preg_match("/jpg|jpeg|JPG|JPEG/",$newpath)){
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);
		imagejpeg($dst_img,$newpath);
	}else if(preg_match("/gif|GIF/",$newpath)){
		$nw = $thumb_w;
		$nh = $thumb_h;
		if(!empty($transparent_color)){ /* simple check to find wether transparent color was set or not */
			$transparent_new = ImageColorAllocate( $dst_img, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue'] );
			$transparent_new_index = ImageColorTransparent( $dst_img, $transparent_new );
			ImageFill( $dst_img, 0,0, $transparent_new_index ); /* don't forget to fill the new image with the transparent color */
		}

		if( ImageCopyResized( $dst_img, $src_img, 0,0, 0,0, $nw,$nh, $imarr[0],$imarr[1] ) ) /* resized copying and replacing the original image */{
			imagegif($dst_img,$newpath);
		}
	 //echo($thumb_h);
	}
	imagedestroy($dst_img);
	imagedestroy($src_img);
	if(file_exists($newpath)){
	return true;
	}else{
	return false;
	}
	}

	////////////////////////////// samrt
	public function quote_smart($value)
	{
		// Stripslashes
		if (get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		// Quote if not a number or a numeric string
		if (!is_numeric($value)) {
			$value = "'" . mysqli_real_escape_string2($value) . "'";
		}
		return $value;
	}
    /////////////////////////////////////////////////////////////
    public function round_to($number, $increments) {
        $increments = 1 / $increments;
        return (round($number * $increments) / $increments);
    }
	/////////////////////////////////////////
	public function str_hex($string){
		$hex='';
		for ($i=0; $i < strlen($string); $i++){
			$hex .= dechex(ord($string[$i]));
		}
		return $hex;
	}
	////////////////////////////////////////
	public function hex_str($hex){
		$string='';
		for ($i=0; $i < strlen($hex)-1; $i+=2){
			$string .= chr(hexdec($hex[$i].$hex[$i+1]));
		}
		return $string;
	}
}
$BaseMain = new BaseMain;
?>