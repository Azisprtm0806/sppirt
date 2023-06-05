<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengguna extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		cekLogin();
		$this->load->model('Datatable_Model');
		$this->load->model('Pengguna_Model');
	}

	var $column_order = [null, 'username', 'role'];
	var $column_search = ['username', 'role'];
	var $order = ['tb_user.created_at' => 'ASC'];

	public function index()
	{
		$data = [
			'title' => 'Manajemen Pengguna',
			'roles' => $this->db->get_where('tb_role', ['deleted_at' => null])->result_array(),
			'provinsi' => $this->db->order_by('id_provinsi')->get('tb_provinsi')->result_array(),
			'breadcrumb' => breadcrumb('Manajemen Pengguna', 'backend/Pengguna')
		];
		$this->template->load('template/backend', 'backend/pengguna', $data);
	}

	function getDataById($id_role)
	{
		if ($this->input->is_ajax_request()) {
			$response = [
				'sukses' => true,
				'data' => $this->Pengguna_Model->getDataById($id_role)->row_array()
			];
			echo json_encode($response);
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	function getData()
	{
		if ($this->input->is_ajax_request()) {
			$query = [
				'table' => 'tb_user',
				'select' => '*',
				'where' => ['tb_user.deleted_at' => null],
				'join' => [
					['tb_role', 'tb_role.id_role = tb_user.id_role', 'inner']
				]
			];
			// var_dump($this->input->post('tipe'));
			$datauser = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
			$data = [];
			$no = @$_POST['start'];
			foreach ($datauser as $user) {
				$no++;
				$row = [];
				$row[] = $no . ".";
				$row[] = $user->username;
				$row[] = $user->role;
				$row[] = date('d-m-Y', strtotime($user->created_at));
				$row[] = '
				  	<div class="">
					  	<a href="#" type="button" id="btn-edit-' . $user->id_user . '" onclick="ButtonEdit(' . $user->id_user . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
	                 	<a href="#" type="button" id="btn-delete-' . $user->id_user . '" onclick="ButtonDelete(' . $user->id_user . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

	                </div>	
				  ';
				$data[] = $row;
			}
			$output = [
				'draw' => @$_POST['draw'],
				'recordsTotal' => $this->Datatable_Model->countAll($query),
				'recordsFiltered' => $this->Datatable_Model->countFilters($query, $this->column_order, $this->column_search, $this->order),
				'data' => $data,
			];


			echo json_encode($output);
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}
}

/* End of file Pengguna.php */
/* Location: ./application/controllers/backend/Pengguna.php */