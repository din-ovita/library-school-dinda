<?php
class m_auth extends CI_Model
{
    public function cek_login($table, $where)
    {
        $data = $this->db->where($where)->get($table);
        return $data;
    }
    public function registrasi($tabel, $data)
    {
        $this->db->insert($tabel, $data);
        return $this->db->insert_id();
    }

    public function update($table, $data, $where)
    {
        $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }
}
