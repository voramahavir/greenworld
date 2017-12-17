<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NurseryController extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('NurseryModel');
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
		$this->NurseryModel->add();
	}

	public function get() {
		$this->NurseryModel->get();
	}

	public function delete($id=""){
		$this->NurseryModel->deleteNursery($id);
	}

	public function recover($id=""){
		$this->NurseryModel->recoverNursery($id);
	}

	public function edit($id=""){
		$this->NurseryModel->updateNursery($id);
	}

	public function import(){
		$this->NurseryModel->importBulkNursery();
	}
}
