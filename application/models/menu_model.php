<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataMenu(){
		$query = "select a.kode, a.nama nama_menu, a.nama_cetak, a.gambar, a.color_text, a.kategori, b.nama nama_kategori, c.kode kode_kitchen, 
		c.nama nama_kitchen, a.is_paket, a.harga, a.ppn 
		from menu a left join kategori_menu b on a.kategori=b.kode 
		left join kitchen c on a.kitchen_kode=c.kode 
		where a.is_hapus='0'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getListMenu($data){
		$query = "select a.kode, a.nama nama_menu 
		from menu a where a.is_hapus='0' and a.nama like '%".$data['q']."%'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataBom($data){
		$query = "";
		if($data['is_paket'] == "0"){
			$query = "select a.barang_kode, b.nama_barang, a.takaran, b.satuan_terkecil, c.nama as nama_satuan_terkecil 
			from bom a left join barang b on a.barang_kode=b.kode left join satuan_barang c on b.satuan_terkecil=c.kode where a.menu_kode='".$data['menu_kode']."'";
		}else{
			$query = "select a.menu_kode, b.nama, a.kwt from detail_paket a left join menu b on a.menu_kode=b.kode 
			where a.paket_kode='".$data['menu_kode']."'";
		}
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanMenu($data){
		$query = "";
		if($data['menu_harga'] == ""){
			$data['menu_harga'] = 0;
		}
		if($data['menu_ppn'] == ""){
			$data['menu_ppn'] = 0;
		}
		if($data['menu_mode'] == "i"){
			$query = "insert into menu (kode, kategori, kitchen_kode, is_paket, nama, nama_cetak, gambar, color_text, harga, ppn, is_hapus) 
			values('".$data['menu_kode']."','".$data['menu_kode_kategori']."','".$data['menu_kitchen']."','".$data['menu_tipe']."',
			'".$data['menu_nama_menu']."','".$data['menu_nama_cetak']."','".$data['menu_gambar']."','".$data['menu_color_text']."',
			".$data['menu_harga'].",".$data['menu_ppn'].",'0')";
		}else{
			$query = "update menu set kategori='".$data['menu_kode_kategori']."', kitchen_kode='".$data['menu_kitchen']."', nama='".$data['menu_nama_menu']."', 
			nama_cetak='".$data['menu_nama_cetak']."', color_text='".$data['menu_color_text']."', gambar='".$data['menu_gambar']."', harga=".$data['menu_harga'].", ppn=".$data['menu_ppn']." 
			where kode='".$data['menu_kode']."'";
		}
		
		$this->db->query($query);
	}
	
	function HapusMenu($data){
		$query = "update menu set is_hapus='1' where kode='".$data['kode']."'";
		
		$this->db->query($query);
	}
	
	function SimpanBom($data){
		if($data['is_paket'] == "0"){
			if($data['takaran'] == ""){
				$data['takaran'] = "0";
			}
			$query = "insert into bom (menu_kode, barang_kode, takaran) values ('".$data['menu_kode']."', '".$data['barang_kode']."', 
			".$data['takaran'].")";
			
			$this->db->query($query);
		}else{
			if($data['kwt'] == ""){
				$data['kwt'] = 0;
			}
			$query = "insert into detail_paket (paket_kode, menu_kode, kwt) values ('".$data['menu_kode']."', '".$data['detail_menu_kode']."', ".$data['kwt'].")";
		
			$this->db->query($query);
		}
	}
	
	function HapusBom($data){
		if($data['is_paket'] == "0"){
			$query = "delete from bom where barang_kode='".$data['kode']."'";
			
			$this->db->query($query);
		}else{
			$query = "delete from detail_paket where menu_kode='".$data['kode']."'";
		
		$this->db->query($query);
		}
		
		$this->db->close();
	}
	
	function DuplicateMenu($data){
		$query = "insert into menu select '".$data['kode_ganti']."' as kode, kategori, kitchen_kode, concat(nama, ' copy') as nama, nama_cetak, gambar, harga, ppn, is_paket, is_hapus, keterangan 
		from menu where kode='".$data['kode']."'";
		
		$this->db->query($query);
		
		$queryBom = "";
		if($data['is_paket'] == "1"){ // paket
			$queryBom = "insert into detail_paket select '".$data['kode_ganti']."' as paket_kode, menu_kode, kwt, status 
			from detail_paket where paket_kode='".$data['kode']."'";
		}else{ // biasa
			$queryBom = "insert into bom select '".$data['kode_ganti']."' as menu_kode, barang_kode, takaran, status 
			from detail_paket where menu_kode='".$data['kode']."'";
		}
		
		$this->db->query($queryBom);
	}
}