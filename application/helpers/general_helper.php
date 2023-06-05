<?php 

	function breadcrumb($name, $link)
	{
		$breadcrumb = '
			<div class="row page-titles mx-0">
			    <div class="col-sm-6 p-md-0">
			      <div class="welcome-text">
			        <span>'.$name.'</span>
			      </div>
			    </div>
			    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
			      <ol class="breadcrumb">
			        <li class="breadcrumb-item"><a href="'.base_url('backend/dashboard').'">Home</a></li>
			        <li class="breadcrumb-item active"><a href="'.base_url($link).'">'.$name.'</a></li>
			      </ol>
			    </div>
			  </div>
			';

		return $breadcrumb;
	}
	
	function tanggal_indo($tanggal, $cetak_hari = false)
	{
		$hari = array ( 1 =>    'Senin',
					'Selasa',
					'Rabu',
					'Kamis',
					'Jumat',
					'Sabtu',
					'Minggu'
				);
				
		$bulan = array (1 =>   'Januari',
					'Februari',
					'Maret',
					'April',
					'Mei',
					'Juni',
					'Juli',
					'Agustus',
					'September',
					'Oktober',
					'November',
					'Desember'
				);
		$split 	  = explode('-', $tanggal);
		$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
		
		if ($cetak_hari) {
			$num = date('N', strtotime($tanggal));
			return $hari[$num] . ', ' . $tgl_indo;
		}
		return $tgl_indo;
	}
	
	function buatKode($nomer_terakhir, $kunci, $jumlah_karakter = 0)
	{
		$nomor_baru = intval(substr($nomer_terakhir, strlen($kunci))) + 1;
		$nomer_baru_plus_nol = str_pad($nomor_baru, $jumlah_karakter, "0", STR_PAD_LEFT);
		$kode = $kunci.$nomer_baru_plus_nol;
		return $kode;
	}
	
	function buatKode2($nomer_terakhir, $kunci, $jumlah_karakter = 0)
	{
		$nomor_baru = intval(substr($nomer_terakhir, strlen($kunci)));
		$nomer_baru_plus_nol = str_pad($nomor_baru, $jumlah_karakter, "0", STR_PAD_LEFT);
		$kode = $kunci.$nomer_baru_plus_nol;
		return $kode;
	}


	function getErrorValidation()
	{
		$CI = &get_instance();

		$forms = $CI->input->post();
		// var_dump($forms);die;
		foreach ($forms as $key => $value) {
			if ($key != 'id') {
				$response[$key] = form_error($key);
			}
		}
		if ($CI->input->post('jenis') == 'verifikasi-cara-pembuatan') {
			$response['berita_acara'] = form_error('berita_acara');
		}
		return $response;
	}


	function softDelete($table, $where)
	{
		$CI = &get_instance();
		return $CI->db->update($table, ['deleted_at' => date('Y-m-d H:i:s')], $where);

	}


	function generateRandomString($length)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	function getMenu($parent, $tipe)
	{
		$CI = &get_instance();
		$role_id = $CI->session->userdata('userData')['id_role'];
		return $CI->db->join('tb_akses_menu', 'tb_akses_menu.id_menu = tb_menu.id_menu')->order_by('posisi', 'ASC')->get_where('tb_menu', ['menu_parent' => $parent, 'tipe' => $tipe, 'id_role' => $role_id, 'tb_menu.deleted_at' => null])->result_array();
	}

	function getMenuFrontEnd($parent)
	{
		$CI = &get_instance();
		return $CI->db->order_by('posisi', 'ASC')->get_where('tb_menu', ['menu_parent' => $parent, 'tipe' => 'frontend','tb_menu.deleted_at' => null])->result_array();
	}

	function createThumbnail($path, $file_name)
	{

		$CI=get_instance();
		$config = array(
		    // Image Large
		    // array(
		    //     'image_library' => 'GD2',
		    //     'source_image'  => './assets/'.$path.'/'.$file_name,
		    //     'maintain_ratio'=> FALSE,
		    //     'width'         => 700,
		    //     'height'        => 467,
		    //     'new_image'     => './assets/'.$path.'/large/'.$file_name
		    //     ),
		    // image Medium
		    array(
		        'image_library' => 'GD2',
		        'source_image'  => './uploads/'.$path.'/'.$file_name,
		        'maintain_ratio'=> FALSE,
		        'width'         => '60%',
		        'height'        => '40%',
		        'new_image'     => './uploads/'.$path.'/thumbnail/'.$file_name
		        ),
		    // Image Small
		    // array(
		    //     'image_library' => 'GD2',
		    //     'source_image'  => './assets/'.$path.'/'.$file_name,
		    //     'maintain_ratio'=> FALSE,
		    //     'width'         => 100,
		    //     'height'        => 67,
		    //     'new_image'     => './assets/'.$path.'/small/'.$file_name
		    // )
		);
		
		$CI->load->library('image_lib', $config[0]);
		foreach ($config as $item){
		    $CI->image_lib->initialize($item);
		    if(!$CI->image_lib->resize()){
		        return false;
		    }
		    $CI->image_lib->clear();
		}
	}

	function dd($data)
	{
	    echo "<pre>";
	    var_dump($data);
	    exit;
	}

	function gen_page()
	{
	    $ci =& get_instance();
	    $page = 1;
	    if ($ci->input->get('page')) {
	        $page = $ci->input->get('page');
	    }
	    return $page;
	}
	function gen_limit($limit = 10)
	{
	    $ci =& get_instance();
	    if ($ci->input->get('limit')) {
	        $limit = $ci->input->get('limit');
	    }
	    return $limit;
	}
	function gen_offset($page, $limit)
	{
	    return ($page-1) * $limit;
	}

	function get_query_string($remove = '')
	{
	    $query_string = $_GET;
	    if ($remove) {
	        if (is_array($remove)) {
	            foreach ($remove as $key => $value) {
	                unset($query_string[$value]);
	            }
	        } else {
	            unset($query_string[$remove]);
	        }
	    }
	    if ($query_string) {
	        return '?'.http_build_query($query_string);
	    }
	    return '';
	}

	function gen_slug($text)
	{
	    // replace non letter or digits by -
	    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

	    // transliterate
	    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	    // remove unwanted characters
	    $text = preg_replace('~[^-\w]+~', '', $text);

	    // trim
	    $text = trim($text, '-');

	    // remove duplicate -
	    $text = preg_replace('~-+~', '-', $text);

	    // lowercase
	    $text = strtolower($text);

	    if (empty($text)) {
	        return 'n-a';
	    }

	    return $text;
	}

	function curl_api_oss($transaction){

	    $kode_unit = '016';
		$username = 'sppirt';
		$password = 'tikbp0m2021';
		$date = date('Ymd');

	    $transaction = json_encode($transaction);
	    $url = 'https://gatewayoss.pom.go.id/gateway-bpom/services/inqueryNIB';
	    //$curl = curl_init($url);

	    $ch = curl_init($url);
		$header = array(
		        'Content-Type: application/json',
				'Unit:'.$kode_unit,
				'Token:'.sha1($username.$password.$date)
		    );
		curl_setopt_array($ch, array(
		    CURLOPT_CUSTOMREQUEST => "POST",
		    CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_FOLLOWLOCATION => TRUE,
			CURLOPT_POST=> 1,
			CURLOPT_BUFFERSIZE => 10,
			CURLOPT_SSL_VERIFYPEER => 0,
		    CURLOPT_HTTPHEADER => $header,
		    CURLOPT_POSTFIELDS => $transaction
		));

	    $response = curl_exec($ch);
	    $err = curl_error($ch);
	    curl_close($ch);

	    if ($err) {
	        return array('status'=>'error','msg'=>"cURL Error #:" . $err);
	    } else {
	        return array('status'=>'success','data'=>json_decode($response));
	    }

	}

	function curl_send_data($transaction){
	    
	    $kode_unit = '016';
		$username = 'sppirt';
		$password = 'tikbp0m2021';
		$date = date('Ymd');

	    $transaction = str_replace("\/", "/", json_encode($transaction));

	    $url = 'https://gatewayoss.pom.go.id/gateway-bpom/services/receiveLicense';
	    $curl = curl_init($url);

	    $header = array(
		        'Content-Type: application/json',
				'Unit:'.$kode_unit,
				'Token:'.sha1($username.$password.$date)
		    );
		curl_setopt_array($curl, array(
		    CURLOPT_CUSTOMREQUEST => "POST",
		    CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_FOLLOWLOCATION => TRUE,
			CURLOPT_POST=> 1,
			CURLOPT_BUFFERSIZE => 10,
			CURLOPT_SSL_VERIFYPEER => 0,
		    CURLOPT_HTTPHEADER => $header,
		    CURLOPT_POSTFIELDS => $transaction
		));

	    $response = curl_exec($curl);
	    $err = curl_error($curl);
	    curl_close($curl);
		
		//print_r($transaction);
		//print_r($response);
		
	    if ($err) {
	        return array('status'=>'error','msg'=>"cURL Error #:" . $err);
	    } else {
	        return array('status'=>'success','data'=>json_decode($response));
	    }

	}

	function send_wa($transaction){

	    $transaction = json_encode($transaction);

	    $curl = curl_init();

	    curl_setopt_array($curl, 
	        array(
	            // CURLOPT_URL => "http://172.16.2.43:9000/send_message", //Prod PMPU
	            CURLOPT_URL => "http://localhost:9000/send_message", //DEV
	            CURLOPT_RETURNTRANSFER => true,
	            CURLOPT_ENCODING => "",
	            CURLOPT_MAXREDIRS => 10,
	            CURLOPT_TIMEOUT => 30,
	            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	            CURLOPT_CUSTOMREQUEST => "POST",
	            CURLOPT_POSTFIELDS => $transaction,
	            CURLOPT_HTTPHEADER => array(
	            "accept: application/json",
	            "cache-control: no-cache",
	            "content-type: application/json"
	        ),
	    ));

	    $response = curl_exec($curl);
	    $err = curl_error($curl);
	    curl_close($curl);

	    if ($err) {
	        return array('status'=>'error','msg'=>"cURL Error #:" . $err);
	    } else {

	        return array('status'=>'success','data'=>json_decode($response));
	    }

	}

	function encrypt_decrypt($action, $string) {
	    $output = false;
	    $encrypt_method = "AES-256-CBC";
	    $secret_key = '^*sppirt!@#$';
	    $secret_iv = '!#@01234567890^';
	    // hash
	    $key = hash('sha256', $secret_key);

	    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	    $iv = substr(hash('sha256', $secret_iv), 0, 16);
	    if ($action == 'encrypt'){
	        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	        $output = base64_encode($output);
	    } else if($action == 'decrypt') {
	        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	    }
	    return $output;
	}



	function rules()
	{
		$rules = [
			'required' => '%s tidak boleh kosong!',
			'is_unique' => '%s tidak dapat digunakan, karena sudah terdaftar!',
			'numeric' => '%s harus berisikan angka!',
			'valid_email' => '%s yang anda masukkan tidak valid',
		];

		return $rules;
	}

	function send_notification($param) {
    	
    	$id = $param['id'];
    	$type = $param['type'];
    	$status = $param['status'];
    	$msg = $param['msg'];

	    $ci =& get_instance();
	    $userData = $ci->session->userdata('userData');

	    $ci->notification_model = new GeneralModel("tb_notification");
	    $ci->pengajuan_sppirt_model = new GeneralModel("tb_pengajuan_sppirt");
	    $ci->hasil_pemeriksaan_cppob_model = new GeneralModel("tb_hasil_pemeriksaan_cppob");
	    $ci->verifikasi_pkp_model = new GeneralModel("tb_verifikasi_pkp");
	    $ci->verifikasi_cara_pembuatan_model = new GeneralModel("tb_verifikasi_cara_pembuatan");
	    $ci->user_model = new GeneralModel("tb_user");
	    $ci->kota_model = new GeneralModel("tb_kota");
	

	    if($type=='Verifikasi Produk'){

	    	$pengajuan_sppirt = $ci->pengajuan_sppirt_model->find($id,'id_pengajuan');
	    	$no_sppirt = isset($pengajuan_sppirt->no_sppirt)?$pengajuan_sppirt->no_sppirt:'';
	    	$alasan = isset($pengajuan_sppirt->alasan_pembatalan)?$pengajuan_sppirt->alasan_pembatalan:'';
	    	$id_pengajuan = isset($pengajuan_sppirt->id_pengajuan)?$pengajuan_sppirt->id_pengajuan:'';
	    	$nib = isset($pengajuan_sppirt->nib)?$pengajuan_sppirt->nib:'';

	    	$user = $ci->user_model->find($pengajuan_sppirt->id_user,'id_user');
	    	$kota = $ci->kota_model->find($user->id_kota,'id_kota');
	    	$nama_kab_kota = isset($kota->nama_kota)?$kota->nama_kota:'';

	    	if($status=='Permohonan Pembatalan'){

	    		$query = $ci->user_model->source();
		        // $query->where('id_user',$pengajuan_sppirt->id_user);
	            $query->group_start();
	                $query->where('id_role',4);
	                $query->where('id_kota',$user->id_kota);
	            $query->group_end();
	            // $query->or_group_start();
	            //     $query->where('id_role',8);
	            //     $query->where('id_prov',$user->id_prov);
	            // $query->group_end();
		        $user = $query->get()->result();
		        foreach($user as $key => $value){

					$msg = "*INFO SPPIRT BPOM RI:*\n\nDiinformasikan bahwa terdapat permohonan pembatalan/pancabutan nomor SPPIRT dengan nomor *".$no_sppirt."* dari Dinas Kesehatan Kab/Kota *".$nama_kab_kota."*.\nMohon dapat ditindaklanjuti melalui aplikasi SPPIRT BPOM Terintegrasi OSS.\n\nJabat Erat,\n*SPPIRT Center BPOM RI*\nhttps://sppirt.pom.go.id \n\n------------------------------------------------\n_*JANGAN DIBALAS* karena tidak akan direspon oleh sistem. Informasi dalam pesan ini digenerate dan dikirim otomatis oleh WA Gateway Aplikasi SPPIRT BPOM RI._ ";
					$msg_dashboard = "Permohonan pembatalan nomor SPPIRT dengan nomor ".$no_sppirt.".";

		    		$notification_data = array(
			            'user_id'=>$value->id_user,
			            'type'=>$type,
			            'status'=>$status,
			            'keterangan'=>$msg_dashboard,
			            'created_at'=>date('Y-m-d H:i:s'),
			            'read'=>0,
			            'id_pengajuan'=>$id_pengajuan,
			            'nib'=>$nib,
			            'no_sppirt'=>$no_sppirt,
			        );
			        $ci->notification_model->insert($notification_data);

			        if(isset($value->no_telp) && $value->no_telp!="" && $value->no_telp!=NULL){

						//// SEND NOTIFICATION WA ke PTSP ///

						$data_wa = array(
				           "phone"=>$value->no_telp,
				           "msg"=>$msg
				        );
				        send_wa($data_wa);

					}

				}

	    	}else if($status=='Pembatalan Disetujui'){

	    		$query = $ci->user_model->source();
		        $query->where('id_user',$pengajuan_sppirt->id_user);
	            $query->or_group_start();
	                $query->where('id_role',3);
	                $query->where('id_kota',$user->id_kota);
	            $query->group_end();
	            // $query->or_group_start();
	            //     $query->where('id_role',5);
	            //     $query->where('id_prov',$user->id_prov);
	            // $query->group_end();
		        $user = $query->get()->result();
		        foreach($user as $key => $value){

					//// SEND NOTIFICATION WA ke Dinkes dan Pelaku Usaha///
		        	$msg = "*INFO SPPIRT BPOM RI:*\n\nDiinformasikan bahwa permohonan pembatalan/pancabutan nomor SPPIRT dengan nomor *".$no_sppirt."* dari Dinas Kesehatan Kab/Kota *".$nama_kab_kota."* telah disetujui oleh DPM PTSP.\n\nJabat Erat,\n*SPPIRT Center BPOM RI*\nhttps://sppirt.pom.go.id \n\n------------------------------------------------\n_*JANGAN DIBALAS* karena tidak akan direspon oleh sistem. Informasi dalam pesan ini digenerate dan dikirim otomatis oleh WA Gateway Aplikasi SPPIRT BPOM RI._ ";
		        	$msg_dashboard = "Pembatalan nomor SPPIRT dengan nomor ".$no_sppirt." telah disetujui DPM PTSP.";

		    		$notification_data = array(
			            'user_id'=>$value->id_user,
			            'type'=>$type,
			            'status'=>$status,
			            'keterangan'=>$msg_dashboard,
			            'created_at'=>date('Y-m-d H:i:s'),
			            'read'=>0,
			        );
			        $ci->notification_model->insert($notification_data);

			        if(isset($value->no_telp) && $value->no_telp!="" && $value->no_telp!=NULL){

						
						//message ke Dinkes dan PU
						$data_wa = array(
				           "phone"=>$value->no_telp,
				           "msg"=>$msg
				        );
				        send_wa($data_wa);

					}

				}

	    	}else if($status=='Permohonan Pembatalan Ditolak'){

	    		$query = $ci->user_model->source();
		        // $query->where('id_user',$pengajuan_sppirt->id_user);
	            $query->group_start();
	                $query->where('id_role',3);
	                $query->where('id_kota',$user->id_kota);
	            $query->group_end();
	            // $query->or_group_start();
	            //     $query->where('id_role',5);
	            //     $query->where('id_prov',$user->id_prov);
	            // $query->group_end();
		        $user = $query->get()->result();
		        foreach($user as $key => $value){

					//// SEND NOTIFICATION WA ke Dinkes doang///
					$msg = "*INFO SPPIRT BPOM RI:*\n\nDiinformasikan bahwa permohonan pembatalan/pancabutan nomor SPPIRT dengan nomor *".$no_sppirt."* dari Dinas Kesehatan Kab/Kota *".$nama_kab_kota."* tidak disetujui oleh DPM PTSP dengan alasan: ".$alasan.".\n\nJabat Erat,\n*SPPIRT Center BPOM RI*\nhttps://sppirt.pom.go.id \n\n------------------------------------------------\n_*JANGAN DIBALAS* karena tidak akan direspon oleh sistem. Informasi dalam pesan ini digenerate dan dikirim otomatis oleh WA Gateway Aplikasi SPPIRT BPOM RI._ ";
					$msg_dashboard = "Permohonan pembatalan nomor SPPIRT dengan nomor ".$no_sppirt." ditolak oleh DPM PTSP.";

		    		$notification_data = array(
			            'user_id'=>$value->id_user,
			            'type'=>$type,
			            'status'=>$status,
			            'keterangan'=>$msg_dashboard,
			            'created_at'=>date('Y-m-d H:i:s'),
			            'read'=>0,
			            'id_pengajuan'=>$id_pengajuan,
			            'nib'=>$nib,
			            'no_sppirt'=>$no_sppirt,
			        );
			        $ci->notification_model->insert($notification_data);

			        if(isset($value->no_telp) && $value->no_telp!="" && $value->no_telp!=NULL){

						
						$data_wa = array(
				           "phone"=>$value->no_telp,
				           "msg"=>$msg
				        );
				        send_wa($data_wa);

					}

				}

	    	}else if($status=='Pemenuhan Komitmen'){

	   //  		$query = $ci->user_model->source();
		  //       $query->where('id_user',$pengajuan_sppirt->id_user);
		  //       $user = $query->get()->result();
		  //       foreach($user as $key => $value){

		  //   		$notification_data = array(
			 //            'user_id'=>$value->id_user,
			 //            'type'=>$type,
			 //            'status'=>$status,
			 //            'keterangan'=>$msg,
			 //            'created_at'=>date('Y-m-d H:i:s'),
			 //            'read'=>0,
			 //            'id_pengajuan'=>$id_pengajuan,
			 //            'nib'=>$nib,
			 //            'no_sppirt'=>$no_sppirt,
			 //        );
			 //        $ci->notification_model->insert($notification_data);

			 //        if(isset($value->no_telp) && $value->no_telp!="" && $value->no_telp!=NULL){

				// 		//// SEND NOTIFICATION WA ke Pelaku Usaha khusus yang berubah nomor SPPIRT ///
				// 		$msg = "*INFO SPPIRT BPOM RI:*\n\nDiinformasikan bahwa permohonan pembatalan/pancabutan nomor SPPIRT dengan nomor ".$no_sppirt." dari Dinas Kesehatan Kab/Kota ".$nama_kab_kota." telah disetujui oleh DPM PTSP.\n\nJabat Erat,\n*SPPIRT Center BPOM RI*\nhttps://sppirt.pom.go.id \n\n------------------------------------------------\n_*JANGAN DIBALAS* karena tidak akan direspon oleh sistem. Informasi dalam pesan ini digenerate dan dikirim otomatis oleh WA Gateway Aplikasi SPPIRT BPOM RI._ ";
						
				// 		$data_wa = array(
				//            "phone"=>$value->no_telp,
				//            "msg"=>$msg
				//         );
				//         send_wa($data_wa);

				// 	}

				// }

	    	}

	    }else if($type=='Verifikasi Label'){

	    	$pengajuan_sppirt = $ci->pengajuan_sppirt_model->find($id,'id_pengajuan');
	    	$no_sppirt = isset($pengajuan_sppirt->no_sppirt)?$pengajuan_sppirt->no_sppirt:'';
	    	$alasan = isset($pengajuan_sppirt->alasan_pembatalan)?$pengajuan_sppirt->alasan_pembatalan:'';
	    	$id_pengajuan = isset($pengajuan_sppirt->id_pengajuan)?$pengajuan_sppirt->id_pengajuan:'';
	    	$nib = isset($pengajuan_sppirt->nib)?$pengajuan_sppirt->nib:'';

	    	$user = $ci->user_model->find($pengajuan_sppirt->id_user,'id_user');

	    	if($status=='Perbaikan Label'){

	    		$query = $ci->user_model->source();
		        $query->where('id_user',$pengajuan_sppirt->id_user);
		        $user = $query->get()->result();
		        foreach($user as $key => $value){

					//// SEND NOTIFICATION WA ke pelaku usaha///
					$msg = "*INFO SPPIRT BPOM RI:*\n\nDiinformasikan bahwa Produk Anda dengan nomor SPPIRT: *".$no_sppirt."* telah diverifikasi oleh Dinas Kesehatan dan memerlukan *PERBAIKAN LABEL*.\nMohon dapat ditindaklanjuti melalui aplikasi SPPIRT BPOM Terintegrasi OSS.\n\nJabat Erat,\n*SPPIRT Center BPOM RI*\nhttps://sppirt.pom.go.id \n\n------------------------------------------------\n_*JANGAN DIBALAS* karena tidak akan direspon oleh sistem. Informasi dalam pesan ini digenerate dan dikirim otomatis oleh WA Gateway Aplikasi SPPIRT BPOM RI._ ";
					$msg_dashboard = "Perbaikan label produk SPPIRT dengan nomor ".$no_sppirt.".";

		    		$notification_data = array(
			            'user_id'=>$value->id_user,
			            'type'=>$type,
			            'status'=>$status,
			            'keterangan'=>$msg_dashboard,
			            'created_at'=>date('Y-m-d H:i:s'),
			            'read'=>0,
			            'id_pengajuan'=>$id_pengajuan,
			            'nib'=>$nib,
			            'no_sppirt'=>$no_sppirt,
			        );
			        $ci->notification_model->insert($notification_data);

			        if(isset($value->no_telp) && $value->no_telp!="" && $value->no_telp!=NULL){


						$data_wa = array(
				           "phone"=>$value->no_telp,
				           "msg"=>$msg
				        );
				        send_wa($data_wa);

					}

				}

	    	}else if($status=='Telah dilakukan perbaikan'){

	    		$query = $ci->user_model->source();
		        // $query->where('id_user',$pengajuan_sppirt->id_user);
	            $query->group_start();
	                $query->where('id_role',3);
	                $query->where('id_kota',$user->id_kota);
	            $query->group_end();
	            // $query->or_group_start();
	            //     $query->where('id_role',5);
	            //     $query->where('id_prov',$user->id_prov);
	            // $query->group_end();
		        $user = $query->get()->result();
		        foreach($user as $key => $value){

					//// SEND NOTIFICATION WA ke Dinkes ///
					$msg = "*INFO SPPIRT BPOM RI:*\n\nDiinformasikan bahwa Produk dengan nomor SPPIRT: *".$no_sppirt."* telah dilakukan *PERBAIKAN LABEL* oleh pelaku usaha.\n Mohon dapat ditindaklanjuti melalui aplikasi SPPIRT BPOM Terintegrasi OSS.\n\nJabat Erat,\n*SPPIRT Center BPOM RI*\nhttps://sppirt.pom.go.id \n\n------------------------------------------------\n_*JANGAN DIBALAS* karena tidak akan direspon oleh sistem. Informasi dalam pesan ini digenerate dan dikirim otomatis oleh WA Gateway Aplikasi SPPIRT BPOM RI._ ";
					$msg_dashboard = "Perbaikan label produk SPPIRT oleh pelaku usaha dengan nomor ".$no_sppirt.".";

		    		$notification_data = array(
			            'user_id'=>$value->id_user,
			            'type'=>$type,
			            'status'=>$status,
			            'keterangan'=>$msg_dashboard,
			            'created_at'=>date('Y-m-d H:i:s'),
			            'read'=>0,
			            'id_pengajuan'=>$id_pengajuan,
			            'nib'=>$nib,
			            'no_sppirt'=>$no_sppirt,
			        );
			        $ci->notification_model->insert($notification_data);

			        if(isset($value->no_telp) && $value->no_telp!="" && $value->no_telp!=NULL){


						$data_wa = array(
				           "phone"=>$value->no_telp,
				           "msg"=>$msg
				        );
				        send_wa($data_wa);

					}

				}

	    	}else if($status=='Pemenuhan Komitmen'){

	   //  		$query = $ci->user_model->source();
		  //       $query->where('id_user',$pengajuan_sppirt->id_user);
		  //       $user = $query->get()->result();
		  //       foreach($user as $key => $value){

		  //   		$notification_data = array(
			 //            'user_id'=>$value->id_user,
			 //            'type'=>$type,
			 //            'status'=>$status,
			 //            'keterangan'=>$msg,
			 //            'created_at'=>date('Y-m-d H:i:s'),
			 //            'read'=>0,
			 //        );
			 //        $ci->notification_model->insert($notification_data);

			 //        if(isset($value->no_telp) && $value->no_telp!="" && $value->no_telp!=NULL){

				// 		//// SEND NOTIFICATION WA tidak perlu ///
				// 		$data_wa = array(
				//            "phone"=>$value->no_telp,
				//            "msg"=>$msg
				//         );
				//         send_wa($data_wa);

				// 	}

				// }

	    	}

	    }else if($type=='Verifikasi PKP'){

	    	$user = $ci->user_model->find($id,'nib');
	    	$nib = isset($user->nib)?$user->nib:'';

	    	$verifikasi_pkp = $ci->verifikasi_pkp_model->find($nib,'nib');
	    	$jadwal = isset($verifikasi_pkp->jadwal)?$verifikasi_pkp->jadwal:'';

	    	if($status=='Penjadwalan Penyuluhan'){

	    		$query = $ci->user_model->source();
		        $query->where('id_user',$user->id_user);
		        $user = $query->get()->result();
		        foreach($user as $key => $value){

					//// SEND NOTIFICATION WA khusus jadwal ke pelaku usaha///
		        	$msg = "*INFO SPPIRT BPOM RI:*\n\nDiinformasikan bahwa data Anda yang terasosiasi dengan NIB: *".$nib."* TELAH dijadwalkan mengikuti Penyuluhan Keamanan Pangan pada tanggal: *".date('d-m-Y',strtotime($jadwal))."*.\n_Apabila Anda telah mengikuti pelatihan PKP, mohon dapat diinputkan data sertifikat PKP melalui aplikasi SPPIRT pada menu *Isi Sertifikat PKP*_.\n\nJabat Erat,\n*SPPIRT Center BPOM RI*\nhttps://sppirt.pom.go.id \n\n------------------------------------------------\n_*JANGAN DIBALAS* karena tidak akan direspon oleh sistem. Informasi dalam pesan ini digenerate dan dikirim otomatis oleh WA Gateway Aplikasi SPPIRT BPOM RI._ ";
		        	$msg_dashboard = "Jadwal Penyuluhan Keamanan pangan dengan NIB ".$nib." dilaksanakan pada tanggal: ".date('d-m-Y',strtotime($jadwal)).".";

		    		$notification_data = array(
			            'user_id'=>$value->id_user,
			            'type'=>$type,
			            'status'=>$status,
			            'keterangan'=>$msg_dashboard,
			            'created_at'=>date('Y-m-d H:i:s'),
			            'read'=>0,
			            'nib'=>$nib,
			        );
			        $ci->notification_model->insert($notification_data);

			        if(isset($value->no_telp) && $value->no_telp!="" && $value->no_telp!=NULL){


						$data_wa = array(
				           "phone"=>$value->no_telp,
				           "msg"=>$msg
				        );
				        send_wa($data_wa);

					}

				}

	    	}else if($status=='Pemenuhan Komitmen'){

	   //  		$query = $ci->user_model->source();
		  //       $query->where('id_user',$user->id_user);
		  //       $user = $query->get()->result();
		  //       foreach($user as $key => $value){

		  //   		$notification_data = array(
			 //            'user_id'=>$value->id_user,
			 //            'type'=>$type,
			 //            'status'=>$status,
			 //            'keterangan'=>$msg,
			 //            'created_at'=>date('Y-m-d H:i:s'),
			 //            'read'=>0,
			 //        );
			 //        $ci->notification_model->insert($notification_data);

			 //        if(isset($value->no_telp) && $value->no_telp!="" && $value->no_telp!=NULL){

				// 		//// SEND NOTIFICATION WA tidak perlu WA///
				// 		$data_wa = array(
				//            "phone"=>$value->no_telp,
				//            "msg"=>$msg
				//         );
				//         send_wa($data_wa);

				// 	}

				// }

	    	}

	    }else if($type=='Verifikasi Cara Pembuatan'){

	    	$user = $ci->user_model->find($id,'nib');
	    	$nib = isset($user->nib)?$user->nib:'';
	    	$alasan =  isset($user->alasan_penolakan_penangguhan_akun)?$user->alasan_penolakan_penangguhan_akun:'';

	    	$kota = $ci->kota_model->find($user->id_kota,'id_kota');
	    	$nama_kab_kota = isset($kota->nama_kota)?$kota->nama_kota:'';

	    	$hasil_pemeriksaan_cppob = $ci->hasil_pemeriksaan_cppob_model->find($nib,'nib');
	    	$jadwal = isset($hasil_pemeriksaan_cppob->jadwal)?$hasil_pemeriksaan_cppob->jadwal:'';
	    	if($jadwal==''){

		    	$verifikasi_cara_pembuatan = $ci->verifikasi_cara_pembuatan_model->find($nib,'nib');
		    	$jadwal = isset($verifikasi_cara_pembuatan->jadwal)?$verifikasi_cara_pembuatan->jadwal:'';

	    	}

	    	if($status=='Rekomendasi Pembekuan Akun'){

	    		$query = $ci->user_model->source();
		        // $query->where('id_user',$user->id_user);
	            $query->group_start();
	                $query->where('id_role',4);
	                $query->where('id_kota',$user->id_kota);
	            $query->group_end();
	            // $query->or_group_start();
	            //     $query->where('id_role',8);
	            //     $query->where('id_prov',$user->id_prov);
	            // $query->group_end();
		        $user = $query->get()->result();
		        foreach($user as $key => $value){

					//// SEND NOTIFICATION WA ke PTSP///
					$msg = "*INFO SPPIRT BPOM RI:*\n\nDiinformasikan bahwa terdapat *PERMOHONAN PEMBEKUAN* akun dengan NIB: *".$nib."* dari Dinas Kesehatan Kab/Kota *".$nama_kab_kota."*.\nMohon dapat ditindaklanjuti melalui aplikasi SPPIRT BPOM Terintegrasi OSS.\n\nJabat Erat,\n*SPPIRT Center BPOM RI*\nhttps://sppirt.pom.go.id \n\n------------------------------------------------\n_*JANGAN DIBALAS* karena tidak akan direspon oleh sistem. Informasi dalam pesan ini digenerate dan dikirim otomatis oleh WA Gateway Aplikasi SPPIRT BPOM RI._ ";
					$msg_dashboard = "Permohonan Pembekuan akun pelaku usaha dengan NIB ".$nib." oleh Dinas Kesehatan.";

		    		$notification_data = array(
			            'user_id'=>$value->id_user,
			            'type'=>$type,
			            'status'=>$status,
			            'keterangan'=>$msg_dashboard,
			            'created_at'=>date('Y-m-d H:i:s'),
			            'read'=>0,
			             'nib'=>$nib,
			        );
			        $ci->notification_model->insert($notification_data);

			        if(isset($value->no_telp) && $value->no_telp!="" && $value->no_telp!=NULL){


						$data_wa = array(
				           "phone"=>$value->no_telp,
				           "msg"=>$msg
				        );
				        send_wa($data_wa);

					}

				}

	    	}else if($status=='Pembekuan Akun Disetujui'){

	    		$query = $ci->user_model->source();
		        $query->where('id_user',$user->id_user);
	            $query->or_group_start();
	                $query->where('id_role',3);
	                $query->where('id_kota',$user->id_kota);
	            $query->group_end();
	            // $query->or_group_start();
	            //     $query->where('id_role',5);
	            //     $query->where('id_prov',$user->id_prov);
	            // $query->group_end();
		        $user = $query->get()->result();
		        foreach($user as $key => $value){

					//// SEND NOTIFICATION WA ke Dinkes dan Pelaku Usaha///
					$msg = "*INFO SPPIRT BPOM RI:*\n\nDiinformasikan bahwa permohonan Pembekuan Akun dengan nomor NIB: *".$nib."* dari Dinas Kesehatan Kab/Kota *".$nama_kab_kota."* telah disetujui oleh DPM PTSP.\nAkun tersebut saat ini tidak bisa dipergunakan oleh pelaku usaha untuk melakukan permohonan penerbitan SPPIRT yang baru.\n\nJabat Erat,\n*SPPIRT Center BPOM RI*\nhttps://sppirt.pom.go.id \n\n------------------------------------------------\n_*JANGAN DIBALAS* karena tidak akan direspon oleh sistem. Informasi dalam pesan ini digenerate dan dikirim otomatis oleh WA Gateway Aplikasi SPPIRT BPOM RI._ ";
					$msg_dashboard = "Pembekuan akun pelaku usaha dengan NIB ".$nib." telah disetujui oleh DPM PTSP.";

		    		$notification_data = array(
			            'user_id'=>$value->id_user,
			            'type'=>$type,
			            'status'=>$status,
			            'keterangan'=>$msg_dashboard,
			            'created_at'=>date('Y-m-d H:i:s'),
			            'read'=>0,
			             'nib'=>$nib,
			        );
			        $ci->notification_model->insert($notification_data);

			        if(isset($value->no_telp) && $value->no_telp!="" && $value->no_telp!=NULL){


						$data_wa = array(
				           "phone"=>$value->no_telp,
				           "msg"=>$msg
				        );
				        send_wa($data_wa);

					}

				}

	    	}else if($status=='Pembekuan Akun Ditolak'){

	    		$query = $ci->user_model->source();
		        // $query->where('id_user',$user->id_user);
	            $query->group_start();
	                $query->where('id_role',3);
	                $query->where('id_kota',$user->id_kota);
	            $query->group_end();
	            // $query->or_group_start();
	            //     $query->where('id_role',5);
	            //     $query->where('id_prov',$user->id_prov);
	            // $query->group_end();
		        $user = $query->get()->result();
		        foreach($user as $key => $value){

					//// SEND NOTIFICATION WA ke Dinkes doang///
					$msg = "*INFO SPPIRT BPOM RI:*\n\nDiinformasikan bahwa Permohonan Pembekuan Akun dengan NIB: *".$nib."* dari Dinas Kesehatan Kab/Kota *".$nama_kab_kota."* tidak disetujui oleh DPM PTSP dengan alasan: _".$alasan."_.\nData dapat dicek melalui aplikasi SPPIRT.\n\nJabat Erat,\n*SPPIRT Center BPOM RI*\nhttps://sppirt.pom.go.id \n\n------------------------------------------------\n_*JANGAN DIBALAS* karena tidak akan direspon oleh sistem. Informasi dalam pesan ini digenerate dan dikirim otomatis oleh WA Gateway Aplikasi SPPIRT BPOM RI._ ";
					$msg_dashboard = "Pembekuan akun pelaku usaha dengan NIB ".$nib." TIDAK DISETUJUI oleh DPM PTSP.";

		    		$notification_data = array(
			            'user_id'=>$value->id_user,
			            'type'=>$type,
			            'status'=>$status,
			            'keterangan'=>$msg_dashboard,
			            'created_at'=>date('Y-m-d H:i:s'),
			            'read'=>0,
			            'nib'=>$nib,
			        );
			        $ci->notification_model->insert($notification_data);

			        if(isset($value->no_telp) && $value->no_telp!="" && $value->no_telp!=NULL){

						
						$data_wa = array(
				           "phone"=>$value->no_telp,
				           "msg"=>$msg
				        );
				        send_wa($data_wa);

					}

				}

	    	}if($status=='Penjadwalan Pemeriksaan'){

	    		$query = $ci->user_model->source();
		        $query->where('id_user',$user->id_user);
		        $user = $query->get()->result();
		        foreach($user as $key => $value){

					//// SEND NOTIFICATION WA ke Pelaku Usaha///
					$msg = "*INFO SPPIRT BPOM RI:*\n\nDiinformasikan bahwa data Anda yang terasosiasi dengan NIB *".$nib."* AKAN atau TELAH dijadwalkan untuk Pemeriksaan Sarana oleh Dinas Kesehatan pada tanggal: *".date('d-m-Y',strtotime($jadwal))."*.\nMohon dapat dicek melalui aplikasi SPPIRT BPOM Terintegrasi OSS.\n\nJabat Erat,\n*SPPIRT Center BPOM RI*\nhttps://sppirt.pom.go.id \n\n------------------------------------------------\n_*JANGAN DIBALAS* karena tidak akan direspon oleh sistem. Informasi dalam pesan ini digenerate dan dikirim otomatis oleh WA Gateway Aplikasi SPPIRT BPOM RI._ ";
					$msg_dashboard = "Jadwal Pemeriksaan Sarana IRTP dengan NIB ".$nib." oleh Dinas Kesehatan AKAN atau TELAH dilaksanakan pada tanggal: ".date('d-m-Y',strtotime($jadwal)).".";

		    		$notification_data = array(
			            'user_id'=>$value->id_user,
			            'type'=>$type,
			            'status'=>$status,
			            'keterangan'=>$msg_dashboard,
			            'created_at'=>date('Y-m-d H:i:s'),
			            'read'=>0,
			             'nib'=>$nib,
			        );
			        $ci->notification_model->insert($notification_data);

			        if(isset($value->no_telp) && $value->no_telp!="" && $value->no_telp!=NULL){


						$data_wa = array(
				           "phone"=>$value->no_telp,
				           "msg"=>$msg
				        );
				        send_wa($data_wa);

					}

				}

	    	}else if($status=='Tidak Memenuhi Komitmen'){

	    		$query = $ci->user_model->source();
		        $query->where('id_user',$user->id_user);
		        $user = $query->get()->result();
		        foreach($user as $key => $value){

					//// SEND NOTIFICATION WA ke Pelaku Usaha///
					$msg = "*INFO SPPIRT BPOM RI:*\n\nDiinformasikan bahwa data Anda yang terasosiasi dengan NIB: *".$nib."* berdasarkan hasil pemeriksaan sarana perlu dilakukan pembinaan. Pelaku usaha diharapakan dapat memperbaiki sarana produksinya. Pemeriksaan sarana akan dijadwalakan kembali oleh Dinas Kesehatan pada tanggal: *".date('d-m-Y',strtotime($jadwal))."*.\nMohon dapat dicek melalui aplikasi SPPIRT BPOM Terintegrasi OSS.\n\nJabat Erat,\n*SPPIRT Center BPOM RI*\nhttps://sppirt.pom.go.id \n\n------------------------------------------------\n_*JANGAN DIBALAS* karena tidak akan direspon oleh sistem. Informasi dalam pesan ini digenerate dan dikirim otomatis oleh WA Gateway Aplikasi SPPIRT BPOM RI._ ";
					$msg_dashboard = "Jadwal Pemeriksaan Ulang Sarana IRTP dengan NIB ".$nib." oleh Dinas Kesehatan akan dilaksanakan pada tanggal: ".date('d-m-Y',strtotime($jadwal)).".";

		    		$notification_data = array(
			            'user_id'=>$value->id_user,
			            'type'=>$type,
			            'status'=>$status,
			            'keterangan'=>$msg_dashboard,
			            'created_at'=>date('Y-m-d H:i:s'),
			            'read'=>0,
			             'nib'=>$nib,
			        );
			        $ci->notification_model->insert($notification_data);

			        if(isset($value->no_telp) && $value->no_telp!="" && $value->no_telp!=NULL){


						$data_wa = array(
				           "phone"=>$value->no_telp,
				           "msg"=>$msg
				        );
				        send_wa($data_wa);

					}

				}

	    	}else if($status=='Pemenuhan Komitmen'){

	   //  		$query = $ci->user_model->source();
		  //       $query->where('id_user',$user->id_user);
		  //       $user = $query->get()->result();
		  //       foreach($user as $key => $value){

		  //   		$notification_data = array(
			 //            'user_id'=>$value->id_user,
			 //            'type'=>$type,
			 //            'status'=>$status,
			 //            'keterangan'=>$msg,
			 //            'created_at'=>date('Y-m-d H:i:s'),
			 //            'read'=>0,
			 //        );
			 //        $ci->notification_model->insert($notification_data);

			 //        if(isset($value->no_telp) && $value->no_telp!="" && $value->no_telp!=NULL){

				// 		//// SEND NOTIFICATION WA ///
				// 		$data_wa = array(
				//            "phone"=>$value->no_telp,
				//            "msg"=>$msg
				//         );
				//         send_wa($data_wa);

				// 	}

				// }

	    	}

	    }

	    return true;
	    
	}


 ?>