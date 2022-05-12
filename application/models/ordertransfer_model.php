<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ordertransfer_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataOT($data){
		$query = "select a.bukti, a.tanggal, a.barang_kode, b.nama_barang, b.satuan, a.kwt, a.harga, a.jumlah, 
		a.toko_kode, c.nama as nama_toko, a.keterangan, a.is_approve, stok_dc 
		from order_transfer a left join barang b on a.barang_kode=b.kode left join toko c on a.toko_kode=c.kode 
		where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.toko_kode='".$data['toko_kode']."' and a.is_hapus='0' 
		order by a.tanggal desc, a.bukti desc, urut";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataListOT($data){
		$query = "select a.bukti, a.tanggal, a.toko_kode, c.nama as nama_toko 
		from order_transfer a left join toko c on a.toko_kode=c.kode 
		where year(a.tanggal)=".$data['tahun']." and month(a.tanggal)=".$data['bulan']." and a.toko_kode='".$data['toko_kode']."' and a.is_hapus='0' and a.is_approve='0' group by a.bukti 
		order by a.tanggal desc, a.bukti";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataListOTLast(){
		$query = "select a.bukti, a.tanggal, a.toko_kode, c.nama as nama_toko 
		from order_transfer a left join toko c on a.toko_kode=c.kode 
		where a.toko_kode='".$this->session->userdata('toko_kode')."' and a.is_hapus='0' and a.is_approve='1' group by a.bukti 
		order by a.tanggal desc limit 5";
		//echo $query;
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanOT($data){
		$query = "";
		if($data['stok_dc'] == ""){
			$data['stok_dc'] = "0";
		}
		if($data['mode'] == "i"){
			$query = "insert ignore into order_transfer(bukti, tanggal, barang_kode, kwt, harga, jumlah, toko_kode, keterangan, is_approve, is_hapus, user_id, waktu_insert, waktu_update, urut, stok_dc) 
			values('".$data['bukti']."', '".$data['tanggal']."', '".$data['barang_kode']."', ".$data['kwt'].", ".$data['harga'].", ".$data['jumlah'].", '".$data['toko_kode']."', 
			'', '0', '0', '".$this->session->userdata('username')."', NOW(), NOW(), ".$data['urut'].", ".$data['stok_dc'].")";
		}else{
			$query = "insert into order_transfer(bukti, tanggal, barang_kode, kwt, harga, jumlah, toko_kode, keterangan, is_approve, is_hapus, user_id, waktu_insert, waktu_update, urut, stok_dc) 
			values('".$data['bukti']."', '".$data['tanggal']."', '".$data['barang_kode']."', ".$data['kwt'].", ".$data['harga'].", ".$data['jumlah'].", '".$data['toko_kode']."', 
			'', '0', '0', '".$this->session->userdata('username')."', NOW(), NOW(), ".$data['urut'].", ".$data['stok_dc'].") on duplicate key update tanggal='".$data['tanggal']."', 
			toko_kode='".$data['toko_kode']."', kwt=".$data['kwt'].", harga=".$data['harga'].", jumlah=".$data['jumlah'].", is_hapus='0', waktu_update=NOW(), urut=".$data['urut'].", stok_dc=".$data['stok_dc']."";
		}
		
		$this->db->query($query);
	}
	
	function getDataBarangOT($data){
		$query = "select a.bukti, a.tanggal, a.barang_kode, b.barcode, b.nama_barang, b.satuan, a.kwt, a.harga, a.jumlah, a.toko_kode, c.nama as nama_toko, a.keterangan, a.is_approve, b.pic, a.stok_dc, d.harga1 as harga_jual from order_transfer a left join barang b on a.barang_kode=b.kode left join toko c on a.toko_kode=c.kode left join harga_barang_toko d on a.barang_kode=d.barang_kode and a.toko_kode=d.toko_kode where a.bukti='".$data['bukti']."' and a.is_hapus='0' order by a.urut";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}

	function getDataBarangOTCetak($data){
		$query = "select a.bukti, a.tanggal, a.barang_kode, b.barcode, b.nama_barang, b.satuan, a.kwt, a.harga, a.jumlah, a.toko_kode, c.nama as nama_toko, a.keterangan, a.is_approve, b.pic, a.stok_dc, d.harga1 as harga_jual, e.saldo_akhir_kwt as stok_toko from order_transfer a left join barang b on a.barang_kode=b.kode left join toko c on a.toko_kode=c.kode left join harga_barang_toko d on a.barang_kode=d.barang_kode and a.toko_kode=d.toko_kode left join (select * from saldo_barang_toko where bulan=".date('m')." and tahun=".date('Y')." and toko_kode='".$data['toko_kode']."') e on a.barang_kode=e.barang_kode and a.toko_kode=e.toko_kode where a.bukti='".$data['bukti']."' and a.is_hapus='0' and a.toko_kode='".$data['toko_kode']."' order by a.urut";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataBarangOTLast($data){
		$query = "select a.bukti, a.tanggal, a.barang_kode, b.nama_barang, b.satuan, a.kwt, a.harga, a.jumlah, a.toko_kode, c.nama as nama_toko, a.keterangan, a.is_approve 
		from order_transfer a left join barang b on a.barang_kode=b.kode left join toko c on a.toko_kode=c.kode  
		where a.bukti='".$data['bukti']."' and a.is_hapus='0' and a.barang_kode not in (select barang_kode from transfer_toko where ref_ot='".$data['bukti']."' and is_hapus='0')";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function HapusOT($data){
		$query = "update order_transfer set is_hapus='1', waktu_update=NOW(), user_id='".$this->session->userdata('username')."' where bukti='".$data['bukti']."'";
		if(isset($data['barang_kode'])){
			$query .= " and barang_kode='".$data['barang_kode']."'";
		}
		
		$this->db->query($query);
	}

	function FixOT($data){
		$query = "update order_transfer a left join transfer_toko b on a.toko_kode=b.toko_kode and a.bukti=b.ref_ot set a.is_approve='0' where a.bukti='".$data['fixot_bukti']."' and a.toko_kode='".$data['fixot_toko']."' and a.is_hapus='0' and b.ref_ot is null";
		
		$this->db->query($query);
	}
	
	function getDataBarangSupplier($data){
		$query = "select a.kode, a.nama_barang, a.satuan, if(c.saldo_akhir_kwt is null, 0, c.saldo_akhir_kwt) as saldo_akhir_kwt, 
		d.supplier_kode, c.toko_kode from barang a left join barang_toko b on a.kode=b.barang_kode 
		left join (select * from saldo_barang_toko where toko_kode='".$data['toko_kode']."' and bulan=".date('m')." and tahun=".date('Y').") c on a.kode=c.barang_kode 
		left join barang_supplier d on a.kode=d.barang_kode 
		where d.supplier_kode='".$data['supplier_kode']."' and b.toko_kode='".$data['toko_kode']."' and a.is_hapus='0'";
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getSaldoBarangToko($data){
		$query = "select a.saldo_akhir_kwt from saldo_barang_toko a where a.toko_kode='".$data['toko_kode']."' 
		and a.barang_kode='".$data['barang_kode']."' and a.bulan=".date('m')." and a.tahun=".date('Y')."";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}

	function getSaldoBarangTokoDC($data){
		$query = "select a.toko_kode, a.saldo_akhir_kwt from saldo_barang_toko a where (a.toko_kode='".$data['toko_kode']."' or a.toko_kode='VO0006') and a.barang_kode='".$data['barang_kode']."' and a.bulan=".date('m')." and a.tahun=".date('Y')."";
		
		$result = $this->db->query($query);
		$ResultArr = $result->result_array();
		$FinalResult = array();
		foreach ($ResultArr as $key => $value) {
			$FinalResult[$value['toko_kode']] = $value['saldo_akhir_kwt'];
		}
		
		return $FinalResult;
	}

	function getRekapOrderTransfer($data){
		$query = "select a.bukti, a.tanggal, sum(a.jumlah) as jumlah, a.toko_kode, c.nama as nama_toko, a.is_approve 
		from order_transfer a left join barang b on a.barang_kode=b.kode left join toko c on a.toko_kode=c.kode 
		where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.toko_kode='".$data['toko_kode']."' and a.is_hapus='0' group by a.bukti, a.tanggal, a.toko_kode, a.is_approve 
		order by a.tanggal, a.bukti";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}

	function getRekapKelompokOrderTransfer($data){
		$query = "select b.kategori, c.nama, sum(a.jumlah) as jumlah from order_transfer a left join barang b on a.barang_kode=b.kode left join kategori_barang c on b.kategori=c.kode where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' and a.toko_kode='".$data['toko_kode']."' group by b.kategori";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
}