<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function verify() {
		$data = $this->input->post(array('user_name', 'password'));

		if (!isset($data['user_name']) || empty($data['user_name'])) {
			$output = array('success' => false, 'msg' => "Username missing");
		} else if (!isset($data['password']) || empty($data['password'])) {
			$output = array('success' => false, 'msg' => "Password missing");
		} else {
			$this->db->select('id, user_name');
			$data['user_name'] = $data['user_name'];
			$data['password'] = $data['password'];
			$data['admin_users.is_active'] = 1;
			$res = $this->db->get_where('admin_users', $data)->result_array();
			if (count($res)) {
				$this->session->set_userdata(array('access' => $res[0]));
				$output = array('success' => true, 'msg' => "Login Successfully");
			} else {
				$output = array('success' => false, 'msg' => "Invalid Credentials");
			}
		}
		echo json_encode($output);
		exit;
	}
}
