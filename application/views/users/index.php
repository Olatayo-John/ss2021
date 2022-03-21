<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/index.css'); ?>">


<div class="pl-5 pr-5 mt-5">
	<div class="emailmodal modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<form enctype="multipart/form-data" method="post" id="upload_csv">
					<div class="modal-body">
						<h6 class="font-weight-bolder text-danger">
							*CSV file must have header of only "Email"
						</h6>
						<input type="file" name="csv_file" id="csv_file" accept=".csv">
					</div>
					<div class="modal-footer justify-content-between">
						<button class="btn btn-secondary closebtn" type="button">Close</button>
						<button class="btn btn-success importbtn" type="submit">Import</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="smsmodal modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<form enctype="multipart/form-data" method="post" id="smsupload_csv">
					<div class="modal-body">
						<h6 class="font-weight-bolder text-danger">
							*CSV file must have header of only "Phonenumber"
						</h6>
						<input type="file" name="sms_csv_file" id="sms_csv_file" accept=".csv">
					</div>
					<div class="modal-footer justify-content-between">
						<button class="btn btn-secondary smsclosebtn" type="button">Close</button>
						<button class="btn btn-success smsimportbtn" type="submit">Import</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-5 p-0">
			<!-- <label style="color: #294a63">Invite citizens for rating</label><br> -->
			<h4 style="color: #294a63">Invite citizens for rating</h4>
			<div class="form-check ml-3">
				<input type="radio" class="form-check-input" name="link" value="ow" id="ow" checked="true">
				<label class="form-check-label" for="ow">Swachh Survekshan 2022</label>
			</div>
			<!-- <div class="form-check ml-3">
				<input type="radio" class="form-check-input" name="link" value="dlink" id="dlink">
				<label class="form-check-label" for="dlink">Direct Link</label>
			</div> -->
			<br>

			<div class="form-group">
				<!-- <label style="color: #294a63">Links</label><br> -->
				<h4 style="color: #294a63">Links</h4>
				<div class="form-check form-check-inline ml-3">
					<input class="form-check-input" type="radio" name="linkTosend" value="vote" id="vlink" checked="true">
					<label class="form-check-label" for="vlink">Voting Link</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="linkTosend" value="app" id="alink">
					<label class="form-check-label" for="alink">App Link</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="linkTosend" value="both" id="blink">
					<label class="form-check-label" for="blink">Both</label>
				</div>
			</div>

			<div class="sndasbtngrp mt-2">
				<button class="sndasmailbtn btn" style="background:#294a63;color:#fff">Send as Email</button>
				<button class="sndassmsbtn btn" style="background:#294a63;color:#fff">Send as SMS</button>
			</div>
		</div>
		<div class="col-md-7 p-0 allform">
			<form action="<?php echo base_url('user/send_link'); ?>" method="post" id="gen_link_form" class="gen_link_form">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf_hash">
				<input type="hidden" name="userid" value="<?php echo $this->session->userdata('rr_id'); ?>" class="userid">
				<div class="import text-right d-flex justify-content-between mb-2">
					<button class="btn singlemailsend" type="button" style="display:none;background:#294a63;color:#fff">Send single mail</button>
					<input type="hidden" name="link_for" class="link_for">
					<button class="btn importemail" type="button" style="background:#294a63;color:#fff">Import emails in CSV format</button>
					<a href="<?php echo base_url('user/email_sample_csv'); ?>" class="email_sample_csv btn btn-danger">
						<i class="fas fa-file-csv mr-2"></i>Download sample file</a>
				</div>

				<div class="form-group">
					<label style="color: #294a63">E-mail</label>
					<input type="email" name="email" class="form-control email" placeholder="example@domain.com" id="email">
					<select class="form-control email_select" name="email_select" id="email_select" style="display: none;" readonly conn="false">
						<option></option>
					</select>
				</div>

				<div class="form-group">
					<label style="color: #294a63">Subject</label>
					<input type="text" name="subj" class="form-control subj">
				</div>

				<div class="form-group">
					<label style="color: #294a63">Body</label>
					<textarea class="form-control bdy" rows="9" name="bdy"></textarea>
				</div>

				<div class="sendlinkdiv">
					<button class="btn btn-success btn-block sendlinkbtn">Send Email</button>
					<button class="btn btn-success btn-block sendmultiplelinkbtn" style="display: none;">Send Email</button>
				</div>
			</form>

			<form action="<?php echo base_url('user/sms_send_link'); ?>" method="post" id="sms_gen_link_form" class="sms_gen_link_form">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf_hash">
				<input type="hidden" name="userid" value="<?php echo $this->session->userdata('rr_id'); ?>" class="userid">
				<div class="sms_import text-right d-flex justify-content-between mb-2">
					<button class="btn singlsmssend" type="button" style="display:none;background:#294a63;color:#fff">Send single sms</button>
					<input type="hidden" name="link_for" class="link_for">
					<button class="btn smsimport" type="button" style="background:#294a63;color:#fff">Import Phonenumber in CSV format</button>
					<a href="<?php echo base_url('user/sms_sample_csv'); ?>" class="email_sample_csv btn btn-danger">
						<i class="fas fa-sms mr-2"></i>Download sample file</a>
				</div>

				<div class=" form-group">
					<label style="color: #294a63">Phonenumber</label>
					<input type="number" name="mobile" class="form-control mobile" placeholder="Your mobile number" id="mobile">
					<span class="e_mobile text-danger font-weight-bolder" style="display: none;">Invalid mobile length</span>
					<select class="form-control sms_select" name="sms_select" id="sms_select" style="display: none;" readonly conn="false">
						<option></option>
					</select>
				</div>

				<div class="form-group">
					<label style="color: #294a63">Body</label>
					<textarea class="form-control smsbdy" rows="9" name="smsbdy"></textarea>
				</div>

				<div class="sendlinkdiv">
					<button class="btn btn-success btn-block smssendlinkbtn">Send SMS</button>
					<button class="btn btn-success btn-block smssendmultiplelinkbtn" style="display: none;">Send SMS</button>
				</div>
			</form>
		</div>
	</div>

