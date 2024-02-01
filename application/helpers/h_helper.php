<?php

function indonesian_date($date)
{
    $indonesian_month = array(
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    );
    $year = substr($date, 0, 4);
    $month = substr($date, 5, 2);
    $currentdate = substr($date, 8, 2);
    $time = substr($date, 11);
    $result = $currentdate . ' ' . $indonesian_month[(int) $month - 1] . ' ' . $year;

    return $result;
}


function convRupiah($value)
{
    $float = floatval($value);
    return 'Rp. ' . number_format($float);
}

// RAK
function tampil_nama_rak($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id_rak', $id)->get('table_rak');
    foreach ($result->result() as $c) {
        $stmt = $c->nama_rak;
        return $stmt;
    }
}

function namaRak_byKategori($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $rak = '';
    $result = $ci->db->select('*')
        ->from('table_kategori')
        ->join('table_rak', 'table_kategori.id_rak = table_rak.id_rak')
        ->where('table_kategori.id_kategori', $id)
        ->get();
    foreach ($result->result() as $c) {
        $stmt = $c->nama_rak;
        $rak = $rak . $stmt;
    }
    return $rak;
}
// END RAK

// KATEGORI
function tampil_nama_kategori($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id_kategori', $id)->get('table_kategori');
    foreach ($result->result() as $c) {
        $stmt = $c->nama_kategori;
        return $stmt;
    }
}
// END KATEGORI

// BUKU
function jumlah_buku($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id_buku', $id)->get('table_id_buku');
    return $result->num_rows();
}

function jumlah_buku_tersedia($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $array = ['id_buku' => $id, 'status' => 'tersedia'];
    $result = $ci->db->where($array)->get('table_id_buku');
    return $result->num_rows();
}

function judul_buku($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id_buku', $id)->get('table_buku');
    foreach ($result->result() as $c) {
        $stmt = $c->nama_buku;
        return $stmt;
    }
}

function index_buku($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id_buku', $id)->get('table_buku');
    foreach ($result->result() as $c) {
        $stmt = $c->index_buku;
        return $stmt;
    }
}

function cover_buku($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id_buku', $id)->get('table_buku');
    foreach ($result->result() as $c) {
        $stmt = $c->foto;
        return $stmt;
    }
}

function idBuku_byIndex($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id', $id)->get('table_id_buku');
    foreach ($result->result() as $c) {
        $stmt = $c->id_buku;
        return $stmt;
    }
}

function judulBuku_byIndex($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $judul = '';
    $result = $ci->db->select('*')
        ->from('table_id_buku')
        ->join('table_buku', 'table_id_buku.id_buku = table_buku.id_buku')
        ->where('table_id_buku.index_buku', $id)
        ->get();
    foreach ($result->result() as $c) {
        $stmt = $c->nama_buku;
        $judul = $judul . $stmt;
    }
    return $judul;
}
// END BUKU

// ANGGOTA
function idLevel_byMember($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $level = '';
    $result = $ci->db->select('*')
        ->from('table_member')
        ->join('table_level', 'table_member.id_level = table_level.id_level')
        ->where('table_member.id_member', $id)
        ->get();
    foreach ($result->result() as $c) {
        $stmt = $c->id_level;
        $level = $level . $stmt;
    }
    return $level;
}

function nisMember_byIdLevel($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $nis = '';
    $result = $ci->db->select('*')
        ->from('table_level')
        ->join('table_member', 'table_level.id_level = table_member.id_level')
        ->where('table_level.id_level', $id)
        ->get();
    foreach ($result->result() as $c) {
        $stmt = $c->nis;
        $nis = $nis . $stmt;
    }
    return $nis;
}

function nama_byNis($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('nis', $id)->get('table_member');
    foreach ($result->result() as $c) {
        $stmt = $c->nama;
        return $stmt;
    }
}
// END ANGGOTA

// PEMINJAMAN
function index_pinjam($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id', $id)->get('table_index_pinjam');
    foreach ($result->result() as $c) {
        $stmt = $c->index_pinjam;
        return $stmt;
    }
}

function tgl_kembali($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('index_pinjam', $id)->get('table_index_pinjam');
    foreach ($result->result() as $c) {
        $stmt = $c->tgl_kembali;
        return $stmt;
    }
}

function cek_konfirmasi_pinjam($id) {
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where(['index_pinjam'=> $id, 'konfirmasi_pinjam' => 'yes', 'konfirmasi_kembali' => 'not'])->get('table_index_pinjam');
    return $result->num_rows();
}


function cek_peminjaman_konfirmasi_pinjam($id, $nis)
{
    $ci = &get_instance();
    $ci->load->database();
    $index_pinjam = '';
    $result = $ci->db->where(['id_buku' => $id, 'nis' => $nis])
        ->get('table_peminjaman');
    foreach ($result->result() as $c) {
        $stmt = $c->index_pinjam;
        $index_pinjam = $index_pinjam . $stmt;
    }
    $res = $ci->db->where(['index_pinjam' => $index_pinjam, 'konfirmasi_pinjam' => 'not', 'konfirmasi_kembali' => 'not'])
        ->get('table_index_pinjam');
    return $res->num_rows();
}

function cek_peminjaman_konfirmasi_kembali($id, $nis)
{
    $ci = &get_instance();
    $ci->load->database();
    $index_pinjam = '';
    $result = $ci->db->where(['id_buku' => $id, 'nis' => $nis])
        ->get('table_peminjaman');
    foreach ($result->result() as $c) {
        $stmt = $c->index_pinjam;
        $index_pinjam = $index_pinjam . $stmt;
    }
    $res = $ci->db->where(['index_pinjam' => $index_pinjam, 'konfirmasi_kembali' => 'not'])
        ->get('table_index_pinjam');
    return $res->num_rows();
}
// END PEMINJAMAN

// DENDA
function nominal_denda($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id', $id)->get('table_denda');
    foreach ($result->result() as $c) {
        $stmt = $c->denda;
        return $stmt;
    }
}

function denda_keterlambatan($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('index_pinjam', $id)->get('table_telat_mengembalikan');
    foreach ($result->result() as $c) {
        $stmt = $c->denda;
        return $stmt;
    }
}

function konfirmasi_bayar_denda($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('index_pinjam', $id)->get('table_telat_mengembalikan');
    foreach ($result->result() as $c) {
        $stmt = $c->konfirmasi;
        return $stmt;
    }
}
// END DENDA

// TOTAL
function jumlah_rak()
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->get('table_rak');
    return $result->num_rows();
}

function jumlah_kategori()
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->get('table_kategori');
    return $result->num_rows();
}

function jumlah_judul_buku()
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->get('table_buku');
    return $result->num_rows();
}
// END TOTAL

