<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JenisPangan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
        $this->load->model('JenisPangan_Model');
    }
    var $column_order = [null, 'nama_kategori_jenis_pangan', 'nama_jenis_pangan', 'deskripsi'];
    var $column_search = ['nama_kategori_jenis_pangan', 'nama_jenis_pangan','deskripsi'];
    var $order = ['tb_jenis_pangan.created_at' => 'ASC'];
    function index()
    {
        $data = [
            'title' => 'Manajemen Jenis Pangan',
            'kategorijenispangan' => $this->db->get_where('tb_kategori_jenis_pangan', ['deleted_at' => null])->result_array(),
            'breadcrumb' => breadcrumb('Manajemen Kategori Jenis Pangan', 'backend/JenisPangan')
        ];
        $this->template->load('template/backend', 'backend/jenispangan', $data);
    }
    function getDataById($id_jenis_pangan)
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'sukses' => true,
                'data' => $this->JenisPangan_Model->getDataById($id_jenis_pangan)->row_array()
            ];
            echo json_encode($response);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
    function getDataJenisPangan()
    {
        if ($this->input->is_ajax_request()) {
            $tipe = $this->input->post('tipe');
            $query = [
                'table' => 'tb_jenis_pangan',
                'select' => '*',
                'where' => ['tb_jenis_pangan.deleted_at' => null],
                'join' => [
                    ['tb_kategori_jenis_pangan', 'tb_kategori_jenis_pangan.id_kategori_jenis_pangan = tb_jenis_pangan.id_kategori_jenis_pangan', 'inner']
                ]
            ];
            // var_dump($this->input->post('tipe'));
            $datajenispangan = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($datajenispangan as $jenis_pangan) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                $row[] = $jenis_pangan->nama_kategori_jenis_pangan;
                $row[] = $jenis_pangan->nama_jenis_pangan;
                //$row[] = $jenis_pangan->deskripsi;
                $row[] = date('d-m-Y', strtotime($jenis_pangan->created_at));
                $row[] = '
				  	<div class="">
					  	<a href="#" type="button" id="btn-edit-' . $jenis_pangan->id_jenis_pangan . '" onclick="ButtonEdit(' . $jenis_pangan->id_jenis_pangan . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
	                 	<a href="#" type="button" id="btn-delete-' . $jenis_pangan->id_jenis_pangan . '" onclick="ButtonDelete(' . $jenis_pangan->id_jenis_pangan . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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
        $this->form_validation->set_rules('id_kategori_jenis_pangan', 'Kategori Jenis Pangan', 'trim|required', ['required' => '%s Belum Dipilih!!']);
        $this->form_validation->set_rules('nama_jenis_pangan', 'Nama Jenis Pangan', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }
    function tambahjenispangan()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $id_kategori_jenis_pangan = $this->input->post('id_kategori_jenis_pangan', TRUE);
                $nama_jenis_pangan = $this->input->post('nama_jenis_pangan', TRUE);
                $deskripsi = $this->input->post('deskripsi', TRUE);
                $data = [
                    'id_kategori_jenis_pangan' => $id_kategori_jenis_pangan,
                    'nama_jenis_pangan' => $nama_jenis_pangan,
                    'deskripsi' => $deskripsi,
                ];
                $this->JenisPangan_Model->insert($data);
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
    function ubahjenispangan()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $id_jenis_pangan = $this->input->post('id_jenis_pangan', TRUE);
                $id_kategori_jenis_pangan = $this->input->post('id_kategori_jenis_pangan', TRUE);
                $nama_jenis_pangan = $this->input->post('nama_jenis_pangan', TRUE);
                $deskripsi = $this->input->post('deskripsi', TRUE);
                $data = [
                    'id_kategori_jenis_pangan' => $id_kategori_jenis_pangan,
                    'nama_jenis_pangan' => $nama_jenis_pangan,
                    'deskripsi' => $deskripsi,
                ];
                $this->JenisPangan_Model->update($id_jenis_pangan, $data);
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

    function delete($id_jenis_pangan)
    {
        if ($this->input->is_ajax_request()) {
            $this->JenisPangan_Model->delete($id_jenis_pangan);
            echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
}
