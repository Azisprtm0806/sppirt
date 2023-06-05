<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		cekLogin();
		$this->load->model('Datatable_Model');
		$this->load->model('Role_Model');
	}

	var $column_order = [null, 'role', 'deskripsi'];
	var $column_search = ['role', 'deskripsi'];
	var $order = ['created_at' => 'ASC'];

	public function index()
	{
		$data = [
			'title' => 'Manajemen Role',
			'breadcrumb' => breadcrumb('Manajemen Role', 'backend/role')
		];

		$this->template->load('template/backend', 'backend/role', $data);
	}

	function getDataById($id_role)
	{
		if ($this->input->is_ajax_request()) {
			$response = [
				'sukses' => true,
				'data' => $this->Role_Model->getDataById($id_role)->row_array()
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
				'table' => 'tb_role',
				'select' => '*',
				'where' => ['tb_role.deleted_at' => null],
				'join' => []
			];
			// var_dump($this->input->post('tipe'));
			$roles = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
			$data = [];
			$no = @$_POST['start'];
			foreach ($roles as $role) {
				$no++;
				$row = [];
				$row[] = $no . ".";
				$row[] = $role->role;
				$row[] = $role->deskripsi;
				$row[] = '
			  	<div class="">
				  	<a href="#" type="button" id="btn-edit-' . $role->id_role . '" onclick="ButtonAccess(' . $role->id_role . ')" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-wrench"></i></a>
				  	<a href="#" type="button" id="btn-edit-' . $role->id_role . '" onclick="ButtonEdit(' . $role->id_role . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                 	<a href="#" type="button" id="btn-delete-' . $role->id_role . '" onclick="ButtonDelete(' . $role->id_role . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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


	function tambahRole()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$role = $this->input->post('role', TRUE);
				$deskripsi = $this->input->post('deskripsi', TRUE);
				$data = [
					'role' => $role,
					'deskripsi' => $deskripsi,
				];
				$this->Role_Model->insert($data);
				$response = [
					'status' => true,
					'alert' => "Ditambahkan"
				];
			} else {
				$response['error'] = getErrorValidation();
				$response['status'] = false;
				$response['alert'] = 'Ditambahkan';
			}
			echo json_encode($response);
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	function ubahRole()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$id_role = $this->input->post('id_role', TRUE);
				$role = $this->input->post('role', TRUE);
				$deskripsi = $this->input->post('deskripsi', TRUE);
				$data = [
					'role' => $role,
					'deskripsi' => $deskripsi,
				];
				$this->Role_Model->update($id_role, $data);
				$response = [
					'status' => true,
					'alert' => "Diperbarui"
				];
			} else {
				$response['error'] = getErrorValidation();
				$response['status'] = false;
				$response['alert'] = 'Diperbarui';
			}
			echo json_encode($response);
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	function delete($id_role)
	{
		if ($this->input->is_ajax_request()) {
			$this->Role_Model->delete($id_role);
			echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	private function _validation()
	{
		$this->form_validation->set_rules('role', 'Nama Role', 'trim|required', ['required' => '%s Belum Diisi!!']);
		$this->form_validation->set_rules('deskripsi', 'Deskripsi Role', 'trim|required', ['required' => '%s Belum Diisi!!']);
		$this->form_validation->set_error_delimiters('', '');
		return $this->form_validation->run();
	}


	function akses($id_role)
	{
		if ($this->input->is_ajax_request()) {
			$menuroleparent = $this->Role_Model->get_menu_child_by_role($id_role, 0);
			$menu = '<input type="hidden" id="id_role" name="id_role" value="' . $id_role . '">';
			$menu .= '<ul>';

			foreach ($menuroleparent as $parent) {
				$parent_is = '';
				if ($parent['id_role'] != "") $parent_is = ' checked="checked"';

				$menu .= '<li>
						<label>
						<input type="checkbox" name="id_menu[]" id="parent"' . $parent_is . ' value="' . $parent['id_menu'] . '">
						<span> ' . $parent['nama_menu'] . '</span>
						</label>
				';

				$menurolechild = $this->Role_Model->get_menu_child_by_role($id_role, $parent['id_menu']);
				if (count($menurolechild) > 0)
					$menu .= '<ul>';

				foreach ($menurolechild as $child) {

					$menurolegrandchild = $this->Role_Model->get_menu_child_by_role($id_role, $child['id_menu']);

					$child_is = '';
					if ($child['id_role'] != "") $child_is = ' checked="checked"';

					$menu .= '<li class="ml-3">
					<label>
						<input type="checkbox" name="id_menu[]" id="parent"' . $child_is . ' value="' . $child['id_menu'] . '">
						<span> ' . $child['nama_menu'] . '</span>
					</label>';



					if (count($menurolegrandchild) > 0)
						$menu .= '<ul>';

					foreach ($menurolegrandchild as $grandchild) {
						$grandchild_is = '';
						if ($grandchild['id_role'] != "") $grandchild_is = ' checked="checked"';



						$menu .= '<li class="ml-3"><label>
						<input type="checkbox" name="id_menu[]" id="parent"' . $grandchild_is . ' value="' . $grandchild['id_menu'] . '">
						<span> ' . $grandchild['nama_menu'] . '</span>
						</label></li>';
					}

					if (count($menurolegrandchild) > 0)
						$menu .= '</ul>';

					$menu .= '</li>';
				}

				if (count($menurolechild) > 0)
					$menu .= '</ul>';

				$menu .= '
				</li>';
			}

			$menu .= '</ul>';

			echo $menu;
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	function saveAkses()
	{
		if ($this->input->is_ajax_request()) {
			$id_role = $this->input->post('id_role');
			$id_menu = $this->input->post('id_menu');

			$data_batch = array();

			for ($i = 0; $i < count($id_menu); $i++) {
				$data_batch[] = array(
					'id_role' => $id_role,
					'id_menu' => $id_menu[$i],
				);
			}


			$param_delete = array('id_role' => $id_role);

			$this->db->trans_begin();
			$this->Role_Model->hapusAkses($param_delete);
			if ($this->db->trans_status() === true) {
				$this->db->trans_commit();

				if (count($data_batch) > 0) {
					$this->db->trans_begin();
					$this->Role_Model->tambahAkses($data_batch);
					if ($this->db->trans_status() === true) {
						$this->db->trans_commit();
						$response = ['success' => true];
					} else {
						$this->db->trans_rollback();
						$response = ['success' => false];
					}
				} else {
					$response = ['success' => true];
				}
			} else {
				$this->db->trans_rollback();
				$response = ['success' => false];
			}

			echo json_encode($response);
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}
}

/* End of file Role.php */
/* Location: ./application/controllers/backend/Role.php */