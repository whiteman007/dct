<tr>
    <td  width="100%" colspan="2" valign="top" class="text2 text-right"><H5  class="label_2 text-right" style="direction: <?=$dir?>"><?=$label_to_ask?>:</H5></td>
</tr>
<tr>
    <td colspan="2">
        <form method="POST"  name="f1" enctype="multipart/form-data"  action="mails/send_contact.php"  class="m_right"  dir="<?=$dir?>">
            <div class="width_100 ">
                <div class="contact-block width_75 margin_center">
                    <form method="post" action="mails/send_contact.php">
                        <div class="w3-row">
                            <div class="w3-col l6  m6 s12 w3-padding w3-center wow fadeIn animated" data-wow-delay=".2s">
                                <input type="text" name="name" class="w3-form width_100" placeholder="<?php echo $label_g_name;?>" required/>
                            </div>
                            <div class="w3-col l6  m6 s12 w3-padding w3-center wow fadeIn animated" data-wow-delay=".4s">
                                <input type="text" name="phone" class="w3-form width_100" placeholder="<?php echo $label_phone;?>" required/>
                            </div>
                            <div class="w3-col l6  m6 s12 w3-padding w3-center wow fadeIn animated" data-wow-delay=".6s">
                                <input type="email" name="email" class="w3-form width_100" placeholder="<?php echo $label_email;?>" required/>
                            </div>
                            <div class="w3-col l6  m6 s12 w3-padding w3-center wow fadeIn animated" data-wow-delay=".8s">
                                <input type="text" name="address" class="w3-form width_100" placeholder="<?php echo $label_address;?>"/>
                            </div>
                            <div class="w3-col l12  m12 s12 w3-padding w3-center wow fadeIn animated" data-wow-delay="1s">
                                <textarea name="comment" class="w3-form width_100" placeholder="<?php echo $label_message;?>"></textarea>
                            </div>
                            <div class="w3-col l6  m6 s12 w3-padding w3-center wow fadeIn animated" data-wow-delay=".8s">
                                <img src="captcha/captcha.php" id="captcha" /><br/><br/>
                                <!-- CHANGE TEXT LINK -->
                                <a  class="w3-text-grey" style="cursor:pointer" onclick="
                                        document.getElementById('captcha').src='captcha/captcha.php?'+Math.random();
                                        document.getElementById('captcha-form').focus();"
                                    id="change-image"><?php echo $label_change_text;?>.</a><br/>
                                <input type="text" name="captcha" id="captcha-form" class="w3-form width_100"  required  autocomplete="off" /><br/>
                            </div>
                            <div class="w3-col l12  m12 s12 w3-padding w3-center wow fadeIn animated" data-wow-delay=".8s">
                                <input type="submit" name="submit" class="btn background_black background_hover_brown" value="<?php echo $label_send;?>"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </form>
    </td>
</tr>
