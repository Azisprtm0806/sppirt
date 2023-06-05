<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KategoriBtp_Model extends CI_Model {

	var $table = 'tb_kategori_btp';
	var $primary = 'id_kategori_btp';
	
	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	function update($id_kategori_btp, $data)
	{
		$this->db->update($this->table, $data, [$this->primary => $id_kategori_btp]);
		// var_dump($this->db->last_query($query));die;
	}

	function delete($id_kategori_btp)
	{
		$cek = $this->db->get_where('tb_btp', ['id_kategori_btp' => $id_kategori_btp, 'deleted_at' => null])->row();
		if ($cek) {
			$response = ['sukses' => false, 'alert' => 'Karena data masih digunakan di tabel lain'];
		}else{
			softDelete($this->table, [$this->primary => $id_kategori_btp]);
			$response = ['sukses' => true, 'alert' => 'Dihapus'];
		}
		return $response;
	}

	function getDataById($id_kategori_btp)
	{
		$query = $this->db->get_where($this->table, [$this->primary => $id_kategori_btp]);
		return $query;
		// var_dump($this->db->last_query($query));die;
	}

}

/* End of file KategoriBtp_Model.php */
/* Location: ./application/models/KategoriBtp_Model.php */