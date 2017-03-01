<?php
class M_Classifier extends CI_Model{

	//hitung total review di data latih
	public function count_total_traindata(){
		$this->db->select('id_review');
		$this->db->from('sa_review');
		$this->db->where('kategori_review','DATA LATIH');
		$total_traindata = $this->db->count_all_results();
		return $total_traindata;
	}

	//hitung total review positif di data latih
	public function count_pos_traindata(){
		$this->db->select('id_review');
		$this->db->from('sa_review');
		$this->db->where('kategori_review','DATA LATIH');
		$this->db->where('sentimen_review','POSITIF');
		$total_pos_traindata = $this->db->count_all_results();
		return $total_pos_traindata;
	}

	//hitung total review negatif di data latih
	public function count_neg_traindata(){
		$this->db->select('id_review');
		$this->db->from('sa_review');
		$this->db->where('kategori_review','DATA LATIH');
		$this->db->where('sentimen_review','NEGATIF');
		$total_neg_traindata = $this->db->count_all_results();
		return $total_neg_traindata;
	}

	//hitung total data uji
	public function count_testdata(){
		$this->db->select('id_review');
		$this->db->from('sa_review');
		$this->db->where('kategori_review','DATA UJI');
		$total_testdata = $this->db->count_all_results();
		return $total_testdata;
	}

	//ambil semua term dari semua data latih
	public function array_terms(){
		$this->db->select('term_stemmed');
		$this->db->from('sa_bagofwords');
		$this->db->join('sa_review', 'sa_review.id_review = sa_bagofwords.id_review');
		$this->db->where('kategori_review','DATA LATIH');
		$array_terms = $this->db->get()->result_array();
		$array_terms= array_column($array_terms,'term_stemmed');
		$all_terms = implode(" ",$array_terms);
		$array_terms = explode(" ",$all_terms);
		return $array_terms;
	}


	//ambil array semua term dari data latih positif
	public function array_pos_terms(){
		$this->db->select('term_stemmed');
		$this->db->from('sa_bagofwords');
		$this->db->join('sa_review', 'sa_review.id_review = sa_bagofwords.id_review');
		$this->db->where('sa_review.sentimen_review','POSITIF');
		$this->db->where('sa_review.kategori_review','DATA LATIH');
		$array_pos_terms = $this->db->get()->result_array();
		$array_pos_terms= array_column($array_pos_terms,'term_stemmed');
		$all_pos_terms = implode(" ",$array_pos_terms);
		$array_pos_terms = explode(" ",$all_pos_terms);
		return $array_pos_terms;
	}

	//ambil array semua term dari data latih negatif
	public function array_neg_terms(){
		$this->db->select('term_stemmed');
		$this->db->from('sa_bagofwords');
		$this->db->join('sa_review', 'sa_review.id_review = sa_bagofwords.id_review');
		$this->db->where('sa_review.sentimen_review','NEGATIF');
		$this->db->where('sa_review.kategori_review','DATA LATIH');
		$array_neg_terms = $this->db->get()->result_array();
		$array_neg_terms= array_column($array_neg_terms,'term_stemmed');
		$all_neg_terms = implode(" ",$array_neg_terms);
		$array_neg_terms = explode(" ",$all_neg_terms);
		return $array_neg_terms;
	}

	/*----PROSES TRAINING----*/

	//ambil array semua term yang unik dari semua data latih (vocabulary)
	public function vocabulary(){
		$array_terms = $this->array_terms();
		$vocabulary = array_unique($array_terms);
		$array_vocabulary = array();
		foreach ($vocabulary as $unique_term) {
			array_push($array_vocabulary,$unique_term);
		}
		return $array_vocabulary;
	}

	//hitung kemunculan (occurences) term t di data latih positif lalu masukkan nilainya ke dalam array
	public function get_pos_occurences(){
		$array_pos_occs = array();
		$vocab = $this->vocabulary();
		$array_pos_terms = $this->array_pos_terms();
		$array_pos_values = array_count_values($array_pos_terms);

		foreach ($vocab as $term) {
			if(isset($array_pos_values[$term])){
				$array_pos_occs[] = $array_pos_values[$term];
			}
			else{
				$array_pos_occs[] = 0;
			}

		}
		return $array_pos_occs;		
	}

	public function get_neg_occurences(){
		$array_neg_occs = array();
		$vocab = $this->vocabulary();
		$array_neg_terms = $this->array_neg_terms();
		$array_neg_values = array_count_values($array_neg_terms);

		foreach ($vocab as $term) {
			if(isset($array_neg_values[$term])){
				$array_neg_occs[] = $array_neg_values[$term];
			}
			else{
				$array_neg_occs[] = 0;
			}

		}
		return $array_neg_occs;		
	}

	public function array_term_occ(){
		$array_occ=array();
		$vocab = $this->vocabulary();
		$array_pos_occ = $this->get_pos_occurences();
		$array_neg_occ = $this->get_neg_occurences();
		$limit = count($vocab);
		for($i=0; $i<$limit; $i++){
			$array_occ[] = array("term"=>$vocab[$i],"pos_occ"=>$array_pos_occ[$i],"neg_occ"=>$array_neg_occ[$i]); 
		}
		return $array_occ;
	}

	/*----INSERT TERM KE DATABASE----*/
	public function insert_term(){
		$this->db->truncate('sa_term');
		$data = $this->array_term_occ();
		$this->db->insert_batch('sa_term',$data);	
		}
}
?>