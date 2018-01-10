<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlantBannerController extends CI_Controller {

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
		$this->load->view('plant/banners');
	}

	public function add() {
		$this->load->model('PlantBannerModel');
		$this->PlantBannerModel->add();
	}

	public function get() {
		$this->load->model('PlantBannerModel');
		$this->PlantBannerModel->get();
	}

	public function delete($id=""){
		$this->load->model('PlantBannerModel');
		$this->PlantBannerModel->deletePlantBanner($id);
	}

	public function recover($id=""){
		$this->load->model('PlantBannerModel');
		$this->PlantBannerModel->recoverPlantBanner($id);
	}

	public function edit($id=""){
		$this->load->model('PlantBannerModel');
		$this->PlantBannerModel->updatePlantBanner($id);
	}

	public function random(){
		$this->load->model('PlantBannerModel');
		$this->PlantBannerModel->random();
	}
}
