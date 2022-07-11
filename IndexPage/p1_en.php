                            <tr>
                                <td  width="100%" colspan="2" valign="top" class="text2"><H5  class="label_2 w3-left-align w3-padding-32-all color_nahdi size_22 calibreb">To ask for question or comment, Please fill the form below:</H5></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <form method="POST"  name="f1" enctype="multipart/form-data"  action="mails/send_contact.php"  class="m_right"  dir="<?=$dir?>">
                                        <div class="width_100 ">
                                            <div class="contact-block width_75 margin_center">
                                                <form method="post" action="mails/send_contact.php">
                                                    <div class="w3-row">
                                                        <div class="w3-col l6  m6 s12 w3-padding w3-center wow fadeIn animated" data-wow-delay=".2s">
                                                            <input type="text" name="name" class="w3-form width_100" placeholder="Name" required/>
                                                        </div>
                                                        <div class="w3-col l6  m6 s12 w3-padding w3-center wow fadeIn animated" data-wow-delay=".4s">
                                                            <input type="text" name="phone" class="w3-form width_100" placeholder="Phone" required/>
                                                        </div>
                                                        <div class="w3-col l6  m6 s12 w3-padding w3-center wow fadeIn animated" data-wow-delay=".6s">
                                                            <input type="email" name="email" class="w3-form width_100" placeholder="E-mail" required/>
                                                        </div>
                                                        <div class="w3-col l6  m6 s12 w3-padding w3-center wow fadeIn animated" data-wow-delay=".8s">
                                                            <input type="text" name="address" class="w3-form width_100" placeholder="Address"/>
                                                        </div>
                                                        <div class="w3-col l12  m12 s12 w3-padding w3-center wow fadeIn animated" data-wow-delay="1s">
                                                            <textarea name="comment" class="w3-form width_100" placeholder="Message"></textarea>
                                                        </div>
                                                        <div class="w3-col l12  m12 s12 w3-padding w3-center wow fadeIn animated" data-wow-delay=".8s">
                                                            <img src="captcha/captcha.php" id="captcha" /><br/>
                                                            <!-- CHANGE TEXT LINK -->
                                                            <a  class="label_2 tahoma w3-small w3-padding" style="cursor:pointer" onclick="
                                        document.getElementById('captcha').src='captcha/captcha.php?'+Math.random();
                                        document.getElementById('captcha-form').focus();"
                                                                id="change-image">Not readable? Change text.</a><br/>
                                                            <input type="text" name="captcha" id="captcha-form" class="w3-input form" required  autocomplete="off" /><br/>
                                                        </div>
                                                        <div class="w3-col l12  m12 s12 w3-padding w3-center wow fadeIn " data-wow-delay=".8s">
                                                            <input type="submit" name="submit" class="btn w3-btn  background_nahdi " style="padding: 10px 60px" value="Send Data"/>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
