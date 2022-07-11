<?php
session_start();
include "logs/function.php";
include "languages/ar.php";
require_once('plugins/phpmailer-master/class.phpmailer.php');
define("main","true");
secure_website();
////////////////////////////// mod rerwite
$url = strip_tags($_GET["url"]);
$url = explode("/",$url);
$type=strip_tags($url[0]);
if($type =="hash"){
    $hash = strip_tags($url[1]);
}else{
    if($url[1]) {
        $q = mysqli_query2("select * from page where cleanurl".$ext." like '".mysqli_real_escape_string($GLOBALS["db_link"],$url[1])."'");
        $r = @mysqli_fetch_array($q);
        $pid = $r["id"];
        $name_en = $r["name_en"];
        $name_ar = $r["name"];
        $cleanurl_en = $r["cleanurl_en"];
        $cleanurl = $r["cleanurl"];
        $description = $r["description".$ext];
        $the_parent = $r["parent_id"];
        $text = $r["text".$ext];
        $the_type_page = $r["type_page"];

    }elseif($url[0]){
        $q = mysqli_query2("select * from page where cleanurl".$ext." like '".mysqli_real_escape_string($GLOBALS["db_link"],$url[0])."'  or (ext_link like '".mysqli_real_escape_string($GLOBALS["db_link"],$url[0])."' and ext_link not like '') ");
        $r = @mysqli_fetch_array($q);
        $pid = $r["id"];
        $the_parent = $r["parent_id"];
        $name_en = $r["name_en"];
        $name_ar = $r["name"];
        $cleanurl_en = $r["cleanurl_en"];
        $cleanurl = $r["cleanurl"];
        $description = $r["description".$ext];
        $the_parent = $r["parent_id"];
        $text = $r["text".$ext];
        $the_type_page = $r["type_page"];

    }
}
/////////////////////////// language
$href = "ar/".$type."/".$cleanurl;
$href_en = "en/".$type."/".$cleanurl_en;
///////////////
$qsettings = mysqli_query2("select * from settings where id= 1");
$rsettings = mysqli_fetch_array($qsettings);
//////////////////////////////////////////////////
$url_home = pathUrl(__DIR__);
///////////////////////////////////////// Page id

$qtext = mysqli_query2("select * from page where id = '".$pid."'");
$rtext = mysqli_fetch_array($qtext);

if($type !=""){
    $qp = mysqli_query2("select * from page where id='".$pid."'");
    $rp = mysqli_fetch_array($qp);
    $pid = $rp["id"];
    $param = $rp["name".$ext];
    $description_face = strword($rp["text".$ext],30);
    if($rp["src"] !=""){
        $src_face = $rp["src"];
    }elseif($rp["src_2"] !=""){
        $src_face = $rp["src_2"];
    }
    $src = $rp["src"];
    $src_2 = $rp["src_2"];

    $image_face = $url_home."pages/photos/".$src_face;
    $keyword =str_replace(" ",",",$description_face);
    $keyword =str_replace("&nbsp;","",$keyword);
    $keyword =str_replace(",,","",$keyword);
    if($rp["keyword_website"] !=""){
        $keyword = $rp["keyword_website"];
    }
}elseif($type == "activities"){
    $param = "All Activities";
}else{
    $param = $label_home;
}

