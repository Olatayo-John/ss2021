<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/account.css'); ?>">


<div class="p-5 pt-0">
	<?php if ($this->session->userdata("rr_admin") === "1") : ?>
		<label class="pl-3">Quota</label>
		<div class="row col-md-12 m-0 p-0 pb-5">
			<div class="col-lg-4 col-xs-12 col-md-12 total-column">
				<div class="panel_s">
					<div class="panel-body">
						<h3 class="_total"><?php echo number_format($balance->bought) ?></h3>
						<span>Total</span>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-xs-12 col-md-12 total-column">
				<div class="panel_s">
					<div class="panel-body">
						<h3 class="_total"><?php echo number_format($balance->used) ?></h3>
						<span>Used</span>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-xs-12 col-md-12 total-column">
				<div class="panel_s">
					<div class="panel-body">
						<h3 class="_total"><?php echo number_format($balance->bal) ?></h3>
						<span>Balance</span>
					</div>
				</div>
			</div>
		</div>

		<label class="pl-3">Links</label>
		<div class="row col-md-12 m-0 p-0 pb-5">
			<div class="col-lg-4 col-xs-12 col-md-12 total-column">
				<div class="panel_s">
					<div class="panel-body">
						<h3 class="_total"><?php echo $all_sms[0]->sms + $all_email[0]->email ?></h3>
						<span>Total</span>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-xs-12 col-md-12 total-column">
				<div class="panel_s">
					<div class="panel-body">
						<h3 class="_total"><?php echo $all_sms[0]->sms ?></h3>
						<span>SMS</span>
					</div>
				</div>
			</div>
			<!-- <div class="col-lg-4 col-xs-12 col-md-12 total-column">
				<div class="panel_s">
					<div class="panel-body">
						<h3 class="_total"><?php echo $all_email[0]->email ?></h3>
						<span>Emails</span>
					</div>
				</div>
			</div> -->
		</div>

		<label class="pl-3">Feedbacks</label>
		<div class="row col-md-12 m-0 p-0 pb-5">
			<div class="col-lg-4 col-xs-12 col-md-12 total-column">
				<div class="panel_s">
					<div class="panel-body">
						<h3 class="_total"><?php echo ($tr) ?></h3>
						<span>Feedbacks</span>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>



<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token">
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
		var csrfName = $('.csrf_token').attr('name');
		var csrfHash = $('.csrf_token').val();
		$.ajax({
			url: "<?php echo base_url('user/bar_data'); ?>",
			method: "post",
			dataType: "json",
			data: {
				[csrfName]: csrfHash,
			},
			success: function(data) {
				$('.tr').html(data.tl);
				$('.atl5').html(data.tl5);
				$('.atl4').html(data.tl4);
				$('.atl3').html(data.tl3);
				$('.atl2').html(data.tl2);
				$('.atl1').html(data.tl1);
				$('.csrf_token').val(data.token);
			},
			error: function(data) {
				alert('Error showing');
			}
		});



	});
</script>