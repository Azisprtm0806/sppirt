<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Narasumber extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
        $this->load->model('Narasumber_Model');
    }
    var $column_order = [null, 'nama_narasumber', 'nip', 'nik', 'nama_instansi', 'no_telp', 'email', 'nama_pelatihan', 'tahun_pelatihan'];
    var $column_search = ['nama_narasumber', 'nip', 'nik', 'nama_instansi', 'no_telp', 'email', 'nama_pelatihan', 'tahun_pelatihan'];
    var $order = ['tb_narasumber.created_at' => 'ASC'];
    function index()
    {
        $data = [
            'title' => 'Manajemen Narasumber',
            'instansi' => $this->db->get_where('tb_instansi', ['deleted_at' => null])->result_array(),
            'pelatihan' => $this->db->get_where('tb_pelatihan', ['deleted_at' => null])->result_array(),
            'breadcrumb' => breadcrumb('Manajemen Narasumber', 'backend/Narasumber')
        ];
        $this->template->load('template/backend', 'backend/narasumber', $data);
    }
    function getDataById($nip)
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'sukses' => true,
                'data' => $this->Narasumber_Model->getDataById($nip)->row_array()
            ];
            echo json_encode($response);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
    function getDataNarasumber()
    {
        if ($this->input->is_ajax_request()) {
            $tipe = $this->input->post('tipe');
            $query = [
                'table' => 'tb_narasumber',
                'select' => '*',
                'where' => ['tb_narasumber.deleted_at' => null],
                'join' => [
                    ['tb_instansi', 'tb_instansi.id_instansi = tb_narasumber.id_instansi', 'inner'],
                    ['tb_pelatihan', 'tb_pelatihan.id_pelatihan = tb_narasumber.id_pelatihan', 'inner']
                ]
            ];
            // var_dump($this->input->post('tipe'));
            $narasumber = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($narasumber as $nrs) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                $row[] = $nrs->nama_narasumber;
                $row[] = $nrs->nip;
                $row[] = $nrs->nik;
                $row[] = $nrs->nama_instansi;
                $row[] = $nrs->no_telp;
                $row[] = $nrs->email;
                $row[] = $nrs->nama_pelatihan;
                $row[] = $nrs->tahun_pelatihan;
                $row[] = '
				  	<div class="">
					  	<a href="#" type="button" id="btn-edit-' . $nrs->nip . '" onclick="ButtonEdit(' . $nrs->nip . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
	                 	<a href="#" type="button" id="btn-delete-' . $nrs->nip . '" onclick="ButtonDelete(' . $nrs->nip . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
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
        $this->form_validation->set_rules('nama_narasumber', 'Nama Narasumber', 'trim|required', ['required' => '%s Belum Dipilih!!']);
        $this->form_validation->set_rules('NIP', 'NIP', 'trim|required', ['required' => '%s Belum Dipilih!!']);
        $this->form_validation->set_rules('NIK', 'NIK', 'trim|required', ['required' => '%s Belum Dipilih!!']);
        $this->form_validation->set_rules('nama_instansi', 'Nama Instansi', 'trim|required', ['required' => '%s Belum Dipilih!!']);
        $this->form_validation->set_rules('no_telp', 'Nomor Telpon', 'trim|required', ['required' => '%s Belum Dipilih!!']);
        $this->form_validation->set_rules('email', 'Email', 'trim|required', ['required' => '%s Belum Dipilih!!']);
        $this->form_validation->set_rules('nama_pelatihan', 'Nama Pelatihan', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_rules('tahun_pelatihan', 'Tahun Pelatihan', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }
    function tambahnarasumber()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $nama_narasumber = $this->input->post('nama_narasumber', TRUE);
                $nip = $this->input->post('NIP', TRUE);
                $nik = $this->input->post('NIK', TRUE);
                $nama_instansi = $this->input->post('nama_instansi', TRUE);
                $no_telp = $this->input->post('no_telp', TRUE);
                $email = $this->input->post('email', TRUE);
                $nama_pelatihan = $this->input->post('nama_pelatihan', TRUE);
                $tahun_pelatihan = $this->input->post('tahun_pelatihan', TRUE);
                $data = [
                    'nip' => $nip,
                    'nik' => $nik,
                    'nama_narasumber' => $nama_narasumber,
                    'id_instansi' => $nama_instansi,
                    'no_telp' => $no_telp,
                    'email' => $email,
                    'id_pelatihan' => $nama_pelatihan,
                    'tahun_pelatihan' => $tahun_pelatihan,
                ];
                $this->Narasumber_Model->insert($data);
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
    function ubahnarasumber()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $nama_narasumber = $this->input->post('nama_narasumber', TRUE);
                $nip = $this->input->post('NIP', TRUE);
                $nik = $this->input->post('NIK', TRUE);
                $nama_instansi = $this->input->post('nama_instansi', TRUE);
                $no_telp = $this->input->post('no_telp', TRUE);
                $email = $this->input->post('email', TRUE);
                $nama_pelatihan = $this->input->post('nama_pelatihan', TRUE);
                $tahun_pelatihan = $this->input->post('tahun_pelatihan', TRUE);
                $data = [
                    'nip' => $nip,
                    'nik' => $nik,
                    'nama_narasumber' => $nama_narasumber,
                    'id_instansi' => $nama_instansi,
                    'no_telp' => $no_telp,
                    'email' => $email,
                    'id_pelatihan' => $nama_pelatihan,
                    'tahun_pelatihan' => $tahun_pelatihan,
                ];
                $this->Narasumber_Model->update($nip, $data);
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

    function delete($nip)
    {
        if ($this->input->is_ajax_request()) {
            $this->Narasumber_Model->delete($nip);
            echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
}
