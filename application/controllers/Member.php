<?php
defined('BASEPATH') or exit('No direct script access allowed');

class member extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_member');
        $this->load->helpers('h_helper');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('upload');
        $login = $this->session->userdata('login_member');
        $role = $this->session->userdata('role');
        if ($login != 'login' && $role != 'member') {
            redirect(base_url('login'));
        }
    }

    // DASHBOARD 
    public function index()
    {
        $data = [
            'member' => $this->m_member->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result(),
            'books' => $this->m_member->get_terbaru('table_buku', 4),
            'kategori' => $this->m_member->get('table_kategori'),
            'buku' => $this->m_member->get('table_buku'),
            'buku2' =>  $this->m_member->getwhere('table_buku', ['id_kategori' => $this->input->post('id')])->result()
        ];
        $this->load->view('member/dashboard', $data);
    }

    public function acak($long)
    {
        $char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $string = '';
        for ($i = 0; $i < $long; $i++) {
            $pos = rand(0, strlen($char) - 1);
            $string .= $char[$pos];
        }
        return $string;
    }

    public function pinjam_buku()
    {
        $id_buku = $this->input->post('id');
        $jumlah = $this->input->post('jumlah');
        $nis = $this->input->post('nis');
        $index = 'IP-' . $this->acak(6);
        $tgl_pinjam = date('Y-m-d');
        $tgl_kembali = date('Y-m-d', strtotime('+6 days'));

        $index_pinjam = [
            'index_pinjam' => $index,
            'tgl_pinjam' => $tgl_pinjam,
            'tgl_kembali' => $tgl_kembali,
            'nis' => $nis
        ];

        $add_index_pinjam = $this->m_member->tambah_index_pinjam($index_pinjam);

        if ($add_index_pinjam) {
            $books = $this->m_member->peminjaman(['id_buku' => $id_buku, 'status' => 'tersedia'], $jumlah);

            $data = [];
            $status = [];

            foreach ($books as $row) {
                $data[] = [
                    'index_buku' => $row->index_buku,
                    'index_pinjam' => index_pinjam($add_index_pinjam),
                    'nis' => $nis,
                    'id_buku' => $id_buku,
                ];

                $status[] = [
                    'index_buku' => $row->index_buku,
                    'status' => 'dipinjam',
                    'id' => $row->id
                ];
            }

            $this->db->insert_batch('table_peminjaman', $data);
            $this->db->update_batch('table_id_buku', $status, 'id');
            $this->session->set_flashdata('success', 'Tambah peminjaman berhasil!');
            redirect(base_url('member'));
        } else {
            $this->session->set_flashdata('error', 'Tambah peminjaman gagal!');
            redirect(base_url('member'));
        }
    }

    function jumlah_buku()
    {
        echo jumlah_buku_tersedia($this->input->post('id_buku'));
    }

    function data_buku()
    {
        $data['buku2'] = $this->m_member->getwhere('table_buku', ['id_kategori' => $this->input->post('id')])->result();
        $this->load->view('member/book', $data);
    }

    function judul_buku()
    {
        echo judul_buku($this->input->post('id'));
    }
    // END DASHBOARD

    // PEMINJAMAN
    public function peminjaman_buku()
    {
        $indikator = $this->input->get("indikator", TRUE);

        if ($indikator == 1) {
            $data['peminjaman'] = $this->m_member->getwhere('table_index_pinjam', ['nis' => nisMember_byIdLevel($this->session->userdata('id')), 'konfirmasi_pinjam' => 'not'])->result();
            $data['indikator'] = '1';
        } elseif ($indikator == 2) {
            $data['peminjaman'] = $this->m_member->getwhere('table_index_pinjam', ['nis' => nisMember_byIdLevel($this->session->userdata('id')), 'konfirmasi_pinjam' => 'yes', 'konfirmasi_kembali' => 'not'])->result();
            $data['indikator'] = '2';
        } else {
            $data['peminjaman'] = $this->m_member->getwhere('table_index_pinjam', ['nis' => nisMember_byIdLevel($this->session->userdata('id')), 'konfirmasi_pinjam' => 'not'])->result();
            $data['indikator'] = '1';
        }

        $data['member'] = $this->m_member->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result();

        $this->load->view('member/peminjaman/peminjaman', $data);
    }

    public function kembalikan_buku($id)
    {
        $tgl_kembali = tgl_kembali($id);
        $status = '';

        if ($tgl_kembali > date('Y-m-d')) {
            $status = 'tepat waktu';
            echo 'yaahhh';
        } else {
            $status = 'telat';
            $selisih = strtotime(date('Y-m-d')) - strtotime($tgl_kembali);
            $selisih_in_days = floor($selisih / (60 * 60 * 24));

            $denda = nominal_denda(1) * $selisih_in_days;

            $data_telat = [
                'index_pinjam' => $id,
                'denda_perhari' => nominal_denda(1),
                'denda' => $denda
            ];

            $this->m_member->tambah_telat_mengembalikan($data_telat);
        }

        $data = [
            'index_pinjam' => $id,
            'konfirmasi_kembali' => 'yes',
            'tgl_pengembalian' => date('Y-m-d'),
            'status' => $status,
        ];
        $konfimasi = $this->m_member->konfirmasi_peminjaman($data, $id);
        if ($konfimasi) {
            $peminjaman = $this->m_member->getwhere('table_peminjaman', ['index_pinjam' => $id])->result();

            $data_buku = [];

            foreach ($peminjaman as $row) {
                $data_buku[] = [
                    'index_buku' => $row->index_buku,
                    'status' => 'tersedia'
                ];
            }

            $this->db->update_batch('table_id_buku', $data_buku, 'index_buku');

            $this->session->set_flashdata('success', 'Pengembalian buku berhasil!');
            redirect(base_url('member/peminjaman_buku'));
        } else {
            $this->session->set_flashdata('error', 'Pengembalian buku gagal!');
            redirect(base_url('member/peminjaman_buku'));
        }
    }
    // END PEMINJAMAN

    // PENGEMBALIAN
    public function pengembalian_buku() {
        $this->load->view('member/pengembalian/pengembalian');
    }
    // END PENGEMBALIAN
}
