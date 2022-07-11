<?
if(main != "true"){
    die("Access Denied");
}

$key = strip_tags($_POST["key"]);
$q = mysqli_query2("select id,name".$ext.",cleanurl".$ext.",description".$ext.",text".$ext.",src from page where Active = 1 and id not in(1,2,159,73,344,765,766,767)  and parent_id not in (159,344,765,766,2) and (name".$ext." like '%".$key."%' or description".$ext." like '%".$key."%' or text".$ext." like '%".$key."%')  order by the_order, id desc limit 50");
$back_img = "images/noimage.png";
?>
<style>
    /*
    .search-block .w3-col{
        float: right;
    }
    */
</style>
<div class="width_100 search-block">
    <div class="block-news width_75 margin_center w3-center w3-padding-64 ltr">
                <?
                if(mysqli_affected_rows2() > 0) {
                    ?>
                    <div class="w3-left-align">
                        <h4 class="w3-padding-32 w3-left-align myrb"> <span class="w3-text-black"><?=$label_search_results?> :</span> <span class="w3-text-red"><?=$_POST["key"]?></span></h4>
                    </div>
                    <?

                    while ($r = mysqli_fetch_array($q)) {
                        $q1 = mysqli_query2("select * from page where parent_id = '".$r["id"]."'");
                        if(mysqli_affected_rows2() > 0) continue;
                        $back_img = default_image($r,"images/8.png",false);
                        ?>
                        <div class="cat-page w3-row w3-padding-16 w3-left-align">
                            <?
                            if ($back_img) {
                                ?>
                                <div class="w3-col l2 m3 s4">
                                    <a href="<?=link_url($r)?>"><img class="opacity" style="width: 316px" src="<?=$back_img?>" alt="<?= $r['name'.$ext]?>"/></a>
                                </div>
                            <?php
                            }else{
                                ?>
                                <div class="w3-col l2 m3 s4">
                                    <a href="<?=link_url($r)?>"><img class="opacity" style="width: 316px" src="<?=$back_img?>" alt="<?= $r['name'.$ext]?>"/></a>
                                </div>
                            <?php
                            }
                            ?>
                            <div class="w3-col l10 m9 s8  w3-padding ">
                                <a href="<?=link_url($r)?>" class="w3-hover-text-red"><h4 class="w3-left-align myrb"><?= $r['name' . $ext] ?></h4></a>
                                <div class="w3-padding-8">
                                    <?
                                    if($r['description' . $ext]){
                                        echo $r['description' . $ext];
                                    }else{
                                        echo strword($r["text".$ext],60);
                                    }
                                     ?>
                                </div>
                                <div class="w3-<?=$align?>-align"><a href="<?=link_url($r)?>" class="w3-btn w3-red w3-hover-black  w3-margin-bottom"><?=$label_more_2?></a></div>
                            </div>
                        </div>
                        <hr style="width: 100%;height: 1px;background-color: #3f3f3f">
                    <?
                    }

                }else{
                    ?><div class="w3-center"><?=$label_no_results_for?> <span class="w3-text-red"><?=$key?></span></div><?
                }
                ?>
    </div>
</div>
<!-- تعليق -->