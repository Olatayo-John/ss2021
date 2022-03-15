$(document).ready(function() {
	$('button.updatebtn').click(function() {
		// e.preventDefault();
		var full_name= $('.full_name').val();		
		var mobile= $('.mobile').val();			

		if (full_name == "" || full_name == null) {
			$('.full_name').css('border','2px solid red');
			return false;
		}else{
			$('.full_name').css('border','0 solid red');
		}
		if (mobile == "" || mobile == null) {
			$('.mobile').css('border','2px solid red');
			return false;
		}else{
			$('.mobile').css('border','0 solid red');
		}
		$.ajax({
			success: function() {
				$('.updatebtn').attr('disabled','disabled');
				$('.updatebtn').html('Updating...');
				$('.updatebtn').css('cursor','not-allowed');
				$('.updatebtn').removeClass('btn-info').addClass('btn-danger');
			}
		});
	});
});