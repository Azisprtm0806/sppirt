<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProsesProduksi_Model extends CI_Model
{

    var $table = 'tb_proses_produksi';
    var $primary = 'id_proses_produksi';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id_proses_produksi, $data)
    {
        $this->db->update($this->table, $data, [$this->primary => $id_proses_produksi]);
        // var_dump($this->db->last_query($query));die;
    }

    function delete($id_proses_produksi)
    {
        softDelete($this->table, [$this->primary => $id_proses_produksi]);
    }

    function getDataById($id_proses_produksi)
    {
        $query = $this->db->get_where($this->table, [$this->primary => $id_proses_produksi]);
        return $query;
        // var_dump($this->db->last_query($query));die;
    }
}

/* End of file KategoriBtp_Model.php */
/* Location: ./application/models/KategoriBtp_Model.php */