<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stockopname_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDatastockopname($data){
		$query = "select a.bukti, a.toko_kode, a.barang_kode, a.tanggal, a.stok_sistem, a.stok_opname, a.selisih, a.user_id, b.barcode, b.nama_barang, a.rak, a.shlv, a.urut from stock_opname a left join barang b on a.barang_kode=b.kode where a.toko_kode='".$data['toko_kode']."' and a.bukti='".$data['tanggal']."' order by a.barang_kode";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanStockopname($data){
		$query = "";
		$username = $this->session->userdata('username');
		
		$query = "update stock_opname set stok_opname=".$data['stok_opname'].", selisih=".$data['selisih'].", user_id='".$username."', waktu_update=NOW() where bukti='".$data['bukti']."' and toko_kode='".$data['toko_kode']."' and barang_kode='".$data['barang_kode']."' and rak='".$data['rak']."' and shlv='".$data['shlv']."' and urut='".$data['urut']."'";
		
		$this->db->query($query);
	}

	function SimpanSO($data){
		$username = $this->session->userdata('username');
		$selisih = $data['stok_fisik'] - $data['stok_sistem'];
		$query = "insert into stock_opname(bukti, toko_kode, barang_kode, rak, shlv, urut, tanggal, stok_sistem, stok_opname, selisih, hpp, user_id, waktu_insert, waktu_update) values('".date("Y-m-d")."', '".$data['toko_kode']."', '".$data['barang_kode']."', '', '', '', NOW(), ".$data['stok_sistem'].", ".$data['stok_fisik'].", ".$selisih.", ".$data['hpp'].", '".$username."', NOW(), NOW()) on duplicate key update stok_sistem=".$data['stok_sistem'].", stok_opname=".$data['stok_fisik'].", selisih=".$selisih.", hpp=".$data['hpp'].", user_id='".$username."', waktu_update=NOW()";
		
		$this->db->query($query);
	}
	
	function HapusStockopname($data){
		$queryDelete = "delete from stock_opname where bukti='".$data['bukti']."'";
		
		$this->db->query($queryDelete);
	}
	
	function getBuktiStockOpname($data){
		$query = "select a.bukti from stock_opname a where a.toko_kode='".$data['toko_kode']."'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getStockToko($data){
		$query = "select saldo_akhir_kwt as jumlah from saldo_barang_toko where toko_kode='".$data['toko_kode']."' and barang_kode='".$data['barang_kode']."' and bulan=month(NOW()) and tahun=year(NOW())";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataRak($data){
		$query = "select distinct(a.rak) as rak from stock_opname a where a.toko_kode='".$data['toko_kode']."' and bukti='".$data['bukti']."' order by cast(a.rak as signed)";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function TambahBarangStock($data){
		if(!isset($data['hpp'])){
			$data['hpp'] = 0;
		}
		$query = "insert into stock_opname(bukti, toko_kode, barang_kode, rak, tanggal, stok_sistem, stok_opname, hpp, user_id, waktu_insert, waktu_update) value('".$data['bukti']."', '".$data['toko_kode']."', '".$data['barang_kode']."', '".$data['rak']."', NOW(), ".$data['stok_sys'].", ".$data['stok_op'].", ".$data['hpp'].", '".$this->session->userdata('username')."', NOW(), NOW())";
		
		$this->db->query($query);
	}

	function SimpanImportData($data, $dataPost){
		//get kode barang
		$queryCheck = "SELECT a.kode FROM barang a WHERE a.kode='".$data[2]."' OR a.barcode='".$data[2]."'";
		$result = $this->db->query($queryCheck);
		$resultArr = $result->result_array();

		if(sizeof($resultArr) > 0){
			$query = "insert into stock_opname (bukti, toko_kode, barang_kode, rak, shlv, urut, tanggal, stok_opname, user_id, waktu_insert, waktu_update) value('".$dataPost['tanggal_op']."', '".$data[0]."', '".$resultArr[0]['kode']."', '".$data[1]."', '-', '-', '".$dataPost['tanggal_op']."', ".$data[3].", '".$this->session->userdata('username')."', NOW(), NOW()) on duplicate key update stok_opname=stok_opname+".$data[3]."";

			$this->db->query($query);
		}
	}

	function UpdateStockSystem($data){
		$query = "update stock_opname a left join barang b on a.barang_kode=b.kode left join (select sbt.toko_kode, sbt.barang_kode, sbt.bulan, sbt.tahun, sbt.saldo_akhir_kwt from saldo_barang_toko sbt where sbt.bulan=".$data['bulan']." and sbt.tahun=".$data['tahun'].") c on a.barang_kode=c.barang_kode and a.toko_kode=c.toko_kode left join (select toko_kode, barang_kode, sum(stok_opname) as stok_opname from stock_opname where bukti='".$data['tanggal']."' group by toko_kode, barang_kode) st on a.toko_kode=st.toko_kode and a.barang_kode=st.barang_kode set a.hpp=b.hpp, a.stok_sistem=c.saldo_akhir_kwt, a.selisih=(st.stok_opname - c.saldo_akhir_kwt) where a.toko_kode='".$data['toko_kode']."' and a.bukti='".$data['tanggal']."'";

		$this->db->query($query);

		$queryDelete = "DELETE FROM penyesuaian WHERE toko_kode='".$data['toko_kode']."' and bukti='".$data['tanggal']."'";
		$this->db->query($queryDelete);

		$queryPenyesuaian = "INSERT INTO penyesuaian (bukti, barang_kode, toko_kode, tanggal, kwt, harga, ppn, jumlah, waktu_update, user_id, status, is_hapus) select a.bukti, a.barang_kode, a.toko_kode, a.tanggal, if(a.selisih < 0, a.selisih*-1, a.selisih) as kwt, a.hpp, 0 as ppn, (if(a.selisih < 0, a.selisih*-1, a.selisih)*a.hpp) as jumlah, NOW(), '".$this->session->userdata('username')."' as user_id, if(a.selisih < 0, '1', '0') as status, '0' as is_hapus from stock_opname a where a.toko_kode='".$data['toko_kode']."' and a.bukti='".$data['tanggal']."' and a.selisih is not null group by a.toko_kode, a.barang_kode";

		$this->db->query($queryPenyesuaian);
	}

	function HapusDataStockOpname($data){
		$query = "DELETE FROM stock_opname WHERE toko_kode='".$data['toko_kode']."' and bukti='".$data['tanggal']."'";
		$this->db->query($query);
	}
}

?>