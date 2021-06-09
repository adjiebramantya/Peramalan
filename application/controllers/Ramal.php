<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ramal extends CI_Controller {

	function __construct(){
			parent::__construct();
			$this->load->model('M_produk');
			$this->load->helper('url');
			$this->load->library('form_validation');
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

		$array = 1;
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
								$detail = $this->db->query("SELECT produk.nama_produk as nama_produk, YEAR(tanggal) as tahun, MONTH(tanggal) as Bulan, SUM(jumlah) as jumlah FROM barang_masuk JOIN produk ON barang_masuk.id_produk= produk.id_produk WHERE barang_masuk.id_produk = 5 AND MONTH(tanggal) = '".sprintf("%02d", $b)."' AND YEAR(tanggal) = '".sprintf("%02d", $t)."' GROUP BY MONTH(tanggal), YEAR(tanggal) ORDER BY tanggal asc")->row();

								if ($t == date("Y", strtotime($akhir->tanggal)) && $b > date("m", strtotime($akhir->tanggal))) {
										break;
								} else {
										if ($detail) {
												echo $array.". ".sprintf("%02d", $b)."-".$t."==".$detail->nama_produk."|".$detail->jumlah."<br>";
										} else {
												echo $array.". ".sprintf("%02d", $b)."-".$t."==".""."|"."0"."<br>";
										}

										$array++;
								}
						}
				}
		}
	}

}
