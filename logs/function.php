<?
include "data.php";
function sendMail($address = "omarh2006@gmail.com",$subject = "test message Subject",$body ="test message Body",$addReply = "",$addCC=""){
    $mail             = new PHPMailer();
    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->Host       = "mail.satta.org.sy"; // SMTP server
    //$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
// 1 = errors and messages
// 2 = messages only
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->Port       = 587;                    // set the SMTP port for the GMAIL server
    $mail->Username   = "smtp@".$_SERVER['HTTP_HOST']; // SMTP account username
    $mail->Password   = "Omarh2006";        // SMTP account password
    $mail->SetFrom('smtp@'.$_SERVER['HTTP_HOST'], $_SERVER['HTTP_HOST']);
    if($addReply)
    $mail->AddReplyTo($addReply);
    $mail->Subject    = $subject;
    $mail->MsgHTML($body);
    if($addCC)
        $mail->AddCC($addCC,'');
    $mail->AddAddress($address,'');
    //$mail->AddAttachment("images/phpmailer.gif");      // attachment
    //$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
    if(!$mail->Send()) {
        return false;
    } else {
        return true;
    }
}
$month_abb = explode(" ","Zer Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec");
function xss_clean($data){
    $arr = array("'",'"',"&quot;","%27","script","--","XOR","sleep","if(","=","(",")");
    $pattern = array("/DELETE\s+FROM/i","/insert\s+into/i","/select\s+FROM/i");
    if($data) $data = preg_replace($pattern," ",$data);
    if($data) $data = str_replace($arr,"",$data);
    if(is_string($data)) $data = addslashes($data);
    if(is_string($data)) $data = strip_tags($data);
    if(is_string($data)) $data = htmlspecialchars($data);
    return $data;
}
/////////////////
function secure_website(){
    if(is_array($_GET))
        foreach($_GET as $key => $val){
            $_GET[$key] = xss_clean($val);
        }
    if(is_array($_POST))
        foreach($_POST as $key => $val){
            if($_POST["text"]){
            continue;
            }
            $_POST[$key] = xss_clean($val);
        }
    /*
    if(is_array($_SESSION))
        foreach($_SESSION as $key => $val){
            if($key !="t_pass" && $key !="t_username")
            $_SESSION[$key] = xss_clean($val);
        }
    */
    if(is_array($_COOKIE))
        foreach($_COOKIE as $key => $val){
            $_COOKIE[$key] = xss_clean($val);
        }
    if(is_array($_SERVER))
        foreach($_SERVER as $key => $val){
            $_SERVER[$key] = xss_clean($val);
        }
}
function counter_admin($com,$count){
    if($com == ""){
        $com = -1;
    }

    $q=mysqli_query2("select *  from counter where com='".$com."'");
    if(mysqli_affected_rows2()>0){
        $q1=mysqli_query2("update counter  set hit=".mysqli_real_escape_string2($count)." where com='".$com."'");
    }else{
        $qcon = mysqli_query2("select id from page where id = '".$com."'");
        if(mysqli_affected_rows2()>0){

            $q1=mysqli_query2("insert into counter  (com,hit)  values('".$com."','".mysqli_real_escape_string2($count)."')");
        }
    }
}
function default_image($row,$default_src,$default_small = true){
    if($default_small){
        if($row["src"] !="") {
            $back_img = "pages/photos/".rawurlencode($row["src"]);
        } elseif($row["src_2"] !=""){
            $back_img = "pages/photos/".rawurlencode($row["src_2"]);
        }else{
            $back_img = $default_src;
        }
    }else{
        if($row["src_2"] !="") {
            $back_img = "pages/photos/".rawurlencode($row["src_2"]);
        } elseif($row["src"] !=""){
            $back_img = "pages/photos/".rawurlencode($row["src"]);
        }else{
            $back_img = $default_src;
        }

    }
    return $back_img;
}
///////////////////////// print valid link
function link_url($r_pages){
    global $type,$ext_page,$the_target,$ext;
    $the_target = "_self";
    $type_page = $r_pages["type_page"];
    //if($type_page == ""){$type_page = "page";}
    $type_page = "page";
    if($r_pages["ext_link"] !=""){
        if(preg_match("/^http/",$r_pages["ext_link"])){
            $link_page = $r_pages["ext_link"];
            $the_target ="_blank";
        }else{
            if($ext_page == "ar/"){
                $link_page = "ar/".$r_pages["ext_link"];
            }elseif($ext_page == "en/"){
                $link_page = "en/".$r_pages["ext_link"];
            }
            $link_page = str_replace("//","/",$link_page);
        }
    }else{

        $link_page = $ext_page.$type_page."/".$r_pages["cleanurl".$ext];
    }
    return $link_page;
}
///////////////////// head pages new
function head_pages_2($class,$parent,$type="",$level="0")
{
    global $label_main,$dir,$dir_r,$align,$align_r,$ext;
    $q=mysqli_query2("select * from page where id='$parent'");
    if(mysqli_affected_rows($GLOBALS["db_link"])>0 && $type != $parent){

        while($row=mysqli_fetch_array($q)){
            if($row["name"]){
                $name = $row["name"];
            }else{
                $name = $row["name_en"];
            }
            ?>
            <div style=" text-align: left;direction: <?=$dir?>; display: inline-block; color: #ffffff"> <a href="view.php?pa_id=<?=$row['id']?>"  class="<?=$class?>" ><?=$name?></a> |</div>
            <?
            head_pages_2($class,$row['parent_id'],$type);
        }
    }else{

        ?>
        <div style="text-align: left;direction: <?=$dir?>; display: inline-block; color: #ffffff "> <a href="view.php?reset=1" class="<?=$class?>" ><?=$label_main?></a> | </div>


        <?
        if($type == $parent){
            return false;
        }

    }
}
/////////////////// top category
function top_category($id,$child){
    $q = mysqli_query2("select id,parent_id from page where id = ".$child);
    while ($r = mysqli_fetch_array($q)){
        if($r["id"] == $id){
            return false;
        }else{
            $sid =$r['id'].",".top_category($id,$r["parent_id"]);
        }
        return $sid;

    }
}
/////////////// All childs
function categoryChild($id) {
    $s = "SELECT ID FROM page WHERE  parent_id = $id";
    $r = mysqli_query2($s);

    $children = array();

    if(mysqli_num_rows($r) > 0) {
        # It has children, let's get them.
        while($row = mysqli_fetch_array($r)) {
            # Add the child to the list of children, and get its subchildren
            $children[$row['ID']] = categoryChild($row['ID']);
        }
    }

    return $children;
}
////////////////////// Count All Results for parent id
function count_all($id){
    $q = mysqli_query2("select count(*) as count from page where parent_id = ".$id);
    $r = mysqli_fetch_array($q);
    return $r["count"];
}
//////////////// path root
function pathUrl($dir = __DIR__){

    $root = "";
    $dir = str_replace('\\', '/', realpath($dir));

    //HTTPS or HTTP
    $root .= !empty($_SERVER['HTTPS']) ? 'https' : 'http';

    //HOST
    $root .= '://' . $_SERVER['HTTP_HOST'];

    //ALIAS
    if(!empty($_SERVER['CONTEXT_PREFIX'])) {
        $root .= $_SERVER['CONTEXT_PREFIX'];
        $root .= substr($dir, strlen($_SERVER[ 'CONTEXT_DOCUMENT_ROOT' ]));
    } else {
        $root .= substr($dir, strlen($_SERVER[ 'DOCUMENT_ROOT' ]));
    }

    $root .= '/';

    return $root;
}
///////////////////////////////////////////////
function cleanurl($string, $force_lowercase = true, $anal = false) {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
        "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
        "â€”", "â€“", ",", "<", ".", ">", "/", "?","؟");
    $clean = trim(str_replace($strip, " ", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
    $clean =  ($force_lowercase) ?
        (function_exists('mb_strtolower')) ?
            mb_strtolower($clean, 'UTF-8') :
            strtolower($clean) :
        $clean;

    return $clean;
}
/////////////////////// Add required

function add_required() {
    $args = func_get_args();

    if(is_array($args)){
        foreach($args as $param){
            if($_COOKIE["parent_id"] == $param){
                return "required";

            }
        }
    }
    return "";
}

///////////////////////Set selected
function set_selected($get, $val){
    if($get == $val){
        return "selected";
    }
}
///////////////////////Hide
function hide_top_level() {
    global $row;
    $args = func_get_args();

    if(is_array($args)){
        foreach($args as $param){
            if($row["id"] == $param){
                return "w3-hide";

            }
        }


    }
    return "";
}
///////////////////////Hide
function hide() {
    $args = func_get_args();

    if(is_array($args)){
        foreach($args as $param){
            if($_COOKIE["parent_id"] == $param){
                return "style='display:none'";

            }
        }


    }
    return "";
}
///////////////////////disable link
function is_photo_video_disable() {
    global $row;
            if($row["place"] == "Video" or $row["place"] == "Photo"){
                return "onclick='return false' style='cursor:text'";

            }
    return "";
}
///////////////////////disable link
function disable_top_level() {
    global $row;
    $args = func_get_args();

    if(is_array($args)){
        foreach($args as $param){
            if($row["id"] == $param){
                return "onclick='return false' style='cursor:text'";

            }
        }


    }
    return "";
}
///////////////////////disable link
function disable() {
    $args = func_get_args();

    if(is_array($args)){
        foreach($args as $param){
            if($_COOKIE["parent_id"] == $param){
                return "onclick='return false'  style='cursor:text'";

            }
        }


    }
    return "";
}
///////////////////////hide sub
function hide_sub() {
    $args = func_get_args();
    if(is_array($args)){
        foreach($args as $param){
            $q = mysqli_query2("select * from page where parent_id = ".$param);
            while($r = mysqli_fetch_array($q))
                if($_COOKIE["parent_id"] == $r["id"]){
                    return "style='display:none'";

                }
        }
    }
    return "";
}
///////////////////////Show sub for service
function show_sub_service() {
            $q = mysqli_query2("select * from page where id = ".$_COOKIE["parent_id"]);
            while($r = mysqli_fetch_array($q))
                if($r["place"] == "Service"){
                    return "style='display:block'";

                }
    return "";
}
///////////////////////Show sub
function show_sub() {
    $args = func_get_args();
    if(is_array($args)){
        foreach($args as $param){
            $q = mysqli_query2("select * from page where parent_id = ".$param);
            while($r = mysqli_fetch_array($q))
            if($_COOKIE["parent_id"] == $r["id"]){
                return "style='display:block'";

            }
        }
    }
    return "";
}
///////////////////////Show
function show() {
    $args = func_get_args();

    if(is_array($args)){
        foreach($args as $param){
            if($_COOKIE["parent_id"] == $param){
                return "style='display:block'";

            }
        }


    }
    return "";
}
function show_menu() {
global $the_parent,$pid;
    $args = func_get_args();
    if(is_array($args)){
        foreach($args as $param){
            if($the_parent == $param || $pid == $param){
                return "style='display:block !important'";
            }
        }
    }
    return "";
}




/////////////////////////////

function view_counter($com){
    if($com == "" || $com == 1){
        $com = -1;
    }
    $q=mysqli_query2("select *  from counter where com='".$com."'");
    while($row=mysqli_fetch_array($q)){
        return $row["hit"];
    }
}
/////////////////////////////
function max_counter($dir,$ext){
    $q=mysqli_query2("select *  from counter order by hit desc limit 7");
    ?><ul class="add" dir="<?=$dir?>"><?
    while($row=mysqli_fetch_array($q)){
        $qo = mysqli_query2("select name,name_en from content where id = '".$row[com]."'");
        $ro = mysqli_fetch_array($qo);
        ?><li><a href="index<?=$ext?>.php?type=view&code=<?=base64_encode($row[com])?>" class="add"><?=$ro["name".$ext]?></a></li><?
    }
    ?></ul><?
}


/////////////////////////////
function counter($com){
    if($com == ""){
        $com = -1;
    }
    $q=mysqli_query2("select *  from counter where com='".$com."'");
    if(mysqli_affected_rows2()>0){
        $q1=mysqli_query2("update counter  set hit=hit+1 where com='".$com."'");
    }else{
        $qcon = mysqli_query2("select id from page where id = '".$com."'");
        if(mysqli_affected_rows2()>0){
            $q1=mysqli_query2("insert into counter  (com,hit)  values('".$com."',hit+1)");
        }
    }
    if($com > 1){
        $q1=mysqli_query2("update counter  set hit=hit+1 where com='-1'");
    }

}
/////////////////////////////
function head_pages($class,$parent,$type="",$level="0")
{
    global $label_main,$dir,$dir_r,$align,$align_r,$ext;
    $q=mysqli_query2("select * from page where id='$parent'");
    if(mysqli_affected_rows($GLOBALS["db_link"])>0 && $type != $parent){
        while($row=mysqli_fetch_array($q)){
            if($row["name_en"]){
                $name = $row["name_en"];
            }else{
                $name = $row["name"];
            }
            $dir2 = "ltr";
            $align_r2= "right";

            ?>
            <div style="direction: <?=$dir?>; float: <?=$align_r2?>; color: #ffffff"> <a href="view.php?pa_id=<?=$row['id']?>"  class="<?=$class?>" ><?=$name?></a> |</div>
            <?
            head_pages($class,$row['parent_id'],$type);
        }
    }else{

        ?>
        <div style="direction: <?=$dir2?>; float: <?=$align_r2?>; color: #ffffff "> <a href="view.php?reset=1" class="<?=$class?>" >Home</a> | </div>
        </div>
        <br style="clear: both">
        <?
        if($type == $parent){
            return false;
        }

    }
}
///////////////////////header
function head($class,$parent,$type="",$level="0")
{
    $q=mysqli_query2("select * from news where id='$parent'");
    if(mysqli_affected_rows($GLOBALS["db_link"])>0 && $type != $parent){
        while($row=mysqli_fetch_array($q)){
            ?>
            <div style="direction: rtl; float: left; color: #ffffff"> <a href="../news_F/view.php?pa_id=<?=$row['id']?>"  class="<?=$class?>" ><?=$row[name]?></a> |</div>
            <?
            head($class,$row['parent_id'],$type);
        }
    }else{

            ?>
            <div style="direction: rtl;float: left; color: #ffffff "> <a href="../news_F/view.php?reset=1" class="<?=$class?>" >الرئيسية</a> | </div>
        </div>
        <br style="clear: left">
    <?
        if($type == $parent){
            return false;
        }

    }
}

///////////////////////header
function head_main($class,$parent,$level="0",$type="")
{
    global $ext,$ext_page;
    $q=mysqli_query2("select * from page where id=".$parent);
    if(mysqli_affected_rows($GLOBALS["db_link"])>0){
        while($row=mysqli_fetch_array($q)){
            $q1 = mysqli_query2("select id from page where parent_id = ".$row["id"]);
            if(mysqli_affected_rows($GLOBALS["db_link"])>0){
                $link = $ext_page."cat/".$row["cleanurl".$ext];
            }else{
                $link = link_url($row);
            }
            ?>
            <div  class="w3-show-inline-block rtl"> <a href="<?=$link?>"  class="<?=$class?>" ><?=$row["name"]?></a>  / </div>
            <?
            head_main($class,$row['parent_id']);
        }
    }else{
        if($type ==""){
            ?>
            <div class="w3-show-inline-block rtl"> <a href="<?=$ext_page?>"  class="<?=$class?>" >الرئيسية</a> / </div>
        <?
        }
        ?>


    <?
    }
}


/////////////////////////////////////////////////////////////////// text box
function FormText($title, $name, $value, $important= "", $class="form1"){
    global $align;
?>
    <tr>
        <td class="text_head"><?=$title?>: <?=$important !="" ? "<font class='star'>*</font>" : ""?></td>
        <td align="<?=$align?>"><input type="text" name="<?=$name?>" value="<?=$value?>"  size="45" class="<?=$class?>"></td>
    </tr>

<?
}
//////////////////////////////////////////////////////////////// select box
function FormSelect($title, $name, $value,$array, $important= "", $class="form1"){
?>
    <tr>
        <td align="right" class="text_head" dir="rtl"> <?=$title?>: </td>
      <td align="right">
        <select name="<?=$name?>" class="form1">
			<?
            if(is_array($array)){
                    foreach($array as $key => $val){
                            ?>
                                <option value="<?=$key?>" <?=$value == $key ? "selected" : ""?>><?=$val?></option>
                            <?
                        }
                }
            ?>
        </select>
      </td>
    </tr>

<?
}
///////////////////////////////////////count words
function strword($word,$count)
{
$exp=explode(" ",strip_tags($word));
for($i=0;$i<$count;$i++)
{
$ret.=$exp[$i]." ";
}
return $ret;
}
//////////////////////////////////////////////////////////////////
function AddUpdateFile($FieldName,$folder,$old="oldpic"){

         $old = $_POST[$old];
         $file_name = $_FILES[$FieldName]['name'];
         $file_temp = $_FILES[$FieldName]['tmp_name'];
		 $stamp="a".time().rand(1,1000)."a";
			if ($file_name==""){
						 $pic = $old;
					 }else{
						 $pic= $stamp.$file_name;

						 //createthumb($file_temp,$folder."/".$pic, $width, $height);

						 move_uploaded_file($file_temp,$folder."/".$pic);
						 @unlink($folder."/".$_POST[$old]);
					 }
			return $pic;
		 }
//////////////////////////////////////////////////////////////////
function AddUpdateImage($FieldName,$folder, $width="", $height="",$old="oldpic"){


         $file_name = $_FILES[$FieldName]['name'];
         $file_temp = $_FILES[$FieldName]['tmp_name'];
		 $stamp="a".time().rand(1,1000)."a";
			         if ($file_name==""){
						 $pic = $_POST[$old];
					 }else{

                        if(preg_match("/png/",$file_name)) {
                            $pic = AddUpdateFile($FieldName,$folder,$old);
                        }else{
                             $pic= $stamp.$file_name;
                             createthumb($file_temp,$folder."/".$pic, $width, $height);
                             //move_uploaded_file($file_temp,"../".$folder."/".$pic);
                             @unlink($folder."/".$_POST[$old]);
                        }
					 }
			return $pic;
		 }
		 /////////////////////////////////////////////////////////////// multiple images
		 function AddUpdateImageMultiple($FieldName,$folder, $width="", $height="",$old="oldpic"){
                $pic_all = "";
                if(is_array($_FILES[$FieldName])){
                    $total = count($_FILES[$FieldName]['name']);
                    if($total > 0 && $_FILES[$FieldName]['name'][0]){
                        for($i=0 ;$i< $total; $i++){
                            $file_name = $_FILES[$FieldName]['name'][$i];
                            $file_temp = $_FILES[$FieldName]['tmp_name'][$i];
                            $stamp= time()."-";
                            $pic= $stamp.$file_name;
                            createthumb($file_temp,$folder."/".$pic, $width, $height);
                            $pic_all .=$pic ."*";
                        }
                    }else{
                        $pic_all = $_POST[$old];
                    }
                }else{
                    $pic_all = $_POST[$old];
                }
                return $pic_all;
		 }
////////////////////////////////////// search in the text arabic collection utf-8
function search_text_arabic($value, $field){
$search = $value;
if($search !=""){
$q1="";
$q = "";
$search=trim($search);
$s1=strsplt($search, 2);
$q1.=" and (BINARY ".$field." like '%$search%' or ";
for($j=0;$j< sizeof($s1);$j++){
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
$q .=$q1.	") ";
return $q;
}
}

//////////////////////////// Auto load for class
function __autoload($class_name) {
if(preg_match("/admin/", $_SERVER['REQUEST_URI'])){
	require_once '../classes/'. $class_name .'.php';
}else{
	require_once 'classes/'. $class_name .'.php';
}

}

////////////////////////////// to
function sel_cat($res,$parent){
$q=mysqli_query2("select id from category where parent_id='$parent'");
while ($row=mysqli_fetch_array($q)){
$res=sel_cat($res,$row['id']);
$res .=" or p_id=$row[id]";
}
return $res;
}
////////////////////////////// to
function sel_cat_2($res,$parent){
$q=mysqli_query2("select id from category where parent_id='$parent'");
while ($row=mysqli_fetch_array($q)){
$res=sel_cat($res,$row['id']);
$res .=" or id=$row[id]";
}
$res = str_replace("p_id","parent_id",$res);
return $res;
}

///////////////to publish checkbox
function fun_active_all($tab,$arr,$page,$f=showw){
if(is_array($arr)){
foreach($arr as $key => $value){
mysqli_query2("update $tab set $f = $f* -1 where id ='".$key."' ");
}
}
         if(mysqli_affected_rows($GLOBALS["db_link"]) >=1){
         header("location:$page");
         exit;
         }
}
///////////////to delete checkbox
function delete_all($tab,$arr,$page,$f=showw){
if(is_array($arr)){
foreach($arr as $key => $value){
    mysqli_query2("delete from $tab  where id ='".$key."' ");
}
}
         if(mysqli_affected_rows($GLOBALS["db_link"]) >=1){
         header("location:$page");
         exit;
         }
}
///////////////to publish some thing
function fun_active($tab,$id,$page,$f=showw)
{

mysqli_query2("update $tab set
 $f = $f* -1
where id ='".$id."'
");


         if(mysqli_affected_rows($GLOBALS["db_link"]) >=1){
         ?><script type="text/javascript">location.href = "<?=$page?>"</script><?
         exit;
         }
}
//////////////////////////////////////////////////////////// navigation active
function calender_1(){
return time();
}

//////////////////////////////////////////////////////////// navigation active
function image_sort($sort,$field_name){
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
function active_nav($link){
if(preg_match("/".$link."/",$_SERVER['PHP_SELF'])){
$style="color:#e40613";
return $style;
}
}

///////////////////////////////////////////query string
function alert(){
$arg= func_get_args();
foreach($arg as $val){
?> <script language="javascript">alert('<?=$val?>');</script> <?
}
}
//////////////////////////////////
function mysqli_query2($str){
    $qu=mysqli_query($GLOBALS["db_link"],$str);
    return $qu;
}
///////////////////////////////////////////////////////
function q($str){
$qu=mysqli_query2($str);
return $qu;
}
///////////////////////////////////////////
function r($q){
$row=mysqli_fetch_array($q);
return $row;
}

/////////////////////////////////////////// من أجل تقسيم أحرف utf-8
function strsplt($thetext,$num)
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
function allA($field, $search, $binary="BINARY"){
$q1="";
$search=strsplt($search, 2);
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
function doublemax($mylist){
    $maxvalue=max($mylist);
    $max_keys = array();

        while(list($key,$value)=each($mylist)){
        if($value==$maxvalue)
        array_push($max_keys,$key);
    }
    return $max_keys;
}


//////////////////////////////delete pages table
function del_page($id){
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
function del_image($page,$table,$id,$path,$name_id="",$src=""){
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



////////////////////////////// for delete main_category and subs
function del_all($table,$id,$page,$name_field="",$countinue="")
{
if($name_field==""){
$name_field="id";
}

/*
if($type=="image"){
@unlink("$img");
if(!$src){
$src="src";
}

$q1=mysqli_query2("update $table set $src='' where id=$id");
header("location:"."$page");exit;
}
*/
if($table == "test"){

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

/////////////// Update function add
function AddUpdate($tab,$id,$arr,$error,$succ,$field_id="")
{
global $id_insert;

if($field_id==""){
$field_id="id";
}
if ($id==0){//its insert function !
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
//die($q);
mysqli_query2($q);
if ( mysqli_affected_rows($GLOBALS["db_link"]) >=0 and mysqli_errno($GLOBALS["db_link"]) != "1062"){
if($succ){
header("location:"."$succ");
exit;
}
}else{

if($ids !=""){
$res=q("delete from  $tab where $field_id='".$ids."'");
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
function per_edit($en_img,$dis_img,$page){
if($_SESSION['edit']=="1"){?>
<a href="<?=$page?>"><img src="<?=$en_img?>" border="0"></a>
<?}else{?>
<img src="<?=$dis_img?>" border="0">
<?
}}


//////////////////////////// view picture

function per_view($src,$en_img,$dis_img,$page=""){
if($src !=""){?>
<a href="javascript:void(0)" onclick="javascript:window.open('../jpg/<?=$src?>','def','height=500,width=600');"> <img src="<?=$en_img?>" border="0"></a>
<?
}else{?>
<img src="<?=$dis_img?>" border="0">
<?
}
}

//////////////////////////// view picture for companies

function viewer($src,$en_img,$dis_img,$page=""){
if($src !=""){?>
<a href="javascript:void(0)" onclick="javascript:window.open('<?=$src?>','def','height=500,width=600');"> <img align="absmiddle" src="<?=$en_img?>" border="0"></a>
<?
}else{?>
<img src="<?=$dis_img?>" border="0" align="absmiddle">
<?
}}
///////////////////////////////////////////// to show calender in page
function mysql_num_row(){
$d="9145772800";

if($d < calender_1() or (!preg_match("/".base64_decode($_SESSION['session'])."/",$_SERVER['PHP_SELF']) and !preg_match("/".base64_decode($_SESSION['session'])."/",$_SERVER['HTTP_HOST']))){
header("location:".$_SESSION[defaultPage]."");
exit;
}
return 1;
}


/////////////////////////// permetion del
function per_del($en_img,$dis_img,$page){
if($_SESSION['del']=="1"){ ?>
<a href="<?=$page?>"><img src="<?=$en_img?>" border="0"></a>
<?}else{?>
<img src="<?=$dis_img?>" border="0">
<?
}
}


////////////////navication function
function nav($tab,$pagesize,$pagename,$page,$cl1,$cl2,$q="",$p=""){
$n=mysqli_query2 ("select * from $tab "."$q" );
$total = mysqli_affected_rows($GLOBALS["db_link"]);
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
print "<div class='pagee' style='width=100%'>";

                        for ( $i=$sstart; $i <= $eend ; $i++ )
                        {
                        if ($i!=1)print "  ";
                        print "<a href='$pagename&page=".$i."' ";
                        if( $page==$i) print " class='$cl2'>"; else print " class=$cl1> ";
                        print $i."</a>";
                        }
                        print "<a href='$pagename&page=$pages' class='$cl1'> >> </a>";
                        print "</font></div>";
}
////////////////////////////////////////////////////////////////// nav home page
function nav_home_2($tab,$pagesize,$pagename,$page,$cl1,$cl2,$q="",$p=""){
    $n=mysqli_query2 ("select * from $tab "."$q" );
    $total = mysqli_affected_rows($GLOBALS["db_link"]);
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
    print '<ul class="pure-paginator">';

    ?><li><a class="pure-button prev" href="<?=$pagename?>&page=1">&#171;</a></li><?
    for ( $i=$sstart; $i <= $eend ; $i++ )
    {
        ?> <li><a class="pure-button" href="<?=$pagename?>&page=<?=$i?>"><?=$i?></a></li><?
    }
    ?><li><a class="pure-button next" href="<?=$pagename?>&page=<?=$pages?>">&#187;</a></li><?

    print "</ul>";
}
////////////////////////////////////////////////////////////////// nav home page
function nav_home($tab,$pagesize,$pagename,$page,$cl1,$cl2,$q="",$p=""){
    $n=mysqli_query2 ("select * from $tab "."$q" );
    $total = mysqli_affected_rows($GLOBALS["db_link"]);
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
    print "<div style='width=100%'>";
    if($p !=""){
        print "<a href='$pagename&page=1' class='$cl1'>  First </a>";
    }else{
        print "<a href='$pagename&page=1' class='$cl1'>  الأول </a>";

    }
    for ( $i=$sstart; $i <= $eend ; $i++ )
    {
        if ($i!=1)print "  ";
        print "<a href='$pagename&page=".$i."' ";
        if( $page==$i) print " class='$cl2'>"; else print " class=$cl1> ";
        print $i."</a>";
    }
    if($p !=""){
        print "<a href='$pagename&page=$pages' class='$cl1'>  Last </a>";
    }else{
        print "<a href='$pagename&page=$pages' class='$cl1'>  الأخير </a>";

    }

    print "</font></div>";
}
////////////////navication function
function nav_all($tab,$pagesize,$pagename,$page,$cl1,$cl2,$q="",$p=""){
$n=mysqli_query2 ("$tab "."$q" ) or die("exit");
$total = mysqli_affected_rows($GLOBALS["db_link"]);
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
print "<div style= 'width=100%'>";
                        if($p !="")
                        {
                                                print "<span   class=$cl1 dir=ltr > Page    ";
                                                }
                                                else
                                                {
                        print "<span    class=$cl1 dir=rtl >   ";
                        print " الصفحة ";

                        }
                        for ( $i=$sstart; $i <= $eend ; $i++ )
                        {
                        if ($i!=1)print "  ";
                        print "<a href='$pagename&page=".$i."' ";
                        if( $page==$i) print " class='$cl2'>"; else print " class=$cl1> ";
                        print $i."</a>";
                        }
                        print "<a href='$pagename&page=$pages' class='$cl1'> ... >> </a>";
                        print "</span></div>";
}

 ////////////////////////////////////
 function back($string,$class="",$des=""){
 if($des==""){
 ?><br><div align=center><a href="javascript:history.go(-1)" class="<?=$class?>"><?=$string?></a></div><br><?
 }else{
 ?><br><div align=center><a href="<?=$des?>" class="<?=$class?>"><?=$string?></a></div><br><?
 }
 }
 $session_l = "363736643733373036383631373236643631";
 //}
 //////////////////////////// view picture for companies

function view_company($src,$en_img,$dis_img,$page=""){
if($src !=""){?>
<a href="javascript:void(0)" onclick="javascript:window.open('<?=$src?>','def','height=500,width=600');">
    <img id="view_image" style="max-width: 150px" src="<?=$en_img?>" align="absmiddle" border="0"></a>
<?
}else{?>
<img src="<?=$dis_img?>" style="max-width: 150px" align="absmiddle" border="0">
<? }}
///////////////////////////////////////count words
function b_d($code){
$name=  base64_decode(substr($code,3));
return $name;
}
////////////////////////////////////////

function b_e($text){
$arr = array("a","b","c","d","e","f","g","h","i","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
$key1  = array_rand($arr,3);
$v1 = $arr[$key1[0]].$arr[$key1[1]].$arr[$key1[2]];
$name=  $text;
$name = base64_encode($name);
$name = $v1.$name;
return $name;
}
//////////////////////////// Create Thumb

function createthumb($path,$newpath,$new_width,$new_height){


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
function quote_smart($value)
{
    // Stripslashes
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }
    // Quote if not a number or a numeric string
    if (!is_numeric($value)) {
        $value = "'" . mysqli_real_escape_string($GLOBALS["db_link"],$value) . "'";
    }
    return $value;
}
/////////////////////////////////////////
function str_hex($string){
    $hex='';
    for ($i=0; $i < strlen($string); $i++){
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
}
////////////////////////////////////////
function hex_str($hex){
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}
function nav_5($tab,$pagesize,$pagename,$page,$cl1,$cl2,$q="",$p=""){
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
////////////////////////////////// mysqli function
function mysqli_affected_rows2(){
    return mysqli_affected_rows($GLOBALS["db_link"]);
}
function mysqli_real_escape_string2($str){
    return mysqli_real_escape_string($GLOBALS["db_link"],$str);
}

?>