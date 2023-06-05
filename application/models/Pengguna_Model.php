<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna_Model extends CI_Model {

	var $table = 'tb_user';
	var $primary = 'id_user';
	
	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	function update($id_user, $data)
	{
		$this->db->update($this->table, $data, [$this->primary => $id_user]);
		// var_dump($this->db->last_query($query));die;
	}

	function delete($id_user)
	{
		softDelete($this->table, [$this->primary => $id_user]);
	}

	function getDataById($id_user)
	{
		$query = $this->db->get_where($this->table, [$this->primary => $id_user]);
		return $query;
		// var_dump($this->db->last_query($query));die;
	}	

}

/* End of file Pengguna_Model.php */
/* Location: ./application/models/Pengguna_Model.php */