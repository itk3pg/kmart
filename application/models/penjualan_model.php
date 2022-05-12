<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penjualan_model extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function getDataPenjualan($data){
		$query = "select a.fcode, DATE_FORMAT(a.fdate,'%d-%m-%Y') as fdate, a.fcustkey, a.fcustname, a.fcodecashier as fcreatedby, c.nama as nama_kasir, a.fbill_amount, a.fcash as fpayment, a.fkupon, a.fshu, a.fdebet, a.fkredit, a.fcash_change as fchange from rst_fc_trans_header a left join user c on a.fcodecashier=c.username where date(a.fdate)='".$data['tanggal']."' and a.fname_payment='".$data['mode']."' and a.fbill_amount is not null and a.flokasi='".$data['toko_kode']."' order by date(a.fdate), a.fcodecashier, a.fcode";
			
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function SimpanEditPelanggan($data){
		// edit pelanggan header
		$queryHeader = "update rst_fc_trans_header set fcustkey='".$data['fcustkey']."', fcustname='".$data['fcustname']."' 
		where fcode='".$data['fcode']."'";
		
		$this->db->query($queryHeader);
		
		// edit pelanggan piutang
		$queryPiutang = "update piutang set pelanggan_kode='".$data['fcustkey']."' where ref_penjualan='".$data['fcode']."'";
		$this->db->query($queryPiutang);
	}
}

?>