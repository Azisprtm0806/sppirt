<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyimpanan_Model extends CI_Model
{

    var $table = 'tb_penyimpanan';
    var $primary = 'id_penyimpanan';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id_penyimpanan, $data)
    {
        $this->db->update($this->table, $data, [$this->primary => $id_penyimpanan]);
        // var_dump($this->db->last_query($query));die;
    }

    function delete($id_penyimpanan)
    {
        softDelete($this->table, [$this->primary => $id_penyimpanan]);
    }

    function getDataById($id_penyimpanan)
    {
        $query = $this->db->get_where($this->table, [$this->primary => $id_penyimpanan]);
        return $query;
        // var_dump($this->db->last_query($query));die;
    }
}

/* End of file KategoriBtp_Model.php */
/* Location: ./application/models/KategoriBtp_Model.php */