<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Panduan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
        $this->load->model('Panduan_Model');
    }
    var $column_order = [null, 'nama_kategori_panduan','judul','file'];
    var $column_search = ['nama_kategori_panduan','judul','file'];
    var $order = ['tb_panduan.created_at' => 'ASC'];
    public function index()
    {
        $data = [
            'title' => 'Manajemen Panduan',
            'kategoripanduan' => $this->db->get_where('tb_kategori_panduan', ['deleted_at' => null])->result_array(),
            'breadcrumb' => breadcrumb('Manajemen Panduan', 'backend/Panduan')
        ];
        $this->template->load('template/backend', 'backend/Panduan', $data);
    }
    function getDataPanduan()
    {
        if ($this->input->is_ajax_request()) {
            // $tipe = $this->input->post('tipe');
            $query = [
                'table' => 'tb_panduan',
                'select' => '*',
                'where' => ['tb_panduan.deleted_at' => null],
                'join' => [['tb_kategori_panduan','tb_panduan.id_kategori = tb_kategori_panduan.id_kategori_panduan','INNER']]
            ];
            // var_dump($this->input->post('tipe'));
            $Panduan = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($Panduan as $pan) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                $row[] = $pan->nama_kategori_panduan;
                $row[] = $pan->judul;
                $row[] = '<a href="'.base_url('uploads/panduan/').$pan->file.'" targer="_BLANK">'.$pan->file.'</a>';
                
                // $row[] = $pan->file;
                $row[] = date('d-m-Y', strtotime($pan->created_at));
                $row[] = '
			  	<div class="">
				  	<a href="#" type="button" id="btn-edit-' . $pan->id_panduan . '" onclick="ButtonEdit(' . $pan->id_panduan . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                 	<a href="#" type="button" id="btn-delete-' . $pan->id_panduan . '" onclick="ButtonDelete(' . $pan->id_panduan . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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
    function getDataById($id_panduan)
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'sukses' => true,
                'data' => $this->Panduan_Model->getDataById($id_panduan)->row_array()
            ];
            echo json_encode($response);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
    private function _validation()
    {
        
        $this->form_validation->set_rules('id_kategori', 'Kategori Panduan', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_rules('judul', 'Judul', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }

    function tambahpanduan()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $id_kategori = $this->input->post('id_kategori', TRUE);
                $judul = $this->input->post('judul', TRUE);
                $upload_panduan = $this->upload($judul);
                // var_dump($upload_panduan);die;
                if ($upload_panduan['status']) {
                    $data = [
                        'id_kategori' => $id_kategori,
                        'judul' => $judul,
                        'file' => $upload_panduan['file_panduan'],
                    ];
                    
                $this->Panduan_Model->insert($data);
                $response = [
                    'status' => true,
                    'alert' => "Ditambahkan"
                ];
            }else{
                $response['error'] = ['file_panduan' => $upload_panduan['file_panduan_error']];
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

    function upload($judul)
    {
        $this->load->helper('string');
        $random = random_string('alnum', 4);
        $config = [
            'upload_path' => './uploads/panduan/',
            'allowed_types' => 'pdf',
            'max_size' => '5000',
            'encrypt_name' => true,
            'file_name' => 'panduan-'.url_title($judul,'dash',true).'-'.date('d-m-Y').'-'.$random,
        ];
        $this->load->library('upload',$config);
        if ($this->input->post('id_panduan')) {
            $cek = $this->db->get_where('tb_panduan', ['id_panduan' => $this->input->post('id_panduan')])->row_array();
            if ($_FILES['file']['name']) {
                if (!$this->upload->do_upload('file')) {
                    $response = ['file_panduan_error' => $this->upload->display_errors(),'status' => false];
                } else {
                    $response = ['file_panduan' => $this->upload->data('file_name'),'status' => true];
                    unlink(FCPATH.'./uploads/panduan/'.$cek['file']);
                    // unlink(FCPATH.'./uploads/panduan/thumbnail/'.$cek['file_panduan']);
                }
            }else{
                    $response = ['file_panduan' => $cek['file'],'status' => true];
            }
        }else{
            if (!$this->upload->do_upload('file')) {
                $response = ['file_panduan_error' => $this->upload->display_errors(),'status' => false];
            } else {
                $response = ['file_panduan' => $this->upload->data('file_name'),'status' => true];
            }
        }
        return $response;
    }

    function ubahpanduan()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $id_panduan = $this->input->post('id_panduan', TRUE);
                $id_kategori = $this->input->post('id_kategori', TRUE);
                $judul = $this->input->post('judul', TRUE);
                // $file = $this->input->post('file', TRUE);
                $upload_panduan = $this->upload($judul);

                if ($upload_panduan['status']) {
                        $data = [
                            'id_kategori' => $id_kategori,
                            'judul' => $judul,
                            'file' => $upload_panduan['file_panduan'],
                        ];
                    $this->Panduan_Model->update($id_panduan, $data);
                    $response = [
                        'status' => true,
                        'alert' => "Diperbarui"
                    ];
                }else{
                    $response['error'] = ['file_panduan' => $upload_panduan['file_panduan_error']];
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

    function delete($id_panduan)
    {
        if ($this->input->is_ajax_request()) {
            $this->Panduan_Model->delete($id_panduan);
            echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
}
