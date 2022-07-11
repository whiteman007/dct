<?
include "config.php";
include $pages->admin_path."/cookie.php";
if ($_POST["act"]=="add"){
         if ($_POST['name']!="" or $_POST['name_en']!=""){

             if($_POST["e_date"] == "0000-00-00" or $_POST["e_date"] == ""){
                 $e_date = date("Y-m-d");
             }else{
                 $e_date = $_POST["e_date"];
             }

             ////////////////// Top Parent
             //$ser = top_category(73,$_COOKIE["parent_id"]);
             //$ser = explode("-",$ser);
             //$sizee = sizeof($ser) - 2;
             //$top_parent =  $ser[$sizee];
             $top_parent =  "";

             ///////////////////////////////
             $id = intval($_POST["id"]);
             $cleanurl = cleanurl($_POST["name"]);
             $cleanurl_en = cleanurl($_POST["name_en"]);
             if($id > 0){
                 $randi = $id;
             }else{
                 $randi = time();
             }

             $qcc = mysqli_query2("select cleanurl,cleanurl_en from page where id <> ".$id." and cleanurl_en like '".trim($cleanurl_en)."' ");
             if(mysqli_affected_rows($GLOBALS["db_link"]) > 0){
                 $cleanurl_en = $cleanurl_en."-".$randi;
             }
             if($cleanurl_en !=""){
                 $qcc = mysqli_query2("select cleanurl,cleanurl_en from page where id <> ".$id." and cleanurl like '".trim($cleanurl)."' ");
                 if(mysqli_affected_rows($GLOBALS["db_link"]) > 0){
                     $cleanurl = $cleanurl."-".$randi;
                 }
             }
             $cleanurl = mysqli_real_escape_string($GLOBALS["db_link"],$cleanurl);
             $cleanurl_en = mysqli_real_escape_string($GLOBALS["db_link"],$cleanurl_en);
             ///////////////////////
         //$pic = AddUpdateFile("file",$pages->folder_name);
			$pic = AddUpdateImage("src",$pages->folder_name,"600","","oldpic");
			$pic_2 = AddUpdateImage("src_2",$pages->folder_name,"1920","","oldpic_2");
             $pic_1 = AddUpdateFile("src_1",$pages->folder_name,"oldpic_1");
             //$pic_3 = AddUpdateFile("src_3",$pages->folder_name,"oldpic_3");

             $pic_3 = AddUpdateImageMultiple("src_3",$pages->folder_name,"1920","","oldpic_3");
             $the_order=$_POST["the_order"];
         if($_POST['the_order'] =="" ){ $the_order="1000";}
		 
		 if($_POST['parent_id'] =="" ){ $parent_id = $_COOKIE["parent_id"];}else{$parent_id = $_POST['parent_id'];}


            //,$_POST["email"],$_POST["fax"],$_POST["phone"], mysqli_real_escape_string($GLOBALS["db_link"],$_POST["mobile"]),mysqli_real_escape_string($GLOBALS["db_link"],$_POST["industry"]),mysqli_real_escape_string($GLOBALS["db_link"],$_POST["product"])
             $arr = array(mysqli_real_escape_string($GLOBALS["db_link"],$_POST["name"]),$cleanurl,
             mysqli_real_escape_string($GLOBALS["db_link"],$_POST["name_en"]),$cleanurl_en,
                 mysqli_real_escape_string($GLOBALS["db_link"],$_POST['description']),mysqli_real_escape_string($GLOBALS["db_link"],$_POST['description_en']),
                 mysqli_real_escape_string($GLOBALS["db_link"],$_POST['text']),mysqli_real_escape_string($GLOBALS["db_link"],$_POST['text_en']),
                 $_POST["Active"], $the_order,$parent_id ,$pic,$pic_1,$pic_2,$pic_3,$_POST["place"],$_POST["type_page"],$_POST["ext_link"],$_POST["m_slider"],$_POST["m_news"]
                 ,$_POST["m_main"],$_POST["facebook"],$_POST["twitter"],$_POST["google"]
                 ,$e_date,$_POST["coord"],$_POST["tag"], mysqli_real_escape_string($GLOBALS["db_link"],$_POST["keyword_website"]),$top_parent,$_POST["counter"],$r_c_admin["t_username"]
                ,$_POST["law_type"],$_POST["year"],$_POST["number"],$_POST["publish_date"],$_POST["room"],$_POST["base_number"],$_POST["decision_number"],$_POST["video_link"]
         );
                 $id = AddUpdate($pages->table,$_POST["id"],$arr,"process.php?err=5","");
                 counter_admin($id,$_POST["visits"]);
                header("location:".$pages->page_name."?page=$_POST[page]&id=".$_POST[id]."&pa_id=".$_POST["pa_id"]);
         }else{
                header("location:".$pages->admin_path."/process.php?err=1");
         }
}
include $pages->admin_path."/head.php";
include $pages->admin_path."/navigation.php";

