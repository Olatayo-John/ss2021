$(document).ready(function() {
	$(document).on('click','.star_r',function(e) {
		e.preventDefault();
		$('.star_r_div').show();
		$('.ques_r_div').hide();
	});

	$(document).on('click','.ques_r',function(e) {
		e.preventDefault();
		$('.star_r_div').hide();
		$('.ques_r_div').show();
	});
});