<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->model('M_login');

		if($this->session->userdata('status') != "login"){
		redirect(base_url("Auth"));
		}

	}

	public function index()
	{
		$where= array('id_user' => $this->session->userdata('id_user'));
		$data['profil'] = $this->M_login->tampil_profil($where,'user')->result();

		$this->load->view('editProfil',$data);
	}

	public function edit_profil(){
		$id_user=$this->input->post('id_user');
		$nama=$this->input->post('nama');
		$email=$this->input->post('email');
		$nohp=$this->input->post('nohp');
		$username=$this->input->post('username');
		$password=$this->input->post('password');

		$where = array(
			'id_user' => $id_user
		);

		if ($password == "") {
			$data = array(
				'nama' => $nama,
				'email' => $email,
				'nohp' => $nohp,
				'username' => $username
			);

			$this->session->set_flashdata('success', 'Anda Berhasil Mengedit data Profil');
			$this->M_login->update_data($where,$data,'user');
			redirect('profil');

		} else{
			$data = array(
				'nama' => $nama,
				'email' => $email,
				'nohp' => $nohp,
				'username' => $username,
				'password' => md5($password)
			);

			$this->session->set_flashdata('success', 'Anda Berhasil Mengedit data Profil');
			$this->M_login->update_data($where,$data,'user');
			redirect('profil');
		}
	}

}
