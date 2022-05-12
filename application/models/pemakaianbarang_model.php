<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pemakaianbarang_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataPemakaian($data){
		$query = "select a.bukti, a.tanggal, a.barang_kode, b.nama_barang, a.kwt_besar, a.kwt_kecil, 
		d.nama as nama_satuan_terkecil, e.nama as nama_satuan, a.kitchen_kode, c.nama as nama_kitchen 
		from pemakaian_barang a 
		left join barang b on a.barang_kode=b.kode 
		left join kitchen c on a.kitchen_kode=c.kode 
		left join satuan_barang d on b.satuan_terkecil=d.kode 
		left join satuan_barang e on b.satuan=e.kode 
		where year(a.tanggal)=".$data['tahun']." and month(a.tanggal)=".$data['bulan']." and a.is_hapus='0' 
		order by a.tanggal desc, a.bukti";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataListPemakaian($data){
		$query = "select a.bukti, a.tanggal, a.kitchen_kode, c.nama nama_kitchen 
		from pemakaian_barang a left join kitchen c on a.kitchen_kode=c.kode 
		where year(a.tanggal)=".$data['tahun']." and month(a.tanggal)=".$data['bulan']." and a.is_hapus='0' group by a.bukti 
		order by a.tanggal desc, a.bukti";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanPemakaian($data){
		$query = "";
		if($data['mode'] == "i"){
			$query = "insert into pemakaian_barang(bukti, tanggal, barang_kode, kwt_besar, kwt_kecil, kitchen_kode, is_hapus, user_id, waktu_insert, waktu_update) 
			values('".$data['bukti']."', '".$data['tanggal']."', '".$data['barang_kode']."', ".$data['kwt_besar'].", ".$data['kwt_kecil'].", '".$data['kitchen_kode']."', 
			'0', '".$this->session->userdata('username')."', NOW(), NOW())";
		}else{
			$query = "insert into pemakaian_barang(bukti, tanggal, barang_kode, kwt_besar, kwt_kecil, kitchen_kode, is_hapus, user_id, waktu_insert, waktu_update) 
			values('".$data['bukti']."', '".$data['tanggal']."', '".$data['barang_kode']."',  ".$data['kwt_besar'].", ".$data['kwt_kecil'].", '".$data['kitchen_kode']."', 
			'0', '".$this->session->userdata('username')."', NOW(), NOW()) on duplicate key update tanggal='".$data['tanggal']."', 
			kitchen_kode='".$data['kitchen_kode']."', kwt_besar=".$data['kwt_besar'].", kwt_kecil=".$data['kwt_kecil'].", is_hapus='0', waktu_update=NOW()";
		}
		
		$this->db->query($query);
	}
	
	function getDataBarangPemakaian($data){
		$query = "select a.bukti, a.tanggal, a.barang_kode, b.nama_barang, a.kwt_besar, a.kwt_kecil, 
		d.nama as nama_satuan_terkecil, a.kitchen_kode 
		from pemakaian_barang a left join barang b on a.barang_kode=b.kode  
		left join satuan_barang d on b.satuan_terkecil=d.kode 
		where a.bukti='".$data['bukti']."' and a.is_hapus='0'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function HapusPemakaian($data){
		$query = "update pemakaian_barang set is_hapus='1' where bukti='".$data['bukti']."'";
		/*if(isset($data['barang_kode'])){
			$query .= " and barang_kode='".$data['barang_kode']."'";
		}*/
		
		$this->db->query($query);
	}
}