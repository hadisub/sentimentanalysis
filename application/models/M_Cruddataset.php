<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Cruddataset extends CI_Model
{


public function inputdataset($judulreview,$isireview,$kategori,$sentimenawal){
	$this->db->insert('sa_review',['judul_review'=>$judulreview,
		'isi_review'=>$isireview,'kategori_review'=>$kategori,'sentimen_review'=>$sentimenawal]);
		return $this->db->insert_id();
	}

public function deletedataset($idreview){
	$delete_review = $this->db->delete('sa_review',['id_review'=>$idreview]);
	return $delete_review;
	}

public function editdataset($judulreview,$isireview,$kategori,$sentimenawal,$idreview){
	$this->db->where('id_review',$idreview);
	$edit_review = $this->db->update('sa_review',['judul_review'=>$judulreview,
		'isi_review'=>$isireview,'kategori_review'=>$kategori,'sentimen_review'=>$sentimenawal]);
	return $edit_review;
	}

}
?>