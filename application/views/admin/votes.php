<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/votes.css'); ?>">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" class="csrf_token">

<div class="container-fluid pt-3">
	<div class="modal updateusermodal" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-body">
					<table id="UserVoteTable" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-md btn" data-buttons-align="left" data-pagination="true" data-sticky-header="true" data-sticky-header-offset-y="60" tablename="UserVote" data-buttons=buttons style="white-space:nowrap;">
						<thead class="text-light" style="background:#223b55;">
							<tr>
								<th data-field="Name" data-sortable="true">Name</th>

								<th data-field="Message" data-sortable="true">Message</th>

								<th data-field="Star" data-sortable="true">Star</th>

								<th data-field="Mobile" data-sortable="true">Mobile</th>

								<th data-field="IP" data-sortable="true">IP</th>

								<th data-field="Date" data-sortable="true">Date</th>
							</tr>
						</thead>
					</table>

					<hr>
					<div class="updatebtngrp text-left mb-2">
						<button class="btn btn-dark closeupdatebtn bradius mr-3">Close</button>
						<input type="hidden" name="ser_id" class="form-control user_id">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- <div class="container-fluid row mb-2">
		<div class="col total_link text-secondary">
			<h4 class="text-center stared">App</h4>
			<div class="value tapp"></div>
		</div>
		<div class="col total_link text-secondary">
			<h4 class="text-center stared">Votes</h4>
			<div class="value tl text-secondary"></div>
		</div>
		<div class="col total_link">
			<h4 class="text-center stared text-success">5 stared</h4>
			<div class="value tl5"></div>
		</div>
		<div class="col total_link">
			<h4 class="text-center stared text-info">4 stared</h4>
			<div class="value tl4"></div>
		</div>
		<div class="col total_link">
			<h4 class="text-center stared text-warning">3 stared</h4>
			<div class="value tl3"></div>
		</div>
		<div class="col total_link">
			<h4 class="text-center stared text-dark">2 stared</h4>
			<div class="value tl2"></div>
		</div>
		<div class="col total_link">
			<h4 class="text-center stared text-danger">1 stared</h4>
			<div class="value tl1"></div>
		</div>
	</div> -->

	<div class="">
	<div class="row col-md-12 m-0 p-0 pb-3">
			<div class="col-lg-3 col-xs-12 col-md-12 total-column">
				<div class="panel_s">
					<div class="panel-body">
						<h3 class="_feedbck links"></h3>
						<span>Total SMS</span>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-xs-12 col-md-12 total-column">
				<div class="panel_s">
					<div class="panel-body">
						<h3 class="_feedbck tl"></h3>
						<span>Total Feedback</span>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-xs-12 col-md-12 total-column">
				<div class="panel_s">
					<div class="panel-body">
						<h3 class="_apphit tapp"></h3>
						<span>Total AppHit</span>
					</div>
				</div>
			</div>
			<!-- <div class="col-lg-3 col-xs-12 col-md-12 total-column">
				<div class="panel_s">
					<div class="panel-body">
						<h3 class="_apphit tapp"></h3>
						<span>Link Hit</span>
					</div>
				</div>
			</div> -->
		</div>
	</div>

	<table id="VoteTable" data-toggle="table" data-search="true" data-show-export="true" data-buttons-prefix="btn-md btn" data-buttons-align="left" data-pagination="true" data-sticky-header="true" data-sticky-header-offset-y="60" tablename="Votes" data-buttons=buttons style="white-space:nowrap;">
		<!-- <thead class="text-light" style="background:#223b55;">
				<tr>
					<th data-field="Username" data-sortable="true">Username</th>

					<th data-field="SMS" data-sortable="true">SMS</th>

					<th data-field="Email" data-sortable="true">Email</th>

					<th data-field="Votes" data-sortable="true">Votes</th>

					<th data-field="5Star" data-sortable="true">5 Star</th>

					<th data-field="4Star" data-sortable="true">4 Star</th>

					<th data-field="3Star" data-sortable="true">3 Star</th>

					<th data-field="2Star" data-sortable="true">2 Star</th>

					<th data-field="1Star" data-sortable="true">1 Star</th>

					<th data-field="ViewVotes" data-sortable="true">View Votes</th>
				</tr>
			</thead>
			<tbody class="bg-light">
				<?php foreach ($details->result_array() as $info) : ?>
					<tr class="text-dark text-center">
						<td class="font-weight-bolder"><?php echo $info['name'] ?></td>
						<td class="font-weight-bolder tv"><?php echo $info['sms'] ?></td>
						<td class="font-weight-bolder tv"><?php echo $info['email'] ?></td>
						<td class="font-weight-bolder tv"><?php echo $info['total_links'] ?></td>
						<td class="font-weight-bolder tv"><?php echo $info['5_star'] ?></td>
						<td class="font-weight-bolder tv"><?php echo $info['4_star'] ?></td>
						<td class="font-weight-bolder tv"><?php echo $info['3_star'] ?></td>
						<td class="font-weight-bolder tv"><?php echo $info['2_star'] ?></td>
						<td class="font-weight-bolder tv"><?php echo $info['1_star'] ?></td>
						<td class="font-weight-bolder">
							<i class="fas fa-poll text-danger" form_key="<?php echo $info['form_key'] ?>"></i>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody> -->

		<thead class="text-light" style="background:#223b55;">
			<tr>
				<th data-field="Username" data-sortable="true">Username</th>

				<th data-field="SMS" data-sortable="true">SMS</th>

				<!-- <th data-field="Email" data-sortable="true">Email</th> -->

				<th data-field="Votes" data-sortable="true">Feedbacks</th>
			</tr>
		</thead>
		<tbody class="bg-light">
			<?php foreach ($details->result_array() as $info) : ?>
				<tr class="text-dark">
					<td class><?php echo $info['name'] ?></td>
					<td class><?php echo $info['sms'] ?></td>
					<!-- <td class><?php echo $info['email'] ?></td> -->
					<td><?php echo $info['total_links'] ?></td>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>



