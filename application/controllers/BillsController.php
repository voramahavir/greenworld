<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BillsController extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('BillsModel');
	}

	public function index() {
		// if (access()) {
		// 	redirect(site_url('dashboard'));
		// }
		// $this->load->view('login');
	}

	public function list(){
		$this->load->view('bills/list');
	}

	public function add() {
		$this->BillsModel->add();
	}

	public function get($id='') {
		$this->BillsModel->get($id);
	}

	public function confirm($id=""){
		$this->BillsModel->confirm($id);
	}
}
