<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->berita_model = new GeneralModel("tb_berita");
		if($_POST){
            $this->input_data = $this->input->post();
        }   
        else if($_GET){
            $this->input_data = $this->input->get();
        } else {
            $this->input_data = json_decode(file_get_contents("php://input"), true);
        }
        
	}

	function index()
	{
		$title = 'Selamat Datang di SPPIRT';
		$judul = 'SPPIRT';
		$this->db->select('*');
		$this->db->from('tb_berita');
		$this->db->limit(3, 'DESC');
		$berita = $this->db->order_by('created_at','DESC')->get()->result_array();
		$this->db->select('*');
		$this->db->from('tb_galeri');
		$this->db->limit(6, 'DESC');
		$galeri = $this->db->get()->result_array();
		$this->db->select('*');
		$this->db->from('tb_testimoni');
		$this->db->limit(6, 'DESC');
		$testimoni = $this->db->get()->result_array();
		$slider = $this->db->get_where('tb_slider', ['deleted_at' => null])->result_array();


		$data = [
			'title' => $title,
			'judul' => $judul,
			'berita' => $berita,
			'galeri' => $galeri,
			'slider' => $slider,
			'testimoni' => $testimoni
		];
		$this->template->load('template/frontend', 'frontend/index', $data);
	}

	function berita()
	{
		$title = 'Berita | SPPIRT';
		//$this->db->select('*');
		//$this->db->from('tb_berita');
		//$this->db->limit(9, 'DESC');
		//$berita = $this->db->get()->result_array();
		
		$limit = isset($this->input_data['limit'])?$this->input_data['limit']:6;
		$page = isset($this->input_data['page'])?$this->input_data['page']:1;
		$start = isset($this->input_data['page'])?(($page-1)*$limit):0;

		$q = isset($this->input_data['q'])?$this->input_data['q']:"";

		$query = $this->berita_model->source();
		
		
		$total_data = $query->count_all_results();

		$query = $this->berita_model->source();
		
		$query->limit($limit,$start);
		$query->order_by('created_at','DESC');
		$berita = $query->get()->result_array();

		$data['total_data'] = $total_data;
		$data['limit'] = $limit;
		$data['start'] = $start;
		$data['pagination'] = $this->paging_page('berita',$limit,$total_data);
		$data['title'] = $title;
		$data['berita'] = $berita;
		
		
		$this->template->load('template/frontend', 'frontend/berita', $data);
	}

	function detail_berita()
	{
		$title = 'Detail Berita';
		$slug = $this->uri->segment(3);
		if(!empty($slug)){
			if(strlen($slug) < 30){
				redirect('404_override');
			}
			else{
				$id = encrypt_decrypt('decrypt', $slug);
				$detail_berita = $this->db->get_where('tb_berita', ['id_berita' => $id])->row_array();
				$this->db->select('*');
				$this->db->from('tb_berita');
				$this->db->limit(6, 'DESC');
				$berita_terbaru = $this->db->get()->result_array();
				$data = [
					'title' => $title,
					'detail_berita' => $detail_berita,
					'berita_terbaru' => $berita_terbaru,
				];
				$this->template->load('template/frontend', 'frontend/detail_berita', $data);
			}
		}
		else{
			redirect('404_override');
		}
	}

	function galeri()
	{
		$title = 'Galeri | SPPIRT';
		$judul = 'SPPIRT';
		$this->db->select('*');
		$this->db->from('tb_galeri');
		$this->db->where('deleted_at', null);
		$this->db->limit(9, 'DESC');
		$galeri = $this->db->get()->result_array();
		$data = [
			'title' => $title,
			'judul' => $judul,
			'galeri' => $galeri
		];
		$this->template->load('template/frontend', 'frontend/galeri', $data);
	}

	function regulasi()
	{
		$data['title'] = 'Regulasi | SPPIRT';
		$this->template->load('template/frontend', 'frontend/regulasi', $data);
	}
	
	function error_register_oss()
	{
		$data['title'] = 'Error Parameter | OSS - SPPIRT';
		$this->template->load('template/frontend', 'frontend/error_register_oss', $data);
	}

	function panduan()
	{
		$data['title'] = 'Panduan | SPPIRT';
		$this->template->load('template/frontend', 'frontend/panduan', $data);
	}
	function kontak()
	{
		$data['title'] = 'Kontak Kami | SPPIRT';
		$this->template->load('template/frontend', 'frontend/kontakkami', $data);
	}

	function faq()
	{
		$data['title'] = 'FAQ | SPPIRT';
		$this->template->load('template/frontend', 'frontend/faq', $data);
	}
	
	function TambahSaran()
	{
		if ($this->input->is_ajax_request()) {
			if ($this->_validation()) {
				$nama = $this->input->post('nama', TRUE);
				$email = $this->input->post('email', TRUE);
				$no_telp = $this->input->post('no_telp', TRUE);
				$komentar = $this->input->post('komentar', TRUE);
				$data = [
					'nama' => $this->input->post('nama', TRUE),
					'email' => $this->input->post('email', TRUE),
					'no_telp' => $this->input->post('no_telp', TRUE),
					'komentar' => $this->input->post('komentar', TRUE),
				];
				$this->db->insert('tb_saran', $data);
				$response = [
					'status' => true,
					'alert' => "Ditambahkan"
				];
			}
			else{
				$response['error'] = getErrorValidation();
                $response['status'] = false;
                $response['alert'] = 'Gagal Ditambahkan';
			}
			echo json_encode($response);
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}
	
	public function paging_page($url, $perpage, $total_rows) {

		$this->load->library('pagination');
		$base_url = base_url($url);
		$base_url .= get_query_string('page');
		$config['base_url'] = $base_url;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $perpage;
		$config['enable_query_strings'] = TRUE;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
		$config["use_page_numbers"] = TRUE;

		$config['first_link']       = '<i class="icofont-rounded-left"></i></a>';
        $config['last_link']        = '<i class="icofont-rounded-right"></i></a>';
        $config['prev_link']        = '<i class="icofont-rounded-left"></i></a>';
        $config['next_link']        = '<i class="icofont-rounded-right"></i></a>';
        $config['full_tag_open']    = '<div class="blog-pagination"><ul class="justify-content-center">';
        $config['full_tag_close']   = '</ul></div>';
        $config['num_tag_open']     = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = '<li class="active" style="padding:7px 16px">';
        $config['cur_tag_close']    = '</li>';
        $config['next_tag_open']    = '<li>';
        $config['next_tagl_close']  = '</li>';
        $config['prev_tag_open']    = '<li>';
        $config['prev_tagl_close']  = 'Next</li>';
        $config['first_tag_open']   = '<li>';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open']    = '<li>';
        $config['last_tagl_close']  = '</li>';

		$this->pagination->initialize($config);
		return $this->pagination->create_links();

	

	}
}
