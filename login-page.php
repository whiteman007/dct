<script>
	function requiredCheck (f){
		var flag = false;
		$(f).find("input[required]").each(function(index){
			if($(this).val() == ""){
				$(this).addClass("req");
				flag = true;
			}else{
				$(this).removeClass("req");
			}
		});
		if(flag == true)
			return false;
	}
</script>
<style>
	.etc-login-form {
		color: #919191;
		padding: 10px 20px;
	}
	.etc-login-form p {
		margin-bottom: 5px;
	}
	/*=== 4. Main Form ===*/
	.login-form-1 {
		max-width: 300px;
		border-radius: 5px;
		display: inline-block;
	}
	.main-login-form {
		position: relative;
	}
	.login-form-1 .form-control {
		border: 0;
		box-shadow: 0 0 0;
		border-radius: 0;
		background: transparent;
		color: #333;
		padding: 7px 0;
		font-weight: bold;
		height:auto;
		font-size: 16px;
	}
	.login-form-1 .form-control::-webkit-input-placeholder{
		color: #555;
	}
	.login-form-1 .form-control:-moz-placeholder,
	.login-form-1 .form-control::-moz-placeholder,
	.login-form-1 .form-control:-ms-input-placeholder {
		color: #555;
	}

	#register-form .req::-webkit-input-placeholder{
		color: #ff0000 !important;
	}
	#register-form .req:-moz-placeholder,
	#register-form .req::-moz-placeholder,
	#register-form .req:-ms-input-placeholder {
		color: #ff0000 !important;
	}

	.login-form-1 .form-group {
		margin-bottom: 0;
		border-bottom: 2px solid #efefef;
		padding-right: 20px;
		position: relative;
	}
	.login-form-1 .form-group:last-child {
		border-bottom: 0;
	}
	.login-group {
		background: #ffffff;
		color: #999999;
		border-radius: 8px;
		padding: 10px 20px;
	}
	/*=== 5. Login Button ===*/
	.login-form-1 .login-button {
		position: absolute;
		right: -25px;
		top: 50%;
		background: #ffffff;
		color: #999999;
		padding: 11px 0;
		width: 50px;
		height: 50px;
		margin-top: -25px;
		border: 5px solid #efefef;
		border-radius: 50%;
		transition: all ease-in-out 500ms;
	}
	.login-form-1 .login-button:hover {
		color: #555555;
		transform: rotate(450deg);
	}
	.login-form-1 .login-button.clicked {
		color: #555555;
	}
	.login-form-1 .login-button.clicked:hover {
		transform: none;
	}
	.login-form-1 .login-button.clicked.success {
		color: #2ecc71;
	}
	.login-form-1 .login-button.clicked.error {
		color: #e74c3c;
	}
	/*=== 6. Form Invalid ===*/
	.login-page label.form-invalid {
		position: absolute;
		top: 0;
		right: 0;
		z-index: 5;
		display: block;
		margin-top: -25px;
		padding: 7px 9px;
		background: #777777;
		color: #ffffff;
		border-radius: 5px;
		font-weight: bold;
		font-size: 11px;
	}
	.login-page label.form-invalid:after {
		top: 100%;
		right: 10px;
		border: solid transparent;
		content: " ";
		height: 0;
		width: 0;
		position: absolute;
		pointer-events: none;
		border-color: transparent;
		border-top-color: #777777;
		border-width: 6px;
	}
	/*=== 7. Form - Main Message ===*/
	.login-form-main-message {
		background: #ffffff;
		color: #999999;
		border-left: 3px solid transparent;
		border-radius: 3px;
		margin-bottom: 8px;
		font-weight: bold;
		height: 0;
		padding: 0 20px 0 17px;
		opacity: 0;
		transition: all ease-in-out 200ms;
	}
	.login-form-main-message.show {
		height: auto;
		opacity: 1;
		padding: 10px 20px 10px 17px;
	}
	.login-form-main-message.success {
		border-left-color: #2ecc71;
	}
	.login-form-main-message.error {
		border-left-color: #e74c3c;
	}

	/* hover style just for information */
	.login-page label:hover:before {
		border: 1px solid #f6f6f6 !important;
	}
	/*=== Customization ===*/
	/* radio aspect */

	.login-page [type="radio"]:not(:checked) + label:before,
	.login-page [type="radio"]:checked + label:before {
		border-radius: 35px;
	}

	.login-page [type="radio"]:not(:checked) + label:after,
	.login-page [type="radio"]:checked + label:after {
		content: '\2022';
		top: 0;
		left: 3px;
		font-size: 30px;
		line-height: 25px;
	}
	/*=== 9. Misc ===*/
	.login-page .logo {
		padding: 15px 0;
		font-size: 25px;
		color: #BB0000;
		font-weight: bold;
		text-transform: capitalize;
	}
	.login-page a{
		color: #BB0000;
	}
