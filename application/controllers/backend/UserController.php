<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends MY_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->library('image_lib');

		$this->user_model = new GeneralModel("tb_user");
		$this->role_model = new GeneralModel("tb_role");
		$this->provinsi_model = new GeneralModel("tb_provinsi");
		$this->kab_kota_model = new GeneralModel("tb_kota");

		$this->userlog = $this->session->userdata('userData');

	}

	public function index()
	{

		$data = [
			'title' => 'User',
			'breadcrumb' => breadcrumb('User', 'backend/user')
		];

		$limit = isset($this->input_data['limit'])?$this->input_data['limit']:10;
		$page = isset($this->input_data['page'])?$this->input_data['page']:1;
		$start = isset($this->input_data['page'])?(($page-1)*$limit):0;

		$q = isset($this->input_data['q'])?$this->input_data['q']:"";

		$query = $this->user_model->source();
		$query->select('tb_user.*, tb_role.role as role');
		$query->join('tb_role','tb_role.id_role=tb_user.id_role');
		if($q!=""){
			$query->group_start();
				$query->like('tb_user.nib',$q);
				$query->or_like('tb_user.email',$q);
				$query->or_like('tb_user.no_telp',$q);
				$query->or_like('tb_user.nama',$q);
			$query->group_end();
		}
		$total_data = $query->count_all_results();

		$query = $this->user_model->source();
		$query->select('tb_user.*, tb_role.role as role');
		$query->join('tb_role','tb_role.id_role=tb_user.id_role');
		if($q!=""){
			$query->group_start();
				$query->like('tb_user.nib',$q);
				$query->or_like('tb_user.email',$q);
				$query->or_like('tb_user.no_telp',$q);
				$query->or_like('tb_user.nama',$q);
			$query->group_end();
		}
		$query->limit($limit,$start);
		$query->order_by('created_at','DESC');
		$data['datas'] = $query->get()->result();

		$data['total_data'] = $total_data;
		$data['limit'] = $limit;
		$data['start'] = $start;
		$data['pagination'] = $this->paging_page('user',$limit,$total_data);
		
		$this->template->load('template/backend', 'backend/user/list', $data);

	}

	public function add()
	{
		$data = array();

		$data = [
			'title' => 'Form edit user',
			'breadcrumb' => breadcrumb('Form User', 'backend/user'),
		];

		$query = $this->role_model->source();
		$data['user_role'] = $query->get()->result();

		$query = $this->provinsi_model->source();
		$data['provinsi'] = $query->get()->result();
		
		$this->template->load('template/backend', 'backend/user/form', $data);

	}

	public function save()
	{

		$param_data = $this->input_data;

		$query = $this->user_model->source();
		$query->where('email',$param_data['email']);
		$query->or_where('username',$param_data['username']);
		$user = $query->get()->row();
		if(isset($user->id)){

			$this->session->set_flashdata("error", "Email sudah digunakan, silahakan gunakan email lain");
			redirect("user/add");

		}else{

			if($param_data['password']==""){

				$this->session->set_flashdata('error', 'Password tidak boleh kosong');
				redirect('user/add');

			}else if(strlen($param_data['password'])<8){
		   
		    	$this->session->set_flashdata('error', 'Password minimal 8 karakter');
				redirect('user/add');

	    	}else if($param_data['password']!=$param_data['re_password']){

		    	$this->session->set_flashdata('error', 'Password & ulangi password tidak sama');
				redirect('user/add');

	    	}else if(!preg_match('@[A-Z]@', $param_data['password'])){
	 
		    	$this->session->set_flashdata('error', 'Password minimal mengandung satu huruf besar');
				redirect('user/add');

	    	}else if(!preg_match('@[0-9]@', $param_data['password'])){

		    	$this->session->set_flashdata('error', 'Password minimal mengandung satu angka');
				redirect('user/add');

	    	}else if (!preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $param_data['password'])){

		    	$this->session->set_flashdata('error', 'Password minimal mengandung satu spesial karakter');
				redirect('user/add');

			}else if (!preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $param_data['password'])){
		    	$this->session->set_flashdata('error', 'Password minimal mengandung satu spesial karakter');
				redirect('user/add');
			}


			$param_data['password'] = md5($param_data['password']);
			$param_data['status'] = 'ACTIVE';
			$this->user_model->insert($param_data);

			$this->session->set_flashdata("success", "Data berhasil disimpan");
			redirect("user");

		}

	}

	public function get($id){
		
		$id = strip_tags($id);
		$id = encrypt_decrypt('decrypt', $id);

		$data = [
			'title' => 'Form edit user',
			'breadcrumb' => breadcrumb('Form Edit Password', 'backend/user'),
		];

		$query = $this->role_model->source();
		$data['user_role'] = $query->get()->result();
		
		$query = $this->provinsi_model->source();
		$data['provinsi'] = $query->get()->result();

		$data['data'] = $this->user_model->find($id,'id_user');

		$this->template->load('template/backend', 'backend/user/form-edit', $data);

	}

	public function update($id)
	{

		$id = strip_tags($id);
		$id = encrypt_decrypt('decrypt', $id);

		$param_data = $this->input_data;
		$this->user_model->update($param_data,$id,'id_user');

		$this->session->set_flashdata("success", "Data berhasil Update");
		redirect('user');

	}

	public function get_data($id){
		
		$id = strip_tags($id);
		$id = encrypt_decrypt('decrypt', $id);

		$data = [
			'title' => 'User',
			'breadcrumb' => breadcrumb('Form Ubah Password', 'backend/user'),
		];

		$data['data'] = $this->user_model->find($id,'id_user');
		
		$this->template->load('template/backend', 'backend/user/form-change-password', $data);


	}

	public function change_password($id_encrypt)
	{

		$id_encrypt = strip_tags($id_encrypt);
		$id = encrypt_decrypt('decrypt', $id_encrypt);
		$param_data = $this->input_data;
		
		if($param_data['password']==""){

			$this->session->set_flashdata('error', 'Password tidak boleh kosong');
			redirect('user/ubah-password/'.$id_encrypt);

		}else if(strlen($param_data['password'])<8){
	   
	    	$this->session->set_flashdata('error', 'Password minimal 8 karakter');
			redirect('user/ubah-password/'.$id_encrypt);

    	}else if($param_data['password']!=$param_data['re_password']){

	    	$this->session->set_flashdata('error', 'Password & ulangi password tidak sama');
			redirect('user/ubah-password/'.$id_encrypt);

    	}else if(!preg_match('@[A-Z]@', $param_data['password'])){
 
	    	$this->session->set_flashdata('error', 'Password minimal mengandung satu huruf besar');
			redirect('user/ubah-password/'.$id_encrypt);

    	}else if(!preg_match('@[0-9]@', $param_data['password'])){

	    	$this->session->set_flashdata('error', 'Password minimal mengandung satu angka');
			redirect('user/ubah-password/'.$id_encrypt);

    	}else if (!preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $param_data['password'])){

	    	$this->session->set_flashdata('error', 'Password minimal mengandung satu spesial karakter');
			redirect('user/ubah-password/'.$id_encrypt);

		}else if (!preg_match('/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/', $param_data['password'])){
	    	$this->session->set_flashdata('error', 'Password minimal mengandung satu spesial karakter');
			redirect('user/ubah-password/'.$id_encrypt);
		}

		$param_data['password'] = md5($param_data['password']);
		$this->user_model->update($param_data,$id,'id_user');

		$this->session->set_flashdata("success", "Password di berhasil Update");
		redirect('user');

	}

	public function delete($id){
		
		$id = strip_tags($id);
		$id = encrypt_decrypt('decrypt', $id);

		$this->user_model->delete($id,'id_user');

		$this->session->set_flashdata("success", "Data berhasil dihapus");
		redirect("user");

	}
	

	public function action_ubah_password(){

		if($this->input_data['password']=="" || $this->input_data['password']==" " || $this->input_data['re_password']=="" || $this->input_data['re_password']==" "){

			$this->session->set_flashdata("error", "Password dan ketik ulang password tidak boleh kosong");
			redirect("ubah-password");

		}else if(strlen($this->input_data['password'])<6){

			$this->session->set_flashdata("error", "Password harus lebih dari 6 karakter");
			redirect("ubah-password");

		}else if($this->input_data['password']!=$this->input_data['re_password']){

			$this->session->set_flashdata("error", "Password dan ketik ulang password tidak sama");
			redirect("ubah-password");

		}else{

			$data_user = array('password'=>md5($this->input_data['password']));
			$this->user_model->update($data_user,$this->userlog['id']);

			$this->session->set_flashdata("success", "Password berhasil diubah");
			redirect("ubah-password");

		} 

		
	}

	public function upload_picture(){

		$crop_data = json_decode(stripslashes($this->input_data['avatar-data']));

		$file = $_FILES['file'];
		$name = 'users_'.$this->userlog['id'].'_'.date('YmdHis').'.jpg';

		$uploadPath = APPPATH . '../assets/images/users/original/'.$name;
		$result = move_uploaded_file($file['tmp_name'], $uploadPath);

		$result_crop = $this->crop($uploadPath,$name,$crop_data);
		if($result_crop['status']=='success'){

			$path = APPPATH . '../assets/images/users/standar/'.$name;
			$result_resize = $this->resize($path,$name,600);
			if($result_resize['status']=='success'){
	
	   			$response['status'] = "success";
	            $response['msg'] = 'SUCCESS: to upload';

		    }

		    $path = APPPATH . '../assets/images/users/thumbs/'.$name;
			$result_resize = $this->resize($path,$name,300);
			if($result_resize['status']=='success'){
	
	   			$response['status'] = "success";
	            $response['msg'] = 'SUCCESS: to upload';
	            $response['thumbPath'] = base_url().'assets/images/users/thumbs/'.$name;

		    }

		    unlink($result_crop['thumbPath']);
		        
		}else{

			$response['status'] = "error";
	        $response['msg'] = 'FAILED: to upload ';

		}

		echo json_encode($response);


	}


	private function crop($source,$name,$crop_data){

		$config['image_library'] = 'gd2';
        $config['source_image'] = $source;
        $config['new_image'] = APPPATH . '../assets/images/users/'.$name;
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
		$config['source_image'] = APPPATH . '../assets/images/users/'.$name;
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
