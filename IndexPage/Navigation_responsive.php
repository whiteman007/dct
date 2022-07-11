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
    if($ext_page == "ar/"){
        //$link_page = str_replace("index.php","index_ar.php",$link_page);
        $link_page = "ar/".$r_pages["ext_link"];
    }elseif($ext_page == "en/"){
        //$link_page = str_replace("index.php","index_ar.php",$link_page);
        $link_page = "en/".$r_pages["ext_link"];
    }
}else{
    //$link_page = "index".$ext_page.".php?type=page&pid=".$r_pages["id"].$extension;
    $link_page = $ext_page."page/".$r_pages["cleanurl".$ext];
}


$arr = explode("/",$_SERVER["REQUEST_URI"]);
$size_arr = sizeof($arr);
$link_now =$arr[$size_arr-1];

$qcat1 = mysqli_query2("select * from page where parent_id ='".$r_pages["id"]."'  order by the_order,id desc");
//print ("select * from page where ext_link = '' and parent_id ='".$r_pages["id"]."' order by the_order,id desc");
if(mysqli_affected_rows($GLOBALS["db_link"]) > 0 && $r_pages["ext_link"] ==""){

if($r_pages["id"] == 73){
    $typeCat1 = $ext_page."products";
}else{
    $typeCat1 = $ext_page."page";
}
?>
<li class="relative">
    <a href="#"><?=$r_pages["name".$ext]?></a>
    <ul class="dl-submenu">
        <?
        while($rcat1 = mysqli_fetch_array($qcat1)){

        $qcat2 = mysqli_query2("select * from page where  parent_id ='".$rcat1["id"]."'  order by the_order,id desc");
        if(mysqli_affected_rows($GLOBALS["db_link"]) > 0 && $rcat1["ext_link"] ==""){
        ?>
        <li class="relative">
            <a href="#"><?=$rcat1["name".$ext]?></a>
            <ul  class="dl-submenu">
                <!--<li> <a href="index<?=$ext_page?>.php?type=page&pid=<?=$rcat1['id']?>"><?=$rcat1["name".$ext]?> <b class="caret"></b></a>--><?
                while($rcat2 = mysqli_fetch_array($qcat2)){
////////////////// Third Level
                    ?>
                    <li><a href="<?=$typeCat1?>/<?=$rcat2['cleanurl'.$ext]?>"><?=$rcat2["name".$ext]?></a></li>
                <?
                }
                print "</ul>
                                    </li>";
                }else{
////////////////////// Second Level
                    ?>
                    <li><a href="<?=$typeCat1?>/<?=$rcat1['cleanurl'.$ext]?>"><?=$rcat1["name".$ext]?></a></li>
                <?
                }
                }
                ?>

            </ul>
        </li><?

        }else{
            $qcat1 = mysqli_query2("select * from page where parent_id ='".$r_pages["id"]."' and Active = 1 order by the_order,id desc");
            //print ("select * from page where ext_link = '' and parent_id ='".$r_pages["id"]."' order by the_order,id desc");
            if(mysqli_affected_rows($GLOBALS["db_link"]) > 0 && $r_pages["id"] =="73"){
                $rcat1 = mysqli_fetch_array($qcat1);
                //alert($link_page);
                $link_page = $link_page."/".$rcat1["cleanurl".$ext];
            }
            ?>
            <li><a href="<?php print $link_page;?>" <?=($pid == $r_pages["id"]) ? "class='active'" : "class=''"?>><?php print $r_pages["name".$ext] ?></a></li>

        <?
        }


        }
        /////////////////////////////////////////////////////////////////
        ?>

