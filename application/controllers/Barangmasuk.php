<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barangmasuk extends CI_Controller {

	function __construct(){
			parent::__construct();
			$this->load->model('M_produk');
			$this->load->model('M_barangMasuk');
			$this->load->helper('url');
			$this->load->library('form_validation');

			if($this->session->userdata('status') != "login"){
			redirect(base_url("Auth"));
			}
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

		// $data['tampilBarangMasuk'] = $this->M_barangMasuk->tampil_barangMasuk()->result();
		$data['produk'] = $this->M_produk->tampil_produk()->row();
		$data['orderBySatuan'] = $this->M_produk->orderBySatuan()->result();
		$data['orderByPaket'] = $this->M_produk->orderByPaket()->result();
		$data['tahun'] = $this->M_barangMasuk->tahun()->result();
		$data['caribarangMasuk'] = $this->M_barangMasuk->rinci_barangMasuk($bulan,$tahun)->result();
		// $data = $this->M_barangMasuk->tampil_barangMasuk()->result();
		$this->load->view('caribarangMasuk',$data);

		// echo '<pre>'; var_dump($data); echo '</pre>';
 		// echo json_encode($data, JSON_UNESCAPED_SLASHES);
		 // echo '<pre>'; print_r($decode); echo '</pre>';

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

		$this->session->set_flashdata('success', 'Anda Berhasil Menambah data Barang Masuk');
		$this->M_barangMasuk->input_data($data,'barang_masuk');
		redirect('Barangmasuk');
	}

	// HAPUS PRODUK
	public function hapus_barangMasuk($id_masuk){
		$where = array('id_masuk' => $id_masuk);
		$this->M_barangMasuk->hapus_data($where,'barang_masuk');
		redirect('barangmasuk');
	}

	function edit_barangMasuk(){
	$id_produk = $this->input->post('id_masuk');
	$nama_produk = $this->input->post('nama_produk');
	$jenis_produk = $this->input->post('jenis_produk');
	$harga = $this->input->post('harga');

	$data = array(
		'nama_produk' => $nama_produk,
		'jenis_produk' => $jenis_produk,
		'harga' => $harga
	);

	$where = array(
		'id_produk' => $id_produk
	);

	$this->session->set_flashdata('success', 'Anda Berhasil Mengubah data Produk');
	$this->M_produk->update_data($where,$data,'produk');
	redirect('produk');

	}

}
