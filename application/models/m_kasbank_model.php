<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_kasbank_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataKasbank(){
		$query = "select kd_kb, keterangan from m_kb";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function SimpanKasbank($data){
		/**
		 * `kd_kb` varchar(4) NOT NULL,
  		   `keterangan` varchar(45) DEFAULT NULL
		 */
		$query = "insert into m_kb values('".$data['kd_kb']."','".$data['keterangan']."')";
		
		$this->db->query($query);
	}
	
	function HapusKasbank($data){
		$query = "delete from m_kb where kd_kb='".$data['kd_kb']."'";
		
		$this->db->query($query);
	}
}
