<?php
if(main != "true"){
    die("Access Denied");
}
$pid=intval($pid);
if($pid < 1){
    $pid=1;
}
$query=mysqli_query2("select * from page where  id='886' ");
$row=mysqli_fetch_array($query);
$title = $row["name".$ext];
if($row["src"] !=""){$back_img = "pages/photos/".rawurlencode($row["src"]);}elseif($row["src_2"] !=""){$back_img = "pages/photos/".rawurlencode($row["src_2"]);}else{$back_img = "";}
?>
<div class="width_100 w3-light-blue">
    <div class="gallery-block container w3-center w3-padding-32">
        <h2 class="ge-flow-bold size_34 w3-text-white wow fadeIn  animated">
            <?=$row['name'.$ext]?>
        </h2>
        <div class="margin_center" style="background-color: #ffbd00;height: 3px;width: 50px"></div>
        <ul id="filters" class="clearfix width_75 margin_center w3-padding-16 <?=$dir?>" style="padding-right: 0;padding-left: 0">

            <?
            $q1 = mysqli_query2("select id from page where Active = 1 and  parent_id = 886 order by the_order, id desc");
            while ($r1 = mysqli_fetch_array($q1)){
                $ids .= $r1["id"].",";
            }
            $ids = substr($ids,0,-1);
            $ik = 0;
            $i =0;
            $q1 = mysqli_query2("select id,name_en,name from page where Active = 1 and  parent_id = 886 order by the_order, id desc");
            while ($r1 = mysqli_fetch_array($q1)){
                $i ++;
                $ik +=0.2;
                ?><li class="animated wow fadeIn w3-text-white" data-wow-delay="<?=$ik?>s"><span class="filter <?=$i == 1 ? 'active' : ''?>" data-filter=".<?=$r1['id']?>"><?=$r1["name".$ext]?></span></li><?
            }
            ?>
        </ul>
        <div id="portfoliolist" class="w3-row width_75 margin_center">
            <?
            $q1 = mysqli_query2("select id,name_en,name from page where Active = 1 and  parent_id = 886 order by the_order, id desc");
            while($r1 = mysqli_fetch_array($q1)){
                $q = mysqli_query2("select * from page where parent_id = ".$r1["id"]." order by the_order, id desc limit 9");
                while($r = mysqli_fetch_array($q)){
                    ?>
                    <div class="portfolio <?=$r['parent_id']?> w3-col l4 m6 s12 w3-padding" data-cat="<?=$r['parent_id']?>">
                        <div style="margin: 16px">
                            <a  href='<?=link_url($r)?>'>
                            <div class="div_image relative" style="background-image:url('pages/photos/<?=rawurlencode($r['src'])?>')"></div>
                            <div class="w3-white w3-padding text-<?=$align?> <?=$dir?>" style="height: 200px;overflow: hidden">
                                <h3 class="w3-text-brown opacity">
                                    <?=$r["name".$ext]?>
                                </h3>
                                <p class="w3-text-grey opacity">
                                    <?=$r["description".$ext]?>
                                </p>
                            </div>
                            </a>
                        </div>
                    </div>
                    <?
                }
            }
            ?>
        </div>
    </div>
</div>
<?
include "directory.php";