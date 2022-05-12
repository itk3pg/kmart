<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pendapatanlain_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataPendapatanLain($data){
		$query = "select a.bukti, a.supplier_kode, b.nama_supplier, a.tanggal, a.toko_kode, c.nama as nama_toko, sum(a.dpp) as dpp, sum(a.ppn) as ppn, sum(a.jumlah) as jumlah, ifnull(a.tukar_nota_bukti, '') as tukar_nota_bukti, a.kasbank_bukti, a.status_pembayaran, if(a.tanggal=date(NOW()), '0', if(a.is_edited='0', '1', '0')) as status_tanggal from pendapatan_lain a left join supplier b on a.supplier_kode=b.kode left join toko c on a.toko_kode=c.kode where a.is_hapus='0' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." group by a.bukti, a.supplier_kode order by a.tanggal desc, a.bukti desc";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}

	function getDataPendapatanLainCetak($data){
		$query = "select a.bukti, a.supplier_kode, b.nama_supplier, a.tanggal, a.keterangan, a.toko_kode, c.nama as nama_toko, a.dpp, a.ppn, a.jumlah, ifnull(a.tukar_nota_bukti, '') as tukar_nota_bukti, a.kasbank_bukti, a.status_pembayaran from pendapatan_lain a left join supplier b on a.supplier_kode=b.kode left join toko c on a.toko_kode=c.kode where a.is_hapus='0' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." order by a.bukti, a.supplier_kode, a.tanggal";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanPendapatanLain($data){
		$query = "";
		if($data['mode'] == "i"){
			$query = "insert into pendapatan_lain(bukti, supplier_kode, tanggal, keterangan, toko_kode, dpp, ppn, jumlah, status_pembayaran, is_hapus, user_id, waktu_insert, waktu_update) 
			values('".$data['bukti']."', '".$data['supplier_kode']."', '".$data['tanggal']."', '".$this->db->escape_str($data['keterangan'])."', '".$data['toko_kode']."', ".$data['dpp'].", ".$data['ppn'].", ".$data['jumlah'].", 
			'".$data['status_pembayaran']."', '0', '".$this->session->userdata('username')."', NOW(), NOW())";
		}else{
			$query = "insert into pendapatan_lain(bukti, supplier_kode, tanggal, keterangan, toko_kode, dpp, ppn, jumlah, status_pembayaran, is_hapus, user_id, waktu_insert, waktu_update) 
			values('".$data['bukti']."', '".$data['supplier_kode']."', '".$data['tanggal']."', '".$this->db->escape_str($data['keterangan'])."', '".$data['toko_kode']."', ".$data['dpp'].", ".$data['ppn'].", ".$data['jumlah'].", 
			'".$data['status_pembayaran']."', '0', '".$this->session->userdata('username')."', NOW(), NOW()) on duplicate key update tanggal='".$data['tanggal']."', keterangan='".$this->db->escape_str($data['keterangan'])."', toko_kode='".$data['toko_kode']."', dpp=".$data['dpp'].", ppn=".$data['ppn'].", jumlah=".$data['jumlah'].", is_edited='0', is_hapus='0', user_id='".$this->session->userdata('username')."', waktu_update=NOW()";
		}
		
		$this->db->query($query);
	}
	
	function HapusPendapatanLain($data){
		$query = "update pendapatan_lain set is_hapus='1', waktu_hapus=NOW(), user_hapus='".$this->session->userdata('username')."' where bukti='".$data['bukti']."' and supplier_kode='".$data['supplier_kode']."'";
		
		$this->db->query($query);
	}

	function BukaAkses($data){
		$query = "update pendapatan_lain set is_edited='1' where bukti='".$data['bukti']."' and supplier_kode='".$data['supplier_kode']."'";
		
		$this->db->query($query);
	}
	
	function getDetailPendapatanLain($data){
		$query = "select a.bukti, a.supplier_kode, b.nama_supplier, a.tanggal, a.keterangan, a.dpp, a.ppn, a.jumlah, a.status_pembayaran from pendapatan_lain a left join supplier b on a.supplier_kode=b.kode where a.is_hapus='0' and a.bukti='".$data['bukti']."' and a.supplier_kode='".$data['supplier_kode']."' order by a.tanggal desc, a.bukti desc";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataPendapatanLainPotongan($data){
		$query = "";
		if(isset($data['supplier_kode'])){
			$query = "select a.bukti, a.tanggal, a.supplier_kode, a.keterangan, a.dpp, a.ppn, a.jumlah from pendapatan_lain a where a.supplier_kode='".$data['supplier_kode']."' and (a.tukar_nota_bukti is null or a.tukar_nota_bukti='') and a.is_hapus='0' and a.status_pembayaran='0' order by a.tanggal desc, a.bukti desc";
		}else{
			$query = "select a.bukti, a.tanggal, a.supplier_kode, a.keterangan, a.dpp, a.ppn, a.jumlah from pendapatan_lain a where a.tukar_nota_bukti='".$data['tukar_nota_bukti']."' and a.is_hapus='0' and a.status_pembayaran='0' order by a.tanggal desc, a.bukti desc";
		}
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function setStatusPendapatanLain($data){
		$query = "update pendapatan_lain a set a.tukar_nota_bukti='".$data['tukar_nota_bukti']."' where a.bukti='".$data['pendapatanlain_bukti']."' and a.supplier_kode='".$data['supplier_kode']."'";
		//echo $query."<br/>";
		$this->db->query($query);
	}
	
	function HapusStatusPendapatanLain($data){
		$query = "update pendapatan_lain set tukar_nota_bukti=NULL where tukar_nota_bukti='".$data['bukti']."'";
		$this->db->query($query);
	}
}

?>