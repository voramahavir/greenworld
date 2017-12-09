<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GroupModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function create(){
        $data = array();
        $success = false;
        $msg = checkParams($_POST);
        if (empty($msg)) {
            $users = explode(',', $_POST['users']);
            if(count($users) > 4){
                $msg = "Only 5 members are allowed in a group.";
            } else{
                $this->db->insert("family_group", array('name' => $_POST['name']));
                if($this->db->insert_id()){
                    $id = $this->db->insert_id();
                    $data = [];
                    for ($i=0; $i < count($users); $i++) { 
                        $data[] = array('group_id' => $id, 'user_id' => $users[$i], 'member_type' => 0);
                    }
                    $data[] = array('group_id' => $id, 'user_id' => $_POST['user_id'], 'member_type' => 1);
                    $this->db->insert_batch("group_members",$data);
                    $success = true;
                    $msg = "Group created successfully.";
                }else{
                    $msg = "Oops! error creating group.";
                }
            }
        }
        echo json_encode(array("success" => $success,"msg" => $msg));
        exit();
	}
}