counter($pid);
if($rsettings["maintenance"] == 1){
    header("location:maintenance.html");
    exit;
}
//////////////////////////////////// Log in Info
$email_u = $_SESSION["email_u"];
$pass_u = $_SESSION["pass_u"];
$id_u = $_SESSION["mid"];
$quserInfo = mysqli_query2("select * from t_members where  active=1 and t_email like '".$email_u."' and t_pass like '".$pass_u."' and id='".$id_u."'");
if(mysqli_affected_rows2() > 0){
    $ruserInfo = mysqli_fetch_array($quserInfo);
    $login = 1;
}
if($type == "cart" || $type == "update" || $type == "mypage" || $type == "reports"){
    include "cookie.php";
}
if ($_POST["reg"]=="update-123-876"){
    include "cookie.php";
    include "members/IndexPage/memberUpdate.php";
}
if($type == "logout"){
    include "members/IndexPage/logout.php";
}
////////////////////////////////////////////////////////////////////////////////
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <base href="<?=$url_home?>">
    <title>
        <?=$label_Syrian_Association_of_Travel_Tourism_Agents?>
        - <?php print $param;?>   </title>
    <link rel="SHORTCUT ICON" href="images/favicon.png">
    <meta name="keywords" content="<?=$keyword?>" />
    <meta name="description" content="<?=$description_face?>"/>
    <meta property="og:title"              content="<?=$param?>" />
    <meta property="og:description"        content="<?=$description_face?>" />
    <meta property="og:image"              content="<?=$image_face?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="plugins/upload-file/css/uploadfile.css">
    <link rel="stylesheet" href="plugins/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/w3c/w3.css">
    <script src="plugins/jquery-latest/dist/jquery.min.js"></script>
    <script src="plugins/bootstrap/dist/js/bootstrap.min.js" async="async"></script>
    <!-- Fancy Box -->
    <link rel="stylesheet" type="text/css" media="all" href="plugins/fancybox/source/jquery.fancybox.css">
    <script type="text/javascript" src="plugins/fancybox/source/jquery.fancybox.js"></script>
    <!-- SCroll Reveal -->
    <script src='plugins/scrollReveal/scrollReveal.js'></script>
    <link rel="stylesheet" href="plugins/animate.css/animate.min.css">
    <script src="plugins/animate.css/wow.js"></script>
    <script src="plugins/parallax-scrolling/js/skrollr.js"></script>
    <!-- MAIN -->
    <script type="text/javascript" src="js/main.js"></script>
    <!-- Slick Slider -->
    <link rel="stylesheet" type="text/css" href="plugins/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="plugins/slick/slick-theme.css"/>
    <script type="text/javascript" src="plugins/slick/slick.js"></script>
    <script type="text/javascript" src="plugins/animatescroll.js-master/animatescroll.js"></script>
    <script src="plugins/parallax-scrolling/js/skrollr.js"></script>
    <link rel="stylesheet" type="text/css" href="plugins/datepicker/css/datepicker.css"/>
    <script type="text/javascript" src="plugins/datepicker/js/bootstrap-datepicker.js"></script>


    <script type="text/javascript">
        new WOW().init();
        $(function() {
            $(".nav-main a,.block-nav-bottom a").click(function(){
                var s = $(this).attr("href");
                var string = s.split('hash/')[1];
                if ( $( "#"+string ).length ) {
                    scrollTo2("#"+string);
                    return false;
                }
            });
            <?php
            if($hash){
               ?>
            scrollTo2("#<?=$hash?>");
            <?php
        }
        ?>
        });
        $(document).ready(function(){
            <?if($type ==""){}else{?>
            $('.body').animatescroll({scrollSpeed:2000,easing:'easeOutExpo'});
            <?}?>
        });
    </script>
    <link rel="stylesheet" href="css/style_ar.css">
    <link rel="stylesheet" href="css/mobile.css">
    <link rel="stylesheet" href="plugins/hover/hover.css">
    <link rel="stylesheet"  href="images/review.css" type="text/css" media="all">
    <script src="plugins/jquery-match-height-master/jquery.matchHeight.js"></script>
    <script src="plugins/TickerMePink/assets/js/tickerme.js"></script>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/simple-portfolio-page/css/layout.css" />
    <script type="text/javascript" src="plugins/simple-portfolio-page/js/jquery.mixitup.min.js"></script>
    <!--<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyD3B0wEVj2GEP-zSin6eDuU26WAdNw0Zgs"></script>-->
