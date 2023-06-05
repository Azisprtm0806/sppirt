<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datatable_Model extends CI_Model {

	function queryDataTables($query, $column_order, $column_search, $order)
	{
		// var_dump($query['join']);die;
		$this->db->from($query['table'],'a');
		if ($query['select']) {
			$this->db->select($query['select']);
		}
		if ($query['join']) {
			for ($i=0; $i < count($query['join']); $i++) { 
				$this->db->join($query['join'][$i][0],$query['join'][$i][1], $query['join'][$i][2]);
			}
		}
		if ($query['where']) {
			$this->db->where($query['where']);
		}

		if(isset($_POST['id_prov']) && $_POST['id_prov']!="") {
			$this->db->where('tb_user.id_prov',$_POST['id_prov']);
		}

		if(isset($_POST['id_prov']) && $_POST['id_prov']!="" && isset($_POST['id_kota']) && $_POST['id_kota']!="") {
			$this->db->where('tb_user.id_kota',$_POST['id_kota']);
		}

	  $i = 0;
	  foreach ($column_search as $faq) {
	    if (@$_POST['search']['value']) {
	      if ($i ===0) {
	        $this->db->group_start();
	        $this->db->like($faq, $_POST['search']['value']);
	      } else {
	        $this->db->or_like($faq, $_POST['search']['value']);
	      } 

	      if (count($column_search) -1 == $i)
	        $this->db->group_end();
	    }
	    $i++;
	  }
	  if (isset($_POST['order'])) {
	    $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
	  }elseif (isset($order)) {
	    $order = $order;
	    $this->db->order_by(key($order), $order[key($order)]);
	  }
	}

	function getDataTables($query, $column_order, $column_search, $order)
	{
	  $this->queryDataTables($query, $column_order, $column_search, $order);
	  if (@$_POST['length'] != 1)
	  $this->db->limit(@$_POST['length'], @$_POST['start']);
	  $query = $this->db->get();
	  return $query->result();
	}

	function countFilters($query, $column_order, $column_search, $order)
	{
	  $this->queryDataTables($query, $column_order, $column_search, $order);
	  $query = $this->db->get();
	  return $query->num_rows();
	}

	function countAll($query)
	{
		$this->db->from($query['table'],'a');
		if ($query['select']) {
			$this->db->select($query['select']);
		}
		if ($query['join']) {
			for ($i=0; $i < count($query['join']); $i++) { 
				$this->db->join($query['join'][$i][0],$query['join'][$i][1], $query['join'][$i][2]);
			}
		}
		if ($query['where']) {
			$this->db->where($query['where']);
		}

	  return $this->db->count_all_results();
	}

	public function ambilById($table, $where)
	{
		return $this->db->get_where($where, $table);
	}

}

/* End of file Datatable_Model.php */
/* Location: ./application/models/Datatable_Model.php */