<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Minmax_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataMinmax($data){
		$query = "select a.barang_kode, b.barcode, b.nama_barang, a.toko_kode, a.min, a.max, a.minor from minmax_stok_barang a left join barang b on a.barang_kode=b.kode where a.toko_kode='".$data['toko_kode']."' 
		order by a.barang_kode";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanMinmax($data){
		$username = $this->session->userdata('username');
		
		$query = "insert into minmax_stok_barang (barang_kode, toko_kode, min, max, minor, waktu_insert, waktu_update, user_id) values('".$data['barang_kode']."','".$data['toko_kode']."',".$data['min'].",".$data['max'].",".$data['minor'].", NOW(), NOW(),'".$username."') on duplicate key update min=".$data['min'].", max=".$data['max'].", minor=".$data['minor'].", waktu_update=NOW(), user_id='".$username."'";
		
		$this->db->query($query);
	}
	
	function HapusMinmax($data){
		$queryDelete = "delete from minmax_stok_barang where barang_kode='".$data['barang_kode']."' and toko_kode='".$data['toko_kode']."'";
		
		$this->db->query($queryDelete);
	}
}

?>