</head>
<body>
<?php
include "language-menu.php";
include "slider.php";
?>
<div style="min-height: 500px">
    <div class="container w3-padding-8 relative" style="background-color: #fff">
        <div>
            <style>
                .nav-login li{
                    text-align: center;
                    direction: rtl;
                }
                .nav-login li a{
                    padding: 2px 8px;
                    font-size: 14px;
                }
            </style>
            <ul class="nav navbar-nav navbar-right nav-login">
                <li  class="<?=$login !='' ? 'w3-hide' : ''?>">
                    <a href="<?=$ext_page?>login" class="w3-text-red">
                        <?=$label_Login?>
                    </a>
                </li>
                <li  class="<?=$login =='' ? 'w3-hide' : ''?>">
                    <a href="<?=$ext_page?>update" class="w3-text-red">
                        <?=$label_My_Personal?>
                    </a>
                </li>
                <li class="<?=$login =='' ? 'w3-hide' : ''?>">
                    <a href="logout" class="icon-white"><i class="glyphicon glyphicon-log-out"></i> تسجيل خروج</a>
                </li>
            </ul>
            <div style="clear: both"></div>
        </div>
        <div style="position: absolute;right: 102%;top: 40px">
            <a href="javascript:void(0)" class="w3-text-white opacity hidden-xs" style="text-shadow: 1px 1px 1px #000">
                English
            </a>
        </div>
        <div style="display: flex;justify-content: center;align-items: center">
            <div style="flex: 1" class="w3-padding hidden-sm hidden-xs">
                <div class="text-left">
                    <form method="get" action="<?=$ext_page?>cat">
                        <div class="input-group" style="max-width: 200px">
                            <input type="text" name="key_s" value="<?=$_GET['key_s']?>" class="form-control" placeholder="Search" style="border-color: transparent;border-bottom:2px solid #91cae0;box-shadow: none;" pattern="\s*(\S\s*){3,}" title="يرجى ادخال أكثر من ثلاث أحرف">
                            <div class="input-group-btn">
                                <button  class="btn btn-default" type="submit" style="background: none;border-color: transparent;padding: 8px 0;font-size: 18px;">
                                    <i class="glyphicon glyphicon-search w3-text-light-blue"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="text-left">
                    <a class="social-icon size_18 w3-text-brown w3-hover-text-deep-orange hvr-grow" style="padding:8px 16px" target="blank" href="<?=$rsettings['link_twitter']?>">
                        <i class="fa fa-twitter"></i>
                    </a>
                    <a class="social-icon size_18 w3-text-brown w3-hover-text-deep-orange hvr-grow" style="padding:8px 16px" target="blank" href="<?=$rsettings['link_facebook']?>">
                        <i class="fa fa-facebook"></i>
                    </a>
                    <a class="social-icon size_18 w3-text-brown w3-hover-text-deep-orange hvr-grow" style="padding:8px 16px" target="blank" href="<?=$rsettings['link_youtube']?>">
                        <i class="fa fa-youtube"></i>
                    </a>
                    <a class="social-icon size_18 w3-text-brown w3-hover-text-deep-orange hvr-grow" style="padding:8px 16px" target="blank" href="<?=$rsettings['link_inst']?>">
                        <i class="fa fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div style="flex: 2" class="w3-padding">
                <div class="text-center">
                    <a href="<?=$ext_page?>">
                        <img src="images/logo2.png" class="max_width_100 opacity"/>
                    </a>
                </div>
                <div class="w3-margin-top">
                    <nav class="navbar navbar-default">
                        <div class="<?=$dir?>" style="padding-left: 0">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle w3-margin-0" data-toggle="collapse" data-target="#myNavbar">
                                    <i class="fa fa-th-large vertical_middle" style="margin-left: 4px"></i>
                                    <?=$label_Menu?>
                                </button>
                            </div>
                            <div style="margin-top: 6px" class="collapse navbar-collapse w3-padding-0" id="myNavbar">
                                <ul class="nav navbar-nav  navbar-right">
                                    <?php
                                    include "pages/IndexPage/Navigation.php";
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
            <div style="flex: 1" class="w3-padding  hidden-sm hidden-xs">
                <div class="text-right">
                    <a href="<?=$ext_page?>">
                        <img src="images/logo.png" class="max_width_100 opacity"/>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .nav-2 .navbar-nav>li>a{
        border-top: 3px solid transparent !important;
        color: #fff;
        font-size: 16px;
        border-bottom: 3px solid transparent;
    }
    .nav-2 .open>a, .nav-2 .open>a:focus, .nav-2 .open>a:hover {
        background-color: transparent;
        border-color: #653422;
    }
    .nav-2 .navbar-nav>li>a:hover{
        background-color: transparent;
        color: #653422;
        border-bottom: 3px solid #653422;
    }
