<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller {

	function getKabkota($id_prov)
	{
		if ($this->input->is_ajax_request()) {
			$response = [
				'status' => 200,
				'success' => true,
				'data' => $this->db->get_where('tb_kota', ['id_prov' => $id_prov])->result_array()
			];
			echo json_encode($response);
		}else{
			exit('Access denied');
		}
	}

	function getProvinsi($id_prov = null)
	{
		if ($this->input->is_ajax_request()) {
			if ($id_prov) {
				$provinsi = $this->db->get_where('tb_provinsi', ['id_prov' => $id_prov])->row_array();
			}else{
				$provinsi = $this->db->get('tb_provinsi')->result_array();
			}
			$response = [
				'status' => 200,
				'success' => true,
				'data' => $provinsi
			];
			echo json_encode($response);
		}else{
			exit('Access denied');
		}
	}


	function getJenisPangan($id)
	{
		if ($this->input->is_ajax_request()) {
			$jenis_pangan = $this->db->get_where('tb_jenis_pangan', ['id_kategori_jenis_pangan' => $id])->result_array();
			$response = [
				'status' => 200,
				'success' => true,
				'data' => $jenis_pangan
			];
			echo json_encode($response);
		}else{
			exit('Access denied');
		}
	}



}

/* End of file General.php */
/* Location: ./application/controllers/backend/General.php */