<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/rate.css'); ?>">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://kit.fontawesome.com/ca92620e44.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="icon" href="<?php echo base_url('assets/images/logo_dark.png') ?>">
<div class="container">
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token">
	<input type="hidden" class="form_key" name="form_key" value="<?php echo $form_key ?>">

	<div>
		<label class="text-info">What would you like us to improve</label>
	</div>
	<div>
		<div class="form-group">
			<label>Name</label>
			<input type="text" class="name form-control" name="name" placeholder="Your Name" value="<?php echo set_value('name') ?>">
		</div>
		<div class="form-group">
			<label>Mobile</label>
			<input type="number" class="mobile form-control" name="mobile" placeholder="Phone number" style="outline: none;" value="<?php echo set_value('mobile') ?>">
			<span class="err e_mobile text-danger font-weight-bolder">Invalid mobile length</span>
		</div>
		<div class="form-group">
			<label>Message</label>
			<textarea class="msg form-control" name="msg" placeholder="Your suggestions..." rows="2" style="outline: none;" value="<?php echo set_value('msg') ?>"></textarea>
		</div>
		<div class="text-right">
			<button class="btn btn-success submitmodalbtn" name="submitmodalbtn" type="submit">Submit</button>
		</div>
	</div>

</div>




<style type="text/css">
	.form-control:focus {
		border-color: black;
		box-shadow: none;
	}
</style>
<script type="text/javascript">
	$(document).ready(function() {
		$(document).on('click', '.submitmodalbtn', function() {
			var starv = "";
			var msg = $('.msg').val();
			var mobile = $('.mobile').val();
			var name = $('.name').val();
			var tbl_name = 'mainweb_rating';
			var form_key = $('.form_key').val();
			var csrfName = $('.csrf_token').attr('name');
			var csrfHash = $('.csrf_token').val();

			if (name == "" || name == null) {
				$('.name').css('border', '2px solid red');
				return false;
			} else {
				$('.name').css('border', '2px solid green');
			}
			if (mobile == "" || mobile == null) {
				$('.mobile').css('border', '2px solid red');
				return false;
			}
			if (mobile.length < 10 || mobile.length > 10) {
				$('.mobile').css('border', '2px solid red');
				$('.e_mobile').show();
				return false;
			} else {
				$('.e_mobile').hide();
				$('.mobile').css('border', '2px solid green');
			}

			$.ajax({
				url: "<?php echo base_url('user/rating_store_review'); ?>",
				method: "post",
				data: {
					starv: starv,
					msg: msg,
					name: name,
					mobile: mobile,
					[csrfName]: csrfHash,
					tbl_name: tbl_name,
					form_key: form_key,
				},
				beforeSend: function() {
					$('.submitmodalbtn').removeClass("btn-info").addClass("btn-danger");
					$('.submitmodalbtn').html("Submitting...");
					$('.submitmodalbtn').attr("disabled", "disabled");
					$('.submitmodalbtn').css("cursor", "not-allowed");
				},
				success: function(data) {
					$('.submitmodalbtn,.submitbtn').html("Submitted");
					$('.submitmodalbtn').removeClass("btn-danger").addClass("btn-success");
					$('.submitmodalbtn,.submitbtn').attr("disabled", "disabled");
					$('.submitmodalbtn,.submitbtn').css("cursor", "not-allowed");

					window.location.assign("https://ss-cf.sbmurban.org/#/feedback");
				}
			});
		});
	});
</script>