<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Dashboard - Peramalan</title>
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
				<div class="panel-header bg-success-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-white pb-2 fw-bold">Dashboard</h2>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner mt--5">
					<div class="row mt--2">
						<div class="col-md-12">
							<div class="card full-height">
								<div class="card-body">
									<div class="card-title">Statistik Keseluruhan</div>
									<div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
										<div class="px-2 pb-2 pb-md-0 text-center">
											<div id="circles-1"></div>
											<h6 class="fw-bold mt-3 mb-0">Produk</h6>
										</div>
										<div class="px-2 pb-2 pb-md-0 text-center">
											<div id="circles-2"></div>
											<h6 class="fw-bold mt-3 mb-0">Produk terlaris</h6>
										</div>
										<div class="px-2 pb-2 pb-md-0 text-center">
											<div id="circles-3"></div>
											<h6 class="fw-bold mt-3 mb-0">Bulan Data yang disimpan</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
          <div class="row mt--2">
            <div class="col-md-12">
              <div class="card full-height">
                <div class="card-body">
                  <div class="d-flex flex-wrap justify-content-around pb-2 pt-4">

                    <div class="px-2 pb-2 pb-md-0 text-center">
                      <i class="fas fa-chart-area fa-3x"></i>
                      <h3 class="fw-bold mt-3 mb-0">Selamat Datang di Aplikasi Peramalan Produk SkinCare <br>dengan Menggunakan Metode Triple Exponential Smoothing</h3>
                    </div>
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

	<!-- Atlantis DEMO methods, don't include it in your project! -->
<script>
  Circles.create({
    id:'circles-1',
    radius:45,
    value:60,
    maxValue:100,
    width:7,
    text: 5,
    colors:['#f1f1f1', '#FF9E27'],
    duration:400,
    wrpClass:'circles-wrp',
    textClass:'circles-text',
    styleWrapper:true,
    styleText:true
  })

  Circles.create({
    id:'circles-2',
    radius:45,
    value:70,
    maxValue:100,
    width:7,
    text: 36,
    colors:['#f1f1f1', '#2BB930'],
    duration:400,
    wrpClass:'circles-wrp',
    textClass:'circles-text',
    styleWrapper:true,
    styleText:true
  })

  Circles.create({
    id:'circles-3',
    radius:45,
    value:40,
    maxValue:100,
    width:7,
    text: 12,
    colors:['#f1f1f1', '#F25961'],
    duration:400,
    wrpClass:'circles-wrp',
    textClass:'circles-text',
    styleWrapper:true,
    styleText:true
  })

  var totalIncomeChart = document.getElementById('totalIncomeChart').getContext('2d');

  var mytotalIncomeChart = new Chart(totalIncomeChart, {
    type: 'bar',
    data: {
      labels: ["S", "M", "T", "W", "T", "F", "S", "S", "M", "T"],
      datasets : [{
        label: "Total Income",
        backgroundColor: '#ff9e27',
        borderColor: 'rgb(23, 125, 255)',
        data: [6, 4, 9, 5, 4, 6, 4, 3, 8, 10],
      }],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        display: false,
      },
      scales: {
        yAxes: [{
          ticks: {
            display: false //this will remove only the label
          },
          gridLines : {
            drawBorder: false,
            display : false
          }
        }],
        xAxes : [ {
          gridLines : {
            drawBorder: false,
            display : false
          }
        }]
      },
    }
  });

  $('#lineChart').sparkline([105,103,123,100,95,105,115], {
    type: 'line',
    height: '70',
    width: '100%',
    lineWidth: '2',
    lineColor: '#ffa534',
    fillColor: 'rgba(255, 165, 52, .14)'
  });
</script>
</body>
</html>
