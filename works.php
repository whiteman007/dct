<?php
if(main != "true"){
    die("Access Denied");
}
$pid=intval($pid);
if($pid < 1){
    $pid=1;
}
$query=mysqli_query2("select * from page where  id='940' ");
$row=mysqli_fetch_array($query);
$title = $row["name".$ext];
if($row["src"] !=""){$back_img = "pages/photos/".rawurlencode($row["src"]);}elseif($row["src_2"] !=""){$back_img = "pages/photos/".rawurlencode($row["src_2"]);}else{$back_img = "";}
?>
<style>
    .embed-container {
        position: relative;
        padding-bottom: 56.25%;
        overflow: hidden;
    }
    .embed-container iframe,
    .embed-container object,
    .embed-container embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>
<div class="w3-padding-32 w3-light-grey" style="margin-top: 32px;background: left top no-repeat url('images/back-work.png')">
    <div class="container block-text text-center">
        <div class="pull-<?=$align?> w3-padding-16-all" style="max-width: 40%">
            <div class="width_100">
                <iframe height="200px" width="100%"  src="<?=$row['video_link']?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
        <div class="w3-rest text-<?=$align?>">
            <h1 class="size_34 <?=$dir?> ge-flow-bold">
                <?=$row['name'.$ext]?>
            </h1>
            <h2 class="size_17 w3-text-red <?=$dir?>">
                <?=$row['description'.$ext]?>
            </h2>
            <div class="desc <?=$dir?> w3-text-grey text-justify w3-margin-top">
                <?=$row['text'.$ext]?>
            </div>
        </div>

    </div>
</div>
