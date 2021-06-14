<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('M_login');

		// if($this->session->userdata('status') != "login"){
		// redirect(base_url("Auth"));
		// }

	}

	public function index()
	{


		$this->load->view('login');
	}

	function aksi_login(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array(
			'username' => $username,
			'password' => md5($password)
			);
		$data= $this->M_login->cek_login("user",$where)->row();
		// var_dump($password);
		// var_dump($data->password);

		$cek = $this->M_login->cek_login("user",$where)->num_rows();
		if($cek > 0){

			$data_session = array(
				'id_user'=> $data->id_user,
				'nama' => $data->nama,
				'email'=> $data->email,
				'username' => $username,
				'status' => "login"
				);

			$this->session->set_userdata($data_session);

			redirect(base_url('Dashboard'));


		}else{
			echo "Username dan password salah !";
		}
	}

	function logout(){
		$this->session->sess_destroy();
		redirect(base_url('Auth'));
	}

	function register(){
		$fullname = $this->input->post('fullname');
		$email = $this->input->post('email');
		$nohp = $this->input->post('nohp');
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$data = array(
			'nama' => $fullname,
			'email' => $email,
			'nohp' => $nohp,
			'username' =>$username,
			'password' =>md5($password)
			);
		$this->M_login->input_data($data,'user');
		redirect('Auth');
	}
}
