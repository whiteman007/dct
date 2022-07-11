<script type="text/javascript">
$(document).ready(function(){
	$(".md").corner("10px");
	$("#SignIn").submit(function(){
		if(SignIn.email.value == ""){
			alert("<?=$all_field?>");
			document.SignIn.email.focus();
			return false;
		}
		if(document.SignIn.email.value != ''){
			if(!validateEmail(document.SignIn.email.value)){
				alert("<?=$all_field?>");
				document.SignIn.email.focus();
				return false;
			}
		}
	})
})
</script>
<?
if(main != "true"){
die("Access Denied");
}
?>
<div align="center">
    <div class="md" style="background:#ffffff; padding:5px 5px 5px 5px; width:98%" align="center">
    <div class="md" style="background:#44aadf; padding:5px 5px 5px 5px; width:95%">
                            <form name="SignIn" id="SignIn" enctype="application/x-www-form-urlencoded" method="post" action="mailingList/IndexPage/add_register.php" style="display:block">
                            <div align="center" style="font-size:15px; font-weight:bold; padding-bottom:5px"><i><?=$label_join_us?></i></div>
                            <div style="padding:2px" align="center" class="label_2"><?=$label_email?></div>
                            <div align="center"><input style="direction:ltr; text-align: left; width: 200px" type="email" name="email" size="20" class="form" required></div>
                            <div style="padding:2px 0px 0px 0px" align="center" class="add">                       
                            <div align="center" style="padding:2px 0px 4px 0px"><input type="submit" dir="rtl" value="<?=$label_join?>" style=" direction:<?=$dir?>" size="20" class="form"></div></div>
                            </form>                                         
    </div>
    </div>
</div>
<?
////////تعليق
?>

