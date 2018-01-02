<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ForgotPasswordController extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		$data['token'] = $_GET['token'];
		$this->load->view('forgotpassword',$data);
	}

	public function checkToken($token="") {
		$this->load->model('ForgotPasswordModel');
		$this->ForgotPasswordModel->checkToken($token);
	}
}
