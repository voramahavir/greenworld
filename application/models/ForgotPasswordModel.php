<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ForgotPasswordModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function checkToken($token='')
	{
		$success = false;
		$data = [];
		if($token != ''){
			$this->db->where('is_used',0);
			$this->db->where('token',$token);
			$res = $this->db->select('user_id')->get('forgot_password')->first_row();
			if(isset($res->user_id)){
				$success = true;
				$data['user_id'] = $res->user_id;
				$this->db->where('token',$token);
				// $this->db->set('is_used',1)->update('forgot_password');
			} else {
				$success = false;
			}
		}
		echo json_encode(array('success' => $success, 'data' => $data));
		exit();
	}
}

?>