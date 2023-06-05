<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AccountController extends MY_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->library('image_lib');

		$this->role_model = new GeneralModel("tb_role");
		$this->user_model = new GeneralModel("tb_user");
		$this->provinsi_model = new GeneralModel("tb_provinsi");

	}

	public function account(){
		
		$data = [
			'title' => 'Accont',
			'breadcrumb' => breadcrumb('Account', 'account')
		];

		$data['data'] = $this->user_model->find($this->userData['id'],'id_user');

		$query = $this->provinsi_model->source();
		$data['provinsi'] = $query->get()->result();

		$query = $this->role_model->source();
		$data['user_role'] = $query->get()->result();

		$this->template->load('template/backend', 'backend/account/account', $data);

	}

	public function save_profil(){

		$this->user_model->update($this->input_data,$this->userData['id'],'id_user');

		$this->userData['nama'] = $this->input_data['nama'];
		$this->userData['picture'] = $this->input_data['picture'];
		$this->session->set_userdata("userData", $this->userData);
		
		$this->session->set_flashdata("success", "Data berhasil diupdate");
		redirect("account");

	}

	public function ubah_password(){

		$user = $this->user_model->find($this->userData['id'],'id_user');
		$this->input_data['current_password'];
		if(isset($user->id_user) && ($user->password==md5($this->input_data['current_password']))){

			if($this->input_data['password']==""){

				$this->session->set_flashdata('error', 'Password tidak boleh kosong');
				redirect("account?tab=ubah-password");

			}else if(strlen($this->input_data['password'])<8){
		   
		    	$this->session->set_flashdata('error', 'Password minimal 8 karakter');
				redirect("account?tab=ubah-password");

	    	}else if($this->input_data['password']!=$this->input_data['re_password']){

		    	$this->session->set_flashdata('error', 'Password & ulangi password tidak sama');
				redirect("account?tab=ubah-password");

	    	}else if(!preg_match('@[A-Z]@', $this->input_data['password'])){
	 
		    	$this->session->set_flashdata('error', 'Password minimal mengandung satu huruf besar');
				redirect("account?tab=ubah-password");

	    	}else if(!preg_match('@[0-9]@', $this->input_data['password'])){

		    	$this->session->set_flashdata('error', 'Password minimal mengandung satu angka');
				redirect("account?tab=ubah-password");

	    	}else if (!preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $this->input_data['password'])){

		    	$this->session->set_flashdata('error', 'Password minimal mengandung satu spesial karakter');
				redirect("account?tab=ubah-password");

			}else if (!preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $this->input_data['password'])){

		    	$this->session->set_flashdata('error', 'Password minimal mengandung satu spesial karakter');
				redirect("account?tab=ubah-password");

			}else{

				$data_user = array('password'=>md5($this->input_data['password']));
				$this->user_model->update($data_user,$this->userData['id'],'id_user');

				$this->session->set_flashdata("success", "Password changed successfully");
				redirect("account?tab=ubah-password");

			} 

		}else{

			$this->session->set_flashdata("error", "The current password you entered is incorrect");
			redirect("account?tab=ubah-password");

		}

		
	}

	public function upload_picture(){

		$crop_data = json_decode(stripslashes($this->input_data['avatar-data']));

		$file = $_FILES['file'];
		$name = 'users_'.$this->userData['id'].'_'.date('YmdHis').'.jpg';

		$uploadPath = APPPATH . '../assets/backend/public/images/profile/'.$name;
		$result = move_uploaded_file($file['tmp_name'], $uploadPath);

		$result_crop = $this->crop($uploadPath,$name,$crop_data);
		if($result_crop['status']=='success'){

			$path = APPPATH . '../assets/backend/public/images/profile/standar/'.$name;
			$result_resize = $this->resize($path,$name,600);
			if($result_resize['status']=='success'){
	
	   			$response['status'] = "success";
	            $response['msg'] = 'SUCCESS: to upload';

		    }

		    $path = APPPATH . '../assets/backend/public/images/profile/small/'.$name;
			$result_resize = $this->resize($path,$name,300);
			if($result_resize['status']=='success'){
	
	   			$response['status'] = "success";
	            $response['msg'] = 'SUCCESS: to upload';
	            $response['thumbPath'] = base_url().'assets/backend/public/images/profile/small/'.$name;

		    }

		}else{

			$response['error'] = $result_crop;
			$response['status'] = "error";
	        $response['msg'] = 'FAILED: to upload ';

		}

		echo json_encode($response);


	}


	private function crop($source,$name,$crop_data){

		$config['image_library'] = 'gd2';
        $config['source_image'] = $source;
        $config['new_image'] = APPPATH . '../assets/backend/public/images/profile/'.$name;
        $config['x_axis'] = round($crop_data->x,0);
        $config['y_axis'] = round($crop_data->y,0);
        $config['maintain_ratio'] = FALSE;
        $config['width'] = round($crop_data->width,0);
        $config['height'] = round($crop_data->height,0);

        $this->image_lib->initialize($config);
		if (!$this->image_lib->crop()){

		    $response['status'] = "error";
            $response['msg'] = 'FAILED: to crop ' . $this->image_lib->display_errors();

		}else{

			$response['status'] = "success";
            $response['msg'] = 'SUCCESS: to crop';
            $response['thumbPath'] = $config['new_image'];

		}

		return $response;

	}

	private function resize($path,$name,$width){

		$config['image_library'] = 'gd2';
		$config['source_image'] = APPPATH . '../assets/backend/public/images/profile/'.$name;
		$config['new_image'] = $path;
		$config['maintain_ratio'] = TRUE;
		$config['width']         = round($width,0);

		$this->image_lib->clear();
		$this->image_lib->initialize($config);

		if (!$this->image_lib->resize()){
            $response['status'] = "error";
            $response['msg'] = 'FAILED: to resize ';
        }else{
			$response['status'] = "success";
            $response['msg'] = 'SUCCESS: to resize';
            $response['thumbPath'] = $config['new_image'];
		}

		return $response;

	}


}
