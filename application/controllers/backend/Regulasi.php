<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Regulasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
        $this->load->model('Regulasi_Model');
    }
    var $column_order = [null, 'nama_kategori_regulasi','judul_regulasi','file_regulasi'];
    var $column_search = ['nama_kategori_regulasi','judul_regulasi','file_regulasi'];
    var $order = ['tb_regulasi.created_at' => 'ASC'];
    public function index()
    {
        $data = [
            'title' => 'Manajemen Regulasi',
            'kategoriregulasi' => $this->db->get_where('tb_kategori_regulasi', ['deleted_at' => null])->result_array(),
            'breadcrumb' => breadcrumb('Manajemen Regulasi', 'backend/Regulasi')
        ];
        $this->template->load('template/backend', 'backend/Regulasi', $data);
    }
    function getDataRegulasi()
    {
        if ($this->input->is_ajax_request()) {
            // $tipe = $this->input->post('tipe');
            $query = [
                'table' => 'tb_regulasi',
                'select' => '*',
                'where' => ['tb_regulasi.deleted_at' => null],
                'join' => [['tb_kategori_regulasi','tb_regulasi.id_kategori = tb_kategori_regulasi.id_kategori_regulasi','INNER']]
            ];
            // var_dump($this->input->post('tipe'));
            $regulasi = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($regulasi as $reg) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                $row[] = $reg->nama_kategori_regulasi;
                $row[] = $reg->judul_regulasi;
                $row[] = '<a href="'.base_url('uploads/regulasi/').$reg->file_regulasi.'" targer="_BLANK">'.$reg->file_regulasi.'</a>';
                
                // $row[] = $reg->file_regulasi;
                $row[] = date('d-m-Y', strtotime($reg->created_at));
                $row[] = '
			  	<div class="">
				  	<a href="#" type="button" id="btn-edit-' . $reg->id_regulasi . '" onclick="ButtonEdit(' . $reg->id_regulasi . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                 	<a href="#" type="button" id="btn-delete-' . $reg->id_regulasi . '" onclick="ButtonDelete(' . $reg->id_regulasi . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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
    function getDataById($id_regulasi)
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'sukses' => true,
                'data' => $this->Regulasi_Model->getDataById($id_regulasi)->row_array()
            ];
            echo json_encode($response);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
    private function _validation()
    {
        
        $this->form_validation->set_rules('id_kategori', 'Kategori Regulasi', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_rules('judul_regulasi', 'Judul', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }

    function tambahregulasi()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $id_kategori = $this->input->post('id_kategori', TRUE);
                $judul_regulasi = $this->input->post('judul_regulasi', TRUE);
                $upload_regulasi = $this->upload($judul_regulasi);
                // var_dump($upload_regulasi);die;
                if ($upload_regulasi['status']) {
                    $data = [
                        'id_kategori' => $id_kategori,
                        'judul_regulasi' => $judul_regulasi,
                        'file_regulasi' => $upload_regulasi['file_regulasi'],
                    ];
                    
                $this->Regulasi_Model->insert($data);
                $response = [
                    'status' => true,
                    'alert' => "Ditambahkan"
                ];
            }else{
                $response['error'] = ['file_regulasi' => $upload_regulasi['file_regulasi_error']];
                $response['status'] = false;
                $response['alert'] = 'Ditambahkan';
            }
                
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

    function upload($judul_regulasi)
    {
        $this->load->helper('string');
        $random = random_string('alnum', 4);
        $config = [
            'upload_path' => './uploads/regulasi/',
            'allowed_types' => 'pdf',
            'max_size' => '5000',
            'encrypt_name' => true,
            'file_name' => 'regulasi-'.url_title($judul_regulasi,'dash',true).'-'.date('d-m-Y').'-'.$random,
        ];
        $this->load->library('upload',$config);
        if ($this->input->post('id_regulasi')) {
            $cek = $this->db->get_where('tb_regulasi', ['id_regulasi' => $this->input->post('id_regulasi')])->row_array();
            if ($_FILES['file_regulasi']['name']) {
                if (!$this->upload->do_upload('file_regulasi')) {
                    $response = ['file_regulasi_error' => $this->upload->display_errors(),'status' => false];
                } else {
                    $response = ['file_regulasi' => $this->upload->data('file_regulasi_name'),'status' => true];
                    unlink(FCPATH.'./uploads/regulasi/'.$cek['file_regulasi']);
                    // unlink(FCPATH.'./uploads/regulasi/thumbnail/'.$cek['file_regulasi']);
                }
            }else{
                    $response = ['file_regulasi' => $cek['file_regulasi'],'status' => true];
            }
        }else{
            if (!$this->upload->do_upload('file_regulasi')) {
                $response = ['file_regulasi_error' => $this->upload->display_errors(),'status' => false];
            } else {
                $response = ['file_regulasi' => $this->upload->data('file_name'),'status' => true];
            }
        }
        return $response;
    }

    function ubahregulasi()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $id_regulasi = $this->input->post('id_regulasi', TRUE);
                $id_kategori = $this->input->post('id_kategori', TRUE);
                $judul_regulasi = $this->input->post('judul_regulasi', TRUE);
                // $file_regulasi = $this->input->post('file_regulasi', TRUE);
                $upload_regulasi = $this->upload($judul_regulasi);

                if ($upload_regulasi['status']) {
                        $data = [
                            'id_kategori' => $id_kategori,
                            'judul_regulasi' => $judul_regulasi,
                            'file_regulasi' => $upload_regulasi['file_regulasi'],
                        ];
                    $this->Regulasi_Model->update($id_regulasi, $data);
                    $response = [
                        'status' => true,
                        'alert' => "Diperbarui"
                    ];
                }else{
                    $response['error'] = ['file_regulasi' => $upload_regulasi['file_regulasi_error']];
                    $response['status'] = false;
                    $response['alert'] = 'Diperbarui';
                }
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

    function delete($id_regulasi)
    {
        if ($this->input->is_ajax_request()) {
            $this->Regulasi_Model->delete($id_regulasi);
            echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
}
