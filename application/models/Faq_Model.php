<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Faq_Model extends CI_Model
{

    var $table = 'tb_faq';
    var $primary = 'id_faq';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id_faq, $data)
    {
        $this->db->update($this->table, $data, [$this->primary => $id_faq]);
        // var_dump($this->db->last_query($query));die;
    }

    function delete($id_faq)
    {
        softDelete($this->table, [$this->primary => $id_faq]);
    }

    function getDataById($id_faq)
    {
        $query = $this->db->get_where($this->table, [$this->primary => $id_faq]);
        return $query;
        // var_dump($this->db->last_query($query));die;
    }
}

/* End of file faq_Model.php */
/* Location: ./application/models/faq_Model.php */