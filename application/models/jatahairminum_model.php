<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jatahairminum_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataAirMinum($data){
		$query = "select bulan, tahun, no_pegawai, nama_pegawai, kode_unit_kerja, nama_unit_kerja, jumlah_hari, waktu_update from jatah_airminum where bulan=".$data['bulan']." and tahun=".$data['tahun']." order by kode_unit_kerja";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getJumlahDataAirMinum($data){
		$query = "select bulan, tahun, sum(jumlah_hari) as jumlah_hari, sum(jumlah_hari*2) as jumlah_botol from jatah_airminum where bulan=".$data['bulan']." and tahun=".$data['tahun']." group by bulan, tahun";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function SimpanJatahAirMinum($post, $data){
		$query = "insert into jatah_airminum(bulan, tahun, no_pegawai, nama_pegawai, jumlah_hari, kode_unit_kerja, nama_unit_kerja, waktu_update) values(".$post['upload_bulan'].", ".$post['upload_tahun'].", '".$data[0]."', '".$this->db->escape_str($data[1])."', ".$data[2].", '".$data[3]."', '".$this->db->escape_str($data[4])."', NOW()) on duplicate key update nama_pegawai='".$this->db->escape_str($data[1])."', jumlah_hari=".$data[2].", kode_unit_kerja='".$data[3]."', nama_unit_kerja='".$this->db->escape_str($data[4])."'";
		
		$this->db->query($query);
	}
}

?>