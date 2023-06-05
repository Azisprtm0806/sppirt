<?php 

	function cekLogin()
	{
		$CI=get_instance();
		if (empty($CI->session->userdata('userData'))) {
			redirect(base_url('login'));
		}else{
			$role = $CI->session->userdata('userData')['id_role'];

			$segs = $CI->uri->segment_array();
			$totalSegs = count($segs);
			$link = '';
			for ($i = 2; $i <= $totalSegs; $i++) {
			    if ($segs[$i] === $segs[$totalSegs]) {
			        $link .= $segs[$i];
			    } else {
			        $link .= $segs[$i] . "/";
			    }
			}



			$menu = $CI->db->get_where('tb_menu', ['menu_url' => $link, 'tipe' => 'backend'])->row();
			if ($menu) {
				$akses = $CI->db->get_where('tb_akses_menu', ['id_role' => $role, 'id_menu' => $menu->id_menu]);
				// var_dump($akses->num_rows());die;
				if ($akses->num_rows() < 1) {
					redirect('backend/403');
				}
			}
		}
	}

 ?>