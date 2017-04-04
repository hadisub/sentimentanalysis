<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_Authentication extends CI_Model
{

	public function checklogin($username, $password){
		$user = $this->db->get_where("sa_user", array("username"=>$username, "password"=>md5($password)))->row_array();

		if (count($user)>0){
		$logindata = array(
        'id' => $user["id"],
        'name'  => $user["nama"],
        'logged_in' => TRUE);

        $this->session->set_userdata($logindata);
			return true;
		}
		else{
			return false;
		}
		}

	public function logout	(){
		$this->session->unset_userdata(array("username","id", 'logged_in'));
	}
	}
?>