<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Taukeluar_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getDataTAUKeluar($data){
		$query = "select a.bukti, a.pelanggan_kode, b.nama_pelanggan, a.barang_kode, c.nama_barang, c.satuan, a.unit_kode, a.tanggal, a.kwt, 
		a.harga, a.jumlah from tau_keluar a left join pelanggan b on a.pelanggan_kode=b.kode left join barang c on a.barang_kode=c.kode 
		where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function SimpanTAUKeluar($data){
		$username = $this->session->userdata('username');
		//$unit_kode = $this->session->userdata('toko_kode');
		
		$query = "insert into tau_keluar(bukti, pelanggan_kode, barang_kode, unit_kode, tanggal, kwt, harga, jumlah, waktu_insert, waktu_update, 
		user_id, is_hapus) values('".$data['bukti']."', '".$data['pelanggan_kode']."', '".$data['barang_kode']."', '', '".$data['tanggal']."', 
		".$data['kwt'].", ".$data['harga'].", ".$data['jumlah'].", NOW(), NOW(), '".$username."', '0') on duplicate key update 
		tanggal='".$data['tanggal']."', kwt=".$data['kwt'].", harga=".$data['harga'].", jumlah=".$data['jumlah'].", 
		waktu_update=NOW(), user_id='".$username."', is_hapus='0'";
		
		$this->db->query($query);
	}
	
	function HapusTAUKeluar($data){
		$username = $this->session->userdata('username');
		//$unit_kode = $this->session->userdata('toko_kode');
		
		$query = "update tau_keluar set is_hapus='1', waktu_update=NOW(), user_id='".$username."' where bukti='".$data['bukti']."'";
		
		$this->db->query($query);
	}
	
	function getDataBarangTAUKeluar($data){
		//$unit_kode = $this->session->userdata('toko_kode');
		
		$query = "select a.bukti, a.pelanggan_kode, b.nama_pelanggan, a.barang_kode, c.nama_barang, c.satuan, a.unit_kode, a.tanggal, a.kwt, 
		a.harga, a.jumlah from tau_keluar a left join pelanggan b on a.pelanggan_kode=b.kode left join barang c on a.barang_kode=c.kode 
		where a.bukti='".$data['bukti']."' and a.is_hapus='0'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}

	function getRekapTAUKeluar($data){
		$query = "select a.bukti, a.tanggal, sum(a.jumlah) as jumlah, a.pelanggan_kode, c.nama_pelanggan 
		from tau_keluar a left join barang b on a.barang_kode=b.kode left join pelanggan c on a.pelanggan_kode=c.kode 
		where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' group by a.bukti 
		order by a.tanggal, a.bukti";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}

	function getRekapKelompokTAUKeluar($data){
		$query = "select b.kategori, c.nama, sum(a.jumlah) as jumlah from tau_keluar a left join barang b on a.barang_kode=b.kode left join kategori_barang c on b.kategori=c.kode where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' group by b.kategori";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
}