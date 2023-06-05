<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Faq extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
        $this->load->model('Faq_Model');
    }
    var $column_order = [null, 'pertanyaan_faq', 'jawaban_faq'];
    var $column_search = ['pertanyaan_faq', 'jawaban_faq'];
    var $order = ['created_at' => 'ASC'];
    public function index()
    {
        $data = [
            'title' => 'Manajemen FAQ',
            'breadcrumb' => breadcrumb('Manajemen FAQ', 'backend/Faq')
        ];
        $this->template->load('template/backend', 'backend/Faq', $data);
    }
    function getDataFaq()
    {
        if ($this->input->is_ajax_request()) {
            // $tipe = $this->input->post('tipe');
            $query = [
                'table' => 'tb_faq',
                'select' => '*',
                'where' => ['deleted_at' => null],
                'join' => []
            ];
            // var_dump($this->input->post('tipe'));
            $FAQ = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($FAQ as $faq) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                $row[] = $faq->pertanyaan_faq;
                $row[] = $faq->jawaban_faq;
                $row[] = date('d-m-Y', strtotime($faq->created_at));
                $row[] = '
			  	<div class="">
				  	<a href="#" type="button" id="btn-edit-' . $faq->id_faq . '" onclick="ButtonEdit(' . $faq->id_faq . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                 	<a href="#" type="button" id="btn-delete-' . $faq->id_faq . '" onclick="ButtonDelete(' . $faq->id_faq . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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
    function getDataById($id_faq)
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'sukses' => true,
                'data' => $this->Faq_Model->getDataById($id_faq)->row_array()
            ];
            echo json_encode($response);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
    private function _validation()
    {
        $this->form_validation->set_rules('pertanyaan_faq', 'Pertanyaan FAQ', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_rules('jawaban_faq', 'Jawaban FAQ', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }

    function tambahfaq()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $pertanyaan_faq = $this->input->post('pertanyaan_faq', TRUE);
                $jawaban_faq = $this->input->post('jawaban_faq', TRUE);
                $data = [
                    'pertanyaan_faq' => $pertanyaan_faq,
                    'jawaban_faq' => $jawaban_faq,
                ];
                $this->Faq_Model->insert($data);
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
    function ubahfaq()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $id_faq = $this->input->post('id_faq', TRUE);
                $pertanyaan_faq = $this->input->post('pertanyaan_faq', TRUE);
                $jawaban_faq = $this->input->post('jawaban_faq', TRUE);
                $data = [
                    'pertanyaan_faq' => $pertanyaan_faq,
                    'jawaban_faq' => $jawaban_faq,
                ];
                // var_dump($data);die;
                $this->Faq_Model->update($id_faq, $data);
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

    function delete($id_faq)
    {
        if ($this->input->is_ajax_request()) {
            $this->Faq_Model->delete($id_faq);
            echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
}
