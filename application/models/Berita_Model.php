<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita_Model extends CI_Model {

	var $table = 'tb_berita';
	var $primary = 'id_berita';
	
	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	function update($id_berita, $data)
	{
		$this->db->update($this->table, $data, [$this->primary => $id_berita]);
		// var_dump($this->db->last_query($query));die;
	}

	function delete($id_berita)
	{
		softDelete($this->table, [$this->primary => $id_berita]);
	}

	function getDataById($id_berita)
	{
		$query = $this->db->get_where($this->table, [$this->primary => $id_berita]);
		return $query;
		// var_dump($this->db->last_query($query));die;
	}

}

/* End of file Berita_Model.php */
/* Location: ./application/models/Berita_Model.php */