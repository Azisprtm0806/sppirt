<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KategoriBtp extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
        cekLogin();
		$this->load->model('Datatable_Model');
		$this->load->model('KategoriBtp_Model');
	}

	var $column_order = [null, 'nama_kategori','created_at'];
	var $column_search = ['nama_kategori','created_at'];
	var $order = ['id_kategori_btp' => 'ASC'];

	public function index()
	{
		$data = [
			'title' => 'Manajemen Kategori BTP',
			'breadcrumb' => breadcrumb('Manajemen Kategori BTP', 'backend/KategoriBtp')
		];
		$this->template->load('template/backend', 'backend/kategoribtp', $data);
	}

	function getDataById($id_kategori_btp)
	{
		if ($this->input->is_ajax_request()) {
			$response = [
				'sukses' => true,
				'data' => $this->KategoriBtp_Model->getDataById($id_kategori_btp)->row_array()
			];
			echo json_encode($response);
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	function getData()
	{
		if ($this->input->is_ajax_request()) {
			// $tipe = $this->input->post('tipe');
			$query = [
				'table' => 'tb_kategori_btp',
				'select' => '*',
				'where' => ['deleted_at' => null],
				'join' => []
			];
			// var_dump($this->input->post('tipe'));
			$kategoribtp = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
			$data = [];
			$no = @$_POST['start'];
			foreach ($kategoribtp as $katbtp) {
				$no++;
				$row = [];
				$row[] = $no . ".";
				$row[] = $katbtp->nama_kategori;
				$row[] = date('d-m-Y', strtotime($katbtp->created_at));
				$row[] = '
			  	<div class="">
				  	<a href="#" type="button" id="btn-edit-' . $katbtp->id_kategori_btp . '" onclick="ButtonEdit(' . $katbtp->id_kategori_btp . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                 	<a href="#" type="button" id="btn-delete-' . $katbtp->id_kategori_btp . '" onclick="ButtonDelete(' . $katbtp->id_kategori_btp . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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

	function tambahKategoriBtp()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$nama_kategori = $this->input->post('nama_kategori', TRUE);
				$data = [
					'nama_kategori' => $nama_kategori,
				];
				$this->KategoriBtp_Model->insert($data);
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

	function ubahKategoriBtp()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$id_kategori_btp = $this->input->post('id_kategori_btp', TRUE);
				$nama_kategori = $this->input->post('nama_kategori', TRUE);
				$data = [
					'nama_kategori' => $nama_kategori,
				];
				$this->KategoriBtp_Model->update($id_kategori_btp, $data);
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

	function delete($id_kategori_btp)
	{
		if ($this->input->is_ajax_request()) {
			echo json_encode($this->KategoriBtp_Model->delete($id_kategori_btp));
		}else{
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	private function _validation()
	{
		$this->form_validation->set_rules('nama_kategori', 'Nama Kategori BTP', 'trim|required', ['required' => '%s Belum Diisi!!']);
		$this->form_validation->set_error_delimiters('', '');
		return $this->form_validation->run();
	}
}

/* End of file KategoriBtp.php */
/* Location: ./application/controllers/backend/KategoriBtp.php */
