<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function login() {
        $msg = checkParams($_POST,'user_name,password');
        $res = [];
		if (empty($msg)) {
            $user_name = $_POST['user_name'];
            $password = md5($_POST['password']);
			$res = $this->db->query("SELECT user_id, first_name, last_name, email, user_name, phone_no, is_verified FROM users WHERE (user_name = '".$user_name."' OR email = '".$user_name."' OR phone_no = '".$user_name."') AND password = '".$password."' AND is_active = 1")->first_row();
			if (count($res)) {
                $otp = rand(100000,999999);
                $message = $otp . " otp to verify your number.";
                $this->send_sms($message, $res->phone_no);
                $res->otp = $otp;
				$output = array('success' => true, 'message' => "Login Successfully", 'data' => (object)$res);
                if(isset($_POST['latitude']) && isset($_POST['longitude'])){
                    $this->db->where('user_id', $res->user_id);
                    $count = $this->db->update("users",array('latitude' => $_POST['latitude'], 'longitude' => $_POST['longitude']));
                }
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
        $msg = checkParams($_POST,'first_name,phone_no,password');
        if (empty($msg)) {
            $_POST = getSetData($_POST,'first_name,last_name,user_name,email,password,phone_no,city,birth_date,sex,user_type,device_id,os,user_fb_id,user_g_id,latitude,longitude,push_key,country_code,bio,app_version');
            $q = $this->db->or_where(array(
                'phone_no' => $_POST['phone_no']
            ))->get("users");
            $num_rows = $q->num_rows();
            if($num_rows>0){
                $msg = "User already exist.";
            } else {
                $target_path = './assets/profilePics/';
                if (!file_exists($target_path)) {
                    mkdir($target_path, 0777, true);
                }
                if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                    $exp = explode(".", $_FILES['image']['name']);
                    $extension = end($exp);
                    $file_name = md5(''.time());
                    $target_path = $target_path . '/'. $file_name .'.'. $extension ;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                        $_POST['profile_pic'] = '/assets/profilePics/'. $file_name .'.'.$extension;
                    } else {
                        $msg = "Error in uploading file, Try again.";
                    }
                }
                if(empty($msg)){
                    $_POST['password'] = md5($_POST['password']);
                    $this->db->insert("users",$_POST);
                    if($this->db->insert_id()){
                    	$id = $this->db->insert_id();
                        $success = true;
                        $msg = "User registered successfully.";
                        $data = $this->db->select('user_id,first_name,last_name,email,user_name,phone_no')->where('user_id',$id)->get("users")->first_row();
                        $otp = rand(100000,999999);
                        $message = $otp . " otp to verify your number.";
                        $this->send_sms($message, $data->phone_no);
                        $data->otp = $otp;
                    } else{
                        $msg = "Oops! error registering user.";
                    }
                }
            }
        }
        echo json_encode(array("success" => $success,"msg" => $msg,"data" => (object)$data));
        exit();
	}

    public function connectorfollow(){
        $msg = checkParams($_POST);
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

    public function getUserData(){
        $search = array('value' => '');
        if (isset($_POST['search'])) {
            $search = $_POST['search'];
        }
        if (isset($search['value'])) {
            $search = $search['value'];
        }
        $start = 0;
        if (isset($_POST['start'])) {
            $start = $_POST['start'];
        }
        $length = 10;
        if (isset($_POST['length'])) {
            $length = $_POST['length'];
        }
        $draw = 1;
        if (isset($_POST['draw'])) {
            $draw = $_POST['draw'];
        }

        $output = array("code" => 0,
            'draw' => $draw,
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'search' => $search
        );
        if(!empty($search)){$this->db->like("user_name",$search);}
        $output['data'] = $this->db->select('*')->get('users')->result();
        if(!empty($search)){$this->db->like("user_name",$search);}
        $output['recordsTotal']=$this->db->get('users')->num_rows();
        $output['recordsFiltered']=$output['recordsTotal'];
        if (!empty($output['data'])) {
            $output['code'] = 1;
        }
        echo json_encode($output);
        exit;
    }

    public function deleteUser($id)
    {
        $success = false;
        $msg = "";
        $count = $this->db->where('user_id', $id)->delete("users");
        if($count > 0){
            $success = true;
            $msg = "User deleted successfully.";
        } else{
            $msg = "Error deleting user,Try again.";
        }
        echo json_encode(array("success" => $success, "msg" => $msg));
        exit();
    }

    public function recoverUser($id)
    {
        $success = false;
        $msg = "";
        $count = $this->db->where('user_id', $id)->set(array(
            'is_active' => 1
        ))->update("users");
        if($count > 0){
            $success = true;
            $msg = "User recovered successfully.";
        } else{
            $msg = "Error recovering user,Try again.";
        }
        echo json_encode(array("success" => $success, "msg" => $msg));
        exit();
    }

    public function getData($id='')
    {
        $success = false;
        $this->db->where('user_id', $id);
        $response = $this->db->select('user_id,first_name,last_name,email,user_name,phone_no,bio,sex,user_type,birth_date,profile_pic,city')->get('users')->first_row();
        if($response != null){
            $success = true;
            $msg = 'Data fetched successfully';
        } else {
            $msg = 'User does not exist.';
        }
        echo json_encode(array("success" => $success, "msg" => $msg, "response" => $response));
        exit();
    }

    public function updateUser($id='')
    {
        $success = false;
        $msg = checkParams($_POST,'first_name,phone_no');
        if(empty($msg)){
            $_POST = getSetData($_POST,'first_name,last_name,user_name,email,password,phone_no,city,birth_date,sex,user_type,country_code,bio');
            $target_path = './assets/profilePics/';
            if (!file_exists($target_path)) {
                mkdir($target_path, 0777, true);
            }
            if (isset($_FILES['image']['name'])) {
                $exp = explode(".", $_FILES['image']['name']);
                $extension = end($exp);
                $file_name = md5(''.time());
                $target_path = $target_path . '/'. $file_name .'.'. $extension ;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    $_POST['profile_pic'] = '/assets/profilePics/'. $file_name .'.'.$extension;
                } else {
                    $msg = "Error in uploading file, Try again.";
                }
            }
            $count = 0;
            if(isset($_POST['password']) && $_POST['password'] === ''){
                unset($_POST['password']);
            } else if (isset($_POST['password'])) {
                $_POST['password'] = md5($_POST['password']);
            }
            $this->db->where('user_id', $id);
            $count = $this->db->update("users",$_POST);
            if($count > 0){
                $success = true;
                $msg = 'User details updated successfully';
            }else{
                $msg = 'Error updating user details, Try again.';
            }
        }
        echo json_encode(array("success" => $success, "msg" => $msg));
        exit();
    }

    public function updateLatLong($id='')
    {
        $success = false;
        $msg = checkParams($_POST,'latitude,longitude');
        if(!empty($id) && empty($msg)){
            $_POST = getSetData($_POST,'latitude,longitude');
            $this->db->where('user_id', $id);
            $count = $this->db->update("users",$_POST);
            if($count > 0){
                $success = true;
                $msg = 'Location updated successfully';
            }else{
                $msg = 'Error updating location, Try again.';
            }
        }
        echo json_encode(array("success" => $success, "msg" => $msg));
        exit();
    }

    public function verifyUser($id='')
    {
        $success = false;
        $msg = '';
        if(!empty($id)) {
            $this->db->where('user_id', $id);
            $count = $this->db->update("users", array('is_verified' => 1));
            if($count > 0){
                $success = true;
                $msg = 'User verified successfully';
            }else{
                $msg = 'Error verifing user, Try again.';
            }
        }
        echo json_encode(array("success" => $success, "msg" => $msg));
        exit();
    }

    public function send_sms($message='', $mobileNumber)
    {        
        //Your authentication key
        $authKey = "190629AOn1V8cU4Y55a47ef98";
        
        //Sender ID,While using route4 sender id should be 6 characters long.
        $senderId = "REGREE";
        
        //Your message to send, Add URL encoding here.
        $message = urlencode($message);
            
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://api.msg91.com/api/v2/sendsms",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "{ \"sender\": \"REGREN\", \"route\": \"4\", \"country\": \"91\", \"sms\": [ { \"message\": \"$message\", \"to\": [ \"$mobileNumber\" ] } ] }",
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_HTTPHEADER => array(
            "authkey: " . $authKey,
            "content-type: application/json"
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);

        if ($err) {
          return "cURL Error #:" . $err;
        } else {
          return $response;
        }
            
        return true;
    }

    public function changePassword($id='')
    {
        $success = false;
        $msg = checkParams($_POST,'old_password,new_password');
        if($msg === '' && !empty($id)) {
            $old_password = md5($_POST['old_password']);
            $this->db->where('user_id', $id);
            $this->db->where('password', $old_password);
            $res = $this->db->select('user_id')->get('users')->first_row();
            if(isset($res->user_id)){
                $this->db->where('user_id', $id);
                $count = $this->db->update("users", array('password' => md5($_POST['new_password'])));
                if($count > 0){
                    $success = true;
                    $msg = 'Password changed successfully';
                }else{
                    $msg = 'Error changing password, Try again.';
                }
            } else {
                $msg = 'Wrong old password.';
            }
        }
        echo json_encode(array("success" => $success, "msg" => $msg));
        exit();
    }

    public function sendEmail()
    {
        $success = false;
        $msg = checkParams($_POST,'value');
        if($msg === ''){
            $this->db->or_where(array('email' => $_POST['value'],'phone_no' => $_POST['value']));
            $res = $this->db->select('user_id,email,phone_no')->get('users')->first_row();
            if(isset($res->email) && $res->email != ''){
                $token = bin2hex(random_bytes(10));
                $this->load->library('email');
                $email_body ="Reset password link : ".site_url('forgotPassword?token=').$token;
                $this->email->from('regreenamd@gmail.com', 'ReGreen');
                $list = array($_POST['value']);
                $this->email->to($list);
                $this->email->subject('Forgot Password');
                $this->email->message($email_body);
                $this->email->send();
                if(isset($res->phone_no) && $res->phone_no != ''){
                    $message = "Reset password link : ".site_url('forgotPassword?token=').$token;
                    $this->send_sms($message,$res->phone_no);
                }
                $data = array('token' => $token, 'user_id' => $res->user_id);
                $this->db->insert('forgot_password',$data);
                if($this->db->insert_id()){
                    $success = true;
                    $msg = "Link sent successfully.";
                }
            } else {
                $msg = 'Email or Phone no does not exist.';
            }
        }
        echo json_encode(array("success" => $success, "msg" => $msg));
        exit();
    }

    public function resendOtp($id) {
        $output = array();
        $res = $this->db->query("SELECT user_id, phone_no, is_verified FROM users WHERE user_id = '".$id."' AND is_active = 1")->first_row();
        if (count($res) && $res->is_verified == 0) {
            $otp = rand(100000,999999);
            $message = $otp . " otp to verify your number.";
            $this->send_sms($message, $res->phone_no);
            $res->otp = $otp;
            $output = array('success' => true, 'message' => "Otp send successfully", 'data' => $res);
        } else {
            $output = array('success' => false, 'message' => "Already verified user", 'data' => $res);
        }
        echo json_encode($output);
        exit();
    }
}
