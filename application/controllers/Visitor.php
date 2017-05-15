<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Visitor extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_classifier');

		if($this->session->userdata('logged_in')){
			redirect ('dashboard');
		}
	}

	public function index(){
		$data['total_traindata'] = $this->m_classifier->count_total_traindata();
		$data['pos_traindata'] = $this->m_classifier->count_pos_traindata();
		$data['neg_traindata'] = $this->m_classifier->count_neg_traindata();
		$this->load->view('visitor',$data);
	}
}
?>