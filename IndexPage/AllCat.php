<?
if(main != "true"){
die("Access Denied");
}
?>

<h2><?=$param?></h2>
<table style="width: 910px" cellpadding="0" cellspacing="0">
    <tbody><tr>
        <td class="barCatogry">
            <table style="width: 100%" cellpadding="0" cellspacing="0" class="style1">
                <tbody><tr>
                    <td style="width:720px">Categories</td>
                    <td style="width:100px"> </td>
                    <td style="width:120px"></td>
                </tr>
                </tbody></table>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><table style="width: 100%" cellpadding="0" cellspacing="0" id="grid">
                <tbody>
                <tr>
                    <?
                    $sp1 = mysqli_query2("select * from page where parent_id='".intval($_GET["pid"])."' order by the_order, BINARY name".$ext);
                    $i=0;
                    if(mysqli_affected_rows($GLOBALS["db_link"])>0){
                        while($rp1 = mysqli_fetch_array($sp1)){
                            $qsub = mysqli_query2("select * from page where parent_id = '".$rp1["id"]."'");
                            if(mysqli_affected_rows($GLOBALS["db_link"])>0){
                                $category = "category";
                            }else{
                                $category = "page";
                            }
                        ?>
                            <td><div class="divContainerCatogry">
                                    <div> <img src="pages/photos/<?=$rp1['src']?>" width="208" height="174"></div>
                                    <div class="nameCorse">
                                        <a href="index.php?type=<?=$category?>&pid=<?=$rp1['id']?>"><?=$rp1["name".$ext]?></a></div>
                                </div></td>
                        <?
                            $i++;
                            if(fmod($i, 4) == "0"){
                                ?>
                                </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="width:21px">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="width:21px">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td style="width:21px">&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                <tr>
                                <?
                            }else{
                                ?><td style="width:21px">&nbsp;</td><?
                            }
                        }
                    }else{
                        print "<span class='label_orange'>".$empty_category."</span>";
                    }
                    ?>
                </tr>


<tr>
    <td colspan="10">
        <div style="text-align: center;width: 100%; padding: 20px 0"><a href="#" onclick="javascript:history.go(-1);return false" class="text"><?=$label_back?></a></div>
    </td>
</tr>




                </tbody></table></td>
    </tr>

    </tbody></table>
