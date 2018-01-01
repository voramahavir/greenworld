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

	public function login() {
		$this->load->model('UserModel');
		$this->UserModel->login();
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

	public function addUser(){
		$this->load->view('users/add_user');
	}

	public function editUser($id=""){
		$data['id'] = $id;
		$this->load->view('users/edit_user',$data);
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

	public function update($id='')
	{
		$this->load->model('UserModel');
		$this->UserModel->updateUser($id);
	}

	public function getUserData($id='')
	{
		$this->load->model('UserModel');
		$this->UserModel->getData($id);
	}

	public function updateLatLong($id='')
	{
		$this->load->model('UserModel');
		$this->UserModel->updateLatLong($id);
	}

	public function verifyUser($id='')
	{
		$this->load->model('UserModel');
		$this->UserModel->verifyUser($id);
	}

	public function splash() {
		if (is_file('maintenance.txt')) {
			echo json_encode(array("success" => true, "msg" => "maintenance break"));
	    	exit();
		} else {
			echo json_encode(array("success" => false, "msg" => ""));
	    	exit();
		}
	}

	public function resendOtp($id='') {
		$this->load->model('UserModel');
		$this->UserModel->resendOtp($id);
	}
}
