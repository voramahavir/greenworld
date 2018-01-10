<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NurseryBannerModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function add(){
        $data = array();
        $success = false;
        $target_path = './assets/nurserybanners/';
        if (!file_exists($target_path)) {
            mkdir($target_path, 0777, true);
        }
        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
            $exp = explode(".", $_FILES['image']['name']);
            $extension = end($exp);
            $file_name = md5(''.time());
            $target_path = $target_path . '/'. $file_name .'.'. $extension ;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                $_POST['image_url'] = '/assets/nurserybanners/'. $file_name. '.'.$extension;
                $this->db->insert("nursery_banner",$_POST);
                if($this->db->insert_id()){
                    $success = true;
                    $msg = "Banner added successfully.";
                }else{
                    $msg = "Oops! error adding banner.";
                }
            } else {
                $msg = "Error in uploading file, Try again.";
            }
        } else {
            $msg = "File is missing.";
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
            'search' => $search,
            'success' => true,
            'msg' => 'Data fetched successfully.'
        );
        $output['data'] = $this->db->select('id,image_url,is_active')->get('nursery_banner')->result();
        $output['recordsTotal']=$this->db->get('nursery_banner')->num_rows();
        $output['recordsFiltered']=$output['recordsTotal'];
        if (!empty($output['data'])) {
            $output['code'] = 1;
        }
        echo json_encode($output);
        exit;
    }

    public function deleteNurseryBanner($id)
    {
        $success = false;
        $msg = "";
        $count = $this->db->where('id', $id)->set(array(
            'is_active' => 0
        ))->update("nursery_banner");
        if($count > 0){
            $success = true;
            $msg = "Nursery Banner deleted successfully.";
        } else{
            $msg = "Error deleting Nursery Banner,Try again.";
        }
        echo json_encode(array("success" => $success, "msg" => $msg));
        exit();
    }

    public function recoverNurseryBanner($id)
    {
        $success = false;
        $msg = "";
        $count = $this->db->where('id', $id)->set(array(
            'is_active' => 1
        ))->update("nursery_banner");
        if($count > 0){
            $success = true;
            $msg = "Nursery Banner recovered successfully.";
        } else{
            $msg = "Error recovering Nursery Banner,Try again.";
        }
        echo json_encode(array("success" => $success, "msg" => $msg));
        exit();
    }

    public function updateNurseryBanner($id='')
    {
        $data = array();
        $success = false;
        $target_path = './assets/nurserybanners/';
        if (!file_exists($target_path)) {
            mkdir($target_path, 0777, true);
        }
        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
            $exp = explode(".", $_FILES['image']['name']);
            $extension = end($exp);
            $file_name = md5(''.time());
            $target_path = $target_path . '/'. $file_name .'.'. $extension ;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                $_POST['image_url'] = '/assets/nurserybanners/'. $file_name. '.'.$extension;
                $count = $this->db->update("nursery_banner",$_POST);
                if($count > 0){
                    $success = true;
                    $msg = "Banner updated successfully.";
                }else{
                    $msg = "Oops! error updating banner.";
                }
            } else {
                $msg = "Error in uploading file, Try again.";
            }
        } else {
            $msg = "File is missing.";
        }
        echo json_encode(array("success" => $success,"msg" => $msg));
        exit();
    }

    public function random()
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
        $output['data'] = $this->db->select('id,image_url')->where('is_active',1)->get('nursery_banner')->result();
        if(count($output['data']) > 4){
            $keys = array_rand($output['data'],4);
            $temp = array();
            for ($i=0; $i < count($output['data']); $i++) { 
                for ($j=0; $j < count($keys); $j++) { 
                    if($i === $keys[$j]){
                        array_push($temp, $output['data'][$i]);
                    }
                }
            }
            $output['data'] = $temp;
        }
        $output['recordsTotal']=$this->db->get('nursery_banner')->num_rows();
        $output['recordsFiltered']=$output['recordsTotal'];
        if (!empty($output['data'])) {
            $output['code'] = 1;
        }
        echo json_encode($output);
        exit;
    }
}
