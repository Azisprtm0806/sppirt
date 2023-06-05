<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Narasumber_Model extends CI_Model
{

    var $table = 'tb_narasumber';
    var $primary = 'nip';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($nip, $data)
    {
        $this->db->update($this->table, $data, [$this->primary => $nip]);
        // var_dump($this->db->last_query($query));die;
    }

    function delete($nip)
    {
        softDelete($this->table, [$this->primary => $nip]);
    }

    function getDataById($nip)
    {
        $query = $this->db->get_where($this->table, [$this->primary => $nip]);
        return $query;
        // var_dump($this->db->last_query($query));die;
    }
}

/* End of file KategoriBtp_Model.php */
/* Location: ./application/models/KategoriBtp_Model.php */