<?php
defined('BASEPATH') or exit('No direct script access allowed');

class register extends CI_Controller
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
        $this->load->view('auth/register');
    }

    public function aksi_register()
    {
        $password = $this->input->post('password');
        $username = $this->input->post('username');

        $cek_user = $this->m_auth->cek_login('table_level', ['username' => $username]);
        $pattern = "/^.{8}$/";

        if (!preg_match($pattern, $password)) {
            $this->session->set_flashdata('errorPassword', 'Password harus 8 karakter!');
            redirect(base_url('login'));
        }
        
        if($cek_user) {
            $this->session->set_flashdata('errorUsername', 'Username sudah digunakan!');
            redirect(base_url('login'));
        }

        $data = [
            'username' => $username,
            'password' => md5($password),
            'role' => 'member',
        ];

        $register = $this->m_auth->registrasi('table_level', $data);
        if ($register) {
            redirect(base_url('login'));
        } else {
            $this->session->set_flashdata('error', 'Pendaftaran gagal!');
            redirect(base_url('login'));
        }
    }
}
