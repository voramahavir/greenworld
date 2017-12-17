<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlantCategoryModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function add(){
        $data = array();
        $success = false;
        $msg = checkParams($_POST);
        if (empty($msg)) {
            $this->db->insert("plant_category",$_POST);
            if($this->db->insert_id()){
                $success = true;
                $msg = "Plant Category added successfully.";
            }else{
                $msg = "Oops! error adding Plant Category.";
            }
        }
        echo json_encode(array("success" => $success,"msg" => $msg));
        exit();
	}

    public function get()
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
        $output['data'] = $this->db->select('id,name,is_active')->get('plant_category')->result();
        if(!empty($search)){$this->db->like("name",$search);}
        $output['recordsTotal']=$this->db->get('plant_category')->num_rows();
        $output['recordsFiltered']=$output['recordsTotal'];
        if (!empty($output['data'])) {
            $output['code'] = 1;
        }
        echo json_encode($output);
        exit;
    }

    public function deletePlantCategory($id)
    {
        $code = 0;
        $response = "";
        $this->db->where('id', $id)->set(array(
            'is_active' => 0
        ))->update("plant_category");
        $code = 1;
        $response = "Plant Category deleted successfully.";
        echo json_encode(array("code" => $code, "response" => $response));
        exit();
    }

    public function recoverPlantCategory($id)
    {
        $code = 0;
        $response = "";
        $this->db->where('id', $id)->set(array(
            'is_active' => 1
        ))->update("plant_category");
        $code = 1;
        $response = "Plant Category recovered successfully.";
        echo json_encode(array("code" => $code, "response" => $response));
        exit();
    }

    public function updatePlantCategory($id='')
    {
        $data = array();
        $success = false;
        $msg = checkParams($_POST);
        if (empty($msg)) {
            $this->db->where('id', $id);
            $count = $this->db->update("plant_category",$_POST);
            if($count){
                $success = true;
                $msg = "Plant Category updated successfully.";
            }else{
                $msg = "Oops! error updaing Plant Category.";
            }
        }
        echo json_encode(array("success" => $success,"msg" => $msg));
        exit();
    }
}