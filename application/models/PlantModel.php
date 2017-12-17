<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlantModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
        $this->load->model('ExcelModel');
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
                $exp = explode(".", $_FILES['image']['name']);
                $extension = end($exp);
                $file_name = md5(''.time());
                $target_path = $target_path . '/'. $file_name .'.'. $extension ;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    $_POST['image_url'] = '/assets/plants/'. $_POST['category_id'] . '/'. $file_name .'.'. $extension;
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
        $search = array('value' => '');
        if (isset($_POST['search'])) {
            $search = $_POST['search'];
        }
        if (isset($search['value'])) {
            $search = $search['value'];
        }
        $start = 0;
        if (isset($_POST['start'])) {
            $start = $_POST['start'];
        }
        $length = 10;
        if (isset($_POST['length'])) {
            $length = $_POST['length'];
        }
        $draw = 1;
        if (isset($_POST['draw'])) {
            $draw = $_POST['draw'];
        }

        $output = array("code" => 0,
            'draw' => $draw,
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'search' => $search
        );
        if(!empty($search)){$this->db->like("name",$search);}
        $this->db->select('t1.id,t1.name,description,qrcode,image_url,t2.name as category,t1.is_active,t2.id as categoryid');
        $this->db->join("plant_category as t2", "t2.id = t1.category_id");
        $output['data'] = $this->db->get('plant as t1')->result();
        if(!empty($search)){$this->db->like("name",$search);}
        $output['recordsTotal']=$this->db->get('plant')->num_rows();
        $output['recordsFiltered']=$output['recordsTotal'];
        if (!empty($output['data'])) {
            $output['code'] = 1;
        }
        echo json_encode($output);
        exit;
    }

    public function deletePlant($id)
    {
        $code = 0;
        $response = "";
        $this->db->where('id', $id)->set(array(
            'is_active' => 0
        ))->update("plant");
        $code = 1;
        $response = "Plant deleted successfully.";
        echo json_encode(array("code" => $code, "response" => $response));
        exit();
    }

    public function recoverPlant($id)
    {
        $code = 0;
        $response = "";
        $this->db->where('id', $id)->set(array(
            'is_active' => 1
        ))->update("plant");
        $code = 1;
        $response = "Plant recovered successfully.";
        echo json_encode(array("code" => $code, "response" => $response));
        exit();
    }

    public function updatePlant($id='')
    {
        $data = array();
        $success = false;
        $msg = checkParams($_POST);
        if (empty($msg)) {
            $target_path = './assets/plants/'. $_POST['category_id'];
            if (!file_exists($target_path)) {
                mkdir($target_path, 0777, true);
            }
            if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                $exp = explode(".", $_FILES['image']['name']);
                $extension = end($exp);
                $file_name = md5(''.time());
                $target_path = $target_path . '/'. $file_name .'.'. $extension ;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    $_POST['image_url'] = '/assets/plants/'. $_POST['category_id'] . '/'. $file_name .'.'. $extension;
                    $this->db->where('id', $id);
                    $count = $this->db->update("plant",$_POST);
                    if($count){
                        $success = true;
                        $msg = "Plant updated successfully.";
                    }else{
                        $msg = "Oops! error updaing plant.";
                    }
                } else {
                    $msg = "Error in uploading file, Try again.";
                }
            } else {
                $this->db->where('id', $id);
                $count = $this->db->update("plant",$_POST);
                if($count){
                    $success = true;
                    $msg = "Plant updated successfully.";
                }else{
                    $msg = "Oops! error updaing plant.";
                }
            }
        }
        echo json_encode(array("success" => $success,"msg" => $msg));
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

    public function bulkUpload()
    {
        $success = false;
        if($_FILES['excelFile']){
            $result = $this->ExcelModel->parseExcel($_FILES['excelFile'],0);
            if(count($result) > 1){
                $finalObj = [];
                for ($i=1; $i < count($result); $i++) { 
                    $obj = array(
                        'name' => $result[$i][0], 
                        'qrcode' => $result[$i][1],
                        'description' => $result[$i][2],
                        'category_id' => 1
                    );
                    $finalObj[] = $obj;
                }
                $count = $this->db->insert_batch('plant',$finalObj);
                if($count > 0){
                    $success = true;
                    $msg = count($finalObj)." records added successfully.";
                } else {
                    $msg = 'Error inserting records, Try again.';
                }
            } else {
                $msg = "No records found";
            }
        }else{
            $msg = 'File not found.';
        }
        echo json_encode(array("success" => $success,"msg" => $msg));
        exit();
    }
}
