<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NurseryModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
        $this->load->model('ExcelModel');
	}
	public function add(){
        $plants = !empty($_GET['plant']) ? explode(',', $_GET['plant']) : '';
        $data = array();
        $success = false;
        $msg = checkParams($_POST,'name,contact_no');
        unset($_POST['plant']);
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
                } else {
                    $msg = "Error in uploading file, Try again.";
                }
            } 
            if(empty($msg)){
                $this->db->insert("nursery",$_POST);
                if($this->db->insert_id()){
                    if($plants != ''){
                        $data = array();
                        for ($i=0; $i < count($plants); $i++) { 
                            $arr = array('plant_id' => $plants[$i], 'nursery_id' => $this->db->insert_id());
                            array_push($data, $arr);
                        }
                        $this->db->insert_batch("plant_nursery_link",$data);
                    }
                    $success = true;
                    $msg = "Nursery added successfully.";
                }else{
                    $msg = "Oops! error adding nursery.";
                }
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
        $output['data'] = $this->db->query("SELECT A.id,name,contact_no,address,image_url,A.is_active,latitude,longitude,group_concat(`plant_id` separator ',') as plants from nursery as A left join plant_nursery_link as B on A.id = B.nursery_id and B.is_active = 1 GROUP BY A.id")->result();
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
        $success = false;
        $msg = "";
        $count = $this->db->where('id', $id)->set(array(
            'is_active' => 0
        ))->update("nursery");
        if($count > 0){
            $success = true;
            $msg = "Nursery deleted successfully.";
        } else{
            $msg = "Error deleting nursery,Try again.";
        }
        echo json_encode(array("success" => $success, "msg" => $msg));
        exit();
    }

    public function recoverNursery($id)
    {
        $success = false;
        $msg = "";
        $count = $this->db->where('id', $id)->set(array(
            'is_active' => 1
        ))->update("nursery");
        if($count > 0){
            $success = true;
            $msg = "Nursery recovered successfully.";
        } else{
            $msg = "Error recovering nursery,Try again.";
        }
        echo json_encode(array("success" => $success, "msg" => $msg));
        exit();
    }

    public function updateNursery($id='')
    {
        $newplants = !empty($_GET['new']) ? explode(',', $_GET['new']) : '';
        $oldplants = !empty($_GET['old']) ? explode(',', $_GET['old']) : '';
        unset($_POST['plant']);
        $data = array();
        $success = false;
        $msg = checkParams($_POST,'name,contact_no');
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
            if($success){
                if(!empty($newplants)){
                    $data = array();
                    for ($i=0; $i < count($newplants); $i++) { 
                        $arr = array('plant_id' => $newplants[$i], 'nursery_id' => $id);
                        array_push($data, $arr);
                    }
                    $this->db->insert_batch("plant_nursery_link",$data);
                }
                if(!empty($oldplants)){
                    $data = array();
                    for ($i=0; $i < count($oldplants); $i++) { 
                        $where = array('plant_id' => $oldplants[$i], 'nursery_id' => $id);
                        $this->db->where($where)->set(array('is_active' => 0))->update("plant_nursery_link");
                    }
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

    public function nearByNursery() {
        $success = false;
        $msg = checkParams($_POST);
        $res = array();
        if(empty($msg)){
            $lat = $_POST['latitude'];
            $long = $_POST['longitude'];
            $res = $this->db->query("SELECT * , (3956 * 2 * ASIN(SQRT( POWER(SIN(( '".$lat."' - latitude) *  pi()/180 / 2), 2) +COS( '".$lat."' * pi()/180) * COS(latitude * pi()/180) * POWER(SIN(( '".$long."' - longitude) * pi()/180 / 2), 2) ))) as distance from nursery having  distance <= 10 order by distance")->result();
            $success = true;
        }
        echo json_encode(array("success" => $success,"msg" => $msg,"data" => $res));
        exit();
    }
}
