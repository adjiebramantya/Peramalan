<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ramal extends CI_Controller {

	function __construct(){
			parent::__construct();
			$this->load->model('M_produk');
			$this->load->helper('url');
			$this->load->library('form_validation');

			if($this->session->userdata('status') != "login"){
			redirect(base_url("Auth"));
			}
	}

	public function index()
	{
		$data['produk'] = $this->M_produk->tampil_produk()->result();
		$data['alpha'] = $this->M_produk->alpha()->row();
		// echo "<pre>";
		// 	print_r($data['alpha']->alpha);
		// echo "</pre>";
		$this->load->view('ramal',$data);
	}

	public function alpha(){
		$alpha = $this->input->post('alpha');
		$data = array(
			'alpha' => $alpha
		);

		$where = array(
			'id_alpha' => '1'
		);
		$this->session->set_flashdata('success', 'Anda Berhasil Mengubah alpha');
		$this->M_produk->update_data($where,$data,'alpha');
		redirect('ramal');
	}

	public function ramal_produk($id_produk){
		$data['produk'] = $this->M_produk->ramal_produk($id_produk)->row();

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
								$detail = $this->db->query("SELECT produk.nama_produk as nama_produk, YEAR(tanggal) as tahun, MONTH(tanggal) as Bulan, SUM(jumlah) as jumlah FROM barang_masuk JOIN produk ON barang_masuk.id_produk= produk.id_produk WHERE barang_masuk.id_produk = '$id_produk' AND MONTH(tanggal) = '".sprintf("%02d", $b)."' AND YEAR(tanggal) = '".sprintf("%02d", $t)."' GROUP BY MONTH(tanggal), YEAR(tanggal) ORDER BY tanggal asc")->row();

								if ($t == date("Y", strtotime($akhir->tanggal)) && $b > date("m", strtotime($akhir->tanggal))) {
										break;
								} else {
										if ($detail) {
												//echo sprintf("%02d", $b)."-".$t."==".$detail->nama_produk."|".$detail->jumlah."<br>";
												$aktual[]= $detail->jumlah;
												$bulan[] = sprintf("%02d",$b)." - ".$t;
										}
										// else {
										// 		//echo sprintf("%02d", $b)."-".$t."==".""."|"."0"."<br>";
										// 		$aktual[]= 0;
										// 		$bulan[] = sprintf("%02d",$b)." - ".$t;
										// }
								}
						}
				}
		}
		$data['alpha'] = $this->M_produk->alpha()->row();

		$alpha = $data['alpha']->alpha;

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

		 echo "<div  class='' hidden>";
			$hasilMAD = round($MAD / $jumlah,3);
			$hasilMSE = round($MSE / ($jumlah-1),3);
			$hasilMAPE= round($MAPE / $jumlah * 100,3);
			$hasilKeseluruhan = $hasilMAD + $hasilMSE + $hasilMAPE;
			$ratarataKesalahan = round($hasilKeseluruhan/3,3);
		 echo "</div>";

			$data['bulan'] = $bulan;
			$data['aktual']= $aktualInt;
			$data['ft']= $ftInt;

			// $data['dt']['bulan'] = $bulan;
			// $data['dt']['aktual']= $aktualInt;
			// $data['dt']['ft']= $ftInt;

			$data['hasilMAD'] = $hasilMAD;
			$data['hasilMSE'] = $hasilMSE;
			$data['hasilMAPE'] = $hasilMAPE;
			$data['ratarataKesalahan'] = $ratarataKesalahan;
			$data['produkBulan'] = end($ftInt);



		// echo "<pre>";
		// 	print_r($data['produkBulan']);
		// echo "</pre>";
		// echo "<pre>";
		// 	print_r($data['aktual']);
		// echo "</pre>";
		// echo "<pre>";
		// 	print_r($data['ft']);
		// echo "</pre>";
		// echo json_encode($data['bulan']);


		 $this->load->view('ramalProduk',$data);
	}

	public function ramal_produkAll($id_produk){
		$data['produk'] = $this->M_produk->ramal_produk($id_produk)->row();

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
								$detail = $this->db->query("SELECT produk.nama_produk as nama_produk, YEAR(tanggal) as tahun, MONTH(tanggal) as Bulan, SUM(jumlah) as jumlah FROM barang_masuk JOIN produk ON barang_masuk.id_produk= produk.id_produk WHERE barang_masuk.id_produk = '$id_produk' AND MONTH(tanggal) = '".sprintf("%02d", $b)."' AND YEAR(tanggal) = '".sprintf("%02d", $t)."' GROUP BY MONTH(tanggal), YEAR(tanggal) ORDER BY tanggal asc")->row();

								if ($t == date("Y", strtotime($akhir->tanggal)) && $b > date("m", strtotime($akhir->tanggal))) {
										break;
								} else {
										if ($detail) {
												//echo sprintf("%02d", $b)."-".$t."==".$detail->nama_produk."|".$detail->jumlah."<br>";
												$aktual[]= $detail->jumlah;
												$bulan[] = sprintf("%02d",$b)." - ".$t;
										}
										// else {
										// 		//echo sprintf("%02d", $b)."-".$t."==".""."|"."0"."<br>";
										// 		$aktual[]= 0;
										// 		$bulan[] = sprintf("%02d",$b)." - ".$t;
										// }
								}
						}
				}
		}

		$alpha = array(0.1,0.2,0.3,0.4,0.5,0.6,0.7,0.8,0.9);

		for($a = 0; $a < count($alpha);$a++){
				$aktualInt = array_map('intval',$aktual);

				$nilaiAwal = array_slice( $aktual, 0,1);
				$nilaiAwalInt = array_map('intval',$nilaiAwal);

				//SMOOTHING 1
					$s1[]= $nilaiAwalInt[0];
					$s1Int = array_map('intval',$s1);

					for($i = 1;$i < count($aktualInt)+1;$i++)
						{
							$s1Int[$i]= round($alpha[$a] * $aktualInt[$i-1]+(1-$alpha[$a]) * $s1Int[$i-1],2);
						}

				//SMOOTHING 2
					$s2[]= $nilaiAwalInt[0];
					$s2Int = array_map('intval',$s2);

					for($i = 1;$i < count($s1Int);$i++)
						{
							$s2Int[$i]= round($alpha[$a] * $s1Int[$i]+(1-$alpha[$a]) * $s2Int[$i-1],2);
						}

				//SMOOTHING 3
					$s3[]= $nilaiAwalInt[0];
					$s3Int = array_map('intval',$s2);

					for($i = 1;$i < count($s2Int);$i++)
						{
							$s3Int[$i]= round($alpha[$a] * $s2Int[$i]+(1-$alpha[$a]) * $s3Int[$i-1],2);
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
								$btInt[$i]= round($alpha[$a]/2*pow(1-$alpha[$a],2)*((6-5*$alpha[$a])*$s1Int[$i]-(10-8*$alpha[$a])*$s2Int[$i]+(4-3*$alpha[$a])*$s3Int[$i]),2);
							}

						//CT
							$ct = array();
							$ctInt = array_map('intval',$ct);

							for($i = 1;$i < count($s1Int);$i++)
								{
									$ctInt[$i]= round(pow($alpha[$a],2)/pow(1-$alpha[$a],2)*($s1Int[$i]-2*$s2Int[$i]+$s3Int[$i]),2);
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

					echo "<div  class='' hidden>";
					$hasilFtInt[$a] = end($ftInt);
					$hasilMAD[$a] = round($MAD / $jumlah,3);
					$hasilMSE[$a] = round($MSE / ($jumlah-1),3);
					$hasilMAPE[$a]= round($MAPE / $jumlah * 100,3);
					$hasilKeseluruhan = $hasilMAD[$a] + $hasilMSE[$a] + $hasilMAPE[$a];
					$ratarataKesalahan[$a] = round($hasilKeseluruhan/3,3);
					echo "</div>";
			}


			$data['bulan'] = $bulan;
			$data['aktual']= $aktualInt;
			$data['ft']= $ftInt;

			// $data['dt']['bulan'] = $bulan;
			// $data['dt']['aktual']= $aktualInt;
			// $data['dt']['ft']= $ftInt;
			$data['alpha'] = $alpha;
			$data['hasilFtint'] = $hasilFtInt;
			$data['hasilMAD'] = $hasilMAD;
			$data['hasilMSE'] = $hasilMSE;
			$data['hasilMAPE'] = $hasilMAPE;
			$data['ratarataKesalahan'] = $ratarataKesalahan;
			$data['produkBulan'] = end($ftInt);



		// echo "<pre>";
		// 	print_r($data['produkBulan']);
		// echo "</pre>";
		// echo "<pre>";
		// 	print_r($data['aktual']);
		// echo "</pre>";
		// echo "<pre>";
		// 	print_r($data['ft']);
		// echo "</pre>";
		// echo json_encode($data['bulan']);


		 $this->load->view('ramalProdukAll',$data);
	}

	public function tesRamal(){

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
								$detail = $this->db->query("SELECT produk.nama_produk as nama_produk, YEAR(tanggal) as tahun, MONTH(tanggal) as Bulan, SUM(jumlah) as jumlah FROM barang_masuk JOIN produk ON barang_masuk.id_produk= produk.id_produk WHERE barang_masuk.id_produk = 10 AND MONTH(tanggal) = '".sprintf("%02d", $b)."' AND YEAR(tanggal) = '".sprintf("%02d", $t)."' GROUP BY MONTH(tanggal), YEAR(tanggal) ORDER BY tanggal asc")->row();

								if ($t == date("Y", strtotime($akhir->tanggal)) && $b > date("m", strtotime($akhir->tanggal))) {
										break;
								} else {
										if ($detail) {
												//echo sprintf("%02d", $b)."-".$t."==".$detail->nama_produk."|".$detail->jumlah."<br>";
												$aktual[]= $detail->jumlah;
												$bulan[] = sprintf("%02d",$b)." - ".$t;
										}
										// else {
										// 		//echo sprintf("%02d", $b)."-".$t."==".""."|"."0"."<br>";
										// 		$aktual[]= 0;
										// 		$bulan[] = sprintf("%02d",$b)." - ".$t;
										// }
								}
						}
				}
		}


		$alpha = array(0.1,0.2,0.3,0.4,0.5,0.6,0.7,0.8,0.9);

		for($a = 0; $a < count($alpha);$a++){
				$aktualInt = array_map('intval',$aktual);

				$nilaiAwal = array_slice( $aktual, 0,1);
				$nilaiAwalInt = array_map('intval',$nilaiAwal);

				//SMOOTHING 1
					$s1[]= $nilaiAwalInt[0];
					$s1Int = array_map('intval',$s1);

					for($i = 1;$i < count($aktualInt)+1;$i++)
						{
							$s1Int[$i]= round($alpha[$a] * $aktualInt[$i-1]+(1-$alpha[$a]) * $s1Int[$i-1],2);
						}

				//SMOOTHING 2
					$s2[]= $nilaiAwalInt[0];
					$s2Int = array_map('intval',$s2);

					for($i = 1;$i < count($s1Int);$i++)
						{
							$s2Int[$i]= round($alpha[$a] * $s1Int[$i]+(1-$alpha[$a]) * $s2Int[$i-1],2);
						}

				//SMOOTHING 3
					$s3[]= $nilaiAwalInt[0];
					$s3Int = array_map('intval',$s2);

					for($i = 1;$i < count($s2Int);$i++)
						{
							$s3Int[$i]= round($alpha[$a] * $s2Int[$i]+(1-$alpha[$a]) * $s3Int[$i-1],2);
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
								$btInt[$i]= round($alpha[$a]/2*pow(1-$alpha[$a],2)*((6-5*$alpha[$a])*$s1Int[$i]-(10-8*$alpha[$a])*$s2Int[$i]+(4-3*$alpha[$a])*$s3Int[$i]),2);
							}

						//CT
							$ct = array();
							$ctInt = array_map('intval',$ct);

							for($i = 1;$i < count($s1Int);$i++)
								{
									$ctInt[$i]= round(pow($alpha[$a],2)/pow(1-$alpha[$a],2)*($s1Int[$i]-2*$s2Int[$i]+$s3Int[$i]),2);
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

					$hasilFtInt[$a] = end($ftInt);
					$hasilMAD[$a] = round($MAD / $jumlah,3);
					$hasilMSE[$a] = round($MSE / ($jumlah-1),3);
					$hasilMAPE[$a]= round($MAPE / $jumlah * 100,3);
					$hasilKeseluruhan = $hasilMAD[$a] + $hasilMSE[$a] + $hasilMAPE[$a];
					$ratarataKesalahan[$a] = round($hasilKeseluruhan/3,3);
			}


			$data['data']['bulan'] = $bulan;
			$data['data']['aktual']= $aktualInt;
			$data['data']['ft']= $ftInt;

			$data['hasilFtint'] = $hasilFtInt;
			$data['hasilMAD'] = $hasilMAD;
			$data['hasilMSE'] = $hasilMSE;
			$data['hasilMAPE'] = $hasilMAPE;
			$data['ratarataKesalahan'] = $ratarataKesalahan;


		echo "<pre>";
			print_r($data['hasilFtint']);
		echo "</pre>";
		echo "<pre>";
			print_r($data['hasilMAPE']);
		echo "</pre>";
		// echo "<br>";
		// echo "<p>AKtual</p>";
		// echo "<pre>";
		// 	print_r($data['aktual']);
		// echo "</pre>";
		// echo "<p>S1</p>";
		// echo "<pre>";
		// 	print_r($s1Int);
		// echo "</pre>";
		// echo "<p>S2</p>";
		// echo "<pre>";
		// 	print_r($s2Int);
		// echo "</pre>";
		// echo "<p>S3</p>";
		// echo "<pre>";
		// 	print_r($s3Int);
		// echo "</pre>";
		// echo "<p>at</p>";
		// echo "<pre>";
		// 	print_r($atInt);
		// echo "</pre>";
		// echo "<p>bt</p>";
		// echo "<pre>";
		// 	print_r($btInt);
		// echo "</pre>";
		// echo "<p>ct</p>";
		// echo "<pre>";
		// 	print_r($ctInt);
		// echo "</pre>";
		// echo "<p>Ft+M</p>";
		// echo "<pre>";
		// 	print_r($ftInt);
		// echo "</pre>";
		// echo "<p>Selisih</p>";
		// echo "<pre>";
		// 	print_r($selisihInt);
		// echo "</pre>";
		// echo "<p>Selisih Absolute</p>";
		// echo "<pre>";
		// 	print_r(array_map("abs",$selisihInt));
		// echo "</pre>";
		// echo "<p>Selisih Pangkat</p>";
		// echo "<pre>";
		// 	print_r($selisihPangkatInt);
		// echo "</pre>";
		// echo "<p>Selisih Seratus</p>";
		// echo "<pre>";
		// 	print_r($selisihSeratusInt);
		// echo "</pre>";
		// echo "<p>MAD</p>";
		// echo "<pre>";
		// 	print_r($hasilMAD);
		// echo "</pre>";
		// echo "<p>MSE</p>";
		// echo "<pre>";
		// 	print_r($hasilMSE);
		// echo "</pre>";
		// echo "<p>MAPE</p>";
		// echo "<pre>";
		// 	print_r($hasilMAPE);
		// echo "</pre>";
		// echo "<p>Hasil Keseluruhan</p>";
		// echo "<pre>";
		// 	print_r($hasilKeseluruhan);
		// echo "</pre>";
		// echo "<p>Rata- Rata Kesalahan</p>";
		// echo "<pre>";
		// 	print_r($ratarataKesalahan);
		// echo "</pre>";
	}

}
