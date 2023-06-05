<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimoni_Model extends CI_Model {

	var $table = 'tb_testimoni';
	var $primary = 'id_testimoni';
	
	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	function update($id_testimoni, $data)
	{
		$this->db->update($this->table, $data, [$this->primary => $id_testimoni]);
		// var_dump($this->db->last_query($query));die;
	}

	function delete($id_testimoni)
	{
		softDelete($this->table, [$this->primary => $id_testimoni]);
	}

	function getDataById($id_testimoni)
	{
		$query = $this->db->get_where($this->table, [$this->primary => $id_testimoni]);
		return $query;
		// var_dump($this->db->last_query($query));die;
	}

}

/* End of file KategoriTestimoni_Model.php */
/* Location: ./application/models/KategoriTestimoni_Model.php */