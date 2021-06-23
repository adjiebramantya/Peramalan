<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Hasil Ramal - Peramalan</title>
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
						<h4 class="page-title">Hasil Ramalan</h4>
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
								<a href="">Ramal Produk</a>
							</li>
						</ul>
					</div>
					</div>
				</div>

				<!-- RUMUS TRIPLE EXPONENTIAL SMOOTHING -->

				<!-- END RUMUS TRIPLE EXPONENTIAL SMOOTHING -->

				<div class="page-inner mt--5">
					<div class="row mt--2">
						<div class="col-md-6">
							<div class="card full-height">
								<div class="card-body">
									<div class="card-title">Statistik Keseluruhan</div>
									<div class="d-flex flex-wrap justify-content-left pb-2 pt-4">
										<?php if (isset($produk)): ?>
											<div class="px-2 pb-2 pb-md-0">
												<h3 class="fw-bold mt-3 mb-0">Nama Produk : &nbsp <?php echo $produk->nama_produk ?></h3>
											</div>
										<?php endif; ?>
									</div>
									<div class="d-flex flex-wrap justify-content-left pb-1 pt-2">
									<?php if (isset($hasilMAD)): ?>
										<div class="px-2 pb-2 pb-md-0">
											<h6 class="fw-bold mt-3 mb-0">MAD : &nbsp <?php echo $hasilMAD ?></h6>
										</div>
									<?php endif; ?>
									</div>
									<div class="d-flex flex-wrap justify-content-left pb-1 pt-2">
									<?php if (isset($hasilMSE)): ?>
										<div class="px-2 pb-2 pb-md-0">
											<h6 class="fw-bold mt-3 mb-0">MSE : &nbsp <?php echo $hasilMSE ?></h6>
										</div>
									<?php endif; ?>
									</div>
									<div class="d-flex flex-wrap justify-content-left pb-1 pt-2">
									<?php if (isset($hasilMAPE)): ?>
										<div class="px-2 pb-2 pb-md-0">
											<h6 class="fw-bold mt-3 mb-0">MAPE : &nbsp <?php echo $hasilMAPE ?> %</h6>
										</div>
									<?php endif; ?>
									</div>
									<div class="d-flex flex-wrap justify-content-left pb-1 pt-2">
									<?php if (isset($ratarataKesalahan)): ?>
										<div class="px-2 pb-2 pb-md-0">
											<h6 class="fw-bold mt-3 mb-0">Rata - rata Kesalahan : &nbsp <?php echo $ratarataKesalahan ?></h6>
										</div>
									<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="card full-height">
								<div class="card-header">
									<div class="card-title">Grafik Keseluruhan</div>
								</div>
								<div class="card-body">
									<div id="chart-container" style="height:350px">
										<canvas id="multipleLineChart"></canvas>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="card full-height">
								<div class="card-header">
									<div class="card-title">Tabel Keseluruhan</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="add-row" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Bulan</th>
													<th>Jumlah Aktual</th>
													<th>Office</th>
													<th style="width: 10%">Action</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Bulan</th>
													<th>Jumlah Aktual</th>
													<th>Office</th>
													<th>Action</th>
												</tr>
											</tfoot>
											<tbody>
											<?php foreach ($ramal as $data): ?>
												<tr>
													<td>
														<?php echo $data['bulan'] ?>
													</td>
													<td>
														<?php echo $data['aktual'] ?>
													</td>
													<td>Edinburgh</td>
													<td>
														<div class="form-button-action">
															<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Ramalkan">
																<i class="fas fa-chart-line"></i>
															</button>
															<button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove">
																<i class="fa fa-times"></i>
															</button>
														</div>
													</td>
												</tr>
											<?php endforeach; ?>
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

	<?php
		foreach ($bulan as $data) {
			$nama_bulan .="'$data'".", ";
		}
	 ?>

	 <?php
		 foreach ($aktual as $data) {
			 $aktualGrafik .="'$data'".", ";
		 }
		?>

		<?php
			foreach ($ft as $data) {
				$ftGrafik .="'$data'".", ";
			}
		 ?>

  <script type="text/javascript">
  // Add Row
    $('#add-row').DataTable({
      "pageLength": 10,
    });

//Chart
var multipleLineChart = document.getElementById('multipleLineChart').getContext('2d');

var myMultipleLineChart = new Chart(multipleLineChart, {
	type: 'line',
	data: {
		labels: [<?php echo $nama_bulan;?>,"hasil"],
		datasets: [{
			label: "Aktual",
			borderColor: "#1d7af3",
			pointBorderColor: "#FFF",
			pointBackgroundColor: "#1d7af3",
			pointBorderWidth: 1,
			pointHoverRadius: 2,
			pointHoverBorderWidth: 1,
			pointRadius: 2,
			backgroundColor: 'transparent',
			fill: true,
			borderWidth: 2,
			data: [<?php echo $aktualGrafik;?>]
		},{
			label: "Hasil Ramal",
			borderColor: "#59d05d",
			pointBorderColor: "#FFF",
			pointBackgroundColor: "#59d05d",
			pointBorderWidth: 1,
			pointHoverRadius: 2,
			pointHoverBorderWidth: 1,
			pointRadius: 2,
			backgroundColor: 'transparent',
			fill: true,
			borderWidth: 2,
			data: [ ,<?php echo $ftGrafik;?>]
		}]
	},
	options : {
		responsive: true,
		maintainAspectRatio: false,
		legend: {
			position: 'top',
		},
		tooltips: {
			bodySpacing: 4,
			mode:"nearest",
			intersect: 0,
			position:"nearest",
			xPadding:10,
			yPadding:10,
			caretPadding:10
		},
		layout:{
			padding:{left:15,right:15,top:15,bottom:15}
		}
	}
});
  </script>

	<!-- Atlantis DEMO methods, don't include it in your project! -->
</body>
</html>
