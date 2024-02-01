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

    public function upload_img($value)
    {
        $kode = round(microtime(true) * 1000);
        $config['upload_path'] = './assets/member/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '30000';
        $config['file_name'] = $kode;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($value)) {
            return array(false, '');
        } else {
            $fn = $this->upload->data();
            $nama = $fn['file_name'];
            return array(true, $nama);
        }
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

    // DASHBOARD 
    public function index()
    {
        $data = [
            'menu' => 'dashboard',
            'member' => $this->m_member->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result(),
            'new_book' => $this->m_member->get_terbaru('table_buku', 5),
            'all_book' => $this->m_member->get_limit('table_buku', 20),
            // 'kategori' => $this->m_member->get('table_kategori'),
            // 'buku' => $this->m_member->get('table_buku'),
            // 'buku2' =>  $this->m_member->getwhere('table_buku', ['id_kategori' => $this->input->post('id')])->result(),
            'user' => $this->m_member->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $this->load->view('member/dashboard', $data);
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
            $response = ['pinjam' => 'success', 'messagePinjam' => 'Peminjaman Buku Berhasil!'];
        } else {
            $response = ['pinjam' => 'error', 'messagePinjamError' => 'Peminjaman Buku Gagal...'];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    // END DASHBOARD

    // PROFILE
    public function profile()
    {
        $data = [
            'user' => $this->m_member->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result(),
            'menu' => ''
        ];
        $this->load->view('member/profile', $data);
    }

    public function aksi_update_profile()
    {
        $foto = $this->upload_img('foto');
        $username = $this->input->post('username');
        $new_pass = $this->input->post('new_pass');
        $confirm_pass = $this->input->post('confirm_pass');
        $id_level = $this->input->post('id_level');

        $pattern = "/^.{8}$/";

        if ($foto[0] === false) {
            if (!empty($new_pass)) {
                if (!preg_match($pattern, $new_pass)) {
                    $this->session->set_flashdata('errorNewPassMember', 'Password Harus 8 Karakter!');
                    redirect(base_url('member/profile'));
                }

                if (md5($new_pass) != md5($confirm_pass)) {
                    $this->session->set_flashdata('errorConfirmPassMember', 'Password Baru dengan Konfirmasi Password Harus Sama!');
                    redirect(base_url('member/profile'));
                }

                $data = [
                    'username' => $username,
                    'password' => md5($new_pass)
                ];

                $update = $this->m_member->update_profile($data, ['id_level' => $id_level]);
                if ($update) {
                    $this->session->set_flashdata('successEditMember', 'Update Profile Berhasil!');
                    redirect(base_url('member/profile'));
                } else {
                    $this->session->set_flashdata('errorEditMember', 'Update Profile Gagal...');
                    redirect(base_url('member/profile'));
                }
            } else {
                $data = [
                    'username' => $username,
                ];

                $update = $this->m_member->update_profile($data, ['id_level' => $id_level]);
                if ($update) {
                    $this->session->set_flashdata('successEditMember', 'Update Profile Berhasil!');
                    redirect(base_url('member/profile'));
                } else {
                    $this->session->set_flashdata('errorEditMember', 'Update Profile Gagal...');
                    redirect(base_url('member/profile'));
                }
            }
        } else {
            if (!empty($new_pass)) {
                if (!preg_match($pattern, $new_pass)) {
                    $this->session->set_flashdata('errorNewPassMember', 'Password Harus 8 Karakter!');
                    redirect(base_url('member/profile'));
                }

                if (md5($new_pass) != md5($confirm_pass)) {
                    $this->session->set_flashdata('errorConfirmPassMember', 'Password Baru dengan Konfirmasi Password Harus Sama!');
                    redirect(base_url('member/profile'));
                }

                $data = [
                    'username' => $username,
                    'password' => md5($new_pass),
                    'foto' => $foto[1]
                ];

                $update = $this->m_member->update_profile($data, ['id_level' => $id_level]);
                if ($update) {
                    $this->session->set_flashdata('successEditMember', 'Update Profile Berhasil!');
                    redirect(base_url('member/profile'));
                } else {
                    $this->session->set_flashdata('errorEditMember', 'Update Profile Gagal...');
                    redirect(base_url('member/profile'));
                }
            } else {
                $data = [
                    'username' => $username,
                    'foto' => $foto[1]
                ];

                $update = $this->m_member->update_profile($data, ['id_level' => $id_level]);
                if ($update) {
                    $this->session->set_flashdata('successEditMember', 'Update Profile Berhasil!');
                    redirect(base_url('member/profile'));
                } else {
                    $this->session->set_flashdata('errorEditMember', 'Update Profile Gagal...');
                    redirect(base_url('member/profile'));
                }
            }
        }
    }
    // END PROFILE

    // PEMINJAMAN
    public function peminjaman_buku($page = 1)
    {
        $data = [
            'menu' => 'peminjaman',
            'user' => $this->m_member->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $per_page = 20;
        $data['peminjaman'] = $this->m_member->get_items_where($per_page, $per_page * ($page - 1), 'table_index_pinjam', ['konfirmasi_kembali' => 'not']);

        $total_rows = $this->m_member->count_items('table_index_pinjam');
        $config['base_url'] = base_url('admin/peminjaman_buku');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = 3;
        $config['num_links'] = 2;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";


        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data['pagination_links'] = $this->pagination->create_links();

        $this->load->view('member/peminjaman/peminjaman', $data);
    }

    public function detail_peminjaman($id)
    {
        $data = [
            'menu' => 'peminjaman',
            'index' => $this->m_member->getwhere('table_index_pinjam', ['index_pinjam' => $id])->result(),
            'buku' => $this->m_member->get('table_buku'),
            'peminjaman' => $this->m_member->getwhere('table_peminjaman', ['index_pinjam' => $id])->result(),
            'user' => $this->m_member->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $this->load->view('member/peminjaman/detail_peminjaman', $data);
    }

    public function kembalikan_buku($id)
    {
        $tgl_kembali = tgl_kembali($id);
        $status = '';

        if ($tgl_kembali > date('Y-m-d')) {
            $status = 'tepat waktu';
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

            $this->session->set_flashdata('successKembalikan', 'Pengembalian Buku Berhasil!');
            redirect(base_url('member/peminjaman_buku'));
        } else {
            $this->session->set_flashdata('errorKembalikan', 'Pengembalian Buku Gagal...');
            redirect(base_url('member/peminjaman_buku'));
        }
    }
    // END PEMINJAMAN

    // KATEGORI
    public function kategori_buku($page = 1)
    {
        $data = [
            'menu' => 'kategori',
            'user' => $this->m_member->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result(),
            'kategori' => $this->m_member->get('table_kategori')
        ];
        $per_page = 10;
        $data['buku'] = $this->m_member->get_items_terbaru($per_page, $per_page * ($page - 1), 'table_buku');

        $total_rows = $this->m_member->count_items('table_buku');
        $config['base_url'] = base_url('admin/kategori_buku');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = 3;
        $config['num_links'] = 2;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";


        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data['pagination_links'] = $this->pagination->create_links();

        $this->load->view('member/kategori/kategori', $data);
    }

    public function detail_buku($id)
    {
        $data = [
            'menu' => 'kategori',
            'buku' => $this->m_member->getwhere('table_buku', ['id_buku' => $id])->result(),
            'user' => $this->m_member->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $this->load->view('member/kategori/detail', $data);
    }

    function search_buku()
    {
        $judul = $this->input->get('judul', TRUE);
        $data['bukus'] = $this->m_member->search_by_judul($judul);

        if ($data['bukus']) {
            $this->load->view('member/kategori/search', $data);
        } else {
            $this->load->view('member/kategori/search', $data);
        }
    }

    function by_kategori_buku()
    {
        $id = $this->input->get('id', TRUE);
        $data['buku_kategori'] = $this->m_member->getwhere('table_buku', ['id_kategori' => $id])->result();

        if ($data['buku_kategori']) {
            $this->load->view('member/kategori/kategori_buku', $data);
        } else {
            $this->load->view('member/kategori/kategori_buku', $data);
        }
    }
    // END KATEGORI

    // PENGEMBALIAN
    public function pengembalian_buku($page = 1)
    {
        $data = [
            'menu' => 'pengembalian',
            'user' => $this->m_member->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $per_page = 20;
        $data['pengembalian'] = $this->m_member->get_items_where($per_page, $per_page * ($page - 1), 'table_index_pinjam', ['konfirmasi_kembali_admin' => 'yes', 'nis' => $this->session->userdata('nis')]);

        $total_rows = $this->m_member->count_items('table_index_pinjam');
        $config['base_url'] = base_url('admin/pengembalian_buku');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = 3;
        $config['num_links'] = 2;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";


        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data['pagination_links'] = $this->pagination->create_links();

        $this->load->view('member/pengembalian/pengembalian', $data);
    }

    public function detail_pengembalian($id)
    {
        $data = [
            'menu' => 'pengembalian',
            'index' => $this->m_member->getwhere('table_index_pinjam', ['index_pinjam' => $id])->result(),
            'buku' => $this->m_member->get('table_buku'),
            'pengembalian' => $this->m_member->getwhere('table_peminjaman', ['index_pinjam' => $id])->result(),
            'user' => $this->m_member->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $this->load->view('member/pengembalian/detail_pengembalian', $data);
    }

    // END PENGEMBALIAN
}
