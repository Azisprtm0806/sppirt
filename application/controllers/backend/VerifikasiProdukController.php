<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VerifikasiProdukController extends MY_Controller {

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
			'title' => 'Verifikasi Produk',
			'breadcrumb' => breadcrumb('Verifikasi Produk', 'backend/verifikasi-produk')
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
		$limitExportData = isset($this->input_data['limit'])?$this->input_data['limit']:100;
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
			2 = Pengajuan Pembatalan ke PTSP
			3 = Menunggu Verifikasi (default value)
			4 = Verifikasi Ulang
		*/

		$query = $this->pengajuan_sppirt_model->source();
		$query->select('tb_pengajuan_sppirt.id_pengajuan, tb_pengajuan_sppirt.status_ptsp_product, tb_pengajuan_sppirt.status_verifikasi_label, tb_pengajuan_sppirt.status_verifikasi_product, no_sppirt, nama_jenis_pangan, nama_produk_pangan,nama_kemasan, id_izin,tb_pengajuan_sppirt.created_at as tgl_pengajuan, status_pengajuan, tb_kategori_jenis_pangan.*, no_sppirt_lama, status_no_sppirt, status_sinkronisasi, id_kota, id_prov, tb_user.nib');
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
		if($status!=5){
			if($status==0){
				$query->group_start();
					$query->where('tb_pengajuan_sppirt.status_verifikasi_product','0');
					// $query->where('tb_pengajuan_sppirt.status_ptsp_product !=',0);
				$query->group_end();
			}
			elseif ($status==1) {
				$query->where('tb_pengajuan_sppirt.status_verifikasi_product',$status);
			}
			elseif($status==2){
				$query->group_start();
					$query->where('tb_pengajuan_sppirt.status_ptsp_product !=',NULL);
					$query->where('tb_pengajuan_sppirt.status_ptsp_product','0');
					$query->where('tb_pengajuan_sppirt.status_verifikasi_product !=','1');
				$query->group_end();
			}
			elseif($status==3){
				$query->where('tb_pengajuan_sppirt.status_ptsp_product',NULL);
				$query->group_start();
					$query->where('tb_pengajuan_sppirt.status_verifikasi_product',$status);	
					$query->or_where('tb_pengajuan_sppirt.status_verifikasi_product',NULL);
				$query->group_end();
			}
			elseif($status==4){
				$query->group_start();
					$query->where('tb_pengajuan_sppirt.status_ptsp_product','2');
				$query->group_end();
			}
			else{
				$query->where('tb_pengajuan_sppirt.status_verifikasi_product',$status);
			}
		}
		$query->group_start();
			$query->where('tb_pengajuan_sppirt.status_ptsp_product',NULL);
			$query->or_where('tb_pengajuan_sppirt.status_ptsp_product','2');
		$query->group_end();
		
		$query->where('tb_pengajuan_sppirt.status_pengajuan', '2');
		
		// $query->where('status_ptsp_product',NULL);
		$total_data = $query->count_all_results();

		$query = $this->pengajuan_sppirt_model->source();
		$query->select('tb_pengajuan_sppirt.id_pengajuan, tb_pengajuan_sppirt.status_ptsp_product, tb_pengajuan_sppirt.status_verifikasi_label, tb_pengajuan_sppirt.status_verifikasi_product, no_sppirt, nama_jenis_pangan, nama_produk_pangan,nama_kemasan, id_izin,tb_pengajuan_sppirt.created_at as tgl_pengajuan, status_pengajuan, tb_kategori_jenis_pangan.*, no_sppirt_lama, status_no_sppirt, status_sinkronisasi, id_kota, id_prov, tb_user.nib');

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
		if($status!=5){
			if($status==0){
				$query->group_start();
					$query->where('tb_pengajuan_sppirt.status_verifikasi_product','0');
					// $query->where('tb_pengajuan_sppirt.status_ptsp_product !=','0');
				$query->group_end();
			}
			elseif ($status==1) {
				$query->where('tb_pengajuan_sppirt.status_verifikasi_product',$status);
			}
			elseif($status==2){
				$query->group_start();
					$query->where('tb_pengajuan_sppirt.status_ptsp_product !=',NULL);
					$query->where('tb_pengajuan_sppirt.status_ptsp_product','0');
					$query->where('tb_pengajuan_sppirt.status_verifikasi_product !=','1');
				$query->group_end();
			}
			elseif($status==3){
				$query->where('tb_pengajuan_sppirt.status_ptsp_product',NULL);
				$query->group_start();
					$query->where('tb_pengajuan_sppirt.status_verifikasi_product',$status);	
					$query->or_where('tb_pengajuan_sppirt.status_verifikasi_product',NULL);
				$query->group_end();
			}
			elseif($status==4){
				$query->group_start();
					$query->where('tb_pengajuan_sppirt.status_verifikasi_product',NULL);
					$query->where('tb_pengajuan_sppirt.status_ptsp_product','2');
				$query->group_end();
			}
			else{
				$query->where('tb_pengajuan_sppirt.status_verifikasi_product',$status);
			}
		}
		$query->group_start();
			$query->where('tb_pengajuan_sppirt.status_ptsp_product',NULL);
			$query->or_where('tb_pengajuan_sppirt.status_ptsp_product','2');
		$query->group_end();
		$query->where('tb_pengajuan_sppirt.status_pengajuan', '2');

		// $query->where('status_ptsp_product',NULL);

	 if(isset($_GET['export']) && $_GET['export']=true){

			if($status == 5 && $id_prov == "" && $id_prov == ""){
				$query->limit($limitExportData,$start);
				$query->order_by('id_pengajuan','ASC'); //sort sebelumnya created_at desc
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

				$this->load->view('backend/verifikasi_produk/export', $data);
			} else {
				$query->order_by('id_pengajuan','ASC'); //sort sebelumnya created_at desc
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

				$this->load->view('backend/verifikasi_produk/export', $data);
			}
		}else{

			$query->limit($limit,$start);
			$query->order_by('id_pengajuan','ASC'); //sort sebelumnya created_at desc
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
			$data['pagination'] = $this->paging_page('backend/verifikasi-produk',$limit,$total_data);
			
			$query = $this->provinsi_model->source();
			$data['provinsi'] = $query->get()->result();

			
			$this->template->load('template/backend', 'backend/verifikasi_produk/list', $data);
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
		$data_notification = array(
			'id'=>$id,
			'type'=>'Verifikasi Produk',
			'status'=>'Pembatalan Disetujui',
			'msg'=>'Pembatalan Disetujui',
		);
		send_notification($data_notification);

		$this->session->set_flashdata("success", "Pembatalan berhasil");
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
		$data_notification = array(
			'id'=>$id,
			'type'=>'Verifikasi Produk',
			'status'=>'Permohonan Pembatalan Ditolak',
			'msg'=>'Permohonan Pembatalan Ditolak',
		);
		send_notification($data_notification);
		
		$this->session->set_flashdata("success", "Pembatalan berhasil ditolak");
		redirect("backend/verifikasi-produk");
	}

	public function verifikasi($id){
		
		$id = strip_tags($id);
		$id_pengajuan = encrypt_decrypt('decrypt', $id);
	
		$this->db->select('tb_pengajuan_sppirt.no_sppirt, tb_pengajuan_sppirt.no_sppirt_lama, tb_pengajuan_sppirt.status_ptsp_product, tb_pengajuan_sppirt.status_verifikasi_product, nama_produk_pangan,nib,tb_input_label_produk.*, tb_kategori_jenis_pangan.*,tb_jenis_pangan.*,tb_input_data_produk.*,tb_pengajuan_sppirt.id_pengajuan as id, tb_jenis_kemasan.nama_kemasan, upload_rancangan')
			->join('tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
			->join('tb_input_label_produk', 'tb_input_label_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
			->join('tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan')
			->join('tb_kategori_jenis_pangan', 'tb_jenis_pangan.id_kategori_jenis_pangan = tb_kategori_jenis_pangan.id_kategori_jenis_pangan')
			->join('tb_jenis_kemasan', 'tb_input_data_produk.id_jenis_kemasan = tb_jenis_kemasan.id_jenis_kemasan')
			->where('tb_pengajuan_sppirt.id_pengajuan', $id_pengajuan);
		$verifikasi = $this->db->get('tb_pengajuan_sppirt')->row_array();

		$query = $this->monitoring_product_model->source();
		$query->where('id_pengajuan',$id_pengajuan);
		$query->group_start();
			$query->or_group_start();
				$query->where('id_analisis_product',2);
				$query->where('hasil_verifikasi',0);
			$query->group_end();
			$query->or_group_start();
				$query->where('id_analisis_product',7);
				$query->where('hasil_verifikasi',0);
			$query->group_end();
		$query->group_end();
		$total_data = $query->count_all_results();

		$data = [
			'title' => 'Verifikasi PIRT',
			'jenis_pangan' => $this->kategori_jenis_pangan_model->list('deleted_at', null),
			'breadcrumb' => breadcrumb('Verifikasi PIRT', 'backend/verifikasi-produk/form-verifikasi-produk'),
			'data' => $verifikasi,
			'perubahan_sppirt' => $total_data,
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

		$id_kategori_jenis_pangan_temp = (empty($verifikasi['id_kategori_jenis_pangan_temp']))?$verifikasi['id_kategori_jenis_pangan']:$verifikasi['id_kategori_jenis_pangan_temp'];

		$query = $this->jenis_pangan_model->source();
		$query->where('id_kategori_jenis_pangan',$id_kategori_jenis_pangan_temp);
		$data['jenis_pangan'] = $query->get()->result();

		$query = $this->jenis_kemasan_model->source();
		$data['jenis_kemasan'] = $query->get()->result();
		

		
		$this->template->load('template/backend', 'backend/verifikasi_produk/form-verifikasi-produk', $data);	

	}

	public function verifikasi_data($id_pengajuan,$hasil_verifikasi,$id_analisis_product){

		$id_pengajuan_org = strip_tags($id_pengajuan);
		$id_pengajuan = encrypt_decrypt('decrypt', $id_pengajuan_org);

		$id_analisis_product = strip_tags($id_analisis_product);
		$id_analisis_product = encrypt_decrypt('decrypt', $id_analisis_product);

		$pambatalan_data = array(
			'status_verifikasi_product'=>"0",
		);
		$this->pengajuan_sppirt_model->update($pambatalan_data,$id_pengajuan,'id_pengajuan');

		$query = $this->monitoring_product_model->source();
		$query->where('id_pengajuan',$id_pengajuan);
		$query->where('id_analisis_product',$id_analisis_product);
		$monitoring_product = $query->get()->row();
		if(isset($monitoring_product->id)){

			$monitoring_data = array(
				'hasil_verifikasi'=>$hasil_verifikasi,
				'is_next'=>1,
			);
			$this->monitoring_product_model->update($monitoring_data,$monitoring_product->id);

		}else{

			$monitoring_data = array(
				'id_pengajuan'=>$id_pengajuan,
				'id_analisis_product'=>$id_analisis_product,
				'hasil_verifikasi'=>$hasil_verifikasi,
				'is_next'=>1,
			);
			$this->monitoring_product_model->insert($monitoring_data);
		}

		$pengajuan_sppirt = $this->pengajuan_sppirt_model->find($id_pengajuan,'id_pengajuan');
		$user = $this->user_model->find($pengajuan_sppirt->id_user,'id_user');

		$this->session->set_flashdata("success", "Verifikasi berhasil");
		redirect("backend/verifikasi-produk/verifikasi/".$id_pengajuan_org);
	}

	public function pengajuan_pembatalan(){

		$id_pengajuan_org = strip_tags($this->input_data['id_pengajuan']);
		$id_pengajuan = encrypt_decrypt('decrypt', $id_pengajuan_org);

		$id_analisis_product = strip_tags($this->input_data['id_analisis_product']);
		$id_analisis_product = encrypt_decrypt('decrypt', $id_analisis_product);

		$pembatalan_data = array(
			'status_verifikasi_product'=>"0",
			'status_ptsp_product'=>"0",
			'alasan_pembatalan'=>$this->input_data['alasan_pembatalan']
		);

		if (!empty($_FILES['rekomendasi_pembatalan']['name'])) {
			$upload_permohonan = $this->cek_permohonan_pembatalan($id_pengajuan);

			if ($upload_permohonan['status'] == 'true') {
				$pembatalan_data['surat_rekomendasi_pembatalan'] = $upload_permohonan['text'];
			}
			else{
				$this->session->set_flashdata("error", $upload_permohonan['text']);
				redirect("backend/verifikasi-produk/verifikasi/".$id_pengajuan_org);
			}
		}

		$this->pengajuan_sppirt_model->update($pembatalan_data,$id_pengajuan,'id_pengajuan');

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

	public function rekomendasi_kategori_jenis_pangan(){

		$id_pengajuan_org = strip_tags($this->input_data['id_pengajuan']);
		$id_pengajuan = encrypt_decrypt('decrypt', $id_pengajuan_org);

		$id_analisis_product = strip_tags($this->input_data['id_analisis_product']);
		$id_analisis_product = encrypt_decrypt('decrypt', $id_analisis_product);

		$pengajuan_sppirt = $this->pengajuan_sppirt_model->find($id_pengajuan,'id_pengajuan');
		$no_sppirt_lama = $pengajuan_sppirt->no_sppirt;

		$user = $this->user_model->find($pengajuan_sppirt->id_user,'id_user');

		$input_data_produk = $this->input_data_produk_model->find($id_pengajuan,'id_pengajuan');
		$id_jenis_kemasan = $input_data_produk->id_jenis_kemasan;

		$id_kategori_jenis_pangan = (int)$input_data_produk->id_kategori_jenis_pangan;
		$id_kategori_jenis_pangan = (strlen($id_kategori_jenis_pangan)<=1)?"0".$id_kategori_jenis_pangan:$id_kategori_jenis_pangan;

		$new_id_kategori_jenis_pangan = (int)$this->input_data['kode_kategori_jenis_pangan'];
		$kode_kategori_jenis_pangan = (strlen($new_id_kategori_jenis_pangan)<=1)?"0".$new_id_kategori_jenis_pangan:$new_id_kategori_jenis_pangan;

		$id_kota = $user->id_kota;

		$produk_ke = (int)$input_data_produk->produk_ke;
		$produk_ke = (strlen($produk_ke)<=1)?"0".$produk_ke:$produk_ke;

		$no_urut_pelaku_usaha = $user->no_urut_pelaku_usaha;

		$year = date('y',strtotime($pengajuan_sppirt->created_at)) + 5;

		$input_data_produk_data = array(
			'id_kategori_jenis_pangan_temp'=>$new_id_kategori_jenis_pangan,
			'id_jenis_kemasan_temp'=>$id_jenis_kemasan,
		);
		$this->input_data_produk_model->update($input_data_produk_data,$id_pengajuan,'id_pengajuan');

		// $no_sppirt = 'P-IRT ' . $id_jenis_kemasan . $kode_kategori_jenis_pangan  . $id_kota . $produk_ke . $no_urut_pelaku_usaha . '-' . $year;

		$verifikasi_data = array(
			'status_verifikasi_product'=>"0",
			// 'status_no_sppirt'=>"1",
			// 'no_sppirt'=>$no_sppirt,
			// 'no_sppirt_lama'=>$no_sppirt_lama,
		);
		$this->pengajuan_sppirt_model->update($verifikasi_data,$id_pengajuan,'id_pengajuan');
		
		$kategori_jenis_pangan = $this->kategori_jenis_pangan_model->find($id_kategori_jenis_pangan,'id_kategori_jenis_pangan');
		$nama_kategori_jenis_pangan_lama = isset($kategori_jenis_pangan->nama_kategori_jenis_pangan)?$kategori_jenis_pangan->nama_kategori_jenis_pangan:'';

		$kategori_jenis_pangan = $this->kategori_jenis_pangan_model->find($new_id_kategori_jenis_pangan,'id_kategori_jenis_pangan');
		$nama_kategori_kategori_jenis_pangan_baru = isset($kategori_jenis_pangan->nama_kategori_jenis_pangan)?$kategori_jenis_pangan->nama_kategori_jenis_pangan:'';

		$query = $this->monitoring_product_model->source();
		$query->where('id_pengajuan',$id_pengajuan);
		$query->where('id_analisis_product',$id_analisis_product);
		$monitoring_product = $query->get()->row();
		if(isset($monitoring_product->id)){

			$monitoring_data = array(
				'hasil_verifikasi'=>0,
				'is_next'=>1,
				'id_from'=>$id_kategori_jenis_pangan,
				'id_to'=>$new_id_kategori_jenis_pangan,
				'change_type'=>'KATEGORI JENIS PANGAN',
				'notes'=>'PERUBAHAN KATEGORY JENIS PANGAN dari '.$nama_kategori_jenis_pangan_lama.' menjadi '.$nama_kategori_kategori_jenis_pangan_baru,
			);
			$this->monitoring_product_model->update($monitoring_data,$monitoring_product->id);

		}else{

			$monitoring_data = array(
				'id_pengajuan'=>$id_pengajuan,
				'id_analisis_product'=>$id_analisis_product,
				'hasil_verifikasi'=>0,
				'is_next'=>1,
				'id_from'=>$id_kategori_jenis_pangan,
				'id_to'=>$new_id_kategori_jenis_pangan,
				'change_type'=>'KATEGORI JENIS PANGAN',
				'notes'=>'PERUBAHAN KATEGORY JENIS PANGAN dari '.$nama_kategori_jenis_pangan_lama.' menjadi '.$nama_kategori_kategori_jenis_pangan_baru,
			);
			$this->monitoring_product_model->insert($monitoring_data);
		}

		$this->session->set_flashdata("success", "Berhasil merekomendasi perubahan kategori jenis pangan");
		redirect("backend/verifikasi-produk/verifikasi/".$id_pengajuan_org);

	}

	public function rekomendasi_jenis_pangan(){

		$id_pengajuan_org = strip_tags($this->input_data['id_pengajuan']);
		$id_pengajuan = encrypt_decrypt('decrypt', $id_pengajuan_org);

		$id_analisis_product = strip_tags($this->input_data['id_analisis_product']);
		$id_analisis_product = encrypt_decrypt('decrypt', $id_analisis_product);

		$input_data_produk = $this->input_data_produk_model->find($id_pengajuan,'id_pengajuan');
		$id_jenis_pangan = $input_data_produk->id_jenis_pangan;

		$new_id_jenis_pangan = (int)$this->input_data['id_jenis_pangan'];
	
		$verifikasi_data = array(
			'status_verifikasi_product'=>"0",
		);
		$this->pengajuan_sppirt_model->update($verifikasi_data,$id_pengajuan,'id_pengajuan');

		$input_data_produk_data = array(
			'id_jenis_pangan'=>$new_id_jenis_pangan,
		);
		$this->input_data_produk_model->update($input_data_produk_data,$id_pengajuan,'id_pengajuan');

		$jenis_pangan = $this->jenis_pangan_model->find($id_jenis_pangan,'id_jenis_pangan');
		$nama_jenis_pangan_lama = isset($jenis_pangan->nama_jenis_pangan)?$jenis_pangan->nama_jenis_pangan:'';

		$jenis_pangan = $this->jenis_pangan_model->find($new_id_jenis_pangan,'id_jenis_pangan');
		$nama_jenis_pangan_baru = isset($jenis_pangan->nama_jenis_pangan)?$jenis_pangan->nama_jenis_pangan:'';

		$query = $this->monitoring_product_model->source();
		$query->where('id_pengajuan',$id_pengajuan);
		$query->where('id_analisis_product',$id_analisis_product);
		$monitoring_product = $query->get()->row();
		if(isset($monitoring_product->id)){

			$monitoring_data = array(
				'hasil_verifikasi'=>0,
				'is_next'=>1,
				'id_from'=>$id_jenis_pangan,
				'id_to'=>$new_id_jenis_pangan,
				'change_type'=>'JENIS PANGAN',
				'notes'=>'PERUBAHAN JENIS PANGAN dari '.$nama_jenis_pangan_lama.' menjadi '.$nama_jenis_pangan_baru,
			);
			$this->monitoring_product_model->update($monitoring_data,$monitoring_product->id);

		}else{

			$monitoring_data = array(
				'id_pengajuan'=>$id_pengajuan,
				'id_analisis_product'=>$id_analisis_product,
				'hasil_verifikasi'=>0,
				'is_next'=>1,
				'id_from'=>$id_jenis_pangan,
				'id_to'=>$new_id_jenis_pangan,
				'change_type'=>'JENIS PANGAN',
				'notes'=>'PERUBAHAN JENIS PANGAN dari '.$nama_jenis_pangan_lama.' menjadi '.$nama_jenis_pangan_baru,
			);
			$this->monitoring_product_model->insert($monitoring_data);
		}
		
		$this->session->set_flashdata("success", "Berhasil merekomendasi perubahan jenis pangan");
		redirect("backend/verifikasi-produk/verifikasi/".$id_pengajuan_org);

	}

	public function rekomendasi_jumlah_btp(){

		$id_pengajuan_org = strip_tags($this->input_data['id_pengajuan']);
		$id_pengajuan = encrypt_decrypt('decrypt', $id_pengajuan_org);

		$id_analisis_product = strip_tags($this->input_data['id_analisis_product']);
		$id_analisis_product = encrypt_decrypt('decrypt', $id_analisis_product);

		$query = $this->monitoring_product_model->source();
		$query->where('id_pengajuan',$id_pengajuan);
		$query->where('id_analisis_product',$id_analisis_product);
		$monitoring_product = $query->get()->row();
		if(isset($monitoring_product->id)){

			$monitoring_data = array(
				'hasil_verifikasi'=>1,
				'is_next'=>1,
				'notes'=>$this->input_data['notes'],
			);
			$this->monitoring_product_model->update($monitoring_data,$monitoring_product->id);

		}else{

			$monitoring_data = array(
				'id_pengajuan'=>$id_pengajuan,
				'id_analisis_product'=>$id_analisis_product,
				'hasil_verifikasi'=>1,
				'is_next'=>1,
				'notes'=>$this->input_data['notes'],
			);
			$this->monitoring_product_model->insert($monitoring_data);
		}

		$pengajuan_sppirt = $this->pengajuan_sppirt_model->find($id_pengajuan,'id_pengajuan');
		$user = $this->user_model->find($pengajuan_sppirt->id_user,'id_user');

		if(isset($user->no_telp) && $user->no_telp!="" && $user->no_telp!=NULL){

			//// SEND NOTIFICATION ///
			//$data_wa = array(
	        //    "phone"=>$user->no_telp,
	        //    "msg"=>"test"
	        //);
	        //send_wa($data_wa);

		}

		$this->session->set_flashdata("success", "Berhasil merekomendasi jumlah BTP");
		redirect("backend/verifikasi-produk/verifikasi/".$id_pengajuan_org);
	}

	public function rekomendasi_jenis_kemasan(){

		$id_pengajuan_org = strip_tags($this->input_data['id_pengajuan']);
		$id_pengajuan = encrypt_decrypt('decrypt', $id_pengajuan_org);

		$id_analisis_product = strip_tags($this->input_data['id_analisis_product']);
		$id_analisis_product = encrypt_decrypt('decrypt', $id_analisis_product);

		$pengajuan_sppirt = $this->pengajuan_sppirt_model->find($id_pengajuan,'id_pengajuan');
		$no_sppirt_lama = $pengajuan_sppirt->no_sppirt;

		$user = $this->user_model->find($pengajuan_sppirt->id_user,'id_user');

		$input_data_produk = $this->input_data_produk_model->find($id_pengajuan,'id_pengajuan');
		$id_jenis_kemasan = $input_data_produk->id_jenis_kemasan;

		$new_id_jenis_kemasan = (int)$this->input_data['id_jenis_kemasan'];

		$id_kategori_jenis_pangan = (int)$input_data_produk->id_kategori_jenis_pangan;
		$kode_kategori_jenis_pangan = (strlen($id_kategori_jenis_pangan)<=1)?"0".$id_kategori_jenis_pangan:$id_kategori_jenis_pangan;

		$id_kota = $user->id_kota;

		$produk_ke = (int)$input_data_produk->produk_ke;
		$produk_ke = (strlen($produk_ke)<=1)?"0".$produk_ke:$produk_ke;

		$no_urut_pelaku_usaha = $user->no_urut_pelaku_usaha;

		$id_kategori_jenis_pangan_temp = (isset($input_data_produk->id_kategori_jenis_pangan_temp) && $input_data_produk->id_kategori_jenis_pangan_temp!=NULL && $input_data_produk->id_kategori_jenis_pangan_temp!="")?$input_data_produk->id_kategori_jenis_pangan_temp:$input_data_produk->id_kategori_jenis_pangan;

		$input_data_produk_data = array(
			'id_kategori_jenis_pangan_temp'=>$id_kategori_jenis_pangan_temp,
			'id_jenis_kemasan_temp'=>$new_id_jenis_kemasan,
		);
		$this->input_data_produk_model->update($input_data_produk_data,$id_pengajuan,'id_pengajuan');

		// $year = date('y') + 5;
		// $no_sppirt = 'P-IRT ' . $new_id_jenis_kemasan . $kode_kategori_jenis_pangan  . $id_kota . $produk_ke . $no_urut_pelaku_usaha . '-' . $year;

		$verifikasi_data = array(
			'status_verifikasi_product'=>"0",
			// 'status_no_sppirt'=>"1",
			// 'no_sppirt'=>$no_sppirt,
			// 'no_sppirt_lama'=>$no_sppirt_lama,
		);
		$this->pengajuan_sppirt_model->update($verifikasi_data,$id_pengajuan,'id_pengajuan');

		$jenis_kemasan = $this->jenis_kemasan_model->find($id_jenis_kemasan,'id_jenis_kemasan');
		$nama_kemasan = isset($jenis_kemasan->nama_kemasan)?$jenis_kemasan->nama_kemasan:'';

		$jenis_kemasan = $this->jenis_kemasan_model->find($new_id_jenis_kemasan,'id_jenis_kemasan');
		$nama_kemasan_baru = isset($jenis_kemasan->nama_kemasan)?$jenis_kemasan->nama_kemasan:'';

		$query = $this->monitoring_product_model->source();
		$query->where('id_pengajuan',$id_pengajuan);
		$query->where('id_analisis_product',$id_analisis_product);
		$monitoring_product = $query->get()->row();
		if(isset($monitoring_product->id)){

			$monitoring_data = array(
				'hasil_verifikasi'=>0,
				'is_next'=>1,
				'id_from'=>$id_jenis_kemasan,
				'id_to'=>$new_id_jenis_kemasan,
				'change_type'=>'JENIS KEMASAN',
				'notes'=>'PERUBAHAN JENIS KEMASAN dari '.$nama_kemasan.' menjadi '.$nama_kemasan_baru,
			);
			$this->monitoring_product_model->update($monitoring_data,$monitoring_product->id);

		}else{

			$monitoring_data = array(
				'id_pengajuan'=>$id_pengajuan,
				'id_analisis_product'=>$id_analisis_product,
				'hasil_verifikasi'=>0,
				'is_next'=>1,
				'id_from'=>$id_jenis_kemasan,
				'id_to'=>$new_id_jenis_kemasan,
				'change_type'=>'JENIS KEMASAN',
				'notes'=>'PERUBAHAN JENIS KEMASAN dari '.$nama_kemasan.' menjadi '.$nama_kemasan_baru,
			);
			$this->monitoring_product_model->insert($monitoring_data);
		}

		$pengajuan_sppirt = $this->pengajuan_sppirt_model->find($id_pengajuan,'id_pengajuan');
		$user = $this->user_model->find($pengajuan_sppirt->id_user,'id_user');

		if(isset($user->no_telp) && $user->no_telp!="" && $user->no_telp!=NULL){

			//// SEND NOTIFICATION ///
			//$data_wa = array(
	        //    "phone"=>$user->no_telp,
	        //    "msg"=>"test"
	        //);
	        //send_wa($data_wa);

		}

		$this->session->set_flashdata("success", "Berhasil merekomendasi perubahan jenis kemasan");
		redirect("backend/verifikasi-produk/verifikasi/".$id_pengajuan_org);

	}

	public function pemenuhan_komitmen($id){

		$id = strip_tags($id);
		$id = encrypt_decrypt('decrypt', $id);

		$pengajuan_sppirt = $this->pengajuan_sppirt_model->find($id,'id_pengajuan');
		$no_sppirt_lama = $pengajuan_sppirt->no_sppirt;

		$user = $this->user_model->find($pengajuan_sppirt->id_user,'id_user');

		$input_data_produk = $this->input_data_produk_model->find($id,'id_pengajuan');
		$new_id_jenis_kemasan = empty($input_data_produk->id_jenis_kemasan_temp)?(int)$input_data_produk->id_jenis_kemasan:(int)$input_data_produk->id_jenis_kemasan_temp;

		$kode_kategori_jenis_pangan = empty($input_data_produk->id_kategori_jenis_pangan_temp)?(int)$input_data_produk->id_kategori_jenis_pangan:(int)$input_data_produk->id_kategori_jenis_pangan_temp;
		$kode_kategori_jenis_pangan = (strlen($kode_kategori_jenis_pangan)<=1)?"0".$kode_kategori_jenis_pangan:$kode_kategori_jenis_pangan;

		$id_kota = $user->id_kota;

		$produk_ke = (int)$input_data_produk->produk_ke;
		$produk_ke = (strlen($produk_ke)<=1)?"0".$produk_ke:$produk_ke;

		$no_urut_pelaku_usaha = $user->no_urut_pelaku_usaha;

		$year = date('y',strtotime($pengajuan_sppirt->created_at)) + 5;
		$no_sppirt = 'P-IRT ' . $new_id_jenis_kemasan . $kode_kategori_jenis_pangan  . $id_kota . $produk_ke . $no_urut_pelaku_usaha . '-' . $year;

		$pambatalan_data = array(
			'status_verifikasi_product'=>"1",
			'status_no_sppirt'=>"1",
			'no_sppirt'=>$no_sppirt,
			'no_sppirt_lama'=>$no_sppirt_lama,
		);
		$this->pengajuan_sppirt_model->update($pambatalan_data,$id,'id_pengajuan');

	    //// SEND NOTIFICATION ///
		$data_notification = array(
			'id'=>$id_pengajuan,
			'type'=>'Verifikasi Produk',
			'status'=>'Pemenuhan Komitmen',
			'msg'=>'Pemenuhan Komitmen',
		);
		send_notification($data_notification);
		
		$this->session->set_flashdata("success", "Pemenuhan komitmen berhasil");
		redirect("backend/verifikasi-produk");
	}

	public function upload_rekomendasi_pembatalan(){
		$id_pengajuan_org = strip_tags($this->input_data['id_pengajuan']);
		$id_pengajuan = encrypt_decrypt('decrypt', $id_pengajuan_org);

		if (!empty($_FILES['rekomendasi_pembatalan']['name'])) {
			$upload_permohonan = $this->cek_permohonan_pembatalan($id_pengajuan);

			if ($upload_permohonan['status'] == 'true') {
				$pembatalan_data['surat_rekomendasi_pembatalan'] = $upload_permohonan['text'];
			}
			else{
				$this->session->set_flashdata("error", $upload_permohonan['text']);
				redirect("backend/verifikasi-produk/verifikasi/".$id_pengajuan_org);
			}

			$this->pengajuan_sppirt_model->update($pembatalan_data,$id_pengajuan,'id_pengajuan');
		}

		$this->session->set_flashdata("success", "Surat rekomendasi pembatalan berhasil disimpan");
		redirect("backend/permohonan-pembatalan");
	}

	private function cek_permohonan_pembatalan($id_pengajuan){
		$this->load->helper('string');
		$random = random_string('alnum', 4);
		$config = [
			'file_name' => 'Surat-Rekomendasi-Pembatalan-' . date('d-m-Y') . '-' . $random,
			'upload_path' => './uploads/verifikasiproduk/surat_rekomendasi_pembatalan',
			'allowed_types' => 'pdf|doc|docx',
			'max_size' => '10000',
			'encrypt_name' => true,
		];

		$this->load->library('upload', $config);

		$response = array();
		$cek = $this->db->get_where('tb_pengajuan_sppirt', ['id_pengajuan' => $id_pengajuan])->row_array();

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
					unlink(FCPATH . './uploads/verifikasiproduk/surat_rekomendasi_pembatalan/' . $cek['surat_rekomendasi_pembatalan']);
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



}
