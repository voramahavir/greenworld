<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		// if (access()) {
		// 	redirect(site_url('dashboard'));
		// }
		// $this->load->view('login');
	}

	public function verify() {
		$this->load->model('UserModel');
		$this->UserModel->verify();
	}

	public function register(){
		$this->load->model('UserModel');
		$this->UserModel->register();
	}

	public function logout() {
		logout();
	}
}
