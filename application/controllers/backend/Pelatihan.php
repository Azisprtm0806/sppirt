<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelatihan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
        $this->load->model('Pelatihan_Model');
    }
    var $column_order = [null, 'nama_pelatihan'];
    var $column_search = ['nama_pelatihan'];
    var $order = ['created_at' => 'ASC'];
    function index()
    {
        $data = [
            'title' => 'Manajemen Pelatihan',
            'breadcrumb' => breadcrumb('Manajemen Pelatihan', 'backend/Pelatihan')
        ];
        $this->template->load('template/backend', 'backend/pelatihan', $data);
    }
    function getDataById($id_pelatihan)
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'sukses' => true,
                'data' => $this->Pelatihan_Model->getDataById($id_pelatihan)->row_array()
            ];
            echo json_encode($response);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
    function getDataPelatihan()
    {
        if ($this->input->is_ajax_request()) {
            $tipe = $this->input->post('tipe');
            $query = [
                'table' => 'tb_pelatihan',
                'select' => '*',
                'where' => ['deleted_at' => null],
                'join' => []
            ];
            // var_dump($this->input->post('tipe'));
            $pelatihan = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($pelatihan as $pl) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                $row[] = $pl->nama_pelatihan;
                $row[] = date('d-m-Y', strtotime($pl->created_at));
                $row[] = '
				  	<div class="">
					  	<a href="#" type="button" id="btn-edit-' . $pl->id_pelatihan . '" onclick="ButtonEdit(' . $pl->id_pelatihan . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
	                 	<a href="#" type="button" id="btn-delete-' . $pl->id_pelatihan . '" onclick="ButtonDelete(' . $pl->id_pelatihan . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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
    private function _validation()
    {
        $this->form_validation->set_rules('nama_pelatihan', 'Nama Pelatihan', 'trim|required', ['required' => '%s Belum Dipilih!!']);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }
    function tambahpelatihan()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $nama_pelatihan = $this->input->post('nama_pelatihan', TRUE);
                $data = [
                    'nama_pelatihan' => $nama_pelatihan,
                ];
                $this->Pelatihan_Model->insert($data);
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
    function ubahpelatihan()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $id_pelatihan = $this->input->post('id_pelatihan', TRUE);
                $nama_pelatihan = $this->input->post('nama_pelatihan', TRUE);
                $data = [
                    'nama_pelatihan' => $nama_pelatihan,
                ];
                $this->Pelatihan_Model->update($id_pelatihan, $data);
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

    function delete($id_pelatihan)
    {
        if ($this->input->is_ajax_request()) {
            $this->Pelatihan_Model->delete($id_pelatihan);
            echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
}
