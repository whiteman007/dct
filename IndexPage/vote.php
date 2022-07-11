<?
$rand = time();
if($_POST["pro_id"] !=""){
    include_once "../../logs/function_2.php";
    $pro_id = $_POST["pro_id"];
    $pro_name = $_POST["pro_name"];
}elseif($_GET["pro_id"] !=""){
    include_once "../../logs/function_2.php";
    $pro_id = $_GET["pro_id"];
    $pro_name = $_GET["pro_name"];
}elseif($pid !=""){
    $pro_id = $pid;
    $pro_name = $param;
}else{
    $pro_id = intval($pid);
    $pro_name = $param;
}

if($_COOKIE["vote_".$pro_id] !="ok" ){
    ?>

    <div id="voting">
        <div class="form-comment w3-padding-32-all w3-right-align <?php if ($table =='pages'){ echo 'w3-hide'; }?>" style="background-color: #fff">
            <form  id="form_vote" class="form_1 rtl" name="form_vote" method="post" enctype="multipart/form-data">
                <input type="hidden" id="rand" name="rand" value="<?=$rand?>">
                <input type="hidden" id="f" name="f" value="">
                <input type="hidden" name="pro_id" value="<?=$pro_id?>">
                <input type="hidden" name="pro_name" value="<?=$pro_name?>">
                <div class="w3-margin-bottom w3-text-black w3-large">
                    <?php
                    if($pid == 736){
                        echo "يمكنك ارسال شكوى من خلال تعبئة النموذج التالي:";
                    }elseif($pid == 2){
                        echo "يمكنك التعليق أو التواصل معنا من خلال النموذج التالي";
                    }else{
                        echo "يمكنك التعليق من خلال تعبئة النموذج التالي:";
                    }
                    ?>
                </div>
                <div class="w3-margin-bottom">
                    <label for="name">
                        الاسم
                    </label>
                    <input id="name" type="text"  name="reviewerName" required>

                </div>
                <div class="w3-margin-bottom">
                    <label for="email">
                        البريد الالكتروني
                    </label>
                    <input id="email" class="tahoma" type="email"  name="reviewerEmail" required>

                </div>
                <div class="w3-margin-bottom">
                    <label for="website">
                        الجوال
                    </label>
                    <input id="website" class="tahoma" type="text"  name="reviewerLocation" >

                </div>
                <?
                if($pid == 736){
                    ?>
                    <div class="w3-margin-bottom">
                        <label for="website">
الرقم الوطني
                        </label>
                        <input id="website" class="tahoma ltr" type="text"  name="id_number" >

                    </div>
                    <div class="w3-margin-bottom">
                        <label for="website">
                        نوع الشكوى
                        </label>
                        <select name="type">
                            <option value="0">اختر</option>
                            <option value="1">شكوى فنية</option>
                            <option value="2">شكوى ادارية</option>
                        </select>

                    </div>
                    <div class="w3-margin-bottom">
                        <label for="website">
                            ملف الشكوى
                        </label>
                        <div id="fileuploader">
                            upload
                        </div>
                    </div>
                    <?
                }
                ?>

                <div class="w3-margin-bottom">
                    <label for="note">
المحتوى
                    </label>
                    <textarea rows="3"  required name="note"></textarea>
                </div>
                <div class="w3-margin-bottom">
                    <div class="w3-row">
                        <div class="w3-show-inline-block"><img src="captcha/captcha.php" id="captcha" height="43px" /></div>
                        <div class="w3-show-inline-block"><input type="text" name="captcha" id="captcha-form" required  autocomplete="off" style="height: 42px;position: relative;top: 3px;" /></div>
                        <div class="w3-show-inline-block"><a  class="label_2" style="cursor: pointer" onclick="
                                    document.getElementById('captcha').src='captcha/captcha.php?'+Math.random();
                                    document.getElementById('captcha-form').focus();"
                                                              id="change-image">تغيير النص.</a></div>

                    </div>

                </div>
                <div class="w3-margin-bottom">
                    <input  type="submit" id="reviewFormSubmit" value="ارسل" class="action w3-btn w3-dark-grey w3-hover-text-red w3-padding-32-h"  name="send">
                </div>
                <div class="w3-center w3-margin-bottom relative">
                    <span class="spinner"></span>
                </div>
            </form>
        </div>
    </div>
<?
}///////////////////////end if vote


?>
<script type="text/javascript"  src="plugins/upload-file/js/jquery.uploadfile.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var uploadObj = $("#fileuploader").uploadFile({
            url:"upload.php?rand=<?=$rand?>",
            multiple:false,
            fileName:"file",
            maxFileSize:102400,
            allowedTypes:"jpg,png,gif,doc,pdf,zip",
            returnType:"json",
            autoSubmit:false,
            onSelect: function (files) {
                $("#f").val("");
                if(files[0].size <= 102400){
                    $("#f").val(files[0].name);
                }
            }
        });

        $("#form_vote").submit(function(){

            scrollTo2(".div-block");
            ///////////////////////////////////////
            var vote_form_data = $(this).serialize();
            $("#voting").html("<div align='center' style='padding: 20px'><img style='width:100px' src='images/filters-load.gif'> </div>");
            uploadObj.startUpload();
            $.post("vote/IndexPage/requests.php",vote_form_data,function(data){
                if(data == "success"){
                    $("#voting").load("vote/IndexPage/vote.php",{"pro_id":"<?=$pid?>","pro_name":"<?=$param?>"},function(){
                        alert("شكراً لتعليقك, سيتم نشره بعد موافقة ادارة الموقع")
                    });
                }else if(data == "errorCaptcha"){
                    $("#voting").load("vote/IndexPage/vote.php",function(){
                        alert("خطأ في كود التحقق")
                    });
                }else{
                    $("#voting").load("vote/IndexPage/vote.php",function(){
                        alert("الرجاء التأكد من البيانات المدخلة.")
                    });
                }
            });
            return false;
        });
    })
</script>
