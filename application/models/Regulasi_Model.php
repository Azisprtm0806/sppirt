<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Regulasi_Model extends CI_Model
{

    var $table = 'tb_regulasi';
    var $primary = 'id_regulasi';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id_regulasi, $data)
    {
        $this->db->update($this->table, $data, [$this->primary => $id_regulasi]);
        // var_dump($this->db->last_query($query));die;
    }

    function delete($id_regulasi)
    {
        softDelete($this->table, [$this->primary => $id_regulasi]);
    }

    function getDataById($id_regulasi)
    {
        $query = $this->db->get_where($this->table, [$this->primary => $id_regulasi]);
        return $query;
        // var_dump($this->db->last_query($query));die;
    }
}

/* End of file regulasi_Model.php */
/* Location: ./application/models/regulasi_Model.php */