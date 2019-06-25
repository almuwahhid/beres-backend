<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/api/Base_api.php');

class Biodata extends Base_api {
  public function __construct() {
    parent::__construct();
    $this->load->helper('url');

    $this->load->model('users_model');
    $this->load->model('main_model');
  }

  public function index(){
    $result = array();
    $result["data"] = array();
    $data = json_decode($this->input->post('data'));
    $update = $this->main_model->update($data, 'user', ['id_user' => $data->id_user]);

    if($update){
      $result["result"] = "success";
      $result["data"] = $this->users_model->get_user($data->email);

    } else {
      $result["result"] = "failed";
    }

    echo json_encode($result);
  }
}
