<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

	function __construct(){
			parent::__construct();
			$this->load->model('M_produk');
			$this->load->helper('url');
			$this->load->library('form_validation');
	}

	//TAMPIL PRODUK
	public function index()
	{
		$data['produk'] = $this->M_produk->tampil_produk()->result();
		$this->load->view('produk',$data);
	}

	// TAMBAH PRODUK
	function tambah_produk(){

		$this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required|is_unique[produk.nama_produk]');

		if ($this->form_validation->run()==true) {
			$nama_produk = $this->input->post('nama_produk');
			$jenis_produk = $this->input->post('jenis_produk');
			$harga = $this->input->post('harga');

			$data = array(
				'nama_produk' => $nama_produk,
				'jenis_produk' => $jenis_produk,
				'harga' => $harga
				);
			$this->M_produk->input_data($data,'produk');
			redirect('produk');
		}
		else
		{
			$data['produk'] = $this->M_produk->tampil_produk()->result();
			$this->load->view('produk',$data);
		}
	}

	// EDIT PRODUK
	function edit($id_produk){
		$where = array('id_produk' => $id_produk);
		$data['produk'] = $this->M_produk->edit_data($where,'produk')->result();
		$this->load->view('editProduk',$data);
	}

	function edit_produk(){
	$id_produk = $this->input->post('id_produk');
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

	$this->M_produk->update_data($where,$data,'produk');
	redirect('produk');
	}

	// HAPUS PRODUK
	public function hapus_produk($id_produk){
		$where = array('id_produk' => $id_produk);
		$this->M_produk->hapus_data($where,'produk');
		redirect('produk');
	}
}
