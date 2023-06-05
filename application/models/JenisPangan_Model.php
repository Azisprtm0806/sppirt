<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JenisPangan_Model extends CI_Model
{

    var $table = 'tb_jenis_pangan';
    var $primary = 'id_jenis_pangan';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id_jenis_pangan, $data)
    {
        $this->db->update($this->table, $data, [$this->primary => $id_jenis_pangan]);
        // var_dump($this->db->last_query($query));die;
    }

    function delete($id_jenis_pangan)
    {
        softDelete($this->table, [$this->primary => $id_jenis_pangan]);
    }

    function getDataById($id_jenis_pangan)
    {
        $query = $this->db->get_where($this->table, [$this->primary => $id_jenis_pangan]);
        return $query;
        // var_dump($this->db->last_query($query));die;
    }
}

/* End of file KategoriBtp_Model.php */
/* Location: ./application/models/KategoriBtp_Model.php */