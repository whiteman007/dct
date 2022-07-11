<?php
if(main != "true"){
    die("Access Denied");
}
$query=mysqli_query2("select * from page where  id='941' ");
$row=mysqli_fetch_array($query);
?>
<div class="w3-padding-64 w3-light-grey">
    <div class="container news" style="margin-top: 32px">
        <h2 class="ge-flow-bold size_34 w3-text-brown text-center title <?=$dir?>">
            <?=$row["name".$ext]?>
        </h2>
        <div class="margin_center" style="background-color: #ffbd00;height: 3px;width: 50px"></div>
    </div>
    <div class="width_100 w3-padding-16">
        <div class="container blk-brand slider-locations-c">
            <div class="slider-container relative  w3-padding-32-h">
                <div class="slider-locations w3-margin-top w3-padding-top">
                    <?
                    $q = mysqli_query2("select * from page where  Active=1 and parent_id = 941  order by the_order,id desc ");
                    while ($r = mysqli_fetch_array($q)) {
                        ?>
                        <div class="slide-item w3-padding" style="display: flex">
                            <div class="w3-padding text-<?=$align?> <?=$dir?>" style="flex: 1">
                                    <h3 class="size_14">
                                        <a class="opacity w3-text-brown" href="<?=link_url($r)?>"><?=$r["name".$ext]?></a>
                                    </h3>
                                    <p class="size_14">
                                        <a class="opacity w3-text-grey" href="<?=link_url($r)?>"><?=$r["description".$ext]?></a>
                                    </p>
                            </div>
                            <div style="flex: 1;min-height: 250px">
                                <div class="w3-border w3-margin-left height_100">
                                    <a href="<?=link_url($r)?>">
                                        <div class="content opacity transition_03"  style="background-image: url('pages/photos/<?=$r['src']?>');height: 100%;width: 100%;background-size: cover!important;"></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?
                    }
                    ?>
                </div>
                <div class="w3-margin-top text-center">
                    <a href="javascript:void(0)" class="arrows arrow-left-2 w3-text-light-blue w3-hover-text-brown inline-block w3-margin-<?=$align?>">
                        <i class="fa fa-angle-left size_40"></i>
                    </a>
                    &nbsp;
                    <a href="javascript:void(0)" class="arrows arrow-right-2  w3-text-light-blue w3-hover-text-brown inline-block ">
                        <i class="fa fa-angle-right size_40"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(".slider-locations").slick({
        fade: false,
        cssEase: 'linear',
        autoplay: true,
        arrows:true,
        prevArrow: ".slider-locations-c .arrow-left-2",
        nextArrow: ".slider-locations-c .arrow-right-2",
        autoplaySpeed:5000,
        dots: false,
        slidesToShow: 2,
        slidesToScroll: 1,
        adaptiveHeight: true,
        draggable : false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
</script>