<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StatusPemenuhanKomitmenController extends MY_Controller {

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


		$this->userData = $this->session->userdata('userData');

	}

	public function index()
	{

		$data = [
			'title' => 'Status Pemenuhan Komitmen',
			'breadcrumb' => breadcrumb('Status Pemenuhan Komitmen', 'backend/status-penuhan-komitmen')
		];

		$limit = isset($this->input_data['limit'])?$this->input_data['limit']:10;
		$page = isset($this->input_data['page'])?$this->input_data['page']:1;
		$start = isset($this->input_data['page'])?(($page-1)*$limit):0;
		$id_prov = isset($this->input_data['id_prov'])?$this->input_data['id_prov']:"";
		$id_kota = isset($this->input_data['id_kota'])?$this->input_data['id_kota']:"";
		$status = isset($this->input_data['status'])?$this->input_data['status']:"";
		$q = isset($this->input_data['q'])?$this->input_data['q']:"";

		if($this->userData['id_role']==2){
			$q = $this->userData['nib'];
		}

		$query = $this->pengajuan_sppirt_model->source();
		$query->select('tb_pengajuan_sppirt.*');
		$query->join('tb_user','tb_user.id_user=tb_pengajuan_sppirt.id_user');
		$query->where('tb_pengajuan_sppirt.status_pengajuan', '2');
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
		$total_data = $query->count_all_results();

		$query = $this->pengajuan_sppirt_model->source();
		$query->select('tb_pengajuan_sppirt.*, tb_user.id_prov, tb_user.id_kota, tb_user.status_verifikasi_pkp, tb_user.status_verifikasi_cara_pembuatan');
		$query->join('tb_user','tb_user.id_user=tb_pengajuan_sppirt.id_user');
		$query->where('tb_pengajuan_sppirt.status_pengajuan', '2');
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
		$query->limit($limit,$start);
		$query->order_by('created_at','DESC');
		$verifikasi_produk = $query->get()->result();
		$datas = array();
		foreach ($verifikasi_produk as $key => $value) {

			$provinsi = $this->provinsi_model->find($value->id_prov,'id_prov');
			$value->nama_prov = isset($provinsi->nama_prov)?$provinsi->nama_prov:'';

			$kab_kota = $this->kab_kota_model->find($value->id_kota,'id_kota');
			$value->nama_kabkot = isset($kab_kota->nama_kota)?$kab_kota->nama_kota:'';

			$value->status_verifikasi_pemenuhan_komitmen = ($value->status_verifikasi_product==1 && $value->status_verifikasi_label==1 && $value->status_verifikasi_pkp==1 && $value->status_verifikasi_cara_pembuatan==1)?'1':'0';

			$datas[] = $value;
		}
		$data['datas'] = $datas;

		$data['total_data'] = $total_data;
		$data['limit'] = $limit;
		$data['start'] = $start;
		$data['pagination'] = $this->paging_page('backend/status-pemenuhan-komitmen',$limit,$total_data);
		
		$query = $this->provinsi_model->source();
		$data['provinsi'] = $query->get()->result();

		$data['userData'] = $this->userData;

		$this->template->load('template/backend', 'backend/status_pemenuhan_komitmen/list', $data);

	}


}
