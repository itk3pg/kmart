<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taukeluarkonsinyasi_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataTG($data){
		$query = "select a.bukti, a.tanggal, a.barang_kode, b.nama_barang, b.satuan, a.kwt, a.harga, a.jumlah, 
		a.toko_kode, c.nama as nama_toko, a.pelanggan_kode, d.nama_pelanggan 
		from tau_keluar_konsinyasi a left join barang b on a.barang_kode=b.kode left join toko c on a.toko_kode=c.kode left join pelanggan d on a.pelanggan_kode=d.kode 
		where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.toko_kode='".$data['toko_kode']."' and a.is_hapus='0' order by a.tanggal desc, a.bukti desc, a.urut";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	// function getDataListTG($data){
	// 	$query = "select a.bukti, a.tanggal, a.toko_kode, c.nama as nama_toko 
	// 	from tau_keluar_konsinyasi a left join toko c on a.toko_kode=c.kode 
	// 	where year(a.tanggal)=".$data['tahun']." and month(a.tanggal)=".$data['bulan']." and a.is_hapus='0' group by a.bukti 
	// 	order by a.tanggal desc, a.bukti";
		
	// 	$result = $this->db->query($query);
		
	// 	return $result->result_array();
	// }
	
	function SimpanTG($data){
		$query = "";
		if($data['mode'] == "i"){
			$query = "insert into tau_keluar_konsinyasi(bukti, tanggal, barang_kode, kwt, harga, jumlah, pelanggan_kode, toko_kode, is_hapus, user_id, waktu_insert, waktu_update, urut) 
			values('".$data['bukti']."', '".$data['tanggal']."', '".$data['barang_kode']."', ".$data['kwt'].", ".$data['harga'].", ".$data['jumlah'].", '".$data['pelanggan_kode']."', '".$data['toko_kode']."', 
			'0', '".$this->session->userdata('username')."', NOW(), NOW(), ".$data['urut'].") on duplicate key update tanggal='".$data['tanggal']."', pelanggan_kode='".$data['pelanggan_kode']."', kwt=".$data['kwt'].", harga=".$data['harga'].", jumlah=".$data['jumlah'].", waktu_update=now(), is_hapus='0', user_id='".$this->session->userdata('username')."', urut=".$data['urut']."";
		}else{
			$query = "insert into tau_keluar_konsinyasi(bukti, tanggal, barang_kode, kwt, harga, jumlah, pelanggan_kode, toko_kode, is_hapus, user_id, waktu_insert, waktu_update, urut) 
			values('".$data['bukti']."', '".$data['tanggal']."', '".$data['barang_kode']."', ".$data['kwt'].", ".$data['harga'].", ".$data['jumlah'].", '".$data['pelanggan_kode']."', '".$data['toko_kode']."', 
			'0', '".$this->session->userdata('username')."', NOW(), NOW(), ".$data['urut'].") on duplicate key update tanggal='".$data['tanggal']."', pelanggan_kode='".$data['pelanggan_kode']."', kwt=".$data['kwt'].", harga=".$data['harga'].", jumlah=".$data['jumlah'].", waktu_update=now(), is_hapus='0', user_id='".$this->session->userdata('username')."', urut=".$data['urut']."";
		}
		
		$this->db->query($query);
	}
	
	function getDataBarangTG($data){
		$query = "select a.bukti, a.tanggal, a.barang_kode, b.nama_barang, a.kwt, a.harga, a.jumlah, b.satuan, a.toko_kode, c.nama as nama_toko, a.pelanggan_kode, d.nama_pelanggan 
		from tau_keluar_konsinyasi a left join barang b on a.barang_kode=b.kode left join toko c on a.toko_kode=c.kode left join pelanggan d on a.pelanggan_kode=d.kode 
		where a.bukti='".$data['bukti']."' and a.toko_kode='".$data['toko_kode']."' and a.is_hapus='0'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}

	function getAllData($data){
		$query = "select a.bukti, a.tanggal, a.barang_kode, a.toko_kode from tau_keluar_konsinyasi a where a.bukti='".$data['bukti']."'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function HapusTG($data){
		$query = "update tau_keluar_konsinyasi set is_hapus='1', waktu_update=NOW(), user_id='".$this->session->userdata('username')."' where bukti='".$data['bukti']."' and toko_kode='".$data['toko_kode']."'";
		if(isset($data['barang_kode'])){
			$query .= " and barang_kode='".$data['barang_kode']."'";
		}
		// echo $query;
		$this->db->query($query);
	}
	
	// function setStatusOT($data){
	// 	$query = "update order_transfer set is_approve='1', waktu_update=NOW(), user_id='".$this->session->userdata('username')."' where bukti='".$data['ref_ot']."'";
		
	// 	$this->db->query($query);
	// }
	
	// function TerimaTransferToko($data){
	// 	$query = "update tau_keluar_konsinyasi set is_approve='1', waktu_update=NOW(), user_id='".$this->session->userdata('username')."' where bukti='".$data['bukti']."'";
		
	// 	$this->db->query($query);

	// 	$queryInsertRetur = "insert into retur_toko_konsinyasi(bukti, toko_kode, barang_kode, tanggal, kwt, keterangan, status, is_approve, is_hapus, user_id, waktu_insert, waktu_update) select bukti, 'VO0001' as toko_kode, barang_kode, tanggal, kwt, 'Barang Konsinyasi' as keterangan, '0' as status, '1' as is_approve, '0' as is_hapus, user_id, NOW() as waktu_insert, NOW() as waktu_update from tau_keluar_konsinyasi where bukti='".$data['bukti']."'";

	// 	$this->db->query($queryInsertRetur);
	// }

	function getRekapTAUKeluar($data){
		$query = "select a.bukti, a.tanggal, sum(a.jumlah) as jumlah, a.pelanggan_kode, c.nama_pelanggan, a.toko_kode, d.nama as nama_toko 
		from tau_keluar_konsinyasi a left join barang b on a.barang_kode=b.kode left join pelanggan c on a.pelanggan_kode=c.kode left join toko d on a.toko_kode=d.kode 
		where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' group by a.bukti 
		order by a.tanggal, a.bukti";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}

	function getRekapKelompokTAUKeluar($data){
		$query = "select b.kategori, c.nama, sum(a.jumlah) as jumlah from tau_keluar_konsinyasi a left join barang b on a.barang_kode=b.kode left join kategori_barang c on b.kategori=c.kode where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' group by b.kategori";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
}