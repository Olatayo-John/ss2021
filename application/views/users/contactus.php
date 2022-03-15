<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/contact.css'); ?>">

<div class="mr-3 ml-3 pt-5 pb-3">
	<!-- <h4 class="text-center text-dark font-weight-bolder mb-3 mt-3">CONTACT US</h4> -->
	<div class="row rowofwhole">
		<div class="col-md-5">
			<form action="<?php echo base_url('support'); ?>" method="post">
				<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
				<div class="form-group">
					<label>Name</label>
					<input type="text" name="name" class="form-control name" placeholder="Your Name">
				</div>
				<div class="form-group">
					<label>E-mail</label>
					<input type="email" name="email" class="form-control email" placeholder="example@domain.com">
				</div>
				<div class="form-group">
					<label>Message</label>
					<textarea name="msg" class="form-control msg" rows="6" placeholder="Drop your message here"></textarea>
				</div>
				<!-- <div class="g-recaptcha form-group" data-sitekey="6LdT_UIaAAAAANYXRPUzs1SwrYxLE0alc5uiqdN2"></div> -->
				<div class="subbtngrp text-center">
					<button class="btn btn-block text-light regbtn" style="background-color: #294a63;">Submit</button>
				</div>
			</form>
		</div>
		<div class="col-md-7 nktechdetails">
			<div class="imagediv text-center mb-4">
				<img src="<?php echo base_url('assets/images/logo_dark.png') ?>" class="">
			</div>
			<div class="detailsdiv row">
				<i class="fas fa-map-marker mr-2"></i>
				<span>307, 3rd Floor,I Thum Tower-A,Sector-62, Noida-201301</span>
			</div>
			<div class="row">
				<i class="fas fa-phone-alt mr-2"></i>
				<span>+91-1204561602/+91-8920877101/+91-9711066609</span>
			</div>
			<div class="row">
				<i class="fas fa-at mr-2"></i>
				<span>info@nktech.in</span>
			</div>
			<hr>
			<div class="row mt-3">
				<div class="col-md-8 p-0">
					NkTech © 2012-2020<br> All rights reserved.<br>Terms of Use and Privacy Policy
				</div>
				<div class="col-md-4 p-0">
					<div class="icons d-flex justify-content-left">
						<a href="https://www.facebook.com/NKTechPvtLtd"><i class="fab fa-facebook"></i></a>
						<a href="https://twitter.com/NktechInfo"><i class="fab fa-twitter"></i></a>
						<a href="https://www.linkedin.com/company/nktech/"><i class="fab fa-linkedin"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
	$(document).ready(function() {
		$('button.regbtn').click(function(e) {
			// e.preventDefault();
			var name = $('.name').val();
			var user_mail = $('.email').val();
			var msg = $('.msg').val();

			if (user_mail == "" || user_mail == null) {
				$('.email').css('border', '1px solid red');
				return false;
			} else {
				$('.email').css('border', '1px solid #ced4da');
			}
			if (msg == "" || msg == null) {
				$('.msg').css('border', '1px solid red');
				return false;
			} else {
				$('.msg').css('border', '1px solid #ced4da');
			}

			$.ajax({
				beforeSend: function(data) {
					$('button.regbtn').html('Submitting...');
					$('button.regbtn').css('cursor', 'not-allowed');
				}
			});
		});
	});
</script>