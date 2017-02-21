<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Crudkatadasar extends CI_Model
{
	
public function inputkatadasar($katabaru){
	$insert_katadasar_baru = $this->db->insert('sa_katadasar',['kata_katadasar'=>$katabaru]);
	return $insert_katadasar_baru;
	}

public function deletekatadasar($idkatadasar){
	$delete_katadasar = $this->db->delete('sa_katadasar',['id_katadasar'=>$idkatadasar]);
	return $delete_katadasar;
	}
	
public function editkatadasar($katadasar,$idkatadasar){
	$this->db->where('id_katadasar',$idkatadasar);
	$edit_katadasar = $this->db->update('sa_katadasar',['kata_katadasar'=>$katadasar]);
	return $edit_katadasar;
	}

}
?>