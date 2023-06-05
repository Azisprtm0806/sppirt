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
	
	function buatKode($nomer_terakhir, $kunci, $jumlah_karakter = 0)
	{
		$nomor_baru = intval(substr($nomer_terakhir, strlen($kunci))) + 1;
		$nomer_baru_plus_nol = str_pad($nomor_baru, $jumlah_karakter, "0", STR_PAD_LEFT);
		$kode = $kunci.$nomer_baru_plus_nol;
		return $kode;
	}
	
	function buatKode2($nomer_terakhir, $kunci, $jumlah_karakter = 0)
	{
		$nomor_baru = intval(substr($nomer_terakhir, strlen($kunci))) + 1;
		$nomer_baru_plus_nol = str_pad($nomor_baru, $jumlah_karakter, "0", STR_PAD_LEFT);
		$kode = $kunci.$nomer_baru_plus_nol;
		return $kode;
	}


	function getErrorValidation()
	{
		$CI = &get_instance();

		$forms = $CI->input->post();
		// var_dump($forms);
		foreach ($forms as $key => $value) {
			if ($key != 'id') {
				$response[$key] = form_error($key);
			}
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

	    $transaction = json_encode($transaction);
	    $curl = curl_init();

	    $token = SHA1('sppirt'.'tikbp0m'.date('YYmd'));
		//$token = SHA1('sppirt'.'tikbp0m'.'202120211001');
		//echo date('YYmd');
		//die();
		
	    curl_setopt_array($curl, 
	        array(
	            //CURLOPT_URL => "http://103.5.148.215/gateway-bpom/services/InqueryNIB", //public
				CURLOPT_URL => "http://172.16.1.215/gateway-bpom/services/InqueryNIB", //local bpom
	            CURLOPT_RETURNTRANSFER => true,
	            CURLOPT_ENCODING => "",
	            CURLOPT_MAXREDIRS => 10,
	            CURLOPT_TIMEOUT => 60,
	            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	            CURLOPT_CUSTOMREQUEST => "POST",
	            CURLOPT_POSTFIELDS => $transaction,
	            CURLOPT_HTTPHEADER => array(
	            "content-type: application/json",
	            "unit: 016",
	            "Token: ".$token
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

	function send_wa($transaction){

	    $transaction = json_encode($transaction);

	    $curl = curl_init();

	    curl_setopt_array($curl, 
	        array(
	            CURLOPT_URL => "http://172.16.2.43:9000/send_message", //Prod PMPU
	            //CURLOPT_URL => "http://localhost:9000/send_message", //DEV
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
	    $secret_key = 'sppirt!@#$';
	    $secret_iv = 'login';
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

 ?>