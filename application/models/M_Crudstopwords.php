<?php

class M_Crudstopwords extends CI_Model
{
	
public function inputstopwords($katabaru){
	$insert_stopwords_baru = $this->db->insert('sa_stopwords',['kata_stopwords'=>$katabaru]);
	return $insert_stopwords_baru;
	}

public function deletestopwords($idstopwords){
	$delete_stopwords = $this->db->delete('sa_stopwords',['id_stopwords'=>$idstopwords]);
	return $delete_stopwords;
	}

public function editstopwords($stopwords,$idstopwords){
	$this->db->where('id_stopwords',$idstopwords);
	$edit_stopwords = $this->db->update('sa_stopwords',['kata_stopwords'=>$stopwords]);
	return $edit_stopwords;
	}
}
?>