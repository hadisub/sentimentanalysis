<?php
class Dashboard extends CI_Controller{

	function __construct(){
	parent::__construct();
	$this->load->model('m_cruddataset');
	$this->load->model('m_term');
	$this->load->model('m_displaytable');
	if(!$this->session->userdata('logged_in')){
			redirect ('/');
	}
	}

	public function index(){
		$data['title'] = 'dashboard';
		$data['total_review'] = $this->m_term->count_total_review();
		$data['pos_review'] = $this->m_term->count_pos_review();
		$data['neg_review'] = $this->m_term->count_neg_review();
		$this->load->view('dashboard',$data);
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
				'-',
				'<span class="badge bg-green">AKURAT</span>'
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
		$data['total_terms'] = $this->m_term->count_total_terms();
		$data['total_pos_terms'] = $this->m_term->count_total_pos_terms();
		$data['total_neg_terms'] = $this->m_term->count_total_neg_terms();
		$data['most_common_term'] = $this->m_term->most_term();
		$data['testing'] = $this->m_term->train_pos_post_prob();
		$this->load->view('tabeltest',$data);
	}

}
?>