</style>
<nav class="w3-light-blue nav-2" style="display: block;">
    <div class="container">
        <ul class="nav navbar-nav navbar-right">
            <?
            $q_pages = mysqli_query2("select * from page where   Active=1 and m_main=1  and parent_id=0   order by the_order,id desc ");
            while($r_pages = mysqli_fetch_array($q_pages)){

                $type_page = $r_pages["type_page"];
                if($type_page == ""){$type_page = "page";}
                if($type_page != "" and $type_page !="page"){$pid_page = "";}else{$pid_page = "&pid=".$r_pages['id'];}
                if($r_pages["ext_link"] !=""){
                    $link_page = $r_pages["ext_link"];
                    if($ext_page == "en/"){
                        //$link_page = str_replace("index.php","index_ar.php",$link_page);
                        $link_page = "en/".$r_pages["ext_link"];
                    }elseif($ext_page == "ar/"){
                        //$link_page = str_replace("index.php","index_ar.php",$link_page);
                        $link_page = "ar/".$r_pages["ext_link"];
                    }
                }else{
                    $link_page = $ext_page."page/".$r_pages["cleanurl".$ext];
                }
                $arr = explode("/",$_SERVER["REQUEST_URI"]);
                $size_arr = sizeof($arr);
                $link_now = $arr[$size_arr-1];

                $qcat1 = mysqli_query2("select * from page where parent_id ='".$r_pages["id"]."' and Active = 1   order by the_order,id desc");
                if(mysqli_affected_rows2() > 0  && $r_pages["type_page"] == "menu"){
                    ?>
                    <li class="dropdown hidden-xs">
                        <a href="javascript:void(0)" class="menu__link dropdown-toggle" data-toggle="dropdown">
                            <?=$r_pages["name".$ext]?>
                            <b class="caret"></b></a>

                        <ul class="dropdown-menu  row w3-light-grey" style="border-radius: 0;border: 0;padding: 0">

                            <?php
                            $ijk = 0;
                            while($r1 = mysqli_fetch_array($qcat1)){
                                $ijk ++ ;
                                $q2 = mysqli_query2("select * from page where parent_id = ".$r1['id']." and Active=1 order by the_order,id desc");
                                if($r_pages["id"] == 73){
                                    $catee = "products";
                                }else{
                                    $catee = "page";
                                }
                                ?>
                            <li class="text-<?=$align?>">
                                <a class="w3-padding-8 w3-text-black w3-hover-brown w3-hover-text-light-blue size_16" href="<?=link_url($r1)?>"><?=$r1["name".$ext]?></a>
                                </li><?
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                }else{
                    ?>
                    <li <?=($pid == $r_pages["id"]) ? "class='active  hidden-xs'" : "class='active  hidden-xs'"?>>
                        <a href="<?php print $link_page;?>">
                            <?php print $r_pages["name".$ext] ?>
                        </a>
                    </li>
                    <?
                }
            }
            ?>
        </ul>
    </div>
</nav>



<div class="body" id="body">
    <?

    switch ($type){
        case "page":
            if($the_type_page == "section")
                include "cat.php";
            else
                include "text.php";
            break;
        case "cat":
            include "cat.php";
            break;
        case "news":
            include "news.php";
            break;
        case "management":
            include "management.php";
            break;
        case "companies":
            include "companies.php";
            break;
        case "laws":
            include "laws.php";
            break;
        case "search":
            include "Search.php";
            break;
        case "login":
            include "login-page.php";
            break;
        case "mypage":
            include "my_page.php";
            break;
        case "update":
            include "members/IndexPage/update-form.php";
            break;
        default:
            include "home.php";
            break;
    }
    ?>
</div>
<div class="width_100  footer">
    <div class="container w3-padding-32 ">
        <div class="row w3-margin-bottom">
            <div class="col-md-4 center-medium text-right">
                <a href="<?=$ext_page?>">
                    <img src="images/logo.png" class="opacity w3-padding-32 w3-padding-16-h img-responsive margin_center">
                </a>
                <div class="text-center">
                    <a class="social-icon size_18 w3-text-grey w3-hover-text-deep-orange hvr-grow" style="padding:8px 16px" target="blank" href="<?=$rsettings['link_twitter']?>">
                        <i class="fa fa-twitter"></i>
                    </a>
                    <a class="social-icon size_18 w3-text-grey w3-hover-text-deep-orange hvr-grow" style="padding:8px 16px" target="blank" href="<?=$rsettings['link_facebook']?>">
                        <i class="fa fa-facebook"></i>
                    </a>
                    <a class="social-icon size_18 w3-text-grey w3-hover-text-deep-orange hvr-grow" style="padding:8px 16px" target="blank" href="<?=$rsettings['link_youtube']?>">
                        <i class="fa fa-youtube"></i>
                    </a>
                    <a class="social-icon size_18 w3-text-grey w3-hover-text-deep-orange hvr-grow" style="padding:8px 16px" target="blank" href="<?=$rsettings['link_inst']?>">
                        <i class="fa fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-4 text-right">
                <div class="<?=$dir?> w3-text-white2">
                    <h3 class="w3-text-brown ge-flow-bold">
                        القائمة البريدية
                    </h3>
                    <div  style="background-color: #ffbd00;height: 3px;width: 50px"></div>
                    <div class="w3-padding-8 <?=$dir?> w3-text-grey">
                        <div class="inline-block">
                            اشترك بقائمتنا البريدية ليصلك كل جديد عن الغرفة
                        </div>
                    </div>
                    <div class="mailing">
                        <div class="w3-row" style="padding-bottom: 15px">
                            <form class="w3-form mailing-form w3-padding-0" method="post" action="add_mail.php">
                                <div>
                                    <input type="text" required name="email" class="lrt text-right" placeholder="أدخل بريدك الالكتروني">
                                </div>
                                <div class="text-<?=$align?> <?=$dir?>" style="margin-top: 4px">
                                    <button class="btn w3-deep-orange w3-hover-light-grey" style="border: 0 !important;">
                                        <?=$label_Subscribe?>
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <h3 class="w3-text-brown ge-flow-bold">
                    &nbsp;
                </h3>
                <div  style="background-color: #ffbd00;height: 3px;width: 50px;visibility: hidden"></div>
                <ul class="nav navbar-nav <?=$dir?> sections">
                    <?
                    $q = mysqli_query2("select * from page where  parent_id = 0 and type_page not in ('section','menu')  and Active=1 order by the_order,id desc");
                    while ($r = mysqli_fetch_array($q)) {
                        ?>
                        <li class="li-first">
                            <a href="<?=link_url($r)?>">
                                <span>
                                    <?=$r['name'.$ext]?>
                                </span>
                            </a>
                        </li>
                        <?
                    }
                    ?>
                </ul>
            </div>

        </div>
    </div>
</div>
<div class="container text-<?=$align?>">
    <div class="w3-text-grey text-<?=$align?> tahoma w3-padding" style="font-size: 11px;">
        Powered by  <a href="http://syrianmonster.com/" target="_blank" class="w3-hover-text-brown">SyrianMonster</a> Web Service Provider - all rights reserved <?=date('Y')?>            </div>
</div>








<div class="modal fade rtl" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="margin-top: 100px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-center bold size_22 w3-text-grey">
                    بحث في الموقع
                </h4>
            </div>
            <div class="modal-body">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="signin">
                        <form class="form-horizontal" action="<?=$ext_page?>cat">
                            <div class="control-group">
                                <div class="controls">
                                    <input value="<?=$_GET['key_s']?>" required="" name="key_s" type="text" class="form-control size_22 text-<?=$align?> <?=$dir?> input-medium" placeholder="كلمة البحث..." >
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="search"></label>
                                <div class="controls">
                                    <button  type="submit" class="search-btn-2 btn w3-brown w3-hover-light-blue transition_03 btn-lg btn-block" style="padding: 8px 20px;">
                                        بحث
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>

            </div>
        </div>
    </div>
</div>

<div id="back-top-wrapper" class="w3-hide-medium w3-hide-small">
    <p id="back-top">
        <a href="#top" class="hvr-shrink">
            <img src="images/arrow-top.png" alt="arrow-top"/>
        </a> </p>
</div>
<?
$q1 = mysqli_query2("select id,name_en,name from page where Active = 1 and  parent_id = 886 order by the_order, id desc");
$r1 = @mysqli_fetch_array($q1);
$first_cat =$r1["id"];

?>
<script type="text/javascript">

    $(function () {
        var filterList = {
            init: function () {
                $('#portfoliolist').mixItUp({
                    selectors: {
                        target: '.portfolio',
                        filter: '.filter'
                    },
                    load: {
                        filter: '.<?=$first_cat?>'
                    }
                });
            }
        };
        // Run the show!
        filterList.init();
    });
</script>
<script src="js/bottom.js"></script>
<script>
    $(document).ready(function(){
        $('#search-btn').on('click', function(event) {
            event.preventDefault();
            $('#search').addClass('open');
            $('#search > form > input[type="search"]').focus();
        });

        $('#search, #search button.close').on('click keyup', function(event) {
            if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
                $(this).removeClass('open');
            }
        });
        $(function () {
            var filterList = {
                init: function () {
                    $('#portfoliolist').mixItUp({
                        selectors: {
                            target: '.portfolio',
                            filter: '.filter'
                        },
                        load: {
                            filter: '.160'
                        }
                    });
                }
            };
            // Run the show!
            filterList.init();
        });
    })
</script>
<!--<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a4adc6afb3ceeb2" async></script>-->

</body>
</html>