</div>



<script type="text/javascript" src="<?php echo base_url('assets/js/index.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {

		//load bodyFile on pageLoad
		var id = $('.userid').val();
		var csrfName = $('.csrf_hash').attr('name');
		var csrfHash = $('.csrf_hash').val();
		$.ajax({
			url: "<?php echo base_url('user/get_link'); ?>",
			method: "post",
			data: {
				id: id,
				[csrfName]: csrfHash
			},
			dataType: "json",
			success: function(data) {
				$('.csrf_hash').val(data.token);
				$('.subj').val("Swachh Survekshan 2022");
				$('.link_for').val('Swachh Survekshan');
				$(".bdy").load("<?php echo base_url("body.txt"); ?>");
				$(".smsbdy").load("<?php echo base_url("body.txt"); ?>");
				$('.gen_link_form').hide();
				$('.sndasbtngrp').show();
				$('.genlinkbtn').attr('disabled');
				$('.genlinkbtn').html('Generated');
				$('.genlinkbtn').css('cursor', 'pointer');
				$('.genlinkbtn').removeClass('btn-danger').addClass('btn-success');
			},
			error: function(data) {
				var baurl = "<?php echo base_url('user/account') ?>";
				window.location.assign(baurl);
			}
		});

		$(document).on('click', '.form-check-input', function() {
			var val = $(this).val();
			var csrfName = $('.csrf_hash').attr('name');
			var csrfHash = $('.csrf_hash').val();

			if (val) {
				$.ajax({
					url: "<?php echo base_url('user/changeLink'); ?>",
					method: "post",
					data: {
						val: val,
						[csrfName]: csrfHash
					},
					dataType: "json",
					success: function(data) {
						$('.csrf_hash').val(data.token);
						$('.subj').val("Swachh Survekshan 2022");
						$('.link_for').val('Swachh Survekshan');
						if (val === "vote") {
							$(".bdy,.smsbdy").load("<?php echo base_url('body.txt'); ?>");
						}
						if (val === "app") {
							$(".bdy,.smsbdy").load("<?php echo base_url('Appbody.txt'); ?>");
						}
						if (val === "both") {
							$(".bdy,.smsbdy").load("<?php echo base_url('Bothbody.txt'); ?>");
						}
					},
					error: function(data) {
						var baurl = "<?php echo base_url('user/account') ?>";
						window.location.assign(baurl);
					}
				});
			}
		});


		$('.sendlinkbtn').click(function() {
			var email = $('.email').val();
			var sbj = $('.subj').val();
			var body = $('.bdy').val();

			if (email == "" || email == null) {
				$('.email').css('border', '2px solid red');
				return false;
			} else {
				$('.email').css('border', '0 solid red');
			}
			if (body == "" || body == null) {
				$('.body').css('border', '2px solid red');
				return false;
			} else {
				$('.body').css('border', '0 solid red');
			}

			$.ajax({
				success: function() {
					$('.sendlinkbtn').attr('disabled', 'disabled');
					$('.sendlinkbtn').html('Sending...');
					$('.sendlinkbtn').css('cursor', 'not-allowed');
					$('.sendlinkbtn').removeClass('btn-success').addClass('btn-danger');
				}
			});
		});

		$('.sendmultiplelinkbtn').click(function(e) {
			e.preventDefault();
			var link_for = $('.link_for').val();
			var email = $('.email').val();
			var subj = $('.subj').val();
			var bdy = $('.bdy').val();
			var csrfName = $('.csrf_hash').attr('name');
			var csrfHash = $('.csrf_hash').val();

			if (email == "" || email == null) {
				$('.email').css('border', '2px solid red');
				return false;
			} else {
				$('.email').css('border', '0 solid red');
			}
			if (subj == "" || subj == null) {
				$('.subj').css('border', '2px solid red');
				return false;
			} else {
				$('.subj').css('border', '0 solid red');
			}
			if (bdy == "" || bdy == null) {
				$('.bdy').css('border', '2px solid red');
				return false;
			} else {
				$('.bdy').css('border', '0 solid red');
			}

			var emaildata = [];
			$(".email_options").each(function() {
				var eachopt = $(this).val();
				emaildata.push(eachopt);
			});

			$.ajax({
					url: "<?php echo base_url('user/send_multiple_link'); ?>",
					method: "post",
					data: {
						emaildata: emaildata,
						subj: subj,
						bdy: bdy,
						link_for: link_for,
						[csrfName]: csrfHash,
					},
					beforeSend: function() {
						$('.sendmultiplelinkbtn').attr('disabled', 'disabled');
						$('.sendmultiplelinkbtn').html('Sending...');
						$('.sendmultiplelinkbtn').css('cursor', 'not-allowed');
						$('.sendmultiplelinkbtn').removeClass('btn-success').addClass('btn-danger');
					},
					error: function() {
						$('.sendmultiplelinkbtn').attr('disabled', 'false');
						$('.sendmultiplelinkbtn').html('Send');
						$('.sendmultiplelinkbtn').css('cursor', 'pointer');
						$('.sendmultiplelinkbtn').removeClass('btn-danger').addClass('btn-success');
					}
				})
				.done(function() {
					window.location.reload();
				});
		});

		$('#upload_csv').on('submit', function(e) {
			e.preventDefault();
			var file = $('#csv_file').val();
			var csrfName = $('.csrf_hash').attr('name');
			var csrfHash = $('.csrf_hash').val();

			if (file == "" || file == null) {
				$('#csv_file').css('border', '2px solid red');
				return false;
			} else {
				$('#csv_file').css('border', '0 solid red');
			}

			$.ajax({
				url: "<?php echo base_url('user/importcsv'); ?>",
				method: "post",
				data: new FormData(this),
				[csrfName]: csrfHash,
				dataType: "json",
				contentType: false,
				cache: false,
				processData: false,
				beforSend: function(data) {
					$('.importbtn').attr('disabled', 'disabled');
					$('.importbtn').html('Importing...');
					$('.importbtn').css('cursor', 'not-allowed');
					$('.importbtn').removeClass('btn-success').addClass('btn-danger');
				},
				success: function(data) {
					$('.emailmodal').hide();
					$('#csv_file').val("");
					for (i = 0; i < data.length; i++) {
						$('#email_select').append('<option disabled class="email_options">' + data[i].email + '</option>');
					}
					$('#email').hide();
					$('#email').val('nomailname@nodomainname.com');
					$('.sendlinkbtn').hide();
					$('.sendmultiplelinkbtn').show();
					$('#email_select').attr('conn', 'true');
					$('#email_select').show();
					$('.singlemailsend').show();
					bseu = "<?php echo base_url('user/send_multiple_link'); ?>";
					$("#gen_link_form").attr('action', bseu);
				},
				error: function(data) {
					alert('Error importing data');
				}
			});
		});

		$('.smssendlinkbtn').click(function() {
			var mobile = $('.mobile').val();
			var smsbdy = $('.smsbdy').val();

			if (mobile == "" || mobile == null) {
				$('.mobile').css('border', '2px solid red');
				return false;
			}
			if (mobile.length < 10 || mobile.length > 10) {
				$('.mobile').css('border', '2px solid red');
				$('.e_mobile').show();
				return false;
			} else {
				$('.mobile').css('border', '0 solid red');
				$('.e_mobile').hide();
			}
			if (smsbdy == "" || smsbdy == null) {
				$('.smsbdy').css('border', '2px solid red');
				return false;
			} else {
				$('.smsbdy').css('border', '0 solid red');
			}

			$.ajax({
				success: function() {
					$('.smssendlinkbtn').attr('disabled', 'disabled');
					$('.smssendlinkbtn').html('Sending...');
					$('.smssendlinkbtn').css('cursor', 'not-allowed');
					$('.smssendlinkbtn').removeClass('btn-success').addClass('btn-danger');
				}
			});
		});

		$('#smsupload_csv').on('submit', function(e) {
			e.preventDefault();
			var sms_file = $('#sms_csv_file').val();
			var csrfName = $('.csrf_hash').attr('name');
			var csrfHash = $('.csrf_hash').val();

			if (sms_file == "" || sms_file == null) {
				$('#sms_csv_file').css('border', '2px solid red');
				return false;
			} else {
				$('#sms_csv_file').css('border', '0 solid red');
			}

			$.ajax({
				url: "<?php echo base_url('user/sms_importcsv'); ?>",
				method: "post",
				data: new FormData(this),
				[csrfName]: csrfHash,
				dataType: "json",
				contentType: false,
				cache: false,
				processData: false,
				beforSend: function(data) {
					$('.smsimportbtn').attr('disabled', 'disabled');
					$('.smsimportbtn').html('Importing...');
					$('.smsimportbtn').css('cursor', 'not-allowed');
					$('.smsimportbtn').removeClass('btn-success').addClass('btn-danger');
				},
				success: function(data) {
					$('#mobile').val('5555555555');
					$('.smsmodal').hide();
					$('#sms_csv_file').val("");
					for (i = 0; i < data.length; i++) {
						$('#sms_select').append('<option disabled class="sms_options">+91' + data[i].Phonenumber + '</option>');
					}
					$('#mobile').hide();
					$('.smssendlinkbtn').hide();
					$('.smssendmultiplelinkbtn').show();
					$('#sms_select').attr('conn', 'true');
					$('#sms_select').show();
					$('.singlsmssend').show();
					bseu = "<?php echo base_url('user/multiple_sms_send_link'); ?>";
					$("#gen_link_form").attr('action', bseu);
				},
				error: function(data) {
					alert('Error importing data');
				}
			});
		});

		$('.smssendmultiplelinkbtn').click(function(e) {
			e.preventDefault();
			var link_for = $('.link_for').val();
			var mobile = $('.mobile').val();
			var smsbdy = $('.smsbdy').val();
			var csrfName = $('.csrf_hash').attr('name');
			var csrfHash = $('.csrf_hash').val();

			if (mobile == "" || mobile == null) {
				$('.mobile').css('border', '2px solid red');
				return false;
			}
			if (mobile.length < 10 || mobile.length > 10) {
				$('.mobile').css('border', '2px solid red');
				$('.e_mobile').show();
				return false;
			} else {
				$('.mobile').css('border', '0 solid red');
				$('.e_mobile').hide();
			}
			if (smsbdy == "" || smsbdy == null) {
				$('.smsbdy').css('border', '2px solid red');
				return false;
			} else {
				$('.smsbdy').css('border', '0 solid red');
			}

			var mobiledata = [];
			$(".sms_options").each(function() {
				var eachopt = $(this).val();
				mobiledata.push(eachopt);
			});

			$.ajax({
					url: "<?php echo base_url('user/multiple_sms_send_link'); ?>",
					method: "post",
					data: {
						mobiledata: mobiledata,
						smsbdy: smsbdy,
						link_for: link_for,
						[csrfName]: csrfHash,
					},
					beforeSend: function() {
						$('.smssendmultiplelinkbtn').attr('disabled', 'disabled');
						$('.smssendmultiplelinkbtn').html('Sending...');
						$('.smssendmultiplelinkbtn').css('cursor', 'not-allowed');
						$('.smssendmultiplelinkbtn').removeClass('btn-success').addClass('btn-danger');
					},
					error: function() {
						$('.smssendmultiplelinkbtn').attr('disabled', 'false');
						$('.smssendmultiplelinkbtn').html('Send');
						$('.smssendmultiplelinkbtn').css('cursor', 'pointer');
						$('.smssendmultiplelinkbtn').removeClass('btn-danger').addClass('btn-success');
					}
				})
				.done(function() {
					window.location.reload();
				});
		});

	});
</script>