<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MateriPenyuluhan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		cekLogin();
		$this->load->model('Datatable_Model');
		$this->load->model('MateriPenyuluhan_Model');
	}

	var $column_order = [null, 'nama_materi', 'status_materi'];
	var $column_search = ['nama_materi', 'status_materi'];
	var $order = ['created_at' => 'ASC'];

	public function index()
	{
		$data = [
			'title' => 'Manajemen Materi Penyuluhan',
			'breadcrumb' => breadcrumb('Manajemen Materi Penyuluhan', 'backend/MateriPenyuluhan')
		];
		$this->template->load('template/backend', 'backend/materipenyuluhan', $data);
	}

	function getDataById($id_penyuluhan)
	{
		if ($this->input->is_ajax_request()) {
			$response = [
				'sukses' => true,
				'data' => $this->MateriPenyuluhan_Model->getDataById($id_penyuluhan)->row_array()
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
				'table' => 'tb_materi_penyuluhan',
				'select' => '*',
				'where' => ['deleted_at' => null],
				'join' => []
			];
			// var_dump($this->input->post('tipe'));
			$materipenyuluhan = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
			$data = [];
			$no = @$_POST['start'];
			foreach ($materipenyuluhan as $materi) {
				$no++;
				$row = [];
				$row[] = $no . ".";
				// $row[] = '
				//   <div class="header-right">
				  	
				//   <div class="header-profile">
		  //             <img src="' . base_url('uploads/materipenyuluhan/') . $materi->file . '" width="20" alt=""/>
				//   </div>
				//   </div>';
				$row[] = $materi->nama_materi;
				$row[] = $materi->status_materi;
				// $row[] = date('d-m-Y', strtotime($materi->tgl_materipenyuluhan));
				$row[] = '
				  	<div class="">
					  	<a href="#" type="button" id="btn-edit-' . $materi->id_penyuluhan . '" onclick="ButtonEdit(' . "'" . $materi->id_penyuluhan . "'" . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
	                 	<a href="#" type="button" id="btn-delete-' . $materi->id_penyuluhan . '" onclick="ButtonDelete(' . "'" . $materi->id_penyuluhan . "'" . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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

	function tambahMateriPenyuluhan()
	{
		// var_dump($this->input->post());die;
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {


				$nama_materi = $this->input->post('nama_materi', TRUE);
				$status_materi = $this->input->post('status_materi', TRUE);
				$upload = $this->upload($nama_materi);
				if ($upload['status']) {
					$data = [
						'nama_materi' => $nama_materi,
						'status_materi' => $status_materi,
						'file' => $upload['file'],
					];
					$this->MateriPenyuluhan_Model->insert($data);
					$response = [
						'status' => true,
						'alert' => "Ditambahkan"
					];
				} else {
					$response['error'] = ['file' => $upload['file_error']];
					$response['status'] = false;
					$response['alert'] = 'Ditambahkan';
				}
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

	function upload($nama_materi)
	{
		$this->load->helper('string');
		$random = random_string('alnum', 4);
		$config = [
			'upload_path' => './uploads/materipenyuluhan/',
			'allowed_types' => 'pdf|doc|docx|ppt|pptx',
			'max_size' => '5000',
			'encrypt_name' => true,
			'file_name' => 'materipenyuluhan-' . url_title($nama_materi, 'dash', true) . '-' . date('d-m-Y') . '-' . $random,
		];
		$this->load->library('upload', $config);
		if ($this->input->post('id_penyuluhan')) {
			$cek = $this->db->get_where('tb_materi_penyuluhan', ['id_penyuluhan' => $this->input->post('id_penyuluhan')])->row_array();
			if ($_FILES['file']['name']) {
				if (!$this->upload->do_upload('file')) {
					$response = ['file_error' => $this->upload->display_errors(), 'status' => false];
				} else {
					$response = ['file' => $this->upload->data('file_name'), 'status' => true];
					unlink(FCPATH . './uploads/materipenyuluhan/' . $cek['file']);
				}
			} else {
				$response = ['file' => $cek['file'], 'status' => true];
			}
		} else {
			if (!$this->upload->do_upload('file')) {
				$response = ['file_error' => $this->upload->display_errors(), 'status' => false];
			} else {
				$response = ['file' => $this->upload->data('file_name'), 'status' => true];
			}
		}
		return $response;
	}

	function ubahMateriPenyuluhan()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$id_penyuluhan = $this->input->post('id_penyuluhan', TRUE);
				$nama_materi = $this->input->post('nama_materi', TRUE);
				$status_materi = $this->input->post('status_materi', TRUE);
				$upload = $this->upload($nama_materi);
				if ($upload['status']) {
					$data = [
						'nama_materi' => $nama_materi,
						'status_materi' => $status_materi,
						'file' => $upload['file'],
					];
					$this->MateriPenyuluhan_Model->update($id_penyuluhan, $data);
					$response = [
						'status' => true,
						'alert' => "Diperbarui"
					];
				} else {
					$response['error'] = ['file' => $upload['file_error']];
					$response['status'] = false;
					$response['alert'] = 'Diperbarui';
				}
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

	function delete($id_penyuluhan)
	{
		if ($this->input->is_ajax_request()) {
			$this->MateriPenyuluhan_Model->delete($id_penyuluhan);
			echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	private function _validation()
	{
		$this->form_validation->set_rules('nama_materi', 'Nama Materi', 'trim|required', ['required' => '%s Belum Diisi!!']);
		$this->form_validation->set_error_delimiters('', '');
		return $this->form_validation->run();
	}

}

/* End of file MateriPenyuluhan.php */
/* Location: ./application/controllers/backend/MateriPenyuluhan.php */