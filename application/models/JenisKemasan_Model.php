<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JenisKemasan_Model extends CI_Model
{

    var $table = 'tb_jenis_kemasan';
    var $primary = 'id_jenis_kemasan';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id_jenis_kemasan, $data)
    {
        $this->db->update($this->table, $data, [$this->primary => $id_jenis_kemasan]);
        // var_dump($this->db->last_query($query));die;
    }

    function delete($id_jenis_kemasan)
    {
        softDelete($this->table, [$this->primary => $id_jenis_kemasan]);
    }

    function getDataById($id_jenis_kemasan)
    {
        $query = $this->db->get_where($this->table, [$this->primary => $id_jenis_kemasan]);
        return $query;
        // var_dump($this->db->last_query($query));die;
    }
}

/* End of file KategoriBtp_Model.php */
/* Location: ./application/models/KategoriBtp_Model.php */