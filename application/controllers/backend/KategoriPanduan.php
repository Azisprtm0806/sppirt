<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KategoriPanduan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
        $this->load->model('KategoriPanduan_Model');
    }
    var $column_order = [null, 'nama_kategori_panduan'];
    var $column_search = ['nama_kategori_panduan'];
    var $order = ['created_at' => 'ASC'];
    public function index()
    {
        $data = [
            'title' => 'Manajemen Kategori Panduan',
            'breadcrumb' => breadcrumb('Manajemen Kategori Panduan', 'backend/KategoriPanduan')
        ];
        $this->template->load('template/backend', 'backend/KategoriPanduan', $data);
    }
    function getDataKategoriPanduan()
    {
        if ($this->input->is_ajax_request()) {
            // $tipe = $this->input->post('tipe');
            $query = [
                'table' => 'tb_kategori_panduan',
                'select' => '*',
                'where' => ['deleted_at' => null],
                'join' => []
            ];
            // var_dump($this->input->post('tipe'));
            $kategoripanduan = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($kategoripanduan as $katpan) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                $row[] = $katpan->nama_kategori_panduan;
                $row[] = date('d-m-Y', strtotime($katpan->created_at));
                $row[] = '
			  	<div class="">
				  	<a href="#" type="button" id="btn-edit-' . $katpan->id_kategori_panduan . '" onclick="ButtonEdit(' . $katpan->id_kategori_panduan . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                 	<a href="#" type="button" id="btn-delete-' . $katpan->id_kategori_panduan . '" onclick="ButtonDelete(' . $katpan->id_kategori_panduan . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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
                'data' => $this->KategoriPanduan_Model->getDataById($id_kategori)->row_array()
            ];
            echo json_encode($response);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
    private function _validation()
    {
        $this->form_validation->set_rules('nama_kategori_panduan', 'Nama Kategori Panduan', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }

    function tambahkategori()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $nama_kategori_panduan = $this->input->post('nama_kategori_panduan', TRUE);
                $data = [
                    'nama_kategori_panduan' => $nama_kategori_panduan,
                ];
                $this->KategoriPanduan_Model->insert($data);
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
                $id_kategori_panduan = $this->input->post('id_kategori_panduan', TRUE);
                $nama_kategori_panduan = $this->input->post('nama_kategori_panduan', TRUE);
                $data = [
                    'nama_kategori_panduan' => $nama_kategori_panduan,
                ];
                $this->KategoriPanduan_Model->update($id_kategori_panduan, $data);
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

    function delete($id_kategori_panduan)
    {
        if ($this->input->is_ajax_request()) {
            $this->KategoriPanduan_Model->delete($id_kategori_panduan);
            echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
}
