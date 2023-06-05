<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		cekLogin();
		$this->load->model('Datatable_Model');
		$this->kategori_jenis_pangan_model = new GeneralModel("tb_kategori_jenis_pangan");
$this->provinsi_model = new GeneralModel("tb_provinsi");
		$this->kab_kota_model = new GeneralModel("tb_kota");
	}

	public function index($page = null)
	{
		$data = [
			'title' => 'Monitoring IRTP '. ucwords($page),
			'breadcrumb' => breadcrumb('Monitoring PIRT '. ucwords($page), 'backend/Monitoring')
		];
		$this->template->load('template/backend', 'backend/monitoring/'.$page, $data);	
	}

	var $column_order = [null, 'no_sppirt', 'tb_pengajuan_sppirt.created_at', 'nama_produk_pangan', 'nama_jenis_pangan', 'nama_kemasan', 'id_izin', 'status_verifikasi'];
	var $column_search = ['no_sppirt', 'tb_pengajuan_sppirt.created_at', 'nama_produk_pangan', 'nama_jenis_pangan', 'nama_kemasan', 'id_izin', 'status_verifikasi'];
	var $order = ['tb_pengajuan_sppirt.created_at' => 'DESC'];

	function getData($jenis = null)
	{
		$id_role = $this->session->userdata('userData')['id_role'];
		$id_kota = $this->session->userdata('userData')['id_kota'];
		$id_prov = $this->session->userdata('userData')['id_prov'];

		$status = $this->input->post('status', true);
		$jenis = $this->input->post('jenis', true);



		// var_dump($id_role);
		$where = ['status_pengajuan >=' => "2"];
		if ($status == "3") {
			if($jenis=='produk'){
				$where['status_verifikasi_product'] = NULL;
			}else{
				$where['status_verifikasi_label'] = NULL;
			}
		}else if ($status == "0" || $status == "1") {
			if($jenis=='produk'){
				$where['status_verifikasi_product'] = $status;
			}else{
				$where['status_verifikasi_label'] = $status;
			}
		}
		// var_dump($where);die;
		if ($id_role == 3) $where['id_kota'] = $id_kota;
		if ($id_role == 4) $where['id_kota'] = $id_kota;
		if ($id_role == 5) $where['id_prov'] = $id_prov;

		if ($jenis == 'produk') $join = ['tb_verifikasi_produk', 'tb_verifikasi_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'left'];
		if ($jenis == 'label') $join = ['tb_verifikasi_label', 'tb_verifikasi_label.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'left'];
		if ($jenis == 'pkp') $join = ['tb_verifikasi_pkp', 'tb_verifikasi_pkp.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'left'];
		if ($jenis == 'pembuatan') $join = ['tb_verifikasi_cara_pembuatan', 'tb_verifikasi_cara_pembuatan.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'left'];

		$query = [
			'table' => 'tb_pengajuan_sppirt',
			'select' => 'tb_pengajuan_sppirt.id_pengajuan, tb_pengajuan_sppirt.status_verifikasi_label, tb_pengajuan_sppirt.status_verifikasi_product, no_sppirt, nama_jenis_pangan, nama_produk_pangan,nama_kemasan, id_izin,tb_pengajuan_sppirt.created_at as tgl_pengajuan, status_pengajuan, tb_kategori_jenis_pangan.*, no_sppirt_lama, status_no_sppirt, status_sinkronisasi, id_kota, id_prov, tb_user.nib',
			'where' => $where,
			'join' => [
				['tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'inner'],
				['tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan', 'inner'],
				['tb_kategori_jenis_pangan', 'tb_kategori_jenis_pangan.id_kategori_jenis_pangan = tb_jenis_pangan.id_kategori_jenis_pangan', 'inner'],
				['tb_jenis_kemasan', 'tb_jenis_kemasan.id_jenis_kemasan = tb_input_data_produk.id_jenis_kemasan', 'inner'],
				['tb_user', 'tb_user.id_user = tb_pengajuan_sppirt.id_user', 'INNER'],
				// $join
			]
		];

		$sppirt = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);	
		// var_dump($this->db->last_query());die;
		// var_dump($sppirt);die;
		$data = [];
		$no = @$_POST['start'];
		foreach ($sppirt as $irtp) {

			if($jenis=='produk'){
				$irtp->status_verifikasi = $irtp->status_verifikasi_product;
			}else{
				$irtp->status_verifikasi = $irtp->status_verifikasi_label;
			}

			//$tgl_berlaku_izin = date('d-m-Y', strtotime('+5 years', strtotime($irtp->created_at)));
			//$tgl_prengajuan = date('d-m-Y', strtotime($irtp->created_at));
			$tgl_berlaku_izin = date('d-m-Y', strtotime('+5 years', strtotime($irtp->tgl_pengajuan)));
			$tgl_prengajuan = date('d-m-Y', strtotime($irtp->tgl_pengajuan));

				$provinsi = $this->provinsi_model->find($irtp->id_prov,'id_prov');
				$nama_prov = isset($provinsi->nama_prov)?$provinsi->nama_prov:'';

				$kab_kota = $this->kab_kota_model->find($irtp->id_kota,'id_kota');
				$nama_kota = isset($kab_kota->nama_kota)?$kab_kota->nama_kota:'';

				$no++;
				$row = [];
				$row[] = $no . ".";
				if($irtp->status_no_sppirt==1){
						$button_riwayat = "<a href='javascript:void(0)' onclick='openmodal(`".$irtp->no_sppirt."`,`".$irtp->no_sppirt_lama."`)' style='color:#008FC3'> Lihat riwayat</a><br>";
						$status_no_sppirt = '<br><button type="button" class="badge badge-danger">BERUBAH</button><br>'.$button_riwayat;
					}else{
						$status_no_sppirt = '';
					}

					$row[] = $irtp->no_sppirt.''.$status_no_sppirt.'<br>Masa Berlaku:<br> <i><font color="purple">'.$tgl_berlaku_izin. '</font></i>';
				$row[] = $irtp->nama_produk_pangan;

				$row[] = '<b>Kategori:</b> <i>'.$irtp->nama_kategori_jenis_pangan.'</i><br><b>Jenis:</b> <i>'.$irtp->nama_jenis_pangan.'</i><br><b>Kemasan:</b> <i>'.$irtp->nama_kemasan. '</i>';

				$row[] = $nama_prov.'<br>'.$nama_kota;

				$row[] = $irtp->nib;
				$row[] = $tgl_prengajuan;
				if ($irtp->status_sinkronisasi == 1) {
						$status_sinkronisasi = '<button type="button" class="badge badge-success">TERKIRIM OSS</button>';
					} else {
						$status_sinkronisasi = '<button type="button" class="badge badge-warning">BELUM TERKIRIM OSS</button>';
					}
				$row[] = $irtp->id_izin."<br>".$status_sinkronisasi;
			if ($jenis == 'produk') $link = base_url('backend/pengawasan/verifikasi-produk/'.encrypt_decrypt('encrypt',$irtp->id_pengajuan));
			if ($jenis == 'label') $link = base_url('backend/pengawasan/verifikasi-label/'.encrypt_decrypt('encrypt',$irtp->id_pengajuan));
			if ($jenis == 'pkp') $link = base_url('backend/pengawasan/verifikasi-pkp/'.encrypt_decrypt('encrypt',$irtp->id_pengajuan));
			if ($jenis == 'pembuatan') $link = base_url('backend/pengawasan/verifikasi-cara-pembuatan/'.encrypt_decrypt('encrypt',$irtp->id_pengajuan));
			if ($irtp->status_verifikasi == '0') {
				$row[] = '<a href="'.$link.'" target="_blank" class="btn btn-warning btn-xs">Verifikasi Belum Lengkap</a>';
			}else if ($irtp->status_verifikasi == '1') {
				$row[] = '<a href="'.$link.'" target="_blank" class="btn btn-success btn-xs">Sudah Diverifikasi</a>';
			}else{
				$row[] = '<a href="'.$link.'" target="_blank" class="btn btn-primary btn-xs">Menunggu Diverifikasi</a>';
			}


			$data[] = $row;
		}
		$output = [
			'draw' => @$_POST['draw'],
			'recordsTotal' => $this->Datatable_Model->countAll($query),
			'recordsFiltered' => $this->Datatable_Model->countFilters($query, $this->column_order, $this->column_search, $this->order),
			'data' => $data,
		];


		echo json_encode($output);
	}

}

/* End of file Monitoring.php */
/* Location: ./application/controllers/backend/Monitoring.php */