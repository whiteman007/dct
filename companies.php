<?php
if(main != "true"){
    die("Access Denied");
}
include "directory.php";
$query=mysqli_query2("select * from page where  id='".$pid."' ");
$row=mysqli_fetch_array($query);
$title = $row["name".$ext];

?>
    <style>
        .cat-pgee .right-block{
            transition: .3s ease-out;
        }
        .cat-pgee .link-val:hover img{
            opacity: .75;
        }
        @media all and (max-width: 767px) {
            .cat-pgee .right-block{
                padding: 16px !important;
                float: none !important;
                margin: 0 auto;
                text-align: center;
                max-width: 100%;
                width: auto !important;
            }
            .cat-pgee .right-block img{
                width: auto;
            }
        }

    </style>
<?
$page = $_GET['page'];
if($page < 1)  $page = 1;
$pagesize = 50;
$start = (($page*$pagesize)-$pagesize) ;
$q_keyword = strip_tags($_GET["q"]);
if($_GET["title"]){
    $link_add .=  "&title=".$_GET["title"];
    $query_add .= " and (name like '%".$_GET["title"]."%')";
}
if($_GET["char"]){
    $link_add .=  "&char=".$_GET["char"];
    if($_GET["char"] == "أ")
        $query_add .= " and ( name".$ext." like 'أ%' or name".$ext." like 'ا%' or name".$ext." like 'آ%' or name".$ext." like 'إ%' )";
    else
        $query_add .= " and ( name".$ext." like '".$_GET["char"]."%' )";
}

