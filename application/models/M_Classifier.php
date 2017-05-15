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

	//ambil semua term dari semua data latih
	public function array_terms(){
		$this->db->select('term_stemmed');
		$this->db->from('sa_bagofwords');
		$this->db->join('sa_review', 'sa_review.id_review = sa_bagofwords.id_review');
		$this->db->where('kategori_review','DATA LATIH');
		$array_terms = $this->db->get()->result_array();
		$array_terms= array_column($array_terms,'term_stemmed');
		$all_terms = implode(" ",$array_terms);
		$all_terms = preg_replace('/\s+/', ' ', $all_terms);
		$all_terms = trim($all_terms);
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
		$all_pos_terms = preg_replace('/\s+/', ' ', $all_pos_terms);
		$all_pos_terms = trim($all_pos_terms);
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
		$all_neg_terms = preg_replace('/\s+/', ' ', $all_neg_terms);
		$all_neg_terms = trim($all_neg_terms);
		$array_neg_terms = explode(" ",$all_neg_terms);
		return $array_neg_terms;
	}

	/*----PROSES TRAINING----*/
	
	//hitung total review di data uji
	public function count_total_testdata(){
		$this->db->select('id_review');
		$this->db->from('sa_review');
		$this->db->where('kategori_review','DATA UJI');
		$total_testdata = $this->db->count_all_results();
		return $total_testdata;
	}
	
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

	//insert jumlah kemunculan term ke database
	public function insert_term(){
		$this->db->truncate('sa_term');
		$data = $this->array_term_occ();
		$this->db->insert_batch('sa_term',$data);	
	}
	
	/*----PROSES TESTING NAIVE BAYES----*/
	
	//ambil seluruh term di tabel review yang kategorinya data uji (untuk ADMIN)
	public function all_terms_testdata(){
		$this->db->select('sa_review.id_review, sa_bagofwords.term_stemmed');
		$this->db->from('sa_review');
		$this->db->where('kategori_review','DATA UJI');
		$this->db->join('sa_bagofwords', 'sa_bagofwords.id_review = sa_review.id_review');
		$array_all_term = $this->db->get()->result_array();
		return $array_all_term;
	}
	
	//ambil seluruh term dari textarea (untuk VISITOR)
	public function all_terms_visitor(){
		
	}
	
	public function get_role(){
		$role="";
		if($this->session->userdata('logged_in')){
			$role="admin";
		}else{
			$role="visitor";
		}
		return $role;
	}
	
	public function get_test_terms($role){
		$array_terms = array();
		switch ($role) {
			case 'admin':
            $array_terms = $this->all_terms_testdata();
            break;
			
			case 'visitor':
            $array_terms = $this->all_terms_visitor();
            break;
		}
		return $array_terms;
	}
	
	//ambil pos dan neg occurences di tabel term
	public function array_occ_db(){
		$this->db->select('term,pos_occ,neg_occ');
		$this->db->from('sa_term');
		$array_occ_db = $this->db->get()->result_array();
		return $array_occ_db;
	}
	
	//prior probability kelas positif
	public function pos_prior_prob(){
		$total_traindata = $this->count_total_traindata();
		$pos_traindata = $this->count_pos_traindata();
		
		//prior prob positif = jumlah data latih positif/jumlah semua data latih
		$pos_prior = $pos_traindata/$total_traindata;
		return $pos_prior;
	}
	
	//prior probability kelas negatif
	public function neg_prior_prob(){
		$total_traindata = $this->count_total_traindata();
		$neg_traindata = $this->count_neg_traindata();
		
		//prior prob negatif = jumlah data latih negatif/jumlah semua data latih
		$neg_prior = $neg_traindata/$total_traindata;
		return $neg_prior;
	}
	
	//proses perhitungan naive bayes
	public function naive_bayes(){
		$role = $this->get_role();
		$vocab_count = count($this->vocabulary()); //jumlah vocabulary (unique terms)
		$array_testdata = $this->get_test_terms($role); //ambil seluruh term di data uji / textarea visitor (tergantung role)
		$total_pos_terms = count($this->array_pos_terms()); //jumlah seluruh term di kelas positif
		$total_neg_terms = count($this->array_neg_terms()); //jumlah seluruh term di kelas negatif
		$array_occ_db = $this->array_occ_db(); //ambil kemunculan kata
		$pos_prior_prob = log($this->pos_prior_prob()); //prior probability kelas positif
		$neg_prior_prob = log($this->neg_prior_prob()); //prior probability kelas negatif
		$array_results = array();
		
		//loop semua dokumen di data uji
		foreach($array_testdata as $test_data){
			$id = $test_data["id_review"];
			$terms_in_doc = explode(" ", $test_data["term_stemmed"]);
			
			$pos_post_prob = 0;
			$neg_post_prob = 0;
			
			//loop semua term di dalam dokumen di data uji
			foreach($terms_in_doc as $term){
				$pos_occ_in_class = 0;
				$neg_occ_in_class = 0;
				for($i=0; $i < count($array_occ_db);$i++){
					if($array_occ_db[$i]["term"] == $term){
					$pos_occ_in_class = $array_occ_db[$i]["pos_occ"];
					$neg_occ_in_class = $array_occ_db[$i]["neg_occ"];
					break;
					}
				}
				
				/*---posterior probability kelas C = jumlah kemunculan kata x di semua dokumen di kategori C  + 1)
				/(jumlah semua kata di kategori C + jumlah semua unique words/vocabulary di semua kategori di data latih---*/
				$pos_post_prob += log(($pos_occ_in_class+1)/($total_pos_terms+$vocab_count)); //posterior probability dokumen C di kelas positif
				$neg_post_prob += log(($neg_occ_in_class+1)/($total_neg_terms+$vocab_count)); //posterior probability dokumen C di kelas negatif
			}
			
			//P kelas positif dokumen C = P kelas positif (prior probability)* posterior probability
			$pos_prob_datauji = $pos_prior_prob+$pos_post_prob;
			
			//P kelas negatif dokumen C = P kelas negatif (prior probability)* posterior probability
			$neg_prob_datauji = $neg_prior_prob+$neg_post_prob;
			
			//ambil kelas terbaik (which one of 2 classes is higher in probability)
			$best_class= $this->best_class($pos_prob_datauji,$neg_prob_datauji);
			
			//masukkan hasil perhitungan ke dalam array data uji
			$array_results[] = array("id_review"=>$id,"prob_pos_datauji"=>$pos_prob_datauji,
			"prob_neg_datauji"=>$neg_prob_datauji,"sentimen_datauji"=>$best_class); 
		}
		
		return $array_results;
	}
	
	//tentukan kelas terbaik
	public function best_class($positive,$negative){
		$best_class = "POSITIF";
		if($positive<$negative){
			$best_class = "NEGATIF";
		}
		return $best_class;
	}
	
	//isi badge di tabel
	public function accuracy_badge($predicted,$result){
		$badge="<span class='badge bg-gray'>BLM DIKETAHUI</span>";
		if(isset($result)){
			if($predicted==$result){
				$badge="<span class='badge bg-green'>AKURAT</span>";
			}else{
				$badge="<span class='badge bg-red'>TDK AKURAT</span>";
			}
		}
		return $badge;
	}
	
	public function insert_datauji(){
		$this->db->truncate('sa_datauji');
		$data = $this->naive_bayes();
		$this->db->insert_batch('sa_datauji',$data);
	}
	
	//ambil sentimen awal dan hasil analisis
	public function get_sentiments(){
		$this->db->select('sa_review.sentimen_review, sa_datauji.sentimen_datauji');
		$this->db->from('sa_review');
		$this->db->where('kategori_review','DATA UJI');
		$this->db->join('sa_datauji', 'sa_datauji.id_review = sa_review.id_review');
		$array_all_sentiments = $this->db->get()->result_array();
		return $array_all_sentiments;
	}
	
	public function matrix_akurasi(){
		$array_sentiments = $this->get_sentiments();
		$total_datauji =  count($array_sentiments);
		$true_positives =0;
		$true_negatives =0;
		$false_positives =0;
		$false_negatives =0;
		
		foreach($array_sentiments as $sentiment){
			if($sentiment["sentimen_review"]=="POSITIF" && $sentiment["sentimen_datauji"]=="POSITIF"){
				$true_positives = $true_positives+1;
			}
			else if($sentiment["sentimen_review"]=="NEGATIF" && $sentiment["sentimen_datauji"]=="NEGATIF"){
				$true_negatives = $true_negatives+1;
			}
			else if($sentiment["sentimen_review"]=="POSITIF" && $sentiment["sentimen_datauji"]=="NEGATIF"){
				$false_positives = $false_positives+1;
			}
			else if($sentiment["sentimen_review"]=="NEGATIF" && $sentiment["sentimen_datauji"]=="POSITIF"){
				$false_negatives = $false_negatives+1;
			}
		}
		
		$akurasi = ($true_positives+$true_negatives)/$total_datauji; //AKURASI :(true positives+true negatives)/total data uji
		$error_rate = 1- $akurasi; //ERROR-RATE : 1 - akurasi (tingkat kesalahan sistem)
		$presisi = $true_positives/($true_positives+$false_positives); //PRESISI :true positives/(true positives+false positives)
		$recall = $true_positives/($true_positives+$false_negatives); //RECALL: true positives/(true positives+false negatives)
		$array_data_matriks = array($total_datauji, $true_positives, $true_negatives, $false_positives, $false_negatives, $akurasi, $error_rate, $presisi, $recall);
		return $array_data_matriks;
	}
	
}
?>