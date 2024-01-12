<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
        $this->load->library('excel');
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
            'menu' => 'dashboard'
        ];
        $this->load->view('admin/dashboard', $data);
    }

    // RAK BUKU
    public function rak_buku()
    {
        $data = [
            'menu' => 'rak'
        ];
        $data['rak'] = $this->m_admin->get('table_rak');
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
            $this->session->set_flashdata('error', 'Tambah rak gagal!');
            redirect(base_url('admin/rak_buku'));
        } else {
            $this->session->set_flashdata('success', 'Tambah rak berhasil!');
            redirect(base_url('admin/rak_buku'));
        }
    }

    public function hapus_rak($id)
    {
        $hapus = $this->m_admin->delete('table_rak', 'id_rak', $id);
        if ($hapus) {
            $this->session->set_flashdata('error', 'Hapus rak gagal!');
            redirect(base_url('admin/rak_buku'));
        } else {
            $this->session->set_flashdata('success', 'Hapus rak berhasil!');
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
            $this->session->set_flashdata('error', 'Edit rak gagal!');
            redirect(base_url('admin/rak_buku'));
        } else {
            $this->session->set_flashdata('success', 'Edit rak berhasil!');
            redirect(base_url('admin/rak_buku'));
        }
    }
    // END RAK BUKU

    // KATEGORI BUKU
    function get_kategori()
    {
        $result = $this->m_admin->getwhere('table_kategori', ['id_kategori' => $this->input->post('id')])->result();
        echo json_encode($result);
    }

    public function kategori_buku()
    {
        $data = [
            'menu' => 'kategori'
        ];
        $data['kategori'] = $this->m_admin->get('table_kategori');
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
            $this->session->set_flashdata('error', 'Tambah kategori buku gagal!');
            redirect(base_url('admin/kategori_buku'));
        } else {
            $this->session->set_flashdata('success', 'Tambah kategori buku berhasil!');
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
            $this->session->set_flashdata('error', 'Edit kategori buku gagal!');
            redirect(base_url('admin/kategori_buku'));
        } else {
            $this->session->set_flashdata('success', 'Edit kategori buku berhasil!');
            redirect(base_url('admin/kategori_buku'));
        }
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
    public function buku()
    {
        $data = [
            'menu' => 'buku',
            'buku' => $this->m_admin->get('table_buku')
        ];
        $this->load->view('admin/buku/buku', $data);
    }

    public function tambah_buku()
    {
        $data = [
            'menu' => 'buku',
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
        $index = $this->acak(6);

        if ($cover[0] == false) {
            $data = ['id_kategori' => $kategori, 'foto' => 'book.png', 'nama_buku' => $judul, 'jumlah' => $jumlah, 'index_buku' => 'IB-' . $index];
        } else {
            $data = ['id_kategori' => $kategori, 'foto' => $cover[1], 'nama_buku' => $judul, 'jumlah' => $jumlah, 'index_buku' => 'IB-' . $index];
        }

        $add_book = $this->m_admin->tambah_buku($data);

        if ($add_book) {
            $index_buku = [];

            for ($i = 1; $i <= $jumlah; $i++) {
                echo $i;
                $index_buku[] = ['id_buku' => $add_book, 'index_buku' => 'IB-' . $index . $i];
            }

            $this->m_admin->tambah_index_buku($index_buku);
            $this->session->set_flashdata('buku', 'Tambah buku berhasil!');
            redirect(base_url('admin/buku'));
        } else {
            $this->session->set_flashdata('errorBuku', 'Tambah buku gagal!');
            redirect(base_url('admin/tambah_buku'));
        }
    }

    public function edit_buku($id)
    {
        $data = [
            'menu' => 'buku',
            'kategori' => $this->m_admin->get('table_kategori'),
            'buku' => $this->m_admin->getwhere('table_buku', ['id_buku' => $id])->result()
        ];
        $this->load->view('admin/buku/edit_buku', $data);
    }

    public function aksi_edit_buku()
    {
        $kategori = $this->input->post('kategori');
        $judul = $this->input->post('judul');
        $cover = $this->upload_img('cover');
        $id_buku = $this->input->post('id_buku');

        if ($cover[0] === false) {
            $data = ['id_kategori' => $kategori, 'nama_buku' => $judul, 'id_buku' => $id_buku];
            echo "kurang";
        } else {
            $data = ['id_kategori' => $kategori, 'foto' => $cover[1], 'nama_buku' => $judul, 'id_buku' => $id_buku];
        }

        $edit = $this->m_admin->update_buku($data, ['id_buku' => $id_buku]);


        if ($edit) {
            $this->session->set_flashdata('editBuku', 'Edit buku berhasil!');
            redirect(base_url('admin/buku'));
        } else {
            $this->session->set_flashdata('buku', 'Edit buku gagal!');
            redirect(base_url('admin/edit_buku/' . $id_buku));
        }
    }

    public function hapus_buku($id)
    {

        $index = $this->m_admin->getwhere('tabel_id_buku', ['id_buku' => $id])->result();

        foreach ($index as $i) {
            $this->m_admin->delete('tabel_id_buku', 'id', $i->id);
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

        $hapus = $this->m_admin->delete('tabel_id_buku', 'id', $id);

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
            'index' => $this->m_admin->getwhere('tabel_id_buku', ['id_buku' => $id])->result()
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
    public function anggota()
    {
        $data = [
            'menu' => 'anggota',
            'anggota' => $this->m_admin->get('table_member')
        ];
        $this->load->view('admin/anggota/anggota', $data);
    }

    public function aksi_tambah_anggota()
    {
        $nama = $this->input->post('anggota');
        $nis = $this->input->post('nis');

        $data_level = [
            'username' => $nama,
            'password' => md5($nis),
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
            $this->session->set_flashdata('member', 'Tambah anggota berhasil!');
            redirect(base_url('admin/anggota'));
        } else {
            $this->session->set_flashdata('error', 'Tambah anggota gagal!');
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
        if (isset($_FILES["fileExcel"]["name"])) {
            $path = $_FILES["fileExcel"]["tmp_name"];
            $object = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                for ($row = 4; $row <= $highestRow; $row++) {
                    $username = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $email = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $nama_depan = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $nama_belakang = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $temp_data[] = array(
                        'username' => $username,
                        'email' => $email,
                        'nama_depan'    => $nama_depan,
                        'nama_belakang'    => $nama_belakang,
                        'image' => 'user_picture.jpg',
                        'password' => md5('preSent12'),
                        'role' => 'karyawan'
                    );
                }
            }
            $this->m_user->insert($temp_data);
        }
    }

    // public function import_karyawan()
    // {
    //     require_once FCPATH . 'vendor/autoload.php';
    //     if (isset($_FILES["fileExcel"]["name"])) {
    //         $path = $_FILES["fileExcel"]["tmp_name"];
    //         $object = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
    //         foreach ($object->getWorksheetIterator() as $worksheet) {
    //             $highestRow = $worksheet->getHighestRow();
    //             for ($row = 4; $row <= $highestRow; $row++) {
    //                 $username = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
    //                 $email = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
    //                 $nama_depan = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
    //                 $nama_belakang = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
    //                 $temp_data[] = array(
    //                     'username' => $username,
    //                     'email' => $email,
    //                     'nama_depan'    => $nama_depan,
    //                     'nama_belakang'    => $nama_belakang,
    //                     'image' => 'user_picture.jpg',
    //                     'password' => md5('preSent12'),
    //                     'role' => 'karyawan'
    //                 );
    //             }
    //         }
    //         $this->m_user->insert($temp_data);
    //         $this->session->set_flashdata('sukses', 'Employee data added successfully');
    //         redirect(base_url('admin/data_karyawan'));
    //     }
    // }

    // public function upload_nilai_sumatif()
    // {
    //     $jenis = $this->input->post('jenis_nilai');
    //     $this->load->library('excel');
    //     $temp_data = [];
    //     $data = [];

    //     $add_sumatif_rapor = [];
    //     $up_sumatif_rapor = [];

    //     $add_sumatif = [];
    //     $up_sumatif = [];

    //     if ($jenis === 'NILAI_SUMATIF') {
    //         $path = $_FILES["file"]["tmp_name"];
    //         $objPHPExcel = PHPExcel_IOFactory::load($path);

    //         $sheet = $objPHPExcel->getActiveSheet();
    //         $mapel = $sheet->getCell('C3')->getValue();
    //         $kelas = $sheet->getCell('C7')->getValue();
    //         $semester = $sheet->getCell('C5')->getValue();
    //         $guru = $sheet->getCell('C6')->getValue();
    //         $jmlPenilaian = $sheet->getCell('J10')->getValue();
    //         $array = explode(' ', $kelas);

    //         $col = 3;
    //         $target_capaian = $this->m_nilai->get_targetcapaian_bykelas_limit($array[1], tampil_id_mapel($mapel), $jmlPenilaian);

    //         foreach ($target_capaian as $target) {
    //             $batas_c = $sheet->getCell(PHPExcel_Cell::stringFromColumnIndex($col) . '5')->getValue();
    //             $batas_b = $sheet->getCell(PHPExcel_Cell::stringFromColumnIndex($col) . '6')->getValue();
    //             $batas_sb = $sheet->getCell(PHPExcel_Cell::stringFromColumnIndex($col) . '7')->getValue();
    //             for ($i = 12; $i <= $sheet->getHighestRow(); $i++) {
    //                 $nilaisumatif = $sheet->getCell(PHPExcel_Cell::stringFromColumnIndex($col) . $i)->getValue();
    //                 $nisn = $sheet->getCell('C' . $i)->getValue();

    //                 $id_siswa = tampil_idSiswa_bynisn($nisn);
    //                 $id_kelas = $array[1];

    //                 $tujuan = '';
    //                 if ($nilaisumatif <= $batas_c) {
    //                     $tujuan = 'Kurang';
    //                 } else if ($nilaisumatif <= $batas_b) {
    //                     $tujuan = 'Cukup';
    //                 } else if ($nilaisumatif <= $batas_sb) {
    //                     $tujuan = 'Baik';
    //                 } else {
    //                     $tujuan = 'Sangat Baik';
    //                 }

    //                 if (empty(tampil_id_nilai_sumatif($id_siswa, $target->id_target, $id_kelas))) {
    //                     array_push(
    //                         $add_sumatif,
    //                         [
    //                             'id_siswa' => $id_siswa,
    //                             'id_kelas' => $id_kelas,
    //                             'id_mapel' => tampil_id_mapel($mapel),
    //                             'id_semester' => tampil_id_semester($semester),
    //                             'nilai' => $nilaisumatif,
    //                             'id_target' => $target->id_target,
    //                             'kode_guru' => tampil_kode_guru($guru),
    //                             'tujuan' => $tujuan
    //                         ]
    //                     );
    //                 } else {
    //                     array_push(
    //                         $up_sumatif,
    //                         [
    //                             'id_siswa' => $id_siswa,
    //                             'id_kelas' => $id_kelas,
    //                             'id_mapel' => tampil_id_mapel($mapel),
    //                             'id_semester' => tampil_id_semester($semester),
    //                             'nilai' => $nilaisumatif,
    //                             'id_nilai' => tampil_id_nilai_sumatif($id_siswa, $target->id_target, $id_kelas),
    //                             'id_target' => $target->id_target,
    //                             'kode_guru' => tampil_kode_guru($guru),
    //                             'tujuan' => $tujuan
    //                         ]
    //                     );
    //                 }

    //             }
    //             $col++;
    //         }

    //         $this->session->set_flashdata('sukses', 'Data berhasil ditambahkan');
    //         $this->m_nilai->nilai_sumatif($add_sumatif, $up_sumatif);

    //         redirect(base_url('nilai/upload_nilai'));
    //     } else {
    //         $path = $_FILES["file"]["tmp_name"];
    //         $objPHPExcel = PHPExcel_IOFactory::load($path);

    //         $sheet = $objPHPExcel->getActiveSheet();
    //         $mapel = $sheet->getCell('D3')->getValue();
    //         $kelas = $sheet->getCell('D6')->getValue();
    //         $semester = $sheet->getCell('D5')->getValue();
    //         $array = explode(' ', $kelas);


    //         for ($i = 10; $i <= $sheet->getHighestRow(); $i++) {
    //             $nisn = $sheet->getCell('C' . $i)->getValue();
    //             $sumatifakhir = $sheet->getCell('D' . $i)->getValue();
    //             if (empty(tampil_sumatif_akhir($array[1], tampil_id_semester($semester), tampil_idSiswa_bynisn($nisn), tampil_id_mapel($mapel)))) {
    //                 array_push(
    //                     $temp_data,
    //                     [
    //                         'id_siswa' => tampil_idSiswa_bynisn($nisn),
    //                         'id_mapel' => tampil_id_mapel($mapel),
    //                         'id_semester' => tampil_id_semester($semester),
    //                         'sumatifakhir' => $sumatifakhir,
    //                         'id_kelas' => $array[1]
    //                     ]
    //                 );
    //             } else {
    //                 array_push($data, [
    //                     'id_siswa' => tampil_idSiswa_bynisn($nisn),
    //                     'id_mapel' => tampil_id_mapel($mapel),
    //                     'id_semester' => tampil_id_semester($semester),
    //                     'sumatifakhir' => $sumatifakhir,
    //                     'id_kelas' => $array[1],
    //                     'id_sumatif_akhir' => tampil_sumatif_akhir($array[1], tampil_id_semester($semester), tampil_idSiswa_bynisn($nisn), tampil_id_mapel($mapel))
    //                 ]);
    //             }

    //             $nama_column = '';
    //             $cek_data_nilai = $this->m_nilai->getwhere('tabel_sumatif_akhir_raport', ['id_siswa' => tampil_idSiswa_bynisn($nisn)])->num_rows();
    //             if (tampil_idTingkatById($array[1]) == '1' && tampil_id_semester($semester) == '1') {
    //                 $nama_column = 'sumatifakhir1';
    //             } else if (tampil_idTingkatById($array[1]) == '1' && tampil_id_semester($semester) == '2') {
    //                 $nama_column = 'sumatifakhir2';
    //             } else if (tampil_idTingkatById($array[1]) == '2' && tampil_id_semester($semester) == '1') {
    //                 $nama_column = 'sumatifakhir3';
    //             } else if (tampil_idTingkatById($array[1]) == '2' && tampil_id_semester($semester) == '2') {
    //                 $nama_column = 'sumatifakhir4';
    //             } else if (tampil_idTingkatById($array[1]) == '3' && tampil_id_semester($semester) == '1') {
    //                 $nama_column = 'sumatifakhir5';
    //             } else if (tampil_idTingkatById($array[1]) == '3' && tampil_id_semester($semester) == '2') {
    //                 $nama_column = 'sumatifakhir6';
    //             }

    //             if ($cek_data_nilai == null) {
    //                 array_push($add_sumatif_rapor, [
    //                     'id_kelas_sekarang' => $array[1],
    //                     'id_siswa' => tampil_idSiswa_bynisn($nisn),
    //                     'id_mapel' => tampil_id_mapel($mapel),
    //                     $nama_column => $sumatifakhir,
    //                 ]);
    //             } else {
    //                 array_push($up_sumatif_rapor, [
    //                     'id_kelas_sekarang' => $array[1],
    //                     $nama_column => $sumatifakhir,
    //                     'id_sumatif_akhir' => tampil_sumatif_akhir_rapor($array[1], tampil_idSiswa_bynisn($nisn), tampil_id_mapel($mapel))
    //                 ]);
    //             }
    //         }

    //         $this->m_nilai->nilai_sumatif_akhir($temp_data, $data);
    //         $this->m_nilai->nilai_sumatif_akhir_rapor($add_sumatif_rapor, $up_sumatif_rapor);

    //         $this->session->set_flashdata('sukses', 'Data berhasil ditambahkan');

    //         redirect(base_url('nilai/upload_nilai'));
    //     }
    // }


    // END ANGGOTA

    // PEMINJAMAN
}
