<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Displaytable extends CI_Model
{
	
	public function fetchreview($id){
		$this->db->where('id_review', $id);
		$this->db->from('sa_review');
		return $this->db->get()->row_array();
	}

	public function fetchkatadasar($id){
		$this->db->where('id_katadasar', $id);
		$this->db->from('sa_katadasar');
		return $this->db->get()->row_array();
	}

	public function fetchstopwords($id){
		$this->db->where('id_stopwords', $id);
		$this->db->from('sa_stopwords');
		return $this->db->get()->row_array();
	}

	public function displaytabeltest($start, $length, $search_query){
		//count all matching reviews
		$this->db->like('judul_review', $search_query);
		$this->db->from('sa_review');
		$this->db->where('kategori_review','DATA UJI');
		$this->db->order_by('judul_review','ASC');
		$totalfilter = $this->db->count_all_results();

		//limit matching reviews per page
		$this->db->like('judul_review', $search_query);
		$this->db->from('sa_review');
		$this->db->where('kategori_review','DATA UJI');
		$this->db->order_by('judul_review','ASC');
		$this->db->limit($length, $start);
		$data = $this->db->get()->result_array();
		$total = $this->db->count_all_results('sa_review');
		return [
			"data" => $data,
			"total" => $total,
			"result" => $totalfilter
		];	
	}

	public function displaydataset($start, $length, $search_query){
		//count all matching stopwords
		$this->db->like('judul_review', $search_query);
		$this->db->from('sa_review');
		$this->db->order_by('judul_review','ASC');
		$totalfilter = $this->db->count_all_results();

		//limit matching stopwords per page
		$this->db->like('judul_review', $search_query);
		$this->db->from('sa_review');
		$this->db->order_by('judul_review','ASC');
		$this->db->limit($length, $start);
		$data = $this->db->get()->result_array();
		$total = $this->db->count_all_results('sa_review');
		return [
			"data" => $data,
			"total" => $total,
			"result" => $totalfilter
		];	
	}

	public function displaykatadasar($start, $length, $search_query){
		//count all matching katadasar
		$this->db->like('kata_katadasar', $search_query);
		$this->db->from('sa_katadasar');
		$this->db->order_by('kata_katadasar','ASC');
		$totalfilter = $this->db->count_all_results();

		//limit matching katadasar per page
		$this->db->like('kata_katadasar', $search_query);
		$this->db->from('sa_katadasar');
		$this->db->order_by('kata_katadasar','ASC');
		$this->db->limit($length, $start);
		$data = $this->db->get()->result_array();
		$total = $this->db->count_all_results('sa_katadasar');
		return [
			"data" => $data,
			"total" => $total,
			"result" => $totalfilter
		];
	}

	public function displaystopwords($start, $length, $search_query){
	//count all matching stopwords
		$this->db->like('kata_stopwords', $search_query);
		$this->db->from('sa_stopwords');
		$this->db->order_by('kata_stopwords','ASC');
		$totalfilter = $this->db->count_all_results();

		//limit matching stopwords per page
		$this->db->like('kata_stopwords', $search_query);
		$this->db->from('sa_stopwords');
		$this->db->order_by('kata_stopwords','ASC');
		$this->db->limit($length, $start);
		$data = $this->db->get()->result_array();
		$total = $this->db->count_all_results('sa_stopwords');
		return [
			"data" => $data,
			"total" => $total,
			"result" => $totalfilter
		];	
	}

	public function displaytermtokenized($start, $length, $search_query){
	//count all matching stopwords
		$this->db->like('judul_review', $search_query);
		$this->db->from('sa_review');
		$this->db->join('sa_term', 'sa_term.id_review = sa_review.id_review');
		$this->db->order_by('sa_review.judul_review','ASC');
		$totalfilter = $this->db->count_all_results();

		//limit matching stopwords per page
		$this->db->like('judul_review', $search_query);
		$this->db->from('sa_review');
		$this->db->join('sa_term', 'sa_term.id_review = sa_review.id_review');
		$this->db->order_by('sa_review.judul_review','ASC');
		$this->db->limit($length, $start);
		$data = $this->db->get()->result_array();
		$total = $this->db->count_all_results('sa_review');
		return [
			"data" => $data,
			"total" => $total,
			"result" => $totalfilter
		];	
	}

	public function displaytermfiltered($start, $length, $search_query){
	//count all matching stopwords
		$this->db->like('judul_review', $search_query);
		$this->db->from('sa_review');
		$this->db->join('sa_term', 'sa_term.id_review = sa_review.id_review');
		$this->db->order_by('sa_review.judul_review','ASC');
		$totalfilter = $this->db->count_all_results();

		//limit matching stopwords per page
		$this->db->like('judul_review', $search_query);
		$this->db->from('sa_review');
		$this->db->join('sa_term', 'sa_term.id_review = sa_review.id_review');
		$this->db->order_by('sa_review.judul_review','ASC');
		$this->db->limit($length, $start);
		$data = $this->db->get()->result_array();
		$total = $this->db->count_all_results('sa_review');
		return [
			"data" => $data,
			"total" => $total,
			"result" => $totalfilter
		];	
	}

	public function displaytermstemmed($start, $length, $search_query){
	//count all matching stopwords
		$this->db->like('judul_review', $search_query);
		$this->db->from('sa_review');
		$this->db->join('sa_term', 'sa_term.id_review = sa_review.id_review');
		$this->db->order_by('sa_review.judul_review','ASC');
		$totalfilter = $this->db->count_all_results();

		//limit matching stopwords per page
		$this->db->like('judul_review', $search_query);
		$this->db->from('sa_review');
		$this->db->join('sa_term', 'sa_term.id_review = sa_review.id_review');
		$this->db->order_by('sa_review.judul_review','ASC');
		$this->db->limit($length, $start);
		$data = $this->db->get()->result_array();
		$total = $this->db->count_all_results('sa_review');
		return [
			"data" => $data,
			"total" => $total,
			"result" => $totalfilter
		];	
	}

}
?>