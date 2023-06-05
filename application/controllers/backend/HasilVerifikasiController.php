<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HasilVerifikasiController extends MY_Controller {

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

	public function pirt_dibatalkan()
	{

		$data = [
			'title' => 'List PIRT yang dibatalkan',
			'breadcrumb' => breadcrumb('PIRT Dibatalkan', 'backend/hasil-verifikasi/pirt-dibatalkan')
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
				$query->or_like('tb_pengajuan_sppirt.no_sppirt',$q);
			$query->group_end();
		}
		$query->where('tb_pengajuan_sppirt.nib',$this->userlog['nib']);
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
				$query->or_like('tb_pengajuan_sppirt.no_sppirt',$q);
			$query->group_end();
		}
		$query->where('tb_pengajuan_sppirt.nib',$this->userlog['nib']);
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
		$data['pagination'] = $this->paging_page('backend/hasil-verifikasi/pirt-dibatalkan',$limit,$total_data);
		
		$query = $this->provinsi_model->source();
		$data['provinsi'] = $query->get()->result();

		$this->template->load('template/backend', 'backend/hasil_verifikasi/list_pirt_dibatalkan', $data);

	}
}