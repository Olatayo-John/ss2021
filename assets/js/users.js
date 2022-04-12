$(document).ready(function () {
	$('.addnewuserbtn').click(function () {
		$('.addusermodal').modal('show');
	});

	$('.closemodalbtn').click(function () {
		$('.addusermodal').modal('hide');
	});

	$('.closeupdatebtn').click(function () {
		$('.updateusermodal').modal('hide');
	});

	$('.u_pwd').click(function () {
		$('.pwderr').show();
	});

	$(document).on('click', '.genpwdbtn', function () {
		var length = 10;
		var charset = "abcdefghijklnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		var val = "";

		for (var i = 0, n = charset.length; i < length; ++i) {
			val += charset.charAt(Math.floor(Math.random() * n));
		}

		$('.u_pwd,.password').val(val);
	});

});