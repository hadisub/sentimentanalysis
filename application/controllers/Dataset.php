<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dataset extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_displaytable');
		$this->load->model('m_cruddataset');
		$this->load->model('m_doc_extraction');

		if(!$this->session->userdata('logged_in')){
			redirect ('/');
		}
	}

	public function index(){

		$data['title'] = 'dataset'; 
		$this->load->view('dataset',$data);
	}

	public function kata(){
		$query = $this->m_displaytable->displaydataset($_GET['start'], $_GET['length'], $_GET['search']['value']);
		
		$no = $this->input->get('start')+1;
		$allData = [];
		foreach ($query['data'] as $key) {
			$allData[] = [
				$no++,
				$key['judul_review'],
				$key['sentimen_review'],
				$key['kategori_review'],
				//explode( "\n",$key['isi_review'])[0],
				$key['isi_review'],
				'<button data-target="#modaldataset" data-toggle="modal" class="btn btn-circle btn-default btn-edit" data-id="'.$key['id_review'].'"><i class="material-icons">edit</i></button>
				<button a href="#deletereviewmodal" data-toggle="modal" data-id="'.$key['id_review'].'" class="btn btn-circle btn-danger btn-delete"><i class="material-icons">delete</i></button>'
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

	public function fetchid(){
		$id_review = $this->input->post('id');
		$data = $this->m_displaytable->fetchreview($id_review);
		echo json_encode($data);
	}

	public function inputdataset(){
		$judul = $this->input->post('judulreview');
		$isi = $this->input->post('teksreview');
		$kategori = $this->input->post('kategori');
		$sentimen = $this->input->post('sentimenawal');
		$lastid = $this->m_cruddataset->inputdataset($judul,$isi,$kategori,$sentimen);
		$this->m_doc_extraction->insertterm($lastid, $isi);

		if($lastid){
			$this->session->set_flashdata('notification','input_review_success');
		}
		else{
			$this->session->set_flashdata('notification','input_rreview_error');
		}
		redirect('dataset');
	}

	public function editdataset(){
		$judul = $this->input->post('judulreview');
		$isi = $this->input->post('teksreview');
		$kategori = $this->input->post('kategori');
		$sentimen = $this->input->post('sentimenawal');
		$idreview = $this->input->post('id_review');
		$edit_review = $this->m_cruddataset->editdataset($judul,$isi,$kategori,$sentimen,$idreview);
		$this->m_doc_extraction->editterm($idreview,$isi);

		if($edit_review){
			$this->session->set_flashdata('notification','edit_review_success');
		}
		else{
			$this->session->set_flashdata('notification','edit_review_error');
		}
		redirect('dataset');
	}

	public function deletedataset(){
		$idreview = $this->input->post('id_review');
		$delete_review = $this->m_cruddataset->deletedataset($idreview);

		if($delete_review){
			$this->session->set_flashdata('notification','delete_review_success');
		}
		else{
			$this->session->set_flashdata('notification','delete_review_error');
		}
		redirect('dataset');
	}

}
?>