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
            $_POST = getSetData($_POST,'name');
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
        $output['data'] = $this->db->select('id,name,is_active')->where('is_active',1)->get('plant_category')->result();
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
        $success = false;
        $msg = "";
        $count = $this->db->where('id', $id)->set(array(
            'is_active' => 0
        ))->update("plant_category");
        if($count > 0){
            $success = true;
            $msg = "Plant Category deleted successfully.";
        } else{
            $msg = "Error deleting Plant Category,Try again.";
        }
        echo json_encode(array("success" => $success, "msg" => $msg));
        exit();
    }

    public function recoverPlantCategory($id)
    {
        $success = false;
        $msg = "";
        $count = $this->db->where('id', $id)->set(array(
            'is_active' => 1
        ))->update("plant_category");
        if($count > 0){
            $success = true;
            $msg = "Plant Category recovered successfully.";
        } else{
            $msg = "Error recovering Plant Category,Try again.";
        }
        echo json_encode(array("success" => $success, "msg" => $msg));
        exit();
    }

    public function updatePlantCategory($id='')
    {
        $data = array();
        $success = false;
        $msg = checkParams($_POST);
        if (empty($msg)) {
            $_POST = getSetData($_POST,'name');
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
