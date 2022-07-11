<?
include "cookie.php";
include "head.php";
include "navigation.php";
?>
<form action='changepass.php'  method='POST' dir=<?=$dir?>>
<table width='300' align='center'>
<tr>
<td class='formtext'><?=$label_user_name?>  :</td>
<td  dir="ltr"><input type='text' name='admin_name' value="<?=$r_c_admin[t_username]?>"  class='form1'></td>
</tr>
<tr>
<td class='formtext'><?=$label_old_password?>:</td>
<td dir="ltr"><input type='text' name='admin_pass'   class='form1'></td>
</tr>
<tr>
<td class='formtext'><?=$label_new_password?>:</td>
<td  dir="ltr"><input type='text' name='pass1' class='form1'></td>
</tr>
<tr>
<td class='formtext'><?=$label_confirm_password?>:</td>
<td  dir="ltr"><input type='text' name='pass2' class='form1'></td>
</tr>
<tr>
<td></td>
<td dir="ltr"><input type='submit' value='<?=$label_change?>' class='form1'></td>
</tr>
</table>
</form>
<?
include "foot.php";
?>