<!DOCTYPE html>
<html>

<head>
	<title>RATING</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/header.css'); ?>">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://kit.fontawesome.com/ca92620e44.js" crossorigin="anonymous"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.5.0/gsap.min.js"></script>

	<link href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css" rel="stylesheet">
	<script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js"></script>

	<script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
	<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/export/bootstrap-table-export.min.js"></script>

	<link href="https://unpkg.com/bootstrap-table@1.19.1/dist/extensions/sticky-header/bootstrap-table-sticky-header.css" rel="stylesheet">
	<script src="https://unpkg.com/bootstrap-table@1.19.1/dist/extensions/sticky-header/bootstrap-table-sticky-header.min.js"></script>
	<link rel="icon" href="<?php echo base_url('assets/images/logo_dark.png') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/header.css'); ?>">
	<script type="text/javascript">
		document.onreadystatechange = function() {
			if (document.readyState !== "complete") {
				$(".spinnerdiv").show();
			} else {
				$(".spinnerdiv").fadeOut();
			}
		};
	</script>
</head>
<div class="spinnerdiv">
	<div class="spinner-border text-danger"></div>
</div>

<body>
	<nav class="navbar navbar-expand-lg navbar-light">

		<button class="btn btn-outline-dark menubtn mr-auto" onclick="opennav()">&#9776;</button>

		<?php $url = $this->uri->segment(1); ?>

		<div class="side-nav" id="side-nav">
			<a href="javascript:void(0)" class="closex" onclick="closenav()">&times;</a>
			<ul class="side-nav-ul">
				<?php if ($this->session->userdata('rr_logged_in') && $this->session->userdata('rr_admin') == "1") : ?>
					<li class="nav-item"><a href="<?php echo base_url('votes') ?>" class="nav-link" style="<?php echo ($url == 'votes') ? 'background-color: #0B3954' : '' ?>">
							<i class="fas fa-poll"></i>Votes</a>
					</li>

					<li class="nav-item"><a href="<?php echo base_url('users') ?>" class="nav-link" style="<?php echo ($url == 'users') ? 'background-color: #0B3954' : '' ?>">
							<i class="fas fa-user-shield"></i>Users</a>
					</li>

					<li class="nav-item"><a href="<?php echo base_url('account') ?>" class="nav-link" style="<?php echo ($url == 'account') ? 'background-color: #0B3954' : '' ?>">
							<i class="fas fa-hourglass-half"></i>Account</a>
					</li>
				<?php endif; ?>

				<?php if ($this->session->userdata('rr_logged_inn') && $this->session->userdata('rr_admin') == "1") : ?>
					<li class="nav-item"><a href="<?php echo base_url('pick_plan') ?>" class="nav-link" style="<?php echo ($url == 'pick-plan') ? 'background-color: #0B3954' : '' ?>">
							<i class="fas fa-retweet"></i>Renew Plan</a>
					</li>
				<?php endif; ?>

				<?php if ($this->session->userdata('rr_logged_in')) : ?>
					<li class="nav-item"><a href="<?php echo base_url('profile') ?>" class="nav-link" style="<?php echo ($url == 'profile') ? 'background-color: #0B3954' : '' ?>">
							<i class="fas fa-user-edit"></i>Profile</a>
					</li>
					<li class="nav-item"><a href="<?php echo base_url('rating') ?>" class="nav-link" style="<?php echo ($url == 'rating') ? 'background-color: #0B3954' : '' ?>">
							<i class="fas fa-link"></i>Send Link</a>
					</li>
				<?php endif; ?>

				<?php if (!$this->session->userdata('rr_logged_in')) : ?>
					<li class="nav-item"><a href="<?php echo base_url('login') ?>" class="nav-link text-light" style="<?php echo ($url == 'login') ? 'background-color: #0B3954' : '' ?>">
							<i class="fas fa-user"></i>Login</a>
					</li>

					<li class="nav-item"><a href="<?php echo base_url('register') ?>" class="nav-link text-light" style="<?php echo ($url == 'register') ? 'background-color: #0B3954' : '' ?>">
							<i class="fas fa-plus-circle"></i>Register</a>
					</li>
				<?php endif; ?>

				<li class="nav-item"><a href="<?php echo base_url('support') ?>" class="nav-link text-light" style="<?php echo ($url == 'support') ? 'background-color: #0B3954' : '' ?>">
						<i class="fas fa-question-circle"></i>Support</a>
				</li>

				<?php if ($this->session->userdata('rr_logged_in')) : ?>
					<li class="nav-item"><a href="<?php echo base_url('logout') ?>" class="nav-link text-light">
							<i class="fas fa-sign-out-alt"></i>Logout</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>

	</nav>
	<div class="container">
		<?php if ($this->session->flashdata('small_bal_length')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('small_bal_length') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('acces_denied')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('acces_denied') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('quota_expired')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('quota_expired') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('sub_failed')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('sub_failed') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('reg_succ')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle text-success"></i>
				<strong><?php echo $this->session->flashdata('reg_succ') ?></strong>
			</div>
		<?php endif; ?>
		<?php if (form_error('subj') || form_error('body') || form_error('email') || form_error('uname') || form_error('pwd')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong>Please fill in all fields</strong>
			</div>
		<?php endif; ?>
		<?php if (form_error('sentcode')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong>Verification code is required to activate your account</strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('link_send_err')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('link_send_err') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('payment_save_err')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('payment_save_err') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('link_send_succ')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle text-success"></i>
				<strong><?php echo $this->session->flashdata('link_send_succ') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('sms_link_send_err')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('sms_link_send_err') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('sms_link_send_succ')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle text-success"></i>
				<strong><?php echo $this->session->flashdata('sms_link_send_succ') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('login_now')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle text-success"></i>
				<strong><?php echo $this->session->flashdata('login_now') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('loginfirst')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('loginfirst') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('logout_first')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('logout_first') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('login_first')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('login_first') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('invalid_login')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('invalid_login') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('valid_login')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle text-success"></i>
				<strong><?php echo $this->session->flashdata('valid_login') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('reg_failed')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('reg_failed') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('adduser_emailndmobile_code')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle text-success"></i>
				<strong><?php echo $this->session->flashdata('adduser_emailndmobile_code') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('adduser_email_code')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle text-success"></i>
				<strong><?php echo $this->session->flashdata('adduser_email_code') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('adduser_mobile_code')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle text-success"></i>
				<strong><?php echo $this->session->flashdata('adduser_mobile_code') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('email_code')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle text-success"></i>
				<strong><?php echo $this->session->flashdata('email_code') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('update_failed')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('update_failed') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('update_succ')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-success"></i>
				<strong><?php echo $this->session->flashdata('update_succ') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('user_updated')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-success"></i>
				<strong><?php echo $this->session->flashdata('user_updated') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('user_deleted')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-success"></i>
				<strong><?php echo $this->session->flashdata('user_deleted') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('log_out')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('log_out') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('cntc_us_succ')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-success"></i>
				<strong><?php echo $this->session->flashdata('cntc_us_succ') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('cntc_us_err')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('cntc_us_err') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('rating_succ')) : ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-exclamation-circle text-success"></i>
				<strong><?php echo $this->session->flashdata('rating_succ') ?></strong>
			</div>
		<?php endif; ?>
		<?php if ($this->session->flashdata('rating_err')) : ?>
			<div class="alert alert-danger">
				<button class="close" data-dismiss="alert">&times;</button>
				<i class="fas fa-check-circle text-danger"></i>
				<strong><?php echo $this->session->flashdata('rating_err') ?></strong>
			</div>
		<?php endif; ?>
	</div>