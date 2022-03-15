<button onclick="topFunction()" id="scrollbtn" class="btn text-light" style="width: 70px"><i class="fas fa-caret-up mr-2"></i>Top</button>

<style type="text/css">
	#scrollbtn {
		background-color: #0B3954;
		display: none;
		position: fixed;
		bottom: 10px;
		right: 15px;
		z-index: 99;
		border: none;
		outline: none;
		cursor: pointer;
		font-size: 17px;
	}

	button#scrollbtn:hover {
		transform: scale(1.1);
		cursor: pointer;
		transition: transform .3s;
	}
</style>

<script type="text/javascript">
	mybutton = document.getElementById("scrollbtn");
	window.onscroll = function() {
		scrollFunction();
	};

	function scrollFunction() {
		if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
			mybutton.style.display = "block";
		} else {
			mybutton.style.display = "none";
		}
	}

	function topFunction() {
		document.body.scrollTop = 0;
		document.documentElement.scrollTop = 0;
	}

	function opennav() {
		document.getElementById('side-nav').style.width = "180px";

	}

	function closenav() {
		document.getElementById('side-nav').style.width = "0";

	}
	// setTimeout(() => document.querySelector('div.alert').remove(), 6000);
</script>
</body>

</html>