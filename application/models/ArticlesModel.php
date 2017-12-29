<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ArticlesModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	public function add(){
        $data = array();
        $success = false;
        $msg = checkParams($_POST);
        if (empty($msg)) {
            $target_path = './assets/articles/';
            if (!file_exists($target_path)) {
                mkdir($target_path, 0777, true);
            }
            if (isset($_FILES['image']['name'])) {
                $exp = explode(".", $_FILES['image']['name']);
                $extension = end($exp);
                $file_name = md5(''.time());
                $target_path = $target_path . '/'. $file_name .'.'. $extension ;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    $_POST['image_url'] = '/assets/articles/'. $file_name. '.'.$extension;
                    $this->db->insert("articles",$_POST);
                    if($this->db->insert_id()){
                        $success = true;
                        $msg = "Article added successfully.";
                    }else{
                        $msg = "Oops! error adding article.";
                    }
                } else {
                    $msg = "Error in uploading file, Try again.";
                }
            } else {
                $this->db->insert("articles",$_POST);
                if($this->db->insert_id()){
                    $success = true;
                    $msg = "Article added successfully.";
                }else{
                    $msg = "Oops! error adding article.";
                }
            }
        }
        echo json_encode(array("success" => $success,"msg" => $msg));
        exit();
	}

    public function get($id=0)
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
        if($id>0){
            $this->db->where('a.user_id'->$id);
        }
        if(!empty($search)){$this->db->like("a.description",$search);}
        $this->db->where("a.is_active",1);
        $this->db->select('id,description,image_url,url,type,a.is_active,a.user_id,a.created_at,CONCAT(u.first_name, " ",u.last_name) as user_fullname,u.profile_pic as user_profile_pic');
        $this->db->join('users as u','u.user_id = a.user_id');
        $output['data'] = $this->db->get('articles as a')->result();
        if(!empty($search)){$this->db->like("a.description",$search);}
        if($id>0){
            $this->db->where('a.user_id'->$id);
        }
        $output['recordsTotal']=$this->db->get('articles as a')->num_rows();
        $output['recordsFiltered']=$output['recordsTotal'];
        if (!empty($output['data'])) {
            $output['code'] = 1;
        }
        echo json_encode($output);
        exit;
    }

    public function upvote() {
        $success = false;
        $msg = '';
        $user_id = $_POST['user_id'];
        $article_id = $_POST['article_id'];
        $this->db->where(array('user_id' => $user_id, 'article_id' => $article_id));
        $res = $this->db->get('upvotes')->first_row();
        if($res){
            $count = $this->db->query('UPDATE upvotes SET up_down = CASE WHEN up_down = 0  THEN 1 WHEN up_down = 1 THEN 0 ELSE up_down END WHERE  up_down IS NOT NULL');
            if($count > 0){
                $success = true;
                $msg = "Article upvoted successfully.";
            } else{
                $msg = "Error upvoting article,Try again.";
            }
        } else {
            $this->db->insert('upvotes',$_POST);
            $success = true;
            $msg = "Article upvoted successfully.";
        }
        echo json_encode(array("success" => $success,"msg" => $msg));
        exit();
    }
}
