<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Slider_Model extends CI_Model
{

    var $table = 'tb_slider';
    var $primary = 'id_slider';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id_slider, $data)
    {
        $this->db->update($this->table, $data, [$this->primary => $id_slider]);
        // var_dump($this->db->last_query($query));die;
    }

    function delete($id_slider)
    {
        softDelete($this->table, [$this->primary => $id_slider]);
    }

    function getDataById($id_slider)
    {
        $query = $this->db->get_where($this->table, [$this->primary => $id_slider]);
        return $query;
        // var_dump($this->db->last_query($query));die;
    }
}

/* End of file slider_Model.php */
/* Location: ./application/models/slider_Model.php */