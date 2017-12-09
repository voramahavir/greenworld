<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GroupController extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		// if (access()) {
		// 	redirect(site_url('dashboard'));
		// }
		// $this->load->view('login');
	}

	public function create() {
		$this->load->model('GroupModel');
		$this->GroupModel->create();
	}
}
