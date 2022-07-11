<?
if(main != "true"){
    die("Access Denied");
}
$third_tree = 0;

$q_pages = mysqli_query2("select * from page where   Active=1 and m_main=0  and parent_id=0   order by the_order,id desc ");
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

    $qcat1 = mysqli_query2("select * from page where parent_id ='".$r_pages["id"]."' and Active = 1   order by the_order,id desc");
    if(mysqli_affected_rows2() > 0  && $r_pages["type_page"] == "menu"){
        ?>
        <li class="dropdown">
            <a href="javascript:void(0)" class="menu__link dropdown-toggle" data-toggle="dropdown">
                <?=$r_pages["name".$ext]?>
                <b class="caret"></b></a>

            <ul class="dropdown-menu  row w3-light-blue" style="border-radius: 0;border: 0;padding: 0">

                <?php
                $ijk = 0;
                while($r1 = mysqli_fetch_array($qcat1)){
                    $ijk ++ ;
                    $q2 = mysqli_query2("select * from page where parent_id = ".$r1['id']." and Active=1 order by the_order,id desc");
                    if($r_pages["id"] == 73){
                        $catee = "products";
                    }else{
                        $catee = "page";
                    }
                    ?>
                            <li class="text-<?=$align?>">
                                <a class="w3-padding-8 w3-text-white w3-hover-brown w3-hover-text-light-blue size_16" href="<?=link_url($r1)?>"><?=$r1["name".$ext]?></a>
                            </li><?
                }
                ?>
            </ul>
        </li>
        <?php
    }else{
        ?>
        <li <?=($pid == $r_pages["id"]) ? "class='active'" : ""?>>
            <a href="<?php print $link_page;?>">
                <?php print $r_pages["name".$ext] ?>
            </a>
        </li>
        <?
    }
}
////////////////////////////////////////////////////////////////
$q_pages = mysqli_query2("select * from page where   Active=1 and m_main=1  and parent_id=0   order by the_order,id desc ");
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

    $qcat1 = mysqli_query2("select * from page where parent_id ='".$r_pages["id"]."' and Active = 1   order by the_order,id desc");
    if(mysqli_affected_rows2() > 0  && $r_pages["type_page"] == "menu"){
        ?>
        <li class="dropdown hidden-lg hidden-md  hidden-sm">
            <a href="javascript:void(0)" class="menu__link dropdown-toggle" data-toggle="dropdown">
                <?=$r_pages["name".$ext]?>
                <b class="caret"></b></a>

            <ul class="dropdown-menu  row">

                <?php
                $ijk = 0;
                while($r1 = mysqli_fetch_array($qcat1)){
                    $ijk ++ ;
                    $q2 = mysqli_query2("select * from page where parent_id = ".$r1['id']." and Active=1 order by the_order,id desc");
                    if($r_pages["id"] == 73){
                        $catee = "products";
                    }else{
                        $catee = "page";
                    }
                    ?>
                <li class="text-<?=$align?>">
                    <a href="<?=link_url($r1)?>"><?=$r1["name".$ext]?></a>
                    </li><?
                }
                ?>
            </ul>
        </li>
        <?php
    }else{
        ?>
        <li <?=($pid == $r_pages["id"]) ? "class='active hidden-lg hidden-md  hidden-sm'" : "class='hidden-lg hidden-md  hidden-sm'"?>>
            <a href="<?php print $link_page;?>">
                <?php print $r_pages["name".$ext] ?>
            </a>
        </li>
        <?
    }
}
?>
