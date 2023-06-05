<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KonfigurasiEmail extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
        $this->load->model('KonfigurasiEmail_Model');
    }
    var $column_order = [null, 'protocol', 'host', 'auth', 'user', 'password', 'post', 'timeout', 'crypto'];
    var $column_search = ['protocol', 'host', 'auth', 'user', 'password', 'post', 'timeout', 'crypto'];
    var $order = ['id_konfigurasi_email' => 'ASC'];
    public function index()
    {
        $data = [
            'title' => 'Manajemen Konfigurasi Email',
            'breadcrumb' => breadcrumb('Manajemen Konfigurasi Email', 'backend/KonfigurasiEmail')
        ];
        $this->template->load('template/backend', 'backend/konfigurasiemail', $data);
    }
    function getDataKonfigurasiEmail()
    {
        if ($this->input->is_ajax_request()) {
            $query = [
                'table' => 'tb_konfigurasi_email',
                'select' => '*',
                'where' => [],
                'join' => []
            ];
            // var_dump($this->input->post('tipe'));
            $konf = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($konf as $ap) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                $row[] = $ap->protocol;
                $row[] = $ap->host;
                $row[] = $ap->auth;
                $row[] = $ap->user;
                $row[] = $ap->port;
                $row[] = $ap->timeout;
                $row[] = $ap->crypto;
                $row[] = date('d-m-Y', strtotime($ap->updated_at));
                $row[] = '
			  	<div class="">
				  	<a href="#" type="button" id="btn-edit-' . $ap->id_konfigurasi_email . '" onclick="ButtonEdit(' . $ap->id_konfigurasi_email . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
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
    function getDataById($id_konfigurasi_email)
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'sukses' => true,
                'data' => $this->KonfigurasiEmail_Model->getDataById($id_konfigurasi_email)->row_array()
            ];
            echo json_encode($response);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
    private function _validation()
    {
        $this->form_validation->set_rules('protocol', 'Protocol', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_rules('host', 'HOST', 'trim|required', ['required' => '%s Belum Diisi!!']);
        // $this->form_validation->set_rules('auth', 'AUTH', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_rules('user', 'User', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_rules('password', 'Password', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_rules('post', 'Port', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_rules('timeout', 'Timeout', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_rules('crypto', 'Crypto', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }


    function ubahkonfigurasiemail()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $id_konfigurasi_email = $this->input->post('id_konfigurasi_email', TRUE);
                $protocol = $this->input->post('protocol', TRUE);
                $host = $this->input->post('host', TRUE);
                // $auth = $this->input->post('auth', TRUE);
                $user = $this->input->post('user', TRUE);
                $password = $this->input->post('password', TRUE);
                $post = $this->input->post('post', TRUE);
                $timeout = $this->input->post('timeout', TRUE);
                $crypto = $this->input->post('crypto', TRUE);
                $data = [
                    'protocol' => $protocol,
                    'host' => $host,
                    // 'auth' => $auth,
                    'user' => $user,
                    'password' => $password,
                    'post' => $post,
                    'timeout' => $timeout,
                    'crypto' => $crypto,
                ];
                var_dump($data);
                die();
                $this->KonfigurasiEmail_Model->update($id_konfigurasi_email, $data);
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
}
