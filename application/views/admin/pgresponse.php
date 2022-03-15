<div class="container">
	<h1 class="text-center mt-3 mb-5">Please do not refresh this page...</h1>
	<div class="spinner-border" role="status">
		<span class="sr-only">Loading...</span>
	</div>
	<form method="post" action="<?php echo PAYTM_TXN_URL ?>" name="f1" class="f1">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_token">
		<?php foreach ($paytm_info as $name => $value) : ?>
			<input type="hidden" name="<?php echo $name ?>" value="<?php echo $value ?>" class="form-control">
		<?php endforeach; ?>
		<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>" class="form-control">
	</form>
</div>

<script type="text/javascript">
	$(document).ready(function(e) {
		// e.preventDefault();
		var user_id = "<?php echo $this->session->userdata('rr_id'); ?>";
		var user_form_key = "<?php echo $this->session->userdata('rr_form_key'); ?>";

		if (user_id !== "" && user_form_key !== "") {
			$('form.f1').submit();
		} else {
			var protocol = window.location.protocol;
			var url_redirect = window.location.hostname + "/ss2021/admin/pick_plan";
			// var url_redirect = window.location.hostname + "/ss21/gzb/admin/pick_plan";
			var new_url = protocol + "//" + url_redirect;
			window.location.assign(new_url);
		}

	});
</script>