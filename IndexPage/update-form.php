<?php
if(main != "true"){
    die("Access Denied");
}
include "plugins/ckeditor/ckeditor.php";
?>
<style>
    #register-section label{
        text-align: right;
        margin-top: 13px;
        font-weight: bold;
        color: #333;
    }
</style>
<?
$qc = mysqli_query2("select * from page where  id = '".$ruser['company_id']."' and Active=1 order by the_order,id desc");
if(mysqli_affected_rows2() > 0){
    $rc = mysqli_fetch_array($qc);
?>
<div class="shell text-center section-50 section-sm-top-80 section-sm-bottom-90" style="padding-bottom: 10px !important;">
    <h1 style="padding-top: 36px" class="w3-text-red">صفحتي الشخصية</h1>
    <p class="h4 offset-top-5"><?=$rc["name".$ext]?></p>
    <!-- Responsive-tabs-->
</div>
<div class="text-center " style="padding:50px 0" id="register-section">
    <!-- Main Form -->
    <div class="container <?=$dir?>">
        <form  action="update" class="text-<?=$align?> form-horizontal" method="post" enctype="multipart/form-data">
            <div class="form-group  row w3-margin-0 w3-padding-8-h" style="margin-bottom: 16px !important;">
                <label class="col-md-12" style="padding-right: 0 !important;" for="reg_username">
                    بيانات الاتصال و العنوان
                </label>
                <textarea name="description" rows="10" class="form-control"><?=$rc["description"]?></textarea>

            </div>
            <div class="form-group row w3-margin-0 w3-padding-8-h" style="margin-bottom: 16px !important;">
                <label class="col-md-12" style="padding-right: 0 !important;" for="reg_username">
                    تفاصيل الشركة
                </label>
                <div style="clear: both">
                    <?
                    $CKEditor = new CKEditor();
                    $CKEditor->editor("text", $rc["text"]);
                    ?>
                </div>

            </div>
            <div class="form-group row w3-margin-0 w3-padding-8-h" style="margin-bottom: 16px !important;">
                <label class="col-md-12" style="padding-right: 0 !important;" for="reg_username">
                    تعديل لوغو الشركة
                </label>
                <input type="file" class="form-control"  name="src"   placeholder="أدخل لوغو الشركة">
                <div class="w3-padding-top">
                    <?
                    if($rc["src"]){
                        ?>
                        <a href="pages/photos/<?=$rc['src']?>" class="fancybox">
                            <img src="pages/photos/<?=$rc['src']?>" class="opacity" alt="logo" width="100px" />
                        </a>
                        <?
                    }
                    ?>
                </div>
            </div>
            <div class="form-group  row w3-margin-0 control-group"  style="margin-bottom: 16px !important;">
                <label class="col-md-12" style="padding-right: 0 !important;" for="reg_username">
                    تعديل صور الشركة
                    <span style="color: red">
                    (
                    صور بلاحقة jpg
                    )</span>
                </label>
                <div>
                    <div class="controls">
                        <div class="entry input-group">
                            <input class="form-control" name="src_3[]"  accept="image/*" type="file" placeholder="تحميل صورة" />
                              <span class="input-group-btn">
                                  <button class="btn btn-success btn-add" type="button" style="height: 34px">
                                      <span class="glyphicon glyphicon-plus"></span>
                                  </button>
                              </span>
                        </div>

                    </div>
                    <br>
                    <small style="color: red">
                        ملاحظة:
                        اضغط
                         <span class="glyphicon glyphicon-plus gs"></span>
                    لاضافة صورة جديدة
                    </small>
                </div>
            </div>
            <div  style="margin-bottom: 16px" class="well">
                <?
                if($rc["src_3"]){
                    $arr_photos =array_filter(explode("*",$rc["src_3"]));
                    ?>
                    <div class="row w3-margin-0">
                        <?
                        foreach ($arr_photos as $key=>$val) {
                            ?>
                            <div class="col-md-2 col-sm-3 col-xs-4" style="padding-top: 0!important;padding-bottom: 0!important;">
                                <a href="pages/photos/<?=rawurlencode($val)?>" class="fancybox" rel="group1">
                                    <div class="width-100 opacity" style="cursor:pointer;background: center center url('pages/photos/<?=rawurlencode($val)?>') no-repeat;background-size: cover !important; height: 75px;"></div>
                                </a>
                            </div>
                            <?
                        }
                        ?>
                    </div>
                    <?
                }
                ?>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label" for="submit"></label>
                <div class="col-md-4">
                    <input type="hidden" name="reg" value="update-123-876">
                    <input  name="oldpic" class="oldpic"  type=hidden value="<?=$rc['src']?>">
                    <input  name="oldpic_3" class="oldpic"  type=hidden value="<?=$rc['src_3']?>">
                    <button id="submit" name="submit" class="btn  w3-margin-bottom w3-margin-right btn-danger">تحديث البيانات</button>
                    <button  name="reset" type="button" onclick="location.href='update'" class="btn btn-default  w3-margin-bottom">
                        تراجع
                    </button>
                </div>
            </div>
        </form>
    </div>
    <!-- end:Main Form -->
</div>
    <script>
        $(function()
        {
            $(document).on('click', '.btn-add', function(e)
            {
                e.preventDefault();

                var controlForm = $('.controls'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);

                newEntry.find('input').val('');
                controlForm.find('.entry:not(:last) .btn-add')
                    .removeClass('btn-add').addClass('btn-remove')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="glyphicon glyphicon-minus"></span>');
            }).on('click', '.btn-remove', function(e)
            {
                $(this).parents('.entry:first').remove();

                e.preventDefault();
                return false;
            });
        });
    </script>
<?
}