<?php
class M_barangMasuk extends CI_Model{
	function tampil_barangMasuk(){
		$this->db->select("barang_masuk.*, produk.nama_produk as nama_produk, DATE_FORMAT(tanggal, '%d/%m/%Y') as tanggal");
		$this->db->from('barang_masuk');
		$this->db->join('produk', 'barang_masuk.id_produk = produk.id_produk');
		return $this->db->get();
	}

	function rinci_barangMasuk($bulan,$tahun){
		$this->db->select("barang_masuk.*, produk.nama_produk as nama_produk, DATE_FORMAT(tanggal, '%d/%m/%Y') as tanggal");
		$this->db->from('barang_masuk');
		$this->db->join('produk', 'barang_masuk.id_produk = produk.id_produk');
		$this->db->where('month(tanggal)',$bulan);
		$this->db->where('year(tanggal)',$bulan);
		return $this->db->get();
	}

	function tahun(){
		$this->db->select("barang_masuk.*, produk.nama_produk as nama_produk, year(tanggal) as tanggal");
		$this->db->from('barang_masuk');
		$this->db->join('produk', 'barang_masuk.id_produk = produk.id_produk');
		$this->db->group_by('year(tanggal)');
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
