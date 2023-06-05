<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Instansi_Model extends CI_Model
{

    var $table = 'tb_instansi';
    var $primary = 'id_instansi';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id_instansi, $data)
    {
        $this->db->update($this->table, $data, [$this->primary => $id_instansi]);
        // var_dump($this->db->last_query($query));die;
    }

    function delete($id_instansi)
    {
        softDelete($this->table, [$this->primary => $id_instansi]);
    }

    function getDataById($id_instansi)
    {
        $query = $this->db->get_where($this->table, [$this->primary => $id_instansi]);
        return $query;
        // var_dump($this->db->last_query($query));die;
    }
}

/* End of file KategoriBtp_Model.php */
/* Location: ./application/models/KategoriBtp_Model.php */