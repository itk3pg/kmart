<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hutangpenyesuaian_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataHutangPenyesuaian($data){
		$query = "select a.bukti, a.supplier_kode, b.nama_supplier, a.tanggal, sum(a.jumlah) as jumlah, a.tukar_nota_bukti, a.pengadaan_barang_bukti from hutang_penyesuaian a left join supplier b on a.supplier_kode=b.kode where a.is_hapus='0' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." group by a.bukti, a.supplier_kode order by a.tanggal desc, a.bukti desc";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanHutangPenyesuaian($data){
		$query = "";
		if($data['mode'] == "i"){
			$query = "insert into hutang_penyesuaian(bukti, supplier_kode, tanggal, jumlah, status, pengadaan_barang_bukti, waktu_update, is_hapus, user_id) 
			values('".$data['bukti']."', '".$data['supplier_kode']."', '".$data['tanggal']."', ".$data['jumlah'].", 
			'0', '".$data['pengadaan_barang_bukti']."', NOW(), '0', '".$this->session->userdata('username')."')";
		}else{
			$query = "insert into hutang_penyesuaian(bukti, supplier_kode, tanggal, jumlah, status, pengadaan_barang_bukti, waktu_update, is_hapus, user_id) 
			values('".$data['bukti']."', '".$data['supplier_kode']."', '".$data['tanggal']."', ".$data['jumlah'].", 
			'0', '".$data['pengadaan_barang_bukti']."', NOW(), '0', '".$this->session->userdata('username')."') on duplicate key update tanggal='".$data['tanggal']."', jumlah=".$data['jumlah'].", is_hapus='0', user_id='".$this->session->userdata('username')."', waktu_update=NOW()";
		}
		
		$this->db->query($query);
	}
	
	function HapusHutangPenyesuaian($data){
		$query = "update hutang_penyesuaian set is_hapus='1' where bukti='".$data['bukti']."' and supplier_kode='".$data['supplier_kode']."'";
		
		$this->db->query($query);
	}
	
	/*function getDetailHutangPenyesuaian($data){
		$query = "select a.bukti, a.supplier_kode, b.nama_supplier, a.tanggal, a.keterangan, a.jumlah, a.status_pembayaran from hutang_penyesuaian a left join supplier b on a.supplier_kode=b.kode where a.is_hapus='0' and a.bukti='".$data['bukti']."' and a.supplier_kode='".$data['supplier_kode']."' order by a.tanggal desc, a.bukti desc";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}*/
	
	/*function getDataHutangPenyesuaianPotongan($data){
		$query = "";
		if(isset($data['supplier_kode'])){
			$query = "select a.bukti, a.tanggal, a.supplier_kode, a.keterangan, a.jumlah from hutang_penyesuaian a where a.supplier_kode='".$data['supplier_kode']."' and (a.tukar_nota_bukti is null or a.tukar_nota_bukti='') and a.is_hapus='0' and a.status_pembayaran='0' order by a.tanggal desc, a.bukti desc";
		}else{
			$query = "select a.bukti, a.tanggal, a.supplier_kode, a.keterangan, a.jumlah from hutang_penyesuaian a where a.tukar_nota_bukti='".$data['tukar_nota_bukti']."' and a.is_hapus='0' and a.status_pembayaran='0' order by a.tanggal desc, a.bukti desc";
		}
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}*/
	
	function setStatusHutangPenyesuaian($data){
		$query = "update hutang_penyesuaian a set a.tukar_nota_bukti='".$data['tukar_nota_bukti']."', a.status='1' where a.bukti='".$data['hutangpenyesuaian_bukti']."' and a.supplier_kode='".$data['supplier_kode']."'";
		//echo $query."<br/>";
		$this->db->query($query);
	}
	
	function HapusStatusHutangPenyesuaian(){
		$query = "update hutang_penyesuaian set tukar_nota_bukti=NULL, status='0' where tukar_nota_bukti='".$data['bukti']."'";
		$this->db->query($query);
	}
}

?>