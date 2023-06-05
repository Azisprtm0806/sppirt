<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Panduan_Model extends CI_Model
{

    var $table = 'tb_panduan';
    var $primary = 'id_panduan';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id_panduan, $data)
    {
        $this->db->update($this->table, $data, [$this->primary => $id_panduan]);
        // var_dump($this->db->last_query($query));die;
    }

    function delete($id_panduan)
    {
        softDelete($this->table, [$this->primary => $id_panduan]);
    }

    function getDataById($id_panduan)
    {
        $query = $this->db->get_where($this->table, [$this->primary => $id_panduan]);
        return $query;
        // var_dump($this->db->last_query($query));die;
    }
}

/* End of file panduan_Model.php */
/* Location: ./application/models/panduan_Model.php */