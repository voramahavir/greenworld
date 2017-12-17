<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlantCategoryController extends CI_Controller {

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
		$this->load->view('plant_category/list');
	}

	public function add() {
		$this->load->model('PlantCategoryModel');
		$this->PlantCategoryModel->add();
	}

	public function get() {
		$this->load->model('PlantCategoryModel');
		$this->PlantCategoryModel->get();
	}

	public function delete($id=""){
		$this->load->model('PlantCategoryModel');
		$this->PlantCategoryModel->deletePlantCategory($id);
	}

	public function recover($id=""){
		$this->load->model('PlantCategoryModel');
		$this->PlantCategoryModel->recoverPlantCategory($id);
	}

	public function edit($id=""){
		$this->load->model('PlantCategoryModel');
		$this->PlantCategoryModel->updatePlantCategory($id);
	}
}
