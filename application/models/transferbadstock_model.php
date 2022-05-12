<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transferbadstock_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataTransferBadStock($data){
		$query = "select a.bukti, a.tanggal, a.barang_kode, a.toko_kode, c.nama as nama_toko, b.nama_barang, b.satuan, a.kwt, a.hpp, a.jumlah, a.is_penyesuaian from bo_bad_stock a left join barang b on a.barang_kode=b.kode left join toko c on a.toko_kode=c.kode where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.toko_kode='".$data['gudang_bs']."' and a.is_hapus='0' order by a.tanggal desc, a.bukti";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanTransferBadStock($data){
		$query = "";
		if($data['mode'] == "i"){
			$query = "insert ignore into bo_bad_stock(bukti, barang_kode, toko_kode, tanggal, kwt, hpp, jumlah, is_hapus, is_penyesuaian, user_id, waktu_insert, waktu_update) values('".$data['bukti']."', '".$data['barang_kode']."', '".$data['gudang_bs']."', '".$data['tanggal']."', ".$data['kwt'].", ".$data['hpp'].", ".$data['jumlah'].", '0', '".$data['is_penyesuaian']."', '".$this->session->userdata('username')."', NOW(), NOW())";
		}else{
			$query = "insert into bo_bad_stock(bukti, barang_kode, toko_kode, tanggal, kwt, hpp, jumlah, is_hapus, is_penyesuaian, user_id, waktu_insert, waktu_update) 
			values('".$data['bukti']."', '".$data['barang_kode']."', '".$data['gudang_bs']."', '".$data['tanggal']."', ".$data['kwt'].", ".$data['hpp'].", ".$data['jumlah'].", '0', '".$data['is_penyesuaian']."', '".$this->session->userdata('username')."', NOW(), NOW()) on duplicate key update tanggal='".$data['tanggal']."', kwt=".$data['kwt'].", hpp=".$data['hpp'].", jumlah=".$data['jumlah'].", is_hapus='0', waktu_update=NOW()";
		}
		
		$this->db->query($query);
	}
	
	function getDataBarangTransferBadStock($data){
		$query = "select a.bukti, a.tanggal, a.barang_kode, a.toko_kode, b.nama_barang, b.satuan, a.kwt, a.hpp, a.jumlah from bo_bad_stock a left join barang b on a.barang_kode=b.kode where a.bukti='".$data['bukti']."' and a.is_hapus='0'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}

	function getDataBarangTransferBadStockHapus($data){
		$query = "select a.bukti, a.tanggal, a.barang_kode, a.toko_kode, b.nama_barang, b.satuan, a.kwt from bo_bad_stock a left join barang b on a.barang_kode=b.kode where a.bukti='".$data['bukti']."'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function HapusTransferBadStock($data){
		$query = "update bo_bad_stock set is_hapus='1' where bukti='".$data['bukti']."'";
		if(isset($data['barang_kode'])){
			$query .= " and barang_kode='".$data['barang_kode']."'";
		}
		
		$this->db->query($query);
	}
}