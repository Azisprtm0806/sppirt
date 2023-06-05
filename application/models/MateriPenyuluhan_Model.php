<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MateriPenyuluhan_Model extends CI_Model {

	var $table = 'tb_materi_penyuluhan';
	var $primary = 'id_penyuluhan';
	
	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	function update($id_penyuluhan, $data)
	{
		$this->db->update($this->table, $data, [$this->primary => $id_penyuluhan]);
		// var_dump($this->db->last_query($query));die;
	}

	function delete($id_penyuluhan)
	{
		softDelete($this->table, [$this->primary => $id_penyuluhan]);
	}

	function getDataById($id_penyuluhan)
	{
		$query = $this->db->get_where($this->table, [$this->primary => $id_penyuluhan]);
		return $query;
		// var_dump($this->db->last_query($query));die;
	}

}

/* End of file MateriPenyuluhan_Model.php */
/* Location: ./application/models/MateriPenyuluhan_Model.php */