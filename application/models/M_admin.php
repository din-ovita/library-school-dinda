<?php

class m_admin extends CI_Model
{
    // GLOBAL
    public function get($table)
    {
        return $this->db->get($table)->result();
    }

    public function getTerbaru($table)
    {
        $this->db->order_by('date', 'desc');
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
        $this->db->insert_batch('table_id_buku', $data);
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

    public function update_member($data, $where)
    {
        $this->db->update('table_member', $data, $where);
        return $this->db->affected_rows();
    }

    public function update_member_level($data, $where)
    {
        $this->db->update('table_level', $data, $where);
        return $this->db->affected_rows();
    }
    // END ANGGOTA

    // for pagination
    public function get_items($limit, $offset, $tabel)
    {
        $this->db->limit($limit, $offset);
        $query = $this->db->get($tabel);
        return $query->result();
    }

    public function get_items_terbaru($limit, $offset, $tabel)
    {
        $this->db->order_by('timestamp', 'desc');
        $this->db->limit($limit, $offset);
        $query = $this->db->get($tabel);
        return $query->result();
    }

    public function get_items_where($limit, $offset, $tabel, $where)
    {
        $this->db->limit($limit, $offset);
        $this->db->where($where);
        $query = $this->db->get($tabel);
        return $query->result();
    }

    public function count_items($tabel)
    {
        return $this->db->get($tabel)->num_rows();
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
    public function update_denda($data, $where)
    {
        $this->db->update('table_denda', $data, $where);
        return $this->db->affected_rows();
    }

    public function tambah_telat_mengembalikan($data)
    {
        $this->db->insert('table_telat_mengembalikan', $data);
        return $this->db->insert_id();
    }

    public function konfirmasi_bayar_denda($data, $where)
    {
        $this->db->update('table_telat_mengembalikan', $data, $where);
        return $this->db->affected_rows();
    }

    // PEMINJAMAN
    public function all_peminjaman($date)
    {
        $this->db->select('*');
        $this->db->from('table_index_pinjam');
        $this->db->where(array(
            'DATE_FORMAT(table_index_pinjam.timestamp, "%Y-%m") =' => $date
        ));
        $db = $this->db->get();
        $result = $db->num_rows();

        return $result;
    }
}
