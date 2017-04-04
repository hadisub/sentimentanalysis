<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Katadasar extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('m_displaytable');
		$this->load->model('m_crudkatadasar');
		if(!$this->session->userdata('logged_in')){
			redirect ('/');
		}
	}

	public function index(){

		$data['title'] = 'katadasar';
		$this->load->view('katadasar', $data);
	}

	public function kata(){
		$query = $this->m_displaytable->displaykatadasar($_GET['start'], $_GET['length'], $_GET['search']['value']);
		
		$no = $this->input->get('start')+1;
		$allData = [];
		foreach ($query['data'] as $key) {
			$allData[] = [
				$no++,
				$key['kata_katadasar'],
				'<button data-target="#modalkatadasar" data-toggle="modal" class="btn btn-circle btn-default btn-edit" data-id="'.$key['id_katadasar'].'"><i class="material-icons">edit</i></button>
				<button data-target="#deletekatadasarmodal" data-toggle="modal" data-id="'.$key['id_katadasar'].'" class="btn btn-circle btn-danger btn-delete"><i class="material-icons">delete</i></button>'
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
	$id_katadasar = $this->input->post('id');
	$data = $this->m_displaytable->fetchkatadasar($id_katadasar);
	echo json_encode($data);
	}

	public function inputkatadasar(){
		$katabaru = $this->input->post('katadasarbaru');
		$input_katadasar_baru = $this->m_crudkatadasar->inputkatadasar($katabaru);

		if($input_katadasar_baru){
			$this->session->set_flashdata('notification','input_kd_success');
		}
		else{
			$this->session->set_flashdata('notification','input_kd_error');
		}

		redirect('katadasar');
	}

	public function editkatadasar(){
	$kata = $this->input->post('katadasarbaru');
	$idkatadasar = $this->input->post('id_katadasar');
	$edit_katadasar = $this->m_crudkatadasar->editkatadasar($kata,$idkatadasar);
	if($edit_katadasar){
		$this->session->set_flashdata('notification','edit_kd_success');
		}
	else{
		$this->session->set_flashdata('notification','edit_kd_error');
		}

	redirect('katadasar');
	}

	public function deletekatadasar(){
	$idkatadasar = $this->input->post('id_katadasar');
	$hapus_katadasar = $this->m_crudkatadasar->deletekatadasar($idkatadasar);
	if($hapus_katadasar){
		$this->session->set_flashdata('notification','delete_kd_success');
		}
	else{
		$this->session->set_flashdata('notification','delete_kd_error');
		}

	redirect('katadasar');
}
}
?>