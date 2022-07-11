<?
include "head.php";

if(isset($_GET['pass']) == "ok"){

print "<p align='center' style='text-align:center;padding-top:40px;color:green;font-weight:bold' class='text' dir='".$dir."'>".$label_change_password_successfully."<br>".$label_repeat_login_please."</p>";
}
?>
<p>&nbsp;</p>
<div style="text-align: center; margin-top: 100px">
<form action='login.php' method='POST' style="border: 10px solid #e2e2e2; width: 700px; margin:0 auto; padding: 20px">
    <table width='100%' align='center' dir="<?=$dir?>">
        <tr>
        <td>
<table width='340' align='center' dir="<?=$dir?>">
    <tr>
        <td  colspan="2" class='admin'><?=$label_enter_content_administration?><br><br></td>

    </tr>

    <tr>
<td class='formtext'><?=$label_user_name?>:</td>
<td><input type='text' name='name' class='form1'></td>
</tr>
<tr>
<td class='formtext'><?=$label_password?></td>
<td><input type='password' name='password' class='form1'></td>
</tr>
<tr>
<td></td>
<td><input type='submit' value='<?=$label_login?>' class='form1'></td>
</tr>
</table>
        </td>
        <td><img src="images/login.jpg" style="width: 100%"> </td>
</form>
</div>
<?
include "foot.php";
?>