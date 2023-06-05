<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JenisKemasan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
        $this->load->model('JenisKemasan_Model');
    }
    var $column_order = [null, 'nama_kemasan', 'keterangan','created_at'];
    var $column_search = ['nama_kemasan', 'keterangan','created_at'];
    var $order = ['created_at' => 'ASC'];
    public function index()
    {
        $data = [
            'title' => 'Manajemen Jenis Kemasan',
            'breadcrumb' => breadcrumb('Manajemen Kategori Jenis Kemasan', 'backend/JenisKemasan')
        ];
        $this->template->load('template/backend', 'backend/jeniskemasan', $data);
    }
    function getDataJenisKemasan()
    {
        if ($this->input->is_ajax_request()) {
            $tipe = $this->input->post('tipe');
            $query = [
                'table' => 'tb_jenis_kemasan',
                'select' => '*',
                'where' => ['deleted_at' => null],
                'join' => []
            ];
            // var_dump($this->input->post('tipe'));
            $jeniskemasan = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($jeniskemasan as $jk) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                $row[] = $jk->nama_kemasan;
                $row[] = $jk->keterangan;
                $row[] = date('d-m-Y', strtotime($jk->created_at));
                $row[] = '
			  	<div class="">
				  	<a href="#" type="button" id="btn-edit-' . $jk->id_jenis_kemasan . '" onclick="ButtonEdit(' . $jk->id_jenis_kemasan . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                 	<a href="#" type="button" id="btn-delete-' . $jk->id_jenis_kemasan . '" onclick="ButtonDelete(' . $jk->id_jenis_kemasan . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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
    function getDataById($id_jenis_kemasan)
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'sukses' => true,
                'data' => $this->JenisKemasan_Model->getDataById($id_jenis_kemasan)->row_array()
            ];
            echo json_encode($response);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
    private function _validation()
    {
        $this->form_validation->set_rules('nama_kemasan', 'Nama Kemasan', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_rules('keterangan', 'Keterangan Jenis Kemasan', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }

    function tambahjeniskemasan()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $nama_kemasan = $this->input->post('nama_kemasan', TRUE);
                $keterangan = $this->input->post('keterangan', TRUE);

                $data = [
                    'nama_kemasan' => $nama_kemasan,
                    'keterangan' => $keterangan
                ];
                $this->JenisKemasan_Model->insert($data);
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
    function ubahjeniskemasan()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $id_jenis_kemasan = $this->input->post('id_jenis_kemasan', TRUE);
                $nama_kemasan = $this->input->post('nama_kemasan', TRUE);
                $keterangan = $this->input->post('keterangan', TRUE);

                $data = [
                    'nama_kemasan' => $nama_kemasan,
                    'keterangan' => $keterangan
                ];
                $this->JenisKemasan_Model->update($id_jenis_kemasan, $data);
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

    function delete($id_jenis_kemasan)
    {
        if ($this->input->is_ajax_request()) {
            $this->JenisKemasan_Model->delete($id_jenis_kemasan);
            echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
}
