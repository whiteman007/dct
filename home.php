<?php
if(main != "true"){
    die("Access Denied");
}
include "services.php";
include "locations_home.php";
/////////////////////////////////////
$query=mysqli_query2("select * from page where  id='1' ");
$row=mysqli_fetch_array($query);
$title = $row["name".$ext];
if($row["src"] !=""){$back_img = "pages/photos/".rawurlencode($row["src"]);}elseif($row["src_2"] !=""){$back_img = "pages/photos/".rawurlencode($row["src_2"]);}else{$back_img = "";}
?>
<div style="margin: 32px 0;">
    <div class="container block-text text-center">
        <div class="pull-<?=$align?> w3-padding-16-all" style="max-width: 40%">
            <div class="width_100 text-<?=$align?>">
                <img src="<?=$back_img?>" class="max_width_100"/>
            </div>
        </div>
        <div class="w3-rest text-<?=$align?>">
            <h1 class="size_17 w3-text-light-blue <?=$dir?> ge-flow-bold">
                <?=$row['name'.$ext]?>
            </h1>
            <h2 class="size_34 w3-text-brown <?=$dir?>">
                <?=$row['description'.$ext]?>
            </h2>
            <div class="desc <?=$dir?> size_14 w3-text-grey text-justify w3-margin-top">
                <?=$row['text'.$ext]?>
            </div>
            <div class="w3-margin-top text-<?=$align?>">
                <a href="<?=link_url($row)?>" class="btn w3-deep-orange">
                    <?=$label_more?>
                </a>
            </div>
        </div>
    </div>
</div>
<?php
include "gallery.php";
?>
