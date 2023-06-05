<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VerifikasiCaraPembuatanController extends MY_Controller {

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
		$this->verifikasi_cara_pembuatan_model = new GeneralModel("tb_verifikasi_cara_pembuatan");
		$this->hasil_pemeriksaan_cppob_model = new GeneralModel("tb_hasil_pemeriksaan_cppob");


		$this->userlog = $this->session->userdata('userData');

	}

	public function index()
	{

		$data = [
			'title' => 'Verifikasi Cara Pembuatan',
			'breadcrumb' => breadcrumb('Verifikasi Cara Pembuatan', 'backend/verifikasi-cara-pembuatan')
		];

		$prov = $kota = '';

		if (($this->userlog['id_role'] == '3') || ($this->userlog['id_role'] == '4')) {
			$prov = $this->userlog['id_prov'];
			$kota = $this->userlog['id_kota'];
		}

		if (($this->userlog['id_role'] == '5') || ($this->userlog['id_role'] == '8')) {
			$prov = $this->userlog['id_prov'];
		}

		$limit = isset($this->input_data['limit'])?$this->input_data['limit']:10;
		$page = isset($this->input_data['page'])?(int)$this->input_data['page']:1;
		$start = isset($this->input_data['page'])?(($page-1)*$limit):0;
		$id_prov = isset($this->input_data['id_prov'])?$this->input_data['id_prov']:$prov;
		$id_kota = isset($this->input_data['id_kota'])?$this->input_data['id_kota']:$kota;
		$status = isset($this->input_data['status'])?$this->input_data['status']:"3";
		$q = isset($this->input_data['q'])?$this->input_data['q']:"";

		/*
			STATUS
			0 = Verifikasi Belum Lengkap
			1 = Sudah Diverifikasi
			2 = Verifikasi Belum Memenuhi Komitmen
			3 = Menunggu Verifikasi (default value)
			4 = Pengajuan Pembatalan ke PTSP
			5 = Akun Dibekukan
			6 = Verifikasi Ulang
		*/

		$query = $this->user_model->source();
		$query->select('tb_user.*, tb_verifikasi_cara_pembuatan.status, tb_verifikasi_cara_pembuatan.lokasi_produksi, tb_verifikasi_cara_pembuatan.peralatan_otomatis, tb_verifikasi_cara_pembuatan.status_verifikasi');
		$query->join('tb_pelaku_usaha','tb_user.nib=tb_pelaku_usaha.nib');
		$query->join('tb_verifikasi_cara_pembuatan','tb_user.nib=tb_verifikasi_cara_pembuatan.nib', 'LEFT');
		$query->where('tb_user.id_role',2);
		
		if($q!=""){
			$query->group_start();
				$query->like('tb_user.nib',$q);
			$query->group_end();
		}
		if($id_prov!=""){
			$query->where('tb_user.id_prov',$id_prov);
		}
		if($id_kota!=""){
			$query->where('tb_user.id_kota',$id_kota);
		}
		if($status!=""){
			if($status==0){
				$query->group_start();
					$query->where('tb_verifikasi_cara_pembuatan.status_verifikasi','0');	
					$query->where('tb_user.status_dikembalikan',NULL);
					$query->where('tb_verifikasi_cara_pembuatan.lokasi_produksi !=',0);
					$query->where('tb_verifikasi_cara_pembuatan.peralatan_otomatis',NULL);
				$query->group_end();
			}
			elseif ($status==1) {
				$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);
			}
			elseif($status==2){
				$query->group_start();
					$query->where('tb_verifikasi_cara_pembuatan.status_verifikasi','0');	
					$query->where('tb_user.status_dikembalikan',NULL);
					$query->where('tb_verifikasi_cara_pembuatan.lokasi_produksi !=',0);
					$query->where('tb_verifikasi_cara_pembuatan.peralatan_otomatis !=',1);
				$query->group_end();
			}
			elseif ($status==3) {
				$query->where('tb_user.status_dikembalikan',NULL);
				$query->where('tb_verifikasi_cara_pembuatan.status_verifikasi',NULL);	
				$query->group_start();
					$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);	
					$query->or_where('tb_user.status_verifikasi_cara_pembuatan',NULL);
				$query->group_end();
			}
			elseif($status==4){
				$query->group_start();
					$query->where('tb_user.status_dikembalikan','2');
				$query->group_end();
			}
			elseif($status==5){
				$query->group_start();
					$query->where('tb_user.status_dikembalikan','1');
				$query->group_end();
			}
			elseif($status==6){
				$query->group_start();
					$query->where('tb_user.status_dikembalikan','0');
				$query->group_end();
			}
			else{
				$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);
			}
		}
		$query->order_by('created_at','ASC');
		$total_data = $query->count_all_results();

		$query = $this->user_model->source();
		$query->select('tb_user.*, tb_verifikasi_cara_pembuatan.status, tb_verifikasi_cara_pembuatan.lokasi_produksi, tb_verifikasi_cara_pembuatan.peralatan_otomatis, tb_verifikasi_cara_pembuatan.status_verifikasi');
		$query->join('tb_pelaku_usaha','tb_user.nib=tb_pelaku_usaha.nib');
		$query->join('tb_verifikasi_cara_pembuatan','tb_user.nib=tb_verifikasi_cara_pembuatan.nib', 'LEFT');
		$query->where('tb_user.id_role',2);
		
		if($q!=""){
			$query->group_start();
				$query->like('tb_user.nib',$q);
			$query->group_end();
		}
		if($id_prov!=""){
			$query->where('tb_user.id_prov',$id_prov);
		}
		if($id_kota!=""){
			$query->where('tb_user.id_kota',$id_kota);
		}
		if($status!=""){
			if($status==0){
				$query->group_start();
					$query->where('tb_verifikasi_cara_pembuatan.status_verifikasi','0');	
					$query->where('tb_user.status_dikembalikan',NULL);
					$query->where('tb_verifikasi_cara_pembuatan.lokasi_produksi !=',0);
					$query->where('tb_verifikasi_cara_pembuatan.peralatan_otomatis',NULL);
				$query->group_end();
			}
			elseif ($status==1) {
				$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);
			}
			elseif($status==2){
				$query->group_start();
					$query->where('tb_verifikasi_cara_pembuatan.status_verifikasi','0');	
					$query->where('tb_user.status_dikembalikan',NULL);
					$query->where('tb_verifikasi_cara_pembuatan.lokasi_produksi !=',0);
					$query->where('tb_verifikasi_cara_pembuatan.peralatan_otomatis !=',1);
				$query->group_end();
			}
			elseif ($status==3) {
				$query->where('tb_user.status_dikembalikan',NULL);
				$query->where('tb_verifikasi_cara_pembuatan.status_verifikasi',NULL);
				$query->group_start();
					$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);	
					$query->or_where('tb_user.status_verifikasi_cara_pembuatan',NULL);
				$query->group_end();
			}
			elseif($status==4){
				$query->group_start();	
					$query->where('tb_user.status_dikembalikan','2');
				$query->group_end();
			}
			elseif($status==5){
				$query->group_start();
					$query->where('tb_user.status_dikembalikan','1');
				$query->group_end();
			}
			elseif($status==6){
				$query->group_start();
					$query->where('tb_user.status_dikembalikan','0');
				$query->group_end();
			}
			else{
				$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);
			}
		}
		$query->limit($limit,$start);
		$query->order_by('created_at','ASC');
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

		if(isset($_GET['export']) && $_GET['export']=true){

			$this->load->view('backend/verifikasi_cara_pembuatan/export', $data);

		}else{

			$data['total_data'] = $total_data;
			$data['limit'] = $limit;
			$data['start'] = $start;
			$data['pagination'] = $this->paging_page('backend/verifikasi-cara-pembuatan',$limit,$total_data);
			
			$query = $this->provinsi_model->source();
			$data['provinsi'] = $query->get()->result();

			$this->template->load('template/backend', 'backend/verifikasi_cara_pembuatan/list', $data);
			
		}

	}

	public function approve($id){

		$id = strip_tags($id);
		$id = encrypt_decrypt('decrypt', $id);

		$pambatalan_data = array(
			'status_ptsp_product'=>"1",
		);
		$this->pengajuan_sppirt_model->update($pambatalan_data,$id,'id_pengajuan');

		//// SEND NOTIFICATION ///
		//$data_wa = array(
        //    "phone"=>"",
        //    "msg"=>""
        //);
        //send_wa($data_wa);

		$this->session->set_flashdata("success", "Pembekuan akun berhasil");
		redirect("backend/verifikasi-produk");
	}

	public function cancel($id){

		$id = strip_tags($id);
		$id = encrypt_decrypt('decrypt', $id);

		$pambatalan_data = array(
			'status_ptsp_product'=>null,
		);
		$this->pengajuan_sppirt_model->update($pambatalan_data,$id,'id_pengajuan');

		//// SEND NOTIFICATION ///
		//$data_wa = array(
        //    "phone"=>"",
        //    "msg"=>""
        //);
        //send_wa($data_wa);
        
		$this->session->set_flashdata("success", "Pembekuan akun berhasil ditolak");
		redirect("backend/verifikasi-produk");
	}

	function verifikasi($id){
		
		$id = strip_tags($id);
		$nib = encrypt_decrypt('decrypt', $id);
	
		$this->db->select('tb_verifikasi_cara_pembuatan.*, tb_user.nib as user_nib, tb_user.status_verifikasi_cara_pembuatan, tb_user.status_dikembalikan, tb_user.nik, tb_user.nama, tb_user.nama_pelaku_usaha, tb_user.nama_usaha, tb_user.alamat_usaha, tb_user.no_telp, tb_user.email')
			->join('tb_verifikasi_cara_pembuatan','tb_user.nib = tb_verifikasi_cara_pembuatan.nib', 'LEFT')
			->where('tb_user.nib', $nib)
			->where('tb_user.id_role', 2);
		$verifikasi = $this->db->get('tb_user')->row_array();

		$hasil_pemeriksaan_cppob = array();
		if ($verifikasi['nib'] != NULL) {
			$hasil_pemeriksaan_cppob = $this->hasil_pemeriksaan_cppob_model->list('nib',$verifikasi['nib']);
		}

		$verifikasi['hasil_pemeriksaan_cppob'] = $hasil_pemeriksaan_cppob;

		$data = [
			'title' => 'Verifikasi PIRT',
			'jenis_pangan' => $this->kategori_jenis_pangan_model->list('deleted_at', null),
			'breadcrumb' => breadcrumb('Verifikasi PIRT', 'backend/verifikasi-cara-pembuatan/form-verifikasi-cara-pembuatan'),
			'data' => $verifikasi
		];

		$this->template->load('template/backend', 'backend/verifikasi_cara_pembuatan/form-verifikasi-cara-pembuatan', $data);	

	}

	public function verifikasi_data($nib,$hasil_verifikasi,$type_verifikasi){

		$nib_org = strip_tags($nib);
		$nib = encrypt_decrypt('decrypt', $nib_org);

		$query = $this->verifikasi_cara_pembuatan_model->source();
		$query->where('nib',$nib);
		$verifikasi_cara_pembuatan = $query->get()->row();
		if(isset($verifikasi_cara_pembuatan->id_verifikasi_cara_pembuatan)){

			$monitoring_data = array(
				$type_verifikasi=>$hasil_verifikasi,
			);
			$this->verifikasi_cara_pembuatan_model->update($monitoring_data,$verifikasi_cara_pembuatan->id_verifikasi_cara_pembuatan,'id_verifikasi_cara_pembuatan');

		}else{


			$monitoring_data = array(
				'nib'=>$nib,
				$type_verifikasi=>$hasil_verifikasi,
			);
			$this->verifikasi_cara_pembuatan_model->insert($monitoring_data);
		}

		$user = $this->user_model->find($nib,'nib');
		if(isset($user->no_telp) && $user->no_telp!="" && $user->no_telp!=NULL){

			//// SEND NOTIFICATION ///
			//$data_wa = array(
	        //    "phone"=>$user->no_telp,
	        //    "msg"=>"test"
	        //);
	        //send_wa($data_wa);

		}

		$this->session->set_flashdata("success", "Verifikasi berhasil");
		redirect("backend/verifikasi-cara-pembuatan/verifikasi/".$nib_org);
	}

	function prosesVerifikasi()
	{

		if ($this->input->is_ajax_request()) {
			$nib = encrypt_decrypt("decrypt", $this->input->post('nib'));
			$where = ['nib' => $nib];
			$jenis = $this->input->post('jenis');

			$validate = $this->_validation();

			// $this->session->unset_userdata('file_berita_acara');
			$return = $this->cekForm($this->session->userdata('file_berita_acara'));

			$data = $return[0];
			$table = $return[1];
			$data_hasil_pemeriksaan = $return[2];
			$data_hasil_pemeriksaan['nib'] = $nib;
	        $data_hasil_pemeriksaan["created_at"] = gmdate("Y-m-d H:i:s",time()+60*60*7);

			$cek = $this->db->get_where($table, $where)->row();

			if ($validate) {
				if ($cek) {
					if ($this->session->userdata('file_berita_acara')) {
						$data['berita_acara'] = $this->session->userdata('file_berita_acara');
					}

					if ($data['status'] == '1' && ($this->input->post('status_verifikasi') == '0')) {
						$this->db->insert('tb_hasil_pemeriksaan_cppob', $data_hasil_pemeriksaan);

						//// SEND NOTIFICATION ///
						$data_notification = array(
							'id'=>$nib,
							'type'=>'Verifikasi Cara Pembuatan',
							'status'=>'Tidak Memenuhi Komitmen',
							'msg'=>'Pemenuhan Komitmen',
						);
						send_notification($data_notification);

					}
					$this->db->update($table, $data, $where);
					$this->db->update('tb_user', array('status_verifikasi_cara_pembuatan'=>$this->input->post('status_verifikasi')), $where);
				}else{
					
					$data['nib'] = $nib;
					$this->db->insert($table, $data);

					if ($data['status'] == '1' && ($this->input->post('status_verifikasi') == '0')) {
						$this->db->insert('tb_hasil_pemeriksaan_cppob', $data_hasil_pemeriksaan);

						//// SEND NOTIFICATION ///
						$data_notification = array(
							'id'=>$nib,
							'type'=>'Verifikasi Cara Pembuatan',
							'status'=>'Tidak Memenuhi Komitmen',
							'msg'=>'Pemenuhan Komitmen',
						);
						send_notification($data_notification);

					}

					$this->db->update('tb_user', array('status_verifikasi_cara_pembuatan'=>$this->input->post('status_verifikasi')), $where);
					$this->session->unset_userdata('file_berita_acara');
				}
				if ($this->input->post('status_verifikasi') == "1") {
					$response = [
						'status' => true,
						'alert' => 'Proses verifikasi berhasil <br><b>Telah memenuhi komitmen</b>'
					];

					//// SEND NOTIFICATION ///
					$data_notification = array(
						'id'=>$nib,
						'type'=>'Verifikasi Cara Pembuatan',
						'status'=>'Pemenuhan Komitmen',
						'msg'=>'Pemenuhan Komitmen',
					);
					send_notification($data_notification);
						
				}else{
					$response = [
						'status' => true,
						'data' => $data,
						'table' => $table,
						'cek' => $cek,
						'nib' => $nib,
						'where' => $where,
						'alert' => 'Proses verifikasi berhasil<br> <b><i>Tidak memenuhi komitmen</i></b>'
					];

					if($data['jadwal']!=null){

						//// SEND NOTIFICATION ///
						$data_notification = array(
							'id'=>$nib,
							'type'=>'Verifikasi Cara Pembuatan',
							'status'=>'Penjadwalan Pemeriksaan',
							'msg'=>'Penjadwalan Pemeriksaan',
						);
						send_notification($data_notification);
					}
				}


			}else{
				if ($this->session->userdata('file_berita_acara')) {
					unlink(FCPATH . './uploads/pengawasan/berita_acara/' . $this->session->userdata('file_berita_acara'));
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

	public function pengajuan_pembatalan(){

		$nib_org = strip_tags($this->input_data['nib']);
		$nib = encrypt_decrypt('decrypt', $nib_org);

		$type_verifikasi = $this->input_data['type_verifikasi'];
		$hasil_verifikasi = $this->input_data['hasil_verifikasi'];
		
		$pembatalan_data = array(
			'status_verifikasi_cara_pembuatan'=>"0",
			'alasan_pembatalan_cara_pembuatan'=>$this->input_data['alasan_pembatalan'],
			'status_dikembalikan'=> "2"
		);

		if (!empty($_FILES['rekomendasi_pembatalan']['name'])) {
			$upload_permohonan = $this->cek_permohonan_pembatalan($nib);

			if ($upload_permohonan['status'] == 'true') {
				$pembatalan_data['surat_rekomendasi_pembatalan'] = $upload_permohonan['text'];
			}
			else{
				$this->session->set_flashdata("error", $upload_permohonan['text']);
				redirect("backend/verifikasi-cara-pembuatan/verifikasi/".$nib_org);
			}
		}

		
		$this->user_model->update($pembatalan_data,$nib,'nib');

		$query = $this->verifikasi_cara_pembuatan_model->source();
		$query->where('nib',$nib);
		$verifikasi_cara_pembuatan = $query->get()->row();
		if(isset($verifikasi_cara_pembuatan->id_verifikasi_cara_pembuatan)){

			$monitoring_data = array(
				$type_verifikasi=>$hasil_verifikasi,
			);
			$this->verifikasi_cara_pembuatan_model->update($monitoring_data,$verifikasi_cara_pembuatan->id_verifikasi_cara_pembuatan,'id_verifikasi_cara_pembuatan');

		}else{

			$monitoring_data = array(
				'nib'=>$nib,
				$type_verifikasi=>$hasil_verifikasi,
			);
			$this->verifikasi_cara_pembuatan_model->insert($monitoring_data);
		}

		//// SEND NOTIFICATION ///
		$data_notification = array(
			'id'=>$nib,
			'type'=>'Verifikasi Cara Pembuatan',
			'status'=>'Rekomendasi Pembekuan Akun',
			'msg'=>'Rekomendasi Pembekuan Akun',
		);
		send_notification($data_notification);

		$this->session->set_flashdata("success", "Permohonan Pembekuan Akun berhasil dikirim");
		redirect("backend/verifikasi-cara-pembuatan/verifikasi/".$nib_org);
	}

	public function pemenuhan_komitmen($id){

		$id = strip_tags($id);
		$id = encrypt_decrypt('decrypt', $id);

		$pambatalan_data = array(
			'status_verifikasi_product'=>"1",
		);
		$this->pengajuan_sppirt_model->update($pambatalan_data,$id,'id_pengajuan');

		//// SEND NOTIFICATION ///
		//$data_wa = array(
        //    "phone"=>"",
        //    "msg"=>""
        //);
        //send_wa($data_wa);

		$this->session->set_flashdata("success", "Pemenuhan komitmen berhasil");
		redirect("backend/verifikasi-produk");
	}

	public function cekForm($berita_acara)
	{
		$arrayCheck= [];
		
		$status = $this->input->post('status', true);
		$jadwal = $this->input->post('jadwal', true);
		$jadwal_pemeriksaan = $this->input->post('jadwal_pemeriksaan', true);
		$hasil_pembinaan = $this->input->post('hasil_pembinaan', true);
		$hasil_pemeriksaan = $this->input->post('hasil_pemeriksaan', true);
		$level = $this->input->post('level', true);
		$status_verifikasi = $this->input->post('status_verifikasi', true);

		$table = 'tb_verifikasi_cara_pembuatan';
		$data = [
			'status' => $status,
			'jadwal' => $status == 0 ? $jadwal : null,
			'level' => $status == 1 ? $this->input->post('levelya') : null,
			'hasil_pemeriksaan' => $status == 1 ? $hasil_pemeriksaan : null,
			'hasil_pembinaan' => ($status == 1 && ($this->input->post('levelya') == 'III' || $this->input->post('levelya') == 'IV'))? $hasil_pembinaan : null,
			'status_verifikasi' => $status_verifikasi
		];

		$data_hasil_pemeriksaan = array(
			"hasil_pemeriksaan"	=>	$status == 1 ? $hasil_pemeriksaan : null,
			"level"				=>	$status == 1 ? $this->input->post('levelya') : null,
			"hasil_pembinaan"	=>	($status == 1 && ($this->input->post('levelya') == 'III' || $this->input->post('levelya') == 'IV'))? $hasil_pembinaan : null,
			"jadwal"			=>	$status == 1 ? $jadwal_pemeriksaan : null
		);

		if ($status == "1") {
			$arrayCheck[] = $hasil_pemeriksaan;
			$arrayCheck[] = $this->input->post('levelya');
		}

		if ($status == "0") {
			$arrayCheck[] = $jadwal;
			$arrayCheck[] = $this->input->post('leveltidak');
			$arrayCheck[] = $berita_acara;

		}

		if ($status == null) {
			$arrayCheck[] = $status;
		}


		$cekValue = true;
		foreach ($arrayCheck as $key => $value) {
			if ($value == null) {
				$cekValue = false;
			}
		}
		// if ($cekValue) {
		// 	$data['status_verifikasi'] = '1';
		// }else{
		// 	$data['status_verifikasi'] = '0';
		// }
		return [$data, $table, $data_hasil_pemeriksaan];
	}

	public function cek_upload(){
		$this->load->helper('string');
		$random = random_string('alnum', 4);
		$config = [
			'upload_path' => './uploads/pengawasan/berita_acara',
			'allowed_types' => 'pdf|doc|docx',
			'max_size' => '5000',
			'encrypt_name' => true,
			'file_name' => 'Berita-Acara-' . date('d-m-Y') . '-' . $random,
		];

		$this->load->library('upload', $config);
		$response = true;
		if ($this->input->post('status') == 1) {
			$cek = $this->db->get_where('tb_verifikasi_cara_pembuatan', ['nib' => encrypt_decrypt("decrypt",$this->input->post('nib'))])->row_array();

			if (isset($cek['berita_acara'])) {
				if ($_FILES['berita_acara']['name']) {
					if (!$this->upload->do_upload('berita_acara')) {
						$this->form_validation->set_message(__FUNCTION__, $this->upload->display_errors('',''));
						$response = false;
						// $response = ['berita_acara_error' => $this->upload->display_errors(), 'status' => false];
					} else {
						// $response = ['berita_acara' => $this->upload->data('file_name'), 'status' => true];
						$this->session->set_userdata('file_berita_acara', $this->upload->data('file_name'));
						unlink(FCPATH . './uploads/pengawasan/berita_acara/' . $cek['berita_acara']);
						$response = true;
						// unlink(FCPATH.'./uploads/berita/thumbnail/'.$cek['berita_acara']);
					}
				} else {
					$this->session->set_userdata('file_berita_acara', $cek['berita_acara']);
					$response = true;
					// $response = ['berita_acara' => $cek['berita_acara'], 'status' => true];
				}
			}else{
				if ($_FILES['berita_acara']['name']) {
					if (!$this->upload->do_upload('berita_acara')) {
						$this->form_validation->set_message(__FUNCTION__, $this->upload->display_errors('',''));
						$response = false;
						// $response = ['berita_acara_error' => $this->upload->display_errors(), 'status' => false];
					} else {
						$this->session->set_userdata('file_berita_acara', $this->upload->data('file_name'));
						$response = true;
						// $response = ['berita_acara' => $this->upload->data('file_name'), 'status' => true];
					}
				}else{
					$response = true;
				}
			}
		}
		return $response;
	}

	public function upload_rekomendasi_pembatalan(){
		$nib_org = strip_tags($this->input_data['nib_rekomendasi']);
		$nib = encrypt_decrypt('decrypt', $nib_org);

		if (!empty($_FILES['rekomendasi_pembatalan']['name'])) {
			$upload_permohonan = $this->cek_permohonan_pembatalan($nib);

			if ($upload_permohonan['status'] == 'true') {
				$pembatalan_data['surat_rekomendasi_pembatalan'] = $upload_permohonan['text'];
			}
			else{
				$this->session->set_flashdata("error", $upload_permohonan['text']);
				redirect("backend/verifikasi-cara-pembuatan/verifikasi/".$nib_org);
			}

			$this->user_model->update($pembatalan_data,$nib,'nib');
		}

		$this->session->set_flashdata("success", "Surat rekomendasi pembekuan akun berhasil disimpan");
		redirect("backend/pembatalan-akun/permohonan-pembatalan");
	}

	private function cek_permohonan_pembatalan($nib){
		$this->load->helper('string');
		$random = random_string('alnum', 4);
		$config = [
			'file_name' => 'Surat-Rekomendasi-Pembatalan-' . date('d-m-Y') . '-' . $random,
			'upload_path' => './uploads/pengawasan/surat_rekomendasi_pembatalan',
			'allowed_types' => 'pdf|doc|docx',
			'max_size' => '10000',
			'encrypt_name' => true,
		];

		$this->load->library('upload', $config);

		$response = array();
		$cek = $this->db->get_where('tb_user', ['nib' => $nib])->row_array();

		if (isset($cek['surat_rekomendasi_pembatalan'])) {
			if (!empty($_FILES['rekomendasi_pembatalan']['name'])) {
				if (!$this->upload->do_upload('rekomendasi_pembatalan')) {
					$response = array(
						'status'	=>	'false',
						'text'		=>	'Gagal Upload surat rekomendasi pembekuan akun. Silakan coba beberapa saat lagi.'
					);
				}
				else {
					$response = array(
						'status'	=>	'true',
						'text'		=>	$this->upload->data('file_name')
					);
					unlink(FCPATH . './uploads/pengawasan/surat_rekomendasi_pembatalan/' . $cek['surat_rekomendasi_pembatalan']);
				}
			}
		}
		else{
			if (!empty($_FILES['rekomendasi_pembatalan']['name'])) {
				if (!$this->upload->do_upload('rekomendasi_pembatalan')) {
					$response = array(
						'status'	=>	'false',
						'text'		=>	'Gagal Upload surat rekomendasi pembekuan akun. Silakan coba beberapa saat lagi.'
					);
				}
				else {
					$response = array(
						'status'	=>	'true',
						'text'		=>	$this->upload->data('file_name')
					);
				}
			}
		}

		return $response;
	}

	function _validation()
	{
		$input = $this->input->post();
		$status = $this->input->post('status');
		$this->session->unset_userdata('file_berita_acara');

		$this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required', rules());
		if ($status == 0 && $status != null) {
			// $this->form_validation->set_rules('berita_acara', 'Berita Acara', 'trim|callback_cek_upload');
			$this->form_validation->set_rules('jadwal', 'Jadwal Pemeriksaan Sarana', 'xss_clean|trim|required', rules());
		}else{
			// $this->form_validation->set_rules('berita_acara', 'Berita Acara', 'trim|callback_cek_upload');
			$this->form_validation->set_rules('hasil_pemeriksaan', 'Hasil Pemeriksaan', 'xss_clean|trim', rules());
		}
		
        $this->form_validation->set_error_delimiters('', '');
		return $this->form_validation->run();


	}

	public function getHasilVerifikasi(){
		if ($this->input->is_ajax_request()) {
			$id = strip_tags($this->input_data['nib']);
			$nib = encrypt_decrypt('decrypt', $id);

			$checked_lp_y = $checked_lp_n = $checked_po_y = $checked_po_n = '';
		
			$this->db->select('tb_verifikasi_cara_pembuatan.*, tb_user.nib as user_nib, tb_user.status_verifikasi_cara_pembuatan, tb_user.status_dikembalikan, tb_user.alasan_pembatalan_cara_pembuatan')
				->join('tb_verifikasi_cara_pembuatan','tb_user.nib = tb_verifikasi_cara_pembuatan.nib', 'LEFT')
				->where('tb_user.nib', $nib)
				->where('tb_user.id_role', 2);
			$verifikasi = $this->db->get('tb_user')->row_array();

			// if ($verifikasi['lokasi_produksi'] == '1') {
			// 	$checked_lp_y = 'checked';
			// }
			// if ($verifikasi['lokasi_produksi'] == '0') {
			// 	$checked_lp_n = 'checked';
			// }

			$html = '<h4>Alasan Pengajuan Pembatalan: <strong>'. $verifikasi['alasan_pembatalan_cara_pembuatan'] .'</strong></h4><br>';

			$html .= '<ol>';
			if ($verifikasi['lokasi_produksi'] == '0') {
				$html .= '<li style="color: black;">- Lokasi Produksi Tidak Dirumah.</li>';
			}

			// $html = '<table class="table text-dark" width="100%">
			// 			<tbody>
			// 				<tr>
			// 					<td class="text-left" width="60%">1. Apakah lokasi produksi di rumah tinggal?</td>
			// 					<td class="text-right" width="40%">
			// 						<label class="radio-inline" for="status_1">
			// 							<input type="radio" ' . $checked_lp_y . ' name="lokasi_produksi" id="lokasi_produksi_1" value="1" disabled > Ya
			// 						</label>';

			// $html .=				'<label class="radio-inline" for="status_0">
			// 							<input type="radio" ' . $checked_lp_n . ' name="lokasi_produksi" id="lokasi_produksi_0" value="0" disabled > Tidak
			// 						</label>
			// 					</td>
			// 				</tr>';


			if ($verifikasi['peralatan_otomatis']!="") {
				if ($verifikasi['peralatan_otomatis'] == '1') {
					$html .= '<li style="color: black;">- Menggunakan Peralatan Otomatis.</li>';
					// $checked_po_y = 'checked';
				}
				// if ($verifikasi['peralatan_otomatis'] == '0') {
				// 	$checked_po_n = 'checked';
				// }


				// $html .= '<tr>
				// 			<td class="text-left">2. Apakah menggunakan peralatan otomatis?</td>
				// 			<td class="text-right">
				// 				<label class="radio-inline" for="status_1">
				// 					<input type="radio" ' . $checked_po_y . ' name="peralatan_otomatis" id="peralatan_otomatis_1" value="1" disabled > Ya
				// 				</label>';
				// $html .= 		'<label class="radio-inline" for="status_0">
				// 					<input type="radio" ' . $checked_po_n . ' name="peralatan_otomatis" id="peralatan_otomatis_0" value="0" disabled > Tidak
				// 				</label>
				// 			</td>
				// 		</tr>';
			}
			$html .= '</ol>';

			// $html .='	</tbody>
			// 		</table>';


			$output = [
				'status' => 'success',
				'nib' => $nib,
				'data' => $html,
			];


			echo json_encode($output);
			// var_dump($verifikasi);
			// var_dump($html);
			// die();
		}
		else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

}