$c_mains=mysqli_query2("select * from ".$pages->table."  where id='".$_GET[id]."' ");
$row=mysqli_fetch_array($c_mains);

if(preg_match("/test\//",$_SERVER["REQUEST_URI"])){
    $host_name = $_SERVER['HTTP_HOST']."/test";
}else{
    $host_name = $_SERVER['HTTP_HOST'];
}

if($_SERVER['HTTP_HOST'] == "localhost"){
    $arrsr = explode("/",$_SERVER["REQUEST_URI"]);
    $host_name= $_SERVER["HTTP_HOST"];
    $domain_name = $arrsr[1];
    $linkBase = "http://".$host_name."/".$domain_name;
}else{

    $linkBase = "http://".$host_name;
}

?>

    <script type="text/javascript">
        $(document).ready(function(){

            $(".del_image").click(function(){
                var btn = $(this);
                var div_img = $(this).parents(".view_image").find("img");
                var field = $(this).parents(".form_add").find(":file").attr("name");
                var oldpic = $(this).parents(".form_add").find(".oldpic");


                a=confirm('هل أنت متأكد أنك تريد الحذف ؟') ;
                if (a==true){
                    div_img.hide();
                    btn.hide();
                    oldpic.val("");


                    $.post("<?=$pages->admin_path?>/del_image.php",{id : "<?=$row['id']?>", table : "<?=$pages->table?>",f:field},function(data){
                        if(data == "ok"){
                            alert("تم حذف الصورة بنجاح");
                            div_img.attr("src","<?=$pages->admin_path?>/images/no_image.png").show();
                        }
                    });
                };
                return false;
            })

            var roxyFileman = '<?=$linkBase?>/plugins/fileman/index.html';



        })
    </script>
<?
/*$arr = categoryChild(73);
$ser = serialize($arr);
if(preg_match("/:".$_COOKIE["parent_id"].";/",$ser)){
    $product = "ok";
}else{
    $product ="";
}
*/




?>
            <div class="w3-container w3-left-align">
                <?if($_GET["id"] !="") {
                    head_pages_2("label", $row["parent_id"], "-1", "0");
                }
                ?>
            </div>
<form method="POST" enctype="multipart/form-data" style="display:block; height: 100% ">

    <div class="ftab" style="width:100%">

        <div id="tabs" style="overflow: auto">
            <ul>
                <li><a href="#tabs-1">عربي</a></li>
                <li><a href="#tabs-2">انكليزي</a></li>



            </ul>
            <div id="tabs-1">
                <div  class="text_head_2">
                    العنوان
                </div>
                <div class="form_add">
                    <input type="text"  name="name" size="70" class="form1" style="direction:rtl;"  value="<?=$row[name]?>">
                </div>
                <div  class="text_head_2"  <?=hide(230)?>>
                    <span>الوصف</span>
                </div>
                <div class="form_add"  <?=hide(230)?>>
                    <textarea style="direction: rtl" name="description" class="form1" rows="4" cols="70"><?=$row["description"]?></textarea>
                </div>

                <div  class="text_head_2" <?=hide(230)?>>
                    التفاصيل
                </div>
                <div class="form_add"  <?=hide(230)?>>
                    <?
                    $CKEditor = new CKEditor();
                    $CKEditor->editor("text", $row["text"]);
                    ?>

                </div>

            </div>
            <div id="tabs-2">

                <div  class="text_head_2">
