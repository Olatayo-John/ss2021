<meta charset="utf-8">
<title>VOTE</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/swacch_rate.css'); ?>">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://kit.fontawesome.com/ca92620e44.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="icon" href="<?php echo base_url('assets/images/logo_dark.png') ?>">
<div class="container">

	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token">
	<input type="hidden" class="form_key" name="form_key form_key" value="<?php echo $form_key ?>">

	<!-- <input type="hidden" name="stateName" class="stateName form-control" value="UTTARAKHAND" id="5">
	<input type="hidden" name="districtName" class="districtName form-control" value="DEHRADUN" id="60">
	<input type="hidden" name="cityName" class="cityName form-control" value="DEHRADUN" id="800310">
	<input type="hidden" name="locationName" class="locationName form-control" value="DEHRADUN"> -->

	<!-- <input type="hidden" name="stateName" class="stateName form-control" value="UTTARAKHAND" id="5">
	<input type="hidden" name="districtName" class="districtName form-control" value="TEHRI" id="59">
	<input type="hidden" name="cityName" class="cityName form-control" value="MUNI-KI-RETI" id="800303">
	<input type="hidden" name="locationName" class="locationName form-control" value="MUNI-KI-RETI"> -->

	<input type="hidden" name="stateName" class="stateName form-control" value="UTTAR PRADESH" id="9">
	<input type="hidden" name="districtName" class="districtName form-control" value="GHAZIABAD" id="135">
	<input type="hidden" name="cityName" class="cityName form-control" value="GHAZIABAD (M. Corp)" id="800734">
	<input type="hidden" name="locationName" class="locationName form-control" value="GHAZIABAD">

	<!-- <input type="hidden" name="stateName" class="stateName form-control" value="UTTAR PRADESH" id="9">
	<input type="hidden" name="districtName" class="districtName form-control" value="BULANDSHAHR" id="138">
	<input type="hidden" name="cityName" class="cityName form-control" value="BULANDSHAHR (NPP)" id="800749">
	<input type="hidden" name="locationName" class="locationName form-control" value="BULANDSHAHR"> -->

	<!-- <input type="hidden" name="stateName" class="stateName form-control" value="UTTAR PRADESH" id="9">
	<input type="hidden" name="districtName" class="districtName form-control" value="SAMBHAL" id="130">
	<input type="hidden" name="cityName" class="cityName form-control" value="CHANDAUSI (NPP)" id="800689">
	<input type="hidden" name="locationName" class="locationName form-control" value="CHANDAUSI"> -->

	<div class="text-center">
		<label class="text-info font-weight-bold">SS2022 VOTE FOR YOUR CITY CITIZEN'S FEEDBACK</label>
	</div>
	<div>
		<div class="form-group">
			<label>Give Rating</label>
			<input type="number" class="starv form-control" name="starv" placeholder="1-10" min="1" max="10">
		</div>

		<div class="form-group">
			<label>Name</label>
			<div class="input-group">
				<div class="input-group-prepend genotp_i">
					<div class="input-group-text p-0">
						<select name="nameTitle" id="nameTitle" class="nameTitle form-control">
							<option value="Mr">Mr</option>
							<option value="Mrs">Mrs</option>
							<option value="Ms">Ms</option>
						</select>
					</div>
				</div>
				<input type="text" class="name form-control" name="name" placeholder="Your Name" value="">
			</div>
		</div>

		<div class="form-group">
			<label><span class="text-danger">* </span> Age</label>
			<input type="number" class="age form-control" name="age" placeholder="Your Age" value="22">
			<span class="err e_age text-danger"></span>
		</div>

		<div class="form-group">
			<label><span class="text-danger">* </span> Sex</label>
			<select name="sex" id="sex" class="sex form-control">
				<option value="M">Male</option>
				<option value="F">Female</option>
			</select>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<label><span class="text-danger">* </span> Mobile</label>
					<div class="input-group">
						<input type="number" class="mobile form-control" name="mobile" placeholder="Mobile number" value="">
						<div class="input-group-prepend genotp_i">
							<div class="input-group-text p-0">
								<button class="btn btn-info genotp_btn">Get OTP</button>
							</div>
						</div>
					</div>
					<span class="err e_mobile text-danger"></span>
					<span class="succ s_mobile text-success"></span>
				</div>
				<div class="col-md-6">
					<label><span class="text-danger">* </span> OTP</label>
					<input type="number" id="otp" class="otp form-control" name="otp" value="">
					<span class="err e_otp text-danger"></span>
					<span class="succ s_otp text-success"></span>
				</div>
			</div>
		</div>

		<hr>
		<div class="form-group text-right">
			<button class="btn btn-success submitformbtn" name="submitformbtn" type="submit">Submit</button>
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

		//gen otp
		$(document).on('click', '.genotp_btn', function() {
			var csrfName = $('.csrf_token').attr('name');
			var csrfHash = $('.csrf_token').val();
			var mobile = $('.mobile').val();

			if (mobile == "" || mobile == null || mobile == undefined) {
				$('.mobile').css('border', '1px solid #dc3545');
				$('.e_mobile').html("Mobile number required").show();
				return false;
			}
			if (mobile.length < 10 || mobile.length > 10) {
				$('.mobile').css('border', '1px solid #dc3545');
				$('.e_mobile').html("Invalid mobile length").show();
				return false;
			} else {
				$('.e_mobile').hide();
				$('.mobile').css('border', '1px solid #ced4da');
			}

			$.ajax({
				url: "<?php echo base_url('generate-otp'); ?>",
				method: "post",
				data: {
					[csrfName]: csrfHash,
					mobile: mobile
				},
				dataType: "json",
				beforeSend: function() {
					$('.genotp_btn').attr('disabled', 'readonly').css({
						'cursor': 'not-allowed'
					}).html("Generating OTP...");

					$('.err,.succ').hide();
					$('.form-control').css('border', '1px solid #ced4da');
				},
				success: function(res) {
					if (res.status === true) {
						$('.s_mobile').html(res.msg).show();
					} else if (res.status === false) {
						if (res.msg) {
							$('.e_mobile').html(res.msg).show();
						}
						if (res.error) {
							$('.e_mobile').html(res.error).show();
						}
					}

					//reset otp_btn
					$('.genotp_btn').delay(5000).removeAttr('disabled', 'readonly').css({
						'cursor': 'pointer'
					}).html("Get OTP");

					$('.csrf_token').val(res.token);
				},
				error: function(res) {
					alert('An error occured!');

					// window.location.reload();
				}

			});
		});


		//submitformbtn
		$(document).on('click', '.submitformbtn', function() {
			var csrfName = $('.csrf_token').attr('name');
			var csrfHash = $('.csrf_token').val();
			var form_key = $('.form_key').val();

			var stateName = $('.stateName').val();
			var districtName = $('.districtName').val();
			var cityName = $('.cityName').val();
			var cityNameID = $('.cityName').attr("id");
			var locationName = $('.locationName').val();

			var nameTitle = $('.nameTitle').val();
			var name = $('.name').val();
			var age = $('.age').val();
			var sex = $('.sex').val();
			var mobile = $('.mobile').val();
			var otp = $('.otp').val();
			var starv = $('.starv').val();

			if (name == "" || name == null) {
				$('.name').css('border', '1px solid #dc3545');
				return false;
			} else {
				$('.name').css('border', '1px solid #ced4da');
			}

			if (age == "" || age == null) {
				$('.age').css('border', '1px solid #dc3545');
				return false;
			}
			if (parseInt(age) < 15) {
				$('.age').css('border', '1px solid #dc3545');
				$('.e_age').html("Must be over 15").show();
				return false;
			} else {
				$('.e_age').hide();
				$('.age').css('border', '1px solid #ced4da');
			}

			if (sex == "" || sex == null || sex == undefined) {
				$('.sex').css('border', '1px solid #dc3545');
				return false;
			} else {
				$('.sex').css('border', '1px solid #ced4da');
			}

			if (mobile == "" || mobile == null || mobile == undefined) {
				$('.mobile').css('border', '1px solid #dc3545');
				return false;
			}
			if (mobile.length < 10 || mobile.length > 10) {
				$('.mobile').css('border', '1px solid #dc3545');
				$('.e_mobile').html("Invalid mobile length").show();
				return false;
			} else {
				$('.e_mobile').hide();
				$('.mobile').css('border', '1px solid #ced4da');
			}

			if (otp == "" || otp == null) {
				$('.otp').css('border', '1px solid #dc3545');
				$('.e_otp').html("OTP is required").show();
				return false;
			} else {
				$('.e_otp').hide();
				$('.otp').css('border', '1px solid #ced4da');
			}

			if (stateName == undefined || districtName == undefined || cityName == undefined || locationName == undefined) {
				window.location.reload();
			}

			$.ajax({
				url: "<?php echo base_url('save'); ?>",
				method: "post",
				data: {
					[csrfName]: csrfHash,
					form_key: form_key,
					starv: starv,
					nameTitle: nameTitle,
					name: name,
					age: age,
					sex: sex,
					mobile: mobile,
					otp: otp,
					cityNameID: cityNameID,
					locationName: locationName
				},
				dataType: "json",
				beforeSend: function() {
					$('.submitformbtn').attr('disabled', 'readonly').css({
						'cursor': 'not-allowed'
					}).html("Submitting...");

					$('.err,.succ').hide();
					$('.form-control').css('border', '1px solid #ced4da');
				},
				success: function(res) {
					if (res.status === true) {
						$('.s_otp').html(res.msg).show();

						alert("Form submitted");
						window.location.reload();
					} else if (res.status === false) {
						if (res.msg) {
							$('.e_otp').html(res.msg).show();
						}
						if (res.error) {
							$('.e_otp').html(res.error).show();
						}
					}

					//reset submit_btn
					$('.submitformbtn').removeAttr('disabled', 'readonly').css({
						'cursor': 'pointer'
					}).html("Submit");

					$('.csrf_token').val(res.token);
				},
				error: function(res) {
					alert('An error occured!');
					// window.location.reload();
				}
			});
		});
		//
	});
</script>