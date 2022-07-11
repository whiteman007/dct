<style>
    #container-wpml {
        position: fixed;
        top: 4px;
        right: 0;
        z-index: 9999 !important;
        background-color: #653422 !important;
        line-height: 20px;
        text-align: center;
        color: #fff !important;
        cursor: pointer;
        font-size: 16px;
        margin: 0 auto;
        padding: 5px 0;
        width: 35px;
    }
    #container-search {
        position: fixed;
        top: 36px;
        right: 0;
        z-index: 9998 !important;
        background-color: #653422 !important;
        line-height: 20px;
        text-align: center;
        color: #fff !important;
        cursor: pointer;
        font-size: 16px;
        margin: 0 auto;
        padding: 5px 0;
        width: 35px;
    }

    .lang-wpml {
        position: fixed;
        top: 34px;
        right: 0;
        display: none;
        z-index: 1000002;
        font-size: 16px;
    }
    #lang_sel_list.lang_sel_list_vertical {
        width: 35px !important;
        background-color: #653422 !important;
    }
    #lang_sel_list.lang_sel_list_vertical ul {
        border: none !important;
        top: 60px;
        left: 0;
        padding: 0 !important;
        margin: 0 !important;
        list-style-type: none !important;
    }
    #lang_sel_list.lang_sel_list_vertical ul li{
        background-color: #653422 !important;
        text-align: center;
        color: #fff !important;
        cursor: pointer;
        line-height: 20px;
        margin: 0 auto;
        transition: .3s ease;
        width: 35px;
        padding: 5px 0;

    }
    #lang_sel_list.lang_sel_list_vertical ul li:hover{
        background-color: #19200e !important;
        color: #fff !important;
    }
    @media all and (max-width: 767px) {
        #container-wpml {
            right: auto;
            left: 0;
        }
        #container-search {
            top: 36px;
            right: auto;
            left: 0;
        }
        .lang-wpml {
            right: auto;
            left: 0;
        }
        .navbar-nav {
            margin: 0;
            padding: 0;
        }
    }

</style>
<div id="container-wpml" class="hidden-lg hidden-md hidden-sm"  data-sr="enter left wait .2s"><?=$label_lang?></div>
<a id="container-search" class="hidden-lg hidden-md hidden-sm"  href="javascript:void(0)" data-toggle="modal" data-target="#myModal" data-sr="enter left wait .2s"><i class="glyphicon glyphicon-search size_16"></i></a>
<div class="lang-wpml">
    <div id="lang_sel_list" class="lang_sel_list_vertical">
        <ul>
            <li class="icl-fr"><a href="<?=$href_en?>" class="lang_sel_other">EN</a></li>
            <li class="icl-en"><a href="<?=$href?>" class="lang_sel_sel">AR</a></li>
        </ul>
    </div>
</div>
<script>
    /*$("#container-wpml").click(function(){
        if($("#container-wpml").text() !=" X "){
            $("#container-wpml").text(" X ");
        }else{
            $("#container-wpml").text("EN");
        }
        $(".lang-wpml").slideToggle(500);

    });*/
</script>