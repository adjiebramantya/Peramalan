<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->model('M_produk');

		if($this->session->userdata('status') != "login"){
		redirect(base_url("Auth"));
		}

	}

	public function index()
	{
		$detail = $this->db->query("SELECT MONTh(tanggal) as bulan , year(tanggal) as tahun FROM barang_masuk GROUP BY MONTH(tanggal), YEAR(tanggal) ORDER BY tanggal asc")->result();

		$data['jumlah_bulan'] = count($detail);
		$data['jumlah_produk'] = $this->M_produk->jumlah_produk()->row();
		$data['nama_produk'] = $this->M_produk->nama_produk()->row();
		$this->load->view('dashboard',$data);
	}
}
