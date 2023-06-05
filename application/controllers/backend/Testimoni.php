<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Testimoni extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		cekLogin();
		$this->load->model('Datatable_Model');
		$this->load->model('Testimoni_Model');
	}

	var $column_order = [null, 'foto_testimoni', 'nama_testimoni', 'komentar_testimoni', 'created_at'];
	var $column_search = ['foto_testimoni', 'nama_testimoni', 'komentar_testimoni', 'created_at'];
	var $order = ['created_at' => 'ASC'];

	public function index()
	{
		$data = [
			'title' => 'Manajemen Testimoni',
			'breadcrumb' => breadcrumb('Manajemen Testimoni', 'backend/Testimoni')
		];
		$this->template->load('template/backend', 'backend/testimoni', $data);
	}

	function getDataById($id_testimoni)
	{
		if ($this->input->is_ajax_request()) {
			$response = [
				'sukses' => true,
				'data' => $this->Testimoni_Model->getDataById($id_testimoni)->row_array()
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
				'table' => 'tb_testimoni',
				'select' => '*',
				'where' => ['deleted_at' => null],
				'join' => []
			];
			// var_dump($this->input->post('tipe'));
			$testimoni = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
			$data = [];
			$no = @$_POST['start'];
			foreach ($testimoni as $testi) {
				$no++;
				$row = [];
				$row[] = $no . ".";
				$row[] = '
				  <div class="header-right">
				  	
				  <div class="header-profile">
		              <img src="' . base_url('uploads/testimoni/') . $testi->foto_testimoni . '" width="20" alt=""/>
				  </div>
				  </div>';
				$row[] = $testi->nama_testimoni;
				$row[] = $testi->komentar_testimoni;
				// $row[] = $testi->komentar_testimoni;
				$row[] = date('d-m-Y', strtotime($testi->created_at));
				$row[] = '
				  	<div class="">
					  	<a href="#" type="button" id="btn-edit-' . $testi->id_testimoni . '" onclick="ButtonEdit(' . "'" . $testi->id_testimoni . "'" . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
	                 	<a href="#" type="button" id="btn-delete-' . $testi->id_testimoni . '" onclick="ButtonDelete(' . "'" . $testi->id_testimoni . "'" . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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

	function tambahTestimoni()
	{
		// var_dump($this->input->post());die;
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {


				$nama_testimoni = $this->input->post('nama_testimoni', TRUE);
				$komentar_testimoni = $this->input->post('komentar_testimoni', TRUE);
				$upload = $this->upload($nama_testimoni);
				if ($upload['status']) {
					$data = [
						'foto_testimoni' => $upload['foto_testimoni'],
						'nama_testimoni' => $nama_testimoni,
						'komentar_testimoni' => $komentar_testimoni,
					];
					$this->Testimoni_Model->insert($data);
					$response = [
						'status' => true,
						'alert' => "Ditambahkan"
					];
				} else {
					$response['error'] = ['foto_testimoni' => $upload['foto_testimoni_error']];
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

	function upload($nama_testimoni)
	{
		$this->load->helper('string');
		$random = random_string('alnum', 4);
		$config = [
			'upload_path' => './uploads/testimoni/',
			'allowed_types' => 'jpg|jpeg|png',
			'max_size' => '5000',
			'encrypt_name' => true,
			'file_name' => 'testimoni-' . url_title($nama_testimoni, 'dash', true) . '-' . date('d-m-Y') . '-' . $random,
		];
		$this->load->library('upload', $config);
		if ($this->input->post('id_testimoni')) {
			$cek = $this->db->get_where('tb_testimoni', ['id_testimoni' => $this->input->post('id_testimoni')])->row_array();
			if ($_FILES['foto_testimoni']['name']) {
				if (!$this->upload->do_upload('foto_testimoni')) {
					$response = ['foto_testimoni_error' => $this->upload->display_errors(), 'status' => false];
				} else {
					$response = ['foto_testimoni' => $this->upload->data('file_name'), 'status' => true];
					unlink(FCPATH . './uploads/testimoni/' . $cek['foto_testimoni']);
				}
			} else {
				$response = ['foto_testimoni' => $cek['foto_testimoni'], 'status' => true];
			}
		} else {
			if (!$this->upload->do_upload('foto_testimoni')) {
				$response = ['foto_testimoni_error' => $this->upload->display_errors(), 'status' => false];
			} else {
				$response = ['foto_testimoni' => $this->upload->data('file_name'), 'status' => true];
			}
		}
		return $response;
	}

	function ubahTestimoni()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$id_testimoni = $this->input->post('id_testimoni', TRUE);
				$nama_testimoni = $this->input->post('nama_testimoni', TRUE);
				$komentar_testimoni = $this->input->post('komentar_testimoni', TRUE);
				$upload = $this->upload($nama_testimoni);
				if ($upload['status']) {
					$data = [
						'foto_testimoni' => $upload['foto_testimoni'],
						'nama_testimoni' => $nama_testimoni,
						'komentar_testimoni' => $komentar_testimoni,
					];
					$this->Testimoni_Model->update($id_testimoni, $data);
					$response = [
						'status' => true,
						'alert' => "Diperbarui"
					];
				} else {
					$response['error'] = ['foto_testimoni' => $upload['foto_testimoni_error']];
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

	function delete($id_testimoni)
	{
		if ($this->input->is_ajax_request()) {
			$this->Testimoni_Model->delete($id_testimoni);
			echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	private function _validation()
	{
		$this->form_validation->set_rules('nama_testimoni', 'Judul Testimoni', 'trim|required', ['required' => '%s Belum Diisi!!']);
		$this->form_validation->set_error_delimiters('', '');
		return $this->form_validation->run();
	}
}

/* End of file Testimoni.php */
/* Location: ./application/controllers/backend/Testimoni.php */