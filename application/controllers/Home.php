<?php
defined('BASEPATH') or exit('No direct script access allowed');

class home extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->helpers('h_helper');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('upload');
    }
    
	public function index()
	{
		$this->load->view('home');
	}
}