if($_GET["content"]){
    $link_add .=  "&content=".$_GET["content"];
    $query_add .= " and (text like '%".$_GET["content"]."%')";
}
if($type && $pid != 1){
    $parent_search  = " and (parent_id = '".$pid."')";
}else{
    $parent_search = "and (parent_id = -1)";
}
$add_search = " $parent_search   $query_add";
?>
    <style>
        .search-c a{
            padding: 4px 6px;
        }
    </style>
    <div class="container text-<?=$align?> <?=$dir?> cat-pgee blk-home" style="margin-bottom: 60px !important;">
        <div class="row">
            <?
            if($ext_page == "ar/"){
                ?>
                <div class="col-md-12 search-c w3-padding-0 text-center <?=$dir?>" style="font-family: tahoma, sans-serif; font-size: 12px">
                    <h3 class="text-center bold" style="font-size: 16px;margin-top: 24px">
                        بحث عن بحسب الأحرف
                    </h3>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=أ" class="w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        أ
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ب" class="w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ب
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ت" class="w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ت
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ث" class="w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ث
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ج" class="w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ج
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ح" class="w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ح
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=خ" class="w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        خ
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=د" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        د
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ذ" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ذ
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ر" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ر
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ز" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ز
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=س" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        س
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ش" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ش
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ص" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ص
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ض" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ض
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ط" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ط
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ظ" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ظ
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ع" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ع
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=غ" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        غ
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ف" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ف
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ق" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ق
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ك" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ك
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ل" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ل
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=م" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        م
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ن" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ن
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ه" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ه
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=و" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        و
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=ي" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        ي
                    </a>
                </div>
                <?
            }else{
                ?>
                <div class="col-md-12 search-c w3-padding-0 text-center <?=$dir?>" style="font-family: tahoma, sans-serif; font-size: 12px">
                    <h3 class="text-center bold" style="font-size: 16px;margin-top: 24px">
Search By First Char
                    </h3>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=A" class="w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        A
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=B" class="w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        B
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=C" class="w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        C
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=D" class="w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        D
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=E" class="w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        E
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=F" class="w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        F
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=G" class="w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        G
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=H" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        H
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=I" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        I
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=J" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        J
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=K" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        K
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=L" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        L
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=M" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        M
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=N" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        N
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=O" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        O
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=P" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        P
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=Q" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        Q
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=R" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        R
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=S" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        S
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=T" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        T
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=U" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        U
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=V" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        V
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=W" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        W
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=X" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        X
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=Y" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        Y
                    </a>
                    <a href="<?=$ext_page?>companies/<?=$row['cleanurl'.$ext]?>?char=Z" class=" w3-text-black w3-light-grey w3-hover-text-red inline-block" style="margin: 4px">
                        Z
                    </a>
                </div>
                <?
            }
            ?>

        </div>
        <div class="row">
            <div class="col-md-12 text-<?=$align?> <?=$dir?> w3-padding-32-h">
                <?
                $q= mysqli_query2("select src,description,description_en,text,text_en,src_2,id,ext_link,type_page,name_en,name,cleanurl,cleanurl_en from page where active=1 ".$add_search." order by the_order, id desc limit $start,$pagesize");
                if(mysqli_affected_rows2() > 0) {
                    ?>
                    <h1 class="size_34 <?=$dir?> ge-flow-bold w3-padding-32 text-center">
                        <?=$title?>
                    </h1>
                    <?

                    while ($r = mysqli_fetch_array($q)) {
                        if ($r["src"] != "") {
                            $back_img = "pages/photos/" . rawurlencode($r["src"]);
                        } elseif ($r["src_2"] != "") {
                            $back_img = "pages/photos/" . rawurlencode($r["src_2"]);
                        } else {
                            $back_img = "images/noimage2.jpg";
                        }
                        $q2 = mysqli_query2("select id from page where parent_id='" . $r["id"] . "'");
                        if (mysqli_affected_rows2() > 0 && $r["ext_link"] == "") {
                            $linkee = $ext_page . "companies/" . $r["cleanurl" . $ext];
                        } else {
                            $linkee = link_url($r);
                        }
                        ?>
                        <a href="<?= $linkee ?>" class="link-val">
                            <div class="w3-padding-16"  style="border-bottom: 2px solid #aaa">
                                <div class="blk row w3-margin-0">
                                    <div>
                                        <h2 class="ge-flow-bold size_34 text-<?=$align?> title <?=$dir?>">
                                            <?=$r["name".$ext]?>
                                        </h2>
                                        <h6 class="ge-flow-bold w3-text-red size_16 text-<?=$align?> title <?=$dir?>">
                                            <?=$label_Company_Information?>
                                        </h6>
                                    </div>
                                    <?
                                    if($r["src"]){
                                        ?><div class="pull-<?=$align?> w3-margin-bottom w3-margin-<?=$align_r?> right-block" style="width: 30%">
                                        <img class="width_100 w3-padding-32-all w3-border" src="pages/photos/<?php echo rawurlencode($r["src"]); ?>" alt="<?php echo $r["name".$ext]; ?>"/>
                                        </div><?
                                    }
                                    ?>

                                    <h3 class="ge-flow-bold size_18 color_black w3-margin-bottom">
                                        <?=$label_Company_Profile?>
                                    </h3>

                                    <div class="op-val ge-flow <?=$dir?>">
                                        <?php echo strword($r["text".$ext],30); ?> ...
                                    </div>
                                </div>
                                <div style="font-family: arial,sans-serif">
                                    <?php echo nl2br($r["description" . $ext]); ?>
                                </div>
                            </div>
                        </a>

                        <?php
                    }
                    ?>

                    <div class="w3-margin-top w3-padding-top w3-center" style="margin-top: 30px">
                        <?php
                        nav_5("page", $pagesize, "companies/" . $cleanurl.$link_add, $_GET["page"], " w3-margin-bottom btn", "btn background_brown  w3-margin-bottom", "where active =1 $parent_search   $query_add order by the_order, id desc");
                        ?>
                    </div>
                    <div class="text-center w3-margin-bottom">
                        <a href="javascript:history.go(-1)" class="btn btn-brown">
                            <?=$label_back?>
                        </a>
                    </div>
                    <?
                }else{
                    ?><div class="color_red size_26 geb text-center w3-padding-128">
                    <?=$label_no_pages?>
                    <div class="w3-padding-32">
                        <a href="javascript:void(0)" onclick="history.go(-1)" class="btn background_black w3-padding-32-h">
                            <?=$label_back?>
                        </a>
                    </div>

                    </div><?
                }
                ?>
            </div>
        </div>
    </div>
<?


