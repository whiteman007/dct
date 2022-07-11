<?php
if(main != "true"){
    die("Access Denied");
}
$q = mysqli_query2("select * from page where  id = '902'");
$r = mysqli_fetch_array($q);
?>
<div class="container w3-padding-32">
    <div class="text-<?=$align?>">
        <h2 class="ge-flow-bold size_34 w3-text-light-blue title <?=$dir?>">
            <?=$r["name".$ext]?>
        </h2>
        <h6 class="ge-flow-bold w3-text-brown size_16 title <?=$dir?>">
            <?=$r["description".$ext]?>
        </h6>
        <div class="w3-padding-16 width_100">
            <div style="background: center center url('pages/photos/<?=rawurlencode($r['src_2'])?>') no-repeat;background-size: cover;height: 150px;width: 100%"></div>
        </div>
        <p>
            <?=$r["text".$ext]?>
        </p>
    </div>
</div>
<div class="w3-light-blue">
    <div class="container news" style="padding: 32px 0">
        <h6 class="ge-flow-bold w3-text-brown size_34 title text-<?=$align?> <?=$dir?>">
            أعضاء اللجنة
        </h6>
        <div class="row w3-margin-0" style="margin-top: 32px !important;">
            <?
            $q = mysqli_query2("select * from page where  parent_id = '".$pid."' and Active=1 order by the_order,id desc");
            while($r = mysqli_fetch_array($q)){
                if($r["src"] !=""){$back_img = "pages/photos/".rawurlencode($r["src"]);}elseif($r["src_2"] !=""){$back_img = "pages/photos/".rawurlencode($r["src_2"]);}else{$back_img = "images/‏‏noimage.jpg";}
                ?>
                <div class="col-md-3" style="margin-bottom: 60px">
                    <div class="block <?=$dir?>">
                        <a href="<?=link_url($r)?>">
                            <div class="opacity" style="background: center center no-repeat;background-size: cover;background-image: url('<?=$back_img?>');width: 100%;height: 200px"></div>
                        </a>
                        <div class="w3-padding text-center w3-white">
                            <div class="w3-padding-16 w3-rest" style="height: 64px">
                                <a class="ge-flow-bold size_17 w3-hover-text-light-blue" href="<?=link_url($r)?>">
                                    <?=$r['name'.$ext]?>
                                </a>
                            </div>
                            <p class="size_15 w3-text-brown w3-margin-bottom  w3-rest"  style="height: 66px">
                                <?=$r['description'.$ext]?>
                            </p>
                        </div>

                    </div>
                </div>
                <?
            }
            ?>
        </div>
    </div>
</div>