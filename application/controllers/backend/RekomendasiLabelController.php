<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RekomendasiLabelController extends MY_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->library('image_lib');

		$this->user_model = new GeneralModel("tb_user");
		$this->role_model = new GeneralModel("tb_role");
		$this->provinsi_model = new GeneralModel("tb_provinsi");
		$this->kab_kota_model = new GeneralModel("tb_kota");
		$this->pengajuan_sppirt_model = new GeneralModel("tb_pengajuan_sppirt");
		$this->kategori_jenis_pangan_model = new GeneralModel("tb_kategori_jenis_pangan");
		$this->jenis_pangan_model = new GeneralModel("tb_jenis_pangan");
		$this->jenis_kemasan_model = new GeneralModel("tb_jenis_kemasan");
		$this->analisis_product_model = new GeneralModel("tb_analisis_product");
		$this->monitoring_product_model = new GeneralModel("tb_monitoring_product");
		$this->input_data_produk_model = new GeneralModel("tb_input_data_produk");


		$this->userlog = $this->session->userdata('userData');

	}

	public function index()
	{

		$data = [
			'title' => 'Rekomendasi Label',
			'breadcrumb' => breadcrumb('Rekomendasi Label', 'backend/rekomendasi-label')
		];

		$limit = isset($this->input_data['limit'])?$this->input_data['limit']:10;
		$page = isset($this->input_data['page'])?$this->input_data['page']:1;
		$start = isset($this->input_data['page'])?(($page-1)*$limit):0;
		$id_prov = isset($this->input_data['id_prov'])?$this->input_data['id_prov']:"";
		$id_kota = isset($this->input_data['id_kota'])?$this->input_data['id_kota']:"";
		$status = isset($this->input_data['status'])?$this->input_data['status']:"0";
		$q = isset($this->input_data['q'])?$this->input_data['q']:"";

		$query = $this->pengajuan_sppirt_model->source();
		$query->select('tb_pengajuan_sppirt.id_pengajuan, tb_pengajuan_sppirt.status_verifikasi_label, tb_pengajuan_sppirt.status_verifikasi_label, no_sppirt, nama_jenis_pangan, nama_produk_pangan,nama_kemasan, id_izin,tb_pengajuan_sppirt.created_at as tgl_pengajuan, status_pengajuan, tb_kategori_jenis_pangan.*, no_sppirt_lama, status_no_sppirt, status_sinkronisasi, id_kota, id_prov, tb_user.nib');
		$query->join('tb_input_data_produk','tb_input_data_produk.id_pengajuan=tb_pengajuan_sppirt.id_pengajuan');
		$query->join('tb_jenis_pangan','tb_jenis_pangan.id_jenis_pangan=tb_input_data_produk.id_jenis_pangan');
		$query->join('tb_kategori_jenis_pangan','tb_kategori_jenis_pangan.id_kategori_jenis_pangan=tb_jenis_pangan.id_kategori_jenis_pangan');
		$query->join('tb_jenis_kemasan','tb_jenis_kemasan.id_jenis_kemasan=tb_input_data_produk.id_jenis_kemasan');
		$query->join('tb_user','tb_user.id_user=tb_pengajuan_sppirt.id_user');
		if($q!=""){
			$query->group_start();
				$query->like('tb_pengajuan_sppirt.nib',$q);
				$query->or_like('tb_pengajuan_sppirt.no_sppirt',$q);
			$query->group_end();
		}
		// $query->where('tb_pengajuan_sppirt.status_verifikasi_label','0');
		$query->where('tb_pengajuan_sppirt.nib',$this->userlog['nib']);
		// if($id_prov!=""){
		// 	$query->where('tb_user.id_prov',$id_prov);
		// }
		// if($id_kota!=""){
		// 	$query->where('tb_user.id_kota',$id_kota);
		// }
		if($status!=""){
			if($status==3){
				$query->group_start();
					$query->where('tb_pengajuan_sppirt.status_verifikasi_label',$status);	
					$query->or_where('tb_pengajuan_sppirt.status_verifikasi_label',NULL);
				$query->group_end();
			}else{
				$query->where('tb_pengajuan_sppirt.status_verifikasi_label',$status);
			}
		}
		// $query->where('status_ptsp_product',NULL);
		$total_data = $query->count_all_results();

		$query = $this->pengajuan_sppirt_model->source();
		$query->select('tb_pengajuan_sppirt.id_pengajuan, tb_pengajuan_sppirt.status_verifikasi_label, tb_pengajuan_sppirt.status_verifikasi_label, no_sppirt, nama_jenis_pangan, nama_produk_pangan,nama_kemasan, id_izin,tb_pengajuan_sppirt.created_at as tgl_pengajuan, status_pengajuan, tb_kategori_jenis_pangan.*, no_sppirt_lama, status_no_sppirt, status_sinkronisasi, id_kota, id_prov, tb_user.nib');
		$query->join('tb_input_data_produk','tb_input_data_produk.id_pengajuan=tb_pengajuan_sppirt.id_pengajuan');
		$query->join('tb_jenis_pangan','tb_jenis_pangan.id_jenis_pangan=tb_input_data_produk.id_jenis_pangan');
		$query->join('tb_kategori_jenis_pangan','tb_kategori_jenis_pangan.id_kategori_jenis_pangan=tb_jenis_pangan.id_kategori_jenis_pangan');
		$query->join('tb_jenis_kemasan','tb_jenis_kemasan.id_jenis_kemasan=tb_input_data_produk.id_jenis_kemasan');
		$query->join('tb_user','tb_user.id_user=tb_pengajuan_sppirt.id_user');
		if($q!=""){
			$query->group_start();
				$query->like('tb_pengajuan_sppirt.nib',$q);
				$query->or_like('tb_pengajuan_sppirt.no_sppirt',$q);
			$query->group_end();
		}
		// $query->where('tb_pengajuan_sppirt.status_verifikasi_label','0');
		$query->where('tb_pengajuan_sppirt.nib',$this->userlog['nib']);
		// if($id_prov!=""){
		// 	$query->where('tb_user.id_prov',$id_prov);
		// }
		// if($id_kota!=""){
		// 	$query->where('tb_user.id_kota',$id_kota);
		// }
		if($status!=""){
			if($status==3){
				$query->group_start();
					$query->where('tb_pengajuan_sppirt.status_verifikasi_label',$status);	
					$query->or_where('tb_pengajuan_sppirt.status_verifikasi_label',NULL);
				$query->group_end();
			}else{
				$query->where('tb_pengajuan_sppirt.status_verifikasi_label',$status);
			}
		}
		// $query->where('status_ptsp_product',NULL);
		$query->limit($limit,$start);
		$query->order_by('created_at','DESC');
		$verifikasi_produk = $query->get()->result();
		$datas = array();
		foreach ($verifikasi_produk as $key => $value) {

			$provinsi = $this->provinsi_model->find($value->id_prov,'id_prov');
			$value->nama_prov = isset($provinsi->nama_prov)?$provinsi->nama_prov:'';

			$kab_kota = $this->kab_kota_model->find($value->id_kota,'id_kota');
			$value->nama_kabkot = isset($kab_kota->nama_kota)?$kab_kota->nama_kota:'';

			$datas[] = $value;
		}
		$data['datas'] = $datas;

		$data['total_data'] = $total_data;
		$data['limit'] = $limit;
		$data['start'] = $start;
		$data['pagination'] = $this->paging_page('backend/rekomendasi-label',$limit,$total_data);
		
		$query = $this->provinsi_model->source();
		$data['provinsi'] = $query->get()->result();

		$this->template->load('template/backend', 'backend/rekomendasi_label/list', $data);

	}

	public function verifikasi($id){
		
		$id = strip_tags($id);
		$id_pengajuan = encrypt_decrypt('decrypt', $id);
	
		$this->db->select('tb_pengajuan_sppirt.no_sppirt, nama_produk_pangan,nib,tb_input_label_produk.*, tb_kategori_jenis_pangan.*,tb_jenis_pangan.*,tb_input_data_produk.*,tb_pengajuan_sppirt.id_pengajuan as id, tb_pengajuan_sppirt.status_verifikasi_label, upload_rancangan,tb_verifikasi_label.*, tb_pengajuan_sppirt.alasan_pengembalian')
			->join('tb_verifikasi_label','tb_pengajuan_sppirt.id_pengajuan = tb_verifikasi_label.id_pengajuan', 'LEFT')
			->join('tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
			->join('tb_input_label_produk', 'tb_input_label_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
			->join('tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan')
			->join('tb_kategori_jenis_pangan', 'tb_jenis_pangan.id_kategori_jenis_pangan = tb_kategori_jenis_pangan.id_kategori_jenis_pangan')
			->where('tb_pengajuan_sppirt.id_pengajuan', $id_pengajuan);
		$verifikasi = $this->db->get('tb_pengajuan_sppirt')->row_array();

		$data = [
			'title' => 'Rekomendasi Label',
			'jenis_pangan' => $this->kategori_jenis_pangan_model->list('deleted_at', null),
			'breadcrumb' => breadcrumb('Rekomendasi Label', 'backend/rekomendasi-label/verifikasi/'.$id),
			'data' => $verifikasi
		];


		$analisis_product_arr = array();
		$query = $this->analisis_product_model->source();
		$analisis_product = $query->get()->result();
		$last_verifikasi = 1;
		$hasil_verifikasi = "";

		foreach ($analisis_product as $key => $value) {

			$query = $this->monitoring_product_model->source();
			$query->where('id_pengajuan',$id_pengajuan);
			$query->where('id_analisis_product',$value->id);
			$monitoring_product = $query->get()->row();
			$value->hasil_verifikasi = isset($monitoring_product->hasil_verifikasi)?$monitoring_product->hasil_verifikasi:NULL;
			$value->is_next = isset($monitoring_product->is_next)?$monitoring_product->is_next:NULL;

			$value->is_disabled = 1;
			$value->is_show = 0;
			if($value->hasil_verifikasi==NULL && $last_verifikasi==$value->step && ($value->condition==NULL || $value->condition==$hasil_verifikasi) ){
				$value->is_disabled = 0;
				$value->is_show = 1;
			}else if($value->hasil_verifikasi!=NULL && $value->is_next==1 && ($value->condition==NULL || $value->condition==$hasil_verifikasi)){
				$last_verifikasi++;
				$value->is_show = 1;
			}else if($value->hasil_verifikasi!=NULL && $value->is_next==0 && ($value->condition==NULL || $value->condition==$hasil_verifikasi)){
				$value->is_show = 1;
			}else if($value->hasil_verifikasi==NULL && $last_verifikasi==$value->step){
				$last_verifikasi++;
			}

			$hasil_verifikasi = $value->hasil_verifikasi;
			$analisis_product_arr[] = $value;

		}

		$data['analisis_product'] = $analisis_product_arr;
		$data['last_verifikasi'] = $last_verifikasi;

		$query = $this->kategori_jenis_pangan_model->source();
		$data['kategori_jenis_pangan'] = $query->get()->result();

		$query = $this->jenis_pangan_model->source();
		$query->where('id_kategori_jenis_pangan',$verifikasi['id_kategori_jenis_pangan']);
		$data['jenis_pangan'] = $query->get()->result();

		$query = $this->jenis_kemasan_model->source();
		$data['jenis_kemasan'] = $query->get()->result();

		
		$this->template->load('template/backend', 'backend/rekomendasi_label/form-verifikasi-label', $data);	

	}

	public function prosesVerifikasi()
	{

		if ($this->input->is_ajax_request()) {

			$id_pengajuan = encrypt_decrypt("decrypt", $this->input->post('id_pengajuan'));
			$where = ['id_pengajuan' => $id_pengajuan];

			$validate = $this->_validation();

			if ($validate) {
				$this->db->update('tb_pengajuan_sppirt', array('status_verifikasi_label'=>$this->input->post('status_verifikasi')), $where);

				if ($this->session->userdata('file_rekomendasi_label')) {
					$this->db->update('tb_input_label_produk', array('upload_rancangan'=>$this->session->userdata('file_rekomendasi_label')), $where);
				}
				
				$response = [
					'status' => true,
					'alert' => 'Perbaikan label berhsil diunggah'
				];

				//// SEND NOTIFICATION ///
				$data_notification = array(
					'id'=>$id_pengajuan,
					'type'=>'Verifikasi Label',
					'status'=>'Telah dilakukan perbaikan',
					'msg'=>'Telah dilakukan perbaikan',
				);
				send_notification($data_notification);

			}else{
				if ($this->session->userdata('file_rekomendasi_label')) {
					unlink(FCPATH . './uploads/labelproduk/' . $this->session->userdata('file_rekomendasi_label'));
				}
				$response = [
					'errors' => getErrorValidation(),
					'status' => false,
					'alert' => 'Status verifikasi Masih ada yang belum dipilih'
				];
			}
			echo json_encode($response);

		}else{
			$data = [
				'title' => 'Access Denied',
				'breadcrumb' => breadcrumb('Access Denied', 'backend/Dashboard')
			];
			$this->template->load('template/backend', 'errors/403', $data);
		}


	}

	function uploadLabel(){
		$this->load->helper('string');
		$random = random_string('alnum', 4);
		$config = [
			'upload_path' => './uploads/labelproduk/',
			'allowed_types' => 'jpg|jpeg|png',
			'max_size' => '5000',
			'encrypt_name' => true,
			'file_name' => 'Label-' . date('d-m-Y') . '-' . $random,
		];

		$id_pengajuan = encrypt_decrypt("decrypt", $this->input->post('id_pengajuan'));

		$this->load->library('upload', $config);
		$response = true;
		// if ($this->input->post('status_verifikasi') == 0) {
			$cek = $this->db->get_where('tb_input_label_produk', ['id_pengajuan' => $id_pengajuan])->row_array();

			if (isset($cek['upload_rancangan'])) {
				if ($_FILES['rekomendasi_label']['name']) {
					if (!$this->upload->do_upload('rekomendasi_label')) {
						$this->form_validation->set_message(__FUNCTION__, $this->upload->display_errors('',''));
						$response = false;
						// $response = ['rekomendasi_label_error' => $this->upload->display_errors(), 'status' => false];
					} else {
						// $response = ['rekomendasi_label' => $this->upload->data('file_name'), 'status' => true];
						$this->session->set_userdata('file_rekomendasi_label', $this->upload->data('file_name'));
						if (file_exists(FCPATH . './uploads/labelproduk/' . $cek['upload_rancangan'])){
							unlink(FCPATH . './uploads/labelproduk/' . $cek['upload_rancangan']);
					        // mkdir($path.'/temp', 0777, true);
					    }
						$response = true;
						// unlink(FCPATH.'./uploads/berita/thumbnail/'.$cek['rekomendasi_label']);
					}
				} else {
					$this->session->set_userdata('file_rekomendasi_label', $cek['upload_rancangan']);
					$response = true;
					// $response = ['rekomendasi_label' => $cek['rekomendasi_label'], 'status' => true];
				}
			}else{
				if ($_FILES['rekomendasi_label']['name']) {
					if (!$this->upload->do_upload('rekomendasi_label')) {
						$this->form_validation->set_message(__FUNCTION__, $this->upload->display_errors('',''));
						$response = false;
						// $response = ['rekomendasi_label_error' => $this->upload->display_errors(), 'status' => false];
					} else {
						$this->session->set_userdata('file_rekomendasi_label', $this->upload->data('file_name'));
						$response = true;
						// $response = ['rekomendasi_label' => $this->upload->data('file_name'), 'status' => true];
					}
				}else{
					$response = true;
				}
			}
		// }
		return $response;
	}

	function _validation()
	{
		$input = $this->input->post();

		if(isset($_FILES['rekomendasi_label']['size']) && $_FILES['rekomendasi_label']['size'] != 0) $this->form_validation->set_rules('rekomendasi_label', 'Rekomendasi Label', 'trim|callback_uploadLabel', rules());

        $this->form_validation->set_error_delimiters('', '');
		return $this->form_validation->run();
	}


}
