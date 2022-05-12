<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Satuanbarang_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataSatuan(){
		$query = "select kode, nama from satuan_barang where is_hapus='0'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanSatuan($data){
		$query = "";
		if($data['mode'] == "i"){ // insert
			$query = "insert into satuan_barang(kode, nama, is_hapus) values(UNIX_TIMESTAMP(), '".$data['nama']."', '0')";
		}else{ // update
			$query = "update satuan_barang set nama='".$data['nama']."' where kode='".$data['kode']."'";
		}
		$this->db->query($query);
	}
	
	function HapusSatuan($data){
		$query = "update satuan_barang set is_hapus='1'";
		
		$this->db->query($query);
	}
}