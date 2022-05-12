<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exportdbf_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getDataPembelianKredit($data){
		$query = "select a.tanggal, a.bukti, a.supplier_kode, b.nama_supplier, sum(a.kwt * a.harga) as dpp, sum(a.kwt * a.ppn) as ppn, sum(a.jumlah) as total from pengadaan_barang a left join supplier b on a.supplier_kode=b.kode where a.is_hapus='0' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.status_pembayaran='K' group by a.bukti, a.supplier_kode order by a.tanggal, a.bukti";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getDataPembelianTunai($data){
		$query = "select a.tanggal, a.bukti, a.supplier_kode, b.nama_supplier, sum(a.kwt * a.harga) as dpp, sum(a.kwt * a.ppn) as ppn, sum(a.jumlah) as total from pengadaan_barang a left join supplier b on a.supplier_kode=b.kode where a.is_hapus='0' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.status_pembayaran='T' group by a.bukti, a.supplier_kode order by a.tanggal, a.bukti";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getDataReturSupplier($data){
		$query = "select a.tanggal, a.bukti, a.supplier_kode, b.nama_supplier, sum(a.kwt * a.harga) as dpp, sum(a.kwt * a.ppn) as ppn, sum(a.jumlah) as total from retur_supplier a left join supplier b on a.supplier_kode=b.kode where a.is_hapus='0' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' group by a.bukti, a.supplier_kode";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getDataPembayaranHutang($data){
		$query = "select date(a.waktu_transfer) as tanggal, a.bukti, b.supplier_kode, c.nama_supplier, a.bukti as bukti_rencana_pembayaran, a.bukti as bukti_nota, b.jumlah_hutang, b.jumlah_potong, b.jumlah_listing, b.sisa_hutang as total_bayar, a.bukti as bukti_bayar, b.sisa_hutang as jumlah_bayar, a.realisasi_bank as nama_bank, a.realisasi_melalui from permintaan_pembayaran a left join tukar_nota b on a.tukar_nota_bukti=b.bukti left join supplier c on b.supplier_kode=c.kode where a.is_hapus='0' and month(a.waktu_transfer)=".$data['bulan']." and year(a.waktu_transfer)=".$data['tahun']." and a.`status`='4'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getLaporanDBF($data){
		$query = "select bukti, kd_kb, kd_cb, unit_kode, tanggal, kode_subject, nama_subject, keterangan, jumlah, no_ref, no_ref_dropping, toko_kode, fcharge_trans, `status`, user_id, is_hapus, waktu_update from kasbank where kd_kb='223' and kd_cb='190' and MONTH(tanggal)=".$data['bulan']." and YEAR(tanggal)=".$data['tahun']." and is_hapus='0' and SUBSTR(no_ref,1,2)='DP'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getLaporanDroppingKasKecil($data){
		$query = "select a.bukti, a.unit_kode, date(a.waktu_realisasi) as waktu_realisasi, a.jumlah from dropping_kaskecil a where a.is_realisasi='1' and a.is_hapus='0' and month(a.waktu_realisasi)=".$data['bulan']." and year(a.waktu_realisasi)=".$data['tahun']."";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
}