<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barangmasuk extends CI_Controller {

	function __construct(){
			parent::__construct();
			$this->load->model('M_produk');
			$this->load->model('M_barangMasuk');
			$this->load->helper('url');
			$this->load->library('form_validation');
	}

	public function index()
	{
		$data['orderBySatuan'] = $this->M_produk->orderBySatuan()->result();
		$data['orderByPaket'] = $this->M_produk->orderByPaket()->result();
		$data['tahun'] = $this->M_barangMasuk->tahun()->result();
		// $data['barangMasuk'] = $this->M_barangMasuk->tampil_barangMasuk()->result();
		$this->load->view('barangMasuk',$data);
	}

	public function barang_masuk(){
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$data = $this->M_barangMasuk->rinci_barangMasuk($bulan,$tahun)->result();
		echo json_encode($data);
	}

	function tambah_barangMasuk(){
		$id_produk = $this->input->post('id_produk');
		$tanggal = $this->input->post('tanggal');
		$jumlah = $this->input->post('jumlah');

		$data = array(
			'id_produk' => $id_produk,
			'tanggal' => $tanggal,
			'jumlah' => $jumlah
			);
		$this->M_barangMasuk->input_data($data,'barang_masuk');
		redirect('Barangmasuk');
	}

}
