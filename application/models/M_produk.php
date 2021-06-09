<?php
class M_produk extends CI_Model{
	function tampil_produk(){
		$this->db->select('produk.*, produk.jenis_produk as id_jenis, jenis_produk.nama_jenis as jenis_produk');
		$this->db->from('produk');
		$this->db->join('jenis_produk', 'jenis_produk.id_jenis = produk.jenis_produk');
		return $this->db->get();
	}

	function orderBySatuan(){
		$this->db->select('produk.*, jenis_produk.nama_jenis as jenis_produk');
		$this->db->from('produk');
		$this->db->join('jenis_produk', 'jenis_produk.id_jenis = produk.jenis_produk');
		$this->db->where('jenis_produk = 2');
		return $this->db->get();
	}

	function orderByPaket(){
		$this->db->select('produk.*, jenis_produk.nama_jenis as jenis_produk');
		$this->db->from('produk');
		$this->db->join('jenis_produk', 'jenis_produk.id_jenis = produk.jenis_produk');
		$this->db->where('jenis_produk = 1');
		return $this->db->get();
	}

	function input_data($data,$table){
		$this->db->insert($table,$data);
	}

  function hapus_data($where,$table){
  	$this->db->where($where);
  	$this->db->delete($table);
  }

  function edit_data($where,$table){
		return $this->db->get_where($table,$where);
	}

  function update_data($where,$data,$table){
    $this->db->where($where);
    $this->db->update($table,$data);
  }
}
 ?>