Title
                </div>
                <div class="form_add">
                    <input type="text"    name="name_en" size="70" class="form1" style="direction:ltr;"  value="<?=$row['name_en']?>">
                </div>
                <div  class="text_head_2" <?=hide(230)?>>
                    <span>Description</span>
                </div>
                <div class="form_add" <?=hide(230)?>>
                   <textarea style="direction: ltr" name="description_en" class="form1" rows="4" cols="70"><?=$row["description_en"]?></textarea>

                </div>

                <div  class="text_head_2"  <?=hide(230)?>>
         Details
                </div>
                <div class="form_add"  <?=hide(230)?>>
                    <?
                    $CKEditor = new CKEditor();
                    $CKEditor->editor("text_en", $row["text_en"]);
                    ?>

                </div>

            </div>
            </div>



        <div class="text_head_2">
            <?=$label_link?> :
        </div>

        <div class="form_add">
            <input type="text" name="ext_link" size="30" class="form1" style="direction:ltr;text-align:left"  value="<?=$row['ext_link']?>">
        </div>
        <?
        if($_GET['id'] == "940"){
            ?>
            <div class="text_head_2">
                رابط الفيديو :
            </div>

            <div class="form_add">
                <input type="text" name="video_link" size="70" class="form1" style="direction:ltr;text-align:left"  value="<?=$row['video_link']?>">
            </div>
            <?
        }
        ?>
        <div class="hide" <?=show(0)?>>
            <div class="text_head_2">
                نوع الصفحة
            </div>
            <div class="form_add">
                <select name="type_page" class="w3-input tahoma">
                    <option value="">
                        صفحة عادية
                    </option>
                    <option value="section" <?=$row["type_page"] == "section" ? 'selected' : ''?>>
                        قسم
                    </option>
                    <option value="menu" <?=$row["type_page"] == "menu" ? 'selected' : ''?>>
                        عنصر قائمة
                    </option>
                </select>
            </div>
        </div>
        <div class="hide" style="<?=($_COOKIE["parent_id"] == "0" && !$declaration) ? 'display: block' : 'display: none' ?> ">
            <div class="text_head_2">
                مكان الظهور
            </div>
            <div class="form_add">
                <select name="m_main" class="w3-input tahoma">
                    <option value="0">
                        قائمة علوية أولى
                    </option>

                    <option value="1" <?=$row["m_main"] == "1" ? 'selected' : ''?>>
                        قائمة علوية ثانية
                    </option>
                </select>
            </div>
        </div>
        <div class="hide" <?=show(339)?>>
            <div class="text_head_2">
                الاحداثيات:
            </div>
            <div class="form_add">
                <input type="text" name="place" size="30" class="form1" style="direction:ltr;text-align:left"  value="<?=$row['place']?>">
            </div>
        </div>


        <div class="hide" <?=show(963,907)?>>
            <div class="text_head_2">
التاريخ
            </div>
            <div class="form_add">
                <input type="text" <?=add_required(907)?>  name="publish_date" size="30" class="form1 datepicker" style="direction:ltr;text-align:left"  value="<?=$row['publish_date']?>">
            </div>
        </div>
        <div class="hide" <?=show(339)?>>
            <div class="text_head_2">
                الاحداثيات:
            </div>
            <div class="form_add">
                <input type="text" name="place" size="30" class="form1" style="direction:ltr;text-align:left"  value="<?=$row['place']?>">
            </div>
        </div>

        <div class="text_head_2"><?=$label_sort?> :</div>
        <div class="form_add">
            <input type="text" name="the_order" size="5" class="form1" style="direction:ltr;text-align:left"  value="<?=$row['the_order']=="" ? '1000' : $row['the_order'] ?>">
        </div>

        <div class="text_head_2">
            <?=$label_show?> :
        </div>
        <div class="form_add">
            <input type="checkbox" name="Active" size="40" class="form1" value="1" style="direction:ltr; text-align:right" <?=($row['Active']==0 && $_GET["id"] !="")   ? "" : "checked"?> >
        </div>

