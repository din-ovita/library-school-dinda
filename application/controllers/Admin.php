<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_admin');
        $this->load->helpers('h_helper');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('upload');
        $login = $this->session->userdata('login_admin');
        $role = $this->session->userdata('role');
        if ($login != 'login' && $role != 'admin') {
            redirect(base_url('login'));
        }
    }

    public function upload_img($value)
    {
        $kode = round(microtime(true) * 1000);
        $config['upload_path'] = './assets/buku/';
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

    public function upload_img_profile($value)
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

    public function index()
    {
        $data = [
            'menu' => 'dashboard',
            'user' => $this->m_admin->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $year = date('Y');
        $data['jan'] = $this->m_admin->all_peminjaman($year . '-01');
        $data['feb'] = $this->m_admin->all_peminjaman($year . '-02');
        $data['maret'] = $this->m_admin->all_peminjaman($year . '-03');
        $data['april'] = $this->m_admin->all_peminjaman($year . '-04');
        $data['mei'] = $this->m_admin->all_peminjaman($year . '-05');
        $data['juni'] = $this->m_admin->all_peminjaman($year . '-06');
        $data['juli'] = $this->m_admin->all_peminjaman($year . '-07');
        $data['agustus'] = $this->m_admin->all_peminjaman($year . '-08');
        $data['september'] = $this->m_admin->all_peminjaman($year . '-09');
        $data['oktober'] = $this->m_admin->all_peminjaman($year . '-10');
        $data['november'] = $this->m_admin->all_peminjaman($year . '-11');
        $data['desember'] = $this->m_admin->all_peminjaman($year . '-12');
        $this->load->view('admin/dashboard', $data);
    }

    // PROFILE
    public function profile()
    {
        $data = [
            'menu' => '',
            'user' => $this->m_admin->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $this->load->view('admin/profile', $data);
    }

    public function aksi_update_profile()
    {
        $foto = $this->upload_img_profile('foto');
        $username = $this->input->post('username');
        $new_pass = $this->input->post('new_pass');
        $confirm_pass = $this->input->post('confirm_pass');
        $id_level = $this->input->post('id_level');

        $pattern = "/^.{8}$/";

        if ($foto[0] === false) {
            if (!empty($new_pass)) {
                if (!preg_match($pattern, $new_pass)) {
                    $this->session->set_flashdata('errorNewPassAdmin', 'Password Harus 8 Karakter!');
                    redirect(base_url('admin/profile'));
                }

                if (md5($new_pass) != md5($confirm_pass)) {
                    $this->session->set_flashdata('errorConfirmPassAdmin', 'Password Baru dengan Konfirmasi Password Harus Sama!');
                    redirect(base_url('admin/profile'));
                }

                $data = [
                    'username' => $username,
                    'password' => md5($new_pass)
                ];

                $update = $this->m_admin->update_member_level($data, ['id_level' => $id_level]);
                if ($update) {
                    $this->session->set_flashdata('successEditAdmin', 'Update Profile Berhasil!');
                    redirect(base_url('admin/profile'));
                } else {
                    $this->session->set_flashdata('errorEditAdmin', 'Update Profile Gagal...');
                    redirect(base_url('admin/profile'));
                }
            } else {
                $data = [
                    'username' => $username,
                ];

                $update = $this->m_admin->update_member_level($data, ['id_level' => $id_level]);
                if ($update) {
                    $this->session->set_flashdata('successEditAdmin', 'Update Profile Berhasil!');
                    redirect(base_url('admin/profile'));
                } else {
                    $this->session->set_flashdata('errorEditAdmin', 'Update Profile Gagal...');
                    redirect(base_url('admin/profile'));
                }
            }
        } else {
            if (!empty($new_pass)) {
                if (!preg_match($pattern, $new_pass)) {
                    $this->session->set_flashdata('errorNewPassAdmin', 'Password Harus 8 Karakter!');
                    redirect(base_url('admin/profile'));
                }

                if (md5($new_pass) != md5($confirm_pass)) {
                    $this->session->set_flashdata('errorConfirmPassAdmin', 'Password Baru dengan Konfirmasi Password Harus Sama!');
                    redirect(base_url('admin/profile'));
                }

                $data = [
                    'username' => $username,
                    'password' => md5($new_pass),
                    'foto' => $foto[1]
                ];

                $update = $this->m_admin->update_member_level($data, ['id_level' => $id_level]);
                if ($update) {
                    $this->session->set_flashdata('successEditAdmin', 'Update Profile Berhasil!');
                    redirect(base_url('admin/profile'));
                } else {
                    $this->session->set_flashdata('errorEditAdmin', 'Update Profile Gagal...');
                    redirect(base_url('admin/profile'));
                }
            } else {
                $data = [
                    'username' => $username,
                    'foto' => $foto[1]
                ];

                $update = $this->m_admin->update_member_level($data, ['id_level' => $id_level]);
                if ($update) {
                    $this->session->set_flashdata('successEditAdmin', 'Update Profile Berhasil!');
                    redirect(base_url('admin/profile'));
                } else {
                    $this->session->set_flashdata('errorEditAdmin', 'Update Profile Gagal...');
                    redirect(base_url('admin/profile'));
                }
            }
        }
    }
    // END PROFILE

    // RAK BUKU
    public function rak_buku($page = 1)
    {
        $data = [
            'menu' => 'rak',
            'user' => $this->m_admin->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $per_page = 20;
        $data['rak'] = $this->m_admin->get_items_terbaru($per_page, $per_page * ($page - 1), 'table_rak');

        $total_rows = $this->m_admin->count_items('table_rak');
        $config['base_url'] = base_url('admin/rak_buku');
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
        $this->load->view('admin/rak/rak', $data);
    }

    function get_rak()
    {
        echo tampil_nama_rak($this->input->post('id'));
    }

    public function aksi_tambah_rak()
    {
        $data = [
            'nama_rak' => $this->input->post('rak')
        ];

        $tambah = $this->m_admin->tambah_rak($data);
        if ($tambah) {
            $this->session->set_flashdata('success', 'Tambah Rak Berhasil!');
            redirect(base_url('admin/rak_buku'));
        } else {
            $this->session->set_flashdata('error', 'Tambah rak gagal!');
            redirect(base_url('admin/rak_buku'));
        }
    }

    public function hapus_rak($id)
    {
        $hapus = $this->m_admin->delete('table_rak', 'id_rak', $id);
        if ($hapus) {
            redirect(base_url('admin/rak_buku'));
        } else {
            redirect(base_url('admin/rak_buku'));
        }
    }

    public function aksi_edit_rak()
    {
        $data = [
            'nama_rak' => $this->input->post('nama_rak'),
            'id_rak' => $this->input->post('id')
        ];

        $update = $this->m_admin->update_rak($data, [
            'id_rak' => $this->input->post('id')
        ]);
        if ($update) {
            $response = ['status' => 'success', 'message' => 'Edit Rak Berhasil!'];
        } else {
            $response = ['status' => 'error', 'message' => 'Edit Rak Gagal!'];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    // END RAK BUKU

    // KATEGORI BUKU
    function get_kategori()
    {
        $result = $this->m_admin->getwhere('table_kategori', ['id_kategori' => $this->input->post('id')])->result();
        echo json_encode($result);
    }

    public function kategori_buku($page = 1)
    {
        $data = [
            'menu' => 'kategori',
            'user' => $this->m_admin->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $per_page = 20;
        $data['kategori'] = $this->m_admin->get_items_terbaru($per_page, $per_page * ($page - 1), 'table_kategori');

        $total_rows = $this->m_admin->count_items('table_kategori');
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
        $data['rak'] = $this->m_admin->get('table_rak');
        $this->load->view('admin/kategori/kategori', $data);
    }

    public function aksi_tambah_kategori()
    {
        $data = [
            'id_rak' => $this->input->post('rak'),
            'nama_kategori' => $this->input->post('kategori'),
        ];

        $tambah = $this->m_admin->tambah_kategori($data);
        if ($tambah) {
            $this->session->set_flashdata('successAddKategori', 'Tambah Kategori Buku Berhasil!');
            redirect(base_url('admin/kategori_buku'));
        } else {
            $this->session->set_flashdata('errorAddKategori', 'Tambah Kategori Buku Gagal!');
            redirect(base_url('admin/kategori_buku'));
        }
    }

    public function aksi_edit_kategori()
    {
        $data = [
            'id_kategori' => $this->input->post('id'),
            'id_rak' => $this->input->post('rak'),
            'nama_kategori' => $this->input->post('kategori'),
        ];

        $update = $this->m_admin->update_kategori($data, [
            'id_kategori' => $this->input->post('id'),
        ]);
        if ($update) {
            $response = ['status' => 'success', 'message' => 'Edit Kategori Buku Berhasil!'];
        } else {
            $response = ['status' => 'error', 'message' => 'Edit Kategori Buku Gagal!'];
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function hapus_kategori($id)
    {
        $hapus = $this->m_admin->delete('table_kategori', 'id_kategori', $id);
        if ($hapus) {
            $this->session->set_flashdata('success', 'Hapus kategori berhasil!');
            redirect(base_url('admin/kategori_buku'));
        } else {
            $this->session->set_flashdata('error', 'Hapus kategori gagal!');
            redirect(base_url('admin/kategori_buku'));
        }
    }
    // END KATEGORI BUKU

    // BUKU
    public function buku($page = 1)
    {
        $data = [
            'menu' => 'buku',
            'user' => $this->m_admin->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $per_page = 20;
        $data['buku'] = $this->m_admin->get_items($per_page, $per_page * ($page - 1), 'table_buku');

        $total_rows = $this->m_admin->count_items('table_buku');
        $config['base_url'] = base_url('admin/buku');
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

        $this->load->view('admin/buku/buku', $data);
    }

    public function tambah_buku()
    {
        $data = [
            'menu' => 'buku',
            'user' => $this->m_admin->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result(),
            'kategori' => $this->m_admin->get('table_kategori')
        ];
        $this->load->view('admin/buku/tambah_buku', $data);
    }

    public function aksi_tambah_buku()
    {
        $kategori = $this->input->post('kategori');
        $judul = $this->input->post('judul');
        $cover = $this->upload_img('cover');
        $jumlah = $this->input->post('jumlah');
        $deskripsi = $this->input->post('deskripsi');
        $pengarang = $this->input->post('pengarang');
        $index = $this->acak(6);

        if ($cover[0] == false) {
            $data = ['id_kategori' => $kategori, 'foto' => 'book.png', 'nama_buku' => $judul, 'jumlah' => $jumlah, 'index_buku' => 'IB-' . $index, 'pengarang' => $pengarang, 'deskripsi' => $deskripsi];
        } else {
            $data = ['id_kategori' => $kategori, 'foto' => $cover[1], 'nama_buku' => $judul, 'jumlah' => $jumlah, 'index_buku' => 'IB-' . $index, 'pengarang' => $pengarang, 'deskripsi' => $deskripsi];
        }

        $add_book = $this->m_admin->tambah_buku($data);

        if ($add_book) {
            $index_buku = [];

            for ($i = 1; $i <= $jumlah; $i++) {
                echo $i;
                $index_buku[] = ['id_buku' => $add_book, 'index_buku' => 'IB-' . $index . $i];
            }

            $this->m_admin->tambah_index_buku($index_buku);
            $this->session->set_flashdata('successAddBuku', 'Tambah Buku Berhasil!');
            redirect(base_url('admin/buku'));
        } else {
            $this->session->set_flashdata('errorAddBuku', 'Tambah Buku Gagal!');
            redirect(base_url('admin/tambah_buku'));
        }
    }

    public function edit_buku($id)
    {
        $data = [
            'menu' => 'buku',
            'kategori' => $this->m_admin->get('table_kategori'),
            'buku' => $this->m_admin->getwhere('table_buku', ['id_buku' => $id])->result(),
            'user' => $this->m_admin->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $this->load->view('admin/buku/edit_buku', $data);
    }

    public function aksi_edit_buku()
    {
        $kategori = $this->input->post('kategori');
        $judul = $this->input->post('judul');
        $pengarang = $this->input->post('pengarang');
        $deskripsi = $this->input->post('deskripsi');
        $cover = $this->upload_img('cover');
        $id_buku = $this->input->post('id_buku');

        if ($cover[0] === false) {
            $data = ['id_kategori' => $kategori, 'nama_buku' => $judul, 'id_buku' => $id_buku, 'pengarang' => $pengarang, 'deskripsi' => $deskripsi];
            echo "kurang";
        } else {
            $data = ['id_kategori' => $kategori, 'foto' => $cover[1], 'nama_buku' => $judul, 'id_buku' => $id_buku, 'pengarang' => $pengarang, 'deskripsi' => $deskripsi];
        }

        $edit = $this->m_admin->update_buku($data, ['id_buku' => $id_buku]);


        if ($edit) {
            $this->session->set_flashdata('successEditBuku', 'Edit Buku Berhasil!');
            redirect(base_url('admin/buku'));
        } else {
            $this->session->set_flashdata('errorEditBuku', 'Edit Buku Gagal!');
            redirect(base_url('admin/edit_buku/' . $id_buku));
        }
    }

    public function hapus_buku($id)
    {

        $index = $this->m_admin->getwhere('table_id_buku', ['id_buku' => $id])->result();

        foreach ($index as $i) {
            $this->m_admin->delete('table_id_buku', 'id', $i->id);
            echo $i->id;
        }

        $hapus = $this->m_admin->delete('table_buku', 'id_buku', $id);

        if ($hapus) {
            $this->session->set_flashdata('success', 'Hapus buku berhasil!');
        } else {
            $this->session->set_flashdata('error', 'Hapus buku gagal!');
        }

        redirect(base_url('admin/buku'));
    }

    public function hapus_index_buku($id)
    {
        $id_buku = idBuku_byIndex($id);

        $hapus = $this->m_admin->delete('table_id_buku', 'id', $id);

        $dataBuku = [
            'id_buku' => $id_buku,
            'jumlah' => max(0, jumlah_buku($id_buku) - 1)
        ];

        $this->m_admin->update_buku($dataBuku, ['id_buku' => $id_buku]);

        if ($hapus) {
            $this->session->set_flashdata('success', 'Hapus index buku berhasil!');
        } else {
            $this->session->set_flashdata('error', 'Hapus index buku gagal!');
        }

        redirect(base_url('admin/detail_buku/' . $id_buku));
    }

    public function detail_buku($id)
    {
        $data = [
            'menu' => 'buku',
            'buku' => $this->m_admin->getwhere('table_buku', ['id_buku' => $id])->result(),
            'index' => $this->m_admin->getwhere('table_id_buku', ['id_buku' => $id])->result(),
            'user' => $this->m_admin->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $this->load->view('admin/buku/detail_buku', $data);
    }

    public function aksi_tambah_jumlah_buku()
    {
        $id_buku = $this->input->post('id');
        $jumlah = $this->input->post('jumlah');

        $old_jumlah = jumlah_buku($id_buku) + 1;
        $index_buku = index_buku($id_buku);

        $dataBuku = [
            'id_buku' => $id_buku,
            'jumlah' => $old_jumlah + $jumlah
        ];

        $buku = $this->m_admin->update_buku($dataBuku, ['id_buku' => $id_buku]);
        if ($buku) {
            $insert = [];

            for ($i = $old_jumlah; $i < $old_jumlah + $jumlah; $i++) {
                $insert[] = ['id_buku' => $id_buku, 'index_buku' => $index_buku . $i];
            }

            $this->m_admin->tambah_index_buku($insert);
            $this->session->set_flashdata('jmlBuku', 'Tambah jumlah buku berhasil!');
            redirect(base_url('admin/detail_buku/' . $id_buku));
        } else {
            $this->session->set_flashdata('!jmlBuku', 'Tambah jumlah buku gagal!');
            redirect(base_url('admin/detail_buku/' . $id_buku));
        }
    }
    // END BUKU

    // ANGGOTA
    public function anggota($page = 1)
    {
        $data = [
            'menu' => 'anggota',
            'user' => $this->m_admin->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $per_page = 20;
        $data['anggota'] = $this->m_admin->get_items($per_page, $per_page * ($page - 1), 'table_member');

        $total_rows = $this->m_admin->count_items('table_member');
        $config['base_url'] = base_url('admin/anggota');
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

        $this->load->view('admin/anggota/anggota', $data);
    }

    public function aksi_tambah_anggota()
    {
        $nama = $this->input->post('anggota');
        $nis = $this->input->post('nis');

        $data_level = [
            'username' => $nama,
            'password' => md5($nis),
            'nis' => $nis,
            'role' => 'member'
        ];

        $level = $this->m_admin->tambah_level($data_level);
        if ($level) {
            $member = [
                'nis' => $nis,
                'id_level' => $level,
                'nama' => $nama,
            ];
            $this->m_admin->tambah_member($member);
            $this->session->set_flashdata('successAddMember', 'Tambah Anggota Berhasil!');
            redirect(base_url('admin/anggota'));
        } else {
            $this->session->set_flashdata('errorAddMember', 'Tambah Anggota Gagal!');
            redirect(base_url('admin/anggota'));
        }
    }

    public function hapus_member($id)
    {
        $id_level = idLevel_byMember($id);

        $hapus = $this->m_admin->delete('table_level', 'id_level', $id_level);

        if ($hapus) {
            $this->m_admin->delete('table_member', 'id_member', $id);
            $this->session->set_flashdata('success', 'Hapus index buku berhasil!');
        } else {
            $this->session->set_flashdata('error', 'Hapus index buku gagal!');
        }

        redirect(base_url('admin/anggota'));
    }

    public function tambah_member_by_excel()
    {

        require_once FCPATH . 'vendor/autoload.php';

        if (isset($_FILES["file"]["name"])) {
            $path = $_FILES["file"]["tmp_name"];
            $object = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);

            $data_to_insert = [];
            $member = [];

            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();

                for ($row = 4; $row <= $highestRow; $row++) {
                    $nis = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $nama = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

                    $data_to_insert[] = [
                        'username' => $nama,
                        'password' => md5($nis),
                        'role'     => 'member',
                        'nis'      => $nis
                    ];

                    $member[] = [
                        'nama' => $nama,
                        'nis' => $nis,
                    ];
                }
            }

            if (!empty($data_to_insert)) {
                $inserted_ids = array();

                foreach ($data_to_insert as $data) {
                    $this->db->insert('table_level', $data);
                    $inserted_ids[] = $this->db->insert_id();
                }

                if (!empty($inserted_ids)) {
                    foreach ($member as &$m) {
                        $m['id_level'] = array_shift($inserted_ids);
                    }

                    $this->db->insert_batch('table_member', $member);

                    $this->session->set_flashdata('success', 'Berhasil upload anggota!');
                    redirect(base_url('admin/anggota'));
                } else {
                    $this->session->set_flashdata('error', 'Gagal upload anggota!');
                    redirect(base_url('admin/anggota'));
                }
            } else {
                echo 'No data to insert.';
            }
        } else {
            echo 'File not uploaded.';
            $this->session->set_flashdata('error', 'Gagal upload anggota!');
            redirect(base_url('admin/anggota'));
        }
    }

    public function export_anggota()
    {
        require_once FCPATH . 'vendor/autoload.php';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ]
        ];

        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ]
        ];

        $sheet->setCellValue('A1', "DATA ANGGOTA PERPUSTAKAAN SMK BINUSA");
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getFont()->setBold(true);

        $sheet->setCellValue('A3', "NO");
        $sheet->setCellValue('B3', "NAMA");
        $sheet->setCellValue('C3', "NIS");

        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);

        $member = $this->m_admin->get('table_member');

        $no = 1;
        $numrow = 4;

        foreach ($member as $data) {
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data->nama);
            $sheet->setCellValue('C' . $numrow, $data->nis);

            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);

            $no++;
            $numrow++;
        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(35);
        $sheet->getColumnDimension('C')->setWidth(15);

        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->setTitle('DATA ANGGOTA');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="data_anggota.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }

    public function edit_anggota($id)
    {
        $data = [
            'menu' => 'anggota',
            'user' => $this->m_admin->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result(),
            'member' => $this->m_admin->getwhere('table_member', ['id_member' => $id])->result()
        ];
        $this->load->view('admin/anggota/edit_anggota', $data);
    }

    public function aksi_edit_anggota()
    {
        $id_member = $this->input->post('id_member');
        $nama = $this->input->post('nama');
        $nis = $this->input->post('nis');
        $new_pass = $this->input->post('new_pass');
        $confirm_pass = $this->input->post('confirm_pass');
        $id_level = idLevel_byMember($id_member);

        $pattern = "/^.{8}$/";

        if (!empty($new_pass)) {
            if (!preg_match($pattern, $new_pass)) {
                $this->session->set_flashdata('errorNewPass', 'Password Harus 8 Karakter!');
                redirect(base_url('admin/edit_anggota/' . $id_member));
            }

            if (md5($new_pass) != md5($confirm_pass)) {
                $this->session->set_flashdata('errorConfirmPass', 'Password Baru dengan Konfirmasi Password Harus Sama!');
                redirect(base_url('admin/edit_anggota/' . $id_member));
            }

            $data_member = [
                'id_member' => $id_member,
                'nis' => $nis,
                'nama' => $nama,
            ];

            $data_level = [
                'id_level' => $id_level,
                'password' => md5($new_pass)
            ];

            $edit_member = $this->m_admin->update_member($data_member, ['id_member' => $id_member]);
            $edit_pass = $this->m_admin->update_member_level($data_level, ['id_level' => $id_level]);

            if ($edit_member && $edit_pass) {
                $this->session->set_flashdata('successEdit', 'Update Anggota Berhasil!');
                redirect(base_url('admin/anggota'));
            } else {
                $this->session->set_flashdata('errorEdit', 'Update Anggota Gagal...');
                redirect(base_url('admin/edit_anggota/' . $id_member));
            }
        } else {
            $data_member = [
                'id_member' => $id_member,
                'nis' => $nis,
                'nama' => $nama,
            ];

            $edit_member = $this->m_admin->update_member($data_member, ['id_member' => $id_member]);

            if ($edit_member) {
                $this->session->set_flashdata('successEdit', 'Update Anggota Berhasil!');
                redirect(base_url('admin/anggota'));
            } else {
                $this->session->set_flashdata('errorEdit', 'Update Anggota Gagal...');
                redirect(base_url('admin/edit_anggota/' . $id_member));
            }
        }
    }
    // END ANGGOTA

    // PEMINJAMAN
    function jumlah_buku()
    {
        echo jumlah_buku_tersedia($this->input->post('id_buku'));
    }

    public function peminjaman_buku($page = 1)
    {
        $data = [
            'menu' => 'peminjaman',
            'user' => $this->m_admin->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $per_page = 20;
        $data['peminjaman'] = $this->m_admin->get_items_where($per_page, $per_page * ($page - 1), 'table_index_pinjam', ['konfirmasi_kembali' => 'not']);

        $total_rows = $this->m_admin->count_items('table_index_pinjam');
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

        $this->load->view('admin/peminjaman/peminjaman', $data);
    }

    public function tambah_peminjaman_buku()
    {
        $data = [
            'menu' => 'peminjaman',
            'index' => 'IP-' . $this->acak(6),
            'tgl_pinjam' => date('Y-m-d'),
            'tgl_kembali' => date('Y-m-d', strtotime('+6 days')),
            'member' => $this->m_admin->get('table_member'),
            'buku' => $this->m_admin->get('table_buku'),
            'user' => $this->m_admin->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $this->load->view('admin/peminjaman/tambah_peminjaman_buku', $data);
    }

    public function aksi_tambah_peminjaman_buku()
    {
        $index = $this->input->post('index');
        $tgl_pinjam = $this->input->post('tgl_pinjam');
        $tgl_kembali = $this->input->post('tgl_kembali');
        $member = $this->input->post('member');
        $buku = $this->input->post('buku');
        $jumlah = $this->input->post('jumlah');

        $index_pinjam = [
            'index_pinjam' => $index,
            'tgl_pinjam' => $tgl_pinjam,
            'tgl_kembali' => $tgl_kembali,
            'nis' => $member,
            'konfirmasi_pinjam' => 'yes'
        ];

        $add_index_pinjam = $this->m_admin->tambah_index_pinjam($index_pinjam);

        if ($add_index_pinjam) {
            $books = $this->m_admin->peminjaman(['id_buku' => $buku, 'status' => 'tersedia'], $jumlah);

            $data = [];
            $status = [];

            foreach ($books as $row) {
                $data[] = [
                    'index_buku' => $row->index_buku,
                    'id_buku' => $buku,
                    'index_pinjam' => index_pinjam($add_index_pinjam),
                    'nis' => $member
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
            redirect(base_url('admin/tambah_buku_dipinjam/' . index_pinjam($add_index_pinjam)));
        } else {
            $this->session->set_flashdata('error', 'Tambah peminjaman gagal!');
            redirect(base_url('admin/tambah_peminjaman_buku'));
        }
    }

    public function tambah_buku_dipinjam($id)
    {
        $data = [
            'menu' => 'peminjaman',
            'index' => $this->m_admin->getwhere('table_index_pinjam', ['index_pinjam' => $id])->result(),
            'buku' => $this->m_admin->get('table_buku'),
            'peminjaman' => $this->m_admin->getwhere('table_peminjaman', ['index_pinjam' => $id])->result(),
            'user' => $this->m_admin->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $this->load->view('admin/peminjaman/tambah_buku_dipinjam', $data);
    }

    public function aksi_tambah_buku_dipinjam()
    {
        $index = $this->input->post('index');
        $member = $this->input->post('member');
        $buku = $this->input->post('buku');
        $jumlah = $this->input->post('jumlah');

        $books = $this->m_admin->peminjaman(['id_buku' => $buku, 'status' => 'tersedia'], $jumlah);

        $data = [];
        $status = [];

        foreach ($books as $row) {
            $data[] = [
                'index_buku' => $row->index_buku,
                'index_pinjam' => $index,
                'id_buku' => $buku,
                'nis' => $member
            ];

            $status[] = [
                'index_buku' => $row->index_buku,
                'status' => 'dipinjam',
                'id' => $row->id
            ];
        }

        $add = $this->db->insert_batch('table_peminjaman', $data);
        if ($add) {
            $this->db->update_batch('table_id_buku', $status, 'id');
            $this->session->set_flashdata('success', 'Tambah peminjaman berhasil!');
            redirect(base_url('admin/tambah_buku_dipinjam/' . $index));
        } else {
            $this->session->set_flashdata('error', 'Tambah peminjaman gagal!');
            redirect(base_url('admin/tambah_buku_dipinjam/' . $index));
        }
    }

    public function detail_peminjaman($id)
    {
        $data = [
            'menu' => 'peminjaman',
            'index' => $this->m_admin->getwhere('table_index_pinjam', ['index_pinjam' => $id])->result(),
            'buku' => $this->m_admin->get('table_buku'),
            'peminjaman' => $this->m_admin->getwhere('table_peminjaman', ['index_pinjam' => $id])->result(),
            'user' => $this->m_admin->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $this->load->view('admin/peminjaman/detail_peminjaman', $data);
    }

    public function konfirmasi_pinjam($id)
    {
        $data = [
            'index_pinjam' => $id,
            'tgl_pinjam' => date('Y-m-d'),
            'tgl_kembali' => date('Y-m-d', strtotime('+6 days')),
            'konfirmasi_pinjam' => 'yes'
        ];
        $konfimasi = $this->m_admin->konfirmasi_peminjaman($data, $id);
        if ($konfimasi) {
            $this->session->set_flashdata('success', 'Konfirmasi peminjaman berhasil!');
            redirect(base_url('admin/peminjaman_buku'));
        } else {
            $this->session->set_flashdata('error', 'Konfirmasi peminjaman gagal!');
            redirect(base_url('admin/peminjaman_buku'));
        }
    }

    public function konfirmasi_kembali($id)
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

            $this->m_admin->tambah_telat_mengembalikan($data_telat);
        }

        $data = [
            'index_pinjam' => $id,
            'konfirmasi_kembali_admin' => 'yes',
            'konfirmasi_kembali' => 'yes',
            'tgl_pengembalian' => date('Y-m-d'),
            'status' => $status,
        ];
        $konfimasi = $this->m_admin->konfirmasi_peminjaman($data, $id);
        if ($konfimasi) {
            $peminjaman = $this->m_admin->getwhere('table_peminjaman', ['index_pinjam' => $id])->result();

            $data_buku = [];

            foreach ($peminjaman as $row) {
                $data_buku[] = [
                    'index_buku' => $row->index_buku,
                    'status' => 'tersedia'
                ];
            }

            $this->db->update_batch('table_id_buku', $data_buku, 'index_buku');

            $this->session->set_flashdata('success', 'Konfirmasi pengembalian berhasil!');
            redirect(base_url('admin/peminjaman_buku'));
        } else {
            $this->session->set_flashdata('error', 'Konfirmasi pengembalian gagal!');
            redirect(base_url('admin/peminjaman_buku'));
        }
    }

    public function hapus_peminjaman($id)
    {
        $peminjaman = $this->m_admin->getwhere('table_peminjaman', ['index_pinjam' => $id])->result();

        $data_buku = [];

        foreach ($peminjaman as $row) {
            $data_buku[] = [
                'index_buku' => $row->index_buku,
                'status' => 'tersedia'
            ];
        }

        $this->db->update_batch('table_id_buku', $data_buku, 'index_buku');

        $this->m_admin->delete('table_index_pinjam', 'index_pinjam', $id);

        $hapus_pinjam = $this->m_admin->deletewhere('table_peminjaman', ['index_pinjam' => $id]);

        if ($hapus_pinjam) {
            $this->session->set_flashdata('success', 'Hapus peminjaman berhasil!');
            redirect(base_url('admin/peminjaman_buku'));
        } else {
            $this->session->set_flashdata('error', 'Hapus peminjaman gagal!');
            redirect(base_url('admin/peminjaman_buku'));
        }
    }
    // END PEMINJAMAN

    // PENGEMBALIAN
    public function pengembalian_buku($page = 1)
    {
        $data = [
            'menu' => 'pengembalian',
            'user' => $this->m_admin->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $per_page = 20;
        $data['pengembalian'] = $this->m_admin->get_items_where($per_page, $per_page * ($page - 1), 'table_index_pinjam', ['konfirmasi_kembali' => 'yes']);

        $total_rows = $this->m_admin->count_items('table_index_pinjam');
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

        $this->load->view('admin/pengembalian/pengembalian', $data);
    }

    public function hapus_pengembalian($id)
    {
        $this->m_admin->delete('table_index_pinjam', 'index_pinjam', $id);

        $hapus_pinjam = $this->m_admin->deletewhere('table_peminjaman', ['index_pinjam' => $id]);

        if ($hapus_pinjam) {
            $this->session->set_flashdata('success', 'Hapus pengembalian berhasil!');
            redirect(base_url('admin/pengembalian_buku'));
        } else {
            $this->session->set_flashdata('error', 'Hapus pengembalian gagal!');
            redirect(base_url('admin/pengembalian_buku'));
        }
    }

    public function detail_pengembalian($id)
    {
        $data = [
            'menu' => 'pengembalian',
            'index' => $this->m_admin->getwhere('table_index_pinjam', ['index_pinjam' => $id])->result(),
            'buku' => $this->m_admin->get('table_buku'),
            'pengembalian' => $this->m_admin->getwhere('table_peminjaman', ['index_pinjam' => $id])->result(),
            'user' => $this->m_admin->getwhere('table_level', ['id_level' => $this->session->userdata('id')])->result()
        ];
        $this->load->view('admin/pengembalian/detail_pengembalian', $data);
    }

    public function aksi_edit_denda()
    {
        $data  = [
            'id' => $this->input->post('id_denda'),
            'denda' => $this->input->post('nominal')
        ];
        $edit = $this->m_admin->update_denda($data, ['id' => $this->input->post('id_denda')]);
        if ($edit) {
            $this->session->set_flashdata('success', 'Ubah denda berhasil!');
            redirect(base_url('admin/peminjaman_buku'));
        } else {
            $this->session->set_flashdata('error', 'Ubah denda gagal!');
            redirect(base_url('admin/peminjaman_buku'));
        }
    }

    public function konfirmasi_bayar_denda($id)
    {
        $data = [
            'konfirmasi' => 'sudah bayar',
            'index_pinjam' => $id
        ];

        $konfirmasi = $this->m_admin->konfirmasi_bayar_denda($data, ['index_pinjam' => $id]);
        if ($konfirmasi) {
            $this->session->set_flashdata('success', 'Konfirmasi bayar denda berhasil!');
            redirect(base_url('admin/pengembalian_buku'));
        } else {
            $this->session->set_flashdata('error', 'Konfirmasi bayar denda gagal!');
            redirect(base_url('admin/pengembalian_buku'));
        }
    }
    // END PENGEMBALIAN
}
