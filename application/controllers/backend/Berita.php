<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Berita extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		cekLogin();
		$this->load->model('Datatable_Model');
		$this->load->model('Berita_Model');
	}

	var $column_order = [null, 'gambar_berita', 'judul_berita', 'deskripsi_berita', 'tgl_berita'];
	var $column_search = ['gambar_berita', 'judul_berita', 'deskripsi_berita', 'tgl_berita'];
	var $order = ['created_at' => 'ASC'];

	public function index()
	{
		$data = [
			'title' => 'Manajemen Berita',
			'breadcrumb' => breadcrumb('Manajemen Berita', 'backend/Berita')
		];
		$this->template->load('template/backend', 'backend/berita', $data);
	}

	function getDataById($id_berita)
	{
		if ($this->input->is_ajax_request()) {
			$response = [
				'sukses' => true,
				'data' => $this->Berita_Model->getDataById($id_berita)->row_array()
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
				'table' => 'tb_berita',
				'select' => '*',
				'where' => ['deleted_at' => null],
				'join' => []
			];
			// var_dump($this->input->post('tipe'));
			$berita = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
			$data = [];
			$no = @$_POST['start'];
			foreach ($berita as $brt) {
				$no++;
				$row = [];
				$row[] = $no . ".";
				$row[] = '
				  <div class="header-right">
				  	
				  <div class="header-profile">
		              <img src="' . base_url('uploads/berita/thumbnail/') . $brt->gambar_berita . '" width="20" alt=""/>
				  </div>
				  </div>';
				$row[] = $brt->judul_berita;
				// $row[] = $brt->deskripsi_berita;
				$row[] = date('d-m-Y', strtotime($brt->tgl_berita));
				$row[] = '
				  	<div class="">
					  	<a href="#" type="button" id="btn-edit-' . $brt->id_berita . '" onclick="ButtonEdit(' . "'" . $brt->id_berita . "'" . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
	                 	<a href="#" type="button" id="btn-delete-' . $brt->id_berita . '" onclick="ButtonDelete(' . "'" . $brt->id_berita . "'" . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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

	function tambahBerita()
	{
		// var_dump($this->input->post());die;
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {


				$judul_berita = $this->input->post('judul_berita', TRUE);
				$deskripsi_berita = $this->input->post('deskripsi_berita', TRUE);
				$tgl_berita = $this->input->post('tgl_berita', TRUE);
				$upload = $this->upload($judul_berita);
				if ($upload['status']) {
					createThumbnail('berita', $upload['gambar_berita']);
					$data = [
						'judul_berita' => $judul_berita,
						'gambar_berita' => $upload['gambar_berita'],
						'deskripsi_berita' => $deskripsi_berita,
						'slug_berita' => url_title($judul_berita, 'dash', true),
						'tgl_berita' => $tgl_berita,
					];
					$this->Berita_Model->insert($data);
					$response = [
						'status' => true,
						'alert' => "Ditambahkan"
					];
				} else {
					$response['error'] = ['gambar_berita' => $upload['gambar_berita_error']];
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

	function upload($judul_berita)
	{
		$this->load->helper('string');
		$random = random_string('alnum', 4);
		$config = [
			'upload_path' => './uploads/berita/',
			'allowed_types' => 'jpg|jpeg|png',
			'max_size' => '5000',
			'encrypt_name' => true,
			'file_name' => 'berita-' . url_title($judul_berita, 'dash', true) . '-' . date('d-m-Y') . '-' . $random,
		];
		$this->load->library('upload', $config);
		if ($this->input->post('id_berita')) {
			$cek = $this->db->get_where('tb_berita', ['id_berita' => $this->input->post('id_berita')])->row_array();
			if ($_FILES['gambar_berita']['name']) {
				if (!$this->upload->do_upload('gambar_berita')) {
					$response = ['gambar_berita_error' => $this->upload->display_errors(), 'status' => false];
				} else {
					$response = ['gambar_berita' => $this->upload->data('file_name'), 'status' => true];
					unlink(FCPATH . './uploads/berita/' . $cek['gambar_berita']);
					unlink(FCPATH . './uploads/berita/thumbnail/' . $cek['gambar_berita']);
				}
			} else {
				$response = ['gambar_berita' => $cek['gambar_berita'], 'status' => true];
			}
		} else {
			if (!$this->upload->do_upload('gambar_berita')) {
				$response = ['gambar_berita_error' => $this->upload->display_errors(), 'status' => false];
			} else {
				$response = ['gambar_berita' => $this->upload->data('file_name'), 'status' => true];
			}
		}
		return $response;
	}

	function ubahBerita()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$id_berita = $this->input->post('id_berita', TRUE);
				$judul_berita = $this->input->post('judul_berita', TRUE);
				$deskripsi_berita = $this->input->post('deskripsi_berita', TRUE);
				$tgl_berita = $this->input->post('tgl_berita', TRUE);
				$upload = $this->upload($judul_berita);
				// var_dump($upload);
				// die();
				if ($upload['status']) {
					createThumbnail('berita', $upload['gambar_berita']);
					$data = [
						'judul_berita' => $judul_berita,
						'gambar_berita' => $upload['gambar_berita'],
						'deskripsi_berita' => $deskripsi_berita,
						'slug_berita' => url_title($judul_berita, 'dash', true),
						'tgl_berita' => $tgl_berita,
					];
					$this->Berita_Model->update($id_berita, $data);
					$response = [
						'status' => true,
						'alert' => "Diperbarui"
					];
				} else {
					$response['error'] = ['gambar_berita' => $upload['gambar_berita_error']];
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

	function delete($id_berita)
	{
		if ($this->input->is_ajax_request()) {
			$this->Berita_Model->delete($id_berita);
			echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	private function _validation()
	{
		$this->form_validation->set_rules('judul_berita', 'Judul Berita', 'trim|required', ['required' => '%s Belum Diisi!!']);
		$this->form_validation->set_error_delimiters('', '');
		return $this->form_validation->run();
	}
}

/* End of file Berita.php */
/* Location: ./application/controllers/backend/Berita.php */