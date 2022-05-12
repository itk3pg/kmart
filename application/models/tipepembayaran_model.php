<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tipepembayaran_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataTipePembayaran(){
		$query = "select kode, nama from tipe_pembayaran";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanTipePembayaran($data){
		$query = "";
		if($data['mode'] == "i"){ // insert
			$query = "insert into tipe_pembayaran(kode, nama) values(UNIX_TIMESTAMP(), '".$data['nama']."')";
		}else{ // update
			$query = "update tipe_pembayaran set nama='".$data['nama']."' where kode='".$data['kode']."'";
		}
		$this->db->query($query);
	}
	
	function HapusTipePembayaran($data){
		$query = "delete from tipe_pembayaran where kode='".$data['kode']."'";
		
		$this->db->query($query);
	}
}