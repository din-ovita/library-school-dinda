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
        $nis = $this->input->post('nis');

        $cek_user = $this->m_auth->cek_login('table_level', ['username' => $username, 'nis' => $nis])->num_rows();
        $pattern = "/^.{8}$/";

        if (!preg_match($pattern, $password)) {
            $this->session->set_flashdata('errorPassword', 'Password Harus 8 Karakter!');
            redirect(base_url('register'));
        }
        
        if($cek_user != 0) {
            $this->session->set_flashdata('errorUsername', 'Username atau NIS Sudah Digunakan!');
            redirect(base_url('register'));
        }

        $data = [
            'username' => $username,
            'nis' => $nis,
            'password' => md5($password),
            'role' => 'member',
        ];

        $register = $this->m_auth->registrasi('table_level', $data);
        if ($register) {
            $data2 = [
                'nama' => $username,
                'nis' => $nis,
                'id_level' => $register
            ];    
            $this->m_auth->registrasi('table_member', $data2);
            $this->session->set_flashdata('successRegister', 'Pendaftaran Berhasil!');
            redirect(base_url('login'));
        } else {
            $this->session->set_flashdata('errorRegister', 'Pendaftaran Gagal!');
            redirect(base_url('register'));
        }
    }
}
