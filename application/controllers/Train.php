<?php
class Train extends CI_Controller{

	function __construct(){
	parent::__construct();
	$this->load->model('m_displaytable');
	$this->load->model('m_classifier');
	$this->load->model('m_cruddataset');
	if(!$this->session->userdata('logged_in')){
			redirect ('/');
	}
	}

	public function index(){
		$data['title'] = 'train';
		$this->load->view('train',$data);
	}
	
	public function insert_term_occ(){
		$this->m_classifier->insert_term();
	}
	
	public function tabeltrain(){
		$query = $this->m_displaytable->displaytabeltrain($_GET['start'], $_GET['length'], $_GET['search']['value']);
		
		$no = $this->input->get('start')+1;
		$allData = [];
		foreach ($query['data'] as $key) {
			$allData[] = [
				$no++,
				$key['term'],
				$key['pos_occ'],
				$key['neg_occ']
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
	
	public function displaytabeltrain(){
		$this->load->view('tabeltrain');
	}
}
?>