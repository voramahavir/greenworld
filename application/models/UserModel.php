<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function verify() {
		$data = $this->input->post(array('user_name', 'password'));
		if (!isset($data['user_name']) || empty($data['user_name'])) {
			$output = array('code' => 0, 'message' => "Username missing.");
		} else if (!isset($data['password']) || empty($data['password'])) {
			$output = array('code' => 0, 'message' => "Password missing.");
		} else {
			$this->db->select('user_id,first_name,last_name,email,user_name,phone_no');
			$this->db->or_where('user_name',$data['user_name']);
			$this->db->or_where('email',$data['user_name']);
			$this->db->or_where('phone_no',$data['user_name']);
			$this->db->where('password',md5($data['password']));
			$this->db->where('is_active',1);
			$res = $this->db->get('users')->first_row();
			$res=(object)$res;
			if (count($res)) {
				$output = array('code' => 1, 'message' => "Login Successfully", 'data' => $res);
			} else {
				$output = array('code' => 0, 'message' => "Invalid Credentials", 'data' => $res);
			}
		}
		echo json_encode($output);
		exit;
	}

	public function register(){
        $post = $_POST;
        $data=array();
        $code=0;
        $msg='';
        $first_name='';       
        if(isset($post['first_name'])){$first_name=$post['first_name'];}
        $email='';       
        if(isset($post['email'])){$email=$post['email'];}
        $phone_no='';       
        if(isset($post['phone_no'])){$phone_no=$post['phone_no'];}
        $user_name='';       
        if(isset($post['user_name'])){$user_name=$post['user_name'];}
        $last_name='';       
        if(isset($post['last_name'])){$last_name=$post['last_name'];}
        $sex='';       
        if(isset($post['sex'])){$sex=$post['sex'];}
        $birth_date='';       
        if(isset($post['birth_date'])){$birth_date=$post['birth_date'];}
        $password='';       
        if(isset($post['password'])){$password=md5($post['password']);$post['password']=$password;}
        $device_id='';       
        if(isset($post['device_id'])){$device_id=$post['device_id'];}
        $os='';       
        if(isset($post['os'])){$os=$post['os'];}
        $user_type='';       
        if(isset($post['user_type'])){$user_type=$post['user_type'];}

        if(empty($first_name)){
            $msg="First name is not provided.";
        }
        else if(empty($last_name)){
            $msg="Last name is not provided.";
        }
        else if(empty($email)){
            $msg="Email is not provided.";
        }
        else if(empty($user_name)){
            $msg="Username is not provided.";
        }
        else if(empty($sex)){
            $msg="Gender is not provided.";
        }
        else if(empty($birth_date)){
            $msg="Date of birth is not provided.";
        }
        else if(empty($device_id)){
            $msg="Device ID is not provided.";
        }
        else if(empty($os)){
            $msg="Operating system is not provided.";
        }
        else if(empty($password)){
            $msg="Password is not provided.";
        } 
        else if (empty($phone_no)) {
            $msg="Phone No is not provided.";
        }
        else if(empty($user_type)){
            $msg="User type is not provided.";
        }
        else{
            $q = $this->db->or_where(array(
                'email' => $email,'phone_no'=>$phone_no,'user_name'=>$user_name
            ))->get("users");
            $num_rows = $q->num_rows();
            if($num_rows>0){
                $msg="User already exist.";
            }else{
                $this->db->insert("users",$post);
                if($this->db->insert_id()){
                	$id = $this->db->insert_id();
                	$this->InsertDeviceID($device_id,$os,$id);
                    $code=1;
                    $msg="User registered successfully.";
                    $data=$this->db->select('user_id,first_name,last_name,email,user_name,phone_no')->where('user_id',$id)->get("users")->first_row();
                    $data=(object)$data;
                }else{
                    $msg="Oops! error registering user.";
                }
            }
        }
        echo json_encode(array("code"=>$code,"msg"=>$msg,"data"=>$data));
        exit();
	}

	public function InsertDeviceID($device_id='',$os='',$user_id=''){
        $data=array("device_id"=>$device_id,"user_id"=>$user_id,"os"=>$os);
        $this->db->where($data);
        $num_rows=$this->db->get('device_details')->num_rows();
        if($num_rows<=0){
            $this->db->insert("device_details",$data);
        }
    }
}
