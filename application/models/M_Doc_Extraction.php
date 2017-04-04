<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Doc_Extraction extends CI_Model{

	private $arraykatadasar;

	/*------------TOKENIZING------------*/
	public function tokenizing($review){
		$lowercase = strtolower($review);
		$tokens = preg_replace('/[^a-z \-]/','', $lowercase);
		$tokens = preg_replace('/\s+/', ' ', $tokens);
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
	
	}

	//cek kombinasi awalan dan akhiran yang dilarang
	public function cek_restr_presuff($term){

		// be- dan -i
		if(preg_match('/^(be)[[:alpha:]]+(i)\z/i',$term)){
			return true;
		}
		
		// di- dan -an
		if(preg_match('/^(di)[[:alpha:]]+(an)\z/i',$term)){ 
			return true;
		}
		
		// ke- dan -i |-kan
		if(preg_match('/^(ke)[[:alpha:]]+(i|kan)\z/i',$term)){ 
			return true;
		}
		
		// me- dan -an
		if(preg_match('/^(me)[[:alpha:]]+(an)\z/i',$term)){
			return true;
		}

		// se- dan -i |-kan
		if(preg_match('/^(se)[[:alpha:]]+(i|kan)\z/i',$term)){ 
			return true;
		}

		return false;
	}


	//hilangkan derivation suffix ("-i","-an" atau "-kan")
	public function del_der_suff($term){
	
	}

	//hilangkan derivation prefix
	public function del_der_pre($term){
	
	}

	//aturan tambahan untuk kata ulang
	public function cek_reduplikasi($kata){

	}


	/*------------INSERT BAG OF WORDS KE DATABASE------------*/
	public function insertterm($id,$isi){

		$hasiltoken = $this->tokenizing($isi);
		$hasilfilter = $this->filtering($hasiltoken);
		$hasilstemming = $this->stemming($hasilfilter); 

		//insert ke database
		$this->db->insert('sa_bagofwords',['id_review'=>$id,'term_tokenized'=>$hasiltoken,'term_filtered'=>$hasilfilter,'term_stemmed'=>$hasilstemming]);

	}

	public function editterm($id,$isi){

		$hasiltoken = $this->tokenizing($isi);
		$hasilfilter = $this->filtering($hasiltoken);
		$hasilstemming = $this->stemming($hasilfilter); 

		//update database
		$this->db->where('id_review',$id);
		$this->db->update('sa_bagofwords',['term_tokenized'=>$hasiltoken,
			'term_filtered'=>$hasilfilter,'term_stemmed'=>$hasilstemming]);
	}


}
?>