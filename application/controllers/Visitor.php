<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Visitor extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_doc_extraction');
		$this->load->model('m_classifier');

		if($this->session->userdata('logged_in')){
			redirect ('dashboard');
		}
	}

	public function index(){
		$data['total_traindata'] = $this->m_classifier->count_total_traindata();
		$data['pos_traindata'] = $this->m_classifier->count_pos_traindata();
		$data['neg_traindata'] = $this->m_classifier->count_neg_traindata();
		$this->load->view('visitor/visitor',$data);
	}
	
	public function display_analisis(){
		$this->load->view('visitor/visitor-analisis');
	}
	
	public function process_visitor_review(){
		$review = $_POST["isi_review"];
		
		//proses ekstraksi
		$tokenized = $this->m_doc_extraction->tokenizing($review);
		$filtered = $this->m_doc_extraction->filtering($tokenized);
		$stemmed = $this->m_doc_extraction->stemming($filtered);
		
		//proses klasifikasi
		$analysis_results = $this->m_classifier->naive_bayes_visitor($stemmed);
		
		echo json_encode($analysis_results);
	}
}
?>