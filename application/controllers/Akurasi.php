<?php
class Akurasi extends CI_Controller{

	function __construct(){
	parent::__construct();
	$this->load->model('m_cruddataset');
	$this->load->model('m_classifier');
	$this->load->model('m_displaytable');
	if(!$this->session->userdata('logged_in')){
			redirect ('/');
		}
	}

	public function index(){
		$data['title'] = 'akurasi';
		$this->load->view('akurasi',$data);
	}
	
	public function insert_datauji(){
		$this->m_classifier->insert_datauji();
	}
	
	public function tabeltest(){
		$query = $this->m_displaytable->displaytabeltest($_GET['start'], $_GET['length'], $_GET['search']['value']);
		
		$no = $this->input->get('start')+1;
		$allData = [];
		foreach ($query['data'] as $key) {
			$allData[] = [
				$no++,
				$key['judul_review'],
				$key['sentimen_review'],
				$key['pos_post_prob'],
				$key['neg_post_prob'],
				$key['sentimen_datauji'],
				$this->m_classifier->accuracy_badge($key['sentimen_review'],$key['sentimen_datauji'])
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

	public function displaytabeltest(){
		$this->load->view('tabeltest');
	}
	
	public function matrix_akurasi(){
		$array_data_matrix = $this->m_classifier->matrix_akurasi();
		echo json_encode($array_data_matrix);
	}
}
?>