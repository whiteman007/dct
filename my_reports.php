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
$q1 = mysqli_query2("select * from page where  id = '963'");
$r1 = mysqli_fetch_array($q1);
?>
    <div class="container text-<?=$align?> <?=$dir?> cat-pgee blk-home" style="margin-bottom: 60px !important;">
        <div class="col-md-12 text-<?=$align?> <?=$dir?> w3-padding-32-h">
            <?
            $q= mysqli_query2("select src,description,e_date,publish_date,src_1,description_en,text,text_en,src_2,id,ext_link,type_page,name_en,name,cleanurl,cleanurl_en from page where Active = 1 and parent_id = 963  order by the_order, id desc limit $start,$pagesize");
            if(mysqli_affected_rows2() > 0) {
                ?>
                <h2 class="text-center ge-flow-bold size_34 text-<?=$align?> title <?=$dir?>" style="margin-top: 32px">
                    <?=$r1["name".$ext]?>
                </h2>
                <?

                while ($r = mysqli_fetch_array($q)) {
                    ?>
                    <a href="pages/photos/<?=$r['src_1']?>" class="link-val fancybox_pdf">
                        <div class="w3-padding-16"  style="border-bottom: 2px solid #aaa">
                            <div class="blk row w3-margin-0">
                                <div class="pull-<?=$align?> w3-margin-bottom w3-margin-left right-block">
                                    <img class="w3-padding-8-all" src="images/pdf.png" alt="<?php echo $r["name".$ext]; ?>"/>
                                </div>
                                <h3 class="ge-flow-bold size_18 color_black">
                                    <?=$r["name".$ext]?>
                                </h3>
                                <div class="op-val <?=$dir?> w3-text-grey tahoma size_11">
                                    <?=$r["publish_date"]?>
                                </div>
                            </div>
                        </div>
                    </a>

                    <?php
                }
                ?>

                <div class="w3-margin-top w3-padding-top w3-center" style="margin-top: 30px">
                    <?php
                    nav_5("page", $pagesize, "reports", $_GET["page"], " w3-margin-bottom btn", "btn background_brown  w3-margin-bottom", "where Active = 1 and parent_id = 963  order by the_order, id desc");
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
<?


