<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Ramal - Peramalan</title>
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
						<h4 class="page-title">Peramalan</h4>
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
								<a href="<?php echo base_url('produk') ?>">Peramalan</a>
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
										<h4 class="card-title">Ramalan Produk</h4>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Nomor</th>
													<th>Nama Produk</th>
													<th style="width: 15%">Jenis Produk</th>
													<th style="width: 10%">Action</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Nomor</th>
													<th>Nama Produk</th>
													<th>Jenis Produk</th>
													<th>Action</th>
												</tr>
											</tfoot>
											<tbody>
												<?php
												$no = 1;
												foreach($produk as $p){
												?>
												<tr>
													<td><?php echo $no++ ?></td>
													<td><?php echo $p->nama_produk ?></td>
													<td><?php echo $p->jenis_produk ?></td>
													<td>
														<div class="form-button-action">
															<a type="button" data-toggle="modal" title="" data-target="#modal_edit<?php echo $p->id_produk?>" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
																<i class="fa fa-chart-line"></i>
															</a>
														</div>
													</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
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

  <script type="text/javascript">
  // Add Row
    $('#add-row').DataTable({
      "pageLength": 10,
    });
  </script>

	<!-- Atlantis DEMO methods, don't include it in your project! -->
</body>
</html>
