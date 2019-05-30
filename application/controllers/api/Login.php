<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->helper('url');

    $this->load->model('users_model');
    $this->load->model('main_model');
  }

  public function index(){
    $data = json_decode($this->input->post('data'));

    if ($this->users_model->check_login($data->email, $data->password)) {
      $user = $this->users_model->get_user($data->email);
      if($user->aktif == 'N'){
        $data = array(
                    'status'           => "204",
                    'message'           => "Akun belum dikonfirmasi oleh Admin",
                    'data'          => new stdClass());
      } else {
        $data = array(
                    'status'           => "200",
                    'message'           => "Login berhasil",
                    'data'          => $user);
      }
    } else {
      $data = array(
                  'status'           => "404",
                  'message'           => "Username atau password salah",
                  'data'          => new stdClass());
    }

    echo json_encode($data);
  }
}
