<?php
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