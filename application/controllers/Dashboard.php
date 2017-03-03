<?php
class Dashboard extends CI_Controller{

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
		$data['title'] = 'dashboard';
		$data['total_traindata'] = $this->m_classifier->count_total_traindata();
		$data['pos_traindata'] = $this->m_classifier->count_pos_traindata();
		$data['neg_traindata'] = $this->m_classifier->count_neg_traindata();
		$data['total_testdata'] = $this->m_classifier->count_testdata();
		$data['testing'] = $this->m_classifier->testingku();
		$this->load->view('dashboard',$data);
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
		$this->m_classifier->insert_term();
		$this->load->view('tabeltrain');
	}

}
?>