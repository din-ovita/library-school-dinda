<?php

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
    $result = $ci->db->where('id_buku', $id)->get('tabel_id_buku');
    return $result->num_rows();
}

function jumlah_buku_tersedia($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $array = ['id_buku' => $id, 'status' => 'tersedia'];
    $result = $ci->db->where($array)->get('tabel_id_buku');
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
    $result = $ci->db->where('id', $id)->get('tabel_id_buku');
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
        ->from('tabel_id_buku')
        ->join('table_buku', 'tabel_id_buku.id_buku = table_buku.id_buku')
        ->where('tabel_id_buku.index_buku', $id)
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
    $result = $ci->db->where('id', $id)->get('tabel_index_pinjam');
    foreach ($result->result() as $c) {
        $stmt = $c->index_pinjam;
        return $stmt;
    }
}

function tgl_kembali($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('index_pinjam', $id)->get('tabel_index_pinjam');
    foreach ($result->result() as $c) {
        $stmt = $c->tgl_kembali;
        return $stmt;
    }
}
// END PEMINJAMAN