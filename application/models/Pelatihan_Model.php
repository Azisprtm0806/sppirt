<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelatihan_Model extends CI_Model
{

    var $table = 'tb_pelatihan';
    var $primary = 'id_pelatihan';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id_pelatihan, $data)
    {
        $this->db->update($this->table, $data, [$this->primary => $id_pelatihan]);
        // var_dump($this->db->last_query($query));die;
    }

    function delete($id_pelatihan)
    {
        softDelete($this->table, [$this->primary => $id_pelatihan]);
    }

    function getDataById($id_pelatihan)
    {
        $query = $this->db->get_where($this->table, [$this->primary => $id_pelatihan]);
        return $query;
        // var_dump($this->db->last_query($query));die;
    }
}

/* End of file KategoriBtp_Model.php */
/* Location: ./application/models/KategoriBtp_Model.php */