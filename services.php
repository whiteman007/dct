<?php
if(main != "true"){
    die("Access Denied");
}
$query=mysqli_query2("select * from page where  id='968' ");
$row=mysqli_fetch_array($query);
?>
<div class="container news" style="margin-top: 32px">
    <h2 class="ge-flow-bold size_34 w3-text-brown text-center title <?=$dir?>">
        <?=$row["name".$ext]?>
    </h2>
    <hr style="background-color: #e1d6d3;height: 3px">
</div>
<div class="width_100 w3-padding-16">
    <div class="container blk-brand slider-services-c">
        <div class="slider-container relative  w3-padding-32-h">
            <a href="javascript:void(0)" class="arrows arrow-left w3-text-light-blue w3-hover-text-brown inline-block w3-margin-<?=$align?>">
                <i class="fa fa-angle-left size_40"></i>
            </a>
            <a href="javascript:void(0)" class="arrows arrow-right  w3-text-light-blue w3-hover-text-brown inline-block ">
                <i class="fa fa-angle-right size_40"></i>
            </a>
            <div class="slider-services w3-margin-top w3-padding-top">
                <?
                $q = mysqli_query2("select * from page where  Active=1 and parent_id = 968  order by the_order,id desc ");
                while ($r = mysqli_fetch_array($q)) {
                    ?>
                    <div class="slide-item w3-padding w3-container">
                        <div class="pull-right">
                            <div class="w3-margin-left w3-padding w3-deep-orange">
                                <a href="<?=link_url($r)?>">
                                    <div class="content opacity transition_03"  style="background: url('pages/photos/<?=$r['src']?>') center center no-repeat;height: 50px;width: 50px"></div>
                                </a>
                            </div>
                        </div>
                        <div class="w3-rest text-<?=$align?> <?=$dir?>">
                                <a class="opacity w3-text-brown size_14" href="<?=link_url($r)?>"><?=$r["name".$ext]?></a>
                                <p class="size_14">
                                    <a class="opacity w3-text-grey" href="<?=link_url($r)?>"><?=$r["description".$ext]?></a>
                                </p>
                        </div>
                    </div>
                    <?
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(".slider-services").slick({
        fade: false,
        cssEase: 'linear',
        autoplay: true,
        arrows:true,
        prevArrow: ".slider-services-c .arrow-left",
        nextArrow: ".slider-services-c .arrow-right",
        autoplaySpeed:5000,
        dots: false,
        slidesToShow: 4,
        slidesToScroll: 1,
        adaptiveHeight: true,
        draggable : false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 767,
                settings: {
                    centerMode: false,
                    centerPadding: '40px',
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
</script>