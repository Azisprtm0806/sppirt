<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PermohonanPembatalanController extends MY_Controller {

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

	public function index()
	{

		$data = [
			'title' => 'Permohonan Pembatalan',
			'breadcrumb' => breadcrumb('Permohonan Pembatalan', 'backend/permohonan-pembatalan')
		];

		$limit = isset($this->input_data['limit'])?$this->input_data['limit']:10;
		$page = isset($this->input_data['page'])?$this->input_data['page']:1;
		$start = isset($this->input_data['page'])?(($page-1)*$limit):0;
		$id_pengajuan_prov = isset($this->input_data['id_prov'])?$this->input_data['id_prov']:"";
		$id_kota = isset($this->input_data['id_kota'])?$this->input_data['id_kota']:"";
		$status = isset($this->input_data['status'])?$this->input_data['status']:"";
		$q = isset($this->input_data['q'])?$this->input_data['q']:"";

		$query = $this->pengajuan_sppirt_model->source();
		$query->select('tb_pengajuan_sppirt.id_pengajuan, tb_pengajuan_sppirt.status_verifikasi_label, tb_pengajuan_sppirt.status_verifikasi_product, no_sppirt, nama_jenis_pangan, nama_produk_pangan,nama_kemasan, id_izin,tb_pengajuan_sppirt.created_at as tgl_pengajuan, status_pengajuan, tb_kategori_jenis_pangan.*, no_sppirt_lama, status_no_sppirt, status_sinkronisasi, id_kota, id_prov, tb_user.nib');
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
		if(!empty($this->userlog['id_prov'])){
			$query->where('tb_user.id_prov',$this->userlog['id_prov']);
		}
		if(!empty($this->userlog['id_kota'])){
			$query->where('tb_user.id_kota',$this->userlog['id_kota']);
		}
		if($status!=""){
			if($status==3){
				$query->group_start();
					$query->where('tb_pengajuan_sppirt.status_verifikasi_product',$status);	
					$query->or_where('tb_pengajuan_sppirt.status_verifikasi_product',NULL);
				$query->group_end();
			}else{
				$query->where('tb_pengajuan_sppirt.status_verifikasi_product',$status);
			}
		}
		$query->where('status_ptsp_product','0');
		$total_data = $query->count_all_results();

		$query = $this->pengajuan_sppirt_model->source();
		$query->select('tb_pengajuan_sppirt.id_pengajuan, tb_pengajuan_sppirt.status_verifikasi_label, tb_pengajuan_sppirt.status_verifikasi_product, tb_pengajuan_sppirt.surat_rekomendasi_pembatalan, tb_pengajuan_sppirt.surat_resmi_pembatalan, tb_pengajuan_sppirt.status_ptsp_product, tb_pengajuan_sppirt.alasan_pembatalan, no_sppirt, nama_jenis_pangan, nama_produk_pangan,nama_kemasan, id_izin,tb_pengajuan_sppirt.created_at as tgl_pengajuan, status_pengajuan, tb_kategori_jenis_pangan.*, no_sppirt_lama, status_no_sppirt, status_sinkronisasi, id_kota, id_prov, tb_user.nib');
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
		if(!empty($this->userlog['id_prov'])){
			$query->where('tb_user.id_prov',$this->userlog['id_prov']);
		}
		if(!empty($this->userlog['id_kota'])){
			$query->where('tb_user.id_kota',$this->userlog['id_kota']);
		}
		if($status!=""){
			if($status==3){
				$query->group_start();
					$query->where('tb_pengajuan_sppirt.status_verifikasi_product',$status);	
					$query->or_where('tb_pengajuan_sppirt.status_verifikasi_product',NULL);
				$query->group_end();
			}else{
				$query->where('tb_pengajuan_sppirt.status_verifikasi_product',$status);
			}
		}


		if(isset($_GET['export']) && $_GET['export']=true){
			$query->where('status_ptsp_product','0');
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
	
			$this->load->view('backend/permohonan_pembatalan/exportExcelPermohonan', $data);
		} else {
		$query->where('status_ptsp_product','0');
			
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
			$data['pagination'] = $this->paging_page('backend/permohonan-pembatalan',$limit,$total_data);
			
			$query = $this->provinsi_model->source();
			$data['provinsi'] = $query->get()->result();
	
			$this->template->load('template/backend', 'backend/permohonan_pembatalan/list', $data);
		}

	}

	public function pembatalan_disetujui()
	{

		$data = [
			'title' => 'Permohonan Pembatalan Disetujui',
			'breadcrumb' => breadcrumb('Permohonan Pembatalan Disetujui', 'backend/permohonan-pembatalan')
		];

		$limit = isset($this->input_data['limit'])?$this->input_data['limit']:10;
		$page = isset($this->input_data['page'])?$this->input_data['page']:1;
		$start = isset($this->input_data['page'])?(($page-1)*$limit):0;
		$id_prov = isset($this->input_data['id_prov'])?$this->input_data['id_prov']:"";
		$id_kota = isset($this->input_data['id_kota'])?$this->input_data['id_kota']:"";
		$status = isset($this->input_data['status'])?$this->input_data['status']:"";
		$q = isset($this->input_data['q'])?$this->input_data['q']:"";

		$query = $this->pengajuan_sppirt_model->source();
		$query->select('tb_pengajuan_sppirt.id_pengajuan, tb_pengajuan_sppirt.status_verifikasi_label, tb_pengajuan_sppirt.status_verifikasi_product, no_sppirt, nama_jenis_pangan, nama_produk_pangan,nama_kemasan, id_izin,tb_pengajuan_sppirt.created_at as tgl_pengajuan, status_pengajuan, tb_kategori_jenis_pangan.*, no_sppirt_lama, status_no_sppirt, status_sinkronisasi, id_kota, id_prov, tb_user.nib');
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
		if(!empty($this->userlog['id_prov'])){
			$query->where('tb_user.id_prov',$this->userlog['id_prov']);
		}
		if(!empty($this->userlog['id_kota'])){
			$query->where('tb_user.id_kota',$this->userlog['id_kota']);
		}
		if($status!=""){
			if($status==3){
				$query->group_start();
					$query->where('tb_pengajuan_sppirt.status_verifikasi_product',$status);	
					$query->or_where('tb_pengajuan_sppirt.status_verifikasi_product',NULL);
				$query->group_end();
			}else{
				$query->where('tb_pengajuan_sppirt.status_verifikasi_product',$status);
			}
		}
		$query->where('status_ptsp_product','1');
		$total_data = $query->count_all_results();

		$query = $this->pengajuan_sppirt_model->source();
		$query->select('tb_pengajuan_sppirt.id_pengajuan, tb_pengajuan_sppirt.status_verifikasi_label, tb_pengajuan_sppirt.status_verifikasi_product, tb_pengajuan_sppirt.surat_rekomendasi_pembatalan, tb_pengajuan_sppirt.surat_resmi_pembatalan, tb_pengajuan_sppirt.status_ptsp_product, tb_pengajuan_sppirt.alasan_pembatalan, no_sppirt, nama_jenis_pangan, nama_produk_pangan,nama_kemasan, id_izin,tb_pengajuan_sppirt.created_at as tgl_pengajuan, status_pengajuan, tb_kategori_jenis_pangan.*, no_sppirt_lama, status_no_sppirt, status_sinkronisasi, id_kota, id_prov, tb_user.nib');
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
		if(!empty($this->userlog['id_prov'])){
			$query->where('tb_user.id_prov',$this->userlog['id_prov']);
		}
		// if(!empty($this->userlog['id_kota'])){
		// 	$query->where('tb_user.id_kota',$this->userlog['id_kota']);
		// }
		if($status!=""){
			if($status==3){
				$query->group_start();
					$query->where('tb_pengajuan_sppirt.status_verifikasi_product',$status);	
					$query->or_where('tb_pengajuan_sppirt.status_verifikasi_product',NULL);
				$query->group_end();
			}else{
				$query->where('tb_pengajuan_sppirt.status_verifikasi_product',$status);
			}
		}

		if(isset($_GET['export']) && $_GET['export']=true){
			$query->where('status_ptsp_product','1');
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
	
			$this->load->view('backend/permohonan_pembatalan/exportExcelDisetujui', $data);

		} else {
			$query->where('status_ptsp_product','1');
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
			$data['pagination'] = $this->paging_page('backend/permohonan-pembatalan',$limit,$total_data);
			
			$query = $this->provinsi_model->source();
			$data['provinsi'] = $query->get()->result();
	
			$this->template->load('template/backend', 'backend/permohonan_pembatalan/list', $data);
		}


	}

	public function pembatalan_ditolak()
	{

		$data = [
			'title' => 'Permohonan Pembatalan Ditolak',
			'breadcrumb' => breadcrumb('Permohonan Pembatalan Ditolak', 'backend/permohonan-pembatalan')
		];

		$limit = isset($this->input_data['limit'])?$this->input_data['limit']:10;
		$page = isset($this->input_data['page'])?$this->input_data['page']:1;
		$start = isset($this->input_data['page'])?(($page-1)*$limit):0;
		$id_prov = isset($this->input_data['id_prov'])?$this->input_data['id_prov']:"";
		$id_kota = isset($this->input_data['id_kota'])?$this->input_data['id_kota']:"";
		$status = isset($this->input_data['status'])?$this->input_data['status']:"";
		$q = isset($this->input_data['q'])?$this->input_data['q']:"";

		$query = $this->pengajuan_sppirt_model->source();
		$query->select('tb_pengajuan_sppirt.id_pengajuan, tb_pengajuan_sppirt.status_verifikasi_label, tb_pengajuan_sppirt.status_verifikasi_product, no_sppirt, nama_jenis_pangan, nama_produk_pangan,nama_kemasan, id_izin,tb_pengajuan_sppirt.created_at as tgl_pengajuan, status_pengajuan, tb_kategori_jenis_pangan.*, no_sppirt_lama, status_no_sppirt, status_sinkronisasi, id_kota, id_prov, tb_user.nib');
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
		if(!empty($this->userlog['id_prov'])){
			$query->where('tb_user.id_prov',$this->userlog['id_prov']);
		}
		if(!empty($this->userlog['id_kota'])){
			$query->where('tb_user.id_kota',$this->userlog['id_kota']);
		}
		if($status!=""){
			if($status==3){
				$query->group_start();
					$query->where('tb_pengajuan_sppirt.status_verifikasi_product',$status);	
					$query->or_where('tb_pengajuan_sppirt.status_verifikasi_product',NULL);
				$query->group_end();
			}else{
				$query->where('tb_pengajuan_sppirt.status_verifikasi_product',$status);
			}
		}
		$query->where('status_ptsp_product','2');
		$total_data = $query->count_all_results();

		$query = $this->pengajuan_sppirt_model->source();
		$query->select('tb_pengajuan_sppirt.id_pengajuan, tb_pengajuan_sppirt.status_verifikasi_label, tb_pengajuan_sppirt.status_verifikasi_product, tb_pengajuan_sppirt.surat_rekomendasi_pembatalan, tb_pengajuan_sppirt.surat_resmi_pembatalan, tb_pengajuan_sppirt.status_ptsp_product, tb_pengajuan_sppirt.alasan_pembatalan, no_sppirt, nama_jenis_pangan, nama_produk_pangan,nama_kemasan, id_izin,tb_pengajuan_sppirt.created_at as tgl_pengajuan, status_pengajuan, tb_kategori_jenis_pangan.*, no_sppirt_lama, status_no_sppirt, status_sinkronisasi, id_kota, id_prov, tb_user.nib');
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
		if(!empty($this->userlog['id_prov'])){
			$query->where('tb_user.id_prov',$this->userlog['id_prov']);
		}
		// if(!empty($this->userlog['id_kota'])){
		// 	$query->where('tb_user.id_kota',$this->userlog['id_kota']);
		// }
		if($status!=""){
			if($status==3){
				$query->group_start();
					$query->where('tb_pengajuan_sppirt.status_verifikasi_product',$status);	
					$query->or_where('tb_pengajuan_sppirt.status_verifikasi_product',NULL);
				$query->group_end();
			}else{
				$query->where('tb_pengajuan_sppirt.status_verifikasi_product',$status);
			}
		}

		if(isset($_GET['export']) && $_GET['export']=true){
			$query->where('status_ptsp_product','2');
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

			$this->load->view('backend/permohonan_pembatalan/exportExcelDitolak', $data);

		} else {
			$query->where('status_ptsp_product','2');
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
			$data['pagination'] = $this->paging_page('backend/permohonan-pembatalan',$limit,$total_data);
			
			$query = $this->provinsi_model->source();
			$data['provinsi'] = $query->get()->result();

			$this->template->load('template/backend', 'backend/permohonan_pembatalan/list', $data);
			}

	}

	public function approve($id){

		$id = strip_tags($id);
		$id = encrypt_decrypt('decrypt', $id);

		$url_return = "backend/permohonan-pembatalan";

		if (isset($this->input_data['url_return']) && !empty($this->input_data['url_return'])) {
			$url_return = $this->input_data['url_return'];
		}

		$pembatalan_data = array(
			'status_ptsp_product'=>"1",
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

		$this->pengajuan_sppirt_model->update($pembatalan_data,$id,'id_pengajuan');

		//// SEND NOTIFICATION ///
		$data_notification = array(
			'id'=>$id,
			'type'=>'Verifikasi Produk',
			'status'=>'Pembatalan Disetujui',
			'msg'=>'Pembatalan Disetujui',
		);
		send_notification($data_notification);

		$this->session->set_flashdata("success", "Pembatalan berhasil");
		redirect($url_return);
	}

	public function cancel($id){

		$id = strip_tags($id);
		$id = encrypt_decrypt('decrypt', $id);

		$pambatalan_data = array(
			'status_ptsp_product'=>'2',
			'status_verifikasi_product'=>null,
		);
		$this->pengajuan_sppirt_model->update($pambatalan_data,$id,'id_pengajuan');
		
		$this->monitoring_product_model->delete($id,'id_pengajuan');

		//// SEND NOTIFICATION ///
		$data_notification = array(
			'id'=>$id,
			'type'=>'Verifikasi Produk',
			'status'=>'Permohonan Pembatalan Ditolak',
			'msg'=>'Permohonan Pembatalan Ditolak',
		);
		send_notification($data_notification);
	
		$this->session->set_flashdata("success", "Pembatalan berhasil ditolak");
		redirect("backend/permohonan-pembatalan");
	}


	public function pengajuan_pembatalan(){

		$id_pengajuan_org = strip_tags($this->input_data['id_pengajuan']);
		$id_pengajuan = encrypt_decrypt('decrypt', $id_pengajuan_org);

		$id_analisis_product = strip_tags($this->input_data['id_analisis_product']);
		$id_analisis_product = encrypt_decrypt('decrypt', $id_analisis_product);

		$pambatalan_data = array(
			'status_ptsp_product'=>"0",
			'alasan_pembatalan'=>$this->input_data['alasan_pembatalan']
		);
		$this->pengajuan_sppirt_model->update($pambatalan_data,$id_pengajuan,'id_pengajuan');

		$query = $this->monitoring_product_model->source();
		$query->where('id_pengajuan',$id_pengajuan);
		$query->where('id_analisis_product',$id_analisis_product);
		$monitoring_product = $query->get()->row();
		if(isset($monitoring_product->id)){

			$monitoring_data = array(
				'hasil_verifikasi'=>0,
				'is_next'=>0,
			);
			$this->monitoring_product_model->update($monitoring_data,$monitoring_product->id);

		}else{

			$monitoring_data = array(
				'id_pengajuan'=>$id_pengajuan,
				'id_analisis_product'=>$id_analisis_product,
				'hasil_verifikasi'=>0,
				'is_next'=>0,
			);
			$this->monitoring_product_model->insert($monitoring_data);
		}

		$pengajuan_sppirt = $this->pengajuan_sppirt_model->find($id_pengajuan,'id_pengajuan');
		$user = $this->user_model->find($pengajuan_sppirt->id_user,'id_user');

		//// SEND NOTIFICATION ///
		$data_notification = array(
			'id'=>$id_pengajuan,
			'type'=>'Verifikasi Produk',
			'status'=>'Permohonan Pembatalan',
			'msg'=>'Permohonan Pembatalan',
		);
		send_notification($data_notification);

		$this->session->set_flashdata("success", "Permohonan Pembatalan berhasil dikirim");
		redirect("backend/verifikasi-produk/verifikasi/".$id_pengajuan_org);
	}

	private function cek_resmi_pembatalan($id_pengajuan){
		$this->load->helper('string');
		$random = random_string('alnum', 4);
		$config = [
			'file_name' => 'Surat-Resmi-Pembatalan-' . date('d-m-Y') . '-' . $random,
			'upload_path' => './uploads/verifikasiproduk/surat_resmi_pembatalan',
			'allowed_types' => 'pdf|doc|docx',
			'max_size' => '10000',
			'encrypt_name' => true,
		];

		$this->load->library('upload', $config);

		$response = array();
		$cek = $this->db->get_where('tb_pengajuan_sppirt', ['id_pengajuan' => $id_pengajuan])->row_array();

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
					unlink(FCPATH . './uploads/verifikasiproduk/surat_resmi_pembatalan/' . $cek['surat_resmi_pembatalan']);
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
