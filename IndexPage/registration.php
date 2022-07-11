<style>


</style>
<form method="POST" name="f1" enctype="multipart/form-data"  action="pages/IndexPage/add_register.php"  class="m_right"  dir="<?=$dir?>" onsubmit="return en_contact()">
						<table border="0" width="100%" cellpadding="4" class="label">
                            <tr>
                                <td  width="100%" colspan="2" valign="top" class="text2" height="30"><H5 style="color:#999999; font-size:13px">To register for our news and updates, Please fill the form below:</H5></td>
                            </tr>
                            <tr>
                                <td class="label">Name: <span class="star">*</span></td>
                                <td align="<?=$align?>"><input type="text" name="name" style="direction:<?=$dir?>" size="25" class="form" required></td>
                            </tr>
                            <tr>
                                <td class="label">Email: <span class="star">*</span></td>
                                <td align="<?=$align?>"><input type="email" name="email" style="direction:<?=$dir?>" size="25" class="form" required></td>
                            </tr>
                            <tr>
                                <td class="label">Professional Title: </td>
                                <td align="<?=$align?>"><input type="text" name="title" style="direction:<?=$dir?>" size="25" class="form"></td>
                            </tr>
                            <tr>
                                <td class="label">Specialty: </td>
                                <td align="<?=$align?>"><input type="text" name="specialty" style="direction:<?=$dir?>" size="25" class="form"></td>
                            </tr>
                            <tr>
                                <td class="label">Organization:</td>
                                <td align="<?=$align?>"><input type="text" name="organization" style="direction:<?=$dir?>" size="25" class="form"></td>
                            </tr>

							<tr>
                                <td class="label">Country:</td>
                                <td align="<?=$align?>"><input type="text" name="country" class="form" size="25"></td>
                            </tr>   
							<tr>
                                <td class="label">City:</td>
                                <td align="<?=$align?>"><input type="text" name="city" class="form" size="25"></td>
                            </tr>   
                                <tr>
                                <td class="label" style="vertical-align:middle">Confirmation Code</td>
                                <td align="<?=$align?>">
                                    <img src="captcha/captcha.php" id="captcha" /><br/>
                                    <!-- CHANGE TEXT LINK -->
                                    <a  class="link_2" style="cursor:pointer" onclick="
                                    document.getElementById('captcha').src='captcha/captcha.php?'+Math.random();
                                    document.getElementById('captcha-form').focus();"
                                    id="change-image">Not readable? Change text.</a><br/>
                                    <input type="text" name="captcha" id="captcha-form" class="form" required  autocomplete="off" /><br/>
                
                                </td>
           					 </tr> 
                            <tr>
                                <td></td>
                                <td height="40" align="<?=$align?>">
                                    <input type="submit" name="Send" value="Send!"    class="btn btn-default"></td>
                            </tr>
						</table>
</form>
                                                     