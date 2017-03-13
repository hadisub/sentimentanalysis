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
		foreach ($arrayfiltered as $kataawal){
			$term = $kataawal;
			
			if(strlen($term)<=3){ //jangan stem kata di bawah tiga huruf
				array_push($arraystemmed,$term);
				continue;
			}

			$cekterm = $this->cekterm($term);
			if($cekterm==true){
				array_push($arraystemmed, $term);
				continue;
			}

			else{

				if(preg_match('/\-/',$term)){ //stem untuk kata ulang
					$split = explode("-",$term);
					$katasatu = $split[0];
					$katadua = $split[1];

					if($katasatu==$katadua){
						$term = $katasatu;
						array_push($arraystemmed, $term);
						continue;
					}
					else{
						$katasatu = $this->cek_reduplikasi($katasatu);
						$katadua = $this->cek_reduplikasi($katadua);
						if($katasatu==$katadua){
							array_push($arraystemmed, $katasatu);
						}
						else{
							array_push($arraystemmed, $katasatu);
							array_push($arraystemmed, $katadua);
						}
						continue;
					}
				}

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
			if(preg_match('/([klt]ah|pun)\z/i',$term)){
				if(preg_match('/([km]u|nya)\z/i',$__term)){
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
		$thisterm = $term; 

		//hilangkan akhiran "-kan"
		if(preg_match('/(kan)\z/i',$term)){
			$__term = preg_replace('/(kan)\z/i','',$term);
			if($this->cekterm($__term)){
				return $__term;
			}
		}

		//hilangkan akhiran "an"|"i"
		if(preg_match('/(i|an)\z/i',$term)){
			$__term = preg_replace('/(i|an)\z/i','',$term);
			if($this->cekterm($__term)){
				return $__term;
			}
		}
		//jika ada kombinasi awalan dan akhiran yang dilarang, return kata awal
		if($this->cek_restr_presuff($term)){
			return $term;
		}
		return $thisterm;
	}

	//hilangkan derivation prefix
	public function del_der_pre($term){
	$thisterm = $term;
	if(strlen($term)>=5){ //jumlah huruf minimal dari kata yang akan dipotong prefiksnya adalah 5 

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


		//awalan "be-" "me-", "pe-" atau "te-"
		if(preg_match('/^([btmp]e)/',$term)){

			//awalan "be-"
			if(preg_match('/^(be)/', $term)){

				//jika "ber-"
				if(preg_match('/^(ber)[aiueo]/',$term)){ //ATURAN 1 berV | ber-V
					$__term = preg_replace('/^(ber)/','',$term);
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
		     		//jika setelah "ber-" ada "r"  luluh, ditambahkan "r" kembali di depan kata | "berakit" -> "rakit"
		     		$__term = preg_replace('/^(ber)/','r',$term); //ATURAN 1 berV.. > ber-V.. | be-rV..
		     			if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "ber-" diikuti huruf konsonan selain "r" dan huruf apa saja lalu partikel selain "er"
				if(preg_match('/^(ber)[^aiueor][a-z](?!er)/',$term)){
					 $__term = preg_replace('/^(ber)/','',$term); //ATURAN 2 berCAP.. > ber-CAP.. di mana C!='r' & P!='er'
					 	if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "ber-" diikuti huruf selain "r" dan partikel "er" lalu huruf vokal
				if(preg_match('/^(ber)[^r][a-z]er[aiueo]/',$term)){ 
					$__term = preg_replace('/^(ber)/','',$term); //ATURAN 3 berCAerV.. | ber-CAerV.. di mana C!='r'
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "belajar"
				if(preg_match('/\b(belajar)\b/',$term)){ 
					$__term = preg_replace('/^(bel)/','',$term); //ATURAN 4 belajar > bel-ajar
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "ber-" diikuti huruf selain "r","l" dan partikel "er" lalu huruf konsonan
				if(preg_match('/^(be)[^rl]er[^aiueo]/',$term)){ 
					$__term = preg_replace('/^(be)/','',$term); //ATURAN 5 beC1erC2.. > be-C1erC2.. di mana C1!='r' | 'l'
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

			}

			//awalan "te-"
			if(preg_match('/^(te)/',$term)){

	     		//jika "ter-" diikuti huruf vokal
	     		if(preg_match('/^(ter)[aiueo]/',$term)){
	     			$__term = preg_replace('/^(ter)/','',$term); //ATURAN 6 terV.. > ter-V |te-rV
		     			if($this->cekterm($__term)){
		     				return $__term;
		     			}
	     			$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
		     		//jika setelah "ter-" ada "r"  luluh, ditambahkan "r" kembali di depan kata | "terawat" -> "rawat"
		     		$__term = preg_replace('/^(ter)/','r',$term);
		     			if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
	     		}

	     		//jika "ter-" diikuti huruf konsonan selain "r" dan partikel "er" lalu huruf vokal
	     		if(preg_match('/^(ter)[^aiueor]er[aiueo]/',$term)){
	     			$__term = preg_replace('/^(ter)/','',$term); //ATURAN 7 terCerV.. > ter-CerV.. di mana C!='r'
		     			if($this->cekterm($__term)){
		     				return $__term;
		     			}
	     			$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
	     		}

	     		//jika "ter-" diikuti huruf selain "r" dan partikel selain "er"
	     		if(preg_match('/^(ter)[^r](?!er)/',$term)){
	     			$__term = preg_replace('/^(ter)/','',$term); //ATURAN 8 terCP.. > ter-CP.. di mana C!='r' & P!='er'
		     			if($this->cekterm($__term)){
		     				return $__term;
		     			}
	     			$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
	     		}

	     		//jika "te-" diikuti huruf konsonan selain "r" dan partikel "er" lalu huruf konsonan
	     		if(preg_match('/^(te)[^aiueor]er[^aiueo]/',$term)){
	     			$__term = preg_replace('/^(te)/','',$term); //ATURAN 9 teC1erC2.. > te-C1erC2.. di mana C!='r'
		     			if($this->cekterm($__term)){
		     				return $__term;
		     			}
	     			$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
	     		}

	     		//jika "te-" diikuti huruf konsonan selain "r" dan partikel "er" lalu huruf konsonan
	     		if(preg_match('/^(te)[^aiueor]er[^aiueo]/',$term)){
	     			$__term = preg_replace('/^(ter)/','',$term); //ATURAN 34 terC1erC2.. > ter-C1erC2.. di mana C!='r'
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

				//jika "me-" diikuti huruf "l","r","w","y" dan huruf vokal
				if(preg_match('/^(me)[lrwy][aiueo]/',$term)){
					$__term = preg_replace('/^(me)/','',$term); //ATURAN 10 me{l|r|w|y}V.. > me-{l|r|w|y}V..
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}
				
				//jika "mem-" diikuti huruf "b","f","v"
				if(preg_match('/^(mem)[bfv]/',$term)){
					$__term = preg_replace('/^(mem)/','',$term); //ATURAN 11 mem{b|f|v}.. > mem-{b|f|v}..
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "mempe-"
				if(preg_match('/^(mempe)[lr]/',$term)){
					$__term = preg_replace('/^(mempe)[lr]/','',$term); //ATURAN 12 mempe{l|r}.. > mempe{l|r}-..
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

					//jika "mem-" diikuti oleh huruf vokal atau huruf "r"
				if(preg_match('/^(mem)[aiueor]/',$term)){
		     		$__term = preg_replace('/^(me)/','',$term); //ATURAN 13 mem{rV|V}.. > me-m{rV|V}.. | me-p{rV|V}..
		     			if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
		     		//jika setelah "mem-" ada "p"  luluh, ditambahkan "p" kembali di depan kata | "memutar" -> "putar"
		     		$__term = preg_replace('/^(mem)/','p',$term);
		     			if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				// jika "men-" diikuti huruf "c","j","d","z"
				if(preg_match('/^(men)[cdjsz]/',$term)){
					$__term = preg_replace('/^(men)/','',$term); //ATURAN 14 men{c|d|j|s|z}.. > men-{c|d|j|s|z}..
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "men-" diikuti oleh huruf vokal
				if(preg_match('/^(men)[aiueo]/',$term)){
					$__term = preg_replace('/^(me)/','',$term); //ATURAN 15 menV.. > me-nV | me-tV ..
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}

		     		//jika setelah "men-" ada "t"  luluh, ditambahkan "t" kembali di depan kata | "menarik" -> "tarik"
		     		$__term = preg_replace('/^(men)/','t',$term);
		     				if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}

				}

				// jika "meng-" diikuti huruf "g","h","q"
				if(preg_match('/^(meng)[ghq]/',$term)){
					$__term = preg_replace('/^(meng)/','',$term); //ATURAN 16 meng{g|h|q}.. > meng-{g|h|q}..
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				// jika "meng-" diikuti huruf vokal				
				if(preg_match('/^(meng)[aiueo]/',$term)){
					$__term = preg_replace('/^(meng)/','',$term); //ATURAN 17 mengV.. > meng-V.. |meng-kV..
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}

		     		//jika setelah "meng-" ada "k"  luluh, ditambahkan "k" kembali di depan kata | "mengikis" -> "kikis"
		     		$__term = preg_replace('/^(meng)/','k',$term);
		     				if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "meny-" diikuti huruf vokal
				if(preg_match('/^(meny)[aiueo]/',$term)){
					$__term = preg_replace('/^(meny)/','s',$term); //ATURAN 18 menyV.. > meny-sV..
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "memp-" diikuti huruf vokal apapun selain "e"
				if(preg_match('/^(memp)[aiuo]/',$term)){
					$__term = preg_replace('/^(mem)/','',$term); //ATURAN 19 mempA.. > mem-pA di mana A!='e'..
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

				//jika "pe-" diikuti huruf "w","y" atau huruf vokal
				if(preg_match('/^(pe)[wy][aiueo]/',$term)){
					$__term = preg_replace('/^(pe)/','',$term); //ATURAN 20 pe{w|y|}V.. > pe-{w|y}V..
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "per-" diikuti huruf vokal
				if(preg_match('/^(per)[aiueo]/',$term)){
					$__term = preg_replace('/^(per)/','',$term); //ATURAN 21 perV.. > per-V | pe-rV..
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
		     		
		     		//jika setelah "per-" ada "r"  luluh, ditambahkan "r" kembali di depan kata | "perantau" -> "rantau"
		     		$__term = preg_replace('/^(per)/','r',$term);
		     				if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "per-" diikuti huruf konsonan selain "r" dan huruf apapun lalu partikel selain "er"
				if(preg_match('/^(per)[^aiueor]+[a-z]+(?!er)/',$term)){
					$__term = preg_replace('/^(per)/','',$term); //ATURAN 22 perCAP.. > per-CAP di mana C!="r" & P!="er"
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "per-" diikuti huruf konsonan selain "r" dan huruf apapun lalu partikel selain "er"
				if(preg_match('/^(per)[^aiueor][a-z]er[aiueo]/',$term)){
					$__term = preg_replace('/^(per)/','',$term); //ATURAN 23 perCAerV.. > per-CAerV di mana C!="r"
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "pem-" diikuti "r"huruf vokal atau huruf vokal
				if(preg_match('/^pemr?[aiueo]/',$term)){
					$__term = preg_replace('/^(pe)/','',$term); //ATURAN 25 pem{rV|V}.. > pe-m{rV|V}.. | pe-p{rV|V}..
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
		     		
		     		//jika setelah "pem-" ada "p"  luluh, ditambahkan "p" kembali di depan kata | "pemprakarsa" -> "prakarsa"
		     		$__term = preg_replace('/^(pem)/','p',$term);
		     				if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "pem-" diikuti huruf "b","v" atau huruf vokal
				if(preg_match('/^(pem)[bfaiueo]/',$term)){
					$__term = preg_replace('/^(pem)/','',$term); //ATURAN 24 pem{b|f|V}.. > pem-{b|f|V}..
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "pen-" diikuti huruf "c","d","j","z"
				if(preg_match('/^(pen)[cdjsz]/',$term)){
					$__term = preg_replace('/^(pen)/','',$term); //ATURAN 26 pen{c|d|j|z}.. > pen-{c|d|j|z}..
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "pen-" diikuti huruf vokal
				if(preg_match('/^(pen)[aiueo]/',$term)){
					$__term = preg_replace('/^(pe)/','',$term); //ATURAN 27 penV.. > pe-nV.. | pe-tV..
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}

		     		//jika setelah "pen-" ada "t"  luluh, ditambahkan "t" kembali di depan kata | "penonton" -> "tonton"
		     		$__term = preg_replace('/^(pen)/','t',$term);
		     				if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "peng-" diikuti huruf konsonan
				if(preg_match('/^(peng)[^aiueo]/',$term)){
					$__term = preg_replace('/^(peng)/','',$term); //ATURAN 28 pengC.. > peng-C..
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "peng-" diikuti huruf vokal
				if(preg_match('/^(peng)[aiueo]/',$term)){
					if(preg_match('/^(peng)[e]/',$term)){
						$__term = preg_replace('/^(penge)/','',$term);
		     				if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     			$__term__ = $this->del_der_suff($__term);
		     				if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
					}
					$__term = preg_replace('/^(peng)/','',$term);  //ATURAN 29 pengV.. > peng-V.. | peng-kV.. | pengV- jika V="e"
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}

		     		//jika setelah "peng-" ada "k"  luluh, ditambahkan "k" kembali di depan kata | "pengawal" -> "kawal"
		     		$__term = preg_replace('/^(peng)/','k',$term);
		     				if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "peny-" diikuti huruf vokal
				if(preg_match('/^(peny)[aiueo]/',$term)){
					$__term = preg_replace('/^(peny)/','s',$term); //ATURAN 30 penyV.. > peny-sV..
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "pel-" diikuti huruf vokal & jika "pelajar"
				if(preg_match('/^(pel)[aiueo]/',$term)){
					if(preg_match('/\b(pelajar)\b/',$term)){
						$__term = preg_replace('/^(pel)/','',$term); //ATURAN 31 pelV.. > pe-lV.. kecuali pelajar > pel-ajar
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     			$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
					}

					$__term = preg_replace('/^(pe)/','',$term);
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "pe-" diikuti konsonan selain "r","w","y","l","m","n" dan partikel "er" lalu huruf vokal
				if(preg_match('/^(pe)[^aiueorwylmn]er[aiueo]/',$term)){
					$__term = preg_replace('/^(per)/','',$term); //ATURAN 32 peCerV.. > per-erV.. di mana C!= {r|w|y|l|m|n}
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "pe-" diikuti konsonan selain "r","w","y","l","m","n" dan partikel selain "er"
				if(preg_match('/^(pe)[^aiueorwylmn](?!er)/',$term)){
					$__term = preg_replace('/^(pe)/','',$term); //ATURAN 33 peCP.. > pe-CP.. di mana P!= "er"
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

				//jika "pe-" diikuti konsonan selain "r","w","y","l","m","n" dan partikel selain "er"
				if(preg_match('/^(pe)[^aiueorwylmn]er[^aiueo]/',$term)){
					$__term = preg_replace('/^(pe)/','',$term); //ATURAN 35 peC1erC2.. > pe-CP.. di mana C1!= {r|w|y|l|m|n}
						if($this->cekterm($__term)){
		     				return $__term;
		     			}
		     		$__term__ = $this->del_der_suff($__term);
		     			if($this->cekterm($__term__)){
		     				return $__term__;
		     			}
				}

			}
		}
		//cek ada tidaknya awalan di-, ke-, se-, te-, be-, me- atau pe-
		if(preg_match('/^(di|[kstbmp]e)/',$term) == false){
			return $term;
		}

	}
	
	return $thisterm;
	}

	//aturan tambahan untuk kata ulang
	public function cek_reduplikasi($kata){
		$term = $this->del_inf_suff($kata);
		$cekterm = $this->cekterm($term);
		if($cekterm==true){
			return $term;
		}

		$term = $this->del_der_suff($term);
		$cekterm = $this->cekterm($term);
		if($cekterm==true){
			return $term;
		}

		$term = $this->del_der_pre($term);
		$cekterm = $this->cekterm($term);
		if($cekterm==true){
			return $term;
		}
		return $kata;
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