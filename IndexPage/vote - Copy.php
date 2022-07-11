<?
if($_POST["v_test_id"] !=""){
    include "../../logs/function_2.php";
    include "../../register/IndexPage/cookie.php";
    $tid = intval($_POST["v_test_id"]);
}
$query_vote=mysqli_query2("select * from vote where user_id='".$mid."' and test_id='".$tid."'");
if(mysqli_affected_rows2()>0){/////////////////if vote
$row_vote=mysqli_fetch_array($query_vote);
?>
<table   style="width:100%; direction:rtl" dir="rtl" class="label">
    <tr>
        <td  width="100%" colspan="2"  valign="top" class="text2" height="30"><div class="bold size_1x color_4c decoration" align="right" >نتيجة تقييمك:</div></td>
    </tr>
    <tr>
        <td class="color_3c label" width="10%" align="right">النتيجة : </td>
        <td align="right" width="90%"><div align="right"> <?=$row_vote["result"]=="3" ? "صحيحة" : " "?><?=$row_vote["result"]=="2" ? "نوعاً ما" : " "?><?=$row_vote["result"]=="1" ? " غير صحيحة" : " "?> </div></td>
    </tr>
    <tr>
        <td class="label" style="vertical-align:middle"><div class="color_3c" align="right" >تعليقك: </div></td>
        <td align="right"><div align="right"><?=nl2br($row_vote[vote])?></div></td>
    </tr>
</table>

<?
}else{
    ?>
    <div class="text" dir="rtl" style="margin:2" align="justify">
        <form method="POST" name="form_vote" id="form_vote"  dir="rtl">
            <input type="hidden" name="tname_v" value="<?=$test_name?>">
            <input type="hidden" name="tid_v" value="<?=$test_id?>">
            <table border="0" width="67%" style="width:100%; direction:rtl" dir="rtl" class="label">
                <tr>
                    <td  width="100%" colspan="2"  valign="top" class="text2" height="30"><div class="color_4c decoration" align="right" >ماهو تقييمك لنتيجة الاختبار:</div></td>
                </tr>
                <tr>
                    <td class="label" width="60"><div class="color_3c" align="right">النتيجة : <font color="#ff0000" style="font-size:11px">*</font></div></td>
                    <td align="right"><div align="right"> صحيحة <input type="radio" name="openion" value="3"   >&nbsp;&nbsp;&nbsp; نوعاً ما <input type="radio" name="openion"    value="2"> &nbsp;&nbsp;&nbsp; غير صحيحة <input type="radio" name="openion"  value="1" > </div></td>
                </tr>
                <tr>
                    <td class="label" style="vertical-align:middle"><div class="color_3c" align="right" >تعليقك: <font color="#ff0000" style="font-size:11px">*</font></div></td>
                    <td align="right"><div align="right"><textarea rows="5" name="note" style="direction:rtl;" cols="40" class="form empty"></textarea></div></td>
                </tr>
                <tr>
                    <td></td>
                    <td align="right"><div align="right"><input type="submit" style="color:#4E3D1E" name="submit" value="إرسال" class="form"></div></td>
                </tr>
            </table>

        </form>
    </div>

<?
}///////////////////////end if vote

$query_vote_2=mysqli_query2("select * from vote where user_id <> '".$mid."' and test_id='".$tid."'");
if(mysqli_affected_rows2()>0){/////////////////if vote
?>
    <table   style="width:100%; direction:rtl" dir="rtl" class="label">
    <tr>
        <td  width="100%" colspan="2"  valign="top" class="text2" align="center"><div style="width: 95%; margin: 10px 0 10px 0; border-radius: 10px; border: 1px solid silver; padding: 10px;line-height: 20px; vertical-align: middle; background: #eeeeee; color: #444444" class="bold size_1x " align="center" >  أراء الأعضاء  </div></td>
    </tr>
    <?
    while($row_vote=mysqli_fetch_array($query_vote_2)){
        $quser = mysqli_query2("select user_fname from user where id = '".$row_vote["user_id"]."' ");
        $ruser = mysqli_fetch_array($quser);
    ?>

        <tr>
            <td align="right" width="100%" colspan="2"><div align="right" class="color_5c italic"> <?=$ruser["user_fname"]?> بتاريخ <?=$row_vote["add_date"]?>   </div></td>
        </tr>

        <tr>
                <td class="color_3c label" width="10%" align="right">النتيجة : </td>
                <td align="right" width="90%"><div align="right"> <?=$row_vote["result"]=="3" ? "صحيحة" : " "?><?=$row_vote["result"]=="2" ? "نوعاً ما" : " "?><?=$row_vote["result"]=="1" ? " غير صحيحة" : " "?> </div></td>
        </tr>
        <tr>
            <td class="label" style="vertical-align:middle"><div class="color_3c" align="right" >التعليق: </div></td>
            <td align="right"><div align="right"><?=nl2br($row_vote[vote])?></div></td>
        </tr>
        <tr>
            <td colspan="2"><hr style="width: 100%; height: 1px;color: #494949"></td>
        </tr>
        <?
    }
        ?></table><?
}
?>
