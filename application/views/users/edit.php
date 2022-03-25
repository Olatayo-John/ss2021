<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/edit.css'); ?>">
<div class="container col-md-10 pb-5 pt-5">

	<!-- <div class="row col-md-12 m-0 p-0 pb-5">
		<div class="col-lg-6 col-xs-12 col-md-12 total-column">
			<div class="panel_s">
				<div class="panel-body">
					<h3 class="_total"><?php echo ($user[0]['total_links']) ?></h3>
					<span>Your Total Feedbacks</span>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-xs-12 col-md-12 total-column">
			<div class="panel_s">
				<div class="panel-body">
					<h3 class="_total"><?php echo ($userToday) ?></h3>
					<span>Your Feedbacks today</span>
				</div>
			</div>
		</div>
	</div> -->

	<form action="<?php echo base_url('profile'); ?>" method="post" class="editform">

		<input type="hidden" class="csrf_token" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

		<div class="form-group">
			<label>Username</label>
			<input type="text" name="uname" class="form-control uname" readonly disabled value="<?php echo $info->full_name ?>">
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<label>E-mail</label>
					<input type="email" name="email" class="form-control email" value="<?php echo $info->email ?>">
				</div>
				<div class="col-md-6 dptcol form-group">
					<label>Mobile</label>
					<input type="number" name="mobile" class="form-control mobile" value="<?php echo $info->mobile ?>">
					<div class="text-danger font-weight-bolder mobileerr" style="display: none;">Invalid mobile length</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<div class="col-md-6">
					<label>Employee ID</label>
					<input type="text" name="eid" class="form-control eid" value="<?php echo $info->eid ?>">
				</div>
				<div class="col-md-6 dptcol form-group">
					<label>Department</label>
					<input type="text" name="dept" class="form-control dept" value="<?php echo $info->dept ?>" readonly>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="d-flex justify-content-between">
				<label class="mb-0">Feedback Link</label>
				<span class="linkcopyalert text-danger text-right" style="display: none;"><strong>Link copied!</strong></span>
			</div>
			<input type="text" name="form_key" id="form_key" class="form-control form_key" value="<?php echo base_url() . "rate/" . $info->form_key ?>" readonly>
			<!-- <button class="btn btn-xs copylinkbtn mt-2" onclick="copyfunc('#form_key')" type="button" style="border-radius: 0px;background-color: #0B3954;color: white"><i class="fas fa-copy"></i> Copy link
			</button> -->
		</div>

		<div class="form-group">
			<div class="d-flex justify-content-between">
				<label class="mb-0">App Link</label>
				<span class="linkcopyalert text-danger text-right" style="display: none;"><strong>Link copied!</strong></span>
			</div>
			<input type="text" name="form_key" id="form_key" class="form-control form_key" value="https://swachhsurvekshan.org/2022/download-swachhta-app" readonly>
		</div>

		<div class="btngrp">
			<button class="btn btn-block text-light updatebtn" style="background-color: #0B3954;" type="submit">Update</button>
		</div>
	</form>
</div>



<script type="text/javascript">
	function copyfunc(element) {
		var link = $("<input>");
		$("body").append(link);
		link.val($(element).val()).select();
		document.execCommand("copy");
		link.remove();
		$('.linkcopyalert').show();
	}

	$(document).ready(function() {
		$('button.updatebtn').click(function(e) {
			// e.preventDefault();

			var mobile = $('.mobile').val();

			if (mobile == "" || mobile == null) {
				$('.mobile').css('border', '1px solid red');
				return false;
			}
			if (mobile.length < 10 || mobile.length > 10) {
				$('.mobile').css('border', '1px solid red');
				$('.mobileerr').show();
				return false;
			} else {
				$('.mobile').css('border', '1px solid #ced4da');
				$('.mobileerr').hide();
			}
			$.ajax({
				success: function() {
					$('.updatebtn').attr('disabled', 'disabled');
					$('.updatebtn').html('Updating...');
					$('.updatebtn').css('cursor', 'not-allowed');
					$('.updatebtn').removeClass('btn-info').addClass('btn-danger');
				}
			});
		});
	});
</script>