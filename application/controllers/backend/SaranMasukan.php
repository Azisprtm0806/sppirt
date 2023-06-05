<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SaranMasukan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
        $this->load->model('SaranMasukan_Model');
    }
    var $column_order = [null, 'nama', 'email', 'no_telp', 'komentar'];
    var $column_search = ['nama', 'email', 'no_telp', 'komentar'];
    var $order = ['created_at' => 'ASC'];
    public function index()
    {
        $data = [
            'title' => 'Manajemen Saran dan Masukan',
            'breadcrumb' => breadcrumb('Manajemen Saran dan Masukan', 'backend/SaranMasukan')
        ];
        $this->template->load('template/backend', 'backend/saranmasukan', $data);
    }
    function getDataSaranMasukan()
    {
        if ($this->input->is_ajax_request()) {
            $tipe = $this->input->post('tipe');
            $query = [
                'table' => 'tb_saran',
                'select' => '*',
                'where' => ['deleted_at' => null],
                'join' => []
            ];
            // var_dump($this->input->post('tipe'));
            $saran = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($saran as $inst) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                $row[] = $inst->nama;
                $row[] = $inst->email;
                $row[] = $inst->no_telp;
                $row[] = $inst->komentar;
                $row[] = date('d-m-Y', strtotime($inst->created_at));
                $row[] = '
			  	<div class="">
                 	<a href="#" type="button" id="btn-delete-' . $inst->id_saran . '" onclick="ButtonDelete(' . $inst->id_saran . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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

    function delete($id_saran)
    {
        if ($this->input->is_ajax_request()) {
            $this->SaranMasukan_Model->delete($id_saran);
            echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
}
