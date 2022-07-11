<?php
if(main != "true"){
    die("Access Denied");
}
$pid=intval($pid);
if($pid < 1){
    $pid=1;
}
$query=mysqli_query2("select * from page where  id='880' ");
$row=mysqli_fetch_array($query);
?>
<div class="width_100 w3-padding-32 w3-light-grey">
    <div class="container blk-brand slider-company-c">
        <div class="text-center">
            <h2 class="ge-flow-bold size_34 w3-text-brown text-center title <?=$dir?>">
                <?=$row["name".$ext]?>
            </h2>
            <div class="margin_center" style="background-color: #ffbd00;height: 3px;width: 50px"></div>
        </div>
        <div class="slider-container relative  w3-padding-32-h">
            <a href="javascript:void(0)" class="arrows arrow-left inline-block w3-margin-<?=$align?>">
                <img class="invert" src="images/arrow-left.png" alt="arrow-left"/>
            </a>
            <a href="javascript:void(0)" class="arrows arrow-right inline-block ">
                <img class="invert" src="images/arrow-right.png" alt="arrow-right"/>
            </a>
            <div class="slider-company w3-margin-top w3-padding-top">
                <?
                $q = mysqli_query2("select * from page where  Active=1 and parent_id = 880  order by the_order,id desc ");
                while ($r = mysqli_fetch_array($q)) {
                    ?>
                    <div class="slide-item w3-padding">
                        <div class="w3-padding">
                            <a href="<?=link_url($r)?>" target="<?=$the_target?>">
                                <div class="content opacity transition_03"  style="background-image: url('pages/photos/<?=$r['src']?>')"></div>
                            </a>
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
    $(".slider-company").slick({
        fade: false,
        cssEase: 'linear',
        autoplay: true,
        arrows:true,
        prevArrow: ".slider-company-c .arrow-left",
        nextArrow: ".slider-company-c .arrow-right",
        autoplaySpeed:5000,
        dots: false,
        slidesToShow: 5,
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