</style>
<?php
?>
<div class="login-page">
		<div id="login-section" class="text-center" style="padding:50px 0">
			<div class="logo">
				تسجيل دخول
			</div>
			<!-- Main Form -->
			<div class="login-form-1">
				<form id="login-form" class="text-left" method="post" action="login_member.php">
					<div class="login-form-main-message"></div>
					<div class="main-login-form">
						<div class="login-group">
							<div class="form-group">
								<label for="lg_username" class="sr-only">Email</label>
								<input type="email" autocomplete="off" required class="form-control tahoma" id="lg_username" name="email" placeholder="Email">
							</div>
							<div class="form-group">
								<label for="lg_password" class="sr-only">Password</label>
								<input type="password" autocomplete="off" required class="form-control" id="lg_password" name="pass" placeholder="Password">
							</div>
						</div>
						<input type="hidden" name="last" value="<?=$_SERVER["HTTP_REFERER"]?>">
						<input type="hidden" name="reg" value="login-123-876">
						<button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
					</div>
					<div class="etc-login-form text-right">
						<p class="<?=$dir?>">
							نسيت كلمة السر؟
							<a href="javascript:void(0)"  onclick="$('#register-section').hide();$('#login-section').hide();$('#forgot-section').show()">
								انقر هنا
							</a></p>

					</div>
				</form>
			</div>
			<!-- end:Main Form -->
		</div>

		<!-- REGISTRATION FORM -->
		

		<!-- FORGOT PASSWORD FORM -->
		<div class="text-center collapse" style="padding:50px 0" id="forgot-section">
			<div class="logo <?=$dir?>">
				نسيت كلمة السر
			</div>
			<!-- Main Form -->
			<div class="login-form-1">
				<form id="forgot-password-form" class="text-left" method="post" action="mails/SendPassword.php">
					<div class="etc-login-form text-right">
						<p class="<?=$dir?>">
							عندما تدخل بريدك الالكتروني, ستصلك البيانات كيف تعيد انشاء كلمة سر جديدة.
						</p>
					</div>
					<div class="login-form-main-message"></div>
					<div class="main-login-form">
						<div class="login-group">
							<div class="form-group">
								<label for="fp_email" class="sr-only">Email address</label>
								<input type="text" class="form-control  tahoma" id="fp_email" name="email" placeholder="Email">
								<input type="hidden" name="reg" value="forgot-123-876">
							</div>
						</div>
						<button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
					</div>
					<div class="etc-login-form  text-right">
						<p class="<?=$dir?>">
							هل لديك حساب؟
							<a href="javascript:void(0)"  onclick="$('#register-section').hide();$('#forgot-section').hide();$('#login-section').show()">
								تسجيل دخول
							</a></p>
						<p class="<?=$dir?>">
							انت عضو جديد؟
							<a href="javascript:void(0)"  onclick="$('#forgot-section').hide();$('#login-section').hide();$('#register-section').show()">
								انشاء حساب جديد
							</a></p>
					</div>
				</form>
			</div>
		</div>
</div>
