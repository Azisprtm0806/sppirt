<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Slider extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cekLogin();
        $this->load->model('Datatable_Model');
        $this->load->model('Slider_Model');
    }
    var $column_order = [null, 'judul_slider', 'gambar_slider'];
    var $column_search = ['judul_slider', 'gambar_slider'];
    var $order = ['created_at' => 'ASC'];
    public function index()
    {
        $data = [
            'title' => 'Manajemen Slider',
            'breadcrumb' => breadcrumb('Manajemen Slider', 'backend/Slider')
        ];
        $this->template->load('template/backend', 'backend/Slider', $data);
    }
    function getDataSlider()
    {
        if ($this->input->is_ajax_request()) {
            // $tipe = $this->input->post('tipe');
            $query = [
                'table' => 'tb_slider',
                'select' => '*',
                'where' => ['deleted_at' => null],
                'join' => []
            ];
            // var_dump($this->input->post('tipe'));
            $Slider = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
            $data = [];
            $no = @$_POST['start'];
            foreach ($Slider as $slide) {
                $no++;
                $row = [];
                $row[] = $no . ".";
                $row[] = $slide->judul_slider;
                // $row[] = $slide->gambar_slider;
                $row[] = '
                <div class="header-right">
                
                <div class="header-profile">
                    <img src="' . base_url('uploads/slider/') . $slide->gambar_slider . '" width="20" alt=""/>
                </div>
                </div>';
                $row[] = date('d-m-Y', strtotime($slide->created_at));
                $row[] = '
			  	<div class="">
				  	<a href="#" type="button" id="btn-edit-' . $slide->id_slider . '" onclick="ButtonEdit(' . $slide->id_slider . ')" class="btn btn-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                 	<a href="#" type="button" id="btn-delete-' . $slide->id_slider . '" onclick="ButtonDelete(' . $slide->id_slider . ')" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>

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
    function getDataById($id_slider)
    {
        if ($this->input->is_ajax_request()) {
            $response = [
                'sukses' => true,
                'data' => $this->Slider_Model->getDataById($id_slider)->row_array()
            ];
            echo json_encode($response);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
    private function _validation()
    {
        $this->form_validation->set_rules('judul_slider', 'Judul Slider', 'trim|required', ['required' => '%s Belum Diisi!!']);
        $this->form_validation->set_error_delimiters('', '');
        return $this->form_validation->run();
    }

    function tambahslider()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $judul_slider = $this->input->post('judul_slider', TRUE);
                $upload_slider = $this->upload($judul_slider);
                // var_dump($upload_slider);die;
                if ($upload_slider['status']) {
                    createThumbnail('slider', $upload_slider['gambar_slider']);

                    $data = [
                        'judul_slider' => $judul_slider,
                        'gambar_slider' => $upload_slider['gambar_slider'],
                    ];

                    $this->Slider_Model->insert($data);
                    $response = [
                        'status' => true,
                        'alert' => "Ditambahkan"
                    ];
                } else {
                    $response['error'] = ['gambar_slider' => $upload_slider['gambar_slider_error']];
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

    function upload($judul_slider)
    {
        $this->load->helper('string');
        $random = random_string('alnum', 4);
        $config = [
            'upload_path' => './uploads/slider/',
            'allowed_types' => 'jpg|jpeg|png',
            'max_size' => '5000',
            'encrypt_name' => true,
            'file_name' => 'slider-' . url_title($judul_slider, 'dash', true) . '-' . date('d-m-Y') . '-' . $random,
        ];
        $this->load->library('upload', $config);
        if ($this->input->post('id_slider')) {
            $cek = $this->db->get_where('tb_slider', ['id_slider' => $this->input->post('id_slider')])->row_array();
            if ($_FILES['gambar_slider']['name']) {
                if (!$this->upload->do_upload('gambar_slider')) {
                    $response = ['gambar_slider_error' => $this->upload->display_errors(), 'status' => false];
                } else {
                    $response = ['gambar_slider' => $this->upload->data('file_name'), 'status' => true];
                    unlink(FCPATH . './uploads/slider/' . $cek['gambar_slider']);
                    unlink(FCPATH . './uploads/slider/thumbnail/' . $cek['gambar_slider']);
                }
            } else {
                $response = ['gambar_slider' => $cek['gambar_slider'], 'status' => true];
            }
        } else {
            if (!$this->upload->do_upload('gambar_slider')) {
                $response = ['gambar_slider_error' => $this->upload->display_errors(), 'status' => false];
            } else {
                $response = ['gambar_slider' => $this->upload->data('file_name'), 'status' => true];
            }
        }
        return $response;
    }

    function ubahslider()
    {
        if ($this->input->is_ajax_request()) {
            if ($this->_validation()) {
                $id_slider = $this->input->post('id_slider', TRUE);
                $judul_slider = $this->input->post('judul_slider', TRUE);
                $upload_slider = $this->upload($judul_slider);
                createThumbnail('slider', $upload_slider['gambar_slider']);
                if ($upload_slider['status']) {
                    $data = [
                        'judul_slider' => $judul_slider,
                        'gambar_slider' => $upload_slider['gambar_slider'],
                    ];

                    $this->Slider_Model->update($id_slider, $data);
                    $response = [
                        'status' => true,
                        'alert' => "Diperbarui"
                    ];
                } else {
                    $response['error'] = ['gambar_slider' => $upload_slider['gambar_slider_error']];
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

    function delete($id_judul)
    {
        if ($this->input->is_ajax_request()) {
            $this->Slider_Model->delete($id_judul);
            echo json_encode(['sukses' => true, 'alert' => 'Dihapus']);
        } else {
            exit('Proses Tidak Dapat Dilanjutkan');
        }
    }
}
