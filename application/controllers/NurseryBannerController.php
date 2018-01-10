<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NurseryBannerController extends CI_Controller {

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
		$this->load->view('nursery/banners');
	}

	public function add() {
		$this->load->model('NurseryBannerModel');
		$this->NurseryBannerModel->add();
	}

	public function get() {
		$this->load->model('NurseryBannerModel');
		$this->NurseryBannerModel->get();
	}

	public function delete($id=""){
		$this->load->model('NurseryBannerModel');
		$this->NurseryBannerModel->deleteNurseryBanner($id);
	}

	public function recover($id=""){
		$this->load->model('NurseryBannerModel');
		$this->NurseryBannerModel->recoverNurseryBanner($id);
	}

	public function edit($id=""){
		$this->load->model('NurseryBannerModel');
		$this->NurseryBannerModel->updateNurseryBanner($id);
	}

	public function random(){
		$this->load->model('NurseryBannerModel');
		$this->NurseryBannerModel->random();
	}
}
