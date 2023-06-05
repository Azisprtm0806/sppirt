<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VerifikasiPkpController extends MY_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->library('image_lib');

		$this->user_model = new GeneralModel("tb_user");
		$this->role_model = new GeneralModel("tb_role");
		$this->provinsi_model = new GeneralModel("tb_provinsi");
		$this->kab_kota_model = new GeneralModel("tb_kota");
		$this->kecamatan_model = new GeneralModel("tb_kecamatan");
		$this->desa_model = new GeneralModel("tb_desa");
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
			'title' => 'Verifikasi PKP',
			'breadcrumb' => breadcrumb('Verifikasi PKP', 'backend/verifikasi-pkp')
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

		$query = $this->user_model->source();
		$query->select('tb_user.*');
		// $query->join('tb_pelaku_usaha','tb_user.nib=tb_pelaku_usaha.nib');
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
		if($status!=4){
			if($status==3){
				$query->group_start();
					$query->where('tb_user.status_verifikasi_pkp',$status);	
					$query->or_where('tb_user.status_verifikasi_pkp',NULL);
				$query->group_end();
			}else{
				$query->where('tb_user.status_verifikasi_pkp',$status);
			}
		}
		$query->order_by('created_at','ASC');
		$total_data = $query->count_all_results();

		$query = $this->user_model->source();
		$query->select('tb_user.*');
		// $query->join('tb_pelaku_usaha','tb_user.nib=tb_pelaku_usaha.nib');
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
		if($status!=4){
			if($status==3){
				$query->group_start();
					$query->where('tb_user.status_verifikasi_pkp',$status);	
					$query->or_where('tb_user.status_verifikasi_pkp',NULL);
				$query->group_end();
			}else{
				$query->where('tb_user.status_verifikasi_pkp',$status);
			}
		}
		
		
		if(isset($_GET['export']) && $_GET['export']=true){

			if($status == 4 && $id_prov == "" && $id_prov == ""){
				$query->limit($limitExportsAll,$start);
				$query->order_by('created_at','ASC');
				$verifikasi_produk = $query->get()->result();
				$datas = array();
				foreach ($verifikasi_produk as $key => $value) {

					$provinsi = $this->provinsi_model->find($value->id_prov,'id_prov');
					$value->nama_prov = isset($provinsi->nama_prov)?$provinsi->nama_prov:'';

					$kab_kota = $this->kab_kota_model->find($value->id_kota,'id_kota');
					$value->nama_kabkot = isset($kab_kota->nama_kota)?$kab_kota->nama_kota:'';

					$kecamatan = $this->kecamatan_model->find($value->id_kecamatan,'id_kecamatan');
					$value->nama_kecamatan = isset($kecamatan->nama_kecamatan)?$kecamatan->nama_kecamatan:'';

					$desa = $this->desa_model->find($value->id_desa,'id_desa');
					$value->nama_desa = isset($desa->nama_desa)?$desa->nama_desa:'';
					
					$datas[] = $value;
				}
				$data['datas'] = $datas;

				$this->load->view('backend/verifikasi_pkp/export', $data);
			} else {
				$query->order_by('created_at','ASC');
				$verifikasi_produk = $query->get()->result();
				$datas = array();
				foreach ($verifikasi_produk as $key => $value) {

					$provinsi = $this->provinsi_model->find($value->id_prov,'id_prov');
					$value->nama_prov = isset($provinsi->nama_prov)?$provinsi->nama_prov:'';

					$kab_kota = $this->kab_kota_model->find($value->id_kota,'id_kota');
					$value->nama_kabkot = isset($kab_kota->nama_kota)?$kab_kota->nama_kota:'';

					$kecamatan = $this->kecamatan_model->find($value->id_kecamatan,'id_kecamatan');
					$value->nama_kecamatan = isset($kecamatan->nama_kecamatan)?$kecamatan->nama_kecamatan:'';

					$desa = $this->desa_model->find($value->id_desa,'id_desa');
					$value->nama_desa = isset($desa->nama_desa)?$desa->nama_desa:'';
					
					$datas[] = $value;
				}
				$data['datas'] = $datas;

				$this->load->view('backend/verifikasi_pkp/export', $data);
			}
		}else{
			$query->limit($limit,$start);
			$query->order_by('created_at','ASC');
			$verifikasi_produk = $query->get()->result();
			$datas = array();
			foreach ($verifikasi_produk as $key => $value) {

				$provinsi = $this->provinsi_model->find($value->id_prov,'id_prov');
				$value->nama_prov = isset($provinsi->nama_prov)?$provinsi->nama_prov:'';

				$kab_kota = $this->kab_kota_model->find($value->id_kota,'id_kota');
				$value->nama_kabkot = isset($kab_kota->nama_kota)?$kab_kota->nama_kota:'';

				$kecamatan = $this->kecamatan_model->find($value->id_kecamatan,'id_kecamatan');
				$value->nama_kecamatan = isset($kecamatan->nama_kecamatan)?$kecamatan->nama_kecamatan:'';

				$desa = $this->desa_model->find($value->id_desa,'id_desa');
				$value->nama_desa = isset($desa->nama_desa)?$desa->nama_desa:'';
				
				$datas[] = $value;
			}
			$data['datas'] = $datas;

			$data['total_data'] = $total_data;
			$data['limit'] = $limit;
			$data['start'] = $start;
			$data['pagination'] = $this->paging_page('backend/verifikasi-pkp',$limit,$total_data);
			
			$query = $this->provinsi_model->source();
			$data['provinsi'] = $query->get()->result();

			$this->template->load('template/backend', 'backend/verifikasi_pkp/list', $data);
			
		}

	}

	public function verifikasi($id){
		
		$id = strip_tags($id);
		$nib = encrypt_decrypt('decrypt', $id);
	
		$this->db->select('tb_verifikasi_pkp.*, tb_user.nib as user_nib, tb_user.nik, tb_user.nama, tb_user.nama_pelaku_usaha, tb_user.nama_usaha, tb_user.alamat_usaha, tb_user.no_telp, tb_user.email, tb_user.nomor_sertifikat_pkp, tb_user.link_sertifikat_pkp, tb_user.tanggal_sertifikat_pkp')
			->join('tb_verifikasi_pkp','tb_user.nib = tb_verifikasi_pkp.nib', 'LEFT')
			->where('tb_user.nib', $nib)
			->where('tb_user.id_role', 2);
		$verifikasi = $this->db->get('tb_user')->row_array();

		$data = [
			'title' => 'Verifikasi PIRT',
			'jenis_pangan' => $this->kategori_jenis_pangan_model->list('deleted_at', null),
			'breadcrumb' => breadcrumb('Verifikasi PIRT', 'backend/verifikasi-pkp/form-verifikasi-pkp'),
			'data' => $verifikasi
		];

		$this->template->load('template/backend', 'backend/verifikasi_pkp/form-verifikasi-pkp', $data);	

	}

	function prosesVerifikasi()
	{

		if ($this->input->is_ajax_request()) {
			$nib = encrypt_decrypt("decrypt", $this->input->post('nib'));
			// var_dump($id_pengajuan);die;
			$where = ['nib' => $nib];
			$this->session->unset_userdata('file_berita_acara');
			$jenis = $this->input->post('jenis');
			$validate = $this->_validation();

			$return = $this->cekForm($this->session->userdata('file_berita_acara'));

			$data = $return[0];
			$table = $return[1];
			$cek = $this->db->get_where($table, $where)->row();

			if ($validate) {

				if ($cek) {
					$this->db->update($table, $data, $where);
					$this->db->update('tb_user', array('status_verifikasi_pkp'=>$data['status_verifikasi']), $where);
				}else{
					
					$data['nib'] = $nib;
					$this->db->insert($table, $data);

					$this->db->update('tb_user', array('status_verifikasi_pkp'=>$data['status_verifikasi']), $where);
					$this->session->unset_userdata('file_berita_acara');
				}
				if ($data['status_verifikasi'] == "1") {
					$response = [
						'status' => true,
						'alert' => 'Proses verifikasi berhasil <br><b>Telah memenuhi komitmen</b>'
					];

					//// SEND NOTIFICATION ///
					$data_notification = array(
						'id'=>$nib,
						'type'=>'Verifikasi PKP',
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

					//// SEND NOTIFICATION ///
					$data_notification = array(
						'id'=>$nib,
						'type'=>'Verifikasi PKP',
						'status'=>'Penjadwalan Penyuluhan',
						'msg'=>'Penjadwalan Penyuluhan',
					);
					send_notification($data_notification);
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


	function cekForm($berita_acara)
	{
		$arrayCheck= [];

		$status = $this->input->post('status', true);
		$status_personil = $this->input->post('status_personil', true);
		$jadwal = $this->input->post('jadwal', true);
		$nomor_sertifikat = $this->input->post('nomor_sertifikat', true);

		$table = 'tb_verifikasi_pkp';
		$data = [
			'status' => $status,
			'status_personil' => $status_personil,
			'nomor_sertifikat' => $nomor_sertifikat,
			'jadwal' => $jadwal
		];


		if ($status == "1") {
			$arrayCheck[] = $nomor_sertifikat;
		}
		if ($status == "0") {
			$arrayCheck[] = $jadwal;
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

		if($nomor_sertifikat!=""){
			$data['status_verifikasi'] = '1';
		}else{
			$data['status_verifikasi'] = '0';
		}
		return [$data, $table];
	}

	function _validation()
	{
		$input = $this->input->post();
		$status = $this->input->post('status');

		$this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required', rules());
		//$this->form_validation->set_rules('jadwal', 'Jadwal Penyuluhan', 'xss_clean|trim', rules());
		if($status == 1 && $status != null) $this->form_validation->set_rules('nomor_sertifikat', 'Nomor Sertifikat', 'xss_clean|trim', rules());
		if($status == 0 && $status != null) $this->form_validation->set_rules('jadwal', 'Jadwal Penyuluhan', 'xss_clean|trim|required', rules());
		
        $this->form_validation->set_error_delimiters('', '');
		return $this->form_validation->run();


	}

	public function sertifikat_pkp(){
		$nib = $this->userlog['nib'];
	
		$this->db->where('tb_user.nib', $nib);
		$user = $this->db->get('tb_user')->row_array();

		$data = [
			'title' => 'Form Isi Sertifikat PKP',
			'breadcrumb' => breadcrumb('Form Isi Sertifikat PKP', 'backend/sertifikat-pkp'),
			'data' => $user
		];

		$this->template->load('template/backend', 'backend/sertifikat_pkp/form-sertifikat-pkp', $data);	
	}

	public function sertifikat_pkp_save(){
		$id = strip_tags($this->input_data['nib']);
		$nib = encrypt_decrypt('decrypt', $id);

		$data = array(
			"nomor_sertifikat_pkp"		=>	$this->input_data['nomor_sertifikat_pkp'],
			"link_sertifikat_pkp"		=>	$this->input_data['link_sertifikat_pkp'],
			"tanggal_sertifikat_pkp"	=>	$this->input_data['tanggal_sertifikat_pkp']
		);

		$this->user_model->update($data,$nib,'nib');

		$this->session->set_flashdata("success", "Sertifikat PKP berhasil disimpan");
		redirect("backend/sertifikat-pkp");
	}

}
