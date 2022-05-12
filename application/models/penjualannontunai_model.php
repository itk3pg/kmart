<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjualannontunai_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getDataPenjualanNonTunai($data){
		$query = "select a.fcode, a.fdate, a.fcodecashier, a.fnocashier, a.fcustkey, a.fstatuskey, a.fcustname, b.fitemkey, c.nama_barang, b.fqty, b.fprice, b.ftotal, c.hpp 
		from rst_fc_trans_header a left join rst_fc_trans_detail b on a.fcode=b.fcode left join barang c on b.fitemkey=c.kode 
		where (a.fstatuskey='5' or a.fstatuskey='6') and a.flokasi='".$data['toko_kode']."' and month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']."";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function SimpanEditHarga($data){
		$query = "update rst_fc_trans_detail set fprice=".$data['harga'].", ftotal=".$data['total']." 
		where fcode='".$data['bukti']."' and fitemkey='".$data['barang_kode']."'";
		
		$this->db->query($query);
	}
	
	function ApproveHarga($data){
		$query = "update rst_fc_trans_header set fstatuskey='6' where fcode='".$data['bukti']."'";
		
		$this->db->query($query);
	}
}