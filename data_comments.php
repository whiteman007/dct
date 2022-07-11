<?
include "cookie.php";
$table="vote";
$page_name="comments.php";

$c_mains = mysqli_query2("select * from ".$table." where id='".$_GET[id]."' ");
$row = mysqli_fetch_array($c_mains);
?>
<script type="text/javascript">
$(document).ready(function(){

	})
</script>
    <table border="0" width="90%" dir="rtl" cellpadding="4" class="text">
        <tr>
            <td class="label" width="40%"> الاسم </td>
            <td align="<?=$align?>"><?=$row["name"]?></td>
        </tr>
        <tr>
            <td class="label">البريد الالكتروني: </td>
            <td align="<?=$align?>"><?=$row["email"]?></td>
        </tr>
        <tr>
            <td class="label">الجوال: </td>
            <td align="<?=$align?>"><?=$row["country"]?></td>
        </tr>
        <tr>
            <td class="label">التعليق: </td>
            <td align="<?=$align?>"><?=$row["vote"]?></td>
        </tr>
        <?
        if($row["src"]){
            ?>
            <tr>
                <td class="label">ملف: </td>
                <td align="<?=$align?>"><a target="_blank" href="../upload/upload/<?=$row['src']?>"><?=$row['src']?></a> </td>
            </tr>
            <?
        }
        if($row["id_number"]){
            ?>
            <tr>
                <td class="label">الرقم الوطني:</td>
                <td align="<?=$align?>"><?=$row["id_number"]?></td>
            </tr>
        <?
        }
        if($row["type"] > 0){
            ?>
            <tr>
                <td class="label">نوع الشكوى : </td>
                <td align="<?=$align?>">
                    <?
                    if($row["type"] == 1){
                        echo "فنية";
                    }else{
                            echo "ادارية";
                    }
                    ?>
                </td>
            </tr>
        <?
        }
        ?>
        <tr>
            <td class="label">تعليق الادارة  : </td>
            <td align="<?=$align?>">
                <form class="manager_comment">
                    <input type="hidden" class="comm" name="comm" value="<?=$row["id"]?>">
                    <textarea name="manager_comment_field"     class="w3-input w3-margin-bottom manager_comment_field" cols="40" rows="3"><?=$row["manager_comment"]?></textarea>
                    <input type="submit" class="w3-btn btn btn-default send" name="send" value="اضافة رد">
                </form>
                <script>
                    $(".manager_comment").submit(function(){
                        $(".manager_comment").slideUp();
                        $.post("add_comment.php",{"manager_comment":$(".manager_comment_field").val(),"comm":$(".comm").val()},function(response){
                            if(response == "success"){
                                alert("تم الرد على هذا التعليق بنجاح");
                                $('.manager_comment_field').attr('readonly', 'readonly');
                                $(".manager_comment").slideDown();
                            }


                        });
                        return false;
                    })
                </script>


            </td>
        </tr>



    </table>