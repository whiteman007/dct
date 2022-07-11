                            <tr>
                                <td  width="100%" colspan="2" valign="top" class="text2"><H5  class="label_2">To ask for question or comment, Please fill the form below:</H5></td>
                            </tr>
                            <tr>
                                <td  class="label">Name: <span class="star">*</span></td>
                                <td align="<?=$align?>"><input type="text" name="name"  style="direction:<?=$dir?>" size="25" class="w3-input form" required></td>
                            </tr>
                            <tr>
                                <td class="label">Email: <span class="star">*</span></td>
                                <td align="<?=$align?>"><input type="email" name="email" required style="direction:<?=$dir?>" size="25" class="w3-input form"></td>
                            </tr>
                            <tr>
                                <td class="label">Phone Number: </td>
                                <td align="<?=$align?>"><input type="text" name="phone" style="direction:<?=$dir?>" size="25" class="w3-input form"></td>
                            </tr>

                            <tr>
                                <td class="label">Address:</td>
                                <td align="<?=$align?>"><input type="text" name="address" style="direction:<?=$dir?>" size="25" class="w3-input form"></td>
                            </tr>

                            <tr>
                                <td class="label">Your Comment:</td>
                                <td align="<?=$align?>">
                                <textarea name="comment" cols="20" style="width: 100%" rows="3" class="w3-input form"></textarea>
                                <input type="hidden" name="lang" value="en" />
                                </td>
                            </tr>

                            <!--<tr>
                                <td class="label" style="vertical-align:middle">Confirmation Code</td>
                                <td align="<?=$align?>">
                                    <img src="captcha/captcha.php" id="captcha" /><br/>

                                    <a  class="label_2" style="cursor:pointer" onclick="
                                    document.getElementById('captcha').src='captcha/captcha.php?'+Math.random();
                                    document.getElementById('captcha-form').focus();"
                                    id="change-image">Not readable? Change text.</a><br/>
                                    <input type="text" name="captcha" id="captcha-form" class="w3-input form" required  autocomplete="off" /><br/>

                                </td>
           					 </tr>-->

                            <tr>
                                <td class="label" style="vertical-align:middle">2+3=</td>
                                <td align="<?=$align?>">
                                    <input type="text" name="captcha" id="captcha-form" class="w3-input form" required  autocomplete="off" />
                                </td>
                            </tr>