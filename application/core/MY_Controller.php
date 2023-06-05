<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper("url");
		if($_POST){
            $this->input_data = $this->input->post();
        }   
        else if($_GET){
            $this->input_data = $this->input->get();
        } else {
            $this->input_data = json_decode(file_get_contents("php://input"), true);
        }
        
        $this->userData = $this->session->userdata('userData');
		// if(empty($this->userData)){
		// 	redirect(base_url('login'));;
		// }
		cekLogin();
	}

	public function load_layout($data, $view_script_js = "") {
		$tp["page_js"] = $view_script_js;
		$tp["sidebar"] = $this->load->view("include/main_sidebar", "", true);
		$tp["page_header"] = $this->load->view("include/main_page_header_breadcrumb", "", true);
		$tp["page_content"] = $data;
		$tp["footer"] = $this->load->view("include/main_footer", "", true);

		$this->load->view("main_template", $tp);
	}

	public function load_layout_website($data, $view_script_js = "") {
		$tp["page_js"] = $view_script_js;
		$tp["page_header"] = $this->load->view("include-web/main_header", "", true);
		$tp["page_content"] = $data;
		$tp["footer"] = $this->load->view("include-web/main_footer", "", true);
		
		$this->load->view("main_template_website", $tp);
	}

	public function load_layout_test($data, $view_script_js = "") {
		$tp["page_js"] = $view_script_js;
		$tp["sidebar"] = "";
		$tp["page_header"] = "";
		$tp["page_content"] = $data;
		$tp["footer"] = "";

		$this->load->view("main_template_test", $tp);
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

		$config['first_link']       = '<i class="la la-angle-left"></i></a>';
        $config['last_link']        = '<i class="la la-angle-right"></i></a>';
        $config['prev_link']        = '<i class="la la-angle-left"></i></a>';
        $config['next_link']        = '<i class="la la-angle-right"></i></a>';
        $config['full_tag_open']    = '<nav><ul class="pagination pagination-circle">';
        $config['full_tag_close']   = '</ul></nav>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';

		$this->pagination->initialize($config);
		return $this->pagination->create_links();

	

	}
}

?>