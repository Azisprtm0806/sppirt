<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyimpanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
        $this->load->model('Penyimpanan_Model');
    }
    var $column_order = [null, 'cara_penyimpanan'];
    var $column_search = ['cara_penyimpanan'];
    var $order = ['created_at' => 'ASC'];
    public function index()
    {
        $data = [
            'title' => 'Manajemen Penyimpanan',
            'breadcrumb' => breadcrumb('Manajemen Penyimpanan', 'backend/Penyimpanan')
        ];
        $this->template->load('template/backend', 'backend/penyimpanan', $data);
    }
    function getDataPenyimpanan()
    {
        if ($this->input->is_ajax_request()) {
            $tipe = $this->input->post('tipe');
            $query = [
                'table' => 'tb_penyimpanan',
                'select' => '*',
                'where' => ['deleted_at' => null],
                'join' => []
            ];
            // var_dump($this->input->post('tipe'));
            $penyimpanan = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($penyimpanan as $ap) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                $row[] = $ap->cara_penyimpanan;
                $row[] = date('d-m-Y', strtotime($ap->created_at));
                $row[] = '
			  	<div class="">
				  	<a href="#" type="button" id="btn-edit-' . $ap->id_penyimpanan . '" onclick="ButtonEdit(' . $ap->id_penyimpanan . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                 	<a href="#" type="button" id="btn-delete-' . $ap->id_penyimpanan . '" onclick="ButtonDelete(' . $ap->id_penyimpanan . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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
    function getDataById($id_penyimpanan)
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'sukses' => true,
                'data' => $this->Penyimpanan_Model->getDataById($id_penyimpanan)->row_array()
            ];
            echo json_encode($response);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
    private function _validation()
    {
        $this->form_validation->set_rules('cara_penyimpanan', 'Cara Penyimpanan', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }

    function tambahpenyimpanan()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $cara_penyimpanan = $this->input->post('cara_penyimpanan', TRUE);
                $data = [
                    'cara_penyimpanan' => $cara_penyimpanan,
                ];
                $this->Penyimpanan_Model->insert($data);
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
    function ubahpenyimpanan()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $id_penyimpanan = $this->input->post('id_penyimpanan', TRUE);
                $cara_penyimpanan = $this->input->post('cara_penyimpanan', TRUE);
                $data = [
                    'cara_penyimpanan' => $cara_penyimpanan,
                ];
                $this->Penyimpanan_Model->update($id_penyimpanan, $data);
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

    function delete($id_penyimpanan)
    {
        if ($this->input->is_ajax_request()) {
            $this->Penyimpanan_Model->delete($id_penyimpanan);
            echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
}
