<?php
if(main != "true"){
    die("Access Denied");
}
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
if($_GET["key_s"]){
    $link_add .=  "&key_s=".$_GET["key_s"];
    $query_add .= " and id not in (344,159) and parent_id not in (344) and ( name".$ext." like '%".$_GET["key_s"]."%' or text".$ext." like '%".$_GET["key_s"]."%' )  ";
}else{
    if($type && $pid != 1){
        $parent_search  = " and (parent_id = '".$pid."')";
    }else{
        $parent_search = " and (  parent_id  = -1)";
    }
}


$add_search = " $parent_search   $query_add";
        ?>
        <div class="container text-<?=$align?> <?=$dir?> cat-pgee blk-home" style="margin-bottom: 60px !important;">
            <div class="col-md-12 text-<?=$align?> <?=$dir?> w3-padding-32-h">
                <?
                $q= mysqli_query2("select src,description,description_en,src_2,id,ext_link,type_page,name_en,name,cleanurl,cleanurl_en from page where active=1 ".$add_search." order by the_order, id desc limit $start,$pagesize");
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
                    $linkee = $ext_page . "cat/" . $r["cleanurl" . $ext];
                } else {
                    $linkee = link_url($r);
                }
                ?>
                <a href="<?= $linkee ?>" class="link-val">
                    <div class="blk row w3-margin-0  w3-padding-16" style="border-bottom: 2px solid #cbb488">
                        <?
                        if($r["src"]){
                            ?><div class="pull-<?=$align?> w3-margin-bottom w3-margin-<?=$align_r?> right-block" style="width: 30%">
                            <img class="width_100" src="pages/photos/<?php echo rawurlencode($r["src"]); ?>" alt="<?php echo $r["name".$ext]; ?>"/>
                            </div><?
                        }
                        ?>

                        <h3 class="geb size_18 w3-text-brown w3-hover-text-light-blue w3-margin-bottom">
                            <?php echo $r["name".$ext]; ?>
                        </h3>

                        <div class="op-val w3-text-grey">
                            <?php echo nl2br($r["description" . $ext]); ?>
                        </div>
                        <div class="w3-deep-orange btn text-<?=$align_r?>  w3-margin-top">
                            <?= $label_more_3 ?>
                        </div>
                    </div>
                </a>

            <?php
            }
            ?>

        <div class="w3-margin-top w3-padding-top w3-center" style="margin-top: 30px">
            <?php
            nav_5("page", $pagesize, "cat/" . $cleanurl.$link_add, $_GET["page"], " w3-margin-bottom btn", "btn background_brown  w3-margin-bottom", "where active =1 $parent_search   $query_add order by the_order, id desc");
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

                </a>
            </div>

        </div><?
    }
        ?>
        </div>
        </div>
<?


