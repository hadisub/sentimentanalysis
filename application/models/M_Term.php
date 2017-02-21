<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Term extends CI_Model{

	private $katadasar;

	/*------------TOKENIZING------------*/
	public function tokenizing($review){
		$lowercase = strtolower($review);
		$tokens = preg_replace('/\s+/', ' ', $lowercase);
		$tokens = preg_replace('/[^a-z -]/','', $tokens);
		return $tokens;
		}


	/*------------FILTERING------------*/
	public function filtering($hasiltoken){
		//ubah string ke array
		$arraytoken = explode(" ",$hasiltoken);

		//ambil stop words dan diubah ke array
		$this->db->select('kata_stopwords');
		$this->db->from('sa_stopwords');
		$arraystopwords = $this->db->get()->result_array();

		//ubah ke associative array
		$arraystopwords= array_column($arraystopwords,'kata_stopwords');
		
		//bandingkan dua array
		$arrayfiltered = array_diff($arraytoken,$arraystopwords);
		
		//ubah hasil filter ke string
		$hasilfilter = implode(" ",$arrayfiltered);
		return $hasilfilter;
	}


	/*------------STEMMING------------*/
	public function stemming($hasilfiltered){

		//ubah string ke array
		$arrayfiltered = explode(" ",$hasilfiltered);
		$arraystemmed=array();
		
		//ambil katadasar words dan diubah ke array
		$this->db->select('kata_katadasar');
		$this->db->from('sa_katadasar');
		$arraykatdas = $this->db->get()->result_array();

		//ubah ke associative array
		$this->arraykatadasar = array_column($arraykatdas,'kata_katadasar');

		//looping
		foreach ($arrayfiltered as $kataawal){
			$term = $kataawal;
			$cekterm = $this->cekterm($term);
			if($cekterm==true){
				array_push($arraystemmed, $term);
				continue;
			}

			else{
				
				// //untuk kata berulang, hilangkan kata setelah hyphen (-)
				// if (preg_match('/(-)/',$term)){
				// $term = strtok($term,'-');
				// }
				
				$term = $this->del_inf_suff($term);
				$cekterm = $this->cekterm($term);
				if($cekterm==true){
					array_push($arraystemmed, $term);
					continue;

				}

				$term = $this->del_der_suff($term);
				$cekterm = $this->cekterm($term);
				if($cekterm==true){
					array_push($arraystemmed, $term);
					continue;
				}

				$term = $this->del_der_pre($term);
				$cekterm = $this->cekterm($term);
				if($cekterm==true){
					array_push($arraystemmed, $term);
					continue;
				}

				//jika setelah dipotong semua awalan dan akhiran tetap tidak ada
				//maka kata awal dimasukkan ke array hasil stem
				array_push($arraystemmed, $kataawal);
			}

		}

		$hasilstemming= implode(" ",$arraystemmed);
		return $hasilstemming;
	}


	/*------------NAZIEF ADRIANI------------*/

	//cek apakah term ada di tabel kata dasar
	public function cekterm($term){
		if(in_array($term,$this->arraykatadasar)){
			return true;
		}
		else{
			return false;
		}
	}

	//hilangkan inflection suffix ("-lah","-kah", "-ku", "-mu", atau "-nya")
	public function del_inf_suff($term){ 
		$thisterm = $term;
		if(preg_match('/([km]u|nya|[kl]ah|pun)\z/i',$term)){
			$__term = preg_replace('/([km]u|nya|[kl]ah|pun)\z/i','',$term);
			if(preg_match('/([kl]ah|pun)\z/i',$term)){
				if(preg_match('/([km]u|nya)\z/i',$term)){
					$__term__ = preg_replace('/([km]u|nya)\z/i','',$__term);
					return $__term__;
				}
			}
		return $__term;
		}
		return $thisterm;
	}

	//cek kombinasi awalan dan akhiran yang dilarang
	public function cek_restr_presuff($term){

		// be- dan -i
		if(preg_match('/^(be)[[:alpha:]]+(i)\z/i',$term)){
			return true;
		}

		// se- dan -i,-kan
		if(preg_match('/^(se)[[:alpha:]]+(i|kan)\z/i',$term)){ 
			return true;
		}
		
		// di- dan -an
		if(preg_match('/^(di)[[:alpha:]]+(an)\z/i',$term)){ 
			return true;
		}
		
		// me- dan -an
		if(preg_match('/^(me)[[:alpha:]]+(an)\z/i',$term)){
			return true;
		}
		
		// ke- dan -i,-kan
		if(preg_match('/^(ke)[[:alpha:]]+(i|kan)\z/i',$term)){ 
			return true;
		}
		return false;
	}


	//hilangkan derivation suffix ("-i","-an" atau "-kan")
	public function del_der_suff($term){
		$thisterm = $term; 
		if(preg_match('/(i|an)\z/i',$term)){
			
			//potong akhiran "-i" dan "-an"
			$__term = preg_replace('/(i|an)\z/i','',$term);
			if($this->cekterm($__term)){
				return $__term;
			} 
			//jika tidak ditemukan di array kata dasar, potong "-kan" 
			if(preg_match('/(kan)\z/i',$term)){
				$__term =preg_replace('/(kan)\z/i','',$term);
				if($this->cekterm($__term)){
					return $__term;
				}
			}
			//jika ada kombinasi awalan dan akhiran yang dilarang, return kata awal
			if($this->cek_restr_presuff($term)){
				return $thisterm;
			}
		}
		return $thisterm;
	}

	//hilangkan derivation prefix
	public function del_der_pre($term){
	$thisterm = $term; 

	//tentukan tipe awalan
		//jika "di-", "ke-" atau "se-"
		if(preg_match('/^(di|[ks]e)/',$term)){
			$__term = preg_replace('/^(di|[ks]e)/','',$term);
				if($this->cekterm($__term)){
					return $__term;
				}
			$__term__ = $this->del_der_suff($__term);
				if($this->cekterm($__term__)){
					return $__term__;
				}
		}

		//jika "diper-"
		if(preg_match('/^(diper)/',$term)){
			$__term = preg_replace('/^(diper)/','',$term);
				if($this->cekterm($__term)){
					return $__term;
				}
			$__term__ = $this->del_der_suff($__term);
				if($this->cekterm($__term__)){
					return $__term__;
				}
			//jika setelah "diper-" ada "r" luluh, ditambahkan "r" kembali di depan kata | diperingkas" -> "ringkas"
			 $__term = preg_replace('/^(diper)/','r',$term);
			 	if($this->cekterm($__term)){
					return $__term;
				}
			$__term__ + $this->del_der_suff($__term);
				if($this->cekterm($__term__)){
					return $__term__;
				}
		}


		//awalan "te-" "me-", "be-" atau "pe-"
		if(preg_match('/^([tmbp]e)/',$term)){

			//awalan "te-"
			if(preg_match('/^(te)/',$term)){
				
				//jika "terr-"
				if(preg_match('/^(terr)/',$term)){
	      			return $term;
	     		}

	     		//jika "ter-"
	     		if(preg_match('/^(ter)[abcdefghijklmnopqrstuvwxyz]/',$term)){
	     			$__term = preg_replace('/^(ter)/','',$term);
		     			if($this->cekterm($__term)){
		     				return $__term;
		     			}
	     			$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
	     		}

	     		if(preg_match('/^(ter[^aiueor]er[aiueo])/',$term)){
	     			$__term = preg_replace('/^(ter)/','',$term);
		     			if($this->cekterm($__term)){
		     				return $__term;
		     			}
	     			$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
	     		}

	     		if(preg_match('/^(ter[^aiueor]er[^aiueo])/',$term)){
	     			$__term = preg_replace('/^(ter)/','',$term);
		     			if($this->cekterm($__term)){
		     				return $__term;
		     			}
	     			$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
	     		}

	     		if(preg_match('/^(ter[^aiueor][^(er)])/',$term)){
	     			$__term = preg_replace('/^(ter)/','',$term);
		     			if($this->cekterm($__term)){
		     				return $__term;
		     			}
	     			$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
	     		}

	     		if(preg_match('/^(te[^aiueor]er[aiueo])/',$term)){
	     			return $term;
	     		}

	     		if(preg_match('/^(te[^aiueor]er[^aiueo])/',$term)){
	     			$__term = preg_replace('/^(te)/','',$term);
		     			if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
	     		}
			}

			//awalan "me-"
			if(preg_match('/^(me)/',$term)){

				//jika "meng-"
				if(preg_match('/^(meng)[aiueokghq]/',$term)){
					$__term = preg_replace('/^(meng)/','',$term);
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}

		     		//jika setelah "meng-" ada "k"  luluh, ditambahkan "k" kembali di depan kata | "mengawal" -> "kawal"
		     		$__term = preg_replace('/^(meng)/','k',$term);
		     			if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}
				
				//jika "meny-"
				if(preg_match('/^(meny)/',$term)){
					$__term = preg_replace('/^(meny)/','s',$term);
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "mem-"
				if(preg_match('/^(mem)[bfpv]/',$term)){
					$__term = preg_replace('/^(mem)/','',$term);
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}

		     		//jika setelah "mem-" ada "p"  luluh, ditambahkan "p" kembali di depan kata | "memaksa" -> "paksa"
		     		$__term = preg_replace('/^(mem)/','p',$term);
		     			if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				// jika "men-"
				if(preg_match('/^(men)[cdjsz]/',$term)){
					$__term = preg_replace('/^(men)/','',$term);
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "me-"
				if(preg_match('/^(me)/',$term)){
					$__term = preg_replace('/^(me)/','',$term);
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}

		     		//jika setelah "men-" ada "t"  luluh, ditambahkan "t" kembali di depan kata | "menawar" -> "tawar"
		     			$__term = preg_replace('/^(men)/','t',$term);
		     				if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}

				}
			}
			
			//awalan "be-"
			if(preg_match('/^(be)/', $term)){

				//jika "ber-"
				if(preg_match('/^(ber)[aiueo]/',$term)){
					$__term = preg_replace('/^(ber)/','',$term);
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
		     		//jika setelah "ber-" ada "r"  luluh, ditambahkan "r" kembali di depan kata | "berakit" -> "rakit"
		     		$__term = preg_replace('/^(ber)/','r',$term);
		     			if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "ber-" diikuti kata selain huruf vokal
				if(preg_match('/(ber)[^aiueo]/',$term)){
					 $__term = preg_replace('/(ber)/','',$term);
					 	if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika setelah "be-" ada "k", "k" dihilangkan
				if(preg_match('/^(be)[k]/',$term)){
					$__term = preg_replace('/^(be)/','',$term);
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

			}

			//awalan "pe-"
			if(preg_match('/^(pe)/',$term)){

				//jika "peng-"
				if(preg_match('/^(peng)[aiueokghq]/',$term)){
					$__term = preg_replace('/^(peng)/','',$term);
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "peny-"
				if(preg_match('/^(peny)/',$term)){
					$__term = preg_replace('/^(peny)/','s',$term);
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "pem-"
				if(preg_match('/^(pem)[bfpv]/',$term)){
					$__term = preg_replace('/^(pem)/','',$term);
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "pen-"
				if(preg_match('/^(pen)[cdjsz]/',$term)){
					$__term = preg_replace('/^(pen)/','',$term);
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}

		     		//jika setelah "pem-" ada "p"  luluh, ditambahkan "p" kembali di depan kata | "pemukul" -> "pukul"
		     		$__term = preg_replace('/^(pem)/','p',$term);
		     			if($this->cekterm($__term)){
		     				return $__term;
		     			}
				}

				//jika "per-"
				if(preg_match('/^(per)/',$term)){
					$__term = preg_replace('/^(per)/','',$term);
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
		     		//jika setelah "per-" ada "r"  luluh, ditambahkan "r" kembali di depan kata | "perawat" -> "rawat"
		     		$__term = preg_replace('/^(per)/','r',$term);
		     			if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "pe-"
				if(preg_match('/^(pe)/',$term)){
					 $__term = preg_replace('/^(pe)/','',$term);
					 	if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}
			}

			//awalan "memper-"
			if(preg_match('/^(memper)/',$term)){
				$__term = preg_replace('/^(memper)/','',$term);
					if($this->cekterm($__term)){
	     				return $__term;
	     			}
	     		$__term__ = $this->del_der_suff($__term);
	     			if($this->cekterm($__term__)){
	     				return $__term__;
	     			}

		     	//jika setelah "memper-" ada "r"  luluh, ditambahkan "r" kembali di depan kata | "memperumit" -> "rumit"
	     		$__term = preg_replace('/^(memper)/','r',$term);
	     			if($this->cekterm($__term)){
	     				return $__term;
	     			}
	     		$__term__ = $this->del_der_suff($__term);
	     			if($this->cekterm($__term__)){
	     				return $__term__;
	     			}
			}
		}
	//cek ada tidaknya awalan
		if(preg_match('/^(di|[kstbmp]e)/',$term) == FALSE){
			return $thisterm;
		}

	return $term;
	}



	/*------------INSERT TERM TO DATABASE------------*/
	public function insertterm($id,$isi){

		$hasiltoken = $this->tokenizing($isi);
		$hasilfilter = $this->filtering($hasiltoken);
		$hasilstemming = $this->stemming($hasilfilter); 

		//insert ke database
		$this->db->insert('sa_term',['id_review'=>$id,'term_tokenized'=>$hasiltoken,'term_filtered'=>$hasilfilter,'term_stemmed'=>$hasilstemming]);

	}

	public function editterm($id,$isi){

		$hasiltoken = $this->tokenizing($isi);
		$hasilfilter = $this->filtering($hasiltoken);
		$hasilstemming = $this->stemming($hasilfilter); 

		//update database
		$this->db->where('id_review',$id);
		$this->db->update('sa_term',['term_tokenized'=>$hasiltoken,
			'term_filtered'=>$hasilfilter,'term_stemmed'=>$hasilstemming]);
	}

	/*------------DASHBOARD------------*/

	//count total reviews
	public function count_total_review(){
		$this->db->select('id_review');
		$this->db->from('sa_review');
		$total_review = $this->db->count_all_results();
		return $total_review;
	}

	//count total positive reviews
	public function count_pos_review(){
		$this->db->select('id_review');
		$this->db->from('sa_review');
		$this->db->where('sentimen_review','POSITIF');
		$total_pos_review = $this->db->count_all_results();
		return $total_pos_review;
	}

	//count total negative reviews
	public function count_neg_review(){
		$this->db->select('id_review');
		$this->db->from('sa_review');
		$this->db->where('sentimen_review','NEGATIF');
		$total_neg_review = $this->db->count_all_results();
		return $total_neg_review;
	}

	//get all IDs of data uji reviews
	public function get_id_uji(){
		$this->db->select('id_review');
		$this->db->from('sa_review');
		$this->db->where('kategori_review','DATA UJI');
		$this->db->order_by('judul_review','ASC');
		$array_id_uji = $this->db->get()->result_array();
		$array_id_uji = array_column($array_id_uji,'id_review');
		return $array_id_uji;
	}

	/*------------TERMS------------*/
	//get an array of terms from all reviews
	public function array_terms(){
		$this->db->select('term_stemmed');
		$this->db->from('sa_term');
		$array_terms = $this->db->get()->result_array();
		$array_terms= array_column($array_terms,'term_stemmed');
		$all_terms = implode(" ",$array_terms);
		$array_terms = explode(" ",$all_terms);
		return $array_terms;
	}

	//get an array of terms from positive reviews
	public function array_pos_terms(){
		$this->db->select('term_stemmed');
		$this->db->from('sa_term');
		$this->db->join('sa_review', 'sa_review.id_review = sa_term.id_review');
		$this->db->where('sa_review.sentimen_review','POSITIF');
		$array_pos_terms = $this->db->get()->result_array();
		$array_pos_terms= array_column($array_pos_terms,'term_stemmed');
		$all_pos_terms = implode(" ",$array_pos_terms);
		$array_pos_terms = explode(" ",$all_pos_terms);
		return $array_pos_terms;
	}

	//get an array of terms from negative reviews
	public function array_neg_terms(){
		$this->db->select('term_stemmed');
		$this->db->from('sa_term');
		$this->db->join('sa_review', 'sa_review.id_review = sa_term.id_review');
		$this->db->where('sa_review.sentimen_review','NEGATIF');
		$array_neg_terms = $this->db->get()->result_array();
		$array_neg_terms= array_column($array_neg_terms,'term_stemmed');
		$all_neg_terms = implode(" ",$array_neg_terms);
		$array_neg_terms = explode(" ",$all_neg_terms);
		return $array_neg_terms;
	}

	//count total terms of dataset
	public function count_total_terms(){
		$array_terms = $this->array_terms();	
		$total_terms = count($array_terms);
		return $total_terms;
	}

	//count total terms from positive review
	public function count_total_pos_terms(){
		$array_pos_terms = $this->array_pos_terms();
		$total_pos_terms = count($array_pos_terms);
		return $total_pos_terms;
	}

	//count total term from negative review
	public function count_total_neg_terms(){
		$array_neg_terms = $this->array_neg_terms();
		$total_neg_terms = count($array_neg_terms);
		return $total_neg_terms;
	}

	//find the most common term
	public function most_term(){
		$this->db->select('term_stemmed');
		$this->db->from('sa_term');
		$array_terms = $this->db->get()->result_array();
		$array_terms = array_column($array_terms,'term_stemmed');
		$all_terms = implode(" ",$array_terms);
		$array_terms = explode(" ",$all_terms);
		$array_terms = array_count_values($array_terms);
		arsort($array_terms);
		$most_term = key($array_terms);
		return $most_term;
	}

	//function to count the number of occurences of term
	public function occurences($term, $array_terms){
		$occurences=0;
		foreach ($array_terms as $key) {
			if($key==$term){
				$occurences++;
			}
		}
		// $arraytmp = array_count_values($arrayterms);
		// $occurences = $arraytmp[$term];
		return $occurences;
	}

	//get a number of unique terms from all reviews (vocabulary)
	public function vocabulary(){
		$array_terms = $this->array_terms();
		$vocabulary = array_unique($array_terms);
		$arrayvocabulary = array();
		foreach ($vocabulary as $unique_term) {
			array_push($arrayvocabulary,$unique_term);
		}
		return $arrayvocabulary;
	}

	
	/*------------PRIOR PROBABILITY------------*/
	//prior probability for positive review: pos reviews/total reviews
	public function pos_prior_prob(){
		$pos_prior_prob = $this->count_pos_review() / $this->count_total_review();
		return $pos_prior_prob;
	}

	//prior probability for negative review: neg reviews/total reviews
	public function neg_prior_prob(){
		$neg_post_prob = $this->count_neg_review() / $this->count_total_review();
		return $neg_post_prob;
	}

	/*------------POSTERIOR PROBABILITY------------*/
	//count the positive posterior probability of a term in positive review
	public function pos_post_prob($term){
		//n_k = number of term's occurences in positive reviews
		$array_pos_terms = $this->array_pos_terms();
		$n_k = $this->occurences($term,$array_pos_terms);
		
		//n = total of terms in positive reviews
		$n = $this->count_total_pos_terms();

		//vocabulary = total of unique terms (vocabulary of terms)
		$vocab = count($this->vocabulary());

		/*term's posterior probability of positive class = (number of term's occurences in positive reviews + 1)/(total of terms in positive reviews + total of unique terms)*/
		$pos_post_prob = ($n_k + 1) / ($n + $vocab);
		return $pos_post_prob;
	}

	//count the negative posterior probability of a term in negative review
	public function neg_post_prob($term){
		//n_k = number of term's occurences in negative reviews
		$array_neg_terms = $this->array_neg_terms();
		$n_k = $this->occurences($term,$array_neg_terms);
		
		//n = total of terms in negative reviews
		$n = $this->count_total_neg_terms();

		//vocabulary = total of unique terms (vocabulary of terms)
		$vocab = count($this->vocabulary());

		/*term's posterior probability of negative class = (number of term's occurences in negative reviews + 1)/(total of terms in negative reviews + total of unique terms)*/
		$neg_prior_prob = ($n_k+1)/($n+$vocab);
		return $neg_prior_prob;
	}

	/*------------TRAIN DATA------------*/

	public function train_pos_post_prob(){
		$array_pos = array();
		$vocab = $this->vocabulary();
		foreach ($vocab as $term) {
			$array_pos[$term] = $this->pos_post_prob($term);
		}

		return $array_pos;
	}

}
?>