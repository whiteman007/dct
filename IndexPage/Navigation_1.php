<?
if(main != "true"){
    die("Access Denied");
}
?>
<div class="nav-descktop w3-hide-small width_100">
    <div class="w3-row">
        <?php
        $q = mysqli_query2("select * from page where parent_id = 0 and place like 'one' order by the_order,id desc limit 4");
        while($r = mysqli_fetch_array($q)){
            ?>
            <div class="w3-col l3 m3 s3">
                <a href="<?=link_url($r)?>" class="w3-hover-text-red">
                    <?=$r["name".$ext]?>
                    <i class="fa"><img src="images/arrow.png" alt="arrow"/> </i>
                </a>
            </div>
        <?php
        }
        ?>
    </div>
    <div class="w3-row">

        <?php
        $q = mysqli_query2("select * from page where parent_id = 0 and place like 'two' order by the_order,id desc limit 4");
        while($r = mysqli_fetch_array($q)){
            $q1 = mysqli_query2("select * from page where parent_id = ".$r['id']." and Active=1 order by the_order,id desc");
            if(mysqli_affected_rows($GLOBALS["db_link"]) > 0){
                ?>
                <div class="w3-col l3 m3 s3">
                    <a href="javascript:void(0)" onmouseover="w3_close()" onclick="replacetext(this);w3_open()" class="w3-hover-text-red">
                        <?=$r["name".$ext]?>
                        <i class="fa"><img src="images/arrow.png" alt="arrow"/> </i>
                    </a>
                    <div class="w3-hide">
                        <?php
                        while($r1 = mysqli_fetch_array($q1)){
                            $q2 = mysqli_query2("select * from page where parent_id = ".$r1['id']." and Active=1 order by the_order,id desc");
                            if(mysqli_affected_rows($GLOBALS["db_link"]) > 0) {
                                ?>
                                <div class="w3-third w3-padding-32-all">
                                    <h3 class="w3-padding-bottom">
                                        <?=$r1["name".$ext]?>
                                    </h3>
                                    <?php
                                    while($r2 = mysqli_fetch_array($q2)){
                                        ?>
                                        <a class="w3-hover-text-red w3-padding-bottom"  href="<?=link_url($r2)?>" target="<?=$the_target?>">
                                            <?=$r2["name".$ext]?>
                                        </a>
                                    <?
                                    }
                                    ?>
                                </div>
                            <?
                            }else{
                                ?>
                                <div class="w3-third w3-padding-32-all">
                                    <a class="w3-hover-text-red"  href="<?=link_url($r1)?>" target="<?=$the_target?>">
                                        <h3 class="w3-padding-bottom">
                                            <?=$r1["name".$ext]?>
                                        </h3>
                                    </a>
                                </div>
                            <?
                            }
                        }
                        ?>
                    </div>

                </div>
            <?php
            }else{
                ?>
                <div class="w3-col l3 m3 s3">
                    <a href="<?=link_url($r)?>" target="<?=$the_target?>" onmouseover="w3_close()" class="w3-hover-text-red">
                        <?=$r["name".$ext]?>
                        <i class="fa"><img src="images/arrow.png" alt="arrow"/> </i>
                    </a>

                </div>
            <?php
            }
        }
        ?>
    </div>
</div>
