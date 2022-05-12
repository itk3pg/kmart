<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permintaanpembayaran_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataPermintaanPembayaran($data){
		$query = "select a.bukti, a.tanggal, a.tukar_nota_bukti, a.`status`, a.waktu_terima_akuntansi, a.user_terima_akuntansi, a.waktu_verifikasi, a.waktu_ppu, a.waktu_transfer, b.supplier_kode, c.nama_supplier, b.jumlah_hutang, b.jumlah_potong, b.jumlah_listing, b.sisa_hutang, b.jatuh_tempo, a.waktu_insert from permintaan_pembayaran a left join tukar_nota b on a.tukar_nota_bukti=b.bukti left join supplier c on b.supplier_kode=c.kode where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' order by a.tanggal desc, a.bukti desc";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}

	function getDetailPermintaanPembayaran($data){
		$query = "select a.bukti, a.tanggal, a.tukar_nota_bukti, a.`status`, a.waktu_terima_akuntansi, a.user_terima_akuntansi, a.waktu_verifikasi, a.waktu_ppu, a.waktu_transfer, b.supplier_kode, c.nama_supplier, b.jumlah_hutang, b.jumlah_potong, b.jumlah_listing, b.sisa_hutang, b.jatuh_tempo, a.waktu_insert from permintaan_pembayaran a left join tukar_nota b on a.tukar_nota_bukti=b.bukti left join supplier c on b.supplier_kode=c.kode where a.bukti='".$data['bukti']."' and a.is_hapus='0'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	 //k3pg-ppn
	function getRekapPermintaanPembayaran($data){
		$query = "select a.supplier_kode, c.nama_supplier, b.ref_pengadaan, b.jumlah, d.no_faktur, round((b.jumlah/1.11)*0.11) as ppn, e.bukti as bukti_pb, a.bukti as bukti_tt from permintaan_pembayaran e left join tukar_nota a on e.tukar_nota_bukti=a.bukti left join hutang b on a.bukti=b.tukar_nota_bukti left join supplier c on a.supplier_kode=c.kode left join detail_tukar_nota d on a.bukti=d.tukar_nota_bukti and b.ref_pengadaan=d.pengadaan_bukti where (date(e.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and e.is_hapus='0' order by a.bukti";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function SimpanPermintaanPembayaran($data){
		$query = "";
		$query = "insert into permintaan_pembayaran(bukti, tukar_nota_bukti, tanggal, `status`, user_id, is_hapus, waktu_update, waktu_insert) values('".$data['bukti']."', '".$data['tukar_nota_bukti']."', '".$data['tanggal']."', '0', '".$this->session->userdata('username')."', '0', NOW(), NOW())";
		
		$this->db->query($query);
	}
	
	function HapusPermintaanPembayaran($data){
		$query = "update permintaan_pembayaran set is_hapus='1' where bukti='".$data['bukti']."'";
		
		$this->db->query($query);
		
		$querytukarnota = "update tukar_nota set status='0' where bukti='".$data['tukar_nota_bukti']."'";
		$this->db->query($querytukarnota);
	}
	
	function getDataTukarNota($data){
		$query = "select a.bukti, a.supplier_kode, b.nama_supplier, a.tanggal, a.jumlah_hutang, a.jumlah_potong, a.jumlah_listing, a.sisa_hutang, a.jatuh_tempo from tukar_nota a left join supplier b on a.supplier_kode=b.kode where a.bukti='".$data['tukar_nota_kode']."'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataPermintaanPembayaranLaporan($data){
		$query = "select realisasi_melalui, nomor_cek, realisasi_bank, date(waktu_transfer) as waktu_transfer from permintaan_pembayaran where bukti='".$data['bukti']."' and is_hapus='0'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function setStatusPermintaanPembayaran($data){
		$setwaktu = "";
		switch($data['status']){
			case "1" :
				$setwaktu = ", waktu_terima_akuntansi=NOW(), user_terima_akuntansi='".$this->session->userdata("username")."'";
				break;
			case "2" :
				$setwaktu = ", waktu_verifikasi=NOW(), user_verifikasi='".$this->session->userdata("username")."'";
				break;
			case "3" :
				$setwaktu = ", waktu_ppu=NOW(), user_ppu='".$this->session->userdata("username")."'";
				break;
			case "4" :
				$setwaktu = ", waktu_transfer=NOW(), user_realisasi='".$this->session->userdata("username")."'";
				break;
		}
		$query = "update permintaan_pembayaran set status='".$data['status']."'".$setwaktu." where bukti='".$data['bukti']."'";
		
		$this->db->query($query);
	}
	
	function SimpanRealisasi($data){
		$query = "update permintaan_pembayaran a set a.`status`='4', a.realisasi_melalui='".$data['melalui']."', a.nomor_cek='".$data['nomor_cek']."', a.realisasi_bank='".$data['bank']."', user_realisasi='".$this->session->userdata("username")."', waktu_transfer='".$data['tanggal_transfer']."' where a.bukti='".$data['bukti']."'";
		
		$this->db->query($query);
		
		$UpdateHutang = "update hutang set is_lunas='1', tanggal_lunas='".$data['tanggal_transfer']."' where tukar_nota_bukti='".$data['tukar_nota_bukti']."'";
		$this->db->query($UpdateHutang);
		
		$UpdateRetur = "update saldo_retur_supplier set `status`='2', waktu_realisasi='".$data['tanggal_transfer']."' where tukar_nota_bukti='".$data['tukar_nota_bukti']."'";
		$this->db->query($UpdateRetur);
		
		$UpdateListing = "update pendapatan_lain set waktu_realisasi='".$data['tanggal_transfer']."' where tukar_nota_bukti='".$data['tukar_nota_bukti']."'";
		$this->db->query($UpdateListing);
	}
	
	function getDataRekapHarian($data){
		$query = "select date(a.waktu_transfer) as tanggal, a.bukti, b.supplier_kode, c.nama_supplier, a.bukti as bukti_rencana_pembayaran, a.bukti as bukti_nota, b.jumlah_hutang, b.jumlah_potong, b.jumlah_listing, b.sisa_hutang as total_bayar, a.bukti as bukti_bayar, b.sisa_hutang as jumlah_bayar, a.realisasi_bank as nama_bank, a.realisasi_melalui from permintaan_pembayaran a left join tukar_nota b on a.tukar_nota_bukti=b.bukti left join supplier c on b.supplier_kode=c.kode where a.is_hapus='0' and (date(a.waktu_transfer) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.`status`='3'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
}

?>