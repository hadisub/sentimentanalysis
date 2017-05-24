<?php
class Dashboard extends CI_Controller{

	function __construct(){
	parent::__construct();
	$this->load->model('m_classifier');
	if(!$this->session->userdata('logged_in')){
			redirect ('/');
	}
	}

	public function index(){
		$data['title'] = 'dashboard';
		$data['total_traindata'] = $this->m_classifier->count_total_traindata();
		$data['pos_traindata'] = $this->m_classifier->count_pos_traindata();
		$data['neg_traindata'] = $this->m_classifier->count_neg_traindata();
		$data['total_testdata'] = $this->m_classifier->count_total_testdata();
		$this->load->view('dashboard',$data);
	}
}
?>