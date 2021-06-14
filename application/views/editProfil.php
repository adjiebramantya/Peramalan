<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Profil - Peramalan</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="<?php echo base_url()?>assets/img/icon.ico" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<link rel="stylesheet" href="<?php echo base_url()?>assets/css/select2.min.css">

	<script type='text/javascript' src="<?php echo base_url();?>assets/js/core/jquery.3.4.1.js" integrity="" crossorigin="anonymous"></script>
	<script type='text/javascript' src="<?php echo base_url();?>assets/js/plugin/select2/select2.full.js"></script>
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
						<h4 class="page-title">Edit Profil</h4>
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
								<a href="<?php echo base_url('profil') ?>">Edit Profil</a>
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
										<h4 class="card-title">Profil</h4>
									</div>
								</div>
								<div class="card-body">

									<!-- Modal -->
									<!-- end Modal -->
									<?php if ($this->session->flashdata('success')): ?>
										<div class="alert alert-success alert-dismissible fade show" role="alert">
												<?= $this->session->flashdata('success'); ?>
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
									<?php endif; ?>


									<?php
									foreach($profil as $p):
											$id_user=$p->id_user;
											$nama=$p->nama;
											$email=$p->email;
											$nohp=$p->nohp;
											$username=$p->username;
											$password=$p->password;
									?>
									<form action="<?= base_url('profil/edit_profil')?>" method="POST">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group form-group-default" hidden>
													<label>id</label>
													<input id="id_user" name="id_user" type="text" class="form-control" placeholder="Masukkan id" value="<?php echo $id_user;?>">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group form-group-default">
													<label>Email</label>
													<input id="email" name="email" type="email" class="form-control" placeholder="Masukkan Email" value="<?php echo $email;?>">
												</div>
												<div class="form-group form-group-default">
													<label>Nama Lengkap</label>
													<input id="nama" name="nama" type="text" class="form-control" placeholder="Masukkan Nama Lengkap" value="<?php echo $nama;?>">
												</div>
												<div class="form-group form-group-default">
													<label>No. Hp</label>
													<input id="nohp" name="nohp" type="number" class="form-control" placeholder="Masukkan Nomer HP" value="<?php echo $nohp;?>">
												</div>
												<div class="form-group form-group-default">
													<label>username</label>
													<input id="username" name="username" type="text" class="form-control" placeholder="Masukkan username" value="<?php echo $username;?>">
												</div>
												<div class="form-group form-group-default">
													<label>password</label>
													<input id="password" name="password" type="password" class="form-control" placeholder="Kosongi, Jika password tidak ingin diganti.">
												</div>
											</div>
										</div>
										<div class="row justify-content-center">
											<button type="submit" id="addRowButton" class="btn btn-primary"><i class="fa fa-edit"></i> Edit Profil</button>
										</div>
									</form>
									<?php endforeach;?>

									<!-- <div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Tanggal</th>
													<th>Nama Produk</th>
													<th>Jumlah</th>
													<th style="width: 10%">Action</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Tanggal</th>
													<th>Nama Produk</th>
													<th>Jumlah</th>
													<th style="width: 10%">Action</th>
												</tr>
											</tfoot>
											<tbody >

											</tbody>
										</table>
									</div> -->
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

      <?php $this->load->view('_partial/jsNoQuery') ?>

  <script type="text/javascript">
  // Add Row
    $('#add-row').DataTable({
      "pageLength": 10,
    });

		//Select 2
		$(document).ready(function() {
				$('#js-example-basic-single').select2({width: 'resolve'});
		});

  </script>



	<!-- Atlantis DEMO methods, don't include it in your project! -->
</body>
</html>
