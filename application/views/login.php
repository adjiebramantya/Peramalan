<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Login - Peramalan</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="<?php echo base_url()?>assets/img/icon.ico" type="image/x-icon"/>

	<!-- Fonts and icons -->
  <?php $this->load->view('_partial/css.php') ?>
</head>
<body class="login">
	<div class="wrapper wrapper-login">
		<div class="container container-login animated fadeIn">

			<h2 class="text-center">Sistem Peramalan</h2>
			<h3 class="text-center">Silahkan Login</h3>
			<?php if ($this->session->flashdata('success')): ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<?= $this->session->flashdata('success'); ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php endif; ?>
			<form class="" action="<?= base_url('Auth/aksi_login')?>" method="post">
				<div class="login-form">
					<div class="form-group form-floating-label">
						<input id="username" name="username" type="text" class="form-control input-border-bottom" required>
						<label for="username" class="placeholder">Username</label>
					</div>
					<div class="form-group form-floating-label">
						<input id="password" name="password" type="password" class="form-control input-border-bottom" required>
						<label for="password" class="placeholder">Password</label>
						<div class="show-password">
							<i class="icon-eye"></i>
						</div>
					</div>
					<div class="row form-sub m-0">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="rememberme">
							<label class="custom-control-label" for="rememberme">Remember Me</label>
						</div>
					</div>
					<div class="form-action mb-3">
						<button type="submit" class="btn btn-primary btn-rounded btn-login">Login</button>
					</div>
					<!-- <div class="login-account">
						<span class="msg">Don't have an account yet ?</span>
						<a href="#" id="show-signup" class="link">Sign Up</a>
					</div> -->
				</div>
			</form>
		</div>

		<div class="container container-signup animated fadeIn">
			<h3 class="text-center">Sign Up</h3>
			<form class="" action="<?= base_url('Auth/register')?>" method="post">
				<div class="login-form">
					<div class="form-group form-floating-label">
						<input  id="fullname" name="fullname" type="text" class="form-control input-border-bottom" required>
						<label for="fullname" class="placeholder">Nama Lengkap</label>
					</div>
					<div class="form-group form-floating-label">
						<input  id="email" name="email" type="email" class="form-control input-border-bottom" required>
						<label for="email" class="placeholder">Email</label>
					</div>
					<div class="form-group form-floating-label">
						<input  id="nohp" name="nohp" type="number" class="form-control input-border-bottom" required>
						<label for="nohp" class="placeholder">No. Hp</label>
					</div>
					<div class="form-group form-floating-label">
						<input  id="username" name="username" type="text" class="form-control input-border-bottom" required>
						<label for="username" class="placeholder">username</label>
					</div>
					<div class="form-group form-floating-label">
						<input  id="passwordsignin" name="passwordsignin" type="password" class="form-control input-border-bottom" required>
						<label for="passwordsignin" class="placeholder">Password</label>
						<div class="show-password">
							<i class="icon-eye"></i>
						</div>
					</div>
					<div class="row form-sub m-0">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" name="agree" id="agree">
							<label class="custom-control-label" for="agree">I Agree the terms and conditions.</label>
						</div>
					</div>
					<div class="form-action">
						<a href="#" id="show-signin" class="btn btn-danger btn-link btn-login mr-3">Cancel</a>
						<button type="submit" class="btn btn-primary btn-rounded btn-login">Sign Up</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php $this->load->view('_partial/js.php') ?>
</body>
</html>
