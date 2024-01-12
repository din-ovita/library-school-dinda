<?php

class m_admin extends CI_Model
{
    // GLOBAL
    public function get($table)
    {
        return $this->db->get($table)->result();
    }

    public function get_id($table, $id_col, $id)
    {
        $data = $this->db->where($id_col, $id)->get($table);
        return $data;
    }

    public function getwhere($table, $where)
    {
        $data = $this->db->where($where)->get($table);
        return $data;
    }

    public function delete($tabel, $field, $id)
    {
        $data = $this->db->delete($tabel, array($field => $id));
        return $data;
    }

    // RAK
    public function tambah_rak($data)
    {
        $this->db->insert('table_rak', $data);
        return $this->db->insert_id();
    }

    public function update_rak($data, $where)
    {
        $this->db->update('table_rak', $data, $where);
        return $this->db->affected_rows();
    }
    // END RAK

    // KATEGORI
    public function tambah_kategori($data)
    {
        $this->db->insert('table_kategori', $data);
        return $this->db->insert_id();
    }

    public function update_kategori($data, $where)
    {
        $this->db->update('table_kategori', $data, $where);
        return $this->db->affected_rows();
    }
    // END KATEGORI

    // BUKU
    public function tambah_buku($data)
    {
        $this->db->insert('table_buku', $data);
        return $this->db->insert_id();
    }

    public function tambah_index_buku($data)
    {
        $this->db->insert_batch('tabel_id_buku', $data);
    }

    public function update_buku($data, $where)
    {
        $this->db->update('table_buku', $data, $where);
        return $this->db->affected_rows();
    }
    // END BUKU

    // ANGGOTA
    public function tambah_member($data)
    {
        $this->db->insert('table_member', $data);
        return $this->db->insert_id();
    }
    
    public function tambah_level($data)
    {
        $this->db->insert('table_level', $data);
        return $this->db->insert_id();
    }
}
