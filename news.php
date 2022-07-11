<?php
if(main != "true"){
    die("Access Denied");
}
$q = mysqli_query2("select * from page where  id = '".$pid."'");
$r = mysqli_fetch_array($q);
?>
<div class="container news" style="margin-top: 32px">
    <div class="text-center">
        <h2 class="ge-flow-bold size_34 w3-text-brown title <?=$dir?>">
            <?=$r["name".$ext]?>
        </h2>
        <h6 class="ge-flow-bold w3-text-deep-orange size_16 title <?=$dir?>">
            <?=$r["description".$ext]?>
        </h6>
        <div class="margin_center" style="background-color: #ffbd00;height: 3px;width: 50px"></div>
    </div>

    <div class="row w3-margin-0" style="margin-top: 32px !important;">
        <?
        $q = mysqli_query2("select * from page where  parent_id = '".$pid."' and Active=1 order by the_order,id desc");
        while($r = mysqli_fetch_array($q)){
            if($r["src"] !=""){$back_img = "pages/photos/".rawurlencode($r["src"]);}elseif($r["src_2"] !=""){$back_img = "pages/photos/".rawurlencode($r["src_2"]);}else{$back_img = "images/‏‏noimage.jpg";}
            ?>
            <div class="col-md-4" style="margin-bottom: 60px">
                <div class="block <?=$dir?>">
                    <a href="<?=link_url($r)?>">
                        <div class="opacity" style="background: center center no-repeat;background-size: cover;background-image: url('<?=$back_img?>');width: 100%;height: 200px"></div>
                    </a>
                    <div class="w3-padding-16 w3-rest" style="height: 64px">
                        <a class="ge-flow-bold  size_17 w3-hover-text-light-blue" href="<?=link_url($r)?>">
                            <?=$r['name'.$ext]?>
                        </a>
                    </div>
                    <p class="size_15 w3-text-grey w3-margin-bottom  w3-rest"  style="height: 66px">
                        <?=$r['description'.$ext]?>
                    </p>
                    <div class="text-<?=$align?>">
                        <a href="<?=link_url($r)?>" class="w3-hover-text-brown w3-text-orange">
                            <?=$label_more?>
                            <i class="fa fa-long-arrow-<?=$align_r?>"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?
        }
        ?>
    </div>
</div>
<?
include "directory.php";