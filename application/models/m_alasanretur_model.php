<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_alasanretur_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataAlasanretur(){
		$query = "select kode as kd_alasanretur, keterangan as keterangan from alasan_retur";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function SimpanAlasanretur($data){
		/**
		 * `kd_alasan_retur` varchar(4) NOT NULL,
  		   `keterangan` varchar(45) DEFAULT NULL
		 */
		$query = "insert into alasan_retur (kode, keterangan) values('".$data['kode']."','".$data['keterangan']."')";
		
		$this->db->query($query);
	}
	
	function HapusAlasanretur($data){
		$query = "delete from alasan_retur where kode='".$data['kode']."'";
		
		$this->db->query($query);
	}
}
