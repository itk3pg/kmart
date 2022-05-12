<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Supplier_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataSupplier(){
		$query = "select a.kode, a.nama_supplier, a.alamat, a.kota, a.provinsi, a.no_telp, a.npwp, a.pkp, a.nama_bank, a.no_rekening, a.top, a.atas_nama, a.fee_konsinyasi 
		from supplier a";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getListDataSupplier($data){
		$query = "select a.kode, a.nama_supplier, a.alamat, a.kota, a.provinsi, a.no_telp, a.npwp 
		from supplier a  
		where a.nama_supplier like '".$data['q']."%' or a.kode like '".$data['q']."%'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanSupplier($data){
		/**
		 * `kd_pelanggan` varchar(6) NOT NULL,
		  `nama_pelanggan` varchar(100) DEFAULT NULL,
		  `alamat` varchar(400) DEFAULT NULL,
		  `kota` varchar(45) DEFAULT NULL,
		  `provinsi` varchar(45) DEFAULT NULL,
		  `no_telp` varchar(45) DEFAULT NULL
		 */
		if($data['supplier_mode'] == "1"){ // untuk insert
			$queryselect = "select kode from `supplier` where kode='".$data['kode']."'";
			$result = $this->db->query($queryselect);
			$resultArr = $result->result_array();
	  
			if(sizeof($resultArr) > 0){
				return "-1";
			}else{
				$query = "insert into supplier(kode, nama_supplier, alamat, kota, provinsi, no_telp, npwp, pkp, top, nama_bank, no_rekening, atas_nama, fee_konsinyasi) 
				values('".$data['kode']."','".$data['nama_supplier']."','".$data['alamat']."',
				'".$data['kota']."','".$data['provinsi']."','".$data['no_telp']."','".$data['npwp']."','".$data['pkp']."', '".$data['top']."', '".$data['nama_bank']."', '".$data['no_rekening']."', '".$data['atas_nama']."', ".$data['fee_konsinyasi'].")";
				$this->db->query($query);
				return "1";
			}
		}else{ // untuk update
			$query = "update supplier set nama_supplier='".$data['nama_supplier']."', 
			alamat='".$data['alamat']."', kota='".$data['kota']."', provinsi='".$data['provinsi']."', 
			no_telp='".$data['no_telp']."', npwp='".$data['npwp']."', pkp='".$data['pkp']."', top='".$data['top']."', nama_bank='".$data['nama_bank']."', no_rekening='".$data['no_rekening']."', atas_nama='".$data['atas_nama']."', fee_konsinyasi=".$data['fee_konsinyasi']." 
			where kode='".$data['kode']."'";
			// echo $query;
			$this->db->query($query);
			return "1";
		}
		
		
	}
	
	function HapusSupplier($data){
		$this->db->trans_begin();

		$query1 = "delete from barang_supplier where supplier_kode='".$data['kode']."'";
		$query2 = "delete from harga_barang_supplier where supplier_kode='".$data['kode']."'";
		$query3 = "delete from hutang where supplier_kode='".$data['kode']."'";
		$query4 = "delete from hutang_penyesuaian where is_hapus='1' and supplier_kode='".$data['kode']."'";
		$query5 = "delete from op where is_hapus='1' and supplier_kode='".$data['kode']."'";
		$query6 = "delete from pendapatan_lain where is_hapus='1' and supplier_kode='".$data['kode']."'";
		$query7 = "delete from pengadaan_barang where is_hapus='1' and supplier_kode='".$data['kode']."'";
		$query8 = "delete from pengadaan_barang_bkl where is_hapus='1' and supplier_kode='".$data['kode']."'";
		$query9 = "delete from pengadaan_barang_konsinyasi where is_hapus='1' and supplier_kode='".$data['kode']."'";
		$query10 = "delete from retur_supplier where is_hapus='1' and supplier_kode='".$data['kode']."'";
		$query11 = "delete from retur_supplier_konsinyasi where is_hapus='1' and supplier_kode='".$data['kode']."'";
		$query12 = "delete from saldo_hutang where supplier_kode='".$data['kode']."'";
		$query13 = "delete from saldo_retur_supplier where supplier_kode='".$data['kode']."'";
		$query14 = "delete from tukar_nota where is_hapus='1' and supplier_kode='".$data['kode']."'";
		$query15 = "delete from um_pembelian where supplier_kode='".$data['kode']."'";
		$query = "delete from supplier where kode='".$data['kode']."'";
		
		$this->db->query($query1);
		$this->db->query($query2);
		$this->db->query($query3);
		$this->db->query($query4);
		$this->db->query($query5);
		$this->db->query($query6);
		$this->db->query($query7);
		$this->db->query($query8);
		$this->db->query($query9);
		$this->db->query($query10);
		$this->db->query($query11);
		$this->db->query($query12);
		$this->db->query($query13);
		$this->db->query($query14);
		$this->db->query($query15);
		$this->db->query($query);

		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
		}

		$querySelect = "select kode from supplier where kode='".$data['kode']."'";
		$resultb = $this->db->query($querySelect);
		$resultbArr = $resultb->result_array();

		if(sizeof($resultbArr) > 0){
			return "-1";
		}else{
			return "1";
		}
	}
	
	function getDataTOP($data){
		$query = "select a.kode, a.top from supplier a where a.kode='".$data['supplier_kode']."'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
}
