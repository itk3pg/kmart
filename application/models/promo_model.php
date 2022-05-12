<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Promo_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataPromo($data){
		$query = "";
		if($data['is_aktif'] == "1"){
			$query = "select a.kode, a.toko_kode, b.nama as nama_toko, a.barang_kode, c.nama_barang, d.harga1, round(a.persentase_promo,2) as persentase_promo, a.kwt_kondisi, a.harga_promo, a.tanggal_awal, a.tanggal_akhir, 
			a.senin, a.selasa, a.rabu, a.kamis, a.jumat, a.sabtu, a.minggu 
			from promo a left join toko b on a.toko_kode=b.kode left join barang c on a.barang_kode=c.kode 
			left join harga_barang_toko d on a.toko_kode=d.toko_kode and a.barang_kode=d.barang_kode 
			where a.is_aktif='1' and a.toko_kode='".$data['toko_kode']."'";
		}else{
			$query = "select a.kode, a.toko_kode, b.nama as nama_toko, a.barang_kode, c.nama_barang, d.harga1, round(a.persentase_promo,2) as persentase_promo, a.kwt_kondisi, a.harga_promo, a.tanggal_awal, a.tanggal_akhir, a.senin, a.selasa, a.rabu, a.kamis, a.jumat, a.sabtu, a.minggu 
			from promo a left join toko b on a.toko_kode=b.kode left join barang c on a.barang_kode=c.kode 
			left join harga_barang_toko d on a.toko_kode=d.toko_kode and a.barang_kode=d.barang_kode 
			where a.is_aktif='0' and a.toko_kode='".$data['toko_kode']."' and a.tanggal_awal <= '".date('Y-m-d')."' and a.tanggal_akhir >= '".date('Y-m-d')."'";
			// echo $query;
		}
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function SimpanPromo($data){
		/**
		 * `kode` VARCHAR(10) NOT NULL,
			`nama` VARCHAR(45) NULL DEFAULT NULL,
			`keterangan` VARCHAR(100) NULL DEFAULT NULL,
			`tanggal_awal` DATE NULL DEFAULT NULL,
			`tanggal_akhir` DATE NULL DEFAULT NULL,
			`persen` DOUBLE NULL DEFAULT NULL,
			`is_aktif` VARCHAR(1) NULL DEFAULT NULL
		 */
		$username = $this->session->userdata('username');
		$query = "";
		$data['senin'] = "1"; $data['selasa'] = "1";
		$data['rabu'] = "1"; $data['kamis'] = "1";
		$data['jumat'] = "1"; $data['sabtu'] = "1";
		$data['minggu'] = "1";
		if($data['kwt_kondisi'] == '0' || $data['kwt_kondisi'] == ''){
			$data['kwt_kondisi'] = '1';
		}
		//if($data['mode'] == "i"){
			$query = "insert into promo (kode, toko_kode, barang_kode, persentase_promo, harga_promo, kwt_kondisi, kwt_promo, tanggal_awal, tanggal_akhir, senin, 
			selasa, rabu, kamis, jumat, sabtu, minggu, is_aktif, user_id, waktu_insert, waktu_update) 
			values ('".$data['kode']."','".$data['toko_kode']."','".$data['barang_kode']."',".$data['persentase_promo'].",
			".$data['harga_promo'].", ".$data['kwt_kondisi'].", 0,'".$data['tanggal_awal']."','".$data['tanggal_akhir']."','".$data['senin']."','".$data['selasa']."',
			'".$data['rabu']."','".$data['kamis']."','".$data['jumat']."','".$data['sabtu']."','".$data['minggu']."','1', '".$username."', NOW(), NOW()) on duplicate key update persentase_promo=".$data['persentase_promo'].", harga_promo=".$data['harga_promo'].", kwt_kondisi=".$data['kwt_kondisi'].", tanggal_awal='".$data['tanggal_awal']."', tanggal_akhir='".$data['tanggal_akhir']."', is_aktif='1', user_id='".$username."', waktu_update=NOW()";
			//echo $query;
			$this->db->query($query);
		/*}else{
			$query = "update promo set persentase_promo=".$data['persentase_promo'].",harga_promo=".$data['harga_promo'].",kwt_kondisi=".$data['kwt_kondisi'].",
			tanggal_awal='".$data['tanggal_awal']."',tanggal_akhir='".$data['tanggal_akhir']."',
			senin='".$data['senin']."',selasa='".$data['selasa']."',rabu='".$data['rabu']."',kamis='".$data['kamis']."',jumat='".$data['jumat']."',
			sabtu='".$data['sabtu']."',minggu='".$data['minggu']."', waktu_update=NOW() where kode='".$data['kode']."'";
			
			$this->db->query($query);
		}*/
	}
	
	function HapusPromo($data){
		$query = "update promo set is_aktif='0' where kode='".$data['kode']."'";
		
		$this->db->query($query);
	}
	
	function HapusPromoToko($data){
		$query = "update promo set is_aktif='0' where kode='".$data['kode']."' and toko_kode='".$data['toko_kode']."'";
		
		$this->db->query($query);
	}
	
	function getDataBarangPromo($data){
		$query = "select a.barang_kode, b.nama_barang, a.persentase_promo, a.harga_promo, a.kwt_kondisi 
		from promo a left join barang b on a.barang_kode=b.kode where a.kode='".$data['kode_promo']."' and a.toko_kode='".$data['toko_kode']."'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}

	function RestorePromo($data){
		$query = "update promo set is_aktif='1' where kode='".$data['kode_promo']."' and toko_kode='".$data['toko_kode']."'";
		$this->db->query($query);
	}
}