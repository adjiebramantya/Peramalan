<?php
class M_login extends CI_Model{
	function cek_login($table,$where){
		return $this->db->get_where($table,$where);
	}

    function input_data($data,$table){
      $this->db->insert($table,$data);
    }
		function tampil_profil($where,$table){
			return $this->db->get_where($table,$where);
		}

		function update_data($where,$data,$table){
			$this->db->where($where);
			$this->db->update($table,$data);
		}

}
 ?>
