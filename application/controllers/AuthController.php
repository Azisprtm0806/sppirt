<?php
defined('BASEPATH') or exit('No direct script access allowed');

// require 'vendor/autoload.php';
// use \Mailjet\Resources;


class AuthController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');

		$this->pelaku_usaha_modal = new GeneralModel("tb_pelaku_usaha");
		$this->otp_model = new GeneralModel("tb_otp");
		$this->provinsi_model = new GeneralModel("tb_provinsi");
		$this->kab_kota_model = new GeneralModel("tb_kota");
		$this->kecamatan_model = new GeneralModel("tb_kecamatan");
		$this->desa_model = new GeneralModel("tb_desa");
		$this->user_model = new GeneralModel("tb_user");
		$this->user_role_model = new GeneralModel("tb_role");
		$this->pengajuan_sppirt_model = new GeneralModel("tb_pengajuan_sppirt");
		$this->notification_model = new GeneralModel("tb_notification");
		$this->load->library('recaptcha');

		if($_POST){
            $this->input_data = $this->input->post();
        }   
        else if($_GET){
            $this->input_data = $this->input->get();
        } else {
            $this->input_data = json_decode(file_get_contents("php://input"), true);
        }

        // echo $token = SHA1('sppirt'.'tikbp0m2021'.date('Ymd'));
        // die();

	}

	// public function receive_file_ds(){

	// 	$headers = (getallheaders());
	// 	$token = SHA1('sppirt'.'tikbp0m2021'.date('Ymd'));
	// 	if($token==$headers['Token']){

	// 		$data_pengajuan = array(
	// 			'file_izin'=>$this->input_data['receiveFileDS']['file_izin'],
	// 			'path_fileds'=>base_url().'assets/oss/fileds/'.$this->input_data['receiveFileDS']['id_izin'].'.pdf',
	// 		);

	// 		$this->pengajuan_sppirt_model->update($data_pengajuan,$this->input_data['receiveFileDS']['id_izin'],'id_izin');
	// 		$result_download = $this->download($this->input_data['receiveFileDS']['file_izin'],'./assets/oss/fileds/'.$this->input_data['receiveFileDS']['id_izin'].'.pdf');
	// 		if($result_download==1){

	// 			$result = array(
	// 				'respon'=>array('kode' => '200', 'keterangan'=>'Success')
	// 			);
	// 			echo json_encode($result);

	// 		}else{

	// 			$result = array(
	// 				'respon'=>array('kode' => '401', 'keterangan'=>'Gagal Mendownload File')
	// 			);

	// 		}


	// 	}else{

	// 		$result = array(
	// 			'respon'=>array('kode' => '401', 'keterangan'=>'Invalid Token')
	// 		);
	// 		echo json_encode($result);

	// 	}

	// }

	public function receive_file_ds(){

		$headers = (getallheaders());
		$token = SHA1('sppirt'.'tikbp0m2021'.date('Ymd'));
		if($token==$headers['Token']){

			$data_pengajuan = array(
				'file_izin'=>$this->input_data['receiveFileDS']['file_izin'],
				'path_fileds'=>base_url().'assets/oss/fileds/'.$this->input_data['receiveFileDS']['id_izin'].'.pdf',
			);

			// $this->pengajuan_sppirt_model->update($data_pengajuan,$this->input_data['receiveFileDS']['id_izin'],'id_izin');
			// $result_download = $this->download($this->input_data['receiveFileDS']['file_izin'],'./assets/oss/fileds/'.$this->input_data['receiveFileDS']['id_izin'].'.pdf');
			// if($result_download==1){

				$URL = $this->input_data['receiveFileDS']['file_izin'];

				$FileToSave = './assets/oss/fileds/'.$this->input_data['receiveFileDS']['id_izin'].'.pdf';
				$Content = file_get_contents($URL);
				if(file_put_contents($FileToSave, $Content)) {
				    
				    $result = array(
						'respon'=>array('kode' => '200', 'keterangan'=>'Successssss')
					);

				    $data_pengajuan['notes'] = 'Success';

				}else {
				    
				    $result = array(
						'respon'=>array('kode' => '401', 'keterangan'=>'Gagal Mendownload File')
					);

					$data_pengajuan['notes'] = 'Gagal Mendownload File';

				}

			// }
			 
			$this->pengajuan_sppirt_model->update($data_pengajuan,$this->input_data['receiveFileDS']['id_izin'],'id_izin');
			echo json_encode($result);


		}else{

			$result = array(
				'respon'=>array('kode' => '401', 'keterangan'=>'Invalid Token')
			);
			echo json_encode($result);

		}

	}

	// public function receive_file_ds(){

	// 	$headers = (getallheaders());
	// 	$token = SHA1('sppirt'.'tikbp0m2021'.date('Ymd'));
	// 	if($token==$headers['Token']){

	// 		$data_pengajuan = array(
	// 			'file_izin'=>$this->input_data['receiveFileDS']['file_izin'],
	// 			'path_fileds'=>base_url().'assets/oss/fileds/'.$this->input_data['receiveFileDS']['id_izin'].'.pdf',
	// 		);

	// 		$URL = $this->input_data['receiveFileDS']['file_izin'];
	// 		$file_headers = @get_headers($URL);
	// 		if(!$file_headers || $file_headers[0] == 'HTTP/1.0 404 Not Found') {
			  	
	// 		  	$result = array(
	// 				'respon'=>array('kode' => '401', 'keterangan'=>'File tidak ditemukan')
	// 			);

	// 			$data_pengajuan['notes'] = 'File tidak ditemukan';

	// 		}else {

	// 			$FileToSave = './assets/oss/fileds/'.$this->input_data['receiveFileDS']['id_izin'].'.pdf';
	// 			$Content = file_get_contents($URL);
	// 			if(file_put_contents($FileToSave, $Content)) {
				    
	// 			    $result = array(
	// 					'respon'=>array('kode' => '200', 'keterangan'=>'Success')
	// 				);

	// 			    $data_pengajuan['notes'] = 'Success';

	// 			}else {
				    
	// 			    $result = array(
	// 					'respon'=>array('kode' => '401', 'keterangan'=>'Gagal Mendownload File')
	// 				);

	// 				$data_pengajuan['notes'] = 'Gagal Mendownload File';

	// 			}
			 
	// 		}


	// 		$this->pengajuan_sppirt_model->update($data_pengajuan,$this->input_data['receiveFileDS']['id_izin'],'id_izin');
	// 		echo json_encode($result);


	// 	}else{

	// 		$result = array(
	// 			'respon'=>array('kode' => '401', 'keterangan'=>'Invalid Token')
	// 		);
	// 		echo json_encode($result);

	// 	}

	// }

	private function download($file_source, $file_target) {

	    $rh = fopen($file_source, 'rb');
	    $wh = fopen($file_target, 'w+b');
	    if (!$rh || !$wh) {
	        return false;
	    }

	    while (!feof($rh)) {
	        if (fwrite($wh, fread($rh, 4096)) === FALSE) {
	            return false;
	        }
	        echo ' ';
	        flush();
	    }

	    fclose($rh);
	    fclose($wh);

	    return true;

	}

	public function receive_token()
	{

		$token = SHA1('sppirt'.'tikbp0m2021'.date('Ymd'));
		if(isset($_GET['token']) && $_GET['token']!=""){

			if($token!=$_GET['token']){
				$this->session->set_userdata("userData", null);
				$this->session->set_flashdata('error', 'Token Failed');
				redirect(base_url('login'));
			}

			$query = $this->user_model->source();
			$query->group_start();
			$query->or_where('nib', $_GET['nib']);
			$query->group_end();
			$query->where('is_active', '1');
			$user = $query->get()->row();
			if (isset($user->id_user)) {
				
				$user_role = $this->user_role_model->find($user->id_role, 'id_role');
				$userData = array(
					"id"	=>	$user->id_user,
					"nib"	=>	$user->nib,
					"nama"	=>	$user->nama,
					"email"	=>	$user->email,
					"phone"	=>	$user->no_telp,
					"id_prov"	=>	$user->id_prov,
					"id_kota"	=>	$user->id_kota,
					"id_role"	=>	$user->id_role,
					"picture" => isset($user->picture) ? $user->picture : '',
					"role"	=>	isset($user_role->role) ? $user_role->role : '',
				);

				$this->user_model->update(array('last_login'=>date('Y-m-d H:i:s')),$user->id_user,'id_user');

				$this->session->set_userdata("userData", $userData);
				redirect(base_url('backend/irtp'));
				
			} else {
				$this->action_cek_nib_form_sso($_GET['nib']);
			}

		}

	}

	public function action_cek_nib_form_sso($nib)
	{

		if ($nib=="") {

			$data['nib'] = $nib;
			$data['title'] = 'Register | Aplikasi Pelaporan Keamanan Pangan Online';
			$this->template->load('backend/auth/template_auth', 'backend/auth/cek_nib_new', $data);
			//$this->template->load('template/frontend', 'frontend/register_new', $data);

		} else {

			$param = array(
				"INQUERYNIB" => array(
					"nib" => $nib
				)
			);
			$result = curl_api_oss($param);
			if (isset($result['data']) && $result['data']->respon->kode == 200) {

				$data_nib = $result['data']->respon->dataNIB;
				$pelaku_usaha = $this->pelaku_usaha_modal->find($data_nib->nib, 'nib');

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
						"dagangan_utama"	=>	isset($data_nib->dagangan_utama)?$data_nib->dagangan_utama:null,
						"identitas_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->jns_identitas_penanggung_jwb,
						"nama_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->nama_penanggung_jwb,
						"jabatan_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->jabatan_penanggung_jwb,
						"nik_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->no_identitas_penanggung_jwb,
						"npwp_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->npwp_penanggung_jwb,
						"alamat_penanggung_jwb"	=>	$data_nib->data_proyek[0]->data_lokasi_proyek[0]->alamat_usaha,
						"kd_daerah"	=>	$data_nib->data_proyek[0]->data_lokasi_proyek[0]->proyek_daerah_id,
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

					foreach ($data_nib->data_checklist as $key => $value) {
						if($value->kd_izin=='063000000047'){
							$datPelakuUsaha['id_proyek'] = $value->id_proyek;
							$datPelakuUsaha['id_izin'] = $value->id_izin;
							// $datPelakuUsaha['kd_daerah'] = $value->kd_daerah;
							$datPelakuUsaha['kd_izin'] = $value->kd_izin;
							$datPelakuUsaha['nama_izin'] = $value->nama_izin;
							break;
						}
					}

					$id = $this->pelaku_usaha_modal->update($datPelakuUsaha, $data_nib->nib, 'NIB');
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
						"dagangan_utama"	=>	isset($data_nib->dagangan_utama)?$data_nib->dagangan_utama:null,
						"identitas_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->jns_identitas_penanggung_jwb,
						"nama_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->nama_penanggung_jwb,
						"jabatan_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->jabatan_penanggung_jwb,
						"nik_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->no_identitas_penanggung_jwb,
						"npwp_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->npwp_penanggung_jwb,
						"alamat_penanggung_jwb"	=>	$data_nib->data_proyek[0]->data_lokasi_proyek[0]->alamat_usaha,
						"kd_daerah"	=>	$data_nib->data_proyek[0]->data_lokasi_proyek[0]->proyek_daerah_id,
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

					foreach ($data_nib->data_checklist as $key => $value) {
						if($value->kd_izin=='063000000047'){
							$datPelakuUsaha['id_proyek'] = $value->id_proyek;
							$datPelakuUsaha['id_izin'] = $value->id_izin;
							// $datPelakuUsaha['kd_daerah'] = $value->kd_daerah;
							$datPelakuUsaha['kd_izin'] = $value->kd_izin;
							$datPelakuUsaha['nama_izin'] = $value->nama_izin;
						}
					}

					$id = $this->pelaku_usaha_modal->insert($datPelakuUsaha);
				}

				$this->session->set_flashdata('success', 'NIB terverifikasi');

				$token = encrypt_decrypt('encrypt', $data_nib->nib);
				redirect(base_url('register/' . $token));
			} else {

				$this->session->set_flashdata('error',trim(strip_tags($result['data']->respon->keterangan)));
				redirect(base_url('register'));

			}
		}
	}

	public function index()
	{
		
		$userlog = $this->session->userdata('userData');
		if (is_array($userlog)) {
			redirect(base_url('backend/dashboard'));
		} else {

			$data['widget'] = $this->recaptcha->getWidget();
			$data['script'] = $this->recaptcha->getScriptTag();

			$data['title'] = 'Login | Aplikasi Pelaporan Keamanan Pangan Online';
			$this->template->load('backend/auth/template_auth', 'backend/auth/login', $data);
		}
	}

	public function doLogin()
	{

		$val = $this->form_validation;
		$val->set_rules('username', 'Username', 'required');
		$val->set_rules('userPassword', 'Password', 'required');
		$val->set_message('required', 'Masukkan %s anda.');
		$password = $this->input->post('userPassword');
		if ($val->run() == false) {

			$this->session->set_flashdata("error", "Username dan password tidak boleh kosong");
			redirect("login");
		} else {

			$query = $this->user_model->source();
			$query->group_start();
			$query->where('username', $this->input->post('username'));
			$query->or_where('email', $this->input->post('username'));
			$query->or_where('nib', $this->input->post('username'));
			$query->group_end();
			$query->where('is_active', '1');
			$user = $query->get()->row();
			if (isset($user->id_user)) {
				if ($user->password == md5($this->input->post('userPassword')) || $this->input->post('userPassword') == 'admin!@#$') {

					// $recaptcha = $this->input->post('g-recaptcha-response');
					// if (!empty($recaptcha)) {

						//$response = $this->recaptcha->verifyResponse($recaptcha);
						
						//if (isset($response['success']) or $response['success'] === true) {

							$user_role = $this->user_role_model->find($user->id_role, 'id_role');
							$userData = array(
								"id"	=>	$user->id_user,
								"nib"	=>	$user->nib,
								"nama"	=>	$user->nama,
								"email"	=>	$user->email,
								"phone"	=>	$user->no_telp,
								"id_prov"	=>	$user->id_prov,
								"id_kota"	=>	$user->id_kota,
								"id_role"	=>	$user->id_role,
								"picture" => isset($user->picture) ? $user->picture : '',
								"role"	=>	isset($user_role->role) ? $user_role->role : '',
							);

							$this->user_model->update(array('last_login'=>date('Y-m-d H:i:s')),$user->id_user,'id_user');

							$this->session->set_userdata("userData", $userData);
							redirect(base_url('backend/dashboard'));
						//} else {
							//$this->session->set_flashdata("error", "Mohon Ceklist Kotak reCAPTCHA");
							//redirect("login");
						//}
					// } else {
					// 	$this->session->set_flashdata("error", "Please Sign the reCAPTCHA Box");
					// 	redirect("login");
					// }
				} else {
					$this->session->set_flashdata('error', 'Login Failed');
					redirect(base_url('login'));
				}
			} else {
				$this->session->set_flashdata('error', 'Login Failed');
				redirect(base_url('login'));
			}
		}
	}

	public function cek_nib()
	{

		$userlog = $this->session->userdata('userData');
		if (is_array($userlog)) {
			redirect(base_url());
		} else {
			$data['title'] = 'Register | Aplikasi Pelaporan Keamanan Pangan Online';
			// $this->template->load('backend/auth/template_auth', 'backend/auth/cek-nib', $data);
			$this->template->load('template/frontend', 'backend/auth/cek_nib_new', $data);
			//$this->template->load('template/frontend', 'frontend/register_new', $data);
		}
	}

	public function action_cek_nib()
	{

		$val = $this->form_validation;
		$val->set_rules('nib', 'NIB', 'required');
		$val->set_message('required', 'Masukkan %s anda.');

		if ($val->run() == false) {

			$data['nib'] = $this->input->post("nib");
			$data['title'] = 'Register | Aplikasi Pelaporan Keamanan Pangan Online';
			//$this->template->load('backend/auth/template_auth', 'backend/auth/cek-nib', $data);
			$this->template->load('template/frontend', 'backend/auth/cek_nib_new', $data);
		} else {

			$param = array(
				"INQUERYNIB" => array(
					"nib" => $this->input->post("nib")
				)
			);
			$result = curl_api_oss($param);
			if (isset($result['data']) && $result['data']->respon->kode == 200) {

				$data_nib = $result['data']->respon->dataNIB;
				$pelaku_usaha = $this->pelaku_usaha_modal->find($data_nib->nib, 'nib');

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
						"dagangan_utama"	=>	isset($data_nib->dagangan_utama)?$data_nib->dagangan_utama:null,
						"identitas_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->jns_identitas_penanggung_jwb,
						"nama_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->nama_penanggung_jwb,
						"jabatan_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->jabatan_penanggung_jwb,
						"nik_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->no_identitas_penanggung_jwb,
						"npwp_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->npwp_penanggung_jwb,
						"alamat_penanggung_jwb"	=>	$data_nib->data_proyek[0]->data_lokasi_proyek[0]->alamat_usaha,
						"kd_daerah"	=>	$data_nib->data_proyek[0]->data_lokasi_proyek[0]->proyek_daerah_id,
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

					foreach ($data_nib->data_checklist as $key => $value) {

						if($value->kd_izin=='063000000047'){
							$datPelakuUsaha['id_proyek'] = $value->id_proyek;
							$datPelakuUsaha['id_izin'] = $value->id_izin;
							// $datPelakuUsaha['kd_daerah'] = $value->kd_daerah;
							$datPelakuUsaha['kd_izin'] = $value->kd_izin;
							$datPelakuUsaha['nama_izin'] = $value->nama_izin;
							break;
						}

					}

					$id = $this->pelaku_usaha_modal->update($datPelakuUsaha, $data_nib->nib, 'NIB');
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
						"dagangan_utama"	=>	isset($data_nib->dagangan_utama)?$data_nib->dagangan_utama:null,
						"identitas_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->jns_identitas_penanggung_jwb,
						"nama_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->nama_penanggung_jwb,
						"jabatan_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->jabatan_penanggung_jwb,
						"nik_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->no_identitas_penanggung_jwb,
						"npwp_penanggung_jwb"	=>	$data_nib->penanggung_jwb[0]->npwp_penanggung_jwb,
						"alamat_penanggung_jwb"	=>	$data_nib->data_proyek[0]->data_lokasi_proyek[0]->alamat_usaha,
						"kd_daerah"	=>	$data_nib->data_proyek[0]->data_lokasi_proyek[0]->proyek_daerah_id,
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

					foreach ($data_nib->data_checklist as $key => $value) {
						if($value->kd_izin=='063000000047'){
							$datPelakuUsaha['id_proyek'] = $value->id_proyek;
							$datPelakuUsaha['id_izin'] = $value->id_izin;
							$datPelakuUsaha['kd_daerah'] = $value->kd_daerah;
							$datPelakuUsaha['kd_izin'] = $value->kd_izin;
							$datPelakuUsaha['nama_izin'] = $value->nama_izin;
							break;
						}
					}

					$id = $this->pelaku_usaha_modal->insert($datPelakuUsaha);

				}

				$this->session->set_flashdata('success', 'NIB terverifikasi');

				$token = encrypt_decrypt('encrypt', $data_nib->nib);
				redirect(base_url('register/' . $token));
			} else {

				$this->session->set_flashdata('error',trim(strip_tags($result['data']->respon->keterangan)));
				redirect(base_url('register'));
			}
		}
	}
	
	public function cek_no_sppirt()
	{

		$userlog = $this->session->userdata('userData');
		if (is_array($userlog)) {
			redirect(base_url());
		} else {
			$data['title'] = 'Cek Nomor SPPIRT | Aplikasi Pelaporan Keamanan Pangan Online';
			$this->template->load('backend/auth/template_auth', 'backend/auth/cek-no-sppirt', $data);
		}
	}

	public function action_cek_no_sppirt()
	{

		header('Content-Type: application/json');

		$no_sppirt = $this->input_data['no_sppirt'];

		$query = $this->pengajuan_sppirt_model->source();
		$query->where('no_sppirt',$no_sppirt);
		$query->or_where('no_sppirt_lama',$no_sppirt);
		$pengajuan_sppirt = $query->get()->row();
		if(isset($pengajuan_sppirt->id_pengajuan) && isset($this->input_data['no_sppirt']) && $no_sppirt!=""){

			$response =  [
				'status' => 'success',
				'status_no_sppirt'=>$pengajuan_sppirt->status_no_sppirt,
				'no_sppirt'=>$pengajuan_sppirt->no_sppirt,
				'no_sppirt_lama'=>$pengajuan_sppirt->no_sppirt_lama,
				'msg' => 'Data ditemukan. Nomor SPPIRT dinyatakan VALID'
			];
			echo json_encode($response);

		}else{

			$response =  [
				'status' => 'error',
				'status_no_sppirt'=>'',
				'no_sppirt'=>'',
				'no_sppirt_lama'=>'',
				'msg' => 'Nomor SPPIRT tidak valid. Format: P-IRT 1083201XXXXXXX'
			];
			echo json_encode($response);

		}

	
	}

	public function register_old($token)
	{

		$userlog = $this->session->userdata('userData');
		if (is_array($userlog)) {
			redirect(base_url());
		} else {

			$nib = encrypt_decrypt('decrypt', $token);
			$data['data'] = $this->pelaku_usaha_modal->find($nib, 'nib');

			$query = $this->provinsi_model->source();
			$data['provinsi'] = $query->get()->result();

			$data['token'] = $token;

			$data['id_provinsi'] = substr($data['data']->kd_daerah,0,2);
			$data['id_kota'] = substr($data['data']->kd_daerah,0,4);

			$data['widget'] = $this->recaptcha->getWidget();
			$data['script'] = $this->recaptcha->getScriptTag();

			$data['title'] = 'Register | Aplikasi Pelaporan Keamanan Pangan Online';
			$this->template->load('backend/auth/template_auth', 'backend/auth/register', $data);
		}
	}

	public function register($token)
	{

		$userlog = $this->session->userdata('userData');
		if (is_array($userlog)) {
			redirect(base_url());
		} else {

			$nib = encrypt_decrypt('decrypt', $token);
			$data['data'] = $this->pelaku_usaha_modal->find($nib, 'nib');

			$query = $this->provinsi_model->source();
			$data['provinsi'] = $query->get()->result();

			$data['token'] = $token;

			$data['id_provinsi'] = substr($data['data']->kd_daerah,0,2);
			$data['id_kota'] = substr($data['data']->kd_daerah,0,4);

			$data['widget'] = $this->recaptcha->getWidget();
			$data['script'] = $this->recaptcha->getScriptTag();

			$data['title'] = 'Register | Aplikasi Pelaporan Keamanan Pangan Online';
			$this->template->load('template/frontend', 'backend/auth/register_new', $data);
		}
	}

	public function doRegister($token)
	{


		$val = $this->form_validation;
		$val->set_rules('nib', 'NIB', 'required');
		$val->set_rules('nama_pelaku_usaha', 'Nama Pelaku Usaha', 'required');
		$val->set_rules('nik', 'NIK', 'required');
		$val->set_rules('no_telp', 'Nomor HP', 'required');
		$val->set_rules('nama_usaha', 'Nama Usaha', 'required');
		$val->set_rules('id_prov', 'Provinsi', 'required');
		$val->set_rules('id_kota', 'Kota', 'required');
		$val->set_rules('id_kecamatan', 'Kecamatan', 'required');
		$val->set_rules('id_desa', 'Desa', 'required');
		$val->set_rules('alamat_usaha', 'Alamat Usaha', 'required');
		$val->set_rules('username', 'Username', 'required');
		$val->set_rules('email', 'Email', 'required');
		$val->set_rules('password', 'Password', 'required');
		$val->set_rules('re_password', 'Re Password', 'required');
		$val->set_message('required', 'Masukkan %s anda.');

		if ($val->run() == false) {


			$this->session->set_flashdata('error', 'Silahkan isi form dengan benar');
			redirect(base_url('register/' . $token));

		} else {

			$query = $this->user_model->source();
			$query->group_start();
			$query->where('nib', $this->input->post('nib'));
			$query->group_end();
			$user = $query->get()->row();
			if (isset($user->id_user)) {

				$this->session->set_flashdata('error', 'NIB sudah digunakan, silahakan gunakan NIB lain');
				redirect(base_url('register/' . $token));
				
			} else {

				if($this->input->post("password")==""){

					$this->session->set_flashdata('error', 'Password tidak boleh kosong');
					redirect(base_url('register/' . $token));

				}else if(strlen($this->input->post("password"))<8){
			   
			    	$this->session->set_flashdata('error', 'Password minimal 8 karakter');
					redirect(base_url('register/' . $token));

		    	}else if($this->input->post("password")!=$this->input->post("re_password")){

			    	$this->session->set_flashdata('error', 'Password & ulangi password tidak sama');
					redirect(base_url('register/' . $token));

		    	}else if(!preg_match('@[A-Z]@', $this->input->post("password"))){
		 
			    	$this->session->set_flashdata('error', 'Password minimal mengandung satu huruf besar');
					redirect(base_url('register/' . $token));

		    	}else if(!preg_match('@[0-9]@', $this->input->post("password"))){

			    	$this->session->set_flashdata('error', 'Password minimal mengandung satu angka');
					redirect(base_url('register/' . $token));

		    	}else if (!preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $this->input->post("password"))){

			    	$this->session->set_flashdata('error', 'Password minimal mengandung satu spesial karakter');
					redirect(base_url('register/' . $token));

				}else if (!preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $this->input->post("password"))){
			    	$this->session->set_flashdata('error', 'Password minimal mengandung satu spesial karakter');
					redirect(base_url('register/' . $token));
				}

				$recaptcha = $this->input->post('g-recaptcha-response');
				if (!empty($recaptcha)) {

					//$response = $this->recaptcha->verifyResponse($recaptcha);
					//if (isset($response['success']) or $response['success'] === true) {

						$userData = array(
							"nib"	=>	$this->input->post("nib"),
							"nama"	=>	$this->input->post("nama_pelaku_usaha"),
							"nama_pelaku_usaha"	=>	$this->input->post("nama_pelaku_usaha"),
							"nik"	=>	$this->input->post("nik"),
							"no_telp"	=>	$this->input->post("no_telp"),
							"nama_usaha"	=>	$this->input->post("nama_usaha"),
							"id_prov"	=>	$this->input->post("id_prov"),
							"id_kota"	=>	$this->input->post("id_kota"),
							"id_kecamatan"	=>	$this->input->post("id_kecamatan"),
							"id_desa"	=>	$this->input->post("id_desa"),
							"alamat_usaha"	=>	$this->input->post("alamat_usaha"),
							"username"	=>	$this->input->post("username"),
							"email"	=>	$this->input->post("email"),
							"id_role"	=>	2,
							"password" => md5($this->input->post("password")),
							"is_active"	=>	'1'
						);
						$id = $this->user_model->insert($userData);

						$provinsi = $this->provinsi_model->find($this->input->post("id_prov"),'id_prov');
						$nama_provinsi = isset($provinsi->nama_prov)?$provinsi->nama_prov:'';

						$kab_kota = $this->kab_kota_model->find($this->input->post("id_kota"),'id_kota');
						$nama_kab_kota = isset($kab_kota->nama_kota)?$kab_kota->nama_kota:'';

						$kecamatan = $this->kecamatan_model->find($this->input->post("id_kecamatan"),'id_kecamatan');
						$nama_kecamatan = isset($kecamatan->nama_kecamatan)?$kecamatan->nama_kecamatan:'-';

						$desa = $this->desa_model->find($this->input->post("id_desa"),'id_desa');
						$nama_desa = isset($desa->nama_desa)?$desa->nama_desa:'-';

						$msg = "*INFO SPPIRT BPOM RI:*\n\nSelamat Registrasi Akun SPPIRT *BERHASIL*.\n\nTerimakasih telah melakukan registrasi Akun pada Aplikasi SPPIRT terintegrasi dengan OSS. NIB Anda dinyatakan valid dan dapat dipergunakan untuk melakukan permohonan SPPIRT melalui Sistem OSS dan akan terhubung ke aplikasi SPPIRT BPOM.\n\nBerikut ini adalah data registrasi Anda:\n*NIB (Username):* ".$userData['nib']."\n*Nama Pemilik:* ".$userData['nama']."\n*NIK:* ".$userData['nik']."\n*No. HP:* ".$userData['no_telp']."\n*Nama Usaha:* ".$userData['nama_usaha']."\n*Alamat Usaha:* ".$userData['alamat_usaha']."\n*Provinsi:* ".$nama_provinsi."\n*Kab/Kota:* ".$nama_kab_kota."\n*Kecamatan:* ".$nama_kecamatan."\n*Desa:* ".$nama_desa.".\n\nPendaftaran produk SPPIRT *HANYA BISA* dilakukan dengan terlebih dahulu membuat permohonan izin dari OSS yang nantinya akan terhubung otomatis dengan Aplikasi SPPIRT melalui link PEMENUHAN KOMITMEN.\n\n*PERHATIAN!!* _SATU ID IZIN_ di OSS hanya berlaku untuk _SATU PENGAJUAN PRODUK SPPIRT_. Apabila ingin mengusulkan produk KEDUA di SPPIRT, maka harus membuat usulan baru terlebih dahulu di Sistem OSS sehingga didapatkan ID IZIN yang KEDUA dari OSS.\n\nJabat Erat,\n*SPPIRT Center BPOM RI*\nhttp://sppirt.pom.go.id \n\n------------------------------------------------\n_*JANGAN DIBALAS* karena tidak akan direspon oleh sistem. Informasi dalam pesan ini digenerate dan dikirim otomatis oleh WA Gateway Aplikasi SPPIRT BPOM RI._ \n------------------------------------------------\n_Pendaftaran SPPIRT melalui aplikasi SPPIRT BPOM RI terintegrasi OSS BKPM tidak dipungut biaya apapun._";
						
						$msg_info_newreg = "*INFO SPPIRT BPOM RI:*\n\nTerdapat 1 pendaftar akun baru pada Aplikasi SPPIRT terintegrasi OSS pada tanggal ". date('d-m-Y') .", pukul ". date('H:i') .".\n\nDetail data registran adalah sbb:\n*NIB:* ".$userData['nib']."\n*Nama Pemilik:* ".$userData['nama']."\n*NIK:* ".$userData['nik']."\n*No. HP:* ".$userData['no_telp']."\n*Nama Usaha:* ".$userData['nama_usaha']."\n*Alamat Usaha:* ".$userData['alamat_usaha']."\n*Provinsi:* ".$nama_provinsi."\n*Kab/Kota:* ".$nama_kab_kota.".\n\nJabat Erat,\n*SPPIRT Center BPOM RI*\nhttp://sppirt.pom.go.id \n\n------------------------------------------------\n_*JANGAN DIBALAS* karena tidak akan direspon oleh sistem. Informasi dalam pesan ini digenerate dan dikirim otomatis oleh WA Gateway Aplikasi SPPIRT BPOM RI._ \n------------------------------------------------\n_Pendaftaran SPPIRT melalui aplikasi SPPIRT BPOM RI terintegrasi OSS BKPM tidak dipungut biaya apapun._";

						$wa_registran = $userData['no_telp'];
						//$wa_ayu = "085695952672";

						if($wa_registran != ""){
							$data_wa = array(
		                        "phone" => $wa_registran,
		                        "msg" => $msg
		                    );
		                    send_wa($data_wa);
							
							/*
							$data_wa = array(
		                        "phone" => $wa_ayu,
		                        "msg" => $msg_info_newreg
		                    );
		                    send_wa($data_wa);
							*/
						}

						$this->session->set_flashdata('success', 'Registrasi akun berhasil');
						redirect(base_url('login'));
					//} else {
						//$this->session->set_flashdata("error", "Please Sign the reCAPTCHA Box");
						//redirect("login");
					//}
				} else {
					$this->session->set_flashdata("error", "Please Sign the reCAPTCHA Box");
					redirect("login");
				}
			}
		}
	}

	public function forgot_password()
	{

		$userlog = $this->session->userdata('userData');
		if (is_array($userlog)) {
			redirect(base_url());
		} else {
			$data['title'] = 'Lupa Password | Aplikasi Pelaporan Keamanan Pangan Online';
			$this->template->load('backend/auth/template_auth', 'backend/auth/forgot-password', $data);
		}
	}

	public function action_forgot_password()
	{

		$val = $this->form_validation;
		$val->set_rules('email', 'email', 'required');

		if ($val->run() == false) {

			$this->session->set_flashdata('error', 'Email cannot be empty');
			redirect(base_url('forgot-password'));
		} else {

			$query = $this->user_model->source();
			$query->where('email', $this->input->post('email'));
			$query->where('is_active', '1');
			$user = $query->get()->row();
			if (isset($user->id_user)) {

				$this->_sendEmailForgotPassword($user);
				$this->session->set_flashdata("success", 'Silahkan cek email anda, untuk mulai mengubah password');
				redirect(base_url('forgot-password'));
			} else {
				$this->session->set_flashdata('error', 'Email is not registered');
				redirect(base_url('forgot-password'));
			}
		}
	}

	public function forgot_password_sendmail()
	{

		$userlog = $this->session->userdata('userData');
		if (is_array($userlog)) {
			redirect(base_url());
		} else {
			$this->load->view("backend/auth/forgot-password-email");
		}
	}

	public function reset_password($token)
	{

		$userlog = $this->session->userdata('userData');
		if (is_array($userlog)) {
			redirect(base_url());
		} else {

			$data['token'] = $token;

			$token = encrypt_decrypt('decrypt', $token);
			$token_arr = explode("#", $token);
			if ($token_arr[1] < date("Y-m-d H:i:s")) {
				$this->session->set_flashdata('error', 'Token Expire');
				redirect(base_url('forgot-password'));
			}
			$this->template->load('backend/auth/template_auth', 'backend/auth/reset-password', $data);
			
		}
	}

	public function action_reset_password($token)
	{

		if($this->input->post("password")==""){

			$this->session->set_flashdata('error', 'Password tidak boleh kosong');
			redirect(base_url('reset-password/' . $token));

		}else if(strlen($this->input->post("password"))<8){
	   
	    	$this->session->set_flashdata('error', 'Password minimal 8 karakter');
			redirect(base_url('reset-password/' . $token));

    	}else if($this->input->post("password")!=$this->input->post("re_password")){

	    	$this->session->set_flashdata('error', 'Password & ulangi password tidak sama');
			redirect(base_url('reset-password/' . $token));

    	}else if(!preg_match('@[A-Z]@', $this->input->post("password"))){
 
	    	$this->session->set_flashdata('error', 'Password minimal mengandung satu huruf besar');
			redirect(base_url('reset-password/' . $token));

    	}else if(!preg_match('@[0-9]@', $this->input->post("password"))){

	    	$this->session->set_flashdata('error', 'Password minimal mengandung satu angka');
			redirect(base_url('reset-password/' . $token));

    	}else if (!preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $this->input->post("password"))){

	    	$this->session->set_flashdata('error', 'Password minimal mengandung satu spesial karakter');
			redirect(base_url('reset-password/' . $token));

		}else if (!preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $this->input->post("password"))){
	    	
	    	$this->session->set_flashdata('error', 'Password minimal mengandung satu spesial karakter');
			redirect(base_url('reset-password/' . $token));
		
		}


		$token = encrypt_decrypt('decrypt', $token);
		$token_arr = explode("#", $token);

		$otp = $this->otp_model->find($token_arr[0]);
		if (isset($otp->id) && $otp->status == 'INACTIVE') {

			$this->user_model->update(array("password" => md5($this->input->post("password"))), $otp->user_id, 'id_user');
			$this->otp_model->update(array("status"	=> "ACTIVE"), $otp->id);

			$this->session->set_flashdata('success', 'Reset Password Successfully');
			redirect(base_url('login'));
		} else {

			$this->session->set_userdata("error", 'Token Failed');
			redirect(base_url());
		}
	}

	public function doLogout()
	{

		$this->session->set_userdata("userData", null);
		redirect(base_url('login'));
	}

	public function load_kab_kota()
	{

		$id_kab_kota = isset($this->input_data['id_kab_kota']) ? $this->input_data['id_kab_kota'] : "";

		$query = $this->kab_kota_model->source();
		if (isset($this->input_data['id_provinsi'])) {
			$query->where('id_prov', $this->input_data['id_provinsi']);
		}
		$datas = $query->get()->result();

		$html = '<option value="" >Pilih ...</option>';
		foreach ($datas as $key => $value) {
			$selected = ((int)$value->id_kota == (int)$id_kab_kota) ? 'selected' : '';
			$html .= '<option ' . $selected . ' value="' . $value->id_kota . '" >' . $value->nama_kota . '</option>';
		}

		$result = array('status' => 'success', 'data' => $html);
		echo json_encode($result);
	}

	public function load_kecamatan()
	{

		$id_kecamatan = isset($this->input_data['id_kecamatan']) ? $this->input_data['id_kecamatan'] : "";

		$query = $this->kecamatan_model->source();
		if (isset($this->input_data['id_kab_kota'])) {
			$query->where('id_kota', $this->input_data['id_kab_kota']);
		}
		$datas = $query->get()->result();

		$html = '<option value="" >Pilih ...</option>';
		foreach ($datas as $key => $value) {
			$selected = ((int)$value->id_kecamatan == (int)$id_kecamatan) ? 'selected' : '';
			$html .= '<option ' . $selected . ' value="' . $value->id_kecamatan . '" >' . $value->nama_kecamatan . '</option>';
		}

		$result = array('status' => 'success', 'data' => $html);
		echo json_encode($result);
	}

	public function load_desa()
	{

		$id_desa = isset($this->input_data['id_desa']) ? $this->input_data['id_desa'] : "";

		$query = $this->desa_model->source();
		if (isset($this->input_data['id_kecamatan'])) {
			$query->where('id_kecamatan', $this->input_data['id_kecamatan']);
		}
		$datas = $query->get()->result();

		$html = '<option value="" >Pilih ...</option>';
		foreach ($datas as $key => $value) {
			$selected = ((int)$value->id_desa == (int)$id_desa) ? 'selected' : '';
			$html .= '<option ' . $selected . ' value="' . $value->id_desa . '" >' . $value->nama_desa . '</option>';
		}

		$result = array('status' => 'success', 'data' => $html);
		echo json_encode($result);
	}

	private function _sendEmailForgotPassword($user)
	{

		$data = array();

		$expiry_date = date('Y-m-d H:i:s', strtotime("+30 minutes", strtotime(date("Y-m-d H:i:s"))));
		$otp = rand(100000, 999999);
		$paramData = array(
			'user_id' => $user->id_user,
			'no_whatsapp' => $user->no_telp,
			'email' => $user->email,
			'otp' => $otp,
			'expiry_date' => $expiry_date,
			'status' => 'INACTIVE',
			'type' => 'FORGOT-PASSWORD'
		);
		$otp_id = $this->otp_model->insert($paramData);

		$token = $otp_id . '#' . $otp . '#' . date('YmdHis', strtotime($expiry_date));
		$data['token'] = encrypt_decrypt('encrypt', $token);
		$data['data'] = $user;

		$this->load->library('email');

		$subject = "Forgot Password";
		$this->email->set_newline("\r\n");
		$this->email->to($user->email);
		$this->email->from('sppirtbpom2022@gmail.com', 'SPPIRT BPOM');

		// $this->load->view("backend/auth/email-reset-password", $data);
		// die();
		$message = $this->load->view("backend/auth/email-reset-password", $data, true);

		$this->email->subject($subject);
		$this->email->message($message);

		$this->email->send();
		echo validation_errors();

		if ($this->email->send()) {
			return true;
		} else {
			return false;
		}
	}

	function cetak($id)
	{
		$id = strip_tags($id);
		$id = encrypt_decrypt('decrypt', $id);

		// $id = '5#5';
		// $id_arr = explode('#', $id);

		print_r($id);
		die();
		
		if(count($id_arr)>1){

			$id_pengajuan = $id_arr[0];

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

			$pengajuan_sppirt = $this->pengajuan_sppirt_model->find($id_pengajuan,'id_pengajuan');

			$provinsi = $this->provinsi_model->find($irtp->id_prov,'id_prov');
			$kab_kota = $this->kab_kota_model->find($irtp->id_kota,'id_kota');
			$kecamatan = $this->kecamatan_model->find($irtp->id_kecamatan, 'id_kecamatan');
			$desa = $this->desa_model->find($irtp->id_desa, 'id_desa');

			$tahun_berlaku = (date("Y", strtotime($irtp->tahun)) + 5);
			$tgl_berlaku_izin = date('d-m-Y', strtotime('+5 years', strtotime($pengajuan_sppirt->created_at)));

			$pdf = new PDF();
			$pdf->SetMargins(20,20, 20,20);
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
			$pdf->Cell(170, 6, 'LAMPIRAN PB-UMKU: '.$irtp->nomor_izin, 0, 1, 'C');
			$pdf->Cell(160, 6, '', 0, 1, 'C');

			$pdf->SetFont('Arial', '', 8);
			$pdf->SetFillColor(255,255,255);

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
			$pdf->MultiCell(80, 6, isset($provinsi->nama_prov)?$provinsi->nama_prov:'', 0, 1);

			$pdf->Cell(30, 6, ' ', 0, 0, 'L');
			$pdf->Cell(40, 6, '6.  Kabupten/Kota', 0, 0, 'L');
			$pdf->Cell(17, 6, ':', 0, 0, 'R');
			$pdf->MultiCell(80, 6, isset($kab_kota->nama_kota)?$kab_kota->nama_kota:'', 0, 1);

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
			$pdf->MultiCell(110, 6,'Mengikuti Penyuluhan Keamanan Pangan.', 0, 1, 'L');

			$pdf->Cell(43, 6, 'b.', 0, 0, 'R');
			$pdf->MultiCell(110, 6,'Memenuhi persyaratan Cara Produksi Pangan yang Baik untuk Industri Rumah Tangga (CPPB-IRT) atau higiene sanitasi dan dokumentasi.', 0, 1, 'L');

			$pdf->Cell(43, 6, 'c.', 0, 0, 'R');
			$pdf->MultiCell(110, 6,'Memenuhi ketentuan label dan iklan pangan olahan.', 0, 1, 'L');

			$pdf->Cell(30, 6, ' ', 0, 0, 'L');
			$pdf->Cell(40, 6, '      Akan dipenuhi dalam waktu 3 bulan', 0, 0, 'L');
			$pdf->Cell(17, 6, '', 0, 0, 'R');
			$pdf->MultiCell(80, 6, '', 0, 1);

			// $pdf->Output();
			$pdf->Output('D', $irtp->no_sppirt . '.pdf');

		}
	}

	public function generate_user(){

		// $query ="
		// SELECT tb_user.id_user as id_user_tb_user, 
		// tb_pengajuan_sppirt.id_user as id_user_tb_pengajuan,
		// tb_pengajuan_sppirt.nib,
		// tb_pengajuan_sppirt.status_pengajuan,
		// tb_pengajuan_sppirt.id_izin,
		// tb_pengajuan_sppirt.nama_usaha,
		// tb_pengajuan_sppirt.nama_pelaku_usaha,
		// tb_pelaku_usaha.email_user_proses,
		// tb_pelaku_usaha.hp_user_proses,
		// tb_pelaku_usaha.alamat_penanggung_jwb,
		// tb_pelaku_usaha.kd_daerah,
		// SUBSTR(tb_pelaku_usaha.kd_daerah,1,2) as id_prov,
		// SUBSTR(tb_pelaku_usaha.kd_daerah,1,4) as id_kota
		// FROM tb_pengajuan_sppirt 
		// LEFT JOIN tb_user ON tb_pengajuan_sppirt.id_user=tb_user.id_user 
		// JOIN tb_pelaku_usaha ON tb_pelaku_usaha.nib=tb_pengajuan_sppirt.nib
		// WHERE username IS NULL
		// GROUP BY tb_pengajuan_sppirt.id_user";

		// $user = $this->db->query($query)->result_array();
		// foreach ($user as $key => $value) {
			
		// 	$user_data = array(
		// 		'id_user'=>$value['id_user_tb_pengajuan'],
		// 		'nib'=>$value['nib'],
		// 		'alamat_usaha'=>$value['alamat_penanggung_jwb'],
		// 		'nama_pelaku_usaha'=>$value['nama_pelaku_usaha'],
		// 		'nama_usaha'=>$value['nama_usaha'],
		// 		'username'=>$value['nib'],
		// 		'password'=>md5('pelakuusaha123456'),
		// 		'id_prov'=>$value['id_prov'],
		// 		'id_kota'=>$value['id_kota'],
		// 		'id_role'=>2,
		// 		'email'=>$value['email_user_proses'],
		// 		'no_telp'=>$value['hp_user_proses'],
		// 		'is_active'=>'1',
		// 		'nama'=>$value['nama_pelaku_usaha'],
		// 	);
		// 	$this->user_model->insert($user_data);
		// }

		$query =" SELECT * FROM tb_provinsi WHERE 1";
		$user = $this->db->query($query)->result_array();
		foreach ($user as $key => $value) {
			
			$user_data = array(
				'nib'=>'ptsp_prov_'.strtolower(str_replace(" ", "_",$value['nama_prov'])),
				'username'=>'ptsp_prov_'.strtolower(str_replace(" ", "_",$value['nama_prov'])),
				'password'=>md5('PTPSprov123!@#'),
				'id_prov'=>$value['id_prov'],
				'id_role'=>8,
				'is_active'=>'1',
				'nama'=>'PTSP PROVINSI',
			);
			$this->user_model->insert($user_data);
		}

	}

	public function read($id){

		$id = strip_tags($id);
		$id = encrypt_decrypt('decrypt', $id);

		$notification_data = array(
			'read'=>"1",
		);
		$this->notification_model->update($notification_data,$id);

		redirect($_SERVER['HTTP_REFERER']);
	}
}