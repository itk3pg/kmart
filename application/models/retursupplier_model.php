<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Retursupplier_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataReturSupplier($data){
		$query = "select a.bukti, a.tanggal, a.barang_kode, b.nama_barang, b.satuan, a.kwt, if(b.is_ppn='1', a.harga, (a.harga + a.ppn)) as harga, if(b.is_ppn='1', a.ppn, 0) as ppn, a.jumlah, 
		a.supplier_kode, c.nama_supplier, a.keterangan, a.tukar_nota_bukti 
		from retur_supplier a left join barang b on a.barang_kode=b.kode left join supplier c on a.supplier_kode=c.kode 
		where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' 
		order by a.tanggal desc, a.bukti";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataListReturSupplier($data){
		$query = "select a.bukti, a.tanggal, a.supplier_kode, c.nama_supplier 
		from retur_supplier a left join supplier c on a.supplier_kode=c.kode 
		where year(a.tanggal)=".$data['tahun']." and month(a.tanggal)=".$data['bulan']." and a.is_hapus='0' group by a.bukti 
		order by a.tanggal desc, a.bukti";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanReturSupplier($data){
		$query = "";
		if($data['mode'] == "i"){
			$query = "insert into retur_supplier(bukti, tanggal, barang_kode, kwt, harga, ppn, jumlah, supplier_kode, keterangan, is_hapus, status, user_id, waktu_insert, waktu_update) 
			values('".$data['bukti']."', '".$data['tanggal']."', '".$data['barang_kode']."', ".$data['kwt'].", ".$data['harga'].", ".$data['ppn'].", ".$data['jumlah'].", '".$data['supplier_kode']."', 
			'', '0', '0', '".$this->session->userdata('username')."', NOW(), NOW())";
		}else{
			$query = "insert into retur_supplier(bukti, tanggal, barang_kode, kwt, harga, ppn, jumlah, supplier_kode, keterangan, is_hapus, status, user_id, waktu_insert, waktu_update) 
			values('".$data['bukti']."', '".$data['tanggal']."', '".$data['barang_kode']."', ".$data['kwt'].", ".$data['harga'].", ".$data['ppn'].", ".$data['jumlah'].", '".$data['supplier_kode']."', 
			'', '0', '0', '".$this->session->userdata('username')."', NOW(), NOW()) on duplicate key update tanggal='".$data['tanggal']."', 
			supplier_kode='".$data['supplier_kode']."', kwt=".$data['kwt'].", harga=".$data['harga'].", ppn=".$data['ppn'].", jumlah=".$data['jumlah'].", is_hapus='0'";
		}
		
		$this->db->query($query);
		
		$querySelect = "select bukti, supplier_kode, tanggal, sum(jumlah) as jumlah from retur_supplier where bukti='".$data['bukti']."' and supplier_kode='".$data['supplier_kode']."' and is_hapus='0' group by bukti, supplier_kode, tanggal";
		
		$resultSelect = $this->db->query($querySelect);
		$resultSelectArr =  $resultSelect->result_array();
		
		$this->SimpanSaldoReturSupplier($resultSelectArr[0]);
	}
	
	function SimpanSaldoReturSupplier($data){
		$query = "insert into saldo_retur_supplier(ref_bukti, supplier_kode, unit_kode, tanggal, jumlah, status) values('".$data['bukti']."', '".$data['supplier_kode']."', 'VO0006', '".$data['tanggal']."', ".$data['jumlah'].", '0') on duplicate key update tanggal='".$data['tanggal']."', jumlah=".$data['jumlah']."";
		
		$this->db->query($query);
	}
	
	function getDataBarangReturSupplier($data){
		$query = "select a.bukti, a.tanggal, a.barang_kode, b.nama_barang, b.satuan, a.kwt, if(b.is_ppn='1', a.harga, (a.harga + a.ppn)) as harga, if(b.is_ppn='1', a.ppn, 0) as ppn, a.jumlah, a.supplier_kode, c.nama_supplier, a.keterangan 
		from retur_supplier a left join barang b on a.barang_kode=b.kode left join supplier c on a.supplier_kode=c.kode  
		where a.bukti='".$data['bukti']."' and a.is_hapus='0'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getRekapReturSupplier($data){
		$query = "";
		if(isset($data['supplier_kode'])){
			//$query = "select a.bukti, a.tanggal, a.supplier_kode, sum(a.jumlah) as jumlah from retur_supplier a where a.supplier_kode='".$data['supplier_kode']."' and (a.tukar_nota_bukti is null or a.tukar_nota_bukti='') and a.is_hapus='0' group by a.bukti, a.supplier_kode order by a.tanggal desc";
			
			$query = "select a.ref_bukti as bukti, a.tanggal, a.supplier_kode, a.jumlah from saldo_retur_supplier a where a.supplier_kode='".$data['supplier_kode']."' and (a.tukar_nota_bukti is null or a.tukar_nota_bukti='') and a.status='0' order by a.tanggal desc";
		}else{
			//$query = "select a.bukti, a.tanggal, a.supplier_kode, sum(a.jumlah) as jumlah from retur_supplier a where a.tukar_nota_bukti='".$data['tukar_nota_bukti']."' and a.is_hapus='0' group by a.bukti, a.supplier_kode order by a.tanggal desc";
			
			$query = "select a.ref_bukti as bukti, a.tanggal, a.supplier_kode, a.jumlah from saldo_retur_supplier a where a.tukar_nota_bukti='".$data['tukar_nota_bukti']."' order by a.tanggal desc";
		}
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function HapusReturSupplier($data){
		$query = "update retur_supplier set is_hapus='1' where bukti='".$data['bukti']."'";
		if(isset($data['barang_kode'])){
			$query .= " and barang_kode='".$data['barang_kode']."'";
		}
		
		$this->db->query($query);
		
		$queryDelete = "delete from saldo_retur_supplier where ref_bukti='".$data['bukti']."'";
		$this->db->query($queryDelete);
	}
	
	function getDataBarangSupplier($data){
		$query = "select a.kode, a.nama_barang, a.satuan, 
		b.supplier_kode, c.harga, d.pkp from barang a left join barang_supplier b on a.kode=b.barang_kode left join harga_barang_supplier c on a.kode=c.barang_kode and b.supplier_kode=c.supplier_kode left join supplier d on b.supplier_kode=d.kode 
		where b.supplier_kode='".$data['supplier_kode']."' and a.is_hapus='0'";
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function setStatusReturSupplier($data){
		$query = "update retur_supplier a set a.tukar_nota_bukti='".$data['tukar_nota_bukti']."' where a.bukti='".$data['retur_bukti']."' and a.supplier_kode='".$data['supplier_kode']."'";
		//echo $query."<br/>"; 
		$this->db->query($query);
		
		$queryUpdate = "update saldo_retur_supplier set tukar_nota_bukti='".$data['tukar_nota_bukti']."', `status`='1' where ref_bukti='".$data['retur_bukti']."' and supplier_kode='".$data['supplier_kode']."'";
		$this->db->query($queryUpdate);
	}
	
	function HapusStatusReturSupplier($data){
		$query = "update retur_supplier set tukar_nota_bukti=NULL where tukar_nota_bukti='".$data['bukti']."'";
		$this->db->query($query);
		
		$queryHapus = "update saldo_retur_supplier set tukar_nota_bukti=NULL, `status`='0' where tukar_nota_bukti='".$data['bukti']."'";
		$this->db->query($queryHapus);
	}

	function getAllDataRetur($data){
		$query = "select a.barang_kode, a.tanggal from retur_supplier a where a.bukti='".$data['bukti']."'";
		$result = $this->db->query($query);
		
		return $result->result_array();
	}

	function getLapRekapReturSupplier($data){
		$query = "select a.bukti, a.supplier_kode, c.nama_supplier, a.tanggal, sum(if(b.is_ppn='1', (a.kwt * a.harga), (a.kwt * (a.harga + a.ppn)))) as dpp, sum(if(b.is_ppn='1', a.kwt * a.ppn, 0)) as ppn, sum(a.jumlah) as jumlah from retur_supplier a left join barang b on a.barang_kode=b.kode left join supplier c on a.supplier_kode = c.kode where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' group by a.bukti, a.supplier_kode, a.tanggal order by a.tanggal asc, a.bukti asc";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}

	function getRekapKelompokReturSupplier($data){
		$query = "select b.kategori, c.nama, sum(a.jumlah) as jumlah from retur_supplier a left join barang b on a.barang_kode=b.kode left join kategori_barang c on b.kategori=c.kode where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' group by b.kategori";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
}