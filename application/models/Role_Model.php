<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_Model extends CI_Model {

	var $table = 'tb_role';
	var $primary = 'id_role';
	
	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	function update($id_role, $data)
	{
		$this->db->update($this->table, $data, [$this->primary => $id_role]);
		// var_dump($this->db->last_query($query));die;
	}

	function delete($id_role)
	{
		softDelete($this->table, [$this->primary => $id_role]);
	}

	function getDataById($id_role)
	{
		$query = $this->db->get_where($this->table, [$this->primary => $id_role]);
		return $query;
		// var_dump($this->db->last_query($query));die;
	}

	public function hapusAkses($param)
	{
		$this->db->delete('tb_akses_menu',$param);
	}

	public function tambahAkses($data)
	{
		$this->db->insert_batch('tb_akses_menu',$data);
	}

	function get_menu_child_by_role($id_role,$menu_parent)
	{

		$this->db->select('tb_menu.id_menu, nama_menu, tb_akses_menu.id_role');
		$this->db->from('tb_menu');
		$this->db->join('tb_akses_menu', 'tb_akses_menu.id_menu = tb_menu.id_menu AND tb_akses_menu.id_role = '.$id_role, 'LEFT');
		$this->db->where('tb_menu.menu_parent', $menu_parent);
		$this->db->where('tb_menu.tipe', 'backend');
		$this->db->where('tb_menu.deleted_at', null);
		$this->db->order_by('posisi', 'ASC');
		return $this->db->get()->result_array();
	}

}

/* End of file KategoriRole_Model.php */
/* Location: ./application/models/KategoriRole_Model.php */