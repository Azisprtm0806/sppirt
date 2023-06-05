<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AlasanPencabutan_Model extends CI_Model
{

    var $table = 'tb_alasan_pencabutan';
    var $primary = 'id_alasan';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id_alasan, $data)
    {
        $this->db->update($this->table, $data, [$this->primary => $id_alasan]);
        // var_dump($this->db->last_query($query));die;
    }

    function delete($id_alasan)
    {
        softDelete($this->table, [$this->primary => $id_alasan]);
    }

    function getDataById($id_alasan)
    {
        $query = $this->db->get_where($this->table, [$this->primary => $id_alasan]);
        return $query;
        // var_dump($this->db->last_query($query));die;
    }
}

/* End of file KategoriBtp_Model.php */
/* Location: ./application/models/KategoriBtp_Model.php */