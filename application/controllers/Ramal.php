<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ramal extends CI_Controller {

	public function index()
	{
		$this->load->view('ramal');
	}

	public function ramal_produk(){
		$this->load->view('ramalProduk');
	}
}
