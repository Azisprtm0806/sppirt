<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Galeri extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
        $this->load->model('Galeri_Model');
    }
    var $column_order = [null, 'judul_galeri', 'deskripsi_galeri', 'gambar_galeri'];
    var $column_search = ['judul_galeri', 'deskripsi_galeri', 'gambar_galeri'];
    var $order = ['created_at' => 'ASC'];
    public function index()
    {
        $data = [
            'title' => 'Manajemen Galeri',
            'breadcrumb' => breadcrumb('Manajemen Galeri', 'backend/Galeri')
        ];
        $this->template->load('template/backend', 'backend/Galeri', $data);
    }
    function getDataGaleri()
    {
        if ($this->input->is_ajax_request()) {
            // $tipe = $this->input->post('tipe');
            $query = [
                'table' => 'tb_galeri',
                'select' => '*',
                'where' => ['deleted_at' => null],
                'join' => []
            ];
            // var_dump($this->input->post('tipe'));
            $galeri = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($galeri as $gr) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                $row[] = $gr->judul_galeri;
                $row[] = $gr->deskripsi_galeri;
                $row[] = '
                <div class="header-right">
                
                <div class="header-profile">
                    <img src="' . base_url('uploads/galeri/') . $gr->gambar_galeri . '" width="20" alt=""/>
                </div>
                </div>';
                $row[] = date('d-m-Y', strtotime($gr->created_at));
                $row[] = '
			  	<div class="">
				  	<a href="#" type="button" id="btn-edit-' . $gr->id_galeri . '" onclick="ButtonEdit(' . $gr->id_galeri . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                 	<a href="#" type="button" id="btn-delete-' . $gr->id_galeri . '" onclick="ButtonDelete(' . $gr->id_galeri . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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
    function getDataById($id_galeri)
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'sukses' => true,
                'data' => $this->Galeri_Model->getDataById($id_galeri)->row_array()
            ];
            echo json_encode($response);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
    private function _validation()
    {
        $this->form_validation->set_rules('judul_galeri', 'Judul Galeri', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_rules('deskripsi_galeri', ' Deskripsi Galeri', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }

    function tambahgaleri()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $judul_galeri = $this->input->post('judul_galeri', TRUE);
                $deskripsi_galeri = $this->input->post('deskripsi_galeri', TRUE);
                $upload_galeri = $this->upload($judul_galeri);
                // var_dump($upload_galeri);die;
                if ($upload_galeri['status']) {
                    createThumbnail('galeri', $upload_galeri['gambar_galeri']);

                    $data = [
                        'judul_galeri' => $judul_galeri,
                        'deskripsi_galeri' => $deskripsi_galeri,
                        'gambar_galeri' => $upload_galeri['gambar_galeri'],
                    ];

                    $this->Galeri_Model->insert($data);
                    $response = [
                        'status' => true,
                        'alert' => "Ditambahkan"
                    ];
                } else {
                    $response['error'] = ['gambar_galeri' => $upload_galeri['gambar_galeri_error']];
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

    function upload($judul_galeri)
    {
        $this->load->helper('string');
        $random = random_string('alnum', 4);
        $config = [
            'upload_path' => './uploads/galeri/',
            'allowed_types' => 'jpg|jpeg|png',
            'max_size' => '5000',
            'encrypt_name' => true,
            'file_name' => 'galeri-' . url_title($judul_galeri, 'dash', true) . '-' . date('d-m-Y') . '-' . $random,
        ];
        $this->load->library('upload', $config);
        if ($this->input->post('id_galeri')) {
            $cek = $this->db->get_where('tb_galeri', ['id_galeri' => $this->input->post('id_galeri')])->row_array();
            if ($_FILES['gambar_galeri']['name']) {
                if (!$this->upload->do_upload('gambar_galeri')) {
                    $response = ['gambar_galeri_error' => $this->upload->display_errors(), 'status' => false];
                } else {
                    $response = ['gambar_galeri' => $this->upload->data('file_name'), 'status' => true];
                    unlink(FCPATH . './uploads/galeri/' . $cek['gambar_galeri']);
                    unlink(FCPATH . './uploads/galeri/thumbnail/' . $cek['gambar_galeri']);
                }
            } else {
                $response = ['gambar_galeri' => $cek['gambar_galeri'], 'status' => true];
            }
        } else {
            if (!$this->upload->do_upload('gambar_galeri')) {
                $response = ['gambar_galeri_error' => $this->upload->display_errors(), 'status' => false];
            } else {
                $response = ['gambar_galeri' => $this->upload->data('file_name'), 'status' => true];
            }
        }
        return $response;
    }

    function ubahgaleri()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $id_galeri = $this->input->post('id_galeri', TRUE);
                $judul_galeri = $this->input->post('judul_galeri', TRUE);
                $deskripsi_galeri = $this->input->post('deskripsi_galeri', TRUE);
                $upload_galeri = $this->upload($judul_galeri);
                createThumbnail('galeri', $upload_galeri['gambar_galeri']);
                if ($upload_galeri['status']) {
                    $data = [
                        'judul_galeri' => $judul_galeri,
                        'deskripsi_galeri' => $deskripsi_galeri,
                        'gambar_galeri' => $upload_galeri['gambar_galeri'],
                    ];

                    $this->Galeri_Model->update($id_galeri, $data);
                    $response = [
                        'status' => true,
                        'alert' => "Diperbarui"
                    ];
                } else {
                    $response['error'] = ['gambar_galeri' => $upload_galeri['gambar_galeri_error']];
                    $response['status'] = false;
                    $response['alert'] = 'Diperbarui';
                }
                // var_dump($data);die;
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

    function delete($id_galeri)
    {
        if ($this->input->is_ajax_request()) {
            $this->Galeri_Model->delete($id_galeri);
            echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
}
