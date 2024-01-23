<?php
defined('BASEPATH') or exit('No direct script access allowed');

class login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_auth');
		$this->load->helpers('h_helper');
		$this->load->helper('url');
		$this->load->library('session');
	}

	public function index()
	{
		$this->load->view('auth/login');
	}

	public function aksi_login()
	{
		$password = $this->input->post('password');
		$data = ['username' => $this->input->post('username'), 'password' => md5($password)];
		$query = $this->m_auth->cek_login('table_level', $data);
		$res = $query->row_array();

		if ($query->num_rows() == 1) {
			$data_session = ["id" => $res['id_level'], "username" => $res['username'], "username" => $res['username'], "role" => $res['role'], 'logged_in' => 'login'];
			$this->session->set_userdata('login', $data_session);
			$this->session->set_userdata($data_session);
			if ($res['role'] == 'admin') {
				$data_session['login_admin'] = "login";
				redirect(base_url('admin'));
			} else {
				$data_session['login_member'] = "login";
				$data_session['nis'] = $res['nis'];
				$this->session->set_userdata($data_session);
				redirect(base_url('member'));
			}
		} else {
			$this->session->set_flashdata('error_message', 'Username atau Password Salah!');
			redirect(base_url('login'));
		}
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
}
