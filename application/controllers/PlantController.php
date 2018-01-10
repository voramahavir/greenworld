<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlantController extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('PlantModel');
	}

	public function index() {
		// if (access()) {
		// 	redirect(site_url('dashboard'));
		// }
		// $this->load->view('login');
	}

	public function list(){
		$this->load->view('plant/list');
	}

	public function add() {
		$this->PlantModel->add();
	}

	public function get($id="") {
		$this->PlantModel->getPlants($id);
	}

	public function delete($id=""){
		$this->PlantModel->deletePlant($id);
	}

	public function recover($id=""){
		$this->PlantModel->recoverPlant($id);
	}

	public function edit($id=""){
		$this->PlantModel->updatePlant($id);
	}

	public function addUserPlant() {
		$this->PlantModel->addUserPlant();
	}

	public function import() {
		$this->PlantModel->bulkUpload();
	}

	public function getPlants() {
		$this->PlantModel->getPlantsForApp();
	}
}
