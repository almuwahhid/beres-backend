<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/BaseController.php');

class Lupapassword extends BaseController {
	public function __construct() {
        parent::__construct();
        $this->load->helper('url');
				$this->load->model('users_model');
		    $this->load->model('main_model');
	}

	public function index() {
    $page = $this->input->get('code');
		$asd = array();
    // $asd['kendaraan'] = $kendaraan;
    $asd['code'] = $page;
    parent::getView('m_lupapassword/lupapassword', 'kendaraan', $asd);
	}
}
