<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlantController extends CI_Controller {

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
		$this->load->model('PlantModel');
		$this->PlantModel->add();
	}

	public function get() {
		$this->load->model('PlantModel');
		$this->PlantModel->getPlants();
	}

	public function addUserPlant() {
		$this->load->model('PlantModel');
		$this->PlantModel->addUserPlant();
	}
}
