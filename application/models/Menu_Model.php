<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_Model extends CI_Model {

	var $table = 'tb_menu';
	var $primary = 'id_menu';

	function getParent($tipe)
	{
		$this->db->select(
			''.$this->table.'.id_menu,'.$this->table.'.menu_parent,
			(select (select b.nama_menu from '.$this->table.' as b where b.id_menu = a.menu_parent) from '.$this->table.' as a where a.id_menu = '.$this->table.'.menu_parent) as menu_parent_parent_title,
			(select c.nama_menu from '.$this->table.' as c where c.id_menu = '.$this->table.'.menu_parent) as menu_parent_title,'.$this->table.'.nama_menu,'.$this->table.'.menu_url,'.$this->table.'.menu_flag_link,'.$this->table.'.posisi');
		$this->db->from($this->table, 'a');
		$this->db->where('tipe', $tipe);
		$this->db->order_by('menu_parent', 'asc');
		$this->db->order_by('posisi', 'asc');
		return $this->db->get();
	}

	function getDataById($id_menu)
	{
		$query = $this->db->get_where($this->table, [$this->primary => $id_menu]);
		return $query;
		// var_dump($this->db->last_query($query));die;
	}

	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	function update($id_menu, $data)
	{
		$this->db->update($this->table, $data, [$this->primary => $id_menu]);
		// var_dump($this->db->last_query($query));die;
	}

	function delete($id_menu)
	{
		softDelete($this->table, [$this->primary => $id_menu]);
	}


	function getMenu($menu_parent, $tipe)
	{
		$this->db->select('id_menu, menu_parent, nama_menu, menu_url, menu_flag_link');
		$this->db->where('menu_parent', $menu_parent);
		$this->db->where('tipe', $tipe);
		$this->db->order_by('posisi', 'ASC');
		$query = $this->db->get($this->table)->result_array();
		return $query;
	}

	function changePositionMenu($data,$param)
	{
		$this->db->update($this->table,$data,$param);
	}

}

/* End of file Menu_Model.php */
/* Location: ./application/models/Menu_Model.php */