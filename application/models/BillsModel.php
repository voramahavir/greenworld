<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BillsModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function add(){
        custom_log('addBill',json_encode($_POST));
        $data = array();
        $success = false;
        $msg = checkParams($_POST);
        if (empty($msg)) {
            $this->db->where('user_id',$_POST['user_id']);
            $res = $this->db->get('users')->result();
            if(count($res) > 0){
                $_POST = getSetData($_POST,'user_id,amount,nurname');
                $this->db->where('user_id',$_POST['user_id']);
                $res = $this->db->get('bills')->result();
                if(count($res) > 0){
                    $msg = "User has already requested for it.";
                } else{

                    $target_path = './assets/bills/';
                    if (!file_exists($target_path)) {
                        mkdir($target_path, 0777, true);
                    }
                    if (isset($_FILES['image']['name']) $_FILES['image']['name'] != '') {
                        $exp = explode(".", $_FILES['image']['name']);
                        $extension = end($exp);
                        $file_name = md5(''.time());
                        $target_path = $target_path . '/'. $file_name .'.'. $extension ;
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                            $_POST['image_url'] = '/assets/bills/'. $file_name. '.'.$extension;
                            $this->db->insert("bills",$_POST);
                            if($this->db->insert_id()){
                                $success = true;
                                $msg = "Bill added successfully.";
                            }else{
                                $msg = "Oops! error adding bill.";
                            }
                        } else {
                            $msg = "Error in uploading file, Try again.";
                        }
                    } else {
                        $msg = "File is missing.";
                    }
                }
            } else {
                $msg = "User does not exist.";
            }
        }
        echo json_encode(array("success" => $success,"msg" => $msg));
        exit();
	}

    public function get($id='')
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
        if($id != ''){$this->db->where(array('b.user_id' => $id, 'is_confirm' => 2));}
        if(!empty($search)){$this->db->like("amount",$search);}
        $this->db->select('id,image_url,amount,nurname,is_confirm,CONCAT(u.first_name, " ",u.last_name) as user_fullname');
        $this->db->join('users as u','u.user_id = b.user_id');
        $output['data'] = $this->db->get('bills as b')->result();
        if($id != ''){$this->db->where(array('user_id' => $id, 'is_confirm' => 2));}
        if(!empty($search)){$this->db->like("amount",$search);}
        $output['recordsTotal']=$this->db->get('bills')->num_rows();
        $output['recordsFiltered']=$output['recordsTotal'];
        if (!empty($output['data'])) {
            $output['code'] = 1;
        }
        echo json_encode($output);
        exit;
    }

    public function confirm($id)
    {
        $success = false;
        $msg = "";
        $value = $_POST['is_confirm'];
        $count = $this->db->where('id', $id)->set(array(
            'is_confirm' => $value,
            'nurname' => $_POST['nurname']
        ))->update("bills");
        if($count > 0){
            if($value == 2) {
                $this->db->where('id',$id);
                $res = $this->db->get('bills')->first_row();
                $this->db->query('update users set reward_points = reward_points + '.$res->amount.' where user_id = '.$res->user_id);
            }
            $success = 1;
            $msg = "Bill status updated successfully.";
        } else {
            $msg = "Error updating status, Try again.";
        }
        echo json_encode(array("success" => $success, "msg" => $msg));
        exit();
    }
}
