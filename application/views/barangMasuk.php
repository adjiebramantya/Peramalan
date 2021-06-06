<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Produk - Peramalan</title>
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
						<h4 class="page-title">Barang Masuk</h4>
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
								<a href="<?php echo base_url('produk') ?>">Barang Masuk</a>
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
										<h4 class="card-title">Barang Masuk</h4>
										<button class="btn btn-success btn-round ml-auto" data-toggle="modal" data-target="#addRowModal">
											<i class="fa fa-plus"></i>
											Barang Masuk
										</button>
									</div>
								</div>
								<div class="card-body">
									<!-- Modal -->
									<div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header no-bd">
													<h5 class="modal-title">
														<span class="fw-mediumbold">
														Barang</span>
														<span class="fw-light">
														Masuk
														</span>
													</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<form action="<?= base_url('barangmasuk/tambah_barangMasuk')?>" method="POST">
														<div class="row">
															<div class="col-sm-12">
																<div class="form-group form-group-default">
																	<label>Nama Produk</label>
																	<select id="js-example-basic-single" name="id_produk" style="width: 100%">
																		<option value="">&nbsp;</option>
																		<optgroup label="Satuan">
																			<?php foreach($orderBySatuan as $satuan){ ?>
																				<option value="<?php echo $satuan->id_produk; ?>"><?php echo $satuan->nama_produk; ?></option>
																			<?php } ?>
																		</optgroup>
																		<optgroup label="Paket">
																			<?php foreach($orderByPaket as $paket){ ?>
																				<option value="<?php echo $paket->id_produk; ?>"><?php echo $paket->nama_produk; ?></option>
																			<?php } ?>
																		</optgroup>
																	</select>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group form-group-default">
																	<label>Tanggal</label>
																	<input id="tanggal" name="tanggal" type="date" class="form-control" placeholder="Masukkan Tanggal">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group form-group-default">
																	<label>Jumlah</label>
																	<input id="jumlah" name="jumlah" type="number" class="form-control" placeholder="Masukkan Stok" value="1">
																</div>
															</div>
														</div>
												</div>
												<div class="modal-footer no-bd">
													<button type="submit" id="addRowButton" class="btn btn-primary">Tambah</button>
													<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
												</div>
												</form>
											</div>
										</div>
									</div>

									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>No.</th>
													<th>Tanggal</th>
													<th>Nama Produk</th>
													<th>Jumlah</th>
													<th style="width: 10%">Action</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>No.</th>
													<th>Tanggal</th>
													<th>Nama Produk</th>
													<th>Jumlah</th>
													<th style="width: 10%">Action</th>
												</tr>
											</tfoot>
											<tbody>
												<?php
												$no = 1;
												foreach($jumlah_transaksi as $p){
												?>
												<tr>
													<td><?php echo $no++ ?></td>
													<td><?php echo $p->tanggal ?></td>
													<td><?php echo $p->nama_produk ?></td>
													<td><?php echo $p->jumlah ?></td>
													<td>
														<div class="form-button-action">
															<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
																<i class="fa fa-edit"></i>
															</button>
															<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
																<i class="fa fa-times"></i>
															</button>
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
