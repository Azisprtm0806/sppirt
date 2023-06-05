<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Instansi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
        $this->load->model('Instansi_Model');
    }
    var $column_order = [null, 'kode_instansi', 'nama_instansi'];
    var $column_search = ['kode_instansi', 'nama_instansi'];
    var $order = ['created_at' => 'ASC'];
    public function index()
    {
        $data = [
            'title' => 'Manajemen Instansi',
            'breadcrumb' => breadcrumb('Manajemen Instansi', 'backend/Instansi')
        ];
        $this->template->load('template/backend', 'backend/instansi', $data);
    }
    function getDataInstansi()
    {
        if ($this->input->is_ajax_request()) {
            $tipe = $this->input->post('tipe');
            $query = [
                'table' => 'tb_instansi',
                'select' => '*',
                'where' => ['deleted_at' => null],
                'join' => []
            ];
            // var_dump($this->input->post('tipe'));
            $instansi = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($instansi as $inst) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                $row[] = $inst->kode_instansi;
                $row[] = $inst->nama_instansi;
                $row[] = date('d-m-Y', strtotime($inst->created_at));
                $row[] = '
			  	<div class="">
				  	<a href="#" type="button" id="btn-edit-' . $inst->id_instansi . '" onclick="ButtonEdit(' . $inst->id_instansi . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                 	<a href="#" type="button" id="btn-delete-' . $inst->id_instansi . '" onclick="ButtonDelete(' . $inst->id_instansi . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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
    function getDataById($kode_instansi)
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'sukses' => true,
                'data' => $this->Instansi_Model->getDataById($kode_instansi)->row_array()
            ];
            echo json_encode($response);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
    private function _validation()
    {
        $this->form_validation->set_rules('kode_instansi', 'Kode Instansi', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_rules('nama_instansi', 'Nama Instansi', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }

    function tambahinstansi()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $nama_instansi = $this->input->post('nama_instansi', TRUE);
                $kode_instansi = $this->input->post('kode_instansi', TRUE);
                $data = [
                    'nama_instansi' => $nama_instansi,
                    'kode_instansi' => $kode_instansi,
                ];
                $this->Instansi_Model->insert($data);
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
    function ubahinstansi()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $id_instansi = $this->input->post('id_instansi', TRUE);
                $kode_instansi = $this->input->post('kode_instansi', TRUE);
                $nama_instansi = $this->input->post('nama_instansi', TRUE);
                $data = [
                    'kode_instansi' => $kode_instansi,
                    'nama_instansi' => $nama_instansi,
                ];
                $this->Instansi_Model->update($id_instansi, $data);
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

    function delete($kode_instansi)
    {
        if ($this->input->is_ajax_request()) {
            $this->Instansi_Model->delete($kode_instansi);
            echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
}
