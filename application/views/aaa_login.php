<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login CBT</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="description" content="AUMadrasah">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>upload/gambar_lembaga/<?php echo $lembaga['lembaga_foto']; ?>">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>___/_login/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>___/_login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>___/_login/fonts/iconic/css/material-design-iconic-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>___/_login/vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>___/_login/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>___/_login/vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>___/_login/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>___/_login/vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>___/_login/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>___/_login/css/main.css">
	<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>___/js/plugin/sweetalert/sweetalert.min.js"></script>
</head>

<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<!-- <form action="" method="post" name="fl" id="f_login" onsubmit="return login();"> -->
				<?php echo form_open(base_url() . 'adm/act_login', "class='form-horizontal'"); ?>
				<span class="login100-form-title p-b-48">
					<img src="../upload/gambar_lembaga/<?php echo $lembaga['lembaga_foto'] ?>" width="100">
				</span>
				<span class="login100-form-title p-b-24">
					LOGIN CBT
				</span>
				<div class="wrap-input100 validate-input">
					<span class="btn-show-pass">
						<i class="zmdi zmdi-assignment-account"></i>
					</span>
					<input class="input100" type="text" id="username" name="username" autofocus required>
					<span class="focus-input100" data-placeholder="Username"></span>
				</div>
				<div class="wrap-input100 validate-input" data-validate="password">
					<span class="btn-show-pass">
						<i class="zmdi zmdi-eye"></i>
					</span>
					<input class="input100" type="password" id="password" name="password" required>
					<span class="focus-input100" data-placeholder="Password"></span>
				</div>
				<div class="container-login100-form-btn">
					<div class="wrap-login100-form-btn">
						<div class="login100-form-bgbtn"></div>
						<button type="submit" class="login100-form-btn" name="btn">
							Masuk
						</button>
					</div>
					<p class="mt-2">Lupa Password? Hubungi proktor!</p>
				</div>
				</form>
			</div>
		</div>
	</div>

	<script src="<?php echo base_url(); ?>___/_login/vendor/jquery/jquery-3.5.1.js"></script>
	<script src="<?php echo base_url(); ?>___/_login/vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>___/_login/vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo base_url(); ?>___/_login/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>___/_login/vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>___/_login/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>___/_login/vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>___/_login/vendor/countdowntime/countdowntime.js"></script>
	<script src="<?php echo base_url(); ?>___/_login/js/main.js"></script>
	<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>___/js/aplikasi.js"></script>
	<script type="text/javascript">
		base_url = "<?php echo base_url(); ?>";
		uri_js = "<?php echo $this->config->item('uri_js'); ?>";
	</script>
</body>

</html>