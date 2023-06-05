<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends CI_Controller {

	public function error403()
	{
		$data = [
			'title' => 'Access Denied',
			'breadcrumb' => breadcrumb('Access Denied', 'backend/Dashboard')
		];
		$this->template->load('template/backend', 'errors/403', $data);
	}

	public function error404()
	{
		$tipe = $this->uri->segment(1) == 'backend' ? 'backend' : 'frontend' ;
		if ($tipe == 'backend') {
			cekLogin();
		}
		$data = [
			'title' => 'Halaman Tidak Ditemukan',
			'breadcrumb' => breadcrumb('Halaman Tidak Ditemukan', 'backend/Dashboard')
		];
		$this->template->load('template/'.$tipe, 'errors/'.$tipe.'404', $data);
	}

}

/* End of file Error.php */
/* Location: ./application/controllers/Error.php */