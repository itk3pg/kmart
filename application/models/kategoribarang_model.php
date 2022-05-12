<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kategoribarang_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getChild($parent){
		$query = "";
		if($parent == ""){
			$query = "select kode, nama, keterangan, margin_harga from kategori_barang where is_hapus='0' and (parent='' or parent is null)";
		}else{
			$query = "select kode, nama, keterangan, margin_harga from kategori_barang where is_hapus='0' and parent='".$this->db->escape_str($parent)."'";
		}
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataKategori(){
		$query = "select kode, nama, keterangan, margin_harga, margin_harga2, kode_akun from kategori_barang where is_hapus='0'";
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function simpankategori($data){
		$queryselect = "select kode from `kategori_barang` where kode='".$data['kode']."'";
		$result = $this->db->query($queryselect);
		$resultArr = $result->result_array();
  
		if(sizeof($resultArr) > 0 && $data['mode'] == "i"){
			return "-1";
		}else{
			if($data['margin1'] == ""){
				$data['margin1'] = "0";
			}
			if($data['margin2'] == ""){
				$data['margin2'] = "0";
			}
			$query = "insert into kategori_barang(kode, nama, margin_harga, margin_harga2, is_hapus, kode_akun) values('".$data['kode']."', '".$this->db->escape_str($data['nama'])."', ".$data['margin1'].", ".$data['margin2'].", '0', '".$data['kode_akun']."') on duplicate key update nama='".$this->db->escape_str($data['nama'])."', margin_harga=".$data['margin1'].", margin_harga2=".$data['margin2'].", kode_akun='".$data['kode_akun']."'";
			$this->db->query($query);

			return "1";
		}
	}
	
	function setparent($data){
		if($data['parent'] == "null"){
			$data['parent'] = "";
		}
		$query = "update kategori_barang set parent='".$this->db->escape_str($data['parent'])."' where kode='".$data['kode']."'";
		
		$this->db->query($query);
	}
	
	function HapusKategori($data){
		$queryhapus = "delete from kategori_barang where kode='".$data['kode']."'";
		
		$this->db->query($queryhapus);

		$querySelect = "select kode from kategori_barang where kode='".$data['kode']."'";
		$resultb = $this->db->query($querySelect);
		$resultbArr = $resultb->result_array();

		if(sizeof($resultbArr) > 0){
			return "-1";
		}else{
			return "1";
		}
	}

	function SimpanKodeAkun($data){
		$query = "insert into kategori_barang_akun(kategori_barang_kode, toko_kode, kode_akun) values('".$data['kategori_barang_kode']."', '".$data['toko_kode']."', '".$data['kode_akun']."') on duplicate key update kode_akun='".$data['kode_akun']."'";
		$this->db->query($query);

		return "1";
	}

	function getDataAkunKategori($data){
		$query = "select a.toko_kode, a.kategori_barang_kode, b.nama as nama_toko, a.kode_akun from kategori_barang_akun a left join toko b on a.toko_kode=b.kode where kategori_barang_kode='".$data['kode']."'";
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
}