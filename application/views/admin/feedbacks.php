<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/feedbacks.css'); ?>">
<div class="bg-dark ml-3 mr-3 mt-3">
	<ul class="tab_ul">
		<li class="tab_li">
			<a href="" class="tab_a star_r">Star Ratings</a>
			<a href="" class="tab_a ques_r">Question Ratings</a>
		</li>
	</ul>
</div>

<div class="star_r_div table-responsive">
	<table class="table table-hover table-sm table-light table-bordered">
		<thead class="bg-dark text-light">
			<th><i class="fas fa-sort"></i>IP</th>
			<th><i class="fas fa-sort"></i>Name</th>
			<th><i class="fas fa-sort"></i>Message</th>
			<th><i class="fas fa-sort"></i>Mobile</th>
			<th><i class="fas fa-sort"></i>Star</th>
			<th><i class="fas fa-sort"></i>Time</th>
		</thead>
		<?php if($r_reviews->num_rows() == "0"): ?>
			<tr>
				<td class="text-dark text-uppercase font-weight-bolder" colspan="6">no data found</td>
			</tr>
		<?php endif; ?>
		<?php foreach($r_reviews->result_array() as $rv): ?>
			<tr>
				<td><?php echo $rv['user_ip'] ?></td>
				<td><?php echo $rv['name'] ?></td>
				<td><?php echo $rv['review_msg'] ?></td>
				<td><?php echo $rv['mobile'] ?></td>
				<td><?php echo $rv['star'] ?></td>
				<td><?php echo $rv['rated_at'] ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>

<div class="ques_r_div table-responsive">
	<table class="table table-hover table-sm table-light table-bordered">
		<thead class="bg-dark text-light">
			<th><i class="fas fa-sort"></i>IP</th>
			<th><i class="fas fa-sort"></i>Question One</th>
			<th><i class="fas fa-sort"></i>Question Two</th>
			<th><i class="fas fa-sort"></i>Question Three</th>
			<th><i class="fas fa-sort"></i>Question Four</th>
			<th><i class="fas fa-sort"></i>Question Five</th>
			<th><i class="fas fa-sort"></i>Question Six</th>
			<th><i class="fas fa-sort"></i>Question Seven</th>
			<th class="text-danger"><i class="fas fa-sort"></i>Time</th>
		</thead>
		<?php if($q_reviews->num_rows() == "0"): ?>
			<tr>
				<td class="text-dark text-uppercase font-weight-bolder" colspan="6">no data found</td>
			</tr>
		<?php endif; ?>
		<?php foreach($q_reviews->result_array() as $qv): ?>
			<tr>
				<td><?php echo $qv['user_ip'] ?></td>
				<td><?php echo $qv['q_one'] ?></td>
				<td><?php echo $qv['q_two'] ?></td>
				<td><?php echo $qv['q_three'] ?></td>
				<td><?php echo $qv['q_four'] ?></td>
				<td><?php echo $qv['q_five'] ?></td>
				<td><?php echo $qv['q_six'] ?></td>
				<td><?php echo $qv['q_seven'] ?></td>
				<td class="text-danger"><?php echo $qv['rated_at'] ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/js/feedbacks.js'); ?>"></script>