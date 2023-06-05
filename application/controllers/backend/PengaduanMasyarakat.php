<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PengaduanMasyarakat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
        $this->load->model('PengaduanMasyarakat_Model');
    }
    var $column_order = [null, 'nama'];
    var $column_search = ['nama','email','komentar'];
    var $order = ['created_at' => 'ASC'];
    public function index()
    {
        $data = [
            'title' => 'Manajemen Pengaduan Masyarakat',
            'breadcrumb' => breadcrumb('Manajemen Pengaduan Masyrakat', 'backend/PengaduanMasyrakat')
        ];
        $this->template->load('template/backend', 'backend/PengaduanMasyarakat', $data);
    }
    function getDataPengaduanMasyarakat()
    {
        if ($this->input->is_ajax_request()) {
            // $tipe = $this->input->post('tipe');
            $query = [
                'table' => 'tb_pengaduan_masyarakat',
                'select' => '*',
                'where' => ['deleted_at' => null],
                'join' => []
            ];
            // var_dump($this->input->post('tipe'));
            $Pengaduan = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($Pengaduan as $penmas) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                $row[] = $penmas->nama;
                $row[] = $penmas->email;
                $row[] = $penmas->no_hp;
                $row[] = $penmas->komentar;
                $row[] = date('d-m-Y', strtotime($penmas->created_at));
                $row[] = '
			  	<div class="">
				  	<a href="#" type="button" id="btn-delete-' . $penmas->id_pengaduan_masyarakat . '" onclick="ButtonDelete(' . $penmas->id_pengaduan_masyarakat . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
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
    function getDataById($id_pengaduan_masyrakat)
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'sukses' => true,
                'data' => $this->PengaduanMasyarakat_Model->getDataById($id_pengaduan_masyrakat)->row_array()
            ];
            echo json_encode($response);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
    private function _validation()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_rules('email', 'Email', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_rules('no_hp', 'No Hp', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_rules('komentar', 'Komentar', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }

    function tambahslider()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $nama = $this->input->post('nama', TRUE);
                $email = $this->input->post('email', TRUE);
                $no_hp = $this->input->post('no_hp', TRUE);
                $komentar = $this->input->post('komentar', TRUE);
                $data = [
                    'nama' => $nama,
                    'judul_slider' => $judul_slider,
                    'no_hp' => $no_hp,
                    'komentar' => $komentar,
                ];
                $this->PengaduanMasyarakat_Model->insert($data);
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
    function delete($id_pengaduan_masyrakat)
    {
        if ($this->input->is_ajax_request()) {
            $this->PengaduanMasyarakat_Model->delete($id_pengaduan_masyrakat);
            echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
}
