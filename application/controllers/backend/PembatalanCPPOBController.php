<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PembatalanCPPOBController extends MY_Controller {

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

		// print_r($this->userlog);
		// die();


	}

	public function index(){

		$data = [
			'title' => 'Permohonan Pembekuan Akun',
			'breadcrumb' => breadcrumb('Permohonan Pembekuan Akun', 'backend/pembatalan-akun/permohonan-pembatalan')
		];

		$limit = isset($this->input_data['limit'])?$this->input_data['limit']:10;
		$page = isset($this->input_data['page'])?$this->input_data['page']:1;
		$start = isset($this->input_data['page'])?(($page-1)*$limit):0;
		$id_prov = isset($this->input_data['id_prov'])?$this->input_data['id_prov']:"";
		$id_kota = isset($this->input_data['id_kota'])?$this->input_data['id_kota']:"";
		$status = isset($this->input_data['status'])?$this->input_data['status']:"";
		$q = isset($this->input_data['q'])?$this->input_data['q']:"";

		$query = $this->user_model->source();
		$query->select('tb_user.*');
		$query->join('tb_pelaku_usaha','tb_user.nib=tb_pelaku_usaha.nib');
		$query->where('tb_user.id_role',2);
		$query->where('tb_user.status_dikembalikan','2');
		
		if($q!=""){
			$query->group_start();
				$query->like('tb_user.nib',$q);
			$query->group_end();
		}
		if(!empty($this->userlog['id_prov'])){
			$query->where('tb_user.id_prov',$this->userlog['id_prov']);
		}
		if(!empty($this->userlog['id_kota'])){
			$query->where('tb_user.id_kota',$this->userlog['id_kota']);
		}
		if($status!=""){
			if($status==3){
				$query->group_start();
					$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);	
					$query->or_where('tb_user.status_verifikasi_cara_pembuatan',NULL);
				$query->group_end();
			}else{
				$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);
			}
		}
		$query->order_by('created_at','DESC');
		$total_data = $query->count_all_results();

		$query = $this->user_model->source();
		$query->select('tb_user.*');
		$query->join('tb_pelaku_usaha','tb_user.nib=tb_pelaku_usaha.nib');
		$query->where('tb_user.id_role',2);
		$query->where('tb_user.status_dikembalikan','2');
		
		if($q!=""){
			$query->group_start();
				$query->like('tb_user.nib',$q);
			$query->group_end();
		}
		if(!empty($this->userlog['id_prov'])){
			$query->where('tb_user.id_prov',$this->userlog['id_prov']);
		}
		if(!empty($this->userlog['id_kota'])){
			$query->where('tb_user.id_kota',$this->userlog['id_kota']);
		}
		if($status!=""){
			if($status==3){
				$query->group_start();
					$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);	
					$query->or_where('tb_user.status_verifikasi_cara_pembuatan',NULL);
				$query->group_end();
			}else{
				$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);
			}
		}
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
		$data['pagination'] = $this->paging_page('backend/pembatalan-akun/permohonan-pembatalan',$limit,$total_data);

		$this->template->load('template/backend', 'backend/pembatalan_cppob/list', $data);
	}

	public function pembatalan_disetujui(){
		$data = [
			'title' => 'Pembekuan Akun Disetujui',
			'breadcrumb' => breadcrumb('Pembekuan Akun Disetujui', 'backend/pembatalan-akun/pembatalan-disetujui')
		];

		$limit = isset($this->input_data['limit'])?$this->input_data['limit']:10;
		$page = isset($this->input_data['page'])?$this->input_data['page']:1;
		$start = isset($this->input_data['page'])?(($page-1)*$limit):0;
		$id_prov = isset($this->input_data['id_prov'])?$this->input_data['id_prov']:"";
		$id_kota = isset($this->input_data['id_kota'])?$this->input_data['id_kota']:"";
		$status = isset($this->input_data['status'])?$this->input_data['status']:"";
		$q = isset($this->input_data['q'])?$this->input_data['q']:"";

		$query = $this->user_model->source();
		$query->select('tb_user.*');
		$query->join('tb_pelaku_usaha','tb_user.nib=tb_pelaku_usaha.nib');
		$query->where('tb_user.id_role',2);
		$query->where('tb_user.status_dikembalikan','1');
		
		if($q!=""){
			$query->group_start();
				$query->like('tb_user.nib',$q);
			$query->group_end();
		}
		if(!empty($this->userlog['id_prov'])){
			$query->where('tb_user.id_prov',$this->userlog['id_prov']);
		}
		if(!empty($this->userlog['id_kota'])){
			$query->where('tb_user.id_kota',$this->userlog['id_kota']);
		}
		if($status!=""){
			if($status==3){
				$query->group_start();
					$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);	
					$query->or_where('tb_user.status_verifikasi_cara_pembuatan',NULL);
				$query->group_end();
			}else{
				$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);
			}
		}
		$query->order_by('created_at','DESC');
		$total_data = $query->count_all_results();

		$query = $this->user_model->source();
		$query->select('tb_user.*');
		$query->join('tb_pelaku_usaha','tb_user.nib=tb_pelaku_usaha.nib');
		$query->where('tb_user.id_role',2);
		$query->where('tb_user.status_dikembalikan','1');
		
		if($q!=""){
			$query->group_start();
				$query->like('tb_user.nib',$q);
			$query->group_end();
		}
		if(!empty($this->userlog['id_prov'])){
			$query->where('tb_user.id_prov',$this->userlog['id_prov']);
		}
		if(!empty($this->userlog['id_kota'])){
			$query->where('tb_user.id_kota',$this->userlog['id_kota']);
		}
		if($status!=""){
			if($status==3){
				$query->group_start();
					$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);	
					$query->or_where('tb_user.status_verifikasi_cara_pembuatan',NULL);
				$query->group_end();
			}else{
				$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);
			}
		}
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
		$data['pagination'] = $this->paging_page('backend/pembatalan-akun/pembatalan-disetujui',$limit,$total_data);

		$this->template->load('template/backend', 'backend/pembatalan_cppob/list', $data);
	}

	public function pembatalan_ditolak(){
		$data = [
			'title' => 'Pembekuan Akun Ditolak',
			'breadcrumb' => breadcrumb('Pembekuan Akun Ditolak', 'backend/pembatalan-akun/pembatalan-ditolak')
		];

		$limit = isset($this->input_data['limit'])?$this->input_data['limit']:10;
		$page = isset($this->input_data['page'])?$this->input_data['page']:1;
		$start = isset($this->input_data['page'])?(($page-1)*$limit):0;
		$id_prov = isset($this->input_data['id_prov'])?$this->input_data['id_prov']:"";
		$id_kota = isset($this->input_data['id_kota'])?$this->input_data['id_kota']:"";
		$status = isset($this->input_data['status'])?$this->input_data['status']:"";
		$q = isset($this->input_data['q'])?$this->input_data['q']:"";

		$query = $this->user_model->source();
		$query->select('tb_user.*');
		$query->join('tb_pelaku_usaha','tb_user.nib=tb_pelaku_usaha.nib');
		$query->where('tb_user.id_role',2);
		$query->where('tb_user.status_dikembalikan','0');
		
		if($q!=""){
			$query->group_start();
				$query->like('tb_user.nib',$q);
			$query->group_end();
		}
		if(!empty($this->userlog['id_prov'])){
			$query->where('tb_user.id_prov',$this->userlog['id_prov']);
		}
		if(!empty($this->userlog['id_kota'])){
			$query->where('tb_user.id_kota',$this->userlog['id_kota']);
		}
		if($status!=""){
			if($status==3){
				$query->group_start();
					$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);	
					$query->or_where('tb_user.status_verifikasi_cara_pembuatan',NULL);
				$query->group_end();
			}else{
				$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);
			}
		}
		$query->order_by('created_at','DESC');
		$total_data = $query->count_all_results();

		$query = $this->user_model->source();
		$query->select('tb_user.*');
		$query->join('tb_pelaku_usaha','tb_user.nib=tb_pelaku_usaha.nib');
		$query->where('tb_user.id_role',2);
		$query->where('tb_user.status_dikembalikan','0');
		
		if($q!=""){
			$query->group_start();
				$query->like('tb_user.nib',$q);
			$query->group_end();
		}
		if(!empty($this->userlog['id_prov'])){
			$query->where('tb_user.id_prov',$this->userlog['id_prov']);
		}
		if(!empty($this->userlog['id_kota'])){
			$query->where('tb_user.id_kota',$this->userlog['id_kota']);
		}
		if($status!=""){
			if($status==3){
				$query->group_start();
					$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);	
					$query->or_where('tb_user.status_verifikasi_cara_pembuatan',NULL);
				$query->group_end();
			}else{
				$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);
			}
		}
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
		$data['pagination'] = $this->paging_page('backend/pembatalan-akun/pembatalan-ditolak',$limit,$total_data);

		$this->template->load('template/backend', 'backend/pembatalan_cppob/list', $data);
	}

	public function pengajuan_pembatalan(){
		$data = [
			'title' => 'Pengajuan Pembekuan Akun',
			'breadcrumb' => breadcrumb('Pengajuan Pembekuan Akun', 'backend/pembatalan-akun/pengajuan-pembatalan')
		];

		$this->template->load('template/backend', 'backend/pembatalan_cppob/pengajuan_pembatalan', $data);

	}

	public function search_nib(){
		if ($this->input->is_ajax_request()) {
			// $nib = encrypt_decrypt('decrypt',$this->input_data['nib']);
			$nib = $this->input_data['nib'];

			// $user = $this->user_model->find($nib, 'nib');
			
			$query = $this->user_model->source();
			$query->where('nib', $nib);
			$query->where('id_role', 2);
			if($this->userlog['id_role'] == 5){ //INI KALO LEVEL DINKES PROVINSI
				$query->where('id_prov',$this->userlog['id_prov']);
			}
			if($this->userlog['id_role'] == 3){ //INI KALO LEVEL DINKES KABKOT
				$query->where('id_prov',$this->userlog['id_prov']);
				$query->where('id_kota',$this->userlog['id_kota']);
			}
			$query->where('is_active', '1');
			$user = $query->get()->result();


			if (!empty($user)) {
				$user = array_shift($user);
				$ret = array(
					"id_user"			=>	$user->id_user,
					"nib"				=>	$user->nib,
					"nik"				=>	$user->nik,
					"nama"				=>	$user->nama,
					"nama_pelaku_usaha"	=>	$user->nama_pelaku_usaha,
					"nama_usaha"		=>	$user->nama_usaha,
					"alamat_usaha"		=>	$user->alamat_usaha,
					"no_telp"			=>	$user->no_telp,
					"email"				=>	$user->email
				);
				$result['status'] = 200;
				$result['userData'] = $ret;
				$result['message'] = 'NIB Found';
			}
			else{
				$result['status'] = 404;
				$result['message'] = "NIB Tidak Ditemukan!";
			}
			echo json_encode($result);
		}
		else{
			$result['status'] = false;
			$result['message'] = "Access Denied";
			echo json_encode($result);
		}
	}

	public function save_submission(){
		if ($this->input->is_ajax_request()) {
			$pembatalan_data = array(
				'alasan_pembatalan_cara_pembuatan'=>$this->input_data['alasan_pembatalan'],
				'status_dikembalikan'=> "2"
			);

			if (!empty($_FILES['rekomendasi_pembatalan']['name'])) {
				$upload_permohonan = $this->cek_permohonan_pembatalan($this->input_data['nib_modal']);

				if ($upload_permohonan['status'] == 'true') {
					$pembatalan_data['surat_rekomendasi_pembatalan'] = $upload_permohonan['text'];
				}
				else{
					$result['status'] = false;
					$result['message'] = $upload_permohonan['text'];
					echo json_encode($result);
					exit();
				}
			}


			$this->user_model->update($pembatalan_data,$this->input_data['nib_modal'],'nib');
			
			$result['status'] = 200;
			$result['message'] = 'Permohonan Pembatalan berhasil dikirim';
			echo json_encode($result);
		}
		else{
			$result['status'] = false;
			$result['message'] = "Access Denied";
			echo json_encode($result);
		}
	}

	public function approve($nib){

		$id = strip_tags($nib);
		$id = encrypt_decrypt('decrypt', $id);

		$url_return = "backend/pembatalan-akun/permohonan-pembatalan";

		if (isset($this->input_data['url_return']) && !empty($this->input_data['url_return'])) {
			$url_return = $this->input_data['url_return'];
		}

		$pembatalan_data = array(
			'status_dikembalikan'=>"1",
		);

		if (!empty($_FILES['resmi_pembatalan']['name'])) {
			$upload_permohonan = $this->cek_resmi_pembatalan($id);

			if ($upload_permohonan['status'] == 'true') {
				$pembatalan_data['surat_resmi_pembatalan'] = $upload_permohonan['text'];
			}
			else{
				$this->session->set_flashdata("error", $upload_permohonan['text']);
				redirect($url_return);
			}
		}

		$this->user_model->update($pembatalan_data,$id,'nib');

		//// SEND NOTIFICATION ///
		$data_notification = array(
			'id'=>$id,
			'type'=>'Verifikasi Cara Pembuatan',
			'status'=>'Pembekuan Akun Disetujui',
			'msg'=>'Pembekuan Akun Disetujui',
		);
		send_notification($data_notification);

		$this->session->set_flashdata("success", "Pembatalan berhasil");
		redirect($url_return);
	}

	public function cancel($nib){

		$id = strip_tags($nib);
		$id = encrypt_decrypt('decrypt', $id);

		$pambatalan_data = array(
			'status_dikembalikan'=>'0',
			'alasan_penolakan_penangguhan_akun'=>$this->input_data['alasan_penolakan_penangguhan_akun']
		);
		$this->user_model->update($pambatalan_data,$id,'nib');

		//// SEND NOTIFICATION ///
		$data_notification = array(
			'id'=>$id,
			'type'=>'Verifikasi Cara Pembuatan',
			'status'=>'Pembekuan Akun Ditolak',
			'msg'=>'Pembekuan Akun Ditolak',
		);
		send_notification($data_notification);
		
		$this->session->set_flashdata("success", "Pembatalan berhasil ditolak");
		redirect("backend/pembatalan-akun/permohonan-pembatalan");
	}

	public function reactivate_akun(){
		$data = [
			'title' => 'Reactivate Akun',
			'breadcrumb' => breadcrumb('Reactivate Akun', 'backend/pembatalan-akun/reactivate-akun')
		];

		$limit = isset($this->input_data['limit'])?$this->input_data['limit']:10;
		$page = isset($this->input_data['page'])?$this->input_data['page']:1;
		$start = isset($this->input_data['page'])?(($page-1)*$limit):0;
		$id_prov = isset($this->input_data['id_prov'])?$this->input_data['id_prov']:"";
		$id_kota = isset($this->input_data['id_kota'])?$this->input_data['id_kota']:"";
		$status = isset($this->input_data['status'])?$this->input_data['status']:"";
		$q = isset($this->input_data['q'])?$this->input_data['q']:"";

		$query = $this->user_model->source();
		$query->select('tb_user.*');
		$query->join('tb_pelaku_usaha','tb_user.nib=tb_pelaku_usaha.nib');
		$query->where('tb_user.id_role',2);
		$query->where('tb_user.status_dikembalikan','1');
		
		if($q!=""){
			$query->group_start();
				$query->like('tb_user.nib',$q);
			$query->group_end();
		}
		if(!empty($this->userlog['id_prov'])){
			$query->where('tb_user.id_prov',$this->userlog['id_prov']);
		}
		if(!empty($this->userlog['id_kota'])){
			$query->where('tb_user.id_kota',$this->userlog['id_kota']);
		}
		if($status!=""){
			if($status==3){
				$query->group_start();
					$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);	
					$query->or_where('tb_user.status_verifikasi_cara_pembuatan',NULL);
				$query->group_end();
			}else{
				$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);
			}
		}
		$query->order_by('created_at','DESC');
		$total_data = $query->count_all_results();

		$query = $this->user_model->source();
		$query->select('tb_user.*');
		$query->join('tb_pelaku_usaha','tb_user.nib=tb_pelaku_usaha.nib');
		$query->where('tb_user.id_role',2);
		$query->where('tb_user.status_dikembalikan','1');
		
		if($q!=""){
			$query->group_start();
				$query->like('tb_user.nib',$q);
			$query->group_end();
		}
		if(!empty($this->userlog['id_prov'])){
			$query->where('tb_user.id_prov',$this->userlog['id_prov']);
		}
		if(!empty($this->userlog['id_kota'])){
			$query->where('tb_user.id_kota',$this->userlog['id_kota']);
		}
		if($status!=""){
			if($status==3){
				$query->group_start();
					$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);	
					$query->or_where('tb_user.status_verifikasi_cara_pembuatan',NULL);
				$query->group_end();
			}else{
				$query->where('tb_user.status_verifikasi_cara_pembuatan',$status);
			}
		}
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
		$data['pagination'] = $this->paging_page('backend/pembatalan-akun/reactivate-akun',$limit,$total_data);

		$this->template->load('template/backend', 'backend/reactivate_akun/list', $data);
	}

	public function process_reactivate($nib){
		$id = strip_tags($nib);
		$id = encrypt_decrypt('decrypt', $id);



		$reactivate_data = array(
			'status_dikembalikan'	=>	'0',
			'reactivate_time'		=>	gmdate("Y-m-d H:i:s",time()+60*60*7),
			'reactivate_by'			=>	$this->userlog['id']
		);
		$this->user_model->update($reactivate_data,$id,'nib');

		$this->session->set_flashdata("success", "Akun berhasil diaktifkan kemabali");
		redirect("backend/pembatalan-akun/reactivate-akun");
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
						'text'		=>	'Gagal Upload surat rekomendasi pembatalan. Silakan coba beberapa saat lagi.'
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
						'text'		=>	'Gagal Upload surat rekomendasi pembatalan. Silakan coba beberapa saat lagi.'
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

	private function cek_resmi_pembatalan($nib){
		$this->load->helper('string');
		$random = random_string('alnum', 4);
		$config = [
			'file_name' => 'Surat-Resmi-Pembatalan-' . date('d-m-Y') . '-' . $random,
			'upload_path' => './uploads/pengawasan/surat_resmi_pembatalan',
			'allowed_types' => 'pdf|doc|docx',
			'max_size' => '10000',
			'encrypt_name' => true,
		];

		$this->load->library('upload', $config);

		$response = array();
		$cek = $this->db->get_where('tb_user', ['nib' => $nib])->row_array();

		if (isset($cek['surat_resmi_pembatalan'])) {
			if (!empty($_FILES['resmi_pembatalan']['name'])) {
				if (!$this->upload->do_upload('resmi_pembatalan')) {
					$response = array(
						'status'	=>	'false',
						'text'		=>	'Gagal Upload surat resmi pembatalan. Silakan coba beberapa saat lagi.'
					);
				}
				else {
					$response = array(
						'status'	=>	'true',
						'text'		=>	$this->upload->data('file_name')
					);
					unlink(FCPATH . './uploads/pengawasan/surat_resmi_pembatalan/' . $cek['surat_resmi_pembatalan']);
				}
			}
		}
		else{
			if (!empty($_FILES['resmi_pembatalan']['name'])) {
				if (!$this->upload->do_upload('resmi_pembatalan')) {
					$response = array(
						'status'	=>	'false',
						'text'		=>	'Gagal Upload surat resmi pembatalan. Silakan coba beberapa saat lagi.'
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
}