<?
if(main != "true"){
    die("Access Denied");
}
?>
    <!-- Cycle Slide -->
    <script src="plugins/cycle2.carousel/jquery.cycle2.carousel.js"></script>
    <script src="plugins/cycle2.carousel/jquery.cycle2.js"></script>

<div class="header_1" style="margin: 0 auto; width:inhert">
    <script>$.fn.cycle.defaults.autoSelector = '.slideshow';</script>
    <div class="slideshow"
         data-cycle-fx=carousel
         data-cycle-timeout=6000
        
        >
    <?
    $f_q = mysqli_query2("select * from flasha order by the_order,id");
        while($f_r=mysqli_fetch_array($f_q)){
            ?>
            <img src="flasha/photos/<?=$f_r['src']?>"  style="height:400px;width:100%">
            <?
        }
    ?>
    </div>
</div>


<!-- تعليق -->