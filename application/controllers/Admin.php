<?php
defined('BASEPATH') or exit('No direct script access allowed');

class admin extends CI_Controller
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
        $this->load->view('admin/dashboard');
    }

    // RAK BUKU
    public function rak_buku() {
        $data = [
            'menu' => 'rak'
        ];
        $this->load->view('admin/rak/rak', $data);
    }
    // END RAK BUKU
}
