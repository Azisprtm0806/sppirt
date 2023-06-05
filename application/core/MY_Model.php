<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
* Updated by SAM (Jun 23,2015)
* change logs
* add variable "by" to delete function
*
*/

class MY_Model extends CI_Model {

    protected $tblName;
    protected $_user_id;
    protected $_username;

    public function __construct(){
        parent::__construct();
        $this->load->database();
        $userData = $this->session->userdata("userData");
        if(isset($userData['id'])){
            $this->_user_id = $userData['id'];
        }else{
            $this->_user_id = 0;
        }
    }

	public function query($query){
        return $this->db->query($query);
    }

    public function source(){
        return $this->db->from($this->tblName);
    }

    public function count(){
        return $this->db->count_all_results($this->tblName);
    }

    public function list($by='id',$id=''){

        $this->db->from($this->tblName);
        if($id!=''){
            $this->db->where($by,$id);   
        }
        return $this->db->get()->result();

    }

    public function list_sort($by='id', $id='', $sortby='', $sort=''){
        $this->db->from($this->tblName);
        if($id!=''){
            $this->db->where($by,$id);   
        }
        $this->db->order_by($sortby, $sort);
        return $this->db->get()->result();
    }

    public function find($id,$by='id'){
        $this->db->from($this->tblName);
        return $this->db->where($by,$id)->get()->row();
    }

    public function insert($data){    

        $data["created_at"] = gmdate("Y-m-d H:i:s",time()+60*60*7);
        $data["created_by"] = $this->_user_id;

        foreach($data as $key=>$val){
            if ($this->db->field_exists($key, $this->tblName)){
                $insert[$key] = htmlspecialchars(stripslashes($val));
            }   
        }

        $this->db->insert($this->tblName, $insert); 
        $insert_id = $this->db->insert_id();
        return $insert_id;

    }

    public function update($data,$id,$by='id'){

        $data["updated_at"] = gmdate("Y-m-d H:i:s",time()+60*60*7);
        $data["updated_by"] = $this->_user_id;

        foreach($data as $key=>$val){
            if ($this->db->field_exists($key, $this->tblName)){
                $update[$key] = htmlspecialchars(stripslashes($val));
            }
        }

        $this->db->where($by,$id);
        $this->db->update($this->tblName, $update); 
        return $id;

    }

    public function delete($id,$by='id'){

        $this->db->where($by,$id);
        $this->db->delete($this->tblName);
   
    }

    public function soft_delete($id,$by='id'){

        $data["deleted_at"] = gmdate("Y-m-d H:i:s",time()+60*60*7);
        $this->db->where($by,$id);
        $this->db->update($this->tblName, $data);

    }

    public function restore($id,$by='id'){

        $data["deleted_at"] = NULL;
        $this->db->where($by,$id);
        $this->db->update($this->tblName, $data);

    }


}