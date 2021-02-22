<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Edit Produk - Peramalan</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="<?php echo base_url()?>assets/img/icon.ico" type="image/x-icon"/>

	<!-- Fonts and icons -->
<?php $this->load->view('_partial/css.php') ?>
</head>
<body>
	<div class="wrapper">
    <?php $this->load->view('_partial/header.php') ?>

		<!-- Sidebar -->
    <?php $this->load->view('_partial/sidebar') ?>
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">
				<div class="panel-header">
					<div class="page-inner py-5">
            <div class="page-header">
						<h4 class="page-title">Produk</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="<?php echo base_url('dashboard') ?>">
									<i class="flaticon-home"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="<?php echo base_url('produk') ?>">Produk</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">Edit Produk</a>
							</li>
						</ul>
					</div>
					</div>
				</div>
				<div class="page-inner mt--5">
					<div class="row mt--2">
            <div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title">Edit Produk</h4>
									</div>
								</div>
								<div class="card-body">

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
      <?php $this->load->view('_partial/footer') ?>
		</div>

		<!-- Custom template | don't include it in your project! -->
		<!-- End Custom template -->
	</div>
	<?php $this->load->view('_partial/js.php') ?>

	<!-- Atlantis DEMO methods, don't include it in your project! -->
</body>
</html>
