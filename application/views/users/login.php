<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login.css'); ?>">


<div class="row m-0 p-0" style="height: 100vh;">
	<div class="empty col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<img src="<?php echo base_url('assets/images/SwachhSide.png'); ?>" class="responsive">
	</div>

	<div class="login col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<form action="<?php echo base_url('login'); ?>" method="post">
			<!-- <h4 class="text-center text-light">LOGIN</h4> -->
			<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<div class="form-group">
				<label>Username</label>
				<input type="text" name="uname" class="form-control uname" autofocus placeholder="Your Username">
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="password" name="pwd" class="form-control pwd" placeholder="Your Password">
			</div>
			<div class="btngrp">
				<button class="btn btn-blockc loginbtn text-light" type="submit" style="background: #294a63;">LogIn</button>

				<a href="<?php echo base_url('register'); ?>" class="signupbtn font-weight-bolder" style="margin:auto 0;color:#294a63">
					Create Account <i class="far fa-arrow-alt-circle-right"></i></a>
			</div>
		</form>
	</div>
</div>



<script>
	$(document).ready(function() {
		$('button.loginbtn').click(function() {
			var name = $('.uname').val();
			var pass = $('.pwd').val();

			if (name == "" || name == null) {
				$('.uname').css('border', '1px solid red');
				return false;
			} else {
				$('.uname').css('border', '1px solid #ced4da');
			}
			if (pass == "" || pass == null) {
				$('.pwd').css('border', '1px solid red');
				return false;
			} else {
				$('.pwd').css('border', '1px solid #ced4da');
			}
		});
	});
</script>