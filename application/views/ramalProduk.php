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
				<?php

				$awal = $this->db->query('SELECT tanggal FROM barang_masuk order by tanggal asc')->row();
				$akhir = $this->db->query('SELECT tanggal FROM barang_masuk order by tanggal desc')->row();


				$starter = 0;
				$lb = 0;

				for ($t = date("Y", strtotime($awal->tanggal)); $t <= date("Y", strtotime($akhir->tanggal)); $t++) {
						if ($starter == 0) {
								$lb = date("m", strtotime($awal->tanggal));
						} else {
								$lb = 1;
						}

						for ($b = $lb; $b <= 13; $b++) {
								if ($b > 12) {
										$starter = 1;
										break;
								} else {
									if (isset($produk)) {
										$id_produk = $produk->id_produk;
									}

										$detail = $this->db->query("SELECT produk.nama_produk as nama_produk, YEAR(tanggal) as tahun, MONTH(tanggal) as Bulan, SUM(jumlah) as jumlah FROM barang_masuk JOIN produk ON barang_masuk.id_produk= produk.id_produk WHERE barang_masuk.id_produk = '$id_produk' AND MONTH(tanggal) = '".sprintf("%02d", $b)."' AND YEAR(tanggal) = '".sprintf("%02d", $t)."' GROUP BY MONTH(tanggal), YEAR(tanggal) ORDER BY tanggal asc")->row();

										if ($t == date("Y", strtotime($akhir->tanggal)) && $b > date("m", strtotime($akhir->tanggal))) {
												break;
										} else {
												if ($detail) {
														//echo sprintf("%02d", $b)."-".$t."==".$detail->nama_produk."|".$detail->jumlah."<br>";
														$aktual[]= $detail->jumlah;
														$bulan[] = sprintf("%02d",$b)." - ".$t;
												} else {
														//echo sprintf("%02d", $b)."-".$t."==".""."|"."0"."<br>";
														$aktual[]= 0;
														$bulan[] = sprintf("%02d",$b)." - ".$t;
												}
										}
								}
						}
				}

				$alpha = 0.1;

				$aktualInt = array_map('intval',$aktual);

				$nilaiAwal = array_slice( $aktual, 0,1);
				$nilaiAwalInt = array_map('intval',$nilaiAwal);

				//SMOOTHING 1
					$s1[]= $nilaiAwalInt[0];
					$s1Int = array_map('intval',$s1);

					for($i = 1;$i < count($aktualInt)+1;$i++)
						{
							$s1Int[$i]= round($alpha * $aktualInt[$i-1]+(1-$alpha) * $s1Int[$i-1],2);
						}

				//SMOOTHING 2
					$s2[]= $nilaiAwalInt[0];
					$s2Int = array_map('intval',$s2);

					for($i = 1;$i < count($s1Int);$i++)
						{
							$s2Int[$i]= round($alpha * $s1Int[$i]+(1-$alpha) * $s2Int[$i-1],2);
						}

				//SMOOTHING 3
					$s3[]= $nilaiAwalInt[0];
					$s3Int = array_map('intval',$s2);

					for($i = 1;$i < count($s2Int);$i++)
						{
							$s3Int[$i]= round($alpha * $s2Int[$i]+(1-$alpha) * $s3Int[$i-1],2);
						}

						//AT
							$at = array();
							$atInt = array_map('intval',$at);

							for($i = 1;$i < count($s1Int);$i++)
								{
									$atInt[$i]= round(3 * $s1Int[$i] - 3 * $s2Int[$i] + $s3Int[$i],2);
								}

						//BT
						$bt = array();
						$btInt = array_map('intval',$bt);

						for($i = 1;$i < count($s1Int);$i++)
							{
								$btInt[$i]= round($alpha/2*pow(1-$alpha,2)*((6-5*$alpha)*$s1Int[$i]-(10-8*$alpha)*$s2Int[$i]+(4-3*$alpha)*$s3Int[$i]),2);
							}

						//CT
							$ct = array();
							$ctInt = array_map('intval',$ct);

							for($i = 1;$i < count($s1Int);$i++)
								{
									$ctInt[$i]= round(pow($alpha,2)/pow(1-$alpha,2)*($s1Int[$i]-2*$s2Int[$i]+$s3Int[$i]),2);
								}

						//FT+M
							$ft = array();
							$ftInt = array_map('intval',$ft);

							for($i = 1;$i < count($atInt)+1;$i++)
								{
									$ftInt[$i]= round($atInt[$i]+$btInt[$i]*1+1/2*$ctInt[$i]*pow(1,2),0);
								}

						//at-ft
							$selisih = array();
							$selisihInt = array_map('intval',$selisih);

							for($i = 1;$i < count($aktualInt);$i++)
								{
									$selisihInt[$i]= $aktualInt[$i]-$ftInt[$i];
								}

						//(at-ft)2
							$selisihPangkat = array();
							$selisihPangkatInt = array_map('intval',$selisihPangkat);

							for($i = 1;$i < count($selisihInt)+1;$i++)
								{
									$selisihPangkatInt[$i]= pow($selisihInt[$i],2);
								}

					//abs((at-ft)/at)*100
						$selisihSeratus = array();
						$selisihSeratusInt = array_map('intval',$selisihSeratus);

						for($i = 1;$i < count($selisihInt)+1;$i++)
							{
								$selisihSeratusInt[$i]= abs($selisihInt[$i]/$aktualInt[$i]);
							}

					$jumlah= count(array_slice($aktualInt,1));
					$MAD = array_sum(array_map("abs",$selisihInt));
					$MSE = array_sum($selisihPangkatInt);
					$MAPE = round(array_sum($selisihSeratusInt),3);

					$hasilMAD = round($MAD / $jumlah,3);
					$hasilMSE = round($MSE / ($jumlah-1),3);
					$hasilMAPE= round($MAPE / $jumlah * 100,3);
					$hasilKeseluruhan = $hasilMAD + $hasilMSE + $hasilMAPE;
					$ratarataKesalahan = round($hasilKeseluruhan/3,3);
				// echo "<pre>";
				// 	print_r($nilaiAwalInt);
				// echo "</pre>";
				echo "<br>";
				echo "<p>AKtual</p>";
				echo "<pre>";
					print_r($bulan);
				echo "</pre>";
				echo "<p>S1</p>";
				echo "<pre>";
					print_r($s1Int);
				echo "</pre>";
				echo "<p>S2</p>";
				echo "<pre>";
					print_r($s2Int);
				echo "</pre>";
				echo "<p>S3</p>";
				echo "<pre>";
					print_r($s3Int);
				echo "</pre>";
				echo "<p>at</p>";
				echo "<pre>";
					print_r($atInt);
				echo "</pre>";
				echo "<p>bt</p>";
				echo "<pre>";
					print_r($btInt);
				echo "</pre>";
				echo "<p>ct</p>";
				echo "<pre>";
					print_r($ctInt);
				echo "</pre>";
				echo "<p>Ft+M</p>";
				echo "<pre>";
					print_r($ftInt);
				echo "</pre>";
				echo "<p>Selisih</p>";
				echo "<pre>";
					print_r($selisihInt);
				echo "</pre>";
				echo "<p>Selisih Absolute</p>";
				echo "<pre>";
					print_r(array_map("abs",$selisihInt));
				echo "</pre>";
				echo "<p>Selisih Pangkat</p>";
				echo "<pre>";
					print_r($selisihPangkatInt);
				echo "</pre>";
				echo "<p>Selisih Seratus</p>";
				echo "<pre>";
					print_r($selisihSeratusInt);
				echo "</pre>";
				echo "<p>MAD</p>";
				echo "<pre>";
					print_r($hasilMAD);
				echo "</pre>";
				echo "<p>MSE</p>";
				echo "<pre>";
					print_r($hasilMSE);
				echo "</pre>";
				echo "<p>MAPE</p>";
				echo "<pre>";
					print_r($hasilMAPE);
				echo "</pre>";
				echo "<p>Hasil Keseluruhan</p>";
				echo "<pre>";
					print_r($hasilKeseluruhan);
				echo "</pre>";
				echo "<p>Rata- Rata Kesalahan</p>";
				echo "<pre>";
					print_r($ratarataKesalahan);
				echo "</pre>";
				 ?>
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
												<h6 class="fw-bold mt-3 mb-0">Nama Produk : &nbsp <?php echo $produk->nama_produk ?></h6>
											</div>
										<?php endif; ?>
									</div>
									<div class="d-flex flex-wrap justify-content-left pb-2 pt-4">
										<div class="px-2 pb-2 pb-md-0">
											<h6 class="fw-bold mt-3 mb-0">Produk</h6>
										</div>
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
									<div id="chart-container">
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
													<th>Name</th>
													<th>Position</th>
													<th>Office</th>
													<th style="width: 10%">Action</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Name</th>
													<th>Position</th>
													<th>Office</th>
													<th>Action</th>
												</tr>
											</tfoot>
											<tbody>
												<tr>
													<td>Tiger Nixon</td>
													<td>System Architect</td>
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

