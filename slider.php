<?php
if(main != "true"){
    die("Access Denied");
}
$pid=intval($pid);
if($pid < 1){
    $pid=1;
}
$query=mysqli_query2("select * from page where  id='".$pid."' ");
$row=mysqli_fetch_array($query);
$title = $row["name".$ext];
if($row["src"] !=""){$back_img = "pages/photos/".rawurlencode($row["src"]);}elseif($row["src_2"] !=""){$back_img = "pages/photos/".rawurlencode($row["src_2"]);}else{$back_img = "";}
?>
<div class="slider-top-wrapper">
    <div class="slider-top-1" style="height: 500px;overflow: hidden">
        <?
        $q = mysqli_query2("select * from page where  parent_id = '344' and Active=1 order by the_order,id desc");
        while ($r = mysqli_fetch_array($q)) {
            ?>
            <div class="item back-cover relative" style="background-image:url('pages/photos/<?=rawurlencode($r['src_2'])?>')">
                <div class="text-center" style="position: absolute;top: 50%;left: 5%;width: 90%;transform: translateY(-50%)">
                    <h3 class="size_27 w3-text-white" style="text-shadow: 1px 1px 1px #000">
                        <?=$r["name".$ext]?>
                    </h3>
                    <p class="ge-flow-bold size_27 w3-text-white" style="text-shadow: 1px 1px 1px #000">
                        <?=$r["description".$ext]?>
                    </p>
                </div>
            </div>
            <?
        }
        ?>
    </div>
</div>
<script>
    $('.slider-top-1').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: ".slider-top-wrapper .arrow-left",
        nextArrow: ".slider-top-wrapper .arrow-right",
        fade: true,
        dots: true,
        autoplay:false
    });
</script>