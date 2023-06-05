<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KonfigurasiEmail_Model extends CI_Model
{

    var $table = 'tb_konfigurasi_email';
    var $primary = 'id_konfigurasi_email';

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id_konfigurasi_email, $data)
    {
        $this->db->update($this->table, $data, [$this->primary => $id_konfigurasi_email]);
    }

    function delete($id_konfigurasi_email)
    {
        softDelete($this->table, [$this->primary => $id_konfigurasi_email]);
    }

    function getDataById($id_konfigurasi_email)
    {
        $query = $this->db->get_where($this->table, [$this->primary => $id_konfigurasi_email]);
        return $query;
    }
}
