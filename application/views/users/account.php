<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/account.css'); ?>">


<div class="p-3 pt-0">
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

		<!-- <label class="pl-3">Links</label>
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
			<div class="col-lg-4 col-xs-12 col-md-12 total-column">
				<div class="panel_s">
					<div class="panel-body">
						<h3 class="_total"><?php echo $all_email[0]->email ?></h3>
						<span>Emails</span>
					</div>
				</div>
			</div>
		</div> -->
	<?php endif; ?>

	<label class="pl-3">Feedback</label>
	<div class="row col-md-12 m-0 p-0 pb-5">
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
					<span>Your Feedbacks Today</span>
				</div>
			</div>
		</div>
	</div>

	<table id="FBackTable" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-md btn" data-buttons-align="left" data-pagination="true" data-sticky-header="true" data-sticky-header-offset-y="0" tablename="Votes" data-buttons=buttons style="white-space:nowrap;">
		<thead class="text-light" style="background:#223b55;">
			<tr>
				<th data-field="IP" data-sortable="true">IP</th>

				<th data-field="Name" data-sortable="true">Name</th>

				<th data-field="Mobile" data-sortable="true">Mobile</th>

				<th data-field="Date" data-sortable="true">Date</th>
			</tr>
		</thead>
		<tbody class="bg-light">
			<?php foreach ($userRating as $u) : ?>
				<tr class="text-dark">
					<td class><?php echo $u['user_ip'] ?></td>
					<td class><?php echo $u['name'] ?></td>
					<td class><?php echo $u['mobile'] ?></td>
					<td class><?php echo $u['rated_at'] ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
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