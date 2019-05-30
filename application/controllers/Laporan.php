<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'controllers/BaseController.php');

class Laporan extends BaseController {
	public function __construct() {
        parent::__construct();
        $this->load->helper('url');
				$this->load->model('laporan_model');

				$this->load->library('session');
		    $this->load->model('main_model');
        $this->load->library('pdfgenerator');

	}

	public function index() {
		// $model = $this->laporan_model->yearList();
		// foreach ($model as $k => $booking) {
		// 	$model2 = $this->laporan_model->monthinYearlist($booking->month);
		// 	foreach ($model2 as $y => $booking2) {
		// 		echo $booking2->month."\n";
		// 	}
		// }

		$model = $this->laporan_model->yearList();
		parent::getView('m_laporan/laporan_tahunan', 'laporan', $model);
	}

	public function detail_laporan_tahunan(){
		$year = $this->input->get('tahun');
		$model = $this->laporan_model->monthinYearlist($year);
		$result = array();
		$result['tahun'] = $year;
		$result['tahunan'] = array();
		foreach ($model as $k => $bulan) :
			$datas = $this->laporan_model->listLaporan($year, $bulan->bulan);
			$datak = array();
			$datak['bulan'] = $bulan;
			$datak['datas'] = $datas;
			array_push($result['tahunan'], $datak);

		endforeach;

		$html = $this->load->view('m_laporan/detiltahunan', ['data' => $result], true);
    $filename = 'report_'.time();
    $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
		// parent::getView('m_laporan/detiltahunan', 'laporan', $result);
	}

	public function detail_laporan_bulanan(){
		$year = $this->input->get('tahun');
		$bulan = $this->input->get('bulan');
		$datas = $this->laporan_model->listLaporan($year, $bulan);

		$result = array();
		$result['tahun'] = $year;
		$result['bulan'] = $this->laporan_model->getmonth($bulan);
		$result['datas'] = $datas;

		$html = $this->load->view('m_laporan/detailbulanan', ['data' => $result], true);
    $filename = 'report_'.time();
    $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
	}

	public function bulanan(){
		$result = array();
		$model = $this->laporan_model->yearList();
		foreach ($model as $k => $tahun) :
			$datas = $this->laporan_model->monthlist($tahun->tahun);
			$datak = array();
			$datak['tahun'] = $tahun->tahun;
			$datak['datas'] = $datas;
			array_push($result, $datak);
		endforeach;
		parent::getView('m_laporan/laporan_bulanan', 'laporan', $result);
	}

	public function sample() {
		$model = $this->laporan_model->listLaporan('2019');
		foreach ($model as $k => $booking) {
			echo $booking->nama_lengkap."\n";
		}
	}

	public function detail($id){
		$data['users']=array(
			array('firstname'=>'I am','lastname'=>'Programmer','email'=>'iam@programmer.com'),
			array('firstname'=>'I am','lastname'=>'Designer','email'=>'iam@designer.com'),
			array('firstname'=>'I am','lastname'=>'User','email'=>'iam@user.com'),
			array('firstname'=>'I am','lastname'=>'Quality Assurance','email'=>'iam@qualityassurance.com')
		);
    $html = $this->load->view('table_report', $data, true);
    $filename = 'report_'.time();
    $this->pdfgenerator->generate($html, $filename, true, 'A4', 'portrait');
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

// SELECT DISTINCT EXTRACT(MONTH FROM begin_date) FROM booking

// SELECT kode_booking FROM booking WHERE EXTRACT(YEAR FROM begin_date) = 2018

}
