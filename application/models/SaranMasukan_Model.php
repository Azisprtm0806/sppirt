<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SaranMasukan_Model extends CI_Model
{

    var $table = 'tb_saran';
    var $primary = 'id_saran';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id_saran, $data)
    {
        $this->db->update($this->table, $data, [$this->primary => $id_saran]);
    }

    function delete($id_saran)
    {
        softDelete($this->table, [$this->primary => $id_saran]);
    }

    function getDataById($id_saran)
    {
        $query = $this->db->get_where($this->table, [$this->primary => $id_saran]);
        return $query;
    }
}
