<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Produk - Peramalan</title>
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
										<h4 class="card-title">Tabel Produk</h4>
										<?php if (validation_errors()) {?>
												 <div class="alert alert-warning alert-dismissible fade show" role="alert">
												  <strong>Perhatian!!</strong> <?php echo validation_errors(); ?>
												  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												    <span aria-hidden="true">&times;</span>
												  </button>
												</div>
										<?php } ?>
										<button class="btn btn-success btn-round ml-auto" data-toggle="modal" data-target="#addRowModal">
											<i class="fa fa-plus"></i>
											Tambah Produk
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
														Tambah</span>
														<span class="fw-light">
														Produk
														</span>
													</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form action="<?= base_url('produk/tambah_produk')?>" method="POST">
												<div class="modal-body">
														<div class="row">
															<div class="col-sm-12">
																<div class="form-group form-group-default">
																	<label>Nama Produk</label>
																	<input id="nama_produk" name="nama_produk" type="text" class="form-control" placeholder="Masukkan Nama Produk">
																</div>
															</div>
															<div class="col-md-6 pr-0">
																<div class="form-group form-group-default">
																	<label for="exampleFormControlSelect2">Jenis Produk</label>
																	<select class="form-control" name="jenis_produk" id="exampleFormControlSelect2">
															      <option value="1">Paket</option>
															      <option value="2">Satuan</option>
															    </select>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group form-group-default">
																	<label>Harga</label>
																	<input id="harga" name="harga" type="number" class="form-control" placeholder="Masukkan Harga">
																</div>
															</div>
														</div>
												</div>

												<div class="modal-footer no-bd">
													<button type="submit" id="addRowButton" class="btn btn-primary">Tambah</button>
													<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
												</div>
												</form>
											</div>
										</div>
									</div>

									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Nomor</th>
													<th>Nama Produk</th>
													<th style="width: 15%">Jenis Produk</th>
													<th style="width: 15%">Harga</th>
													<th style="width: 10%">Action</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Nomor</th>
													<th>Nama Produk</th>
													<th>Jenis Produk</th>
													<th>Harga</th>
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
													<td>Rp. <?php echo number_format($p->harga) ?></td>
													<td>
														<div class="form-button-action">
															<a type="button" data-toggle="modal" title="" data-target="#modal_edit<?php echo $p->id_produk?>" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task">
																<i class="fa fa-edit"></i>
															</a>
															<a type="button" data-toggle="modal" title="" data-target="#modal_hapus<?php echo $p->id_produk?>" class="btn btn-link btn-danger" data-original-title="Remove">
																<i class="fa fa-times"></i>
															</a>
														</div>
													</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>

								<!-- ============ MODAL Edit BARANG =============== -->
								<?php
								foreach($produk as $p):
										$id_produk=$p->id_produk;
										$id_jenis=$p->id_jenis;
										$nama_produk=$p->nama_produk;
										$jenis_produk=$p->jenis_produk;
										$harga=$p->harga;
								?>
								<div class="modal fade" id="modal_edit<?php echo $id_produk;?>" tabindex="-1" role="dialog" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header no-bd">
												<h5 class="modal-title">
													<span class="fw-mediumbold">
													Edit</span>
													<span class="fw-light">
													Produk
													</span>
												</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<form action="<?= base_url('produk/edit_produk/<?php echo $id_produk?>')?>" method="POST">
											<div class="modal-body">
													<div class="row">
														<div class="col-sm-12">
															<div class="form-group form-group-default" hidden>
																<label>ID Produk</label>
																<input id="id_produk" name="id_produk" type="text" class="form-control" placeholder="Masukkan ID Produk" value="<?php echo $id_produk;?>">
															</div>
															<div class="form-group form-group-default">
																<label>Nama Produk</label>
																<input id="nama_produk" name="nama_produk" type="text" class="form-control" placeholder="Masukkan Nama Produk" value="<?php echo $nama_produk;?>">
															</div>
														</div>
														<div class="col-md-6 pr-0">
															<div class="form-group form-group-default">
																<label for="exampleFormControlSelect2">Jenis Produk</label>
																<select class="form-control" name="jenis_produk" id="exampleFormControlSelect2">
																	<option value="1">Paket</option>
																	<option value="2">Satuan</option>
																</select>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group form-group-default">
																<label>Harga</label>
																<input id="harga" name="harga" type="number" class="form-control" placeholder="Masukkan Harga" value="<?php echo $harga;?>">
															</div>
														</div>
													</div>
											</div>

											<div class="modal-footer no-bd">
												<button type="submit" id="addRowButton" class="btn btn-primary">Edit</button>
												<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
											</div>
											</form>
										</div>
									</div>
								</div>
								<?php endforeach;?>
								<!-- END MODAL Edit BARANG -->

				     <!-- ============ MODAL HAPUS BARANG =============== -->
						 <?php
						 foreach($produk as $p):
								 $id_produk=$p->id_produk;
								 $nama_produk=$p->nama_produk;
								 $jenis_produk=$p->jenis_produk;
								 $harga=$p->harga;
						 ?>
				        <div class="modal fade" id="modal_hapus<?php echo $id_produk;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
				            <div class="modal-dialog">
				            <div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title">Hapus Produk</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div
				            <form class="form-horizontal" method="post" action="<?= base_url('produk/hapus_produk/<?php echo $id_produk?>')?>">
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
      <?php $this->load->view('_partial/footer') ?>
		</div>

		<!-- Custom template | don't include it in your project! -->
		<!-- End Custom template -->
	</div>
  <?php $this->load->view('_partial/js') ?>

  <script type="text/javascript">
  // Add Row
    $('#add-row').DataTable({
      "pageLength": 10,
    });

  </script>

	<!-- Atlantis DEMO methods, don't include it in your project! -->
</body>
</html>
