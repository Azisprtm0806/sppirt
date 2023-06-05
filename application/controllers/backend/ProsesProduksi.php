<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProsesProduksi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
        $this->load->model('ProsesProduksi_Model');
    }
    var $column_order = [null, 'nama_proses_produksi','created_at'];
    var $column_search = ['nama_proses_produksi','created_at'];
    var $order = ['created_at' => 'ASC'];
    function index()
    {
        $data = [
            'title' => 'Manajemen Proses Produksi',
            'breadcrumb' => breadcrumb('Manajemen Proses Produksi', 'backend/ProsesProduksi')
        ];
        $this->template->load('template/backend', 'backend/prosesproduksi', $data);
    }
    function getDataById($id_proses_produksi)
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'sukses' => true,
                'data' => $this->ProsesProduksi_Model->getDataById($id_proses_produksi)->row_array()
            ];
            echo json_encode($response);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
    function getDataProsesProduksi()
    {
        if ($this->input->is_ajax_request()) {
            $tipe = $this->input->post('tipe');
            $query = [
                'table' => 'tb_proses_produksi',
                'select' => '*',
                'where' => ['deleted_at' => null],
                'join' => []
            ];
            // var_dump($this->input->post('tipe'));
            $dataproses = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($dataproses as $pp) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                $row[] = $pp->nama_proses_produksi;
                $row[] = date('d-m-Y', strtotime($pp->created_at));
                $row[] = '
				  	<div class="">
					  	<a href="#" type="button" id="btn-edit-' . $pp->id_proses_produksi . '" onclick="ButtonEdit(' . $pp->id_proses_produksi . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
	                 	<a href="#" type="button" id="btn-delete-' . $pp->id_proses_produksi . '" onclick="ButtonDelete(' . $pp->id_proses_produksi . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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
        $this->form_validation->set_rules('nama_proses_produksi', 'Nama Proses produksi', 'trim|required', ['required' => '%s Belum Dipilih!!']);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }
    function tambahprosesproduksi()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $nama_proses_produksi = $this->input->post('nama_proses_produksi', TRUE);
                $data = [
                    'nama_proses_produksi' => $nama_proses_produksi,
                ];
                $this->ProsesProduksi_Model->insert($data);
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
    function ubahprosesproduksi()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $id_proses_produksi = $this->input->post('id_proses_produksi', TRUE);
                $nama_proses_produksi = $this->input->post('nama_proses_produksi', TRUE);
                $data = [
                    'nama_proses_produksi' => $nama_proses_produksi,
                ];
                $this->ProsesProduksi_Model->update($id_proses_produksi, $data);
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

    function delete($id_proses_produksi)
    {
        if ($this->input->is_ajax_request()) {
            $this->ProsesProduksi_Model->delete($id_proses_produksi);
            echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
}
