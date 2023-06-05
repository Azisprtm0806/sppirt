<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Galeri_Model extends CI_Model
{

    var $table = 'tb_galeri';
    var $primary = 'id_galeri';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id_galeri, $data)
    {
        $this->db->update($this->table, $data, [$this->primary => $id_galeri]);
    }

    function delete($id_galeri)
    {
        softDelete($this->table, [$this->primary => $id_galeri]);
    }

    function getDataById($id_galeri)
    {
        $query = $this->db->get_where($this->table, [$this->primary => $id_galeri]);
        return $query;
    }
}

/* End of file Galeri_Model.php */
/* Location: ./application/models/Galeri_Model.php */