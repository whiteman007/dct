<?php
if(main != "true"){
    die("Access Denied");
}
$pid=intval($pid);
if($pid < 1){
    $pid=1;
}
$query=mysqli_query2("select * from page where  id='73' ");
$row=mysqli_fetch_array($query);
$title = $row["name".$ext];
if($row["src"] !=""){$back_img = "pages/photos/".rawurlencode($row["src"]);}elseif($row["src_2"] !=""){$back_img = "pages/photos/".rawurlencode($row["src_2"]);}else{$back_img = "";}
?>
<style>
    @media all and (max-width: 767px) {
        .directory .w3-rest{
            clear: both;
        }
    }
</style>
<div class="container w3-red w3-padding-16-all directory" style="margin-top: 16px">
    <h2 class="size_34 text-<?=$align?> pull-<?=$align?>" style="padding-left: 8px">
        <?=$title?>
    </h2>
    <div class="pull-<?=$align_r?>">
        <div style="padding: 16px 8px">
            <a href="javascript:void(0)" class="arrow-left w3-text-white w3-hover-text-light-grey inline-block" style="margin-<?=$align?>: 4px">
                <i class="fa fa-angle-left"></i>
            </a>
            &nbsp;
            <a href="javascript:void(0)" class="arrow-right w3-text-white w3-hover-text-light-grey inline-block">
                <i class="fa fa-angle-right"></i>
            </a>
        </div>

    </div>
    <div class="w3-rest text-<?=$align_r?>">
        <div class="slider-directory">
            <?
            $q = mysqli_query2("select * from page where  parent_id = '73' and Active=1 order by the_order,id desc");
            while ($r = mysqli_fetch_array($q)) {
                ?>
                <a href="<?=$ext_page?>companies/<?=$r['cleanurl'.$ext]?>" class="item w3-text-white w3-margin-top w3-hover-text-black" style="margin-<?=$align_r?>: 4px;margin-<?=$align?>: 4px">
                    <div class="text-center margin_center">
                        <?=$r["name".$ext]?>
                    </div>
                </a>
                <?
            }
            ?>


        </div>
    </div>
</div>
