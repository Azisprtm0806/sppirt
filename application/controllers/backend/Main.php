<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
        cekLogin();
		$this->load->model('M_Main');
	}

	public function index()
	{
		redirect('./');
	}

	public function generate_menu()
	{
		$role = $this->session->userdata('role_id');
		$url = $_POST['url'];
		$url2 = $_POST['url'] . '/' . $_POST['url2'];
		// $url = $this->uri->segment(1); 
		$html = '
		<script src="' . base_url() . 'assets/js/admin.js"></script>
		';


		$menu_parent = 0;
		// $menu = $this->db->where('menu_parent', 0)->where('menu_id !=', 11)->get('pmpu_menu')->result_array();
		$menu = $this->M_Main->get_menu($role, 0, 1);

		for ($i = 0; $i < count($menu); $i++) {

			/* BEGIN MENU */
			if ($menu[$i]['menu_url'] == $url) {
				$li_active = 'class="active"';
				if ($menu[$i]['menu_url'] == "" || $menu[$i]['menu_flag_link'] == 0) {
					$span_selected = 'menu-toggle';
					$atr = 'onClick="return false;"';
					$link_menu = 'javascript:;';
				} else {
					$atr = '';
					$link_menu = base_url() . $menu[$i]['menu_url'];
					$span_selected = '';
				}
			} else {
				$li_active = 'class=""';
				if ($menu[$i]['menu_url'] == "dashboard" || $menu[$i]['menu_flag_link'] == 1) {
					$span_selected = '';
					$atr = '';
					$link_menu = base_url() . $menu[$i]['menu_url'];
				} else {
					$span_selected = 'menu-toggle';
					$atr = 'onClick="return false;"';
					$link_menu = 'javascript:;';
				}
			}



			$html .= '
				<li ' . $li_active . '>
	               <a href="' . $link_menu . '" ' . $atr . ' class="' . $span_selected . '">
	               <i class="fa fa-' . $menu[$i]['menu_icon_parent'] . '"></i>
	                  <span>' . $menu[$i]['menu_title'] . '</span> 
	               </a>
				';

			/* BEGIN SUB MENU */
			$submenu = $this->M_Main->get_menu($role, $menu[$i]['menu_id'], 2);
			if (count($submenu) > 0)
				$html .= '<ul class="ml-menu">';

			for ($j = 0; $j < count($submenu); $j++) {
				$sub_submenu = $this->M_Main->get_menu($role, $submenu[$j]['menu_id'], 3);
				if (count($sub_submenu) > 0) {
					$classli = 'class="dropdown-submenu"';
					$class = 'class="menu-toggle"';
					$attr = 'onClick="return false;"';
				} else {
					$classli = '';
					$class = '';
					$attr = '';
				}
				if ($submenu[$j]['menu_flag_link'] == 0) {
					$link = 'javascript:;';
					$html .= '
						  <li>
		                     <a ' . $attr . ' ' . $class . ' href="' . $link . '">
		                     	<span>' . $submenu[$j]['menu_title'] . '</span>
		                     	
		                     </a>
						';
				} else {

					if ($submenu[$j]['menu_url'] == $url2 && $menu[$i]['menu_url'] == $url) {
						$li_active2 = 'class="active"';
					} else {
						$li_active2 = '';
					}
					$link = base_url() . $submenu[$j]['menu_url'];
					$html .= '
							  <li ' . $li_active2 . '>
			                     <a ' . $attr . ' ' . $class . ' href="' . $link . '">
			                     	<span>' . $submenu[$j]['menu_title'] . '</span>
			                     	
			                     </a>
							';
				}

				if (count($sub_submenu) > 0)
					$html .= '<ul class="ml-menu">';

				for ($k = 0; $k < count($sub_submenu); $k++) {
					// $sub_submenu_url = $this->uri->segment(1).$this->uri->segment(2);
					if ($sub_submenu[$k]['menu_url'] == $url2) {
						$li_active3 = 'class="active"';
					} else {
						$li_active3 = '';
					}
					$html .= '
							  <li ' . $li_active3 . '>
								 <a href="' . base_url() . $sub_submenu[$k]['menu_url'] . '">
			                     	<span>' . $sub_submenu[$k]['menu_title'] . '</span>
			                     </a>
			                  </li>
						';
				}

				if (count($sub_submenu) > 0)
					$html .= '</ul>';

				$html .= '
	                  </li>
	                ';
			}

			if (count($submenu) > 0)
				$html .= '</ul>';
			/* END SUB MENU */

			$html .= '</li>';
			/* END MENU */
		}

		echo ($html);
	}

	public function generate_menu_umkm()
	{
		$role = $this->session->userdata('role_id');
		$url2 = $this->input->post('url') . '/' . $this->input->post('url2');
		$url = $this->uri->segment(1);
		$html = '
		<script src="' . base_url() . 'assets/js/admin.js"></script>
		';


		$menu_parent = 0;
		// $menu = $this->M_Main->get_menu(0,1);
		$menu = $this->db->order_by('position', 'asc')->get_where('pmpu_menu', ['menu_parent' => 11])->result_array();

		for ($i = 0; $i < count($menu); $i++) {

			/* BEGIN MENU */
			if ($menu[$i]['menu_url'] == $url2) {
				$li_active = 'class="active"';
				if ($menu[$i]['menu_url'] == "" || $menu[$i]['menu_flag_link'] == 0) {
					$span_selected = 'menu-toggle';
					$atr = 'onClick="return false;"';
					$link_menu = 'javascript:;';
				} else {
					$atr = '';
					$link_menu = base_url() . $menu[$i]['menu_url'];
					$span_selected = '';
				}
			} else {
				$li_active = 'class=""';
				if ($menu[$i]['menu_url'] == "dashboard" || $menu[$i]['menu_flag_link'] == 1) {
					$span_selected = '';
					$atr = '';
					$link_menu = base_url() . $menu[$i]['menu_url'];
				} else {
					$span_selected = 'menu-toggle';
					$atr = 'onClick="return false;"';
					$link_menu = 'javascript:;';
				}
			}

			$html .= '
				<li ' . $li_active . '>
	               <a href="' . $link_menu . '" ' . $atr . ' class="' . $span_selected . '">
	               <i class="fa fa-' . $menu[$i]['menu_icon_parent'] . '"></i>
	                  <span>' . $menu[$i]['menu_title'] . '</span> 
	               </a>
				';

			/* BEGIN SUB MENU */
			$submenu = $this->M_Main->get_menu($role, $menu[$i]['menu_id'], 2);
			if (count($submenu) > 0)
				$html .= '<ul class="ml-menu">';

			for ($j = 0; $j < count($submenu); $j++) {
				$sub_submenu = $this->M_Main->get_menu($role, $submenu[$j]['menu_id'], 3);
				if (count($sub_submenu) > 0) {
					$classli = 'class="dropdown-submenu"';
					$class = 'class="menu-toggle"';
					$attr = 'onClick="return false;"';
				} else {
					$classli = '';
					$class = '';
					$attr = '';
				}
				if ($submenu[$j]['menu_flag_link'] == 0) {
					$link = 'javascript:;';
					$html .= '
						  <li>
		                     <a ' . $attr . ' ' . $class . ' href="' . $link . '">
		                     	<span>' . $submenu[$j]['menu_title'] . '</span>
		                     	
		                     </a>
						';
				} else {
					if ($submenu[$j]['menu_url'] == $url2) {
						$li_active2 = 'class="active"';
					} else {
						$li_active2 = '';
					}
					$link = base_url() . $submenu[$j]['menu_url'];
					$html .= '
							  <li ' . $li_active2 . '>
			                     <a ' . $attr . ' ' . $class . ' href="' . $link . '">
			                     	<span>' . $submenu[$j]['menu_title'] . '</span>
			                     	
			                     </a>
							';
				}

				if (count($sub_submenu) > 0)
					$html .= '<ul class="ml-menu">';

				for ($k = 0; $k < count($sub_submenu); $k++) {
					// $sub_submenu_url = $this->uri->segment(1).$this->uri->segment(2);
					if ($sub_submenu[$k]['menu_url'] == $url2) {
						$li_active3 = 'class="active"';
					} else {
						$li_active3 = '';
					}
					$html .= '
							  <li ' . $li_active3 . '>
								 <a href="' . base_url() . $sub_submenu[$k]['menu_url'] . '">
			                     	<span>' . $sub_submenu[$k]['menu_title'] . '</span>
			                     </a>
			                  </li>
						';
				}

				if (count($sub_submenu) > 0)
					$html .= '</ul>';

				$html .= '
	                  </li>
	                ';
			}

			if (count($submenu) > 0)
				$html .= '</ul>';
			/* END SUB MENU */

			$html .= '</li>';
			/* END MENU */
		}

		echo ($html);
	}

	public function generate_menu_sdm()
	{
		$role = $this->session->userdata('role_id');
		$url2 = $this->input->post('url') . '/' . $this->input->post('url2');
		$url = $this->uri->segment(1);
		$html = '
		<script src="' . base_url() . 'assets/js/admin.js"></script>
		';


		$menu_parent = 0;
		$menu = $this->M_Main->get_menu($role, 84, 1);

		for ($i = 0; $i < count($menu); $i++) {

			/* BEGIN MENU */
			if ($menu[$i]['menu_url'] == $url2) {
				$li_active = 'class="active"';
				if ($menu[$i]['menu_url'] == "" || $menu[$i]['menu_flag_link'] == 0) {
					$span_selected = 'menu-toggle';
					$atr = 'onClick="return false;"';
					$link_menu = 'javascript:;';
				} else {
					$atr = '';
					$link_menu = base_url() . $menu[$i]['menu_url'];
					$span_selected = '';
				}
			} else {
				$li_active = 'class=""';
				if ($menu[$i]['menu_url'] == "dashboard" || $menu[$i]['menu_flag_link'] == 1) {
					$span_selected = '';
					$atr = '';
					$link_menu = base_url() . $menu[$i]['menu_url'];
				} else {
					$span_selected = 'menu-toggle';
					$atr = 'onClick="return false;"';
					$link_menu = 'javascript:;';
				}
			}

			$html .= '
				<li ' . $li_active . '>
	               <a href="' . $link_menu . '" ' . $atr . ' class="' . $span_selected . '">
	               <i class="fa fa-' . $menu[$i]['menu_icon_parent'] . '"></i>
	                  <span>' . $menu[$i]['menu_title'] . '</span> 
	               </a>
				';

			/* BEGIN SUB MENU */
			$submenu = $this->M_Main->get_menu($role, $menu[$i]['menu_id'], 2);
			if (count($submenu) > 0)
				$html .= '<ul class="ml-menu">';

			for ($j = 0; $j < count($submenu); $j++) {
				$sub_submenu = $this->M_Main->get_menu($role, $submenu[$j]['menu_id'], 3);
				if (count($sub_submenu) > 0) {
					$classli = 'class="dropdown-submenu"';
					$class = 'class="menu-toggle"';
					$attr = 'onClick="return false;"';
				} else {
					$classli = '';
					$class = '';
					$attr = '';
				}
				if ($submenu[$j]['menu_flag_link'] == 0) {
					$link = 'javascript:;';
					$html .= '
						  <li>
		                     <a ' . $attr . ' ' . $class . ' href="' . $link . '">
		                     	<span>' . $submenu[$j]['menu_title'] . '</span>
		                     	
		                     </a>
						';
				} else {
					if ($submenu[$j]['menu_url'] == $url2) {
						$li_active2 = 'class="active"';
					} else {
						$li_active2 = '';
					}
					$link = base_url() . $submenu[$j]['menu_url'];
					$html .= '
							  <li ' . $li_active2 . '>
			                     <a ' . $attr . ' ' . $class . ' href="' . $link . '">
			                     	<span>' . $submenu[$j]['menu_title'] . '</span>
			                     	
			                     </a>
							';
				}

				if (count($sub_submenu) > 0)
					$html .= '<ul class="ml-menu">';

				for ($k = 0; $k < count($sub_submenu); $k++) {
					// $sub_submenu_url = $this->uri->segment(1).$this->uri->segment(2);
					if ($sub_submenu[$k]['menu_url'] == $url2) {
						$li_active3 = 'class="active"';
					} else {
						$li_active3 = '';
					}
					$html .= '
							  <li ' . $li_active3 . '>
								 <a href="' . base_url() . $sub_submenu[$k]['menu_url'] . '">
			                     	<span>' . $sub_submenu[$k]['menu_title'] . '</span>
			                     </a>
			                  </li>
						';
				}

				if (count($sub_submenu) > 0)
					$html .= '</ul>';

				$html .= '
	                  </li>
	                ';
			}

			if (count($submenu) > 0)
				$html .= '</ul>';
			/* END SUB MENU */

			$html .= '</li>';
			/* END MENU */
		}

		echo ($html);
	}
}