<?
if($_COOKIE["parent_id"] >= 0){
    ?>
        <div <?=hide(50,230,328,963);?>>
                <div class="text_head_2 ltr hide" <?=show(73)?>>
                    (400 * 300)
                </div>
                <div class="text_head_2 ltr hide" <?=show(750)?>>
                    (150 * --)
                </div>
                <div class="text_head_2 ltr hide" <?=show(756)?>>
                    (200 * 200)
                </div>
                <div class="text_head_2 ltr" <?=hide(750,73,756)?>>
                    400 * 300
                </div>
                <div class="form_add">
                    <input type="file" name="src" size="19" class="form1">
                    <?
                    $field = $row['src'];
                    ?>
                    <input  name="oldpic" class="oldpic"  type="hidden" value="<?=$field?>">
                    <?
                    $src = "";
                    if($field != ""){
                        $src =  $pages->folder_name ."/".$field;
                    }
                    ?>
                    <div class="link view_image" style="padding: 10px 0">
                        <? view_company($src,"photos/".$field,$pages->admin_path."/images/no_image.png","");?>
                        <span> <input  style="<?=$field != '' ? '' : 'display:none' ?>" class="vmiddle del_image" type="button" value="حذف"></span></div>

                </div>
        </div>
        <div  <?=hide(220,230,249,332,750,756,963)?>>
		        <div class="text_head_2">
                    <span class="hide ltr" <?=show(344)?>>  (1920 * 1280)</span>
                    <span <?=hide(344)?>><?=$label_photo_file?></span>

				</div>
				<div class="form_add">
					<input type="file" name="src_2" size="19" class="form1">
					<?
					$field = $row['src_2'];
					?>
					<input  name="oldpic_2" class="oldpic"  type=hidden value="<?=$field?>">
					<?
					$src = "";
					if($field != ""){

						$src =  $pages->folder_name ."/".$field;
					}
					?>

					<div class="link view_image" style="padding: 10px 0">
						<? view_company($src,"photos/".$field,$pages->admin_path."/images/no_image.png","");?>
						<span> <input  style="<?=$field != '' ? '' : 'display:none' ?>" class="vmiddle del_image" type="button" value="حذف"></span></div>

				</div>
        </div>
        <div>
            <div class="text_head_2">
                <?=$label_attach_file?>
            </div>
            <div class="form_add">
                <input type="file" name="src_1" size="19" class="form1">
                <?
                $field = $row['src_1'];
                ?>
                <input  name="oldpic_1" class="oldpic"  type=hidden value="<?=$field?>">
                <?
                $src = "";
                if($field != ""){

                    $src =  $pages->folder_name ."/".$field;
                }
                ?>


                <div class="link view_image w3-show-inline-block" style="padding: 10px 0">
                    <a target="_blank" href="photos/<?=$row["src_1"]?>"><?=$row["src_1"]?></a>
                    <span> <input  style="<?=$field != '' ? '' : 'display:none' ?>" class="vmiddle del_image" type="button" value="حذف"></span></div>

            </div>
        </div>
        <div>
            <div class="text_head_2">
                معرض الصور
            </div>
            <div class="form_add">
                <input type="file" name="src_3[]" multiple  size="19" class="form1">
                <?
                $field = $row['src_3'];
                ?>
                <input  name="oldpic_3" class="oldpic"  type=hidden value="<?=$field?>">
                <?
                $src = "";
                if($field != ""){

                    $src =  $pages->folder_name ."/".$field;
                }
                ?>


                <div class="link view_image w3-show-inline-block" style="padding: 10px 0">
                    <a target="_blank" href="photos/<?=$row["src_3"]?>"><?=$row["src_3"]?></a>
                    <span> <input  style="<?=$field != '' ? '' : 'display:none' ?>" class="vmiddle del_image" type="button" value="حذف"></span></div>

            </div>
        </div>
        <div>
            <div class="text_head_2">
                كلمات مفتاحية:
            </div>
            <div class="form_add">
                <textarea style="direction: ltr" name="keyword_website" class="form1" rows="4" cols="70"><?=$row["keyword_website"]?></textarea>
            </div>
        </div>
    <? if($_GET["id"] != ""){
        ?>
        <div class="text_head_2"> عداد الصفحة :</div>
        <div class="form_add">
            <input type="text" name="visits" size="8" class="form1" style="direction:ltr;text-align:left"  value="<?=view_counter($_GET['id'])?>">
        </div>
    <?php
    }
}


    ?>
        <div class="text_head_2">
        </div>
        <div class="form_add">
            <input name="act" type="hidden" value="add">
            <input name="page" type="hidden" value="<?=$_GET[page]?>">
            <input name="id" type="hidden" value="<?=$_GET[id]?>">
            <input name="parent_id" type="hidden" value="<?=$row['parent_id']?>">
            <input name="e_date" type="hidden" value="<?=$row['e_date']?>">
            <input name="counter" type="hidden" value="<?=$row['counter']?>">
            <input type="submit" value="<?=$_GET[id]==''? $label_add : $label_update ?>"  name="B1" class="form1">
            <input type="button" name="button" value="<?=$label_back?>" class="form1" onclick="javascript:location.href='<?=$pages->page_name?>?pa_id=<?=$_GET["pa_id"]?>&page=<?=$_GET[page]?>&id=<?=$_GET[id]?>'">
        </div>

    </div>
</form>
    <script>
        $( function() {
            $( ".datepicker" ).datepicker({
                dateFormat:'yy-mm-dd'
            });
        } );
    </script>
<? include $pages->admin_path."/foot.php"?>