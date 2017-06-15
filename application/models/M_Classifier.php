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
	public function all_terms_traindata(){
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
	
	//ambil array semua term yang unik dari semua data latih (vocabulary)
	public function vocabulary(){
		$array_terms = $this->all_terms_traindata();
		$vocabulary = array_unique($array_terms);
		$array_vocabulary = array();
		foreach ($vocabulary as $unique_term) {
			array_push($array_vocabulary,$unique_term);
		}
		return $array_vocabulary;
	}
	
	/*---------------------------PROSES TRAINING---------------------------*/
	
	//PRIOR PROBABILITY
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
	
	//hitung kemunculan (occurences) term t di data latih negatif lalu masukkan nilainya ke dalam array
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
	
	//LIKELIHOOD
	//fungsi untuk menghitung likelihood
	public function likelihood($term_occ,$total_term_in_cat,$vocabulary_count){
		$likelihood = ($term_occ+1)/($total_term_in_cat+$vocabulary_count);
		$likelihood = log($likelihood); //agar tidak terjadi underflow
		return $likelihood;
	}
	
	public function training(){
		$array_training_terms=array();
		$vocab = $this->vocabulary();
		$pos_terms_count = count($this->array_pos_terms()); //jumlah semua term di data latih positif
		$neg_terms_count = count($this->array_neg_terms()); //jumlah semua term di data latih negatif
		
		$array_pos_occ = $this->get_pos_occurences();
		$array_neg_occ = $this->get_neg_occurences();
		$vocab_count = count($vocab); //jumlah semua term di vocabulary
		for($i=0; $i<$vocab_count; $i++){
			
			//hitung likelihood kelas positif dan negatif untuk setiap term di vocabulary
			$pos_likelihood = $this->likelihood($array_pos_occ[$i],$pos_terms_count,$vocab_count);
			$neg_likelihood = $this->likelihood($array_neg_occ[$i],$neg_terms_count,$vocab_count);
			$array_training_terms[] = array("term"=>$vocab[$i],"pos_occ"=>$array_pos_occ[$i],"neg_occ"=>$array_neg_occ[$i],"pos_likelihood"=>$pos_likelihood,
			"neg_likelihood"=>$neg_likelihood); 
		}
		return $array_training_terms;
	}
	
	//insert hasil proses training ke database
	public function insert_train(){
		$this->db->truncate('sa_vocabulary');
		$data = $this->training();
		$this->db->insert_batch('sa_vocabulary',$data);	
	}
	
	/*---------------------------PROSES TESTING---------------------------*/
	
	//hitung total review di data uji
	public function count_total_testdata(){
		$this->db->select('id_review');
		$this->db->from('sa_review');
		$this->db->where('kategori_review','DATA UJI');
		$total_testdata = $this->db->count_all_results();
		return $total_testdata;
	}
	
	//ambil semua review data uji
	public function all_test_docs(){
		$this->db->select('sa_review.id_review, sa_bagofwords.term_stemmed');
		$this->db->from('sa_review');
		$this->db->where('kategori_review','DATA UJI');
		$this->db->join('sa_bagofwords', 'sa_bagofwords.id_review = sa_review.id_review');
		$array_test_docs = $this->db->get()->result_array();
		return $array_test_docs;
	}
	
	//ambil semua isi tabel vocabulary (frekuensi kemunculan term dan likelihood)
	public function all_vocabs(){
		$this->db->select('*');
		$this->db->from('sa_vocabulary');
		$array_all_vocabs = $this->db->get()->result_array();
		return $array_all_vocabs;
	}
	
	//normalisasi log posterior probability
	public function normalize_log($pos,$neg){
		$max_val = max($pos,$neg);//cari nilai log terbesar
		
		$pos = $max_val/$pos;
		$neg = $max_val/$neg;
		
		$exp_pos = exp($pos);
		$exp_neg = exp($neg);
		
		$pos_prob = $exp_pos/($exp_pos+$exp_neg);
		$neg_prob = $exp_neg/($exp_pos+$exp_neg);
		
		$array_results = array("pos_prob"=>$pos_prob, "neg_prob"=>$neg_prob);
		return $array_results;
	}
	
	//tentukan kelas sentimen terbaik
	public function best_class($positive,$negative){
		$best_class = "POSITIF";
		if($positive<$negative){
			$best_class = "NEGATIF";
		}
		return $best_class;
	}
	
	//fungsi naive bayes classifier untuk mengklasifikasikan data uji
	public function naive_bayes(){
		$array_results=array();
		$vocab = $this->all_vocabs();
		$pos_terms_count = count($this->array_pos_terms()); //jumlah semua term di data latih positif
		$neg_terms_count = count($this->array_neg_terms()); //jumlah semua term di data latih negatif
		$vocab_count = count($vocab); //jumlah semua term di vocabulary
		$array_test_docs = $this->all_test_docs(); //ambil semua review data uji
		$pos_prior_prob = log($this->pos_prior_prob()); //log dari prior probability kelas positif
		$neg_prior_prob = log($this->neg_prior_prob()); //log dari prior probability kelas negatif
		
		
		foreach($array_test_docs as $test_doc){ //loop untuk semua review data uji
			$id = $test_doc["id_review"];
			$terms_in_doc = explode(" ", $test_doc["term_stemmed"]);
			$total_pos_likelihood = 0;
			$total_neg_likelihood = 0;
			
			foreach($terms_in_doc as $term){
				$pos_likelihood = 0;
				$neg_likelihood = 0;
				$found = false;
				
				for($i=0; $i < $vocab_count;$i++){
					if($vocab[$i]["term"] == $term){
						$pos_likelihood = $vocab[$i]["pos_likelihood"];
						$neg_likelihood = $vocab[$i]["neg_likelihood"];
						$found= true;
						break;
					}
				}
				if(!$found){
					$pos_likelihood = $this->likelihood(0,$pos_terms_count,$vocab_count);
					$neg_likelihood = $this->likelihood(0,$neg_terms_count,$vocab_count);
				}
				
				$total_pos_likelihood += $pos_likelihood;
				$total_neg_likelihood += $neg_likelihood;				
			}
			
			//posterior probability kelas positif dokumen C = log(prior probability) + total likelihood
			$pos_post_prob = $pos_prior_prob + $total_pos_likelihood;
			
			//posterior probability kelas negatif dokumen C = log(prior probability) + total likelihood
			$neg_post_prob = $neg_prior_prob + $total_neg_likelihood;
			
			//normalisasi log posterior probability
			$array_prob = $this->normalize_log($pos_post_prob,$neg_post_prob);
			$pos_post_prob = $array_prob["pos_prob"];
			$neg_post_prob = $array_prob["neg_prob"];
			
			//ambil kelas terbaik (kelas dengan posterior probability tertinggi)
			$best_class= $this->best_class($pos_post_prob,$neg_post_prob);
			
			//masukkan ke array results
			$array_results[] = array("id_review"=>$id,"pos_post_prob"=>$pos_post_prob,
			"neg_post_prob"=>$neg_post_prob,"sentimen_datauji"=>$best_class); 
		}
		
		return $array_results;
	}
	
	public function insert_datauji(){
		$this->db->truncate('sa_datauji');
		$data = $this->naive_bayes();
		$this->db->insert_batch('sa_datauji',$data);
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
	
	//ambil sentimen asli dan sentimen hasil analisis
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
		$ppv = $true_positives/($true_positives+$false_positives); //POSITIVE PREDICTION VALUE /PRESISI : true positives/(true positives+false positives)
		$npv = $true_negatives/($true_negatives+$false_negatives); //NEGATIVE PREDICTION VALUE : true negatives/(true negatives+false negatives)
		$sensitivity = $true_positives/($true_positives+$false_negatives); //SENSITIVITY /RECALL : true positives/(true positives+false negatives)
		$specificity = $true_negatives/($true_negatives+$false_positives); //SPECIFICITY : true negatives/(true negatives+false positives)
		$array_data_matriks = array($total_datauji, $true_positives, $true_negatives, $false_positives, $false_negatives, $akurasi, $error_rate, $ppv, $npv, $sensitivity, $specificity);
		return $array_data_matriks;
	}
	
	/*---------------------------LIHAT SENTIMEN VISITOR---------------------------*/
	
	//bersihkan whitespaces dan ubah ke array
	public function visitor_clean_space($stemmed_review){
		$all_terms = preg_replace('/\s+/', ' ', $stemmed_review);
		$array_terms = explode(" ",$all_terms);
		
		return $array_terms;
	}
	
	//fungsi naive bayes untuk mengklasifikasikan review dari visitor
	public function naive_bayes_visitor($stemmed_review){
		$array_results=array();
		$vocab = $this->all_vocabs();
		$pos_terms_count = count($this->array_pos_terms()); //jumlah semua term di data latih positif
		$neg_terms_count = count($this->array_neg_terms()); //jumlah semua term di data latih negatif
		$vocab_count = count($vocab); //jumlah semua term di vocabulary
		$array_terms = $this->visitor_clean_space($stemmed_review); //kumpulan term yang diambil berasal dari masukan review visitor
		$pos_prior_prob = log($this->pos_prior_prob()); //log dari prior probability kelas positif
		$neg_prior_prob = log($this->neg_prior_prob()); //log dari prior probability kelas negatif
		$total_pos_likelihood_visitor = 0;
		$total_neg_likelihood_visitor = 0;
			
		foreach($array_terms as $term){ //loop untuk semua term di review visitor
			$pos_likelihood_visitor =0;
			$neg_likelihood_visitor =0;
			$found = false;
			
			for($i=0; $i < $vocab_count;$i++){
				if($vocab[$i]["term"] == $term){
					$pos_likelihood_visitor = $vocab[$i]["pos_likelihood"];
					$neg_likelihood_visitor = $vocab[$i]["neg_likelihood"];
					$found= true;
					break;
				}
			}
			if(!$found){
				$pos_likelihood_visitor = $this->likelihood(0,$pos_terms_count,$vocab_count);
				$neg_likelihood_visitor = $this->likelihood(0,$neg_terms_count,$vocab_count);
			}
			
			$total_pos_likelihood_visitor += $pos_likelihood_visitor;
			$total_neg_likelihood_visitor += $neg_likelihood_visitor;				
		}
		
		//posterior probability kelas positif dokumen C = log(prior probability) + total likelihood
		$pos_post_prob_visitor = $pos_prior_prob + $total_pos_likelihood_visitor;
		
		//posterior probability kelas negatif dokumen C = log(prior probability) + total likelihood
		$neg_post_prob_visitor = $neg_prior_prob + $total_neg_likelihood_visitor;
		
		//normalisasi log posterior probability
		$array_prob = $this->normalize_log($pos_post_prob_visitor,$neg_post_prob_visitor);
		$pos_post_prob_visitor = $array_prob["pos_prob"];
		$neg_post_prob_visitor = $array_prob["neg_prob"];
		
		//ambil kelas terbaik (kelas dengan posterior probability tertinggi)
		$best_class= $this->best_class($pos_post_prob_visitor,$neg_post_prob_visitor);
		
		//masukkan ke array results
		$array_results = array($pos_post_prob_visitor,$neg_post_prob_visitor,$best_class); 
	
		return $array_results;
	}
}
?>