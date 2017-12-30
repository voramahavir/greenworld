<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CodeController extends CI_Controller {

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
		$this->load->view('codes/list');
	}

	public function get(){
		$this->load->model('CodeModel');
		$this->CodeModel->get();
	}

	public function add(){
		$this->load->model('CodeModel');
		$this->CodeModel->add();
	}

	public function delete($id=""){
		$this->load->model('CodeModel');
		$this->CodeModel->delete($id);
	}

	public function recover($id=""){
		$this->load->model('CodeModel');
		$this->CodeModel->recover($id);
	}

	public function update($id='')
	{
		$this->load->model('CodeModel');
		$this->CodeModel->update($id);
	}

	public function checkCode()
	{
		$this->load->model('CodeModel');
		$this->CodeModel->checkCode();
	}
}
