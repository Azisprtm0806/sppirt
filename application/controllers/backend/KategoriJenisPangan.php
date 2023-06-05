<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KategoriJenisPangan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
        $this->load->model('KategoriJenisPangan_Model');
    }
    var $column_order = [null, 'nama_kategori_jenis_pangan','created_at'];
    var $column_search = ['nama_kategori_jenis_pangan','created_at'];
    var $order = ['id_kategori_jenis_pangan' => 'ASC'];
    public function index()
    {
        $data = [
            'title' => 'Manajemen Jenis Pangan',
            'breadcrumb' => breadcrumb('Manajemen Kategori Jenis Pangan', 'backend/KategoriJenisPangan')
        ];
        $this->template->load('template/backend', 'backend/kategorijenispangan', $data);
    }
    function getDataJenisPangan()
    {
        if ($this->input->is_ajax_request()) {
            $tipe = $this->input->post('tipe');
            $query = [
                'table' => 'tb_kategori_jenis_pangan',
                'select' => '*',
                'where' => ['deleted_at' => null],
                'join' => []
            ];
            // var_dump($this->input->post('tipe'));
            $kategorijenispangan = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($kategorijenispangan as $katjp) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                $row[] = $katjp->nama_kategori_jenis_pangan;
                $row[] = $katjp->kode_kategori_jenis_pangan;
                $row[] = date('d-m-Y H-i-s', strtotime($katjp->created_at));
                $row[] = date('d-m-Y H-i-s', strtotime($katjp->updated_at));
                $row[] = '
			  	<div class="">
				  	<a href="#" type="button" id="btn-edit-' . $katjp->id_kategori_jenis_pangan . '" onclick="ButtonEdit(' . $katjp->id_kategori_jenis_pangan . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                 	<a href="#" type="button" id="btn-delete-' . $katjp->id_kategori_jenis_pangan . '" onclick="ButtonDelete(' . $katjp->id_kategori_jenis_pangan . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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
    function getDataById($id_kategori_jenis_pangan)
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'sukses' => true,
                'data' => $this->KategoriJenisPangan_Model->getDataById($id_kategori_jenis_pangan)->row_array()
            ];
            echo json_encode($response);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
    private function _validation()
    {
        $this->form_validation->set_rules('nama_kategori_jenis_pangan', 'Nama Kategori Jenis Pangan', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }

    function tambahkategori_jenis_pangan()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $nama_kategori_jenis_pangan = $this->input->post('nama_kategori_jenis_pangan', TRUE);
                $data = [
                    'nama_kategori_jenis_pangan' => $nama_kategori_jenis_pangan,
                ];
                $this->KategoriJenisPangan_Model->insert($data);
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
    function ubahkategori_jenis_pangan()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $id_kategori_jenis_pangan = $this->input->post('id_kategori_jenis_pangan', TRUE);
                $nama_kategori_jenis_pangan = $this->input->post('nama_kategori_jenis_pangan', TRUE);
                $data = [
                    'nama_kategori_jenis_pangan' => $nama_kategori_jenis_pangan,
                ];
                $this->KategoriJenisPangan_Model->update($id_kategori_jenis_pangan, $data);
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

    function delete($id_kategori_jenis_pangan)
    {
        if ($this->input->is_ajax_request()) {
            $this->KategoriJenisPangan_Model->delete($id_kategori_jenis_pangan);
            echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
}
