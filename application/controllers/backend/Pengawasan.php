<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengawasan extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		cekLogin();
		$this->load->model('Datatable_Model');
		$this->kategori_jenis_pangan_model = new GeneralModel("tb_kategori_jenis_pangan");
		$this->provinsi_model = new GeneralModel("tb_provinsi");
		$this->kab_kota_model = new GeneralModel("tb_kota");
	}

	public function index($jenis = null)
	{

		$data = [
			'title' => 'Pengawasan IRTP',
			'breadcrumb' => breadcrumb('Pengawasan PIRT', 'backend/Pengawasan')
		];
		$this->template->load('template/backend', 'backend/pengawasan/index', $data);	
	}

	var $column_order = [null, 'no_sppirt', 'tb_pengajuan_sppirt.created_at', 'nama_produk_pangan', 'nama_jenis_pangan', 'nama_kemasan', 'id_izin'];
	var $column_search = ['no_sppirt', 'tb_pengajuan_sppirt.created_at', 'nama_produk_pangan', 'nama_jenis_pangan', 'nama_kemasan', 'id_izin'];
	var $order = ['tb_pengajuan_sppirt.created_at' => 'DESC'];

	function getData($jenis = null)
	{
		$id_role = $this->session->userdata('userData')['id_role'];
		$id_kota = $this->session->userdata('userData')['id_kota'];
		$id_prov = $this->session->userdata('userData')['id_prov'];

		// var_dump($id_role);
		$where = ['status_pengajuan >=' => "2"];
		if ($id_role == 3) $where['id_kota'] = $id_kota;
		if ($id_role == 4) $where['id_kota'] = $id_kota;
		if ($id_role == 5) $where['id_prov'] = $id_prov;

		$query = [
			'table' => 'tb_pengajuan_sppirt',
			'select' => 'tb_pengajuan_sppirt.id_pengajuan,status_no_sppirt,no_sppirt_lama, no_sppirt, status_sinkronisasi,nama_jenis_pangan, nama_produk_pangan,nama_kemasan, id_izin,tb_pengajuan_sppirt.created_at as tgl_pengajuan, status_pengajuan,tb_verifikasi_pkp.status_verifikasi as verifikasi_pkp, tb_verifikasi_label.status_verifikasi as verifikasi_label, tb_verifikasi_produk.status_verifikasi as verifikasi_produk, tb_verifikasi_cara_pembuatan.status_verifikasi as verifikasi_cara_pembuatan, tb_user.*, tb_kategori_jenis_pangan.*, tb_penyimpanan.*',
			'where' => $where,
			'join' => [
				['tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'inner'],
				['tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan', 'inner'],
				['tb_kategori_jenis_pangan', 'tb_kategori_jenis_pangan.id_kategori_jenis_pangan = tb_jenis_pangan.id_kategori_jenis_pangan', 'inner'],
				['tb_jenis_kemasan', 'tb_jenis_kemasan.id_jenis_kemasan = tb_input_data_produk.id_jenis_kemasan', 'inner'],
				['tb_penyimpanan', 'tb_penyimpanan.id_penyimpanan = tb_input_data_produk.id_penyimpanan', 'inner'],
				['tb_verifikasi_produk', 'tb_verifikasi_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'left'],
				['tb_verifikasi_label', 'tb_verifikasi_label.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'left'],
				['tb_verifikasi_pkp', 'tb_verifikasi_pkp.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'left'],
				['tb_verifikasi_cara_pembuatan', 'tb_verifikasi_cara_pembuatan.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'left'],
				['tb_user', 'tb_user.id_user = tb_pengajuan_sppirt.id_user', 'RIGHT']
			]
		];

		$sppirt = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);	
		// var_dump($this->db->last_query());die;
		//var_dump($sppirt);die;
		$data = [];
		$no = @$_POST['start'];
		foreach ($sppirt as $irtp) {
			$tgl_berlaku_izin = date('d-m-Y', strtotime('+5 years', strtotime($irtp->tgl_pengajuan)));
			$tgl_prengajuan = date('d-m-Y', strtotime($irtp->tgl_pengajuan));
				//$tgl_prengajuan = date('d-m-Y', strtotime($irtp->created_at));

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

				$row[] = '<b>Kategori:</b> <i>'.$irtp->nama_kategori_jenis_pangan.'</i><br><b>Jenis:</b> <i>'.$irtp->nama_jenis_pangan.'</i><br><b>Kemasan:</b> <i>'.$irtp->nama_kemasan. '</i> <br><b>Cara Penyimpanan : </b><i>'.$irtp->cara_penyimpanan. '</i>';

				$row[] = $nama_prov.'<br>'.$nama_kota;

				$row[] = $irtp->nib;
				$row[] = $tgl_prengajuan;
				if ($irtp->status_sinkronisasi == 1) {
						$status_sinkronisasi = '<button type="button" class="badge badge-success">TERKIRIM OSS</button>';
					} else {
						$status_sinkronisasi = '<button type="button" class="badge badge-warning">BELUM TERKIRIM OSS</button>';
					}
				$row[] = $irtp->id_izin."<br>".$status_sinkronisasi;
			if ($irtp->status_pengajuan == 2) {
				$row[] = '<button type="button" class="btn btn-primary btn-xs" onclick="ButtonDetailStatus(this)" data-id="'.encrypt_decrypt("encrypt", $irtp->id_pengajuan).'">Lihat Status</button>';
			}else if ($irtp->status_pengajuan == 3) {
				$row[] = '<button type="button" class="btn btn-warning btn-xs">Menunggu PTSP</button>';
			}else{
				$row[] = '<button type="button" class="btn btn-danger btn-xs" onclick="ButtonDetailStatus(this)" data-id="'.encrypt_decrypt("encrypt", $irtp->id_pengajuan).'">Dibatalkan</button>';
			}
			// if ($irtp->id_verifikasi_produk) {
			// 	$row[] = '<a href="'.base_url('backend/pengawasan/verifikasi-produk/').encrypt_decrypt("encrypt",$irtp->no_sppirt).'" class="btn btn-xs btn-success" onclick="return false;" title="Sudah Diverifikasi"><span class="fa fa-check"></span> Sudah Diverifikasi</a>';
			// }else{
			// 	$row[] = '<a href="'.base_url('backend/pengawasan/verifikasi-produk/').encrypt_decrypt("encrypt",$irtp->no_sppirt).'" class="btn btn-xs btn-primary"><span class="fa fa-clock-o"></span> Menunggu Verifikasi</a>';
			// }

			// if ($irtp->id_verifikasi_label) {
			// 	$row[] = '<a href="'.base_url('backend/pengawasan/verifikasi-label/').encrypt_decrypt("encrypt",$irtp->no_sppirt).'"  class="btn btn-xs btn-success" onclick="return false;" title="Sudah Diverifikasi" ><span class="fa fa-check"></span> Sudah Diverifikasi</a>';
			// }else{
			// 	$row[] = '<a href="'.base_url('backend/pengawasan/verifikasi-label/').encrypt_decrypt("encrypt",$irtp->no_sppirt).'"  class="btn btn-xs btn-primary"><span class="fa fa-clock-o"></span> Menunggu Verifikasi</a>';
			// }

			// if ($irtp->id_verifikasi_pkp) {
			// 	$row[] = '<a href="'.base_url('backend/pengawasan/verifikasi-pkp/').encrypt_decrypt("encrypt",$irtp->no_sppirt).'" class="btn btn-xs btn-success" onclick="return false"><span class="fa fa-check"></span> Sudak Diverifikasi</a>';
			// }else{
			// 	$row[] = '<a href="'.base_url('backend/pengawasan/verifikasi-pkp/').encrypt_decrypt("encrypt",$irtp->no_sppirt).'" class="btn btn-xs btn-primary"><span class="fa fa-clock-o"></span> Menunggu Verifikasi</a>';
			// }

			// if ($irtp->id_verifikasi_cara_pembuatan) {
			// 	$row[] = '<a href="'.base_url('backend/pengawasan/verifikasi-cara-pembuatan/').encrypt_decrypt("encrypt",$irtp->no_sppirt).'" class="btn btn-xs btn-success" onclick="return false"><span class="fa fa-check"></span> Sudah Diverifikasi</a>';
			// }else{
			// 	$row[] = '<a href="'.base_url('backend/pengawasan/verifikasi-cara-pembuatan/').encrypt_decrypt("encrypt",$irtp->no_sppirt).'" class="btn btn-xs btn-primary"><span class="fa fa-clock-o"></span> Menunggu Verifikasi</a>';
			// }

			// $row[] = '<button type="button" class="btn btn-sm btn-primary">Verifikasi Data Pangan</button>';
			// $row[] = '<button type="button" class="btn btn-sm btn-info">Verifikasi Data Label</button>';
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


	function getRowData($id)
	{
		$id_pengajuan = encrypt_decrypt('decrypt', $id);
		$this->db->select('tb_pengajuan_sppirt.id_pengajuan, no_sppirt, tb_verifikasi_pkp.status_verifikasi as pkp, tb_verifikasi_label.status_verifikasi as label, tb_verifikasi_produk.status_verifikasi as produk, tb_verifikasi_cara_pembuatan.status_verifikasi as cara_pembuatan')
			->join('tb_verifikasi_pkp', 'tb_verifikasi_pkp.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan','left')
			->join('tb_verifikasi_label', 'tb_verifikasi_label.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan','left')
			->join('tb_verifikasi_produk', 'tb_verifikasi_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan','left')
			->join('tb_verifikasi_cara_pembuatan', 'tb_verifikasi_cara_pembuatan.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan','left')
			->where('tb_pengajuan_sppirt.id_pengajuan', $id_pengajuan);
		$irtp = $this->db->get('tb_pengajuan_sppirt')->row_array();
		$irtp['id_pengajuan'] = encrypt_decrypt("encrypt",$irtp['id_pengajuan']);

		echo json_encode($irtp);
	}


	function verifikasi()
	{
		$jenis = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$id_pengajuan = encrypt_decrypt('decrypt', $id);
		if ($jenis == 'verifikasi-produk') $table = 'tb_verifikasi_produk' ;
		if ($jenis == 'verifikasi-label') $table = 'tb_verifikasi_label' ;
		if ($jenis == 'verifikasi-pkp') $table = 'tb_verifikasi_pkp' ;
		if ($jenis == 'verifikasi-cara-pembuatan') $table = 'tb_verifikasi_cara_pembuatan' ;

		$this->db->select('tb_pengajuan_sppirt.no_sppirt, nama_produk_pangan,tb_pengajuan_sppirt.nib,tb_input_label_produk.*, tb_kategori_jenis_pangan.*,tb_jenis_pangan.*,tb_input_data_produk.*,tb_pengajuan_sppirt.id_pengajuan as id, upload_rancangan,'.$table.'.*')
			->join($table, 'tb_pengajuan_sppirt.id_pengajuan = '.$table.'.id_pengajuan', 'LEFT')
			->join('tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
			->join('tb_input_label_produk', 'tb_input_label_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
			->join('tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan')
			->join('tb_kategori_jenis_pangan', 'tb_jenis_pangan.id_kategori_jenis_pangan = tb_kategori_jenis_pangan.id_kategori_jenis_pangan')
			->where('tb_pengajuan_sppirt.id_pengajuan', $id_pengajuan);
		$verifikasi = $this->db->get('tb_pengajuan_sppirt')->row_array();
		// $fieds = $this->db->list_fields('tb_verifikasi');
		// $verifikasi = ['no_sppirt' => $irtp['no_sppirt']];
		// foreach ($fieds as $key) {
		// 	if ($key != 'id_verifikasi' && $key != 'created_at' && $key != 'updated_at' && $key != 'deleted_at') {
		// 		$verifikasi[$key] = explode(";", $irtp[$key]);
		// 	}
		// }
		$data = [
			'title' => 'Verifikasi PIRT',
			'jenis_pangan' => $this->kategori_jenis_pangan_model->list('deleted_at', null),
			'breadcrumb' => breadcrumb('Verifikasi PIRT', 'backend/pengawasan/'.$jenis.'/'.$id),
			'data' => $verifikasi
		];
		$this->template->load('template/backend', 'backend/pengawasan/'.$jenis, $data);	
	}

	function cek_upload()
	{
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
		if ($this->input->post('status') == 0) {
			$cek = $this->db->get_where('tb_verifikasi_cara_pembuatan', ['id_pengajuan' => encrypt_decrypt("decrypt",$this->input->post('id_pengajuan'))])->row_array();

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
		// var_dump($response);die;
		return $response;
	}

	function prosesVerifikasi()
	{


		if ($this->input->is_ajax_request()) {
			$id_pengajuan = encrypt_decrypt("decrypt", $this->input->post('id_pengajuan'));
			// var_dump($id_pengajuan);die;
			$where = ['id_pengajuan' => $id_pengajuan];
			$this->session->unset_userdata('file_berita_acara');
			$jenis = $this->input->post('jenis');
			$validate = $this->_validation();

			$return = $this->cekForm($this->session->userdata('file_berita_acara'));

			$data = $return[0];
			$table = $return[1];
			$cek = $this->db->get_where($table, $where)->row();

			if ($validate) {
				if ($cek) {
					if ($jenis == 'verifikasi-cara-pembuatan' && $this->session->userdata('file_berita_acara')) $data['berita_acara'] = $this->session->userdata('file_berita_acara');
					$this->db->update($table, $data, $where);

					if($this->input->post('jenis')=='verifikasi-produk'){
						$this->db->update('tb_pengajuan_sppirt', array('status_verifikasi_product'=>$data['status_verifikasi']), $where);
					}else{
						$this->db->update('tb_pengajuan_sppirt', array('status_verifikasi_label'=>$data['status_verifikasi']), $where);
					}

				}else{
					if ($jenis == 'verifikasi-cara-pembuatan') $data['berita_acara'] = $this->session->userdata('file_berita_acara');
					$data['id_pengajuan'] = $id_pengajuan;
					// var_dump($data);die;
					$this->db->insert($table, $data);

					if($this->input->post('jenis')=='verifikasi-produk'){
						$this->db->update('tb_pengajuan_sppirt', array('status_verifikasi_product'=>$data['status_verifikasi']), $where);
					}else{
						$this->db->update('tb_pengajuan_sppirt', array('status_verifikasi_label'=>$data['status_verifikasi']), $where);
					}
					
					$this->session->unset_userdata('file_berita_acara');
				}
				if ($data['status_verifikasi'] == "1") {
					$response = [
						'status' => true,
						'alert' => 'Proses verifikasi berhasil <br><b>data sudah terisi semua</b>'
					];

				}else{
					$response = [
						'status' => true,
						'alert' => 'Proses verifikasi berhasil<br> <b><i>Data masih belum lengkap</i></b>'
					];
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
		$kategori_jenis_pangan = $this->input->post('kategori_jenis_pangan', true);
		$id_kategori_jenis_pangan = $this->input->post('id_kategori_jenis_pangan', true);

		$jenis_pangan = $this->input->post('jenis_pangan', true);
		$deskripsi_jenis_pangan = $this->input->post('deskripsi_jenis_pangan', true);

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
		$saran_asal_usul_bahan = $this->input->post('saran_asal_usul_bahan', true);
		
		$nama_produsen = $this->input->post('nama_produsen', true);
		$saran_nama_produsen = $this->input->post('saran_nama_produsen', true);
		
		$alamat_produsen = $this->input->post('alamat_produsen', true);
		$saran_alamat_produsen = $this->input->post('saran_alamat_produsen', true);

		$informasi_nilai_gizi = $this->input->post('informasi_nilai_gizi', true);
		$asal_informasi_nilai_gizi = $this->input->post('asal_informasi_nilai_gizi', true);


		$status = $this->input->post('status', true);
		$jadwal = $this->input->post('jadwal', true);
		$nomor_sertifikat = $this->input->post('nomor_sertifikat', true);

		$hasil_pembinaan = $this->input->post('hasil_pembinaan', true);
		$hasil_pemeriksaan = $this->input->post('hasil_pemeriksaan', true);
		$level = $this->input->post('level', true);
		

		$jenis = $this->input->post('jenis');

		if ($jenis == 'verifikasi-produk') {
			$table = 'tb_verifikasi_produk';
			$data = [
				'status_kategori_jenis_pangan' => $kategori_jenis_pangan,
				'id_kategori_jenis_pangan' => $id_kategori_jenis_pangan,
				'status_jenis_pangan' => $jenis_pangan,
				'deskripsi_jenis_pangan' => $deskripsi_jenis_pangan,
			];

			if ($kategori_jenis_pangan == "1") {
				$arrayCheck[] = $jenis_pangan;
			}else{
				$arrayCheck[] = $id_kategori_jenis_pangan;
				$arrayCheck[] = $jenis_pangan;
			}

			if ($jenis_pangan == "0") {
				$arrayCheck[] = $deskripsi_jenis_pangan;
			}
		}

		if ($jenis == 'verifikasi-label') {
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
				'status_informasi_nilai_gizi' => $informasi_nilai_gizi,
				'asal_informasi_nilai_gizi' => $asal_informasi_nilai_gizi,
				'nama_produsen'=> $nama_produsen,
				'saran_nama_produsen'=> $saran_nama_produsen,
				'alamat_produsen'=> $alamat_produsen,
				'saran_alamat_produsen'=> $saran_alamat_produsen,
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


		}

		// var_dump($arrayCheck);die;

		if ($jenis == 'verifikasi-pkp') {
			$table = 'tb_verifikasi_pkp';
			$data = [
				'status' => $status,
				'nomor_sertifikat' => $nomor_sertifikat,
				'jadwal' => $jadwal
			];


			if ($status == "1") {
				$arrayCheck[] = $nomor_sertifikat;
			}
			if ($status == "0") {
				$arrayCheck[] = $jadwal;
			}
		}


		// var_dump($this->session->userdata('file_berita_acara'));die;





		if ($jenis == 'verifikasi-cara-pembuatan') {
			$table = 'tb_verifikasi_cara_pembuatan';
			$data = [
				'status' => $status,
				'jadwal' => $status == 0 ? $jadwal : null,
				'level' => $status == 1 || $this->input->post('levelya') ? $this->input->post('levelya') : $this->input->post('leveltidak') ,
				'hasil_pemeriksaan' => $status == 1 ? $hasil_pemeriksaan : null,
				'hasil_pembinaan' => $status == 0 ? $hasil_pembinaan : null,
			];

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

	function _validation()
	{
		$input = $this->input->post();

		$kategori_jenis_pangan = $this->input->post('kategori_jenis_pangan');
		$jenis_pangan = $this->input->post('jenis_pangan');
		$nama_produk = $this->input->post('nama_produk');
		$komposisi = $this->input->post('komposisi');
		$berat_bersih = $this->input->post('berat_bersih');
		$nama_alamat = $this->input->post('nama_alamat');
		$tgl_kode_produksi = $this->input->post('tgl_kode_produksi');
		$halal = $this->input->post('halal');
		$keterangan_kadaluarsa = $this->input->post('keterangan_kadaluarsa');
		$asal_usul_bahan = $this->input->post('asal_usul_bahan');
		$informasi_nilai_gizi = $this->input->post('informasi_nilai_gizi');
		$status = $this->input->post('status');
		// var_dump($nama_produk);die;
		$jenis = $input['jenis'];

		if ($jenis == 'verifikasi-produk'){
			if($kategori_jenis_pangan == 0 && $kategori_jenis_pangan != null) $this->form_validation->set_rules('id_kategori_jenis_pangan', 'Kategori Jenis Pangan', 'xss_clean|trim', rules());
			if($jenis_pangan == 0 && $jenis_pangan != null) $this->form_validation->set_rules('deskripsi_jenis_pangan', 'Saran Jenis Pangan', 'xss_clean|trim', rules());

			$this->form_validation->set_rules('kategori_jenis_pangan', 'Nama Jenis Pangan', 'xss_clean|trim|required', rules());
			$this->form_validation->set_rules('jenis_pangan', 'Jenis Pangan', 'xss_clean|trim|required', rules());
		}
		if ($jenis == 'verifikasi-label'){

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

			$this->form_validation->set_rules('nama_produk', 'Nama Produk Pangan', 'xss_clean|trim|required', rules());
			$this->form_validation->set_rules('komposisi', 'Komposisi', 'xss_clean|trim|required', rules());
			$this->form_validation->set_rules('berat_bersih', 'Satuan', 'xss_clean|trim|required', rules());
			$this->form_validation->set_rules('nama_alamat', 'Produsen', 'xss_clean|trim|required', rules());
			$this->form_validation->set_rules('halal', 'Label Halal', 'xss_clean|trim|required', rules());
			$this->form_validation->set_rules('tgl_kode_produksi', 'Tanggal dan Kode Produksi', 'xss_clean|trim|required', rules());
			$this->form_validation->set_rules('keterangan_kadaluarsa', 'Label Kadaluarsa', 'xss_clean|trim|required', rules());
			$this->form_validation->set_rules('asal_usul_bahan', 'Label Asal Usul', 'xss_clean|trim|required', rules());
			$this->form_validation->set_rules('informasi_nilai_gizi', 'Informasi Nilai Gizi', 'xss_clean|trim|required', rules());
		}

		if ($jenis == 'verifikasi-pkp'){
			$this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required', rules());
			if($status == 1 && $status != null) $this->form_validation->set_rules('nomor_sertifikat', 'Nomor Sertifikat', 'xss_clean|trim', rules());
			if($status == 0 && $status != null) $this->form_validation->set_rules('jadwal', 'Jadwal Penyuluhan', 'xss_clean|trim', rules());
		}

		if ($jenis == 'verifikasi-cara-pembuatan') {
			$this->form_validation->set_rules('status', 'Status', 'xss_clean|trim|required', rules());
			if ($status == 0 && $status != null) {
				$this->form_validation->set_rules('berita_acara', 'Berita Acara', 'trim|callback_cek_upload');
				$this->form_validation->set_rules('jadwal', 'Jadwal Pemeriksaan Sarana', 'xss_clean|trim', rules());
				$this->form_validation->set_rules('leveltidak', 'Level', 'xss_clean|trim', rules());
			}else{
				$this->form_validation->set_rules('levelya', 'Level', 'xss_clean|trim', rules());
				$this->form_validation->set_rules('hasil_pemeriksaan', 'Hasil Pemeriksaan', 'xss_clean|trim', rules());
			}
		}

		
        $this->form_validation->set_error_delimiters('', '');
		return $this->form_validation->run();


	}


	function rekomendasicancelIrtp($id_pengajuan)
	{
		if ($this->input->is_ajax_request()) {
			$id_pengajuan = encrypt_decrypt('decrypt', $id_pengajuan);
			// var_dump($id_pengajuan);die;
			$data = $this->db->get_where('tb_pengajuan_sppirt', ['id_pengajuan' => $id_pengajuan])->row();
			$cek = $this->db->get_where('tb_verifikasi_produk', ['id_pengajuan' => $id_pengajuan])->row();
			if ($cek) {
				$this->db->update('tb_verifikasi_produk', ['status_jenis_pangan' => '0','deskripsi_jenis_pangan' => '0', 'status_verifikasi' => '1'], ['id_pengajuan' => $id_pengajuan]);
			}else{
				$this->db->insert('tb_verifikasi_produk', ['id_pengajuan' => $id_pengajuan,'status_jenis_pangan' => '0','deskripsi_jenis_pangan' => '0', 'status_verifikasi' => '1']);
			}
			$update = $this->db->update('tb_pengajuan_sppirt', ['status_pengajuan' => '3', 'status_verifikasi' => '1'], ['id_pengajuan' => $id_pengajuan]);
			if ($update) {
				$response = [
					'status' => true,
					'alert' => 'Rekomendasi pembatalan pengajuan IRTP dengan No :<br><b>'.$data->no_sppirt.' telah dikirim ke PTSP'
				];
			}else{
				$response = [
					'status' => false,
					'alert' => 'Proses Pembatalan Pengajuan Gagal'
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



	function hasilPengawasan($id_pengajuan = null)
	{

		if ($id_pengajuan) {
			$id_pengajuan = encrypt_decrypt("decrypt", $id_pengajuan);
			// var_dump($id_pengajuan);die;
			$this->db->select('tb_verifikasi_cara_pembuatan.*, tb_verifikasi_label.*, tb_verifikasi_pkp.*, tb_verifikasi_produk.*, tb_pengajuan_sppirt.*, tb_verifikasi_produk.created_at as created_produk, tb_verifikasi_label.created_at as created_label, tb_verifikasi_pkp.created_at as created_pkp, tb_verifikasi_cara_pembuatan.created_at as created_cara_pembuatan, tb_kategori_jenis_pangan.*, tb_verifikasi_pkp.status as status_pkp, tb_verifikasi_pkp.jadwal as jadwal_pkp, tb_verifikasi_cara_pembuatan.status as status_cara_pembuatan, tb_verifikasi_cara_pembuatan.jadwal as jadwal_cara_pembuatan');
			$this->db->join('tb_verifikasi_produk', 'tb_verifikasi_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'INNER');
			$this->db->join('tb_kategori_jenis_pangan', 'tb_kategori_jenis_pangan.id_kategori_jenis_pangan = tb_verifikasi_produk.id_kategori_jenis_pangan', 'LEFT');
			$this->db->join('tb_verifikasi_label', 'tb_verifikasi_label.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'INNER');
			$this->db->join('tb_verifikasi_pkp', 'tb_verifikasi_pkp.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'INNER');
			$this->db->join('tb_verifikasi_cara_pembuatan', 'tb_verifikasi_cara_pembuatan.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'INNER');
			$this->db->where('tb_pengajuan_sppirt.id_pengajuan', $id_pengajuan);
			$irtp = $this->db->get('tb_pengajuan_sppirt')->row_array();
			if ($irtp) {
				$data = [
					'title' => 'Hasil Pengawasan No : '.$irtp['no_sppirt'],
					'breadcrumb' => breadcrumb('Hasil Pengawasan P-IRT', 'backend/detail-hasil-pengawasan'),
					'irtp' => $irtp
				];
				$this->template->load('template/backend', 'backend/pengawasan/detail-hasil-pengawasan', $data);
			}else{
				$data = [
					'title' => 'Not Found',
					'breadcrumb' => breadcrumb('Hasil Pengawasan P-IRT', 'backend/detail-hasil-pengawasan'),
				];
				$this->template->load('template/backend', 'errors/backend404', $data);
			}
		}else{
			$data = [
				'title' => 'Hasil Pengawasan IRTP',
				'breadcrumb' => breadcrumb('Hasil Pengawasan P-IRT', 'backend/hasil-pengawasan')
			];
			$this->template->load('template/backend', 'backend/pengawasan/hasil-pengawasan', $data);	
		}
	}


	function getHasilPengawasan()
	{
		$column_order = [null, 'no_sppirt', 'nama_produk_pangan', 'nama_kategori_jenis_pangan', 'id_prov','tb_user.nib', 'tb_pengajuan_sppirt.created_at', 'id_izin'];
		$column_search = [null,'no_sppirt', 'nama_produk_pangan', 'nama_kategori_jenis_pangan','id_prov', 'tb_user.nib', 'tb_pengajuan_sppirt.created_at', 'id_izin'];
		$order = ['tb_pengajuan_sppirt.created_at' => 'DESC'];

		$id_role = $this->session->userdata('userData')['id_role'];
		$id_kota = $this->session->userdata('userData')['id_kota'];
		$id_prov = $this->session->userdata('userData')['id_prov'];

		// var_dump($id_role);
		$where = ['status_pengajuan >=' => "2"];
		if ($id_role == 3) $where['id_kota'] = $id_kota;
		if ($id_role == 4) $where['id_kota'] = $id_kota;
		if ($id_role == 5) $where['id_prov'] = $id_prov;

		$query = [
			'table' => 'tb_pengajuan_sppirt',
			'select' => 'tb_pengajuan_sppirt.id_pengajuan, no_sppirt,no_sppirt_lama,status_no_sppirt,status_sinkronisasi,id_prov,id_kota,status_pengajuan, nama_jenis_pangan, nama_produk_pangan,nama_kemasan,nama_kategori_jenis_pangan,tb_user.nib, id_izin,tb_pengajuan_sppirt.created_at, status_pengajuan, tb_verifikasi_produk.status_verifikasi as status_verifikasi_produk ,
				tb_verifikasi_pkp.status_verifikasi as status_verifikasi_pkp ,
				tb_verifikasi_label.status_verifikasi as status_verifikasi_label ,
				tb_verifikasi_cara_pembuatan.status_verifikasi as status_verifikasi_cara_pembuatan',
			'where' => $where,
			'join' => [
				['tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'inner'],
				['tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan', 'inner'],
				['tb_kategori_jenis_pangan', 'tb_kategori_jenis_pangan.id_kategori_jenis_pangan = tb_jenis_pangan.id_kategori_jenis_pangan', 'inner'],
				['tb_jenis_kemasan', 'tb_jenis_kemasan.id_jenis_kemasan = tb_input_data_produk.id_jenis_kemasan', 'inner'],
				['tb_verifikasi_produk', 'tb_verifikasi_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'left'],
				['tb_verifikasi_label', 'tb_verifikasi_label.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'left'],
				['tb_verifikasi_pkp', 'tb_verifikasi_pkp.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'left'],
				['tb_verifikasi_cara_pembuatan', 'tb_verifikasi_cara_pembuatan.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'left'],
				['tb_user', 'tb_user.id_user = tb_pengajuan_sppirt.id_user', 'RIGHT']
			]
		];

		$sppirt = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);	
		// var_dump($this->db->last_query());die;
		// var_dump($sppirt);die;
		$data = [];
		$no = @$_POST['start'];
		foreach ($sppirt as $irtp) {
			$tgl_berlaku_izin = date('d-m-Y', strtotime('+5 years', strtotime($irtp->created_at)));
				$tgl_prengajuan = date('d-m-Y', strtotime($irtp->created_at));

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
			if ($irtp->status_verifikasi_label == 1 && $irtp->status_verifikasi_pkp == 1 && $irtp->status_verifikasi_produk == 1 && $irtp->status_verifikasi_cara_pembuatan == 1 || $irtp->status_pengajuan == 4) {
				$row[] = '
					<a href="'.base_url("backend/hasil-pengawasan/").encrypt_decrypt("encrypt", $irtp->id_pengajuan).'" title="Hasil Pengawasan" class="btn btn-info btn-xs">Lihat Hasil Pengawasan</a>';
			}else{
				$row[] = '<button type="button" class="btn btn-warning btn-xs">Menunggu Verifikasi</button>';
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

	function getRowDataHasilPengawasan($id)
	{
		$id_pengajuan = encrypt_decrypt('decrypt', $id);
		// var_dump($id_pengajuan);die;
		$this->db->select('*,
			tb_verifikasi_produk.status_verifikasi as status_verifikasi_produk,
			tb_verifikasi_label.status_verifikasi as status_verifikasi_label,
			tb_verifikasi_pkp.status_verifikasi as status_verifikasi_pkp,
			tb_verifikasi_pkp.status as status_pkp,
			tb_verifikasi_pkp.jadwal as jadwal_pkp,
			tb_verifikasi_cara_pembuatan.status_verifikasi as status_verifikasi_cara_pembuatan')
			->join('tb_verifikasi_produk', 'tb_pengajuan_sppirt.id_pengajuan = tb_verifikasi_produk.id_pengajuan', 'LEFT')
			->join('tb_verifikasi_label', 'tb_pengajuan_sppirt.id_pengajuan = tb_verifikasi_label.id_pengajuan', 'LEFT')
			->join('tb_verifikasi_pkp', 'tb_pengajuan_sppirt.id_pengajuan = tb_verifikasi_pkp.id_pengajuan', 'LEFT')
			->join('tb_verifikasi_cara_pembuatan', 'tb_pengajuan_sppirt.id_pengajuan = tb_verifikasi_cara_pembuatan.id_pengajuan', 'LEFT')
			// ->join('tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
			// ->join('tb_input_label_produk', 'tb_input_label_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
			// ->join('tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan')
			->join('tb_kategori_jenis_pangan', 'tb_verifikasi_produk.id_kategori_jenis_pangan = tb_kategori_jenis_pangan.id_kategori_jenis_pangan','LEFT')
			->where('tb_pengajuan_sppirt.id_pengajuan', $id_pengajuan);
		$verifikasi = $this->db->get('tb_pengajuan_sppirt')->row_array();
		// var_dump($verifikasi);
		echo json_encode($verifikasi);
	}
}

/* End of file Pengawasan.php */
/* Location: ./application/controllers/backend/Pengawasan.php */