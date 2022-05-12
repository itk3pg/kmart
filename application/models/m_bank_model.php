<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_bank_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataBank(){
		$query = "select id as kd_bank, nama_bank as keterangan from bank";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function SimpanBank($data){
		/**
		 * `kd_bank` varchar(4) NOT NULL,
  		   `keterangan` varchar(45) DEFAULT NULL
		 */
		$query = "insert into bank (id, nama_bank) values('".$data['kd_bank']."','".$data['keterangan']."')";
		
		$this->db->query($query);
	}
	
	function HapusBank($data){
		$query = "delete from bank where id='".$data['kd_bank']."'";
		
		$this->db->query($query);
	}
}
