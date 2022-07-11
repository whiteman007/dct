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
if($row["src"] !=""){
    $back_img = "pages/photos/".$row["src"];
    $back_img_href = "pages/photos/".$row["src"];
}elseif($row["src_2"] !=""){
    $back_img = "pages/photos/".$row["src_2"];
    $back_img_href = "pages/photos/".$row["src_2"];
}else{
    $back_img = "images/berj.jpg";
    $back_img_href = "images/body.jpg";
    $hide_image = "ok";
}
?>

<div class="block-home block-text width_100 relative mydiv">
    <div class="width_75 margin_center">
        <div class="desc">
            <?
            $desc = explode("\n", str_replace("\r", "", $row["description".$ext]));
            ?>
            <div data-sr="enter left move 100px over 2s reset"><?=$desc["0"]?></div>
            <div data-sr="enter right move 100px over 2s reset"  class="w3-black w3-text-white"><?=$desc["1"]?></div>
            <div data-sr="enter left move 100px over 2s reset"><?=$desc["2"]?></div>
        </div>
        <div class="w3-padding-8 w3-row">
            <div class="w3-col l6 m6 s12 center-small relative div-image">
                <img src="<?=$back_img?>"/>

                &nbsp;
            </div>
            <div class="w3-col l6 m6 s12 w3-padding-16-all w3-justify">
                <div>
                    <?=$row["text".$ext]?>
                </div>
                <div class="w3-padding-8 w3-left-align icons">
                    <div class="w3-show-inline-block share w3-hover-white"  data-sr='scale up 20% roll 15deg spin 180deg reset '>
                        <div class="w3-show-inline-block hide-icon">
                            <div   style="display: inline-block !important;"><a onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="facebook-share-button" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($url_home.link_url($row));?>&picture=<?php echo urlencode($url_home.'pages/photos'.$back_img);?>&title=<?php echo urlencode($row['name'.$ext]);?>&description=<?php echo urlencode($row['description'.$ext]);?>"><i class="fa fa-facebook-f" aria-hidden="true"></i></a></div>
                            <div><a onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="http://twitter.com/share?text=<?=$row["description".$ext]?>&url=<?php echo urlencode($url_home.link_url($row));?>"><i class="fa fa-twitter" aria-hidden="true"></i></a></div>
                            <div><a onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="https://plus.google.com/share?url=<?php echo urlencode($url_home.link_url($row));?>&t=<?=urlencode($param)?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a></div>
                        </div>
                        <a href="javascript:void(0)"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
                    </div>

                </div>
                <?php
                if($pid=="2"){

                    ?>
                    <div class="text" dir="<?=$dir?>" style="margin-top:10px; margin-<?=$align?>:10px" >
                        <table border="0" width="100%" cellpadding="4" class="contact">
                            <tr>
                                <td style="width: 100%">
                                    <table border="0" style="width: 100%" cellpadding="4" class="label contact">
                                        <?
                                        include "pages/IndexPage/p1".$ext.".php";
                                        ?>
                                    </table>
                                </td>

                            </tr>
                        </table>
                    </div>

                <?php
                }
                ?>
            </div>
        </div>
        <?
        include "footer.php";
        ?>
    </div>
</div>


<!-- تعليق -->