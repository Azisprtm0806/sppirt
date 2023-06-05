<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RekapController extends MY_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->library('image_lib');

		$this->user_model = new GeneralModel("tb_user");
		$this->role_model = new GeneralModel("tb_role");
		$this->provinsi_model = new GeneralModel("tb_provinsi");
		$this->kab_kota_model = new GeneralModel("tb_kota");
		$this->pengajuan_sppirt_model = new GeneralModel("tb_pengajuan_sppirt");


		$this->pelaku_usaha_model = new GeneralModel("tb_pelaku_usaha");
		$this->pengajuan_sppirt_model = new GeneralModel("tb_pengajuan_sppirt");
		$this->kecamatan_model = new GeneralModel("tb_kecamatan");
		$this->desa_model = new GeneralModel("tb_desa");
		$this->user_model = new GeneralModel("tb_user");
		$this->jenis_pangan_model = new GeneralModel("tb_jenis_pangan");
		$this->kategori_jenis_pangan_model = new GeneralModel("tb_kategori_jenis_pangan");
		$this->jenis_kemasan_model = new GeneralModel("tb_jenis_kemasan");
		$this->penyimpanan_model = new GeneralModel("tb_penyimpanan");

		$this->userData = $this->session->userdata('userData');

	}

	public function pelaku_usaha()
	{

		$data = [
			'title' => 'Rekap Pelaku Usaha',
			'breadcrumb' => breadcrumb('Rekap | Pelaku Usaha', 'backend/rekap-pelaku-usaha')
		];

		$query = $this->provinsi_model->source();
		$data['provinsi'] = $query->get()->result();
		$data['userData'] = $this->userData;

		$limit = isset($this->input_data['limit'])?(int)$this->input_data['limit']:10;
		$page = isset($this->input_data['page'])?(int)$this->input_data['page']:1;
		$start = isset($this->input_data['page'])?(($page-1)*$limit):0;

		$q = isset($this->input_data['q'])?$this->input_data['q']:"";


		if($this->userData['id_role']==3 || $this->userData['id_role']==4 || $this->userData['id_role']==5){
			$id_prov = $this->userData['id_prov'];
		}else{
			$id_prov = (isset($_GET['id_prov']) && $_GET['id_prov']!="")?$_GET['id_prov']:"";
		}

		if($this->userData['id_role']==3 || $this->userData['id_role']==4){
			$id_kota = $this->userData['id_kota'];
		}else{
			$id_kota = (isset($_GET['id_kota']) && $_GET['id_kota']!="")?$_GET['id_kota']:"";
		}

		if(((isset($_GET['search']) && $_GET['search']=true) || (isset($_GET['export']) && $_GET['export']=true))|| ($this->userData['id_role']==3 || $this->userData['id_role']==4)){

			$query = $this->user_model->source();
			$query->select('tb_user.*, tb_provinsi.nama_prov, tb_kota.nama_kota');
			$query->join('tb_pelaku_usaha','tb_user.nib=tb_pelaku_usaha.nib');
			$query->join('tb_provinsi','tb_user.id_prov=tb_provinsi.id_prov');
			$query->join('tb_kota','tb_user.id_kota=tb_kota.id_kota');
			if($id_prov!=""){
				$query->where('tb_user.id_prov',$id_prov);
			}
			if($id_kota!=""){
				$query->where('tb_user.id_kota',$id_kota);
			}
			$query->where('tb_user.id_role',2);
			$query->order_by('no_urut_pelaku_usaha','DESC');
			$total_data = $query->count_all_results();

			$query = $this->user_model->source();
			$query->select('tb_user.*, tb_provinsi.nama_prov, tb_kota.nama_kota');
			$query->join('tb_pelaku_usaha','tb_user.nib=tb_pelaku_usaha.nib');
			$query->join('tb_provinsi','tb_user.id_prov=tb_provinsi.id_prov');
			$query->join('tb_kota','tb_user.id_kota=tb_kota.id_kota');
			if($id_prov!=""){
				$query->where('tb_user.id_prov',$id_prov);
			}
			if($id_kota!=""){
				$query->where('tb_user.id_kota',$id_kota);
			}
			$query->where('tb_user.id_role',2);
			$query->order_by('no_urut_pelaku_usaha','DESC');
			
			$show = 1;

		}else{

			$show = 0;
			$data['datas'] = array();

		}
	

		if(isset($_GET['search']) && $_GET['search']=true){

			$query->limit($limit,$start);
			$data['datas'] = $query->get()->result();

			$data['total_data'] = $total_data;
			$data['limit'] = $limit;
			$data['start'] = $start;
			$data['pagination'] = $this->paging_page('backend/rekap/pelaku-usaha',$limit,$total_data);

			$this->template->load('template/backend', 'backend/rekap/pelaku-usaha', $data);
		}else if(isset($_GET['export']) && $_GET['export']=true){

			$data['datas'] = $query->get()->result();

			$this->load->view('backend/rekap/export-pelaku-usaha', $data);
			
		}else{
			if($show==1){
				$query->limit($limit,$start);
				$data['datas'] = $query->get()->result();
			}else{
				$total_data = 0;
			}
			
			$data['total_data'] = $total_data;
			$data['limit'] = $limit;
			$data['start'] = $start;
			$data['pagination'] = $this->paging_page('backend/rekap/pelaku-usaha',$limit,$total_data);

			$this->template->load('template/backend', 'backend/rekap/pelaku-usaha', $data);
		}

	}

	public function detailProduk($nama){

		$data = [
			'title' => 'Detail Produk Pelaku Usaha',
			'breadcrumb' => breadcrumb('Detail Produk Pelaku Usaha', 'backend/rekap-pelaku-usaha')
	];
	
		$explode = explode('%20',$nama);
		$implode = implode(" ",$explode);

		$query = $this->pengajuan_sppirt_model->source();

		// $str = str_replace(' ','%20',$nama);
		$query->select('tb_pengajuan_sppirt.*')->where('nama_pelaku_usaha="'.$implode.'"');
		$data['datas'] = $query->get()->result();

		// var_dump($data);
		// die;

		$this->template->load('template/backend', 'backend/rekap/produk-pelaku-usaha', $data);
		
	}


	public function rekap_data_pirt()
	{

		$data = [
			'title' => 'Rekap Data PIRT',
			'breadcrumb' => breadcrumb('Rekap | Rekap Data PIRT', 'backend/rekap-data-pirt')
		];

		$query = $this->provinsi_model->source();
		$data['provinsi'] = $query->get()->result();
		$data['userData'] = $this->userData;

		$limit = isset($this->input_data['limit'])?(int)$this->input_data['limit']:10;
		$page = isset($this->input_data['page'])?(int)$this->input_data['page']:1;
		$start = isset($this->input_data['page'])?(($page-1)*$limit):0;
		$limitExportAll = isset($this->input_data['limit'])?(int)$this->input_data['limit']:100;

		$status = isset($this->input_data['status'])?$this->input_data['status']:"";
		


		if($this->userData['id_role']==3 || $this->userData['id_role']==4 || $this->userData['id_role']==5){
			$id_prov = $this->userData['id_prov'];
		}else{
			$id_prov = (isset($_GET['id_prov']) && $_GET['id_prov']!="")?$_GET['id_prov']:"";
		}

		if($this->userData['id_role']==3 || $this->userData['id_role']==4){
			$id_kota = $this->userData['id_kota'];
		}else{
			$id_kota = (isset($_GET['id_kota']) && $_GET['id_kota']!="")?$_GET['id_kota']:"";
		}

		if(((isset($_GET['search']) && $_GET['search']=true) || (isset($_GET['export']) && $_GET['export']=true))|| ($this->userData['id_role']==3 || $this->userData['id_role']==4)){

			$query = $this->pengajuan_sppirt_model->source();
			$query->select('tb_pengajuan_sppirt.*, tb_user.id_prov, tb_user.id_kota');
			$query->select('
				tb_pengajuan_sppirt.created_at as tgl_pengajuan, 
				tb_pengajuan_sppirt.created_at as tgl_pengajuan, 
				tb_pengajuan_sppirt.nib, 
				tb_pengajuan_sppirt.status_pengajuan, 
				tb_pengajuan_sppirt.id_pengajuan, 
				tb_pengajuan_sppirt.nama_produk_pangan, 
				tb_pengajuan_sppirt.file_izin, 
				tb_pengajuan_sppirt.no_sppirt, 
				tb_pengajuan_sppirt.no_sppirt_lama, 
				tb_pengajuan_sppirt.status_no_sppirt, 
				tb_pengajuan_sppirt.status_sinkronisasi, 
				tb_pengajuan_sppirt.id_izin, 
				tb_pengajuan_sppirt.path_fileds, 
				tb_input_data_produk.id_jenis_pangan, 
				tb_input_data_produk.id_penyimpanan, 
				tb_input_data_produk.id_jenis_kemasan, 
				tb_input_data_produk.id_kategori_jenis_pangan, 
				tb_user.id_prov, 
				tb_user.id_kota,
				tb_user.id_kecamatan,
				tb_user.id_desa'
			);
			$query->join('tb_user','tb_user.id_user=tb_pengajuan_sppirt.id_user');
			$query->join('tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan');
			// $query->join('tb_pelaku_usaha','tb_user.nib=tb_pelaku_usaha.nib');
			// $query->join('tb_provinsi','tb_user.id_prov=tb_provinsi.id_prov');
			// $query->join('tb_kota','tb_user.id_kota=tb_kota.id_kota');
			if($id_prov!=""){
				$query->where('tb_user.id_prov',$id_prov);
			}
			if($id_kota!=""){
				$query->where('tb_user.id_kota',$id_kota);
			}
			if($status!="4"){
				$query->where('tb_pengajuan_sppirt.status_pengajuan',$status);
			}
			$query->where('tb_user.id_role',2);


			$query->order_by('tb_pengajuan_sppirt.created_at','DESC');
			$total_data = $query->count_all_results();

			$query = $this->pengajuan_sppirt_model->source();
			$query->select('
				tb_pengajuan_sppirt.created_at as tgl_pengajuan, 
				tb_pengajuan_sppirt.created_at as tgl_pengajuan, 
				tb_pengajuan_sppirt.nib, 
				tb_pengajuan_sppirt.status_pengajuan, 
				tb_pengajuan_sppirt.id_pengajuan, 
				tb_pengajuan_sppirt.nama_produk_pangan, 
				tb_pengajuan_sppirt.file_izin, 
				tb_pengajuan_sppirt.no_sppirt, 
				tb_pengajuan_sppirt.no_sppirt_lama, 
				tb_pengajuan_sppirt.status_no_sppirt, 
				tb_pengajuan_sppirt.status_sinkronisasi, 
				tb_pengajuan_sppirt.id_izin, 
				tb_pengajuan_sppirt.path_fileds, 
				tb_input_data_produk.id_jenis_pangan, 
				tb_input_data_produk.id_penyimpanan, 
				tb_input_data_produk.id_jenis_kemasan, 
				tb_input_data_produk.id_kategori_jenis_pangan, 
				tb_user.id_prov, 
				tb_user.id_kota,
				tb_user.id_kecamatan,
				tb_user.id_desa'
			);
			$query->join('tb_user','tb_user.id_user=tb_pengajuan_sppirt.id_user');
			$query->join('tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan');
			// $query->select('tb_pengajuan_sppirt.*, tb_provinsi.nama_prov, tb_kota.nama_kota');
			// $query->join('tb_user','tb_user.nib=tb_pengajuan_sppirt.nib');
			// $query->join('tb_provinsi','tb_user.id_prov=tb_provinsi.id_prov');
			// $query->join('tb_kota','tb_user.id_kota=tb_kota.id_kota');
			if($id_prov!=""){
				$query->where('tb_user.id_prov',$id_prov);
			}
			if($id_kota!=""){
				$query->where('tb_user.id_kota',$id_kota);
			}
			if($status!="4"){
				$query->where('tb_pengajuan_sppirt.status_pengajuan',$status);
			}
			$query->where('tb_user.id_role',2);
			$query->order_by('tb_pengajuan_sppirt.created_at','DESC');
			
			$show = 1;

		}else{
			$show = 0;
			$data['datas'] = array();
		}
	

		if(isset($_GET['search']) && $_GET['search']=true){

			$query->limit($limit,$start);
			$pengajuan_sppirt= $query->get()->result();

			$datas = array();


			foreach ($pengajuan_sppirt as $key => $value) {

				$provinsi = $this->provinsi_model->find($value->id_prov,'id_prov');
				$value->nama_prov = isset($provinsi->nama_prov)?$provinsi->nama_prov:'';

				$kab_kota = $this->kab_kota_model->find($value->id_kota,'id_kota');
				$value->nama_kota = isset($kab_kota->nama_kota)?$kab_kota->nama_kota:'';

				$kecamatan = $this->kecamatan_model->find($value->id_kecamatan,'id_kecamatan');
				$value->nama_kecamatan = isset($kecamatan->nama_kecamatan)?$kecamatan->nama_kecamatan:'';

				$desa = $this->desa_model->find($value->id_desa,'id_desa');
				$value->nama_desa = isset($desa->nama_desa)?$desa->nama_desa:'';

				$value->tgl_berlaku_izin = date('d-m-Y', strtotime('+5 years', strtotime($value->tgl_pengajuan)));
				$value->tgl_prengajuan = date('d-m-Y', strtotime($value->tgl_pengajuan));

				$jenis_kemasan = $this->jenis_kemasan_model->find($value->id_jenis_kemasan,'id_jenis_kemasan');
				$value->nama_kemasan = isset($jenis_kemasan->nama_kemasan)?$jenis_kemasan->nama_kemasan:'';

				$kategori_jenis_pangan = $this->kategori_jenis_pangan_model->find($value->id_kategori_jenis_pangan,'id_kategori_jenis_pangan');
				$value->nama_kategori_jenis_pangan = isset($kategori_jenis_pangan->nama_kategori_jenis_pangan)?$kategori_jenis_pangan->nama_kategori_jenis_pangan:'';

				$penyimpanan = $this->penyimpanan_model->find($value->id_penyimpanan,'id_penyimpanan');
				$value->cara_penyimpanan = isset($penyimpanan->cara_penyimpanan)?$penyimpanan->cara_penyimpanan:'';

				$jenis_pangan = $this->jenis_pangan_model->find($value->id_jenis_pangan,'id_jenis_pangan');
				$value->nama_jenis_pangan = isset($jenis_pangan->nama_jenis_pangan)?$jenis_pangan->nama_jenis_pangan:'';

				$value->status_oss = ($value->status_sinkronisasi==1)?'TERKIRIM OSS':'BELUM TERKIRIM OSS';

				$datas[] = $value;
			}

			$data['datas'] = $datas;

			$data['total_data'] = $total_data;
			$data['limit'] = $limit;
			$data['start'] = $start;
			$data['pagination'] = $this->paging_page('backend/rekap/data-pirt',$limit,$total_data);

			$this->template->load('template/backend', 'backend/rekap/data-pirt', $data);

		}else if(isset($_GET['export']) && $_GET['export']=true){
			if($status == "4"){
				$query->limit($limitExportAll,$start);
				$pengajuan_sppirt= $query->get()->result();
				$datas = array();
	
				foreach ($pengajuan_sppirt as $key => $value) {
	
					$provinsi = $this->provinsi_model->find($value->id_prov,'id_prov');
					$value->nama_prov = isset($provinsi->nama_prov)?$provinsi->nama_prov:'';
	
					$kab_kota = $this->kab_kota_model->find($value->id_kota,'id_kota');
					$value->nama_kota = isset($kab_kota->nama_kota)?$kab_kota->nama_kota:'';
	
					$kecamatan = $this->kecamatan_model->find($value->id_kecamatan,'id_kecamatan');
					$value->nama_kecamatan = isset($kecamatan->nama_kecamatan)?$kecamatan->nama_kecamatan:'';
	
					$desa = $this->desa_model->find($value->id_desa,'id_desa');
					$value->nama_desa = isset($desa->nama_desa)?$desa->nama_desa:'';
	
					$value->tgl_berlaku_izin = date('d-m-Y', strtotime('+5 years', strtotime($value->tgl_pengajuan)));
					$value->tgl_prengajuan = date('d-m-Y', strtotime($value->tgl_pengajuan));
	
					$jenis_kemasan = $this->jenis_kemasan_model->find($value->id_jenis_kemasan,'id_jenis_kemasan');
					$value->nama_kemasan = isset($jenis_kemasan->nama_kemasan)?$jenis_kemasan->nama_kemasan:'';
	
					$kategori_jenis_pangan = $this->kategori_jenis_pangan_model->find($value->id_kategori_jenis_pangan,'id_kategori_jenis_pangan');
					$value->nama_kategori_jenis_pangan = isset($kategori_jenis_pangan->nama_kategori_jenis_pangan)?$kategori_jenis_pangan->nama_kategori_jenis_pangan:'';
	
					$penyimpanan = $this->penyimpanan_model->find($value->id_penyimpanan,'id_penyimpanan');
					$value->cara_penyimpanan = isset($penyimpanan->cara_penyimpanan)?$penyimpanan->cara_penyimpanan:'';
	
					$jenis_pangan = $this->jenis_pangan_model->find($value->id_jenis_pangan,'id_jenis_pangan');
					$value->nama_jenis_pangan = isset($jenis_pangan->nama_jenis_pangan)?$jenis_pangan->nama_jenis_pangan:'';
	
					$value->status_oss = ($value->status_sinkronisasi==1)?'TERKIRIM OSS':'BELUM TERKIRIM OSS';
	
					$datas[] = $value;
				}
	
				$data['datas'] = $datas;			 
				$this->load->view('backend/rekap/export-data-pirt', $data);
			} else {
				$pengajuan_sppirt= $query->get()->result();
				$datas = array();
	
				foreach ($pengajuan_sppirt as $key => $value) {
	
					$provinsi = $this->provinsi_model->find($value->id_prov,'id_prov');
					$value->nama_prov = isset($provinsi->nama_prov)?$provinsi->nama_prov:'';
	
					$kab_kota = $this->kab_kota_model->find($value->id_kota,'id_kota');
					$value->nama_kota = isset($kab_kota->nama_kota)?$kab_kota->nama_kota:'';
	
					$kecamatan = $this->kecamatan_model->find($value->id_kecamatan,'id_kecamatan');
					$value->nama_kecamatan = isset($kecamatan->nama_kecamatan)?$kecamatan->nama_kecamatan:'';
	
					$desa = $this->desa_model->find($value->id_desa,'id_desa');
					$value->nama_desa = isset($desa->nama_desa)?$desa->nama_desa:'';
	
					$value->tgl_berlaku_izin = date('d-m-Y', strtotime('+5 years', strtotime($value->tgl_pengajuan)));
					$value->tgl_prengajuan = date('d-m-Y', strtotime($value->tgl_pengajuan));
	
					$jenis_kemasan = $this->jenis_kemasan_model->find($value->id_jenis_kemasan,'id_jenis_kemasan');
					$value->nama_kemasan = isset($jenis_kemasan->nama_kemasan)?$jenis_kemasan->nama_kemasan:'';
	
					$kategori_jenis_pangan = $this->kategori_jenis_pangan_model->find($value->id_kategori_jenis_pangan,'id_kategori_jenis_pangan');
					$value->nama_kategori_jenis_pangan = isset($kategori_jenis_pangan->nama_kategori_jenis_pangan)?$kategori_jenis_pangan->nama_kategori_jenis_pangan:'';
	
					$penyimpanan = $this->penyimpanan_model->find($value->id_penyimpanan,'id_penyimpanan');
					$value->cara_penyimpanan = isset($penyimpanan->cara_penyimpanan)?$penyimpanan->cara_penyimpanan:'';
	
					$jenis_pangan = $this->jenis_pangan_model->find($value->id_jenis_pangan,'id_jenis_pangan');
					$value->nama_jenis_pangan = isset($jenis_pangan->nama_jenis_pangan)?$jenis_pangan->nama_jenis_pangan:'';
	
					$value->status_oss = ($value->status_sinkronisasi==1)?'TERKIRIM OSS':'BELUM TERKIRIM OSS';
	
					$datas[] = $value;
				}
	
				$data['datas'] = $datas;			 
				$this->load->view('backend/rekap/export-data-pirt', $data);
			}
		} else {

			if($show==1){
				$query->limit($limit,$start);
				$data['datas'] = $query->get()->result();
			}else{
				$total_data = 0;
			}
			
			$data['total_data'] = $total_data;
			$data['limit'] = $limit;
			$data['start'] = $start;
			$data['pagination'] = $this->paging_page('backend/rekap/data-pirt',$limit,$total_data);

			$this->template->load('template/backend', 'backend/rekap/data-pirt', $data);
		}

	}


}
