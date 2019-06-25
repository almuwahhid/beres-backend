<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/BaseAdminController.php');

class Survey extends BaseAdminController {
	public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
				$this->load->model('survey_model');
		    $this->load->model('main_model');
		    $this->load->model('users_model');
	}

	public function index() {
    $page = $this->input->get('p');
		$booking = $this->users_model->get($page);
		$jumlah = $this->users_model->totalUser();
    $asd['user'] = $booking;
    $asd['jumlah'] = $jumlah;
    $asd['page'] = $page;
    parent::getView('m_user/list_user', 'survey', $asd);
	}

	public function detail($id_user){
    $data = array();
		$data['survey'] = $this->survey_model->laporanSurveySaya($id_user);
    $data['id_user'] = $id_user;
		parent::getView('m_survey/list_survey', 'survey', $data);
	}

	public function pertanyaan($id_survey){
    $data = array();
		$id_user = $this->input->get('id_user');
		$data['detail'] = $this->survey_model->getPertanyaanByIdSurvey($id_survey);
		$data['survey'] = $this->survey_model->getSurveyById($id_survey);
    $data['id_user'] = $id_user;
		parent::getView('m_survey/detail_survey', 'survey', $data);
	}

	public function konfirmasi(){
		$id_booking = $this->input->get('id');
		$status = $this->input->get('status');

		if($status == '1'){
			$params = array('confirmed' => 'Y');
		} else {
			$params = array('deleted_at' => date('Y-m-d H:i:s'));
		}

		$insert = $this->main_model->update($params, 'booking', ['id_booking' => $id_booking]);
		if ($insert) {
			$this->session->set_flashdata('alert', array('message' => 'Berhasil menghapus foto','class' => 'success'));
			redirect('booking');
		} else {
			$this->session->set_flashdata('alert', array('message' => 'Gagal menghapus foto','class' => 'danger'));
			redirect('booking');
		}
	}


}
