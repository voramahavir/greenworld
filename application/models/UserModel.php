<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

    public function checkParams($post){
        $msg = '';
        foreach ($post as $param_name => $param_val) {
            if(empty($param_val)){
                $msg .= "$param_name is missing,";
            }
        }
        return $msg;
    }

	public function verify() {
        $msg = $this->checkParams($_POST);
        $res = [];
		if (empty($msg)) {
			$this->db->select('user_id,first_name,last_name,email,user_name,phone_no');
			$this->db->or_where('user_name',$_POST['user_name']);
			$this->db->or_where('email',$_POST['user_name']);
			$this->db->or_where('phone_no',$_POST['user_name']);
			$this->db->where('password',md5($_POST['password']));
			$this->db->where('is_active',1);
			$res = $this->db->get('users')->first_row();
			if (count($res)) {
				$output = array('success' => true, 'message' => "Login Successfully", 'data' => (object)$res);
			} else {
				$output = array('success' => false, 'message' => "Invalid Credentials", 'data' => (object)$res);
			}
		} else {
            $output = array('success' => false, 'message' => $msg, 'data' => (object)$res);
        }
		echo json_encode($output);
		exit;
	}

	public function register(){
        $data = array();
        $success = false;
        $msg = $this->checkParams($_POST);

        if (empty($msg)) {
            $q = $this->db->or_where(array(
                'email' => $_POST['email'],'phone_no' => $_POST['phone_no'],'user_name' => $_POST['user_name']
            ))->get("users");
            $num_rows = $q->num_rows();
            if($num_rows>0){
                $msg = "User already exist.";
            }else{
                $this->db->insert("users",$_POST);
                if($this->db->insert_id()){
                	$id = $this->db->insert_id();
                    $success = true;
                    $msg = "User registered successfully.";
                    $data = $this->db->select('user_id,first_name,last_name,email,user_name,phone_no')->where('user_id',$id)->get("users")->first_row();
                }else{
                    $msg = "Oops! error registering user.";
                }
            }
        }
        echo json_encode(array("success" => $success,"msg" => $msg,"data" => (object)$data));
        exit();
	}

    public function connectorfollow(){
        $msg = $this->checkParams($_POST);
        if (empty($msg)) {
            $connected_by = $this->db->where('user_id',$_POST['connected_by'])->get('users')->result();
            $connected_to = $this->db->where('user_id',$_POST['connected_to'])->get('users')->result();
            if (count($connected_to) && count($connected_by)) {
                $is_exists = $this->db->where($_POST)->get('connect')->num_rows();
                if(!$is_exists){
                    $_POST['type'] = $connected_to[0]->user_type;
                    $res = $this->db->insert("connect",$_POST);
                    if ($res) {
                        $output = array('success' => true, 'message' => "Users gets connected Successfully");
                    } else {
                        $output = array('success' => false, 'message' => "Oops, Error in creating connection between two user.");
                    }
                }else{
                    $output = array('success' => false, 'message' => "Users are already connected.");
                }
            }else{
                $output = array('success' => false, 'message' => "User does not exist.");
            }
		} else {
            $output = array('success' => true, 'message' => $msg);
        }
		echo json_encode($output);
		exit;
    }
}