<script type="text/javascript" src="<?php echo base_url('assets/js/votes.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {

		var csrfName = $('.csrf_token').attr('name');
		var csrfHash = $('.csrf_token').val();
		$.ajax({
			url: "<?php echo base_url('bar-data'); ?>",
			method: "post",
			dataType: "json",
			data: {
				[csrfName]: csrfHash,
			},
			success: function(data) {
				$('.tl').html(data.tl);
				$('.links').html(data.links.length);
				$('.tl5').html(data.tl5);
				$('.tl4').html(data.tl4);
				$('.tl3').html(data.tl3);
				$('.tl2').html(data.tl2);
				$('.tl1').html(data.tl1);
				$('.tapp').html(data.tapp);
				$('.csrf_token').val(data.token);
			},
			error: function(data) {
				alert('Error showing');
			}
		});

		$(document).on('click', 'i.fa-poll', function() {
			var key = $(this).attr("form_key");
			var csrfName = $('.csrf_token').attr('name');
			var csrfHash = $('.csrf_token').val();

			$.ajax({
				url: "<?php echo base_url('get-user-votes') ?>",
				method: "POST",
				data: {
					key: key,
					[csrfName]: csrfHash
				},
				dataType: "json",
				success: function(data) {
					$('.csrf_token').val(data.token);
					$('.input_form_key').val(key);
					$(".indiv_votes_export_csv").attr("href", "indiv_votes_export_csv/" + key);
					if (data['users'].length == 0) {
						var table = $('table.tableuserreview');
						var tr = $('<tr class="truserreview"></tr>');
						tr.append('<td colspan="6" class="font-weight-bolder text-dark text-center">User has no data</td>');
						table.append(tr);
						$('.updateusermodal').modal('show');
					}
					var table = $('table.tableuserreview');
					for (var i = 0; i < data['users'].length; i++) {
						var tr = $('<tr class="truserreview"></tr>');
						tr.append('<td class="font-weight-bolder text-dark">' + data['users'][i].name + '</td>');
						tr.append('<td class="font-weight-bolder">' + data['users'][i].review_msg + '</td>');
						tr.append('<td class="font-weight-bolder">' + data['users'][i].star + '</td>');
						tr.append('<td class="font-weight-bolder">' + data['users'][i].mobile + '</td>');
						tr.append('<td class="font-weight-bolder">' + data['users'][i].user_ip + '</td>');
						tr.append('<td class="text-danger font-weight-bolder">' + data['users'][i].rated_at + '</td>');
						table.append(tr);
						$('.updateusermodal').modal('show');
					}
				}
			});
		});

		$('.tv').each(function() {
			$(this).prop('Counter', 0).animate({
				Counter: $(this).text()
			}, {
				duration: 1000,
				easing: 'swing',
				step: function(now) {
					$(this).text(Math.ceil(now));
				}
			});
		});

	});
</script>