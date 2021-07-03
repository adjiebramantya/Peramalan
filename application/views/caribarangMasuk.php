<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Barang Masuk - Peramalan</title>
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
										<h4 class="card-title">Hasil Sorting Barang Masuk</h4>
									</div>
								</div>
								<div class="card-body">

									<?php if ($this->session->flashdata('success')): ?>
										<div class="alert alert-success alert-dismissible fade show" role="alert">
												<?= $this->session->flashdata('success'); ?>
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
									<?php endif; ?>
									<div class="table-responsive">
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
											<tbody>
												<?php
												foreach($caribarangMasuk as $p){
												?>
												<tr>
													<td><?php echo $p->tanggal ?></td>
													<td><?php echo $p->nama_produk ?></td>
													<td><?php echo $p->jumlah ?></td>
													<td>
														<div class="form-button-action">
															<a type="button" data-toggle="modal" title="" data-target="#modal_edit<?php echo $p->id_masuk?>" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
																<i class="fa fa-edit"></i>
															</a>
															<a type="button" data-toggle="modal" title="" data-target="#modal_hapus<?php echo $p->id_masuk?>" class="btn btn-link btn-danger" data-original-title="Remove">
																<i class="fa fa-times"></i>
															</a>
														</div>
													</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>

									<!-- Modal Edit -->
									<?php
									foreach($caribarangMasuk as $p):
											$id_masuk=$p->id_masuk;
											$tanggal=$p->tanggal;
											$id_produk=$p->id_produk;
											$nama_produk=$p->nama_produk;
											$jumlah=$p->jumlah;
									?>

									<div class="modal fade" id="modal_edit<?php echo $id_masuk;?>" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header no-bd">
													<h5 class="modal-title">
														<span class="fw-mediumbold">
														Edit </span>
														<span class="fw-light">
														Barang Masuk
														</span>
													</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
													<form action="<?= base_url('barangmasuk/edit_barangMasuk/'.$id_masuk)?>" method="POST">
														<div class="row">
															<div class="" hidden>
																<input type="text" name="id_masuk" value="<?php echo $id_masuk; ?>">
															</div>
															<div class="col-sm-12">
																<div class="form-group form-group-default">
																	<label>Nama Produk</label>
																	<select id="js-example-basic-single" name="id_produk" style="width: 100%">
																		<?php if (isset($produk)): ?>
																				<option value="<?php echo $id_produk;?>" <?php if($produk->id_produk == $id_produk) echo 'selected="selected"';?> ><?php echo $nama_produk ?></option>
																		<?php endif; ?>
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
																	<input id="tanggal" name="tanggal" type="date" class="form-control" placeholder="Masukkan Tanggal" >
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group form-group-default">
																	<label>Jumlah</label>
																	<input id="jumlah" name="jumlah" type="number" class="form-control" placeholder="Masukkan Stok" value="<?php echo $jumlah ?>">
																</div>
															</div>
														</div>
												</div>
												<div class="modal-footer no-bd">
													<button type="submit" id="addRowButton" class="btn btn-primary">Edit</button>
													<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
												</div>
												</form>
											</div>
										</div>
									</div>
									<?php endforeach;?>
									<!-- end Modal -->

									<!-- ============ MODAL HAPUS BARANG =============== -->
		 						 <?php
								 foreach($caribarangMasuk as $p):
										 $id_masuk=$p->id_masuk;
										 $tanggal=$p->tanggal;
										 $nama_produk=$p->nama_produk;
										 $jumlah=$p->jumlah;
		 						 ?>
		 				        <div class="modal fade" id="modal_hapus<?php echo $id_masuk;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
		 				            <div class="modal-dialog">
		 				            <div class="modal-content">
		 											<div class="modal-header">
		 												<h5 class="modal-title">Hapus Produk</h5>
		 												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		 													<span aria-hidden="true">&times;</span>
		 												</button>
		 											</div>
		 				            <form class="form-horizontal" method="post" action="<?= base_url('barangmasuk/hapus_barangMasuk/'.$id_masuk)?>">
		 				                <div class="modal-body">
		 				                    <p>Anda yakin mau menghapus <b><?php echo $nama_produk;?></b></p>
		 				                </div>
		 				                <div class="modal-footer">
		 				                    <!-- <input type="hidden" name="kode_barang" value=""> -->
		 														<button type="submit" class="btn btn-danger">Hapus</button>
		 				                    <button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
		 				                </div>
		 				            </form>
		 				            </div>
		 				            </div>
		 				        </div>
		 				    		<?php endforeach;?>
		 				    		<!-- END MODAL HAPUS BARANG -->
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
	//Select 2
	$(document).ready(function() {
			$('#js-example-basic-single').select2({width: 'resolve'});
	});

	// Add Row
    $('#add-row').DataTable({
      "pageLength": 10,
    });


  </script>



	<!-- Atlantis DEMO methods, don't include it in your project! -->
</body>
</html>
