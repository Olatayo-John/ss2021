<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/pick_plan.css'); ?>">

<form method="post" name="renew_plan_form" class="renew_plan_form" action="<?php echo base_url('admin/save_plan'); ?>" target>
	<input type="hidden" name="plan_amount" class="plan_amount">
	<input type="hidden" name="quota_amount" class="quota_amount">
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token">
</form>

<input type="hidden" value="<?php echo $this->session->userdata('rr_form_key'); ?>" class="form_key">

<?php if ($this->session->userdata("rr_sub") == "0") : ?>
	<div class="container mb-5">
		<div class="bg-danger error">
			<i class="fas fa-exclamation-circle"></i>
			<strong>You have no active subscription. Pick a plan suitable to continue using our services.</strong>
		</div>
	</div>
<?php endif; ?>

<?php if ($this->session->userdata("rr_sub") == "1") : ?>
	<div class="container mb-5">
		<div class="bg-success error">
			<i class="fas fa-check-circle"></i>
			<strong>You have an active subscription.</strong>
		</div>
	</div>
<?php endif; ?>

<div class="container-fluid row">
	<div class="col-md-3 plan-one">
		<div class="card">
			<div class="card-header text-center bg-primary text-light">
				<label>BASIC</label>
			</div>
			<div class="text-center mt-2 mb-0 text-primary font-weight-bolder amount bg-primary text-light">
				<i class="fas fa-rupee-sign"></i>
				25,000
			</div>
			<div class="card-body">
				<p class="text-center font-weight-bolder">25,000 Voting points for:</p>
				<div class="ml-5">
					<i class="fas fa-check-circle text-success mr-2"></i>EMAIL<br>
					<i class="fas fa-check-circle text-success mr-2"></i>SMS<br>
					<i class="fas fa-check-circle text-success mr-2"></i>RATINGS<br>
				</div>
			</div>
			<div class="card-footer">
				<?php if ($this->session->userdata('rr_sub') == '0') : ?>
					<button class="btn btn-outline-info btn-block sub_btn renewplanbtn" amount="25000" quota="25000" type="submit">Choose Plan</button>
				<?php endif; ?>
				<?php if ($this->session->userdata('rr_sub') == '1') : ?>
					<button class="btn btn-outline-info btn-block sub_btn renewplanbtn" amount="25000" quota="25000" type="submit">Renew Plan</button>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="col-md-3 plan-two">
		<div class="card bg-light">
			<div class="card-header text-center bg-secondary">
				<label>SILVER</label>
			</div>
			<div class="text-center mt-2 mb-0 text-secondary font-weight-bolder amount bg-secondary text-light">
				<i class="fas fa-rupee-sign"></i>
				50,000
			</div>
			<div class="card-body">
				<p class="text-center font-weight-bolder">62,500 Voting points for:</p>
				<div class="ml-5">
					<i class="fas fa-check-circle text-success mr-2"></i>EMAIL<br>
					<i class="fas fa-check-circle text-success mr-2"></i>SMS<br>
					<i class="fas fa-check-circle text-success mr-2"></i>RATINGS<br>
				</div>
			</div>
			<div class="card-footer">
				<?php if ($this->session->userdata('rr_sub') == '0') : ?>
					<button class="btn btn-outline-info btn-block sub_btn renewplanbtn" amount="50000" quota="62500" type="submit">Choose Plan</button>
				<?php endif; ?>
				<?php if ($this->session->userdata('rr_sub') == '1') : ?>
					<button class="btn btn-outline-info btn-block sub_btn renewplanbtn" amount="50000" quota="62500" type="submit">Renew Plan</button>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="col-md-3 plan-three">
		<div class="card ">
			<div class="card-header text-center bg-warning">
				<label>GOLD</label>
			</div>
			<div class="text-center mt-2 mb-0 text-warning font-weight-bolder amount bg-warning text-light">
				<i class="fas fa-rupee-sign"></i>
				1,00,000
			</div>
			<div class="card-body">
				<p class="text-center font-weight-bolder">1,50,000 Voting points for:</p>
				<div class="ml-5">
					<i class="fas fa-check-circle text-success mr-2"></i>EMAIL<br>
					<i class="fas fa-check-circle text-success mr-2"></i>SMS<br>
					<i class="fas fa-check-circle text-success mr-2"></i>RATINGS<br>
				</div>
			</div>
			<div class="card-footer">
				<?php if ($this->session->userdata('rr_sub') == '0') : ?>
					<button class="btn btn-outline-info btn-block sub_btn renewplanbtn" amount="100000" quota="150000" type="submit">Choose Plan</button>
				<?php endif; ?>
				<?php if ($this->session->userdata('rr_sub') == '1') : ?>
					<button class="btn btn-outline-info btn-block sub_btn renewplanbtn" amount="100000" quota="150000" type="submit">Renew Plan</button>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="col-md-3 plan-four">
		<div class="card">
			<div class="card-header text-center bg-dark text-light">
				<label>PLATINUM</label>
			</div>
			<div class="text-center mt-2 mb-0 font-weight-bolder amount bg-dark text-light">
				<i class="fas fa-rupee-sign"></i>
				<span class="voting_amount"></span>
			</div>
			<div class="card-body">
				<input type="text" name="voting_points" value="" class="form-control voting_points mb-2" placeholder="Enter your desired amount" readonly>
				<div class="ml-5">
					<i class="fas fa-check-circle text-success mr-2"></i>EMAIL<br>
					<i class="fas fa-check-circle text-success mr-2"></i>SMS<br>
					<i class="fas fa-check-circle text-success mr-2"></i>RATINGS<br>
				</div>
			</div>
			<div class="card-footer">
				<?php if ($this->session->userdata('rr_sub') == '0') : ?>
					<button class="btn btn-outline-info btn-block sub_btn renewplanbtn voting_points" amount="500000" quota="1250000" type="submit">Choose Plan</button>
				<?php endif; ?>
				<?php if ($this->session->userdata('rr_sub') == '1') : ?>
					<button class="btn btn-outline-info btn-block sub_btn renewplanbtn voting_points" amount="500000" quota="1250000" type="submit">Renew Plan</button>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript" src="<?php echo base_url('assets/js/pick_plan.js'); ?>"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.renewplanbtn').click(function() {
			var user_id = "<?php echo $this->session->userdata('rr_id'); ?>";
			var user_form_key = "<?php echo $this->session->userdata('rr_form_key'); ?>";

			if (user_id !== "" && user_form_key !== "") {
				var amount = $(this).attr("amount");
				var quota = $(this).attr("quota");
				$('.plan_amount').attr('value', amount);
				$('.quota_amount').attr('value', quota);
				$('form.renew_plan_form').submit();
			} else {
				window.location.reload();
			}
		});

		$('.voting_points').keyup(function() {
			var v_points = $(this).val();
			$('span.voting_amount').html(v_points);
		});

	});
</script>