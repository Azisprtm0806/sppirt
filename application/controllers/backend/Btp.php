<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Btp extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		cekLogin();
		$this->load->model('Datatable_Model');
		$this->load->model('Btp_Model');
	}

	var $column_order = [null, 'nama_kategori', 'nama_btp','tb_btp.created_at'];
	var $column_search = ['nama_kategori', 'nama_btp','tb_btp.created_at'];
	var $order = ['tb_btp.created_at' => 'ASC'];

	public function index()
	{
		$data = [
			'title' => 'Manajemen BTP',
			'kategoribtp' => $this->db->get_where('tb_kategori_btp', ['deleted_at' => null])->result_array(),
			'breadcrumb' => breadcrumb('Manajemen BTP', 'backend/Btp')
		];
		$this->template->load('template/backend', 'backend/btp', $data);
	}

	function getDataById($id_btp)
	{
		if ($this->input->is_ajax_request()) {
			$response = [
				'sukses' => true,
				'data' => $this->Btp_Model->getDataById($id_btp)->row_array()
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
				'table' => 'tb_btp',
				'select' => '*',
				'where' => ['tb_btp.deleted_at' => null],
				'join' => [
					['tb_kategori_btp', 'tb_kategori_btp.id_kategori_btp = tb_btp.id_kategori_btp', 'inner']
				]
			];
			// var_dump($this->input->post('tipe'));
			$databtp = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
			$data = [];
			$no = @$_POST['start'];
			foreach ($databtp as $btp) {
				$no++;
				$row = [];
				$row[] = $no . ".";
				$row[] = $btp->nama_kategori;
				$row[] = $btp->nama_btp;
				$row[] = date('d-m-Y', strtotime($btp->created_at));
				$row[] = '
			  	<div class="">
				  	<a href="#" type="button" id="btn-edit-' . $btp->id_btp . '" onclick="ButtonEdit(' . $btp->id_btp . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                 	<a href="#" type="button" id="btn-delete-' . $btp->id_btp . '" onclick="ButtonDelete(' . $btp->id_btp . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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

	function tambahBtp()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$id_kategori_btp = $this->input->post('id_kategori_btp', TRUE);
				$nama_btp = $this->input->post('nama_btp', TRUE);
				$data = [
					'id_kategori_btp' => $id_kategori_btp,
					'nama_btp' => $nama_btp,
				];
				$this->Btp_Model->insert($data);
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

	function ubahBtp()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$id_btp = $this->input->post('id_btp', TRUE);
				$id_kategori_btp = $this->input->post('id_kategori_btp', TRUE);
				$nama_btp = $this->input->post('nama_btp', TRUE);
				$data = [
					'id_kategori_btp' => $id_kategori_btp,
					'nama_btp' => $nama_btp,
				];
				$this->Btp_Model->update($id_btp, $data);
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

	function delete($id_btp)
	{
		if ($this->input->is_ajax_request()) {
			$this->Btp_Model->delete($id_btp);
			echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	private function _validation()
	{
		$this->form_validation->set_rules('id_kategori_btp', 'Kategori BTP', 'trim|required', ['required' => '%s Belum Dipilih!!']);
		$this->form_validation->set_rules('nama_btp', 'Nama BTP', 'trim|required', ['required' => '%s Belum Diisi!!']);
		$this->form_validation->set_error_delimiters('', '');
		return $this->form_validation->run();
	}
}

/* End of file Btp.php */
/* Location: ./application/controllers/backend/Btp.php */
