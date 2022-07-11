<div>
    <div class="w3-row width_75 margin_center ">
        <div class="col-md-9 column margintop40">
            <ul class="menu-right nav nav-pills nav-stacked  w3-right-align w3-padding-bottom">
                <li  class="w3-black w3-hover-black"><a class="w3-text-white" >
                        <?php echo $param?>
                    </a></li>
            </ul>
            <div class="container width_100">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="">
                            <div class="panel-body">
                                <form role="form"  method="POST" name="fadvertise" enctype="multipart/form-data"  action="mails/send_advertise.php"  class="fadvertise w3-container"  dir="<?=$dir?>">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input type="text" required name="phone" id="phone" class="form-control input-sm" placeholder="هاتف">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input type="text" required name="name" id="name" class="form-control input-sm" placeholder="الاسم">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <input type="email" name="email" required id="email" class="form-control input-sm" placeholder="البريد الالكتروني">
                                    </div>

                                    <div class="form-group">

                                        <div class="row">
                                            <div class="col-xs-12 col-md-12 col-sm-12">
                                                <!-- image-preview-filename input [CUT FROM HERE]-->
                                                <div class="input-group image-preview ltr">
                                                    <input type="text" class="form-control image-preview-filename" disabled="disabled"> <!-- don't give a name === doesn't send on POST/GET -->
													<span class="input-group-btn">
														<!-- image-preview-clear button -->
														<button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                                                            <span class="glyphicon glyphicon-remove"></span> Clear
                                                        </button>
														<!-- image-preview-input -->
														<div class="btn btn-default image-preview-input">
                                                            <span class="glyphicon glyphicon-folder-open"></span>
                                                            <span class="image-preview-input-title">Browse</span>
                                                            <input type="file"  name="input-file-preview"/> <!-- rename it -->
                                                        </div>
													</span>
                                                </div><!-- /input-group image-preview [TO HERE]-->
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group g-recaptcha">
                                        <img src="captcha/captcha.php" id="captcha" /><br/>
                                        <!-- CHANGE TEXT LINK -->
                                        <a  class="link_1" style="cursor: pointer" onclick="
                                    document.getElementById('captcha').src='captcha/captcha.php?'+Math.random();
                                    document.getElementById('captcha-form').focus();"
                                            id="change-image"><?php print $label_change_text;?> .</a><br/>
                                        <input type="text" name="captcha" id="captcha-form"  required  autocomplete="off" class="form-control input-sm" /><br/>
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="ارسال" class="btn w3-black w3-hover-red   margin_center btn-block" style="width: 100px !important;">
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>




        <div class="section-right col-md-3 column margintop40 rtl">
            <?
            include_once "menu.php";
            ?>
        </div>
    </div>
</div>
<script>
    //close form


    $(function() {
        $(document).on('click', '#close-preview', function(){
            $('.image-preview').popover('hide');
            // Hover befor close the preview
            $('.image-preview').hover(
                function () {
                    $('.image-preview').popover('show');
                },
                function () {
                    $('.image-preview').popover('hide');
                }
            );
        });
        // Create the close button
        var closebtn = $('<button/>', {
            type:"button",
            text: 'x',
            id: 'close-preview',
            style: 'font-size: initial;',
        });
        closebtn.attr("class","close pull-right");
        // Set the popover default content
        $('.image-preview').popover({
            trigger:'manual',
            html:true,
            title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
            content: "There's no image",
            placement:'bottom'
        });
        // Clear event
        $('.image-preview-clear').click(function(){
            $('.image-preview').attr("data-content","").popover('hide');
            $('.image-preview-filename').val("");
            $('.image-preview-clear').hide();
            $('.image-preview-input input:file').val("");
            $(".image-preview-input-title").text("Browse");
        });
        // Create the preview image
        $(".image-preview-input input:file").change(function (){
            var img = $('<img/>', {
                id: 'dynamic',
                width:250,
                height:200
            });
            var file = this.files[0];
            var reader = new FileReader();
            // Set preview image into the popover data-content
            reader.onload = function (e) {
                $(".image-preview-input-title").text("Change");
                $(".image-preview-clear").show();
                $(".image-preview-filename").val(file.name);
                img.attr('src', e.target.result);
                $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
            }
            reader.readAsDataURL(file);
        });


    });
</script>