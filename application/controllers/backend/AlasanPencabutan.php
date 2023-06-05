<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AlasanPencabutan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
        $this->load->model('AlasanPencabutan_Model');
    }
    var $column_order = [null, 'alasan'];
    var $column_search = ['alasan'];
    var $order = ['created_at' => 'ASC'];
    public function index()
    {
        $data = [
            'title' => 'Manajemen Alasan Pencabutan',
            'breadcrumb' => breadcrumb('Manajemen Alasan Pencabutan', 'backend/AlasanPencabutan')
        ];
        $this->template->load('template/backend', 'backend/alasanpencabutan', $data);
    }
    function getDataAlasanPencabutan()
    {
        if ($this->input->is_ajax_request()) {
            $tipe = $this->input->post('tipe');
            $query = [
                'table' => 'tb_alasan_pencabutan',
                'select' => '*',
                'where' => ['deleted_at' => null],
                'join' => []
            ];
            // var_dump($this->input->post('tipe'));
            $alasan = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($alasan as $ap) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                $row[] = $ap->alasan;
                $row[] = date('d-m-Y', strtotime($ap->created_at));
                $row[] = '
			  	<div class="">
				  	<a href="#" type="button" id="btn-edit-' . $ap->id_alasan . '" onclick="ButtonEdit(' . $ap->id_alasan . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                 	<a href="#" type="button" id="btn-delete-' . $ap->id_alasan . '" onclick="ButtonDelete(' . $ap->id_alasan . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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
    function getDataById($id_alasan)
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'sukses' => true,
                'data' => $this->AlasanPencabutan_Model->getDataById($id_alasan)->row_array()
            ];
            echo json_encode($response);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
    private function _validation()
    {
        $this->form_validation->set_rules('alasan', 'Alasan Pencabutan', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }

    function tambahalasanpencabutan()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $alasan = $this->input->post('alasan', TRUE);
                $data = [
                    'alasan' => $alasan,
                ];
                $this->AlasanPencabutan_Model->insert($data);
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
    function ubahalasanpencabutan()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $id_alasan = $this->input->post('id_alasan', TRUE);
                $alasan = $this->input->post('alasan', TRUE);
                $data = [
                    'alasan' => $alasan,
                ];
                $this->AlasanPencabutan_Model->update($id_alasan, $data);
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

    function delete($id_alasan)
    {
        if ($this->input->is_ajax_request()) {
            $this->AlasanPencabutan_Model->delete($id_alasan);
            echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
}
