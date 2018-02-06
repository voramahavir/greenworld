<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BillsModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
    }

	public function add(){
        $data = array();
        $success = false;
        $msg = checkParams($_POST);
        if (empty($msg)) {
            $this->db->where('user_id',$_POST['user_id']);
            $res = $this->db->get('users')->result();
            if(count($res) > 0){
                $_POST = getSetData($_POST,'user_id,amount,nurname');
                // $this->db->where('user_id',$_POST['user_id']);
                // $res = $this->db->get('bills')->result();
                // if(count($res) > 0){
                //     $msg = "User has already requested for it.";
                // } else{

                $target_path = './assets/bills/';
                if (!file_exists($target_path)) {
                    mkdir($target_path, 0777, true);
                }
                if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                    $exp = explode(".", $_FILES['image']['name']);
                    $extension = end($exp);
                    $file_name = md5(''.time());
                    $target_path = $target_path . '/'. $file_name .'.'. $extension ;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                        $_POST['image_url'] = '/assets/bills/'. $file_name. '.'.$extension;
                        $this->db->insert("bills",$_POST);
                        if($this->db->insert_id()){
                            $success = true;
                            $msg = "Points will be issued in 48 hours.";
                        }else{
                            $msg = "Oops! error adding bill.";
                        }
                    } else {
                        $msg = "Error in uploading file, Try again.";
                    }
                } else {
                    $msg = "File is missing.";
                }
                // }
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
        $reward_points = 0;
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
        if($id != ''){
            $res = $this->db->select('reward_points')->where('user_id',$id)->get('users')->first_row();
            if(isset($res->reward_points)){
                $reward_points = $res->reward_points;
            }
            $this->db->where(array('b.user_id' => $id, 'is_confirm' => 2));
        	$this->db->limit($length,$start);
        }
        if(!empty($search)){$this->db->like("amount",$search);}
        $this->db->select('id,image_url,amount,nurname,is_confirm,CONCAT(u.first_name, " ",u.last_name) as user_fullname');
        $this->db->join('users as u','u.user_id = b.user_id');
        $output['data'] = $this->db->get('bills as b')->result();
        if($id != ''){$this->db->where(array('user_id' => $id, 'is_confirm' => 2));}
        if(!empty($search)){$this->db->like("amount",$search);}
        $output['recordsTotal']=$this->db->get('bills')->num_rows();
        $output['recordsFiltered']=$output['recordsTotal'];
        $output['reward_points'] = $reward_points;
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
        if($count > 0) {
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

    public function getMessages()
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
        $this->db->select('*');
        $output['data'] = $this->db->get('cancel_reasons')->result();
        $output['recordsTotal']=$this->db->get('cancel_reasons')->num_rows();
        $output['recordsFiltered']=$output['recordsTotal'];
        if (!empty($output['data'])) {
            $output['code'] = 1;
        }
        echo json_encode($output);
        exit;
    }

    function sendMessage($id=''){
        $success = false;
        $msg = '';
        $billData = $this->db->select('*')->where('id',$id)->get('bills')->first_row();
        if($billData->id){
            $userData = $this->db->select('*')->where('user_id',$billData->user_id)->get('users')->first_row();
            if($userData->phone_no){
                $this->send_sms($_POST['message'],$userData->phone_no);
                $data = array('bill_id'=>$id,'message'=>$_POST['message']);
                $count = $this->db->insert('user_reasons_link',$data);
                $success = true;
                $msg = "Message sent successfully.";
            } else {
                $msg = "User does not exist.";
            }
        } else {
            $msg = "Bill data does not exist.";
        }
        echo json_encode(array("success" => $success, "msg" => $msg));
        exit();
    }

    public function send_sms($message='', $mobileNumber)
    {        
        //Your authentication key
        $authKey = "190629AOn1V8cU4Y55a47ef98";
        //Sender ID,While using route4 sender id should be 6 characters long.
        $senderId = "REGREE";
        //Your message to send, Add URL encoding here.
        $message = urlencode($message);
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://api.msg91.com/api/v2/sendsms",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "{ \"sender\": \"REGREN\", \"route\": \"4\", \"country\": \"91\", \"sms\": [ { \"message\": \"$message\", \"to\": [ \"$mobileNumber\" ] } ] }",
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_HTTPHEADER => array(
            "authkey: " . $authKey,
            "content-type: application/json"
          ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
          return "cURL Error #:" . $err;
        } else {
          return $response;
        }
        return true;
    }
}
