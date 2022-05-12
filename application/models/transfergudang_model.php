<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transfergudang_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataTG($data){
		$query = "select a.bukti, a.tanggal, a.barang_kode, b.nama_barang, b.satuan, a.kwt, a.harga, a.jumlah, a.ref_ot, 
		a.toko_kode, c.nama as nama_toko, a.is_approve 
		from transfer_toko a left join barang b on a.barang_kode=b.kode left join toko c on a.toko_kode=c.kode
		where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.toko_kode='".$data['toko_kode']."' and a.is_approve like '%".$data['is_approve']."%' and a.is_hapus='0' order by a.tanggal desc, a.bukti desc, a.urut";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataListTG($data){
		$query = "select a.bukti, a.tanggal, a.toko_kode, c.nama as nama_toko 
		from transfer_toko a left join toko c on a.toko_kode=c.kode 
		where year(a.tanggal)=".$data['tahun']." and month(a.tanggal)=".$data['bulan']." and a.is_hapus='0' group by a.bukti 
		order by a.tanggal desc, a.bukti";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanTG($data){
		$query = "";
		if($data['mode'] == "i"){
			$query = "insert into transfer_toko(bukti, tanggal, barang_kode, kwt, harga, jumlah, ref_ot, is_approve, toko_kode, is_hapus, user_id, waktu_insert, waktu_update) 
			values('".$data['bukti']."', '".$data['tanggal']."', '".$data['barang_kode']."', ".$data['kwt'].", ".$data['harga'].", ".$data['jumlah'].", '".$data['ref_ot']."', '0', '".$data['toko_kode']."', 
			'0', '".$this->session->userdata('username')."', NOW(), NOW())";
		}else{
			$query = "insert into transfer_toko(bukti, tanggal, barang_kode, kwt, harga, jumlah, ref_ot, is_approve, toko_kode, is_hapus, user_id, waktu_insert, waktu_update) 
			values('".$data['bukti']."', '".$data['tanggal']."', '".$data['barang_kode']."', ".$data['kwt'].", ".$data['harga'].", ".$data['jumlah'].", '".$data['ref_ot']."', '0', '".$data['toko_kode']."', 
			'0', '".$this->session->userdata('username')."', NOW(), NOW()) on duplicate key update tanggal='".$data['tanggal']."', 
			toko_kode='".$data['toko_kode']."', kwt=".$data['kwt'].", waktu_update=now(), is_hapus='0'";
		}
		
		$this->db->query($query);
	}
	
	function getDataBarangTG($data){
		$query = "select a.bukti, a.tanggal, a.barang_kode, b.nama_barang, a.kwt, a.harga, a.jumlah, b.satuan, a.toko_kode, c.nama as nama_toko, a.is_approve 
		from transfer_toko a left join barang b on a.barang_kode=b.kode left join toko c on a.toko_kode=c.kode 
		where a.bukti='".$data['bukti']."' and a.is_hapus='0'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function HapusTG($data){
		$query = "update transfer_toko set is_hapus='1' where bukti='".$data['bukti']."'";
		if(isset($data['barang_kode'])){
			$query .= " and barang_kode='".$data['barang_kode']."'";
		}
		
		$this->db->query($query);
		
		$querysetStatus = "update order_transfer set is_approve='0' where bukti='".$data['ref_ot']."'";
		
		$this->db->query($querysetStatus);
	}
	
	function setStatusOT($data){
		$query = "update order_transfer set is_approve='1', waktu_update=NOW(), user_id='".$this->session->userdata('username')."' where bukti='".$data['ref_ot']."'";
		
		$this->db->query($query);
	}
	
	function TerimaTransferToko($data){
		$query = "update transfer_toko set is_approve='1', waktu_update=NOW(), user_id='".$this->session->userdata('username')."' where bukti='".$data['bukti']."' and toko_kode='".$data['toko_kode']."'";
		
		$this->db->query($query);
	}

	function BatalTerimaTransferToko($data){
		$query = "update transfer_toko set is_approve='0', waktu_update=NOW(), user_id='".$this->session->userdata('username')."' where bukti='".$data['bukti']."' and toko_kode='".$data['toko_kode']."'";
		
		$this->db->query($query);
	}

	function getRekapTransferGudang($data){
		$query = "select a.bukti, a.tanggal, sum(a.jumlah) as jumlah, a.toko_kode, c.nama as nama_toko, a.ref_ot, a.is_approve 
		from transfer_toko a left join barang b on a.barang_kode=b.kode left join toko c on a.toko_kode=c.kode 
		where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.toko_kode='".$data['toko_kode']."' and a.is_hapus='0' group by a.bukti, a.toko_kode 
		order by a.tanggal, a.bukti";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}

	function getRekapKelompokTransferGudang($data){
		$query = "select b.kategori, c.nama, sum(a.jumlah) as jumlah from transfer_toko a left join barang b on a.barang_kode=b.kode left join kategori_barang c on b.kategori=c.kode where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' and a.toko_kode='".$data['toko_kode']."' group by b.kategori";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
}