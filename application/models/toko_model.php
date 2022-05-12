<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Toko_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataToko(){
		$query = "select a.kode, a.nama, a.alamat, a.kota, a.npwp, a.notelp 
		from toko a where a.is_hapus='0' order by a.kode";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}

	function getDataKategori(){
		$query = "select a.kode, a.nama 
		from kategori_barang a where a.is_hapus='0' and a.parent is not null and a.parent<>''";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getAllDataToko(){
		$query = "select a.kode, a.nama, a.alamat, a.kota, a.npwp, a.notelp 
		from toko a where (a.is_hapus='0' or a.is_hapus='1') order by a.kode";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanToko($data){
		$query = "";
		//UNIX_TIMESTAMP()
		if($data['mode'] == "i"){
			$query = "insert into toko (kode, nama, alamat, kota, npwp, notelp, is_hapus) 
			values('".$data['kode']."','".$data['nama']."','".$data['alamat']."','".$data['kota']."','".$data['npwp']."','".$data['notelp']."','0')";
		}else{
			$query = "update toko set nama='".$data['nama']."', alamat='".$data['alamat']."', kota='".$data['kota']."', npwp='".$data['npwp']."', 
			notelp='".$data['notelp']."' where kode='".$data['kode']."'";
		}
		
		$this->db->query($query);
	}
	
	function HapusToko($data){
		$query = "update toko set is_hapus='1' where kode='".$data['kode']."'";
		
		$this->db->query($query);
	}
}