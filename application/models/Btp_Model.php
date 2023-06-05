<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Btp_Model extends CI_Model {

	var $table = 'tb_btp';
	var $primary = 'id_btp';
	
	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	function update($id_btp, $data)
	{
		$this->db->update($this->table, $data, [$this->primary => $id_btp]);
		// var_dump($this->db->last_query($query));die;
	}

	function delete($id_btp)
	{
		softDelete($this->table, [$this->primary => $id_btp]);
	}

	function getDataById($id_btp)
	{
		$query = $this->db->get_where($this->table, [$this->primary => $id_btp]);
		return $query;
		// var_dump($this->db->last_query($query));die;
	}

}

/* End of file KategoriBtp_Model.php */
/* Location: ./application/models/KategoriBtp_Model.php */