//Chart
var multipleLineChart = document.getElementById('multipleLineChart').getContext('2d');

var myMultipleLineChart = new Chart(multipleLineChart, {
	type: 'line',
	data: {
		labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
		datasets: [{
			label: "Python",
			borderColor: "#1d7af3",
			pointBorderColor: "#FFF",
			pointBackgroundColor: "#1d7af3",
			pointBorderWidth: 2,
			pointHoverRadius: 4,
			pointHoverBorderWidth: 1,
			pointRadius: 4,
			backgroundColor: 'transparent',
			fill: true,
			borderWidth: 2,
			data: [30, 45, 45, 68, 69, 90, 100, 158, 177, 200, 245, 256,]
		},{
			label: "PHP",
			borderColor: "#59d05d",
			pointBorderColor: "#FFF",
			pointBackgroundColor: "#59d05d",
			pointBorderWidth: 2,
			pointHoverRadius: 4,
			pointHoverBorderWidth: 1,
			pointRadius: 4,
			backgroundColor: 'transparent',
			fill: true,
			borderWidth: 2,
			data: [10, 20, 55, 75, 80, 48, 59, 55, 23, 107, 60, 87]
		}, {
			label: "Ruby",
			borderColor: "#f3545d",
			pointBorderColor: "#FFF",
			pointBackgroundColor: "#f3545d",
			pointBorderWidth: 2,
			pointHoverRadius: 4,
			pointHoverBorderWidth: 1,
			pointRadius: 4,
			backgroundColor: 'transparent',
			fill: true,
			borderWidth: 2,
			data: [10, 30, 58, 79, 90, 105, 117, 160, 185, 210, 185, 194]
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
