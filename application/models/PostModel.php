<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PostModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function add(){
        $data = array();
        $success = false;
        $msg = checkParams($_POST);
        if (empty($msg)) {
            $target_path = './assets/posts/';
            if (!file_exists($target_path)) {
                mkdir($target_path, 0777, true);
            }
            if (isset($_FILES['image']['name'])) {
                $target_path = $target_path . '/'. md5(''.time()) . end((explode(".", $_FILES['image']['name'])));
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    $_POST['image_url'] = '/assets/posts/'. md5(''.time()) . end((explode(".", $_FILES['image']['name'])));
                } else {
                    $msg = "Error in uploading file, Try again.";
                }
            }
            if(empty($msg)){
                $this->db->insert("posts",$_POST);
                if($this->db->insert_id()){
                    $success = true;
                    $msg = "Post added successfully.";
                }else{
                    $msg = "Oops! error adding post.";
                }
            }
        }
        echo json_encode(array("success" => $success,"msg" => $msg));
        exit();
	}
}
