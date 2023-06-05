<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KategoriRegulasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
        $this->load->model('KategoriRegulasi_Model');
    }
    var $column_order = [null, 'nama_kategori_regulasi'];
    var $column_search = ['nama_kategori_regulasi'];
    var $order = ['created_at' => 'ASC'];
    public function index()
    {
        $data = [
            'title' => 'Manajemen Kategori Regulasi',
            'breadcrumb' => breadcrumb('Manajemen Kategori Regulasi', 'backend/KategoriRegulasi')
        ];
        $this->template->load('template/backend', 'backend/KategoriRegulasi', $data);
    }
    function getDataKategoriRegulasi()
    {
        if ($this->input->is_ajax_request()) {
            // $tipe = $this->input->post('tipe');
            $query = [
                'table' => 'tb_kategori_regulasi',
                'select' => '*',
                'where' => ['deleted_at' => null],
                'join' => []
            ];
            // var_dump($this->input->post('tipe'));
            $kategoriregulasi = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($kategoriregulasi as $regulasi) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                $row[] = $regulasi->nama_kategori_regulasi;
                $row[] = date('d-m-Y', strtotime($regulasi->created_at));
                $row[] = '
			  	<div class="">
				  	<a href="#" type="button" id="btn-edit-' . $regulasi->id_kategori_regulasi . '" onclick="ButtonEdit(' . $regulasi->id_kategori_regulasi . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                 	<a href="#" type="button" id="btn-delete-' . $regulasi->id_kategori_regulasi . '" onclick="ButtonDelete(' . $regulasi->id_kategori_regulasi . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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
    function getDataById($id_kategori)
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'sukses' => true,
                'data' => $this->KategoriRegulasi_Model->getDataById($id_kategori)->row_array()
            ];
            echo json_encode($response);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
    private function _validation()
    {
        $this->form_validation->set_rules('nama_kategori_regulasi', 'Nama Kategori Regulasi', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }

    function tambahkategori()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $nama_kategori_regulasi = $this->input->post('nama_kategori_regulasi', TRUE);
                $data = [
                    'nama_kategori_regulasi' => $nama_kategori_regulasi,
                ];
                $this->KategoriRegulasi_Model->insert($data);
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
    function ubahkategori()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $id_kategori_regulasi = $this->input->post('id_kategori_regulasi', TRUE);
                $nama_kategori_regulasi = $this->input->post('nama_kategori_regulasi', TRUE);
                $data = [
                    'nama_kategori_regulasi' => $nama_kategori_regulasi,
                ];
                $this->KategoriRegulasi_Model->update($id_kategori_regulasi, $data);
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

    function delete($id_kategori_regulasi)
    {
        if ($this->input->is_ajax_request()) {
            $this->KategoriRegulasi_Model->delete($id_kategori_regulasi);
            echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
}
