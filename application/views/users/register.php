<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/register.css'); ?>">


<div class="container col-md-6 pt-5 pb-5">
	<form action="<?php echo base_url('register'); ?>" method="post">
		<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		<div class="form-group">
			<label><span class="text-danger">* </span>Username</label>
			<input type="text" name="full_name" class="form-control full_name" autofocus placeholder="Pick a Username"  value="<?php echo set_value('full_name'); ?>">
		</div>
		<div class="form-group">
			<label>E-mail</label>
			<input type="email" name="email" class="form-control email" placeholder="Your E-mail" value="<?php echo set_value('email'); ?>">
		</div>
		<div class="form-group">
			<label><span class="text-danger">* </span>Mobile Number</label>
			<input type="number" name="mobile" class="form-control mobile" placeholder="Your Mobile" value="<?php echo set_value('mobile'); ?>">
			<div class="text-danger font-weight-bolder mobileerr" style="display: none;">Invalid mobile length</div>
		</div>

		<div class="form-group row">
			<div class="col-md-6">
				<label>Employee ID</label>
				<input type="text" name="eid" class="form-control eid" placeholder="Your Employee ID" value="<?php echo set_value('eid'); ?>">
			</div>
			<div class="col-md-6">
				<label>Department</label>
				<input type="text" name="dept" class="form-control dept" value="Staff" readonly>
			</div>
		</div>

		<div class="form-group">
			<label><span class="text-danger">* </span>Password</label>
			<div class="input-group">
				<input type="text" class="form-control pass" name="pass" placeholder="Password">
				<div class="input-group-prepend genpwdbtn_i">
					<div class="input-group-text"><i class="fas fa-sync-alt"></i></div>
				</div>
			</div>
			<div class="text-danger font-weight-bolder passerr" style="display: none;"></div>
		</div>

		<div class="btngrp">
			<button class="btn btn-block text-light registerbtn" type="submit" style="background-color: #294a63;">Register</button>

			<a href="<?php echo base_url('login'); ?>" class="loginbtn text-dangevr">
				Already a user? <i class="far fa-arrow-alt-circle-right"></i></a>
		</div>
	</form>
</div>



<script>
	$(document).ready(function() {
		$(".genpwdbtn_i").click(function() {
			var length = 10;
			var charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			var val = "";

			for (var i = 0, n = charset.length; i < length; ++i) {
				val += charset.charAt(Math.floor(Math.random() * n));
			}

			$('.pass').val(val);
		});

		$('button.registerbtn').click(function() {
			// e.preventDefault();
			var full_name = $('.full_name').val();
			var mobile = $('.mobile').val();
			var pass = $('.pass').val();

			if (full_name == "" || full_name == null) {
				$('.full_name').css('border', '1px solid red');
				return false;
			} else {
				$('.full_name').css('border', '1px solid #ced4da');
			}
			if (mobile == "" || mobile == null) {
				$('.mobile').css('border', '1px solid red');
				return false;
			}if (mobile.length < 10 || mobile.length > 10) {
				$('.mobileerr').show();
				return false;
			} else {
				$('.mobile').css('border', '1px solid #ced4da');
				$('.mobileerr').hide();
			}
			if (pass == "" || pass == null) {
				$('.passerr').text("Enter a Password").show();
				return false;
			}if (pass.length < 6) {
				$('.passerr').text("Password should be over 6characters").show();
				return false;
			}  else {
				$('.pass').css('border', '1px solid #ced4da');
				$('.passerr').hide();
			}
			$.ajax({
				success: function() {
					$('.registerbtn').attr('disabled', 'disabled');
					$('.registerbtn').html('Processing...');
					$('.registerbtn').css('cursor', 'not-allowed');
				}
			});
		});
	});
</script>