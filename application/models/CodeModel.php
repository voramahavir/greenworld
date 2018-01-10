<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CodeModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
        $this->load->model('ExcelModel');
	}
	public function add(){
        $data = array();
        $success = false;
        $msg = checkParams($_POST,'code,type,discount,reusability'); 
        if(empty($msg)){
            $_POST = getSetData($_POST,'code,type,discount,reusability');
            $this->db->insert("codes",$_POST);
            if($this->db->insert_id()){
                $success = true;
                $msg = "Code added successfully.";
            }else{
                $msg = "Oops! error adding code.";
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
        if(!empty($search)){$this->db->like("code",$search);}
        $output['data'] = $this->db->select('*')->get('codes')->result();
        if(!empty($search)){$this->db->like("code",$search);}
        $output['recordsTotal']=$this->db->get('codes')->num_rows();
        $output['recordsFiltered']=$output['recordsTotal'];
        if (!empty($output['data'])) {
            $output['code'] = 1;
        }
        echo json_encode($output);
        exit;
    }

    public function delete($id)
    {
        $success = false;
        $msg = "";
        $count = $this->db->where('id', $id)->set(array(
            'is_active' => 0
        ))->update("codes");
        if($count > 0){
            $success = true;
            $msg = "Code deleted successfully.";
        } else{
            $msg = "Error deleting code,Try again.";
        }
        echo json_encode(array("success" => $success, "msg" => $msg));
        exit();
    }

    public function recover($id)
    {
        $success = false;
        $msg = "";
        $count = $this->db->where('id', $id)->set(array(
            'is_active' => 1
        ))->update("codes");
        if($count > 0){
            $success = true;
            $msg = "Code recovered successfully.";
        } else{
            $msg = "Error recovering code,Try again.";
        }
        echo json_encode(array("success" => $success, "msg" => $msg));
        exit();
    }

    public function update($id='')
    {
        $data = array();
        $success = false;
        $msg = checkParams($_POST,'code,type,discount,reusability');
        if (empty($msg)) {
            $msg = checkParams($_POST,'code,type,discount,reusability'); 
            $this->db->where('id', $id);
            $count = $this->db->update("codes",$_POST);
            if($count){
                $success = true;
                $msg = "Code updated successfully.";
            }else{
                $msg = "Oops! error updaing code.";
            }
        }
        echo json_encode(array("success" => $success,"msg" => $msg));
        exit();
    }

    public function checkCode()
    {
        $data = array();
        $success = false;
        $msg = checkParams($_POST);
        $reward_points = 0;
        $type = 0;
        if (empty($msg)) {
            $this->db->where('code', $_POST['code']);
            $this->db->where('is_active', 1);
            $codeDetails = $this->db->select('id,type,discount,reusability')->get('codes')->result();
            if(count($codeDetails) > 0){
                $userDetails = $this->db->select('reward_points')->where('user_id',$_POST['user_id'])->get('users')->first_row();
                $type = $codeDetails[0]->type;
                if($codeDetails[0]->type == 1 ){
                    $reward_points = $userDetails->reward_points - $codeDetails[0]->discount;
                } else {
                    $reward_points = ($userDetails->reward_points * $codeDetails[0]->discount) / 100;
                }
                if($codeDetails[0]->reusability == 1){
                    $this->db->where('code_id', $codeDetails[0]->id);
                    $this->db->where('user_id', $_POST['user_id']);
                    $res = $this->db->select('*')->get('user_code_link')->result();
                    if(count($res) <= 0){
                        $data = $codeDetails[0];
                        $this->db->insert('user_code_link',array('user_id' => $_POST['user_id'], 'code_id' => $codeDetails[0]->id));
                        if($this->db->insert_id()){
                            $success = true;
                            $msg = "Code gets used successfully.";
                        } else{
                            $msg = "Error applying code, Try again.";
                        }
                    } else {
                        $msg = "User has already used this code.";
                    }
                } else {
                    $data = $codeDetails[0];
                    $this->db->insert('user_code_link',array('user_id' => $_POST['user_id'], 'code_id' => $codeDetails[0]->id));
                    if($this->db->insert_id()){
                        $success = true;
                        $msg = "Code gets used successfully.";
                    } else{
                        $msg = "Error applying code, Try again.";
                    }
                }
            } else {
                $msg = "Code does not exist.";
            }
        }
        if($type != 3 && $msg === "Code gets used successfully."){
             $this->db->query('update users set reward_points = '.$reward_points.' where user_id = '.$_POST['user_id']);
             $data->reward_points = $reward_points;
        }
        echo json_encode(array("success" => $success,"msg" => $msg,"data" => $data));
        exit();
    }
}
