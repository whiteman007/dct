<?
if(main != "true"){
    die("Access Denied");
}
$third_tree = 0;

$q_pages = mysqli_query2("select * from page where   Active=1 and parent_id=0   order by the_order,id desc ");
while($r_pages = mysqli_fetch_array($q_pages)){

    $type_page = $r_pages["type_page"];
    if($type_page == ""){$type_page = "page";}
    if($type_page != "" and $type_page !="page"){$pid_page = "";}else{$pid_page = "&pid=".$r_pages['id'];}
    if($r_pages["ext_link"] !=""){
        $link_page = $r_pages["ext_link"];
        if($ext_page == "en/"){
            //$link_page = str_replace("index.php","index_ar.php",$link_page);
            $link_page = "en/".$r_pages["ext_link"];
        }elseif($ext_page == "ar/"){
            //$link_page = str_replace("index.php","index_ar.php",$link_page);
            $link_page = "ar/".$r_pages["ext_link"];
        }
    }else{
        $link_page = $ext_page."page/".$r_pages["cleanurl".$ext];
    }
    $arr = explode("/",$_SERVER["REQUEST_URI"]);
    $size_arr = sizeof($arr);
    $link_now = $arr[$size_arr-1];

    $qcat1 = mysqli_query2("select * from page where parent_id ='".$r_pages["id"]."' and Active = 1 order by the_order,id desc");
    //print ("select * from page where ext_link = '' and parent_id ='".$r_pages["id"]."' order by the_order,id desc");
    if(mysqli_affected_rows($GLOBALS["db_link"]) > 0){
       continue;
    }
    ?>
    <a href="<?php print $link_page;?>" class="opacity"><div class="w3-show-inline-block w3-text-white w3-padding-8-h w3-margin Gadugi <?php echo ($pid == $r_pages["id"]) ? "active" : ""?>"><?php print $r_pages["name".$ext] ?></div></a>
<?

}
////////////////////////////////////////////////////////////////
?>

