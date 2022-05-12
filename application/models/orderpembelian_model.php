<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orderpembelian_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataOP($data){
		$query = "select a.bukti, a.tanggal, a.barang_kode, b.nama_barang, a.kwt, a.harga, a.ppn, a.jumlah, 
		a.supplier_kode, c.nama_supplier, b.satuan, a.is_receive 
		from op a left join barang b on a.barang_kode=b.kode left join supplier c on a.supplier_kode=c.kode 
		where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' 
		order by a.tanggal desc, a.bukti desc, a.urut";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataListOP($data){
		$query = "select a.bukti, a.tanggal, a.supplier_kode, b.nama_supplier 
		from op a left join supplier b on a.supplier_kode=b.kode 
		where year(a.tanggal)=".$data['tahun']." and month(a.tanggal)=".$data['bulan']." and a.supplier_kode = '".$data['supplier_kode']."' 
		and a.is_hapus='0' and a.is_receive='0' group by a.bukti 
		order by a.tanggal, a.bukti, a.urut";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanOP($data){
		$query = "";
		if($data['mode'] == "i"){
			$query = "insert ignore into op(bukti, unit_kode, tanggal, barang_kode, kwt, harga, harga_asli, diskon1, ppn, jumlah, supplier_kode, is_receive, is_include_ppn, is_hapus, user_id, waktu_update, waktu_insert, urut) 
			values('".$data['bukti']."', 'VO0006', '".$data['tanggal']."', '".$data['barang_kode']."', ".$data['kwt'].", ".$data['harga'].", ".$data['harga_asli'].", ".$data['diskon1'].", ".$data['ppn'].", 
			".$data['jumlah'].", '".$data['supplier_kode']."', 
			'0', '".$data['mode_include']."', '0', '".$this->session->userdata('username')."', NOW(), NOW(), ".$data['index'].")";
		}else{
			$query = "insert into op(bukti, unit_kode, tanggal, barang_kode, kwt, harga, harga_asli, diskon1, ppn, jumlah, supplier_kode, is_receive, is_include_ppn, is_hapus, user_id, waktu_update, waktu_insert, urut) 
			values('".$data['bukti']."', 'VO0006', '".$data['tanggal']."', '".$data['barang_kode']."', ".$data['kwt'].", ".$data['harga'].", ".$data['harga_asli'].", ".$data['diskon1'].", ".$data['ppn'].", 
			".$data['jumlah'].", '".$data['supplier_kode']."', 
			'0', '".$data['mode_include']."', '0', '".$this->session->userdata('username')."', NOW(), NOW(), ".$data['index'].") on duplicate key update tanggal='".$data['tanggal']."', 
			supplier_kode='".$data['supplier_kode']."', kwt=".$data['kwt'].", harga=".$data['harga'].", harga_asli=".$data['harga_asli'].", diskon1=".$data['diskon1'].", ppn=".$data['ppn'].", jumlah=".$data['jumlah'].", 
			is_receive='0', is_include_ppn='".$data['mode_include']."', is_hapus='0', user_id='".$this->session->userdata('username')."', 
			waktu_update=NOW()";
		}
		
		$this->db->query($query);
	}
	
	function getDataBarangOP($data){
		$query = "select a.bukti, a.tanggal, a.barang_kode, b.nama_barang, a.kwt, a.harga, a.harga_asli, a.diskon1, a.ppn, a.jumlah, a.keterangan, b.satuan 
		from op a left join barang b on a.barang_kode=b.kode  
		where a.bukti='".$data['bukti']."' and a.is_hapus='0' order by a.urut";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataBarangSupplier($data){
		$query = "select a.kode, a.nama_barang, a.satuan, '0' as diskon1, '0' as kwt, if(date(NOW()) < b.periode, b.harga, b.harga_periode) as harga, d.pkp, 
		if(c.saldo_akhir_kwt is null, 0, c.saldo_akhir_kwt) as saldo_akhir_kwt, if(e.saldo_akhir_kwt is null, 0, e.saldo_akhir_kwt) as saldo_akhir_kwt_tuban from barang a left join harga_barang_supplier b on a.kode=b.barang_kode 
		left join (select * from saldo_barang_toko where toko_kode='VO0006' and bulan=".date('m')." and tahun=".date('Y').") c on a.kode=c.barang_kode left join (select * from saldo_barang_toko where toko_kode='VO0002' and bulan=".date('m')." and tahun=".date('Y').") e on a.kode=e.barang_kode 
		left join supplier d on b.supplier_kode=d.kode 
		where b.supplier_kode='".$data['supplier_kode']."' and a.is_hapus='0'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataBarangEditOP($data){
		$query = "select a.bukti, a.tanggal, d.nama_supplier, a.barang_kode, b.nama_barang, a.kwt, a.harga, a.harga_asli, a.diskon1, a.ppn, a.jumlah, a.keterangan, b.satuan, 
		if(c.saldo_akhir_kwt is null, 0, c.saldo_akhir_kwt) as saldo_akhir_kwt, e.nama as nama_user 
		from op a left join barang b on a.barang_kode=b.kode 
		left join (select * from saldo_barang_toko where toko_kode='VO0006' and bulan=".date('m')." and tahun=".date('Y').") c on a.barang_kode=c.barang_kode 
		left join supplier d on a.supplier_kode=d.kode left join user e on a.user_id=e.username 
		where a.bukti='".$data['bukti']."' and a.is_hapus='0' order by a.urut";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}

	//function getDataBarangCetak($data){
		//$query = "select a.bukti, a.tanggal, d.nama_supplier, a.barang_kode, b.nama_barang, a.kwt, a.harga, a.harga_asli, a.diskon1, a.ppn, a.jumlah, a.keterangan, b.satuan, 
		//if(c.saldo_toko1 is null, 0, c.saldo_toko1) as saldo_toko1, 
		//if(c.saldo_toko2 is null, 0, c.saldo_toko2) as saldo_toko2, 
		//if(c.saldo_toko3 is null, 0, c.saldo_toko3) as saldo_toko3, 
		//if(c.saldo_gudang is null, 0, c.saldo_gudang) as saldo_gudang, e.nama as nama_user  
		//from op a left join barang b on a.barang_kode=b.kode 
		//left join (select a.barang_kode, sum(if(a.toko_kode='VO0001', a.saldo_akhir_kwt, 0)) as saldo_toko1, sum(if(a.toko_kode='VO0002', 
		//a.saldo_akhir_kwt, 0)) as saldo_toko2, sum(if(a.toko_kode='VO0003', a.saldo_akhir_kwt, 0)) as saldo_toko3, sum(if(a.toko_kode='VO0006', 
		//a.saldo_akhir_kwt, 0)) as saldo_gudang from saldo_barang_toko a where toko_kode in ('VO0006', 'VO0001', 'VO0002', 'VO0003') and 
		//bulan=".date('m')." and tahun=".date('Y')." group by a.barang_kode) c on a.barang_kode=c.barang_kode 
		//left join supplier d on a.supplier_kode=d.kode left join user e on a.user_id=e.username 
		//where a.bukti='".$data['bukti']."' and a.is_hapus='0' order by a.urut";
		//echo $query; exit;
		//
		
		//$result = $this->db->query($query);
		
		//return $result->result_array();
	//}
	
	function getDataBarangCetak($data){
		$query = "select a.bukti, a.tanggal, d.nama_supplier, a.barang_kode, b.nama_barang, a.kwt, a.harga, a.harga_asli, a.diskon1, a.ppn, a.jumlah, a.keterangan, b.satuan, 
		if(c.saldo_toko1 is null, 0, c.saldo_toko1) as saldo_toko1, 
		if(c.saldo_toko2 is null, 0, c.saldo_toko2) as saldo_toko2, 
		if(c.saldo_toko3 is null, 0, c.saldo_toko3) as saldo_toko3, 
		if(c.saldo_gudang is null, 0, c.saldo_gudang) as saldo_gudang, e.nama as nama_user  
		from op a left join barang b on a.barang_kode=b.kode 
		left join (select a.barang_kode,sum(if(a.toko_kode='VO0001', a.saldo_akhir_kwt, 0)) as saldo_toko1, sum(if(a.toko_kode='VO0002', 
		a.saldo_akhir_kwt, 0)) as saldo_toko2, sum(if(a.toko_kode='VO0003', a.saldo_akhir_kwt, 0)) as saldo_toko3, sum(if(a.toko_kode='VO0006', 
		a.saldo_akhir_kwt, 0)) as saldo_gudang from saldo_barang_toko a where toko_kode in ('VO0006', 'VO0001', 'VO0002', 'VO0003') and 
		bulan=".date('m')." and tahun=".date('Y')." group by a.barang_kode) c on a.barang_kode=c.barang_kode 
		left join supplier d on a.supplier_kode=d.kode left join user e on a.user_id=e.username 
		where a.bukti='".$data['bukti']."' and a.is_hapus='0' order by a.urut";
		//echo $query; exit;
		//
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
		function getDataBarangCetakop($data){
		$query = "select a.bukti, a.tanggal, d.nama_supplier, a.barang_kode, b.nama_barang, a.kwt, a.harga, a.harga_asli, a.diskon1, a.ppn, a.jumlah,
		a.keterangan, b.satuan,e.nama as nama_user  
		from op a left join barang b on a.barang_kode=b.kode 
		left join supplier d on a.supplier_kode=d.kode left join user e on a.user_id=e.username 
		where a.bukti='".$data['bukti']."' and a.is_hapus='0' order by a.urut";
		//echo $query; exit;
		//
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	function HapusOP($data){
		$query = "update op set is_hapus='1' where bukti='".$data['bukti']."'";
		if(isset($data['barang_kode'])){
			$query .= " and barang_kode='".$data['barang_kode']."'";
		}
		
		$this->db->query($query);
	}
	
	function setStatusOP($buktiOP){
		$query = "update op set is_receive='1' where bukti='".$buktiOP."'";
		
		$this->db->query($query);
	}
	
	function getHargaBarangSupplier($data){
		$query = "select if(date(NOW()) < periode, harga, harga_periode) as harga 
		from harga_barang_supplier 
		where barang_kode='".$data['barang_kode']."' and supplier_kode='".$data['supplier_kode']."'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getStokDC($data){
		$query = "select saldo_akhir_kwt from saldo_barang_toko 
		where barang_kode='".$data['barang_kode']."' and toko_kode='VO0006' and bulan=".date('m')." and tahun=".date('Y')."";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}

	function getJumlahBarangJual($data){
		$query = "select a.fitemkey, count(a.fitemkey) as jum from rst_fc_trans_detail a left join rst_fc_trans_header b on a.fcode=b.fcode and a.flokasi=b.flokasi where month(b.fdate)=".$data['bulan']." and year(b.fdate)=".$data['tahun']." and a.fstatuskey='1' and b.fstatuskey='1' and a.fitemkey='".$data['barang_kode']."' group by a.fitemkey";

		$result = $this->db->query($query);
		$resultArr = $result->result_array();
		if(sizeof($resultArr) > 0){
			return $resultArr[0]['jum'];
		}else{
			return 0;
		}
	}

	function getRekapOrderPembelian($data){
		$query = "select a.bukti, a.supplier_kode, c.nama_supplier, a.tanggal, sum(a.kwt * a.harga) as dpp, sum(a.kwt * a.ppn) as ppn, sum(a.jumlah) as jumlah from op a left join supplier c on a.supplier_kode = c.kode where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' group by a.bukti, a.supplier_kode, a.tanggal order by a.tanggal asc, a.bukti asc";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}

	function getRekapKelompokOrderPembelian($data){
		$query = "select b.kategori, c.nama, sum(a.jumlah) as jumlah from op a left join barang b on a.barang_kode=b.kode left join kategori_barang c on b.kategori=c.kode where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' group by b.kategori";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
}