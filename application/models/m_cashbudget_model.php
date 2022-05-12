<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_cashbudget_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataCashbudget(){
		$query = "select kd_cb, keterangan from m_cb";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function SimpanCashbudget($data){
		/**
		 * `kd_cb` varchar(4) NOT NULL,
		  `keterangan` varchar(45) DEFAULT NULL,
		  `status` varchar(1) DEFAULT NULL,
		  `is_hapus` varchar(1) DEFAULT NULL
		 */
		$query = "insert into m_cb values('".$data['kd_cb']."','".mysql_real_escape_string(urldecode($data['keterangan']))."','','0') on duplicate key update keterangan='".mysql_real_escape_string(urldecode($data['keterangan']))."'";
		
		$this->db->query($query);
	}
	
	function HapusCashbudget($data){
		$query = "delete from m_cb where kd_cb='".$data['kd_cb']."'";
		
		$this->db->query($query);
	}
}
