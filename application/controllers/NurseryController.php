<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NurseryController extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	public function index() {
		// if (access()) {
		// 	redirect(site_url('dashboard'));
		// }
		// $this->load->view('login');
	}

	public function list(){
		$this->load->view('nursery/list');
	}

	public function add() {
		$this->load->model('NurseryModel');
		$this->NurseryModel->add();
	}

	public function get() {
		$this->load->model('NurseryModel');
		$this->NurseryModel->get();
	}

	public function delete($id=""){
		$this->load->model('NurseryModel');
		$this->NurseryModel->deleteNursery($id);
	}

	public function recover($id=""){
		$this->load->model('NurseryModel');
		$this->NurseryModel->recoverNursery($id);
	}
}
