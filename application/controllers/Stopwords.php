<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Stopwords extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_displaytable');
		$this->load->model('m_crudstopwords');

		if(!$this->session->userdata('logged_in')){
			redirect ('/');
		}
	}

	public function index(){

		$data['title'] = 'stopwords';
		$this->load->view('stopwords', $data);
	}

	public function kata(){
		$query = $this->m_displaytable->displaystopwords($_GET['start'], $_GET['length'], $_GET['search']['value']);
		
		$no = $this->input->get('start')+1;
		$allData = [];
		foreach ($query['data'] as $key) {
			$allData[] = [
				$no++,
				$key['kata_stopwords'],
				'<button data-target="#modalstopwords" data-toggle="modal" class="btn btn-circle btn-default btn-edit" data-id="'.$key['id_stopwords'].'"><i class="material-icons">edit</i></button>
				<button data-target="#deletestopwordsmodal" data-toggle="modal" data-id="'.$key['id_stopwords'].'" class="btn btn-circle btn-danger btn-delete"><i class="material-icons">delete</i></button>'
			];
		}

		$data = [
			"draw" => $_GET['draw'],
			"recordsTotal" => $query['total'],
			"recordsFiltered" => $query['result'],
			"data" => $allData
		];

		echo json_encode($data);
	}

	public function ambilkata(){
	$id_stopwords = $this->input->post('id');
	$data = $this->m_displaytable->fetchstopwords($id_stopwords);
	echo json_encode($data);
	}

	public function inputstopwords(){
		$katabaru = $this->input->post('stopwordsbaru');
		$input_stopwords_baru = $this->m_crudstopwords->inputstopwords($katabaru);

		if($input_stopwords_baru){
			$this->session->set_flashdata('notification','input_sw_success');
		}
		else{
			$this->session->set_flashdata('notification','input_sw_error');
		}
		redirect('stopwords');
	}

	public function editstopwords(){
	$kata = $this->input->post('stopwordsbaru');
	$idstopwords = $this->input->post('id_stopwords');
	$this->load->model('m_crudstopwords');
	$edit_stopwords = $this->m_crudstopwords->editstopwords($kata,$idstopwords);
	if($edit_stopwords){
			$this->session->set_flashdata('notification','edit_sw_success');
		}
		else{
			$this->session->set_flashdata('notification','edit_sw_error');
		}

	redirect('stopwords');
	}

	public function deletestopwords(){
	$idstopwords = $this->input->post('id_stopwords');
	$this->load->model('m_crudstopwords');
	$hapus_stopwords = $this->m_crudstopwords->deletestopwords($idstopwords);
	if($hapus_stopwords){
			$this->session->set_flashdata('notification','delete_sw_success');
		}
		else{
			$this->session->set_flashdata('notification','delete_sw_error');
		}

	redirect('stopwords');
	}
}
?>