<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Main extends CI_Model {

	function get_menu($role_id,$menu_parent=0)
	{

		$this->db->select('tb_menu.menu_id, tb_menu.menu_parent, tb_menu.menu_title, tb_menu.menu_url, tb_menu.menu_flag_link, tb_menu.menu_icon_parent');
		$this->db->from('tb_menu');
		$this->db->join('pmpu_user_nav', 'pmpu_user_nav.menu_id=tb_menu.menu_id');
		$this->db->where('pmpu_user_nav.role_id', $role_id);
		$this->db->where('tb_menu.menu_parent', $menu_parent);
		$this->db->order_by('tb_menu.position', 'ASC');
		$query = $this->db->get()->result_array();
		return $query;
	}
	public function authentication_member($username,$password)
	{
		$password = sha1($password);
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		return $this->db->get('pmpu_user')->row_array();
	} 

	public function update($table,$data,$param)
	{
		$this->db->update($table,$data,$param);
	}
}