<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ArticlesModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
        $this->load->model('ExcelModel');
	}

	public function add(){
        $data = array();
        $success = false;
        $msg = checkParams($_POST,"title,description");
        if ($msg === '') {
            $_POST = getSetData($_POST,'title,description,image_url,video_url,image_type,video_type,url,source,designation');
            $target_path = './assets/articles/';
            if (!file_exists($target_path)) {
                mkdir($target_path, 0777, true);
            }
            if (count($_FILES) > 0) {
                $count = 0;
                if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                    $exp = explode(".", $_FILES['image']['name']);
                    $extension = end($exp);
                    $file_name = md5(''.time());
                    $target_path = $target_path . '/'. $file_name .'.'. $extension ;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                        $_POST['image_url'] = '/assets/articles/images/'. $file_name. '.'.$extension;
                    } else {
                        $count = 1;
                        $msg = "Error in uploading Image, Try again.";
                    }
                }
                if(isset($_FILES['video']['name']) && $_FILES['video']['name'] != '') {
                    $exp = explode(".", $_FILES['video']['name']);
                    $extension = end($exp);
                    $file_name = md5(''.time());
                    $target_path = $target_path . '/'. $file_name .'.'. $extension ;
                    if (move_uploaded_file($_FILES['video']['tmp_name'], $target_path)) {
                        $_POST['video_url'] = '/assets/articles/videos/'. $file_name. '.'.$extension;
                    } else {
                        $count = 1;
                        $msg = "Error in uploading Video, Try again.";
                    }
                }
                if($count === 0){
                    $this->db->insert("articles", $_POST);
                    if($this->db->insert_id()) {
                        $success = true;
                        $msg = "Article added successfully.";
                    }else{
                        $msg = "Oops! error adding article.";
                    }
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
        } else {
            $msg = 'Invalid Content';
        }
        echo json_encode(array("success" => $success,"msg" => $msg));
        exit;
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
            $this->db->where("a.is_active",1);
        }
        if(!empty($search)){$this->db->like("a.description",$search);}
        $this->db->select('id,description,image_url,url,title,source,submitted_by,designation,video_url,image_type,video_type,a.is_active,a.user_id,a.created_at,CONCAT(u.first_name, " ",u.last_name) as user_fullname,u.profile_pic as user_profile_pic');
        $this->db->join('users as u','u.user_id = a.user_id', 'left');
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

    public function update($id=''){
        $data = array();
        $success = false;
        $msg = checkParams($_POST,"title,description");
        if ($msg === '') {
            $_POST = getSetData($_POST,'title,description,image_url,video_url,image_type,video_type,url,source,designation');
            $target_path = './assets/articles/';
            if (!file_exists($target_path)) {
                mkdir($target_path, 0777, true);
            }
            if (count($_FILES) > 0) {
                $count = 0;
                if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                    $exp = explode(".", $_FILES['image']['name']);
                    $extension = end($exp);
                    $file_name = md5(''.time());
                    $target_path = $target_path . '/'. $file_name .'.'. $extension ;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                        $_POST['image_url'] = '/assets/articles/images/'. $file_name. '.'.$extension;
                    } else {
                        $count = 1;
                        $msg = "Error in uploading Image, Try again.";
                    }
                }
                if(isset($_FILES['video']['name']) && $_FILES['video']['name'] != '') {
                    $exp = explode(".", $_FILES['video']['name']);
                    $extension = end($exp);
                    $file_name = md5(''.time());
                    $target_path = $target_path . '/'. $file_name .'.'. $extension ;
                    if (move_uploaded_file($_FILES['video']['tmp_name'], $target_path)) {
                        $_POST['video_url'] = '/assets/articles/videos/'. $file_name. '.'.$extension;
                    } else {
                        $count = 1;
                        $msg = "Error in uploading Video, Try again.";
                    }
                }
                if($count === 0){
                    $this->db->where('id',$id);
                    $count = $this->db->update("articles", $_POST);
                    if($count > 0) {
                        $success = true;
                        $msg = "Article updated successfully.";
                    }else{
                        $msg = "Oops! error updating article.";
                    }
                }
            } else {
                $this->db->where('id',$id);
                $count = $this->db->update("articles",$_POST);
                if($count > 0){
                    $success = true;
                    $msg = "Article updated successfully.";
                }else{
                    $msg = "Oops! error updating article.";
                }
            }
        } else {
            $msg = 'Invalid Content';
        }
        echo json_encode(array("success" => $success,"msg" => $msg));
        exit;
    }

    public function delete($id)
    {
        $success = false;
        $msg = "";
        $count = $this->db->where('id', $id)->set(array(
            'is_active' => 0
        ))->update("articles");
        if($count > 0){
            $success = true;
            $msg = "Article deleted successfully.";
        } else{
            $msg = "Error deleting article,Try again.";
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
        ))->update("articles");
        if($count > 0){
            $success = true;
            $msg = "Article recovered successfully.";
        } else{
            $msg = "Error recovering article,Try again.";
        }
        echo json_encode(array("success" => $success, "msg" => $msg));
        exit();
    }

    public function bulkUpload()
    {
        $success = false;
        if($_FILES['excelFile']){
            $result = $this->ExcelModel->parseExcel($_FILES['excelFile'],0);
            if(count($result) > 1){
                $finalObj = [];
                for ($i=1; $i < count($result); $i++) { 
                    $obj = array(
                        'title' => isset($result[$i][0]) ? $result[$i][0] : '', 
                        'description' => isset($result[$i][1]) ? $result[$i][1] : '',
                        'image_url' => isset($result[$i][2]) ? $result[$i][2] : '',
                        'video_url' => isset($result[$i][3]) ? $result[$i][3] : '',
                        'url' => isset($result[$i][4]) ? $result[$i][4] : '', 
                        'source' => isset($result[$i][5]) ? $result[$i][5] : '',
                        'submitted_by' => isset($result[$i][6]) ? $result[$i][6] : '',
                        'designation' => isset($result[$i][7]) ? $result[$i][7] : '',
                    );
                    $finalObj[] = $obj;
                }
                $count = $this->db->insert_batch('articles',$finalObj);
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