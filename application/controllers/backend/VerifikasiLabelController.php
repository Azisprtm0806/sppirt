<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VerifikasiLabelController extends MY_Controller {

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
			'title' => 'Verifikasi Label',
			'breadcrumb' => breadcrumb('Verifikasi Label', 'backend/verifikasi-label')
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
		$limitExportsAll = isset($this->input_data['limit'])?$this->input_data['limit']:100;
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
		if($id_prov!=""){
			$query->where('tb_user.id_prov',$id_prov);
		}
		if($id_kota!=""){
			$query->where('tb_user.id_kota',$id_kota);
		}
		if($status!=4){
			if($status==3){
				$query->group_start();
					$query->where('tb_pengajuan_sppirt.status_verifikasi_label',$status);	
					$query->or_where('tb_pengajuan_sppirt.status_verifikasi_label',NULL);
				$query->group_end();
			}else{
				$query->where('tb_pengajuan_sppirt.status_verifikasi_label',$status);
			}
		}
		$query->where('tb_pengajuan_sppirt.status_pengajuan', '2');
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
		if($id_prov!=""){
			$query->where('tb_user.id_prov',$id_prov);
		}
		if($id_kota!=""){
			$query->where('tb_user.id_kota',$id_kota);
		}
		if($status!=4){
			if($status==3){
				$query->group_start();
					$query->where('tb_pengajuan_sppirt.status_verifikasi_label',$status);	
					$query->or_where('tb_pengajuan_sppirt.status_verifikasi_label',NULL);
				$query->group_end();
			}else{
				$query->where('tb_pengajuan_sppirt.status_verifikasi_label',$status);
			}
		}
		$query->where('tb_pengajuan_sppirt.status_pengajuan', '2');
		// $query->where('status_ptsp_product',NULL);
		
		if(isset($_GET['export']) && $_GET['export']=true){
			

			if($status == 4 && $id_prov == "" && $id_prov == ""){
				$query->limit($limitExportsAll,$start);	
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
	
	
				$this->load->view('backend/verifikasi_label/export', $data);
			} else {
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
	
	
				$this->load->view('backend/verifikasi_label/export', $data);	
			}
		}else{
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
			$data['pagination'] = $this->paging_page('backend/verifikasi-label',$limit,$total_data);
			
			$query = $this->provinsi_model->source();
			$data['provinsi'] = $query->get()->result();

			$this->template->load('template/backend', 'backend/verifikasi_label/list', $data);

		}

	}

	public function verifikasi($id){
		
		$id = strip_tags($id);
		$id_pengajuan = encrypt_decrypt('decrypt', $id);
	
		$this->db->select('tb_pengajuan_sppirt.no_sppirt, nama_produk_pangan,nib,tb_input_label_produk.*, tb_kategori_jenis_pangan.*,tb_jenis_pangan.*,tb_input_data_produk.*,tb_pengajuan_sppirt.id_pengajuan as id, tb_pengajuan_sppirt.status_verifikasi_label, upload_rancangan,tb_verifikasi_label.*')
			->join('tb_verifikasi_label','tb_pengajuan_sppirt.id_pengajuan = tb_verifikasi_label.id_pengajuan', 'LEFT')
			->join('tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
			->join('tb_input_label_produk', 'tb_input_label_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
			->join('tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan')
			->join('tb_kategori_jenis_pangan', 'tb_jenis_pangan.id_kategori_jenis_pangan = tb_kategori_jenis_pangan.id_kategori_jenis_pangan')
			->where('tb_pengajuan_sppirt.id_pengajuan', $id_pengajuan);
		$verifikasi = $this->db->get('tb_pengajuan_sppirt')->row_array();

		$data = [
			'title' => 'Verifikasi PIRT',
			'jenis_pangan' => $this->kategori_jenis_pangan_model->list('deleted_at', null),
			'breadcrumb' => breadcrumb('Verifikasi PIRT', 'backend/verifikasi-produk/form-verifikasi-produk'),
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

		
		$this->template->load('template/backend', 'backend/verifikasi_label/form-verifikasi-label', $data);	

	}

	function prosesVerifikasi()
	{

		if ($this->input->is_ajax_request()) {
			$id_pengajuan = encrypt_decrypt("decrypt", $this->input->post('id_pengajuan'));
			$where = ['id_pengajuan' => $id_pengajuan];

			$data_update_input_label_produk = array();

			$validate = $this->_validation();
			// $this->session->unset_userdata('file_rekomendasi_label');
			$jenis = $this->input->post('jenis');

			$return = $this->cekForm($this->session->userdata('file_rekomendasi_label'));
			$data = $return[0];
			$table = $return[1];
			$cek = $this->db->get_where($table, $where)->row();
			if ($validate) {
				if ($cek) {
				
					$this->db->update($table, $data, $where);
					$this->db->update('tb_pengajuan_sppirt', array('status_verifikasi_label'=>$this->input->post('status_verifikasi'),'alasan_pengembalian'=>$this->input->post('alasan_pengembalian')), $where);

					if ($this->session->userdata('file_rekomendasi_label')) {
						$data_update_input_label_produk['rekomendasi_label'] = $this->session->userdata('file_rekomendasi_label');
						// $this->db->update('tb_input_label_produk', array('rekomendasi_label'=>$this->session->userdata('file_rekomendasi_label')), $where);
					}
					$data_update_input_label_produk['catatan_perbaikan_label'] = $this->input->post('catatan_perbaikan_label');

					$this->db->update('tb_input_label_produk', $data_update_input_label_produk, $where);

				}else{
					$data['id_pengajuan'] = $id_pengajuan;
					$this->db->insert($table, $data);

					$this->db->update('tb_pengajuan_sppirt', array('status_verifikasi_label'=>$this->input->post('status_verifikasi'),'alasan_pengembalian'=>$this->input->post('alasan_pengembalian')), $where);

					if ($this->session->userdata('file_rekomendasi_label')) {
						$data_update_input_label_produk['rekomendasi_label'] = $this->session->userdata('file_rekomendasi_label');
						// $this->db->update('tb_input_label_produk', array('rekomendasi_label'=>$this->session->userdata('file_rekomendasi_label')), $where);
					}
					$data_update_input_label_produk['catatan_perbaikan_label'] = $this->input->post('catatan_perbaikan_label');

					$this->db->update('tb_input_label_produk', $data_update_input_label_produk, $where);
					$this->session->unset_userdata('file_rekomendasi_label');

				}
				if ($this->input->post('status_verifikasi') == "1") {
					$response = [
						'status' => true,
						'alert' => 'Proses verifikasi berhasil <br><b>Telah memenuhi komitmen</b>'
					];

					//// SEND NOTIFICATION ///
					$data_notification = array(
						'id'=>$id_pengajuan,
						'type'=>'Verifikasi Label',
						'status'=>'Pemenuhan Komitmen',
						'msg'=>'Pemenuhan Komitmen',
					);
					send_notification($data_notification);

				}else{
					$response = [
						'status' => true,
						'alert' => 'Proses verifikasi berhasil<br> <b><i>Tidak memenuhi komitmen</i></b>'
					];

					//// SEND NOTIFICATION ///
					$data_notification = array(
						'id'=>$id_pengajuan,
						'type'=>'Verifikasi Label',
						'status'=>'Perbaikan Label',
						'msg'=>'Perbaikan Label',
					);
					send_notification($data_notification);
				}

		
				
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


	function cekForm($rekomendasi_label)
	{
		$arrayCheck= [];

		$nama_produk = $this->input->post('nama_produk', true);
		$saran_nama_produk = $this->input->post('saran_nama_produk', true);

		$komposisi = $this->input->post('komposisi', true);
		$saran_komposisi = $this->input->post('saran_komposisi', true);

		$berat_bersih = $this->input->post('berat_bersih', true);
		$saran_berat_bersih = $this->input->post('saran_berat_bersih', true);

		$nama_alamat = $this->input->post('nama_alamat', true);
		$saran_nama_alamat = $this->input->post('saran_nama_alamat', true);

		$tgl_kode_produksi = $this->input->post('tgl_kode_produksi', true);
		$saran_tgl_kode_produksi = $this->input->post('saran_tgl_kode_produksi', true);

		$halal = $this->input->post('halal', true);
		$saran_halal = $this->input->post('saran_halal', true);

		$keterangan_kadaluarsa = $this->input->post('keterangan_kadaluarsa', true);
		$saran_keterangan_kadaluarsa = $this->input->post('saran_keterangan_kadaluarsa', true);

		$asal_usul_bahan = $this->input->post('asal_usul_bahan', true);
		$catatan_asal_usul_bahan = $this->input->post('catatan_asal_usul_bahan', true);
		$saran_asal_usul_bahan = $this->input->post('saran_asal_usul_bahan', true);
		
		$nama_produsen = $this->input->post('nama_produsen', true);
		$saran_nama_produsen = $this->input->post('saran_nama_produsen', true);
		
		$alamat_produsen = $this->input->post('alamat_produsen', true);
		$saran_alamat_produsen = $this->input->post('saran_alamat_produsen', true);

		$informasi_nilai_gizi = $this->input->post('informasi_nilai_gizi', true);
		$asal_informasi_nilai_gizi = $this->input->post('asal_informasi_nilai_gizi', true);

		$klaim_pada_label = $this->input->post('klaim_pada_label', true);

		$table = 'tb_verifikasi_label';
		$data = [
			'status_nama_produk' => $nama_produk,
			'saran_nama_produk' => $saran_nama_produk,
			'status_komposisi' => $komposisi,
			'saran_komposisi' => $saran_komposisi,
			'status_berat_bersih' => $berat_bersih,
			'saran_berat_bersih' => $saran_berat_bersih,
			'status_nama_alamat' => $nama_alamat,
			'saran_nama_alamat' => $saran_nama_alamat,
			'status_halal' => $halal,
			'saran_halal' => $saran_halal,
			'status_tgl_kode_produksi' => $tgl_kode_produksi,
			'saran_tgl_kode_produksi' => $saran_tgl_kode_produksi,
			'status_keterangan_kadaluarsa' => $keterangan_kadaluarsa,
			'saran_keterangan_kadaluarsa' => $saran_keterangan_kadaluarsa,
			'saran_asal_usul_bahan' => $saran_asal_usul_bahan,
			'status_asal_usul_bahan' => $asal_usul_bahan,
			'catatan_asal_usul_bahan' => $catatan_asal_usul_bahan,
			'status_informasi_nilai_gizi' => $informasi_nilai_gizi,
			'asal_informasi_nilai_gizi' => $asal_informasi_nilai_gizi,
			'nama_produsen'=> $nama_produsen,
			'saran_nama_produsen'=> $saran_nama_produsen,
			'alamat_produsen'=> $alamat_produsen,
			'saran_alamat_produsen'=> $saran_alamat_produsen,
			'status_klaim_pada_label'=>$klaim_pada_label
		];
		if ($nama_produk == '0') {
			$arrayCheck[] = $saran_nama_produk;
		}else if ($nama_produk == null) {
			$arrayCheck[] = $nama_produk;
		}
		if ($komposisi == '0') {
			$arrayCheck[] = $saran_komposisi;
		}else if ($komposisi == null) {
			$arrayCheck[] = $komposisi;
		}
		if ($berat_bersih == '0') {
			$arrayCheck[] = $saran_berat_bersih;
		}else if ($berat_bersih == null) {
			$arrayCheck[] = $berat_bersih;
		}
		if ($nama_alamat == '0') {
			$arrayCheck[] = $saran_nama_alamat;
		}else if ($nama_alamat == null) {
			$arrayCheck[] = $nama_alamat;
		}
		if ($halal == '0') {
			$arrayCheck[] = $saran_halal;
		}else if ($halal == null) {
			$arrayCheck[] = $halal;
		}
		if ($tgl_kode_produksi == '0') {
			$arrayCheck[] = $saran_tgl_kode_produksi;
		}else if ($tgl_kode_produksi == null) {
			$arrayCheck[] = $tgl_kode_produksi;
		}
		if ($keterangan_kadaluarsa == '0') {
			$arrayCheck[] = $saran_keterangan_kadaluarsa;
		}else if ($keterangan_kadaluarsa == null) {
			$arrayCheck[] = $keterangan_kadaluarsa;
		}
		if ($asal_usul_bahan == '0') {
			$arrayCheck[] = $saran_asal_usul_bahan;
		}else if ($asal_usul_bahan == null) {
			$arrayCheck[] = $asal_usul_bahan;
		}
		if ($informasi_nilai_gizi == '1') {
			$arrayCheck[] = $asal_informasi_nilai_gizi;
		}else if ($informasi_nilai_gizi == null) {
			$arrayCheck[] = $informasi_nilai_gizi;
		}
		if ($nama_produsen == '0') {
			$arrayCheck[] = $saran_nama_produsen;
		}else if ($nama_produsen == null) {
			$arrayCheck[] = $nama_produsen;
		}
		if ($alamat_produsen == '0') {
			$arrayCheck[] = $saran_alamat_produsen;
		}else if ($alamat_produsen == null) {
			$arrayCheck[] = $alamat_produsen;
		}


		$cekValue = true;
		foreach ($arrayCheck as $key => $value) {
			if ($value == null) {
				$cekValue = false;
			}
		}
		if ($cekValue) {
			$data['status_verifikasi'] = '1';
		}else{
			$data['status_verifikasi'] = '0';
		}
		return [$data, $table];
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
		if ($this->input->post('status_verifikasi') == 0) {
			$cek = $this->db->get_where('tb_input_label_produk', ['id_pengajuan' => $id_pengajuan])->row_array();

			if (isset($cek['rekomendasi_label'])) {
				if ($_FILES['rekomendasi_label']['name']) {
					if (!$this->upload->do_upload('rekomendasi_label')) {
						$this->form_validation->set_message(__FUNCTION__, $this->upload->display_errors('',''));
						$response = false;
						// $response = ['rekomendasi_label_error' => $this->upload->display_errors(), 'status' => false];
					} else {
						// $response = ['rekomendasi_label' => $this->upload->data('file_name'), 'status' => true];
						$this->session->set_userdata('file_rekomendasi_label', $this->upload->data('file_name'));
						unlink(FCPATH . './uploads/labelproduk/' . $cek['rekomendasi_label']);
						$response = true;
						// unlink(FCPATH.'./uploads/berita/thumbnail/'.$cek['rekomendasi_label']);
					}
				} else {
					$this->session->set_userdata('file_rekomendasi_label', $cek['rekomendasi_label']);
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
		}
		return $response;
	}

	function _validation()
	{
		$input = $this->input->post();

		$nama_produk = $this->input->post('nama_produk');
		$komposisi = $this->input->post('komposisi');
		$berat_bersih = $this->input->post('berat_bersih');
		$nama_alamat = $this->input->post('nama_alamat');
		$tgl_kode_produksi = $this->input->post('tgl_kode_produksi');
		$halal = $this->input->post('halal');
		$keterangan_kadaluarsa = $this->input->post('keterangan_kadaluarsa');
		$asal_usul_bahan = $this->input->post('asal_usul_bahan');
		$informasi_nilai_gizi = $this->input->post('informasi_nilai_gizi');
		$this->session->unset_userdata('file_rekomendasi_label');

		if($nama_produk == 0 && $nama_produk != null) $this->form_validation->set_rules('saran_nama_produk', 'Saran Produk Pangan', 'xss_clean|trim', rules());
		if($komposisi == 0 && $komposisi != null) $this->form_validation->set_rules('saran_komposisi', 'Saran Komposisi', 'xss_clean|trim', rules());
		if($berat_bersih == 0 && $berat_bersih != null) $this->form_validation->set_rules('saran_berat_bersih', 'Jenis Satuan', 'xss_clean|trim', rules());
		if($nama_alamat == 0 && $nama_alamat != null) $this->form_validation->set_rules('saran_nama_alamat', 'Saran Produsen', 'xss_clean|trim', rules());
		if($tgl_kode_produksi == 0 && $tgl_kode_produksi != null) $this->form_validation->set_rules('saran_tgl_kode_produksi', 'Saran Tanggal dan Kode Produksi', 'xss_clean|trim', rules());
		if($halal == 0 && $halal != null) $this->form_validation->set_rules('saran_halal', 'Saran Halal', 'xss_clean|trim', rules());
		if($keterangan_kadaluarsa == 0 && $keterangan_kadaluarsa != null) $this->form_validation->set_rules('saran_keterangan_kadaluarsa', 'Saran Keterangan Kadaluarsa', 'xss_clean|trim', rules());
		if($asal_usul_bahan == 0 && $asal_usul_bahan != null) $this->form_validation->set_rules('saran_asal_usul_bahan', 'Saran Asal Usul Bahan', 'xss_clean|trim', rules());
		// if($informasi_nilai_gizi == 0) $this->form_validation->set_rules('informasi_nilai_gizi', 'Saran Status Informasi Nilai Gizi', 'xss_clean|trim', rules());
		if($informasi_nilai_gizi == 1 && $informasi_nilai_gizi != null) $this->form_validation->set_rules('asal_informasi_nilai_gizi', 'Asal Informasi Nilai Gizi', 'xss_clean|trim', rules());
		if(isset($_FILES['rekomendasi_label']['size']) && $_FILES['rekomendasi_label']['size'] != 0) $this->form_validation->set_rules('rekomendasi_label', 'Rekomendasi Label', 'trim|callback_uploadLabel', rules());


		$this->form_validation->set_rules('nama_produk', 'Nama Produk Pangan', 'xss_clean|trim|required', rules());
		$this->form_validation->set_rules('komposisi', 'Komposisi', 'xss_clean|trim|required', rules());
		$this->form_validation->set_rules('berat_bersih', 'Satuan', 'xss_clean|trim|required', rules());
		$this->form_validation->set_rules('nama_alamat', 'Produsen', 'xss_clean|trim|required', rules());
		$this->form_validation->set_rules('halal', 'Label Halal', 'xss_clean|trim', rules());
		$this->form_validation->set_rules('tgl_kode_produksi', 'Tanggal dan Kode Produksi', 'xss_clean|trim|required', rules());
		$this->form_validation->set_rules('keterangan_kadaluarsa', 'Label Kadaluarsa', 'xss_clean|trim|required', rules());
		$this->form_validation->set_rules('asal_usul_bahan', 'Label Asal Usul', 'xss_clean|trim|required', rules());
		$this->form_validation->set_rules('informasi_nilai_gizi', 'Informasi Nilai Gizi', 'xss_clean|trim|required', rules());

		
        $this->form_validation->set_error_delimiters('', '');
		return $this->form_validation->run();


	}

	public function pemenuhan_komitmen($id){

		$id = strip_tags($id);
		$id = encrypt_decrypt('decrypt', $id);

		$pambatalan_data = array(
			'status_verifikasi_product'=>"1",
		);
		$this->pengajuan_sppirt_model->update($pambatalan_data,$id,'id_pengajuan');

		//// SEND NOTIFICATION ///
		$data_notification = array(
			'id'=>$id,
			'type'=>'Verifikasi Label',
			'status'=>'Pemenuhan Komitmen',
			'msg'=>'Pemenuhan Komitmen',
		);
		send_notification($data_notification);
				
		$this->session->set_flashdata("success", "Pemenuhan komitmen berhasil");
		redirect("backend/verifikasi-produk");
	}



}
