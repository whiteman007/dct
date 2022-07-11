<?php
if(main != "true"){
    die("Access Denied");
}
$pid=intval($pid);
if($pid < 1){
    $pid=1;
}
$q=mysqli_query2("select * from page where  id='".$pid."' ");
$r=mysqli_fetch_array($q);
$title = $r["name".$ext];
if($r["src"] !=""){$back_img = "pages/photos/".rawurlencode($r["src"]);}elseif($r["src_2"] !=""){$back_img = "pages/photos/".rawurlencode($r["src_2"]);}else{$back_img = "images/noimage.jpg";}
?>
<style>
    @media all and (max-width: 767px) {
        .block-text .pull-left,.block-text .pull-right{
            float: none !important;
            text-align: center;
            max-width: 100% !important;
        }
    }
</style>
<div class="w3-padding-32 " style="margin-top: 32px">
    <div class="container block-text text-center">
        <a href="<?=$back_img?>" class="fancybox">
            <img src="<?=$back_img?>" alt="<?=$r["name".$ext]?>" class="pull-<?=$align?> opacity w3-padding-16-all" style="max-width: 40%;padding-<?=$align?>: 0">
        </a>
        <div class="w3-rest text-<?=$align?>">
            <div class="text-<?=$align?> w3-margin-bottom">
                <h2 class="ge-flow-bold size_34 w3-text-light-blue title <?=$dir?>">
                    <?=$r["name".$ext]?>
                </h2>
                <h6 class="tahoma w3-text-brown size_16 title <?=$dir?>" style="line-height: 1.5">
                    <?=nl2br($r["description".$ext])?>
                </h6>
            </div>
            <div class="desc <?=$dir?>  text-justify w3-margin-top">
               <div>
                   <?=$r["text".$ext]?>
               </div>
                <?php
                if($pid=="2"){
                    ?>
                    <p class="text-center w3-padding-16">
                        <?php
                        include "pages/IndexPage/p1".$ext.".php";
                        ?>
                    </p>
                    <?
                }
                ?>
                <div class="w3-padding-8 margin_center" style="width: 145px">
                    <?
                    include 'addthis.html';
                    ?>
                </div>
            </div>
        </div>
        <?
        if($r["src_3"]){
            $arr_photos =array_filter(explode("*",$r["src_3"]));
            ?>
            <div class="row w3-margin-0">
                <?
                foreach ($arr_photos as $key=>$val) {
                    ?>
                    <div class="col-md-3 col-sm-4 col-xs-6" style="padding-top: 0!important;padding-bottom: 0!important;">
                        <a href="pages/photos/<?=rawurlencode($val)?>" class="fancybox" rel="group1">
                            <div class="width-100 opacity" style="cursor:pointer;background: center center url('pages/photos/<?=rawurlencode($val)?>') no-repeat;background-size: cover !important; height: 150px;"></div>
                        </a>
                    </div>
                    <?
                }
                ?>
            </div>
            <?
        }
        ?>
        <?
        if($pid == 953){
            ?>
            <div class="w3-margin-top">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3326.429329208847!2d36.29309486505347!3d33.51622160323379!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1518e731d13acfe5%3A0x5a4db16d00e592c6!2sYousef+Al-Azmeh+Roundabout%2C+Damascus%2C+Syria!5e0!3m2!1sen!2s!4v1555707134304!5m2!1sen!2s" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
            <?
        }
        ?>

    </div>
</div>
<?php
include "locations_home.php";