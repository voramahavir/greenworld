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

	public function connectorfollow(){
		$this->load->model('UserModel');
		$this->UserModel->connectorfollow();
	}

	public function list(){
		$this->load->view('users/list');
	}

	public function get(){
		$this->load->model('UserModel');
		$this->UserModel->getUserData();
	}

	public function delete($id=""){
		$this->load->model('UserModel');
		$this->UserModel->deleteUser($id);
	}

	public function recover($id=""){
		$this->load->model('UserModel');
		$this->UserModel->recoverUser($id);
	}
}
