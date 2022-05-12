<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tukarnota_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataTukarNota($data){
		$query = "select a.bukti, a.supplier_kode, c.nama_supplier, a.tanggal, a.jumlah_hutang, a.jumlah_potong, a.jumlah_listing, a.sisa_hutang, a.jatuh_tempo, a.`status`, b.pengadaan_bukti from tukar_nota a left join detail_tukar_nota b on a.bukti=b.tukar_nota_bukti left join supplier c on a.supplier_kode=c.kode left join hutang d on a.supplier_kode=d.supplier_kode and b.pengadaan_bukti=d.ref_pengadaan where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' group by a.bukti, a.supplier_kode order by a.tanggal desc, a.bukti desc";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataListTukarNota($data){
		$query = "select a.bukti, a.supplier_kode, a.tanggal, a.jumlah_hutang, a.jumlah_potong, a.sisa_hutang, a.jatuh_tempo, a.`status`, b.pengadaan_bukti from tukar_nota a left join detail_tukar_nota b on a.bukti=b.tukar_nota_bukti where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanTukarNota($data){
		$query = "";
		if($data['mode'] == "i"){
			$query = "insert into tukar_nota(bukti, supplier_kode, tanggal, jumlah_hutang, jumlah_potong, jumlah_listing, sisa_hutang, jatuh_tempo, `status`, user_id, is_hapus, waktu_insert, waktu_update) values('".$data['bukti']."', '".$data['supplier_kode']."', '".$data['tanggal']."', ".$data['jumlah_hutang'].", ".$data['jumlah_potong'].", ".$data['jumlah_listing'].", ".$data['sisa_hutang'].", '".$data['jatuh_tempo']."', '0','".$this->session->userdata('username')."', '0', NOW(), NOW())";
		}else{
			$query = "update tukar_nota set jumlah_hutang=".$data['jumlah_hutang'].", jumlah_potong=".$data['jumlah_potong'].", jumlah_listing=".$data['jumlah_listing'].", sisa_hutang=".$data['sisa_hutang'].", jatuh_tempo='".$data['jatuh_tempo']."', waktu_update=NOW() where bukti='".$data['bukti']."' and supplier_kode='".$data['supplier_kode']."'";
		}
		
		$this->db->query($query);
	}
	
	function SimpanDetailTukarNota($data){
		$query = "insert into detail_tukar_nota(tukar_nota_bukti, pengadaan_bukti, no_faktur) values('".$data['bukti']."', '".$data['pengadaan_bukti']."', '".$data['no_faktur']."')";
		
		$this->db->query($query);
	}
	
	function getDataBuktiTukarNota($data){
		$query = "select a.tukar_nota_bukti, a.pengadaan_bukti, b.tanggal, b.jumlah from detail_tukar_nota a left join hutang b on a.pengadaan_bukti=b.ref_pengadaan where a.tukar_nota_bukti='".$data['tukar_nota_bukti']."'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataPenerimaanSupplier($data){
		$query = "select a.ref_pengadaan, a.supplier_kode, date(a.tanggal) as tanggal, a.jumlah, sum(if(b.jumlah is null, 0, b.jumlah)) as jumlah_pembayaran, c.bukti as bukti_penyesuaian, if(substr(c.bukti, 1,2)='HK', (c.jumlah*-1), c.jumlah) as jumlah_penyesuaian from hutang a left join (select * from pembayaran_hutang where is_hapus='0') b on a.ref_pengadaan=b.ref_pengadaan left join (select * from hutang_penyesuaian where is_hapus='0') c on a.ref_pengadaan=c.pengadaan_barang_bukti and a.supplier_kode=c.supplier_kode where a.supplier_kode='".$data['supplier_kode']."' and a.is_lunas='0' and (a.tukar_nota_bukti='' or a.tukar_nota_bukti is null) group by a.ref_pengadaan, a.supplier_kode";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataPenerimaanTukarNota($data){
		$query = "select a.tukar_nota_bukti, a.pengadaan_bukti, date(b.tanggal) as tanggal, b.jumlah, a.no_faktur, c.bukti as bukti_penyesuaian, if(substr(c.bukti, 1,2)='HK', (c.jumlah*-1), c.jumlah) as jumlah_penyesuaian from detail_tukar_nota a left join hutang b on a.pengadaan_bukti=b.ref_pengadaan left join (select * from hutang_penyesuaian where is_hapus='0') c on b.ref_pengadaan=c.pengadaan_barang_bukti and b.supplier_kode=c.supplier_kode where a.tukar_nota_bukti='".$data['tukar_nota_bukti']."'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function HapusTukarNota($data){
		$query = "update tukar_nota set is_hapus='1' where bukti='".$data['bukti']."'";
		
		$this->db->query($query);
	}
	
	function HapusDetailTukarNota($data){
		$query = "delete from detail_tukar_nota where tukar_nota_bukti='".$data['bukti']."'";
		
		$this->db->query($query);
	}
	
	function setStatusTukarNota($buktiTukarNota){
		$query = "update tukar_nota set status='1' where bukti='".$buktiTukarNota."'";
		
		$this->db->query($query);
	}
	
	function getDataSelectTukarNota(){
		$query = "select a.bukti, b.nama_supplier from tukar_nota a left join supplier b on a.supplier_kode=b.kode where a.`status`='0' and a.is_hapus='0' order by a.tanggal desc";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getLaporanTukarNota($data){
		$query = "select a.bukti, a.supplier_kode, c.nama_supplier, DATE_FORMAT(a.tanggal,'%d/%m/%Y') as tanggal, a.jumlah_hutang, a.jumlah_listing, a.jumlah_potong, b.pengadaan_bukti, DATE_FORMAT(d.tanggal,'%d/%m/%Y') as tanggal_pengadaan, b.no_faktur, d.jumlah, if(e.jumlah_pembayaran is null, 0, e.jumlah_pembayaran) as jumlah_pembayaran, if(f.jumlah is null, 0, if(substr(f.bukti, 1,2)='HK', (f.jumlah*-1), f.jumlah)) as jumlah_penyesuaian, f.bukti as bukti_penyesuaian, c.top, c.no_rekening, c.nama_bank, c.atas_nama, DATE_FORMAT(a.jatuh_tempo,'%d/%m/%Y') as jatuh_tempo from tukar_nota a left join detail_tukar_nota b on a.bukti=b.tukar_nota_bukti left join supplier c on a.supplier_kode=c.kode left join hutang d on b.pengadaan_bukti=d.ref_pengadaan and a.supplier_kode=d.supplier_kode left join (select ref_pengadaan, supplier_kode, sum(jumlah) as jumlah_pembayaran from pembayaran_hutang where is_hapus='0' group by ref_pengadaan, supplier_kode) e on d.ref_pengadaan=e.ref_pengadaan and d.supplier_kode=e.supplier_kode left join hutang_penyesuaian f on b.tukar_nota_bukti=f.tukar_nota_bukti and b.pengadaan_bukti=f.pengadaan_barang_bukti where a.bukti='".$data['bukti']."' and a.is_hapus='0'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getLaporanRetur($data){
		$query = "select g.ref_bukti as bukti, g.supplier_kode, '' as nama_supplier, g.tanggal, 0 as jumlah_hutang, 0 as jumlah_listing, 0 as jumlah_potong, g.ref_bukti as pengadaan_bukti, g.tanggal, '' as no_faktur, g.jumlah, 0 as jumlah_pembayaran, 0 as jumlah_pembayaran, '' as bukti_penyesuaian, 0 as top, '' as no_rekening, '' as nama_bank, '' as atas_nama, g.tanggal as jatuh_tempo from saldo_retur_supplier g where g.tukar_nota_bukti='".$data['bukti']."'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getLaporanListing($data){
		$query = "select g.bukti as bukti, g.supplier_kode, '' as nama_supplier, g.tanggal, 0 as jumlah_hutang, 0 as jumlah_listing, 0 as jumlah_potong, g.bukti as pengadaan_bukti, g.tanggal, '' as no_faktur, g.jumlah, 0 as jumlah_pembayaran, 0 as jumlah_pembayaran, '' as bukti_penyesuaian, 0 as top, '' as no_rekening, '' as nama_bank, '' as atas_nama, g.tanggal as jatuh_tempo from pendapatan_lain g where g.tukar_nota_bukti='".$data['bukti']."' and g.is_hapus='0'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getJumlahRetur($data){
		$query = "select sum(a.jumlah) as jumlah from retur_supplier a where a.tukar_nota_bukti='".$data['bukti']."' and a.is_hapus='0' group by a.tukar_nota_bukti";
		
		$result = $this->db->query($query);
		$rsultArr = $result->result_array();
		$jumlah = 0;
		if(sizeof($rsultArr) == 0){
			$jumlah = 0;
		}else{
			$jumlah = $rsultArr[0]['jumlah'];
		}
		
		return $jumlah;
	}
	
	function getJumlahPendapatanLain($data){
		$query = "select sum(a.jumlah) as jumlah from pendapatan_lain a where a.tukar_nota_bukti='".$data['bukti']."' and a.is_hapus='0' group by a.tukar_nota_bukti";
		
		$result = $this->db->query($query);
		$rsultArr = $result->result_array();
		$jumlah = 0;
		if(sizeof($rsultArr) == 0){
			$jumlah = 0;
		}else{
			$jumlah = $rsultArr[0]['jumlah'];
		}
		
		return $jumlah;
	}
}