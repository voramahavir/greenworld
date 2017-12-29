<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ArticlesController extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('ArticlesModel');
	}

	public function index() {
		// if (access()) {
		// 	redirect(site_url('dashboard'));
		// }
		// $this->load->view('login');
	}

	public function add() {
		$this->ArticlesModel->add();
	}

	public function get($id=0) {
		$this->ArticlesModel->get($id);
	}

	public function upvote(){
		$this->ArticlesModel->upvote();
	}
}
