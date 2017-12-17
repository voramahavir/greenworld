<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NurseryModel extends CI_Model {

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
            $target_path = './assets/nursery/';
            if (!file_exists($target_path)) {
                mkdir($target_path, 0777, true);
            }
            if (isset($_FILES['image']['name'])) {
                $exp = explode(".", $_FILES['image']['name']);
                $extension = end($exp);
                $file_name = md5(''.time());
                $target_path = $target_path . '/'. $file_name .'.'. $extension ;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    $_POST['image_url'] = '/assets/nursery/'. $file_name. '.'.$extension;
                    $this->db->insert("nursery",$_POST);
                    if($this->db->insert_id()){
                        $success = true;
                        $msg = "Nursery added successfully.";
                    }else{
                        $msg = "Oops! error adding nursery.";
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
        $output['data'] = $this->db->select('id,name,contact_no,address,image_url,is_active,latitude,longitude')->get('nursery')->result();
        if(!empty($search)){$this->db->like("name",$search);}
        $output['recordsTotal']=$this->db->get('nursery')->num_rows();
        $output['recordsFiltered']=$output['recordsTotal'];
        if (!empty($output['data'])) {
            $output['code'] = 1;
        }
        echo json_encode($output);
        exit;
    }

    public function deleteNursery($id)
    {
        $code = 0;
        $response = "";
        $this->db->where('id', $id)->set(array(
            'is_active' => 0
        ))->update("nursery");
        $code = 1;
        $response = "Nursery deleted successfully.";
        echo json_encode(array("code" => $code, "response" => $response));
        exit();
    }

    public function recoverNursery($id)
    {
        $code = 0;
        $response = "";
        $this->db->where('id', $id)->set(array(
            'is_active' => 1
        ))->update("nursery");
        $code = 1;
        $response = "Nursery recovered successfully.";
        echo json_encode(array("code" => $code, "response" => $response));
        exit();
    }

    public function updateNursery($id='')
    {
        $data = array();
        $success = false;
        $msg = checkParams($_POST);
        if (empty($msg)) {
            $target_path = './assets/nursery/';
            if (!file_exists($target_path)) {
                mkdir($target_path, 0777, true);
            }
            if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                $exp = explode(".", $_FILES['image']['name']);
                $extension = end($exp);
                $file_name = md5(''.time());
                $target_path = $target_path . '/'. $file_name .'.'. $extension ;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    $_POST['image_url'] = '/assets/nursery/'. $file_name. '.'.$extension;
                    $this->db->where('id', $id);
                    $count = $this->db->update("nursery",$_POST);
                    if($count){
                        $success = true;
                        $msg = "Nursery updated successfully.";
                    }else{
                        $msg = "Oops! error updaing nursery.";
                    }
                } else {
                    $msg = "Error in uploading file, Try again.";
                }
            } else {
                $this->db->where('id', $id);
                $count = $this->db->update("nursery",$_POST);
                if($count){
                    $success = true;
                    $msg = "Nursery updated successfully.";
                }else{
                    $msg = "Oops! error updaing nursery.";
                }
            }
        }
        echo json_encode(array("success" => $success,"msg" => $msg));
        exit();
    }

    public function importBulkNursery()
    {
        $success = false;
        if($_FILES['excelFile']){
            $result = $this->ExcelModel->parseExcel($_FILES['excelFile'],0);
            if(count($result) > 1){
                $finalObj = [];
                for ($i=1; $i < count($result); $i++) { 
                    $obj = array(
                        'name' => $result[$i][0], 
                        'contact_no' => $result[$i][1],
                        'address' => $result[$i][2],
                        'latitude' => $result[$i][3],
                        'longitude' => $result[$i][4]
                    );
                    $finalObj[] = $obj;
                }
                $count = $this->db->insert_batch('nursery',$finalObj);
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
