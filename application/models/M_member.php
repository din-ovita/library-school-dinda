<?php

class m_member extends CI_Model
{
    // GLOBAL
    public function get($table)
    {
        return $this->db->get($table)->result();
    }

    public function get_terbaru($table, $limit)
    {
        $this->db->order_by('date', 'desc');
        $this->db->limit($limit);
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

    public function deletewhere($tabel, $where)
    {
        $data = $this->db->delete($tabel, $where);
        return $data;
    }

    // PEMINJAMAN
    public function tambah_index_pinjam($data)
    {
        $this->db->insert('table_index_pinjam', $data);
        return $this->db->insert_id();
    }

    public function peminjaman($where, $limit)
    {
        $this->db->where($where);
        $this->db->limit($limit);
        $data = $this->db->get('table_id_buku');
        return $data->result();
    }

    public function konfirmasi_peminjaman($data, $where)
    {
        $this->db->update('table_index_pinjam', $data, ['index_pinjam' => $where]);
        return $this->db->affected_rows();
    }

    // DENDA
    public function tambah_telat_mengembalikan($data)
    {
        $this->db->insert('table_telat_mengembalikan', $data);
        return $this->db->insert_id();
    }
}
