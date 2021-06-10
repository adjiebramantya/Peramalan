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
		// $data = $this->M_barangMasuk->rinci_barangMasuk($bulan,$tahun)->result();
		$data = $this->M_barangMasuk->tampil_barangMasuk()->result();
 		$decode = json_encode($data, JSON_UNESCAPED_SLASHES);
		 echo '<pre>'; print_r($decode); echo '</pre>';

    // foreach ($json as $value) {
    //     echo $value['id_masuk']."<br/>";
    //     echo $value['tanggal']."<br/>";
    //     echo $value['nama_produk']."<br/>";
    //     echo $value['jumlah']."<br/>";
    //     echo "<br/>";
    // }
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
