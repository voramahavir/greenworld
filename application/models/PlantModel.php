<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlantModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function add(){
        $data = array();
        $success = false;
        $msg = checkParams($_POST);
        if (empty($msg)) {
            $target_path = './assets/plants/'. $_POST['category_id'];
            if (!file_exists($target_path)) {
                mkdir($target_path, 0777, true);
            }
            if (isset($_FILES['image']['name'])) {
                $target_path = $target_path . '/'. md5(''.time()) . end((explode(".", $_FILES['image']['name'])));
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    $_POST['image_url'] = '/assets/plants/'. $_POST['category_id'] . '/'. md5(''.time()) . end((explode(".", $_FILES['image']['name'])));
                    $this->db->insert("plant",$_POST);
                    if($this->db->insert_id()){
                        $success = true;
                        $msg = "Plant added successfully.";
                    }else{
                        $msg = "Oops! error adding plant.";
                    }
                } else {
                    $msg = "Error in uploading file, Try again.";
                }
            } else {
                $msg = "File missing.";
            }
        }
        echo json_encode(array("success" => $success,"msg" => $msg));
        exit();
	}

    public function getPlants()
    {
        $this->db->select('t1.name,nick_name,description,qrcode,image_url,t2.name as category');
        $this->db->join("plant_category as t2", "t2.id = t1.category_id");
        $data = $this->db->get('plant as t1')->result_array();
        echo json_encode($data);
        exit();
    }

    public function addUserPlant(){
        $data = array();
        $success = false;
        $msg = checkParams($_POST);
        if (empty($msg)) {
            $q = $this->db->where(
                'user_id', $_POST['user_id']
            )->get("user_plant");
            $num_rows = $q->num_rows();
            if($num_rows>=5){
                $msg = "One user can add only 5 plants.";
            }else{
                $q = $this->db->where(array('user_id' => $_POST['user_id'], 'plant_id' => $_POST['plant_id'])
                )->get("user_plant");
                $num_rows = $q->num_rows();
                if($num_rows<=0){
                    $this->db->insert("user_plant",$_POST);
                    if($this->db->insert_id()){
                        $success = true;
                        $msg = "Plant added successfully.";
                    }else{
                        $msg = "Oops! error adding plant.";
                    }
                } else {
                    $msg = "Plant is alredy added for this user.";
                }
            }
        }
        echo json_encode(array("success" => $success,"msg" => $msg));
        exit();
    }
}
