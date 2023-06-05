<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard_Model');
		cekLogin();
	}

	public function index()
	{
		$data = [
			'title' => 'Dashboard',
			'breadcrumb' => breadcrumb('Dashboard', 'backend/dashboard'),
			'total_pengajuan' => $this->Dashboard_Model->get_pengajuan(),
			'total_terbit' => $this->Dashboard_Model->get_terbit(),
			'total_ditangguhkan' => $this->Dashboard_Model->get_ditangguhkan(),
			'total_ditolak' => $this->Dashboard_Model->get_ditolak(),
			'total_dibatalkan' => $this->Dashboard_Model->get_dibatalkan(),
			'notifications' => $this->Dashboard_Model->get_notifications()
		];
		$this->template->load('template/backend.php', 'backend/home', $data);
	}

	public function read_notifications()
	{
		$cb = '';

		if (!empty($this->input->post('cb'))) {
			$cb = encrypt_decrypt("decrypt", $this->input->post('cb'));
		}
		$update = $this->Dashboard_Model->update_notification($this->input->post('type'), $this->input->post('ids'));

		$response = array(
			'status'	=>	true,
			'text'		=>	"Berhasil menandai notifikasi telah dibaca!",
			'callback'	=>	$cb
		);
		echo json_encode($response);
	}
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/backend/Dashboard.php */