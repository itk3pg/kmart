<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jasa_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataJasa(){
		$query = "select a.kode, a.nama_jasa from jasa a where a.is_hapus='0'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getListDataJasa($data){
		$query = "select a.kode, a.nama_jasa from jasa a 
		where a.is_hapus='0' and a.nama_jasa like '".$data['q']."%'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanJasa($data){
		$query = "";
		
		if($data['mode'] == "i"){
			$query = "insert into jasa (kode, nama_jasa, is_hapus) 
			values('".$data['kode']."','".$data['nama_jasa']."','0')";
		}else{
			$query = "update jasa set nama_jasa='".$data['nama_jasa']."' where kode='".$data['kode']."'";
		}
		
		$this->db->query($query);
	}
	
	function HapusJasa($data){
		$query = "update jasa set is_hapus='1' where kode='".$data['kode']."'";
		
		$this->db->query($query);
	}
}