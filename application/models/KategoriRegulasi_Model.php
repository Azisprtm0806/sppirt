<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KategoriRegulasi_Model extends CI_Model
{

    var $table = 'tb_kategori_regulasi';
    var $primary = 'id_kategori_regulasi';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id_kategori_regulasi, $data)
    {
        $this->db->update($this->table, $data, [$this->primary => $id_kategori_regulasi]);
        // var_dump($this->db->last_query($query));die;
    }

    function delete($id_kategori_regulasi)
    {
        softDelete($this->table, [$this->primary => $id_kategori_regulasi]);
    }

    function getDataById($id_kategori_regulasi)
    {
        $query = $this->db->get_where($this->table, [$this->primary => $id_kategori_regulasi]);
        return $query;
        // var_dump($this->db->last_query($query));die;
    }
}

/* End of file KategoriBtp_Model.php */
/* Location: ./application/models/KategoriBtp_Model.php */