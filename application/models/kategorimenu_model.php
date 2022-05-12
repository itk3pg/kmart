<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kategorimenu_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getChild($parent){
		$query = "";
		if($parent == ""){
			$query = "select kode, nama, keterangan from kategori_menu where is_hapus='0' and (parent='' or parent is null)";
		}else{
			$query = "select kode, nama, keterangan from kategori_menu where is_hapus='0' and parent='".$parent."'";
		}
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function simpankategori($data){
		$query = "";
		if($data['mode'] == "i"){ // insert
			$query = "insert into kategori_menu(kode, nama, is_hapus) values(UNIX_TIMESTAMP(), '".$data['nama']."', '0')";
		}else{ // update
			$query = "update kategori_menu set nama='".$data['nama']."' where kode='".$data['kode']."'";
		}
		$this->db->query($query);
	}
	
	function setparent($data){
		if($data['parent'] == "null"){
			$data['parent'] = "";
		}
		$query = "update kategori_menu set parent='".$data['parent']."' where kode='".$data['kode']."'";
		
		$this->db->query($query);
	}
	
	function HapusKategori($data){
		$queryUpdate = "update kategori_menu set parent='' where parent='".$data['kode']."'";
		$this->db->query($queryUpdate);
		
		$queryhapus = "update kategori_menu set is_hapus='1' where kode='".$data['kode']."'";
		$this->db->query($queryhapus);
	}
}