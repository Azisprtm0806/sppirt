<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
        cekLogin();
		$this->load->model('Datatable_Model');
		$this->load->model('Menu_Model');
	}

	var $column_order = [null, 'parent2', 'nama_menu', 'menu_url', 'menu_icon_parent', 'menu_flag_link'];
	var $column_search = ['nama_menu', 'menu_url', 'menu_icon_parent', 'menu_flag_link'];
	var $order = ['menu_parent' => 'ASC'];

	public function index()
	{
		$data = [
			'title' => 'Manajemen Menu',
			'breadcrumb' => breadcrumb('Manajemen Menu', 'backend/menu')
		];
		$this->template->load('template/backend', 'backend/menu', $data);
	}

	function getDataById($id_menu)
	{
		if ($this->input->is_ajax_request()) {
			$response = [
				'sukses' => true,
				'data' => $this->Menu_Model->getDataById($id_menu)->row_array()
			];
			echo json_encode($response);
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}


	function getData()
	{
		if ($this->input->is_ajax_request()) {
			$tipe = $this->input->post('tipe');
			$query = [
				'table' => 'tb_menu',
				'select' => 'id_menu,menu_parent,nama_menu,menu_icon_parent,menu_flag_link,menu_url,(SELECT a.nama_menu FROM tb_menu a WHERE a.id_menu = tb_menu.menu_parent) as parent2, posisi',
				'where' => ['tipe' => $tipe, 'deleted_at' => null],
				'join' => []
			];
			// var_dump($this->input->post('tipe'));
			$menus = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
			$data = [];
			$no = @$_POST['start'];
			foreach ($menus as $menu) {
				$no++;
				$row = [];
				$row[] = $no . ".";
				$row[] = $menu->parent2;
				$row[] = $menu->nama_menu;
				$row[] = $menu->menu_url == '#' ? '' : '<a href="' . base_url($menu->menu_url) . '" title="' . $menu->nama_menu . '">' . base_url($menu->menu_url) . '</a>';
				$row[] = '<span class="fa fa-' . $menu->menu_icon_parent . '"></span>';
				$row[] = $menu->menu_flag_link == 0 ? '<span class="badge badge-info">Have Child</span>' : '<span class="badge badge-success">Not Have Child</span>';
				$row[] = '
			  	<div class="d-flex">
				  	<a href="#" type="button" id="btn-edit-' . $menu->id_menu . '" onclick="ButtonEdit(' . $menu->id_menu . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                 	<a href="#" type="button" id="btn-delete-' . $menu->id_menu . '" onclick="ButtonDelete(' . $menu->id_menu . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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


	function loadParent()
	{
		if ($this->input->is_ajax_request()) {
			echo json_encode($this->Menu_Model->getParent($this->input->get('tipe'))->result_array());
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	function tambahMenu()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$menu_parent = $this->input->post('menu_parent', TRUE);
				$menu_icon_parent = $this->input->post('menu_icon_parent', TRUE);
				$nama_menu = $this->input->post('nama_menu', TRUE);
				$menu_url = $this->input->post('menu_url', TRUE);
				$posisi = $this->db->select_max('posisi')->where('tb_menu.menu_parent', $menu_parent)->get('tb_menu')->row();
				$tipe = $this->input->post('tipe', TRUE);
				$menu_flag_link = $this->input->post('menu_flag_link', TRUE);
				$data = [
					'nama_menu' => $nama_menu,
					'menu_url' => $menu_url,
					'menu_parent' => $menu_parent,
					'menu_flag_link' => $menu_flag_link,
					'posisi' => $posisi->posisi + 1,
					'tipe' => $tipe,
					'menu_icon_parent' => $menu_icon_parent,
				];
				$this->Menu_Model->insert($data);
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

	function ubahMenu()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$id_menu = $this->input->post('id_menu', TRUE);
				$menu_parent = $this->input->post('menu_parent', TRUE);
				$menu_icon_parent = $this->input->post('menu_icon_parent', TRUE);
				$nama_menu = $this->input->post('nama_menu', TRUE);
				$menu_url = $this->input->post('menu_url', TRUE);
				// $posisi = $this->db->select_max('posisi')->where('tb_menu.menu_parent', $menu_parent)->get('tb_menu')->row();
				// $tipe = $this->input->post('tipe', TRUE);
				$menu_flag_link = $this->input->post('menu_flag_link', TRUE);
				$data = [
					'nama_menu' => $nama_menu,
					'menu_url' => $menu_url,
					'menu_parent' => $menu_parent,
					'menu_flag_link' => $menu_flag_link,
					// 'posisi' => $posisi->posisi + 1,
					// 'tipe' => $tipe,
					'menu_icon_parent' => $menu_icon_parent,
				];
				$this->Menu_Model->update($id_menu, $data);
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

	function delete($id_menu)
	{
		if ($this->input->is_ajax_request()) {
			$this->Menu_Model->delete($id_menu);
			echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}


	private function _validation()
	{
		$this->form_validation->set_rules('menu_parent', 'Jenis Menu', 'trim|required', ['required' => '%s Belum Dipilih!!']);
		$this->form_validation->set_rules('nama_menu', 'Nama Menu', 'trim|required', ['required' => '%s Belum Diisi!!']);
		$this->form_validation->set_rules('menu_url', 'Link Menu', 'trim|required', ['required' => '%s Belum Diisi!!']);
		$this->form_validation->set_rules('menu_icon_parent', 'Ikon Menu', 'trim|required', ['required' => '%s Belum Dipilih!!']);
		$this->form_validation->set_rules('menu_flag_link', 'Memiliki Link', 'trim|required', ['required' => '%s Belum Dipilih!!']);
		$this->form_validation->set_error_delimiters('', '');
		return $this->form_validation->run();
	}
}

/* End of file Menu.php */
/* Location: ./application/controllers/backend/Menu.php */