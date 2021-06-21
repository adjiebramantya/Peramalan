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
		$this->load->view('ramal',$data);
	}

	public function ramal_produk(){
		$this->load->view('ramalProduk');
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
								$detail = $this->db->query("SELECT produk.nama_produk as nama_produk, YEAR(tanggal) as tahun, MONTH(tanggal) as Bulan, SUM(jumlah) as jumlah FROM barang_masuk JOIN produk ON barang_masuk.id_produk= produk.id_produk WHERE barang_masuk.id_produk = 16 AND MONTH(tanggal) = '".sprintf("%02d", $b)."' AND YEAR(tanggal) = '".sprintf("%02d", $t)."' GROUP BY MONTH(tanggal), YEAR(tanggal) ORDER BY tanggal asc")->row();

								if ($t == date("Y", strtotime($akhir->tanggal)) && $b > date("m", strtotime($akhir->tanggal))) {
										break;
								} else {
										if ($detail) {
												//echo sprintf("%02d", $b)."-".$t."==".$detail->nama_produk."|".$detail->jumlah."<br>";
												$aktual[]= $detail->jumlah;
										} else {
												//echo sprintf("%02d", $b)."-".$t."==".""."|"."0"."<br>";
												$aktual[]= 0;
										}
								}
						}
				}
		}

		$aktualInt = array_map('intval',$aktual);

		$nilaiAwal = array_slice( $aktual, 0,1);
		$nilaiAwalInt = array_map('intval',$nilaiAwal);

		//SMOOTHING 1
			$s1[]= $nilaiAwalInt[0];
			$s1Int = array_map('intval',$s1);

			for($i = 1;$i < count($aktualInt)+1;$i++)
				{
					$s1Int[$i]= round(0.1 * $aktualInt[$i-1]+(1-0.1) * $s1Int[$i-1],2);
				}

		//SMOOTHING 2
			$s2[]= $nilaiAwalInt[0];
			$s2Int = array_map('intval',$s2);

			for($i = 1;$i < count($s1Int);$i++)
				{
					$s2Int[$i]= round(0.1 * $s1Int[$i]+(1-0.1) * $s2Int[$i-1],2);
				}

		//SMOOTHING 3
			$s3[]= $nilaiAwalInt[0];
			$s3Int = array_map('intval',$s2);

			for($i = 1;$i < count($s2Int);$i++)
				{
					$s3Int[$i]= round(0.1 * $s2Int[$i]+(1-0.1) * $s3Int[$i-1],2);
				}
		// echo "<pre>";
		// 	print_r($nilaiAwalInt);
		// echo "</pre>";
		echo "<br>";
		echo "<p>AKtual</p>";
		echo "<pre>";
			print_r($aktualInt);
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
	}

}
