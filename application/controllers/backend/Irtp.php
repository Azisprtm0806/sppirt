<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Irtp extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		cekLogin();
		$this->load->model('Datatable_Model');
		$this->pelaku_usaha_model = new GeneralModel("tb_pelaku_usaha");
		$this->pengajuan_sppirt_model = new GeneralModel("tb_pengajuan_sppirt");
		$this->provinsi_model = new GeneralModel("tb_provinsi");
		$this->kab_kota_model = new GeneralModel("tb_kota");
		$this->kecamatan_model = new GeneralModel("tb_kecamatan");
		$this->desa_model = new GeneralModel("tb_desa");
		$this->user_model = new GeneralModel("tb_user");
		$this->jenis_pangan_model = new GeneralModel("tb_jenis_pangan");
		$this->kategori_jenis_pangan_model = new GeneralModel("tb_kategori_jenis_pangan");
		$this->jenis_kemasan_model = new GeneralModel("tb_jenis_kemasan");
		$this->penyimpanan_model = new GeneralModel("tb_penyimpanan");
		// $this->load->model('Btp_Model');
	}

	public function index($id_pengajuan = null)
	{
		$getLastDataProduk = $this->db->order_by('produk_ke', 'desc')->join('tb_pengajuan_sppirt', 'tb_pengajuan_sppirt.id_pengajuan = tb_input_data_produk.id_pengajuan')->get_where('tb_input_data_produk', ['nib' => $this->session->userdata('userData')['nib'], 'status_pengajuan >=' => '2'])->row();
		$data = [
			'title' => 'Pengajuan Izin PIRT',
			'pelakuusaha' => $this->db->get_where('tb_pelaku_usaha', ['nib' => $this->session->userdata('userData')['nib']])->row_array(),
			'user' => $this->db->get_where('tb_user', ['nib' => $this->session->userdata('userData')['nib']])->row_array(),
			'provinsi' => $this->db->order_by('nama_prov', 'ASC')->get('tb_provinsi')->result_array(),
			'kota' => $this->db->order_by('nama_kota', 'ASC')->get_where('tb_kota', ['id_prov' => $this->session->userdata('userData')['id_prov']])->result_array(),
			'kategorijenispangan' => $this->db->order_by('id_kategori_jenis_pangan', 'ASC')->get_where('tb_kategori_jenis_pangan', ['deleted_at' => null])->result_array(),
			'jeniskemasan' => $this->db->order_by('id_jenis_kemasan', 'ASC')->get_where('tb_jenis_kemasan', ['deleted_at' => null])->result_array(),
			'prosesproduksi' => $this->db->order_by('nama_proses_produksi', 'ASC')->get_where('tb_proses_produksi', ['deleted_at' => null])->result_array(),
			'carapenyimpanan' => $this->db->order_by('cara_penyimpanan', 'ASC')->get_where('tb_penyimpanan', ['deleted_at' => null])->result_array(),
			'produk_ke' => buatKode(isset($getLastDataProduk->produk_ke) ? $getLastDataProduk->produk_ke : 0, '', 2),
			'breadcrumb' => breadcrumb('Pengajuan Izin PIRT', 'backend/Irtp')
		];

		$status_user = $this->_getStatusUser($this->session->userdata('userData')['nib']);
		if ($status_user['response'] == TRUE && $status_user['status_dikembalikan'] == '1') {
			$this->template->load('template/backend', 'backend/irtp/akun-dibekukan', $data);
		}
		else{
			// var_dump($this->session->userdata('userData'));die;
			if ($id_pengajuan) {
				$id_pengajuan = strip_tags($id_pengajuan);
				$id_pengajuan = encrypt_decrypt('decrypt', $id_pengajuan);
				$this->db->select('*')
					->join('tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
					->join('tb_input_label_produk', 'tb_input_label_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
					->where('tb_pengajuan_sppirt.id_pengajuan', $id_pengajuan);
				$data['irtp'] = $this->db->get('tb_pengajuan_sppirt')->row();
				$this->template->load('template/backend', 'backend/irtp/perbaiki-irtp', $data);
			} else {
				$getLastDataProduk = $this->db->order_by('produk_ke', 'desc')->join('tb_pengajuan_sppirt', 'tb_pengajuan_sppirt.id_pengajuan = tb_input_data_produk.id_pengajuan')->get_where('tb_input_data_produk', ['nib' => $this->session->userdata('userData')['nib']])->row();
				$data['is_first'] = $getLastDataProduk == NULL ? true : false;
				$data['file_komitmen'] = $this->db->select('file_komitmen')->where('nib', $this->session->userdata('userData')['nib'])->get('tb_pelaku_usaha')->row()->file_komitmen;
				$this->template->load('template/backend', 'backend/irtp/pengajuan-irtpv2', $data);
			}			
		}
	}


	function simpanKomitmen()
	{
		$nib = $this->session->userdata('userData')['nib'];
		$upload = $this->uploadKomitmen($nib);
		// var_dump($nib);die;
		if ($upload['status']) {
			$data = [
				'file_komitmen' => $upload['file_komitmen']
			];
			$this->db->where('nib', $nib);
			$this->db->update('tb_pelaku_usaha', $data);
			$response =  [
				'success' => true,
				'msg' => 'Selamat, anda telah memenuhi komitmen....'
			];
		} else {
			$response =  [
				'success' => false,
				'error' => true,
				'msg' => $upload['file_komitmen_error']
			];
		}

		echo json_encode($response);
	}
	function uploadKomitmen($nib)
	{
		$this->load->helper('string');
		$random = random_string('alnum', 4);
		$config = [
			'upload_path' => './uploads/komitmen/',
			'allowed_types' => 'jpg|jpeg|png|pdf',
			'max_size' => '5000',
			'encrypt_name' => true,
			'file_name' => 'Komitmen-' . date('d-m-Y') . '-' . $random,
		];
		$this->load->library('upload', $config);
		$cek = $this->db->get_where('tb_pelaku_usaha', ['nib' => $nib])->row_array();
		if (!$this->upload->do_upload('file_komitmen')) {
			$response = ['file_komitmen_error' => $this->upload->display_errors('', ''), 'status' => false];
		} else {
			$response = ['file_komitmen' => $this->upload->data('file_name'), 'status' => true];
			if ($cek['file_komitmen']) {
				unlink(FCPATH . './uploads/komitmen/' . $cek['file_komitmen']);
			}
			// unlink(FCPATH.'./uploads/berita/thumbnail/'.$cek['file_komitmen']);
		}
		// if ($_FILES['file_komitmen']['name']) {
		// } else {
		// 	$response = ['file_komitmen' => $cek['file_komitmen'], 'status' => true];
		// }
		return $response;
	}



	function cekNamaProduk()
	{
		$nama_produk = $this->input->post('nama_produk');
		$nib = $this->input->post('nib');

		$cek = $this->db->get_where('tb_pengajuan_sppirt', ['nama_produk_pangan' => $nama_produk, 'nib' => $nib])->row();
		if ($cek) {
			$response =  [
				'success' => false,
				'msg' => 'Produk Pangan Sudah Terdaftar'
			];
		} else {
			$response =  [
				'success' => true,
				'msg' => ''
			];
		}

		echo json_encode($response);
	}

	function simpanPengajuan()
	{
		if ($this->input->is_ajax_request()) {
			$nama_pelaku_usaha = $this->input->post('nama_pelaku_usaha', true);
			$nib = $this->input->post('nib', true);
			$status_konfirmasi = $this->input->post('status_konfirmasi', true);
			$nama_usaha = $this->input->post('nama_usaha', true);
			$alamat_usaha = $this->input->post('alamat_lengkap', true);
			$id_prov = $this->input->post('id_prov', true);
			$id_kota = $this->input->post('id_kota', true);


			$id_pengajuan = $this->input->post('id_pengajuan', true);
			$id_input_data = $this->input->post('id_input_data', true);
			$id_input_label = $this->input->post('id_input_label', true);
			$isi_bersih_produk = json_decode($this->input->post('isi_bersih_produk', true));
			$data_isi_bersih = [];
			foreach ($isi_bersih_produk as $key => $value) {
				$data_isi_bersih[] = $value->value;
			} 
			// var_dump($id_pengajuan);die;
			$id_kategori_jenis_pangan = $this->input->post('id_kategori_jenis_pangan', true);
			$id_jenis_pangan = $this->input->post('id_jenis_pangan', true);
			$id_jenis_kemasan = $this->input->post('id_jenis_kemasan', true);
			// $deskripsi_jenis_pangan = $this->input->post('deskripsi_jenis_pangan', true);
			$komposisi = $this->input->post('komposisi', true);
			$id_proses_produksi = $this->input->post('id_proses_produksi', true);
			$id_penyimpanan = $this->input->post('id_penyimpanan', true);
			$masa_simpan = $this->input->post('masa_simpan', true);
			$jenis_simpan = $this->input->post('satuan_masa_simpan', true);
			$produk_ke = $this->input->post('produk_ke', true);
			$nama_produk_pangan = $this->input->post('nama_produk_pangan', true);

			$nama_produk = $this->input->post('nama_produk', true);
			$komposisi = htmlspecialchars($this->input->post('komposisi', true));
			$ket_komposisi = $this->input->post('ket_komposisi', true);
			$isi_bersih = $this->input->post('isi_bersih', true);
			$halal = $this->input->post('halal', true);
			$tgl_produksi = $this->input->post('tgl_produksi', true);
			$kode_produksi = $this->input->post('tgl_produksi', true);
			$ket_kadaluarsa = $this->input->post('ket_kadaluarsa', true);
			$asal_usul = $this->input->post('asal_usul', true);
			$kel_lainnya = $this->input->post('kel_lainnya', true);
			$informasi_nilai_gizi = $this->input->post('informasi_nilai_gizi', true);
			$nama_produsen = $this->input->post('nama_produsen',TRUE);
			$alamat_produsen = $this->input->post('alamat_produsen',TRUE);
			$arraylabel = [
				$nama_produk,
				$ket_komposisi,
				$isi_bersih,
				//$halal,
				$tgl_produksi,
				//$kode_produksi,
				$ket_kadaluarsa,
				//$asal_usul,
				//$informasi_nilai_gizi,
				// $kel_lainnya,
				$nama_produsen,
				$alamat_produsen
			];
			if (in_array(null, $arraylabel)) {
				$response =  [
					'success' => false,
					'error' => true,
					'msg' => 'Pastikan semua field sudah terisi dengan benar'
				];
			} else {
				$datapengajuan = [
					'nama_pelaku_usaha' => $nama_pelaku_usaha,
					'nama_usaha' => $nama_usaha,
					'alamat_lengkap' => $alamat_usaha,
					'nama_produk_pangan' => $nama_produk_pangan,
					'nib' => $nib,
					'id_user' => $this->session->userdata('userData')['id'],
					'status_konfirmasi' => $status_konfirmasi
				];

				$upload = $this->uploadLabel();
				if ($upload['status']) {
					$this->db->trans_start();
					if ($id_pengajuan) {
						$this->db->update('tb_pengajuan_sppirt', $datapengajuan, ['id_pengajuan' => $id_pengajuan]);
					} else {
						$pengajuan = $this->db->insert('tb_pengajuan_sppirt', $datapengajuan);
						$id_pengajuan = $this->db->insert_id('id_pengajuan');
					}
					$datainputproduk = [
						'id_pengajuan' => $id_pengajuan,
						'id_kategori_jenis_pangan' => $id_kategori_jenis_pangan,
						'id_jenis_pangan' => $id_jenis_pangan,
						'id_jenis_kemasan' => $id_jenis_kemasan,
						// 'deskripsi_jenis_pangan' => $deskripsi_jenis_pangan,
						'komposisi' => $komposisi,
						'isi_bersih_produk' => implode(",", $data_isi_bersih),
						'id_proses_produksi' => $id_proses_produksi,
						'id_penyimpanan' => $id_penyimpanan,
						'masa_simpan' => $masa_simpan,
						'jenis_simpan' => $jenis_simpan,
						'produk_ke' => $produk_ke,

					];
					if ($id_input_data) {
						$this->db->update('tb_input_data_produk', $datainputproduk, ['id_input_data' => $id_input_data]);
					} else {
						$this->db->insert('tb_input_data_produk', $datainputproduk);
					}
					$datalabelproduk = [
						'id_pengajuan' => $id_pengajuan,
						'nama_produk' => $nama_produk,
						'ket_komposisi' => $ket_komposisi,
						'isi_bersih' => $isi_bersih,
						'halal' => $halal,
						'tgl_produksi' => $tgl_produksi,
						'kode_produksi' => $kode_produksi,
						'ket_kadaluarsa' => $ket_kadaluarsa,
						'asal_usul' => $asal_usul,
						'informasi_nilai_gizi' => $informasi_nilai_gizi,
						'kel_lainnya' => $kel_lainnya,
						'nama_produsen' => $nama_produsen,
						'alamat_produsen' => $alamat_produsen,
						'upload_rancangan' => $upload['upload_rancangan']
					];
					//var_dump($datalabelproduk);
					//die();
					if ($id_input_label) {
						$this->db->update('tb_input_label_produk', $datalabelproduk, ['id_input_label' => $id_input_label]);
					} else {
						$this->db->insert('tb_input_label_produk', $datalabelproduk);
					}

					if ($id_penyimpanan == 2 || $id_penyimpanan == 3 || $jenis_simpan == 'hari'  && $masa_simpan < 7) {
						if ($id_jenis_pangan == 157 && $id_penyimpanan != 2 && $id_penyimpanan != 3) {
							$response =  [
								'id_pengajuan'=>encrypt_decrypt('encrypt',$id_pengajuan),
								'success' => true,
								'msg' => 'Selamat!! Pengajuan izin PIRT anda BERHASIL...'
							];
							$status = '2';
						} else {
							$response =  [
								'success' => false,
								'msg' => 'Maaf!! Pengajuan izin PIRT anda DITOLAK...'
							];
							$status = '0';
						}
					} else {
						$response =  [
							'id_pengajuan'=>encrypt_decrypt('encrypt',$id_pengajuan),
							'success' => true,
							'msg' => 'Selamat!! Pengajuan izin PIRT anda BERHASIL...'
						];
						$status = '2';
					}


					if ($status != '0') {
						if (in_array('0', $arraylabel)) {
							$response =  [
								'success' => false,
								'msg' => 'Informasi yang harus dicantumkan pada label TIDAK LENGKAP. Silahkan melakukan konsultasi dengan Dinas Kesehatan atau Badan POM terkait kelengkapan informasi label. Perbaikan data dapat dilakukan paling cepat 24 jam dari waktu pengajuan.'
							];
							$status = '1';
						}
					}

					$nourutpangan = $this->db->select('id_pengajuan')->where('nib', $nib)->get('tb_pengajuan_sppirt')->num_rows() + 1;
					
					/* format lama
					$ceknourutpelakuusaha = $this->db->get_where('tb_user', ['nib' => $nib])->row_array();
					if ($ceknourutpelakuusaha['no_urut_pelaku_usaha'] == NULL) {
						$nourutpelakuusaha = $this->db->select('tb_user.nib')->where(['id_kota' => $id_kota, 'tb_user.nib !=' => $nib])->get('tb_user')->num_rows();
						$nourutpelakuusaha = buatKode($nourutpelakuusaha, '', 4);
						// var_dump($nourutpelakuusaha);
						$this->db->update('tb_user', ['no_urut_pelaku_usaha' => $nourutpelakuusaha], ['nib' => $nib]);
					} else {
						$nourutpelakuusaha = $ceknourutpelakuusaha['no_urut_pelaku_usaha'];
					}
					*/
					
					$ceknourutpelakuusaha = $this->db->get_where('tb_user', ['nib' => $nib])->row_array();
					if ($ceknourutpelakuusaha['no_urut_pelaku_usaha'] == NULL) {

						$query = $this->user_model->source();
						$query->where('id_kota',$id_kota);
						$query->where('id_role',2);
						$query->order_by('no_urut_pelaku_usaha','DESC');
						$user = $query->get()->row();
						if(isset($user->no_urut_pelaku_usaha)){
							$nourutpelakuusaha = (int)$user->no_urut_pelaku_usaha;
						}else{
							$nourutpelakuusaha = 0;
						}

						// $nourutpelakuusaha = $this->db->select('tb_user.nib')->where(['id_kota' => $id_kota, 'tb_user.nib !=' => $nib])->get('tb_user')->num_rows();
						$nourutpelakuusaha = buatKode($nourutpelakuusaha, '', 4);
						// var_dump($nourutpelakuusaha);
						// die();
						
						$this->db->update('tb_user', ['no_urut_pelaku_usaha' => $nourutpelakuusaha], ['nib' => $nib]);
					} else {
						$nourutpelakuusaha = $ceknourutpelakuusaha['no_urut_pelaku_usaha'];
					}

					// die;

					$year = date('y') + 5;

					if ($status == '2') {

						$id_kategori_jenis_pangan = (strlen($id_kategori_jenis_pangan)<=1)?"0".$id_kategori_jenis_pangan:$id_kategori_jenis_pangan;
						$no_sppirt = 'P-IRT ' . $id_jenis_kemasan . $id_kategori_jenis_pangan  . $id_kota . $produk_ke . $nourutpelakuusaha . '-' . $year;
						
					} else {
						$no_sppirt = '';
					}

					$notifikasi = [
						'id_prov' => $id_prov,
						'id_kab' => $id_kota,
						'id_pengajuan' => $id_pengajuan,
						'status' => $status,
						'notifikasi_admin' => '0',
						'notifikasi_ptsp' => '0',
						'notifikasi_dinkesprov' => '0',
						'notifikasi_dinkeskab' => '0'
					];
					$this->db->insert('tb_notifikasi', $notifikasi);

					$this->db->update('tb_pengajuan_sppirt', ['status_pengajuan' => $status, 'no_sppirt' => $no_sppirt], ['id_pengajuan' => $id_pengajuan]);
					$this->db->trans_complete();
					if ($this->db->trans_status() === FALSE) {
						$this->db->trans_rollback();
						$response =  [
							'success' => true,
							'msg' => 'Proses Pengajuan Gagal'
						];
					}

					// $this->send_data(encrypt_decrypt('encrypt', $id_pengajuan), 'DIRECT');
				} else {
					$response =  [
						'success' => false,
						'error' => true,
						'msg' => $upload['upload_rancangan_error']
					];
				}
			}




			echo json_encode($response);
		} else {
			exit('Access denied');
		}
	}


	function cekLabel($finish = false)
	{
		$nama_produk = $this->input->post('nama_produk', true);
		$komposisi = htmlspecialchars($this->input->post('komposisi', true));
		$ket_komposisi = $this->input->post('ket_komposisi', true);
		$isi_bersih = $this->input->post('isi_bersih', true);
		$halal = $this->input->post('halal', true);
		$tgl_produksi = $this->input->post('tgl_produksi', true);
		$kode_produksi = $this->input->post('tgl_produksi', true);
		$ket_kadaluarsa = $this->input->post('ket_kadaluarsa', true);
		$asal_usul = $this->input->post('asal_usul', true);
		$nama_produsen = $this->input->post('nama_produsen',TRUE);
		$alamat_produsen = $this->input->post('alamat_produsen',TRUE);
		$kel_lainnya = $this->input->post('kel_lainnya', true);
		$informasi_nilai_gizi = $this->input->post('informasi_nilai_gizi', true);
		$arraylabel = [
			$nama_produk,
			$ket_komposisi,
			$isi_bersih,
			$tgl_produksi,
			$kode_produksi,
			$ket_kadaluarsa,
			$asal_usul,
			$kel_lainnya,
			$halal,
			$informasi_nilai_gizi,
			$nama_produsen,
			$alamat_produsen
		];
		if (in_array(null, $arraylabel)) {
			$response =  [
				'success' => false,
				'error' => true,
				'msg' => 'Pastikan semua field sudah terisi dengan benar'
			];
		} else {
			$upload = $this->uploadLabel();
			if ($upload['status']) {
				$cek = $this->db->get_where('tb_input_label_produk', ['upload_rancangan' => $upload['upload_rancangan']])->num_rows();
				if ($cek < 1) {
					unlink(FCPATH . './uploads/labelproduk/' . $upload['upload_rancangan']);
				}
				$response =  [
					'success' => true,
				];
			} else {
				$response =  [
					'success' => false,
					'error' => true,
					'msg' => $upload['upload_rancangan_error']
				];
			}
		}

		echo json_encode($response);
	}



	function uploadLabel()
	{
		$this->load->helper('string');
		$random = random_string('alnum', 4);
		$config = [
			'upload_path' => './uploads/labelproduk/',
			'allowed_types' => 'jpg|jpeg|png',
			'max_size' => '5000',
			'encrypt_name' => true,
			'file_name' => 'Label-' . date('d-m-Y') . '-' . $random,
		];
		$this->load->library('upload', $config);
		if ($this->input->post('id_input_label')) {
			$cek = $this->db->get_where('tb_input_label_produk', ['id_input_label' => $this->input->post('id_input_label')])->row_array();
			if ($_FILES['upload_rancangan']['name']) {
				if (!$this->upload->do_upload('upload_rancangan')) {
					$response = ['upload_rancangan_error' => $this->upload->display_errors(), 'status' => false];
				} else {
					$response = ['upload_rancangan' => $this->upload->data('file_name'), 'status' => true];
					unlink(FCPATH . './uploads/labelproduk/' . $cek['upload_rancangan']);
					// unlink(FCPATH.'./uploads/berita/thumbnail/'.$cek['upload_rancangan']);
				}
			} else {
				$response = ['upload_rancangan' => $cek['upload_rancangan'], 'status' => true];
			}
		} else {
			if (!$this->upload->do_upload('upload_rancangan')) {
				$response = ['upload_rancangan_error' => $this->upload->display_errors(), 'status' => false];
			} else {
				$response = ['upload_rancangan' => $this->upload->data('file_name'), 'status' => true];
			}
		}
		return $response;
	}



	function list($status)
	{
		$data = [
			'title' => 'Pangajuan IRTP ' . $status,
			'breadcrumb' => breadcrumb('Pengajuan IRTP ' . $status, 'backend/irtp/list/' . $status)
		];

		$query = $this->provinsi_model->source();
		$data['provinsi'] = $query->get()->result();

		$this->template->load('template/backend', 'backend/irtp/pengajuan-' . $status, $data);
	}


	// var $column_order = [null, 'no_sppirt', 'nama_produk_pangan', 'nama_jenis_pangan', 'nama_kemasan', 'tb_pengajuan_sppirt.created_at', 'status_pengajuan'];
	var $column_order = [null, 'no_sppirt', 'nama_produk_pangan', 'tb_pengajuan_sppirt.created_at', 'status_pengajuan'];
	// var $column_search = ['no_sppirt','no_sppirt_lama','tb_pengajuan_sppirt.nib', 'nama_produk_pangan', 'nama_jenis_pangan', 'nama_kemasan','tb_pengajuan_sppirt.id_izin', 'tb_pengajuan_sppirt.created_at', 'status_pengajuan'];
	var $column_search = ['no_sppirt','no_sppirt_lama','tb_pengajuan_sppirt.nib', 'nama_produk_pangan','tb_pengajuan_sppirt.id_izin', 'tb_pengajuan_sppirt.created_at', 'status_pengajuan'];
	var $order = ['tb_pengajuan_sppirt.created_at' => 'DESC'];

	function getData($status)
	{
		if ($this->input->is_ajax_request()) {

			$role_id = $this->session->userdata('userData')['id_role'];
			if ($role_id == 2) {
				$where['tb_pengajuan_sppirt.id_user'] = $this->session->userdata('userData')['id'];
			} else if ($role_id == 3 || $role_id == 4) {
				$where['id_kota'] = $this->session->userdata('userData')['id_kota'];
			} else if ($role_id == 5) {
				$where['id_prov'] = $this->session->userdata('userData')['id_prov'];
			}else if ($role_id == 8) {
				$where['id_prov'] = $this->session->userdata('userData')['id_prov'];
			}

			$where['tb_pengajuan_sppirt.deleted_at'] = null;
			$where['status_pengajuan'] = $status;

			$query = [
				'table' => 'tb_pengajuan_sppirt',
				// 'select' => '*, tb_pengajuan_sppirt.created_at as tgl_pengajuan',
				'select' => '
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
				tb_user.id_desa,',
				'where' => $where,
				'join' => [
					['tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'inner'],
					// ['tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan', 'inner'],
					// ['tb_kategori_jenis_pangan', 'tb_kategori_jenis_pangan.id_kategori_jenis_pangan = tb_jenis_pangan.id_kategori_jenis_pangan', 'inner'],
					// ['tb_jenis_kemasan', 'tb_jenis_kemasan.id_jenis_kemasan = tb_input_data_produk.id_jenis_kemasan', 'inner'],
					// ['tb_penyimpanan', 'tb_penyimpanan.id_penyimpanan = tb_input_data_produk.id_penyimpanan', 'inner'],
					['tb_user', 'tb_user.id_user = tb_pengajuan_sppirt.id_user', 'inner'],
					// ['tb_provinsi', 'tb_provinsi.id_prov = tb_user.id_prov', 'inner'],
					// ['tb_kota', 'tb_kota.id_prov = tb_provinsi.id_prov', 'inner']

				]
			];
			// var_dump($this->input->post('tipe'));
			$sppirt = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
			// var_dump(
			// $this->db->last_query($sppirt)
			// );die;
			$data = [];
			$no = @$_POST['start'];
			foreach ($sppirt as $irtp) {

				$tgl_berlaku_izin = date('d-m-Y', strtotime('+5 years', strtotime($irtp->tgl_pengajuan)));
				$tgl_prengajuan = date('d-m-Y', strtotime($irtp->tgl_pengajuan));

				$jenis_kemasan = $this->jenis_kemasan_model->find($irtp->id_jenis_kemasan,'id_jenis_kemasan');
				$irtp->nama_kemasan = isset($jenis_kemasan->nama_kemasan)?$jenis_kemasan->nama_kemasan:'';

				$kategori_jenis_pangan = $this->kategori_jenis_pangan_model->find($irtp->id_kategori_jenis_pangan,'id_kategori_jenis_pangan');
				$irtp->nama_kategori_jenis_pangan = isset($kategori_jenis_pangan->nama_kategori_jenis_pangan)?$kategori_jenis_pangan->nama_kategori_jenis_pangan:'';

				$penyimpanan = $this->penyimpanan_model->find($irtp->id_penyimpanan,'id_penyimpanan');
				$irtp->cara_penyimpanan = isset($penyimpanan->cara_penyimpanan)?$penyimpanan->cara_penyimpanan:'';

				$jenis_pangan = $this->jenis_pangan_model->find($irtp->id_jenis_pangan,'id_jenis_pangan');
				$irtp->nama_jenis_pangan = isset($jenis_pangan->nama_jenis_pangan)?$jenis_pangan->nama_jenis_pangan:'';

				$provinsi = $this->provinsi_model->find($irtp->id_prov,'id_prov');
				$nama_prov = isset($provinsi->nama_prov)?$provinsi->nama_prov:'';

				$kab_kota = $this->kab_kota_model->find($irtp->id_kota,'id_kota');
				$nama_kota = isset($kab_kota->nama_kota)?$kab_kota->nama_kota:'';

				$kecamatan = $this->kecamatan_model->find($irtp->id_kecamatan,'id_kecamatan');
				$nama_kecamatan = isset($kecamatan->nama_kecamatan)?$kecamatan->nama_kecamatan:'';

				$desa = $this->desa_model->find($irtp->id_desa,'id_desa');
				$nama_desa = isset($desa->nama_desa)?$desa->nama_desa:'';

				$no++;
				$row = [];
				$row[] = $no . ".";
				if ($status >= 2) {

					if($irtp->status_no_sppirt==1){
						$button_riwayat = "<a href='javascript:void(0)' onclick='openmodal(`".$irtp->no_sppirt."`,`".$irtp->no_sppirt_lama."`)' style='color:#008FC3'> Lihat riwayat</a><br>";
						$status_no_sppirt = '<br><button type="button" class="badge badge-danger">BERUBAH</button><br>'.$button_riwayat;
					}else{
						$status_no_sppirt = '';
					}

					$row[] = $irtp->no_sppirt.''.$status_no_sppirt.'<br>Masa Berlaku:<br> <i><font color="purple">'.$tgl_berlaku_izin. '</font></i>';
				}
				$row[] = $irtp->nama_produk_pangan;

				$row[] = '<b>Kategori:</b> <i>'.$irtp->nama_kategori_jenis_pangan.'</i><br><b>Jenis:</b> <i>'.$irtp->nama_jenis_pangan.'</i><br><b>Kemasan:</b> <i>'.$irtp->nama_kemasan. '</i> <br><b>Cara Penyimpanan: </b><i>'.$irtp->cara_penyimpanan. '</i>';

				$row[] = $nama_prov.',<br>'.$nama_kota.',<br>'.$nama_kecamatan.'<br>'.$nama_desa;

				$row[] = $irtp->nib;

				// $row[] = $irtp->nama_jenis_pangan;
				// $row[] = $irtp->nama_kemasan;
				//if ($status == 2) {
					//$row[] = date('Y', strtotime($irtp->created_at)) + 5;
				//}

				if ($irtp->status_pengajuan == 0) {
					$status_pengajuan = '<button type="button" class="badge badge-danger">DITOLAK</button>';

					if ($irtp->status_sinkronisasi == 1) {
						$status_sinkronisasi = '<button type="button" class="badge badge-success">SUDAH DISINKRONISASI</button>';
					} else {
						$status_sinkronisasi = '<button type="button" class="badge badge-danger">BELUM DISINKRONISASI</button>';
					}

					$button = '
	  				  	<div class="">
	  				  		<a href="javascript:void(0)" type="button" class="btn btn-primary shadow btn-xs sharp mr-1" onclick=sendData("' . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '")><i class="fa fa-upload"></i></a>
	  					  	<a href="' . base_url('backend/irtp/detail/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" type="button" title="Lihat detail data SPPIRT" class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>

	  	                </div>
			  	';
				} else if ($irtp->status_pengajuan == 1) {
					$status_pengajuan = '<button type="button" class="badge badge-warning">DITUNDA</button>';

					if ($irtp->status_sinkronisasi == 1) {
						$status_sinkronisasi = '<button type="button" class="badge badge-warning">DITUNDA</button>';
					} else {
						$status_sinkronisasi = '<button type="button" class="badge badge-warning">DITUNDA</button>';
					}

					if ($role_id == 2) {
						$button = '
		  				  	<div class="">
		  					  	<a href="' . base_url('backend/irtp/detail/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" type="button" title="Lihat detail data SPPIRT" class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>
		  					  	<a href="' . base_url('backend/irtp/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" type="button" title="Perbaiki ulang data SPPIRT" class="btn btn-pencil shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>

		  	                </div>
				  	';
					} else {
						$button = '
  		  				  	<div class="">
  		  					  	<a href="' . base_url('backend/irtp/detail/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" type="button" title="Lihat detail data SPPIRT" class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>
  		  	                </div>
  				  	';
					}
				} 

				//Jika status 2 -> diterima
				else if ($irtp->status_pengajuan == 2) {
					$status_pengajuan = '<button type="button" class="badge badge-success">DITERBITKAN</button>';


					if ($irtp->status_sinkronisasi == 1) {
						$status_sinkronisasi = '<button type="button" class="badge badge-success">TERKIRIM OSS</button>';
					} else {
						$status_sinkronisasi = '<button type="button" class="badge badge-warning">BELUM TERKIRIM OSS</button>';
					}

					$button_download = "";
					if ($irtp->file_izin != "") {
						$button_download .='<a target="_blank" href='.$irtp->path_fileds.' type="button" class="btn btn-success shadow btn-xs sharp mr-1" title="Download file izin resmi dari OSS"><i class="fa fa-file-text"></i></a>';
					}

					if ($role_id == 1) {

						$button = '
	  				  	<div class="">
	  					  	<a href="javascript:void(0)" type="button" class="btn btn-primary shadow btn-xs sharp mr-1" title="Sinkronasikan Data SPPIRT ke Sistem OSS" onclick=sendData("' . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '")><i class="fa fa-upload"></i></a>
	  					  	<a href="' . base_url('backend/irtp/detail/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" type="button" title="Lihat detail data SPPIRT" class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>
							<a href="javascript:void(0)" type="button" class="btn btn-warning shadow btn-xs sharp mr-1" title="Edit Data SPPIRT" onclick=modalEdit("' . $irtp->id_pengajuan . '")><i class="fa fa-edit"></i></a>
							<a href="' . base_url('backend/irtp/cetak/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" target="_blank" type="button" title="Lihat PDF lembar lampiran 2" class="btn btn-default shadow btn-xs sharp mr-1"><i class="fa fa-file"></i></a>
							' . $button_download . '
							
	  	                </div>
			  			';
					} 
					else {

						$button = '
	  				  	<div class="">
	  					  	<a href="javascript:void(0)" type="button" class="btn btn-primary shadow btn-xs sharp mr-1" title="Sinkronasikan Data SPPIRT ke Sistem OSS" onclick=sendData("' . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '")><i class="fa fa-upload"></i></a>
	  					  	<a href="' . base_url('backend/irtp/detail/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" type="button" title="Lihat detail data SPPIRT" class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>
							<a href="' . base_url('backend/irtp/cetak/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" target="_blank" type="button" title="Lihat PDF lembar lampiran 2" class="btn btn-default shadow btn-xs sharp mr-1"><i class="fa fa-file"></i></a>
							' . $button_download . '
							
	  	                </div>
			  			';
					}
				}

				//jika status 3 -> dibatalkan
				else if ($irtp->status_pengajuan == 3) {
					$status_pengajuan = '<button type="button" class="badge badge-danger">Menunggu PTSP</button>';
					if ($irtp->status_sinkronisasi == 1) {
						$status_sinkronisasi = '<button type="button" class="badge badge-success">TERKIRIM OSS</button>';
					} else {
						$status_sinkronisasi = '<button type="button" class="badge badge-warning">BELUM TERKIRIM OSS</button>';
					}

					$button_download = "";
					if ($irtp->file_izin != "") {
						$button_download .='<a target="_blank" href='.$irtp->path_fileds.' type="button" class="btn btn-success shadow btn-xs sharp mr-1" title="Download file izin resmi dari OSS"><i class="fa fa-file-text"></i></a>';
					}

					$button = '
	  				  	<div class="">
	  					  	<a href="javascript:void(0)" type="button" class="btn btn-primary shadow btn-xs sharp mr-1" title="Sinkronasikan Data SPPIRT ke Sistem OSS" onclick=sendData("' . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '")><i class="fa fa-upload"></i></a>
	  					  	<a href="' . base_url('backend/irtp/detail/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" type="button" title="Lihat detail data SPPIRT" class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>
							<a href="' . base_url('backend/irtp/cetak/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" target="_blank" type="button" title="Lihat PDF lembar lampiran 2" class="btn btn-default shadow btn-xs sharp mr-1"><i class="fa fa-file"></i></a>
							'.$button_download.'
	  	                </div>
			  	';
				}else{
					$status_pengajuan = '<button type="button" class="badge badge-danger">DIBATALKAN</button>';

				}
				$row[] = $tgl_prengajuan;
				// $row[] = $status_pengajuan;
				// if ($irtp->status_pengajuan == 2 || $irtp->status_pengajuan == 0 || $irtp->status_pengajuan == 1) {
					$row[] = $irtp->id_izin.'<br>'.$status_sinkronisasi;
				// }
				$row[] = $button;
				$data[] = $row;
			}
			$output = [
				'draw' => @$_POST['draw'],
				'recordsTotal' => $this->Datatable_Model->countAll($query),
				'recordsFiltered' => $this->Datatable_Model->countFilters($query, $this->column_order, $this->column_search, $this->order),
				'data' => $data,
			];


			echo json_encode($output);
		} else {
			exit('Proses Tidak Dapat Dilanjutkan');
		}
	}

	// function getData($status)
	// {
	// 	if ($this->input->is_ajax_request()) {

	// 		$role_id = $this->session->userdata('userData')['id_role'];
	// 		if ($role_id == 2) {
	// 			$where['tb_pengajuan_sppirt.id_user'] = $this->session->userdata('userData')['id'];
	// 		} else if ($role_id == 3 || $role_id == 4) {
	// 			$where['id_kota'] = $this->session->userdata('userData')['id_kota'];
	// 		} else if ($role_id == 5) {
	// 			$where['id_prov'] = $this->session->userdata('userData')['id_prov'];
	// 		}

	// 		$where['tb_pengajuan_sppirt.deleted_at'] = null;
	// 		$where['status_pengajuan'] = $status;

	// 		$query = [
	// 			'table' => 'tb_pengajuan_sppirt',
	// 			// 'select' => '*, tb_pengajuan_sppirt.created_at as tgl_pengajuan',
	// 			'select' => 'tb_pengajuan_sppirt.created_at as tgl_pengajuan, tb_pengajuan_sppirt.created_at as tgl_pengajuan, tb_pengajuan_sppirt.nib, tb_pengajuan_sppirt.status_pengajuan, tb_pengajuan_sppirt.id_pengajuan, tb_pengajuan_sppirt.nama_produk_pangan, tb_pengajuan_sppirt.file_izin, tb_pengajuan_sppirt.no_sppirt, tb_pengajuan_sppirt.no_sppirt_lama, tb_pengajuan_sppirt.status_no_sppirt, tb_pengajuan_sppirt.status_sinkronisasi, tb_pengajuan_sppirt.id_izin, tb_user.id_prov, tb_user.id_kota, tb_kategori_jenis_pangan.nama_kategori_jenis_pangan, tb_jenis_kemasan.nama_kemasan, tb_penyimpanan.cara_penyimpanan, tb_jenis_pangan.nama_jenis_pangan ',
	// 			'where' => $where,
	// 			'join' => [
	// 				['tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'inner'],
	// 				['tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan', 'inner'],
	// 				['tb_kategori_jenis_pangan', 'tb_kategori_jenis_pangan.id_kategori_jenis_pangan = tb_jenis_pangan.id_kategori_jenis_pangan', 'inner'],
	// 				['tb_jenis_kemasan', 'tb_jenis_kemasan.id_jenis_kemasan = tb_input_data_produk.id_jenis_kemasan', 'inner'],
	// 				['tb_penyimpanan', 'tb_penyimpanan.id_penyimpanan = tb_input_data_produk.id_penyimpanan', 'inner'],
	// 				['tb_user', 'tb_user.id_user = tb_pengajuan_sppirt.id_user', 'inner'],
	// 				// ['tb_provinsi', 'tb_provinsi.id_prov = tb_user.id_prov', 'inner'],
	// 				// ['tb_kota', 'tb_kota.id_prov = tb_provinsi.id_prov', 'inner']

	// 			]
	// 		];
	// 		// var_dump($this->input->post('tipe'));
	// 		$sppirt = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
	// 		// var_dump(
	// 		// $this->db->last_query($sppirt)
	// 		// );die;
	// 		$data = [];
	// 		$no = @$_POST['start'];
	// 		foreach ($sppirt as $irtp) {

	// 			$tgl_berlaku_izin = date('d-m-Y', strtotime('+5 years', strtotime($irtp->tgl_pengajuan)));
	// 			$tgl_prengajuan = date('d-m-Y', strtotime($irtp->tgl_pengajuan));

	// 			$provinsi = $this->provinsi_model->find($irtp->id_prov,'id_prov');
	// 			$nama_prov = isset($provinsi->nama_prov)?$provinsi->nama_prov:'';

	// 			$kab_kota = $this->kab_kota_model->find($irtp->id_kota,'id_kota');
	// 			$nama_kota = isset($kab_kota->nama_kota)?$kab_kota->nama_kota:'';

	// 			$no++;
	// 			$row = [];
	// 			$row[] = $no . ".";
	// 			if ($status >= 2) {

	// 				if($irtp->status_no_sppirt==1){
	// 					$button_riwayat = "<a href='javascript:void(0)' onclick='openmodal(`".$irtp->no_sppirt."`,`".$irtp->no_sppirt_lama."`)' style='color:#008FC3'> Lihat riwayat</a><br>";
	// 					$status_no_sppirt = '<br><button type="button" class="badge badge-danger">BERUBAH</button><br>'.$button_riwayat;
	// 				}else{
	// 					$status_no_sppirt = '';
	// 				}

	// 				$row[] = $irtp->no_sppirt.''.$status_no_sppirt.'<br>Masa Berlaku:<br> <i><font color="purple">'.$tgl_berlaku_izin. '</font></i>';
	// 			}
	// 			$row[] = $irtp->nama_produk_pangan;

	// 			$row[] = '<b>Kategori:</b> <i>'.$irtp->nama_kategori_jenis_pangan.'</i><br><b>Jenis:</b> <i>'.$irtp->nama_jenis_pangan.'</i><br><b>Kemasan:</b> <i>'.$irtp->nama_kemasan. '</i> <br><b>Cara Penyimpanan: </b><i>'.$irtp->cara_penyimpanan. '</i>';

	// 			$row[] = $nama_prov.'<br>'.$nama_kota;

	// 			$row[] = $irtp->nib;

	// 			// $row[] = $irtp->nama_jenis_pangan;
	// 			// $row[] = $irtp->nama_kemasan;
	// 			//if ($status == 2) {
	// 				//$row[] = date('Y', strtotime($irtp->created_at)) + 5;
	// 			//}

	// 			if ($irtp->status_pengajuan == 0) {
	// 				$status_pengajuan = '<button type="button" class="badge badge-danger">DITOLAK</button>';

	// 				if ($irtp->status_sinkronisasi == 1) {
	// 					$status_sinkronisasi = '<button type="button" class="badge badge-success">SUDAH DISINKRONISASI</button>';
	// 				} else {
	// 					$status_sinkronisasi = '<button type="button" class="badge badge-danger">BELUM DISINKRONISASI</button>';
	// 				}

	// 				$button = '
	//   				  	<div class="">
	//   				  		<a href="javascript:void(0)" type="button" class="btn btn-primary shadow btn-xs sharp mr-1" onclick=sendData("' . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '")><i class="fa fa-upload"></i></a>
	//   					  	<a href="' . base_url('backend/irtp/detail/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" type="button" title="Lihat detail data SPPIRT" class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>

	//   	                </div>
	// 		  	';
	// 			} else if ($irtp->status_pengajuan == 1) {
	// 				$status_pengajuan = '<button type="button" class="badge badge-warning">DITUNDA</button>';

	// 				if ($irtp->status_sinkronisasi == 1) {
	// 					$status_sinkronisasi = '<button type="button" class="badge badge-warning">DITUNDA</button>';
	// 				} else {
	// 					$status_sinkronisasi = '<button type="button" class="badge badge-warning">DITUNDA</button>';
	// 				}

	// 				if ($role_id == 2) {
	// 					$button = '
	// 	  				  	<div class="">
	// 	  					  	<a href="' . base_url('backend/irtp/detail/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" type="button" title="Lihat detail data SPPIRT" class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>
	// 	  					  	<a href="' . base_url('backend/irtp/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" type="button" title="Perbaiki ulang data SPPIRT" class="btn btn-pencil shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>

	// 	  	                </div>
	// 			  	';
	// 				} else {
	// 					$button = '
 //  		  				  	<div class="">
 //  		  					  	<a href="' . base_url('backend/irtp/detail/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" type="button" title="Lihat detail data SPPIRT" class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>
 //  		  	                </div>
 //  				  	';
	// 				}
	// 			} 

	// 			//Jika status 2 -> diterima
	// 			else if ($irtp->status_pengajuan == 2) {
	// 				$status_pengajuan = '<button type="button" class="badge badge-success">DITERBITKAN</button>';


	// 				if ($irtp->status_sinkronisasi == 1) {
	// 					$status_sinkronisasi = '<button type="button" class="badge badge-success">TERKIRIM OSS</button>';
	// 				} else {
	// 					$status_sinkronisasi = '<button type="button" class="badge badge-warning">BELUM TERKIRIM OSS</button>';
	// 				}

	// 				$button_download = "";
	// 				if ($irtp->file_izin != "") {
	// 					$button_download .='<a target="_blank" href='.$irtp->path_fileds.' type="button" class="btn btn-success shadow btn-xs sharp mr-1" title="Download file izin resmi dari OSS"><i class="fa fa-file-text"></i></a>';
	// 				}

	// 				if ($role_id == 1) {

	// 					$button = '
	//   				  	<div class="">
	//   					  	<a href="javascript:void(0)" type="button" class="btn btn-primary shadow btn-xs sharp mr-1" title="Sinkronasikan Data SPPIRT ke Sistem OSS" onclick=sendData("' . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '")><i class="fa fa-upload"></i></a>
	//   					  	<a href="' . base_url('backend/irtp/detail/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" type="button" title="Lihat detail data SPPIRT" class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>
	// 						<a href="javascript:void(0)" type="button" class="btn btn-warning shadow btn-xs sharp mr-1" title="Edit Data SPPIRT" onclick=modalEdit("' . $irtp->id_pengajuan . '")><i class="fa fa-edit"></i></a>
	// 						<a href="' . base_url('backend/irtp/cetak/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" target="_blank" type="button" title="Lihat PDF lembar lampiran 2" class="btn btn-default shadow btn-xs sharp mr-1"><i class="fa fa-file"></i></a>
	// 						' . $button_download . '
							
	//   	                </div>
	// 		  			';
	// 				} 
	// 				else {

	// 					$button = '
	//   				  	<div class="">
	//   					  	<a href="javascript:void(0)" type="button" class="btn btn-primary shadow btn-xs sharp mr-1" title="Sinkronasikan Data SPPIRT ke Sistem OSS" onclick=sendData("' . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '")><i class="fa fa-upload"></i></a>
	//   					  	<a href="' . base_url('backend/irtp/detail/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" type="button" title="Lihat detail data SPPIRT" class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>
	// 						<a href="' . base_url('backend/irtp/cetak/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" target="_blank" type="button" title="Lihat PDF lembar lampiran 2" class="btn btn-default shadow btn-xs sharp mr-1"><i class="fa fa-file"></i></a>
	// 						' . $button_download . '
							
	//   	                </div>
	// 		  			';
	// 				}
	// 			}

	// 			//jika status 3 -> dibatalkan
	// 			else if ($irtp->status_pengajuan == 3) {
	// 				$status_pengajuan = '<button type="button" class="badge badge-danger">Menunggu PTSP</button>';
	// 				if ($irtp->status_sinkronisasi == 1) {
	// 					$status_sinkronisasi = '<button type="button" class="badge badge-success">TERKIRIM OSS</button>';
	// 				} else {
	// 					$status_sinkronisasi = '<button type="button" class="badge badge-warning">BELUM TERKIRIM OSS</button>';
	// 				}

	// 				$button_download = "";
	// 				if ($irtp->file_izin != "") {
	// 					$button_download .='<a target="_blank" href='.$irtp->path_fileds.' type="button" class="btn btn-success shadow btn-xs sharp mr-1" title="Download file izin resmi dari OSS"><i class="fa fa-file-text"></i></a>';
	// 				}

	// 				$button = '
	//   				  	<div class="">
	//   					  	<a href="javascript:void(0)" type="button" class="btn btn-primary shadow btn-xs sharp mr-1" title="Sinkronasikan Data SPPIRT ke Sistem OSS" onclick=sendData("' . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '")><i class="fa fa-upload"></i></a>
	//   					  	<a href="' . base_url('backend/irtp/detail/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" type="button" title="Lihat detail data SPPIRT" class="btn btn-info shadow btn-xs sharp mr-1"><i class="fa fa-eye"></i></a>
	// 						<a href="' . base_url('backend/irtp/cetak/') . encrypt_decrypt('encrypt', $irtp->id_pengajuan) . '" target="_blank" type="button" title="Lihat PDF lembar lampiran 2" class="btn btn-default shadow btn-xs sharp mr-1"><i class="fa fa-file"></i></a>
	// 						'.$button_download.'
	//   	                </div>
	// 		  	';
	// 			}else{
	// 				$status_pengajuan = '<button type="button" class="badge badge-danger">DIBATALKAN</button>';

	// 			}
	// 			$row[] = $tgl_prengajuan;
	// 			// $row[] = $status_pengajuan;
	// 			// if ($irtp->status_pengajuan == 2 || $irtp->status_pengajuan == 0 || $irtp->status_pengajuan == 1) {
	// 				$row[] = $irtp->id_izin.'<br>'.$status_sinkronisasi;
	// 			// }
	// 			$row[] = $button;
	// 			$data[] = $row;
	// 		}
	// 		$output = [
	// 			'draw' => @$_POST['draw'],
	// 			'recordsTotal' => $this->Datatable_Model->countAll($query),
	// 			'recordsFiltered' => $this->Datatable_Model->countFilters($query, $this->column_order, $this->column_search, $this->order),
	// 			'data' => $data,
	// 		];


	// 		echo json_encode($output);
	// 	} else {
	// 		exit('Proses Tidak Dapat Dilanjutkan');
	// 	}
	// }


	function detail($id_pengajuan)
	{
		$id_pengajuan = strip_tags($id_pengajuan);
		$id_pengajuan = encrypt_decrypt('decrypt', $id_pengajuan);

		$this->db->select('*')
			->join('tb_user', 'tb_user.id_user = tb_pengajuan_sppirt.id_user')
			->join('tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
			->join('tb_input_label_produk', 'tb_input_label_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
			->join('tb_jenis_kemasan', 'tb_jenis_kemasan.id_jenis_kemasan = tb_input_data_produk.id_jenis_kemasan')
			->join('tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan')
			->join('tb_proses_produksi', 'tb_proses_produksi.id_proses_produksi = tb_input_data_produk.id_proses_produksi')
			->join('tb_penyimpanan', 'tb_penyimpanan.id_penyimpanan = tb_input_data_produk.id_penyimpanan')
			->join('tb_kategori_jenis_pangan', 'tb_jenis_pangan.id_kategori_jenis_pangan = tb_kategori_jenis_pangan.id_kategori_jenis_pangan')
			->where('tb_pengajuan_sppirt.id_pengajuan', $id_pengajuan);
		$irtp = $this->db->get('tb_pengajuan_sppirt')->row();
		//var_dump($id_pengajuan);die;
		$data = [
			'title' => 'Detail Pengajuan',
			'irtp' => $irtp,
			'breadcrumb' => breadcrumb('Detail Pengajuan', 'backend/irtp/detail/' . encrypt_decrypt('encrypt', $id_pengajuan))
		];
		if ($irtp) {
			$this->template->load('template/backend', 'backend/irtp/detail-pengajuan', $data);
		} else {
			$this->template->load('template/backend', 'errors/backend404', $data);
		}
	}
	function cetak($id_pengajuan)
	{
		$id_pengajuan = strip_tags($id_pengajuan);
		$id_pengajuan = encrypt_decrypt('decrypt', $id_pengajuan);

		$this->db->select('*, tb_pengajuan_sppirt.created_at as tahun, tb_pengajuan_sppirt.nomor_izin, tb_user.id_prov, tb_user.id_kota, tb_user.id_kecamatan, tb_user.id_desa')
			->join('tb_pelaku_usaha', 'tb_pelaku_usaha.nib = tb_pengajuan_sppirt.nib')
			->join('tb_user', 'tb_user.id_user = tb_pengajuan_sppirt.id_user')
			->join('tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
			->join('tb_input_label_produk', 'tb_input_label_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
			->join('tb_jenis_kemasan', 'tb_jenis_kemasan.id_jenis_kemasan = tb_input_data_produk.id_jenis_kemasan')
			->join('tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan')
			->join('tb_proses_produksi', 'tb_proses_produksi.id_proses_produksi = tb_input_data_produk.id_proses_produksi')
			->join('tb_penyimpanan', 'tb_penyimpanan.id_penyimpanan = tb_input_data_produk.id_penyimpanan')
			->join('tb_kategori_jenis_pangan', 'tb_jenis_pangan.id_kategori_jenis_pangan = tb_kategori_jenis_pangan.id_kategori_jenis_pangan')
			->where('tb_pengajuan_sppirt.id_pengajuan', $id_pengajuan);
		$irtp = $this->db->get('tb_pengajuan_sppirt')->row();

		$pengajuan_sppirt = $this->pengajuan_sppirt_model->find($id_pengajuan, 'id_pengajuan');

		$provinsi = $this->provinsi_model->find($irtp->id_prov, 'id_prov');
		$kab_kota = $this->kab_kota_model->find($irtp->id_kota, 'id_kota');
		$kecamatan = $this->kecamatan_model->find($irtp->id_kecamatan, 'id_kecamatan');
		$desa = $this->desa_model->find($irtp->id_desa, 'id_desa');

		$tahun_berlaku = (date("Y", strtotime($irtp->tahun)) + 5);
		$tgl_berlaku_izin = date('d-m-Y', strtotime('+5 years', strtotime($pengajuan_sppirt->created_at)));

		$pdf = new PDF();
		$pdf->SetMargins(20, 20, 20, 20);
		$pdf->SetAutoPageBreak(true, 30);
		// membuat halaman baru
		$pdf->AddPage();
		// setting jenis font yang akan digunakan
		$pdf->SetFont('Arial', 'B', 13.6);
		$pdf->Image('assets/garuda_pancasila.png', 95, 15, 20, 20);
		$pdf->Cell(170, 23, '', 0, 1, 'C');
		$pdf->Cell(170, 17, 'PEMERINTAH REPUBLIK INDONESIA', 0, 1, 'C');
		$pdf->Cell(170, 6, 'PERIZINAN BERUSAHA UNTUK MENUNJANG KEGIATAN USAHA', 0, 1, 'C');
		$pdf->Cell(170, 6, 'SERTIFIKAT PEMENUHAN KOMITMEN PRODUKSI PANGAN OLAHAN', 0, 1, 'C');
		$pdf->Cell(170, 6, 'INDUSTRI RUMAH TANGGA (SPP-IRT)', 0, 1, 'C');
		$pdf->Cell(170, 6, 'LAMPIRAN PB-UMKU: ' . $irtp->nomor_izin, 0, 1, 'C');
		$pdf->Cell(160, 6, '', 0, 1, 'C');

		$pdf->SetFont('Arial', '', 8);
		$pdf->SetFillColor(255, 255, 255);

		$pdf->Cell(30, 6, ' ', 0, 0, 'L');
		$pdf->Cell(40, 6, '1.  No. Pendaftaran ', 0, 0, 'L');
		$pdf->Cell(17, 6, ':', 0, 0, 'R');
		$pdf->MultiCell(0, 6, '' . $irtp->no_sppirt, 0, 1);

		$pdf->Cell(30, 6, ' ', 0, 0, 'L');
		$pdf->Cell(40, 6, '2.  Nama IRTP  ', 0, 0, 'L');
		$pdf->Cell(17, 6, ':', 0, 0, 'R');
		$pdf->MultiCell(80, 6, '' . $irtp->nama_usaha, 0, 1);

		$pdf->Cell(30, 6, ' ', 0, 0, 'L');
		$pdf->Cell(40, 6, '3.  Nama Pemilik ', 0, 0, 'L');
		$pdf->Cell(17, 6, ':', 0, 0, 'R');
		$pdf->MultiCell(80, 6, '' . $irtp->nama_pelaku_usaha, 0, 1);

		$pdf->Cell(30, 6, ' ', 0, 0, 'L');
		$pdf->Cell(40, 6, '4.  Alamat', 0, 0, 'L');
		$pdf->Cell(17, 6, ':', 0, 0, 'R');
		$pdf->MultiCell(80, 6, '' . $irtp->alamat_usaha, 0, 1);

		$pdf->Cell(30, 6, ' ', 0, 0, 'L');
		$pdf->Cell(40, 6, '5.  Provinsi', 0, 0, 'L');
		$pdf->Cell(17, 6, ':', 0, 0, 'R');
		$pdf->MultiCell(80, 6, isset($provinsi->nama_prov) ? $provinsi->nama_prov : '', 0, 1);

		$pdf->Cell(30, 6, ' ', 0, 0, 'L');
		$pdf->Cell(40, 6, '6.  Kabupten/Kota', 0, 0, 'L');
		$pdf->Cell(17, 6, ':', 0, 0, 'R');
		$pdf->MultiCell(80, 6, isset($kab_kota->nama_kota) ? $kab_kota->nama_kota : '', 0, 1);

		$pdf->Cell(30, 6, ' ', 0, 0, 'L');
		$pdf->Cell(40, 6, '7.  Kecamatan', 0, 0, 'L');
		$pdf->Cell(17, 6, ':', 0, 0, 'R');
		$pdf->MultiCell(80, 6, isset($kecamatan->nama_kecamatan) ? $kecamatan->nama_kecamatan : '-', 0, 1);

		$pdf->Cell(30, 6, ' ', 0, 0, 'L');
		$pdf->Cell(40, 6, '8.  Desa', 0, 0, 'L');
		$pdf->Cell(17, 6, ':', 0, 0, 'R');
		$pdf->MultiCell(80, 6, isset($desa->nama_desa) ? $desa->nama_desa : '-', 0, 1);

		$pdf->Cell(30, 6, ' ', 0, 0, 'L');
		$pdf->Cell(40, 6, '9.  Jenis Pangan', 0, 0, 'L');
		$pdf->Cell(17, 6, ':', 0, 0, 'R');
		$pdf->MultiCell(80, 6, '' . $irtp->nama_kategori_jenis_pangan, 0, 1);

		$pdf->Cell(30, 6, ' ', 0, 0, 'L');
		$pdf->Cell(40, 6, '10.  Nama Produk Pangan ', 0, 0, 'L');
		$pdf->Cell(17, 6, ':', 0, 0, 'R');
		$pdf->MultiCell(80, 6, '' . $irtp->nama_jenis_pangan, 0, 1);

		$pdf->Cell(30, 6, ' ', 0, 0, 'L');
		$pdf->Cell(40, 6, '11.  Branding Produk ', 0, 0, 'L');
		$pdf->Cell(17, 6, ':', 0, 0, 'R');
		$pdf->MultiCell(80, 6, '' . $irtp->nama_produk_pangan, 0, 1);

		$pdf->Cell(30, 6, ' ', 0, 0, 'L');
		$pdf->Cell(40, 6, '12.  Komposisi', 0, 0, 'L');
		$pdf->Cell(17, 6, ':', 0, 0, 'R');
		$pdf->MultiCell(80, 6, '' . $irtp->komposisi, 0, 1);

		$pdf->Cell(30, 6, ' ', 0, 0, 'L');
		$pdf->Cell(40, 6, '13.  Kemasan Primer ', 0, 0, 'L');
		$pdf->Cell(17, 6, ':', 0, 0, 'R');
		$pdf->MultiCell(80, 6, '' . $irtp->nama_kemasan, 0, 1);

		$pdf->Cell(30, 6, ' ', 0, 0, 'L');
		$pdf->Cell(40, 6, '14.  Masa Berlaku Sertifikat ', 0, 0, 'L');
		$pdf->Cell(17, 6, ':', 0, 0, 'R');
		$pdf->MultiCell(80, 6, '' . $tgl_berlaku_izin, 0, 1);

		$pdf->Cell(30, 6, ' ', 0, 0, 'L');
		$pdf->Cell(40, 6, '15. Komitmen ', 0, 0, 'L');
		$pdf->Cell(17, 6, ':', 0, 0, 'R');
		$pdf->MultiCell(80, 6, '', 0, 1);

		$pdf->Cell(43, 6, 'a.', 0, 0, 'R');
		$pdf->MultiCell(110, 6, 'Mengikuti Penyuluhan Keamanan Pangan.', 0, 1, 'L');

		$pdf->Cell(43, 6, 'b.', 0, 0, 'R');
		$pdf->MultiCell(110, 6, 'Memenuhi persyaratan Cara Produksi Pangan yang Baik untuk Industri Rumah Tangga (CPPB-IRT) atau higiene sanitasi dan dokumentasi.', 0, 1, 'L');

		$pdf->Cell(43, 6, 'c.', 0, 0, 'R');
		$pdf->MultiCell(110, 6, 'Memenuhi ketentuan label dan iklan pangan olahan.', 0, 1, 'L');

		$pdf->Cell(30, 6, ' ', 0, 0, 'L');
		$pdf->Cell(40, 6, '      Akan dipenuhi dalam waktu 3 bulan', 0, 0, 'L');
		$pdf->Cell(17, 6, '', 0, 0, 'R');
		$pdf->MultiCell(80, 6, '', 0, 1);

		$pdf->Output();
	}

	function send_data($id_pengajuan, $type = 'ACTION CLICK')
	{

		$id_pengajuan = strip_tags($id_pengajuan);
		$id_pengajuan = encrypt_decrypt('decrypt', $id_pengajuan);


		$this->db->select('*, tb_pengajuan_sppirt.created_at as tahun, tb_pengajuan_sppirt.nomor_izin, tb_pengajuan_sppirt.status_pengajuan, tb_pengajuan_sppirt.id_izin as izin_id')
			->join('tb_pelaku_usaha', 'tb_pelaku_usaha.nib = tb_pengajuan_sppirt.nib')
			->join('tb_user', 'tb_user.id_user = tb_pengajuan_sppirt.id_user')
			->join('tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
			->join('tb_input_label_produk', 'tb_input_label_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
			->join('tb_jenis_kemasan', 'tb_jenis_kemasan.id_jenis_kemasan = tb_input_data_produk.id_jenis_kemasan')
			// ->join('tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan')
			->join('tb_proses_produksi', 'tb_proses_produksi.id_proses_produksi = tb_input_data_produk.id_proses_produksi')
			->join('tb_penyimpanan', 'tb_penyimpanan.id_penyimpanan = tb_input_data_produk.id_penyimpanan')
			// ->join('tb_kategori_jenis_pangan', 'tb_jenis_pangan.id_kategori_jenis_pangan = tb_kategori_jenis_pangan.id_kategori_jenis_pangan')
			->where('tb_pengajuan_sppirt.id_pengajuan', $id_pengajuan);
		$irtp = $this->db->get('tb_pengajuan_sppirt')->row();

		$tahun_berlaku = (date("Y", strtotime($irtp->tahun)) + 5);
		$tgl_terbit_izin = date("Y-m-d", strtotime($irtp->created_at));
		$tgl_berlaku_izin = date('Y-m-d', strtotime('+5 years', strtotime($irtp->created_at)));

		$nomor_izin = $irtp->nomor_izin;
		$status_pengajuan = $irtp->status_pengajuan;



		$status_action = 0;
		if ($status_pengajuan == 2) {

			$result_nib = $this->action_cek_nib($irtp->nib);
			$query = $this->pengajuan_sppirt_model->source();
			$query->where('id_izin', $result_nib['id_izin']);
			$pengajuan_sppirt = $query->get()->row();


			if (isset($pengajuan_sppirt->id_izin) && $pengajuan_sppirt->id_pengajuan != $id_pengajuan) {

				if ($type == 'ACTION CLICK') {

					$this->session->set_flashdata('error', 'Silahkan terlebih dahulu melakukan pengajuan baru di sistem OSS ');
					redirect(base_url('backend/irtp/list/diterima'));
				} else {
					return true;
				}
			}

			$redirect = 'diterima';
			$link = base_url() . 'sertifikat/' . encrypt_decrypt('encrypt', $id_pengajuan . '#' . $irtp->nib);

			$param = array(
				"IZINFINAL" => array(
					"nib" => $irtp->nib,
					"id_proyek" => $irtp->id_proyek,
					"oss_id" => $irtp->oss_id,
					"id_izin" => $result_nib['id_izin'],
					"kd_izin" => $irtp->kd_izin,
					"kd_daerah" => $irtp->kd_daerah,
					"nomor_izin" => $nomor_izin,
					"kewenangan" => "0",
					"tgl_terbit_izin" => $tgl_terbit_izin,
					"tgl_berlaku_izin" => $tgl_berlaku_izin,
					"nama_ttd" => "Kepala Badan POM RI",
					"nip_ttd" => "196311091990032001",
					"jabatan_ttd" => "KEPALA BADAN POM RI",
					"status_izin" => "50",
					"file_izin" => "-",
					"keterangan" => $irtp->nama_izin,
					"file_lampiran" => $link,
					"data_pnbp" => [array(
						"kd_akun" => "",
						"kd_penerimaan" => "",
						"nominal" => ""
					)]
				)
			);

			$result = curl_send_data($param);
			if (isset($result['data']) && $result['data']->respon->kode == 200) {

				$data = [
					'status_sinkronisasi' => 1,
					'link' => $link,
				];

				if ($irtp->izin_id == "") {
					$data['id_izin'] = $result_nib['id_izin'];
				}

				if ($nomor_izin == "") {

					$data['nomor_izin'] = $result['data']->respon->nomor_izin;

					$param['IZINFINAL']['nomor_izin'] = $result['data']->respon->nomor_izin;
					$result2 = curl_send_data($param);

					if (isset($result2['data']) && $result2['data']->respon->kode == 200) {
						$status_action = 1;
					} else {
						$status_action = 0;
					}
				} else {
					$status_action = 1;
				}


				$this->db->where('id_pengajuan', $id_pengajuan);
				$this->db->update('tb_pengajuan_sppirt', $data);
			} else {
				$status_action = 0;
			}
		} else if ($status_pengajuan == 0) {

			$redirect = 'ditolak';
			$param = array(
				"IZINFINAL" => array(
					"nib" => $irtp->nib,
					"id_proyek" => $irtp->id_proyek,
					"oss_id" => $irtp->oss_id,
					"id_izin" => $irtp->id_izin,
					"kd_izin" => $irtp->kd_izin,
					"kd_daerah" => $irtp->kd_daerah,
					"nomor_izin" => "-",
					"tgl_terbit_izin" => "",
					"tgl_berlaku_izin" => "",
					"nama_ttd" => "",
					"nip_ttd" => "",
					"jabatan_ttd" => "",
					"status_izin" => "90",
					"file_izin" => "",
					"keterangan" => $irtp->nama_izin,
					"data_pnbp" => [array(
						"kd_akun" => "",
						"kd_penerimaan" => "",
						"nominal" => ""
					)]
				)
			);

			$result = curl_send_data($param);
			if (isset($result['data']) && $result['data']->respon->kode == 200) {

				$data = [
					'status_sinkronisasi' => 1,
					'nomor_izin' => $result['data']->respon->nomor_izin
				];

				$this->db->where('id_pengajuan', $id_pengajuan);
				$this->db->update('tb_pengajuan_sppirt', $data);

				$status_action = 1;
			} else {
				$status_action = 0;
			}
		}


		if ($status_action == 1) {

			if ($type == 'ACTION CLICK') {

				$this->session->set_flashdata('success', 'Sinkronisasi data SPPIRT ke OSS BERHASIL..');
				redirect(base_url('backend/irtp/list/' . $redirect));
			} else {
				return true;
			}
		} else if ($status_action == 0) {

			if ($type == 'ACTION CLICK') {

				$this->session->set_flashdata('error', 'Sinkronisasi data SPPIRT ke OSS GAGAL..');
				redirect(base_url('backend/irtp/list/' . $redirect));
			} else {
				return true;
			}
		}
	}

	public function action_cek_nib($nib)
	{

		$id_izin_arr = array();
		$query = $this->pengajuan_sppirt_model->source();
		$query->select('id_izin');
		$query->where('nib', $nib);
		$query->where('id_izin !=', '');
		$query->group_by('id_izin');
		foreach ($query->get()->result() as $value) {
			$id_izin_arr[] = $value->id_izin;
		}

		$param = array(
			"INQUERYNIB" => array(
				"nib" => $nib
			)
		);
		$result = curl_api_oss($param);
		if (isset($result['data']) && $result['data']->respon->kode == 200) {

			$data_nib = $result['data']->respon->dataNIB;
			$pelaku_usaha = $this->pelaku_usaha_model->find($data_nib->nib, 'nib');

			if (isset($pelaku_usaha->nib)) {

				$datPelakuUsaha = array(
					"nib"	=>	$data_nib->nib,
					// "type_desc"	=>	$data_nib->type_desc,
					"tgl_terbit_nib"	=>	$data_nib->tgl_terbit_nib,
					"tgl_perubahan_nib"	=>	$data_nib->tgl_perubahan_nib,
					"npwp_perseroan"	=>	$data_nib->npwp_perseroan,
					"nama_perseroan"	=>	$data_nib->nama_perseroan,
					"alamat_perseroan"	=>	$data_nib->alamat_perseroan,
					"nomor_telpon_perseroan"	=>	$data_nib->nomor_telpon_perseroan,
					"email_perusahaan"	=>	$data_nib->email_perusahaan,
					"dagangan_utama"	=>	isset($data_nib->dagangan_utama) ? $data_nib->dagangan_utama : null,
					"identitas_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->jns_identitas_penanggung_jwb,
					"nama_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->nama_penanggung_jwb,
					"jabatan_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->jabatan_penanggung_jwb,
					"nik_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->no_identitas_penanggung_jwb,
					"npwp_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->npwp_penanggung_jwb,
					"alamat_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->alamat_penanggung_jwb,
					"email_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->email_penanggung_jwb,
					"no_akta"	=>	$data_nib->no_akta_lama,
					"tgl_akta"	=>	$data_nib->tgl_akta_lama,
					"nama_notaris"	=>	$data_nib->legalitas[0]->nama_notaris,
					"alamat_notaris"	=>	$data_nib->legalitas[0]->alamat_notaris,
					"telepon_notaris"	=>	$data_nib->legalitas[0]->telepon_notaris,
					"no_pengesahan"	=>	$data_nib->no_pengesahan,
					"tgl_pengesahan"	=>	$data_nib->tgl_pengesahan,
					"no_id_user_proses"	=>	$data_nib->no_id_user_proses,
					"nama_user_proses"	=>	$data_nib->nama_user_proses,
					"email_user_proses"	=>	$data_nib->email_user_proses,
					"hp_user_proses"	=>	$data_nib->hp_user_proses,
					"user_id_proses"	=>	$data_nib->no_id_user_proses,
					"oss_id"	=>	$data_nib->oss_id,
					// "user_password_proses"	=>	$data_nib->user_password_proses,
				);

				$number = 0;
				foreach ($data_nib->data_checklist as $key => $value) {
					if ($value->kd_izin == '063000000047' && !in_array($value->id_izin, $id_izin_arr)) {
						$number = 1;
						$datPelakuUsaha['id_proyek'] = $value->id_proyek;
						$datPelakuUsaha['id_izin'] = $value->id_izin;
						$datPelakuUsaha['kd_daerah'] = $value->kd_daerah;
						$datPelakuUsaha['kd_izin'] = $value->kd_izin;
						$datPelakuUsaha['nama_izin'] = $value->nama_izin;
						break;
					}
				}

				if ($number == 0) {
					foreach ($data_nib->data_checklist as $key => $value) {
						if ($value->kd_izin == '063000000047') {
							$datPelakuUsaha['id_proyek'] = $value->id_proyek;
							$datPelakuUsaha['id_izin'] = $value->id_izin;
							$datPelakuUsaha['kd_daerah'] = $value->kd_daerah;
							$datPelakuUsaha['kd_izin'] = $value->kd_izin;
							$datPelakuUsaha['nama_izin'] = $value->nama_izin;
							break;
						}
					}
				}

				$id = $this->pelaku_usaha_model->update($datPelakuUsaha, $data_nib->nib, 'NIB');
			} else {

				$datPelakuUsaha = array(
					"nib"	=>	$data_nib->nib,
					// "type_desc"	=>	$data_nib->type_desc,
					"tgl_terbit_nib"	=>	$data_nib->tgl_terbit_nib,
					"tgl_perubahan_nib"	=>	$data_nib->tgl_perubahan_nib,
					"npwp_perseroan"	=>	$data_nib->npwp_perseroan,
					"nama_perseroan"	=>	$data_nib->nama_perseroan,
					"alamat_perseroan"	=>	$data_nib->alamat_perseroan,
					"nomor_telpon_perseroan"	=>	$data_nib->nomor_telpon_perseroan,
					"email_perusahaan"	=>	$data_nib->email_perusahaan,
					"dagangan_utama"	=>	isset($data_nib->dagangan_utama) ? $data_nib->dagangan_utama : null,
					"identitas_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->jns_identitas_penanggung_jwb,
					"nama_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->nama_penanggung_jwb,
					"jabatan_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->jabatan_penanggung_jwb,
					"nik_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->no_identitas_penanggung_jwb,
					"npwp_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->npwp_penanggung_jwb,
					"alamat_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->alamat_penanggung_jwb,
					"email_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->email_penanggung_jwb,
					"no_akta"	=>	$data_nib->no_akta_lama,
					"tgl_akta"	=>	$data_nib->tgl_akta_lama,
					"nama_notaris"	=>	$data_nib->legalitas[0]->nama_notaris,
					"alamat_notaris"	=>	$data_nib->legalitas[0]->alamat_notaris,
					"telepon_notaris"	=>	$data_nib->legalitas[0]->telepon_notaris,
					"no_pengesahan"	=>	$data_nib->no_pengesahan,
					"tgl_pengesahan"	=>	$data_nib->tgl_pengesahan,
					"no_id_user_proses"	=>	$data_nib->no_id_user_proses,
					"nama_user_proses"	=>	$data_nib->nama_user_proses,
					"email_user_proses"	=>	$data_nib->email_user_proses,
					"hp_user_proses"	=>	$data_nib->hp_user_proses,
					"user_id_proses"	=>	$data_nib->no_id_user_proses,
					"oss_id"	=>	$data_nib->oss_id,
					// "user_password_proses"	=>	$data_nib->user_password_proses,
				);

				$number = 0;
				foreach ($data_nib->data_checklist as $key => $value) {
					if ($value->kd_izin == '063000000047') {
						$number = 1;
						$datPelakuUsaha['id_proyek'] = $value->id_proyek;
						$datPelakuUsaha['id_izin'] = $value->id_izin;
						$datPelakuUsaha['kd_daerah'] = $value->kd_daerah;
						$datPelakuUsaha['kd_izin'] = $value->kd_izin;
						$datPelakuUsaha['nama_izin'] = $value->nama_izin;
					}
				}

				if ($number == 0) {
					foreach ($data_nib->data_checklist as $key => $value) {
						if ($value->kd_izin == '063000000047') {
							$datPelakuUsaha['id_proyek'] = $value->id_proyek;
							$datPelakuUsaha['id_izin'] = $value->id_izin;
							$datPelakuUsaha['kd_daerah'] = $value->kd_daerah;
							$datPelakuUsaha['kd_izin'] = $value->kd_izin;
							$datPelakuUsaha['nama_izin'] = $value->nama_izin;
							break;
						}
					}
				}

				$id = $this->pelaku_usaha_model->insert($datPelakuUsaha);
			}

			return $datPelakuUsaha;
		} else {

			$this->session->set_flashdata('error', trim(strip_tags($result['data']->respon->keterangan)));
			redirect(base_url('backend/irtp/list/diterima'));
		}
	}

	function fileds($id_pengajuan)
	{

		$id_pengajuan = strip_tags($id_pengajuan);
		$id_pengajuan = encrypt_decrypt('decrypt', $id_pengajuan);

		$pengajuan_sppirt = $this->pengajuan_sppirt_model->find($id_pengajuan, 'id_pengajuan');

		// $uploadPath = realpath(APPPATH . '../assets/file');
		// $tofile= realpath($uploadPath.'/'.$content->file_other);
		header('Content-Type: application/pdf');
		readfile($pengajuan_sppirt->path_fileds);
	}

	public function exportexcel()
	{


		$role_id = $this->session->userdata('userData')['id_role'];
		if ($role_id == 2) {
			$where['tb_pengajuan_sppirt.id_user'] = $this->session->userdata('userData')['id'];
		} else if ($role_id == 3 || $role_id == 4) {
			$where['id_kota'] = $this->session->userdata('userData')['id_kota'];
		} else if ($role_id == 5) {
			$where['id_prov'] = $this->session->userdata('userData')['id_prov'];
		}

		$where['tb_pengajuan_sppirt.deleted_at'] = null;


		$query = [
			'table' => 'tb_pengajuan_sppirt',
			// 'select' => '*, tb_pengajuan_sppirt.created_at as tgl_pengajuan',
			'select' => '
			tb_pengajuan_sppirt.created_at as tgl_pengajuan, 
			tb_pengajuan_sppirt.created_at as tgl_pengajuan, 
			tb_pengajuan_sppirt.nib, 
			tb_pengajuan_sppirt.nama_pelaku_usaha,
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
			tb_user.alamat_usaha, 
			tb_user.id_kota,
			tb_user.no_telp,',
			'where' => $where,
			'join' => [
				['tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan', 'inner'],
				// ['tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan', 'inner'],
				// ['tb_kategori_jenis_pangan', 'tb_kategori_jenis_pangan.id_kategori_jenis_pangan = tb_jenis_pangan.id_kategori_jenis_pangan', 'inner'],
				// ['tb_jenis_kemasan', 'tb_jenis_kemasan.id_jenis_kemasan = tb_input_data_produk.id_jenis_kemasan', 'inner'],
				// ['tb_penyimpanan', 'tb_penyimpanan.id_penyimpanan = tb_input_data_produk.id_penyimpanan', 'inner'],
				['tb_user', 'tb_user.id_user = tb_pengajuan_sppirt.id_user', 'inner'],
				// ['tb_provinsi', 'tb_provinsi.id_prov = tb_user.id_prov', 'inner'],
				// ['tb_kota', 'tb_kota.id_prov = tb_provinsi.id_prov', 'inner']

			]
		];

		require(APPPATH . 'third_party/PHPExcel/PHPExcel.php');
		require(APPPATH . 'third_party/PHPExcel/PHPExcel/Writer/Excel2007.php');

		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('SPPIRT')
			->setLastModifiedBy('SPPIRT')
			->setTitle('REKAP DATA PIRT DITERBITKAN')
			->setKeywords('IRPT Diterima');
		$style_col = array(
			'font' => array('bold' => true),
			'alignment' => [
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			],
		);
		$style_row = array(
			'font' => array('bold' => true),
			'alignment' => [
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			],

		);
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "REKAP DATA PIRT DITERBITKAN");
		$excel->getActiveSheet()->mergeCells('A1:K1');
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A3', 'NO');
		$excel->getActiveSheet()->mergeCells('A3:A4');
		$excel->setActiveSheetIndex(0)->setCellValue('B3', 'NO SPPIRT');
		$excel->getActiveSheet()->mergeCells('B3:B4');
		$excel->setActiveSheetIndex(0)->setCellValue('C3', 'NAMA BRANDING PRODUK');
		$excel->getActiveSheet()->mergeCells('C3:C4');
		$excel->getActiveSheet()->getColumnDimension('C')->setAutoSize();
		$excel->setActiveSheetIndex(0)->setCellValue('D3', 'DATA PRODUK PANGAN');
		$excel->getActiveSheet()->mergeCells('D3:G3');
		$excel->setActiveSheetIndex(0)->setCellValue('D4', 'KATEGORI PANGAN');
		$excel->setActiveSheetIndex(0)->setCellValue('E4', 'JENIS PANGAN');
		$excel->setActiveSheetIndex(0)->setCellValue('F4', 'KEMASAN');
		$excel->setActiveSheetIndex(0)->setCellValue('G4', 'CARA PENYIMPANAN');
		$excel->setActiveSheetIndex(0)->setCellValue('H3', 'NIB');
		$excel->getActiveSheet()->mergeCells('H3:H4');
		$excel->setActiveSheetIndex(0)->setCellValue('I3', 'WILAYAH');
		$excel->getActiveSheet()->mergeCells('I3:I4');
		$excel->setActiveSheetIndex(0)->setCellValue('J3', 'TANGGAL PENGAJUAN');
		$excel->getActiveSheet()->mergeCells('J3:J4');
		$excel->setActiveSheetIndex(0)->setCellValue('K3', 'STATUS OSS');
		$excel->getActiveSheet()->mergeCells('K3:K4');
		$excel->setActiveSheetIndex(0)->setCellValue('L3', 'No. HP');
		$excel->getActiveSheet()->mergeCells('L3:L4');
		$excel->setActiveSheetIndex(0)->setCellValue('M3', 'Nama Pelaku Usaha');
		$excel->getActiveSheet()->mergeCells('M3:M4');
		$excel->setActiveSheetIndex(0)->setCellValue('N3', 'Alamat');
		$excel->getActiveSheet()->mergeCells('N3:N4');

		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);



		$sppirt = $this->Datatable_Model->getDataTables($query, $this->column_order, $this->column_search, $this->order);
		// $data = $this->db->get('tb_pengajuan_sppirt')->row();
		// $status_pengajuan = $data->status_pengajuan;
		// var_dump(
		// $this->db->last_query($sppirt)
		// );die;
		$numrow = 5;
		$no = 1;

		// echo "<pre>";
		// print_r($sppirt);
		// echo "</pre>";
		// die();
		
		foreach ($sppirt as $irtp) {
			
			$tgl_berlaku_izin = date('d-m-Y', strtotime('+5 years', strtotime($irtp->tgl_pengajuan)));
			$tgl_prengajuan = date('d-m-Y', strtotime($irtp->tgl_pengajuan));

			$jenis_kemasan = $this->jenis_kemasan_model->find($irtp->id_jenis_kemasan,'id_jenis_kemasan');
			$irtp->nama_kemasan = isset($jenis_kemasan->nama_kemasan)?$jenis_kemasan->nama_kemasan:'';

			$kategori_jenis_pangan = $this->kategori_jenis_pangan_model->find($irtp->id_kategori_jenis_pangan,'id_kategori_jenis_pangan');
			$irtp->nama_kategori_jenis_pangan = isset($kategori_jenis_pangan->nama_kategori_jenis_pangan)?$kategori_jenis_pangan->nama_kategori_jenis_pangan:'';

			$penyimpanan = $this->penyimpanan_model->find($irtp->id_penyimpanan,'id_penyimpanan');
			$irtp->cara_penyimpanan = isset($penyimpanan->cara_penyimpanan)?$penyimpanan->cara_penyimpanan:'';

			$jenis_pangan = $this->jenis_pangan_model->find($irtp->id_jenis_pangan,'id_jenis_pangan');
			$irtp->nama_jenis_pangan = isset($jenis_pangan->nama_jenis_pangan)?$jenis_pangan->nama_jenis_pangan:'';

			$provinsi = $this->provinsi_model->find($irtp->id_prov,'id_prov');
			$nama_prov = isset($provinsi->nama_prov)?$provinsi->nama_prov:'';

			$kab_kota = $this->kab_kota_model->find($irtp->id_kota,'id_kota');
			$nama_kota = isset($kab_kota->nama_kota)?$kab_kota->nama_kota:'';

			$wilayah = $nama_prov . ', ' . $nama_kota;


			if ($irtp->status_pengajuan == 2) {

				$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no++);
				$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $irtp->no_sppirt);
				$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $irtp->nama_produk_pangan);

				$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $irtp->nama_kategori_jenis_pangan);

				$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $irtp->nama_jenis_pangan);
				$excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $irtp->nama_kemasan);;
				$excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $irtp->cara_penyimpanan);

				$excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $irtp->nib);
				$excel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
				$excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $wilayah);

				$excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $tgl_prengajuan);

				if ($irtp->status_sinkronisasi == 1) {
					$excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, 'Sudah Sinkron OSS');
				} else {
					$excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, 'Belum Sinkron OSS');
				}
				$excel->setActiveSheetIndex(0)->setCellValue('L' . $numrow, $irtp->no_telp);
				$excel->setActiveSheetIndex(0)->setCellValue('M' . $numrow, $irtp->nama_pelaku_usaha);
				$excel->setActiveSheetIndex(0)->setCellValue('N' . $numrow, $irtp->alamat_usaha);
				$numrow++;
			}
		}
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(27);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(55);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(18);
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(22);
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(37);
		$excel->getActiveSheet()->getColumnDimension('J')->setWidth(17);
		$excel->getActiveSheet()->getColumnDimension('K')->setWidth(16);
		$excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
		$excel->getActiveSheet()->getColumnDimension('M')->setWidth(28);
		$excel->getActiveSheet()->getColumnDimension('N')->setWidth(70);

		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("REKAP DATA PIRT DITERBITKAN");
		$excel->setActiveSheetIndex(0);
		$filename = 'Rekap Data PIRT Diterbitkan' . '.xlsx';
		$excel->getActiveSheet()->setTitle("REKAP DATA PIRT DITERBITKAN");
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$writer->save('php://output');
		// $writer->download('php://output');
		exit;
	}

	function edit_data($id_pengajuan)
	{

		$id_pengajuan = strip_tags($id_pengajuan);
		$id_pengajuan = encrypt_decrypt('decrypt', $id_pengajuan);

		$this->db->select('*')
			->join('tb_user', 'tb_user.id_user = tb_pengajuan_sppirt.id_user')
			->join('tb_input_data_produk', 'tb_input_data_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
			->join('tb_input_label_produk', 'tb_input_label_produk.id_pengajuan = tb_pengajuan_sppirt.id_pengajuan')
			->join('tb_jenis_kemasan', 'tb_jenis_kemasan.id_jenis_kemasan = tb_input_data_produk.id_jenis_kemasan')
			->join('tb_jenis_pangan', 'tb_jenis_pangan.id_jenis_pangan = tb_input_data_produk.id_jenis_pangan')
			->join('tb_proses_produksi', 'tb_proses_produksi.id_proses_produksi = tb_input_data_produk.id_proses_produksi')
			->join('tb_penyimpanan', 'tb_penyimpanan.id_penyimpanan = tb_input_data_produk.id_penyimpanan')
			->join('tb_kategori_jenis_pangan', 'tb_jenis_pangan.id_kategori_jenis_pangan = tb_kategori_jenis_pangan.id_kategori_jenis_pangan')
			->where('tb_pengajuan_sppirt.id_pengajuan', $id_pengajuan);
		$irtp = $this->db->get('tb_pengajuan_sppirt')->row();
		//var_dump($id_pengajuan);die;
		$data = [
			'title' => 'Detail Pengajuan',
			'irtp' => $irtp,
			'breadcrumb' => breadcrumb('Detail Pengajuan', 'backend/irtp/edit_data/' . encrypt_decrypt('encrypt', $id_pengajuan))
		];
		if ($irtp) {
			$this->template->load('template/backend', 'backend/irtp/edit-pengajuan', $data);
		} else {
			$this->template->load('template/backend', 'errors/backend404', $data);
		}
	}
	public function edit()
	{
		$id_pengajuan = $this->input->post('id_pengajuan');;
		$no_sppirt_lama = $this->input->post('no_sppirt_lama');
		$no_sppirt_baru = $this->input->post('no_sppirt_baru');
		$nama_produk_pangan = $this->input->post('nama_produk_pangan');
		$keterangan = $this->input->post('keterangan');
		$status = "1";

		if ($no_sppirt_baru == '') {
			$result['pesan'] = 'No SPPIRT tidak boleh kosong';
		} elseif ($nama_produk_pangan == '') {
			$result['pesan'] = 'Nama Branding tidak boleh kosong';
		} else {
			$result['pesan'] = '';
			$query = array(
				'no_sppirt_lama' => $no_sppirt_lama,
				'no_sppirt' => $no_sppirt_baru,
				'nama_produk_pangan' => $nama_produk_pangan,
				'keterangan' => $keterangan,
				'status_no_sppirt' => $status,

			);
			$this->db->set('no_sppirt_lama', $no_sppirt_lama);
			$this->db->set('no_sppirt', $no_sppirt_baru);
			$this->db->set('nama_produk_pangan', $nama_produk_pangan);
			$this->db->set('keterangan', $keterangan);
			$this->db->set('status_no_sppirt', $status);
			$this->db->where('id_pengajuan', $id_pengajuan);
			$this->db->update('tb_pengajuan_sppirt');
		}
		echo json_encode($result);
	}
	
	public function ambilById()
	{
		$id_pengajuan = $this->input->post('id_pengajuan');
		$where = array('id_pengajuan' => $id_pengajuan);
		$data = $this->Datatable_Model->ambilById($where, 'tb_pengajuan_sppirt')->result();
		echo json_encode($data);
	}

	private function _getStatusUser($nib){
		$query = $this->user_model->source();
		$query->select('nib, status_dikembalikan');
		$query->where('nib', $nib);
		$user = $query->get()->row();

		$return = array("response" => FALSE);

		if (!empty($user)) {
			$return = array(
				"response"				=> TRUE,
				"nib"					=> $user->nib,
				"status_dikembalikan"	=> $user->status_dikembalikan
			);

		}

		return $return;
	}
}

/* End of file Irtp.php */
/* Location: ./application/controllers/backend/Irtp.php */
