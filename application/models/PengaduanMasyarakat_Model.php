<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PengaduanMasyarakat_Model extends CI_Model
{

    var $table = 'tb_pengaduan_masyarakat';
    var $primary = 'id_pengaduan_masyarakat';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id_pengaduan_masyrakat, $data)
    {
        $this->db->update($this->table, $data, [$this->primary => $id_pengaduan_masyrakat]);
        // var_dump($this->db->last_query($query));die;
    }

    function delete($id_pengaduan_masyrakat)
    {
        softDelete($this->table, [$this->primary => $id_pengaduan_masyrakat]);
    }

    function getDataById($id_pengaduan_masyrakat)
    {
        $query = $this->db->get_where($this->table, [$this->primary => $id_pengaduan_masyrakat]);
        return $query;
        // var_dump($this->db->last_query($query));die;
    }
}

/* End of file pengaduan$id_pengaduan_masyrakat_Model.php */
/* Location: ./application/models/pengaduan$id_pengaduan_masyrakat_Model.php */