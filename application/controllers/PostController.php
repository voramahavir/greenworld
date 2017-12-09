<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PostController extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		// if (access()) {
		// 	redirect(site_url('dashboard'));
		// }
		// $this->load->view('login');
	}

	public function add() {
		$this->load->model('PostModel');
		$this->PostModel->add();
	}

	public function get() {
		$this->load->model('PostModel');
		$this->PostModel->getPosts();
	}
}
