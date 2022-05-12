<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Returtoko_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataReturToko($data){
		$query = "select a.bukti, a.tanggal, a.barang_kode, b.nama_barang, b.satuan, a.kwt, a.harga, a.jumlah, 
		a.toko_kode, c.nama as nama_toko, a.keterangan, a.is_approve 
		from retur_toko a left join barang b on a.barang_kode=b.kode left join toko c on a.toko_kode=c.kode 
		where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.toko_kode='".$data['toko_kode']."' and a.is_hapus='0' and a.is_approve like '%".$data['is_approve']."%' 
		order by a.tanggal desc, a.bukti desc";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataListReturToko($data){
		$query = "select a.bukti, a.tanggal, a.toko_kode, c.nama as nama_toko 
		from retur_toko a left join toko c on a.toko_kode=c.kode 
		where year(a.tanggal)=".$data['tahun']." and month(a.tanggal)=".$data['bulan']." and a.is_hapus='0' and a.is_approve='0' group by a.bukti 
		order by a.tanggal desc, a.bukti";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}

	function getDataListReturTokoApprove($data){
		$query = "select a.bukti, a.tanggal, a.toko_kode, c.nama as nama_toko 
		from retur_toko a left join toko c on a.toko_kode=c.kode 
		where year(a.tanggal)=".$data['tahun']." and month(a.tanggal)=".$data['bulan']." and a.is_hapus='0' and a.is_approve='1' group by a.bukti 
		order by a.tanggal desc, a.bukti";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}

	function getDataListOT($data){
		$query = "select a.bukti, a.tanggal, a.toko_kode, c.nama as nama_toko 
		from order_transfer a left join toko c on a.toko_kode=c.kode 
		where year(a.tanggal)=".$data['tahun']." and month(a.tanggal)=".$data['bulan']." and a.toko_kode='".$data['toko_kode']."' and a.is_hapus='0' and a.is_approve='0' group by a.bukti 
		order by a.tanggal desc, a.bukti";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function SimpanReturToko($data){
		$query = "";
		if($data['mode'] == "i"){
			$query = "insert ignore into retur_toko(bukti, tanggal, barang_kode, kwt, harga, jumlah, toko_kode, keterangan, is_approve, is_hapus, user_id, waktu_insert, waktu_update) 
			values('".$data['bukti']."', '".$data['tanggal']."', '".$data['barang_kode']."', ".$data['kwt'].", ".$data['harga'].", ".$data['jumlah'].", '".$data['toko_kode']."', 
			'".$data['keterangan']."', '0', '0', '".$this->session->userdata('username')."', NOW(), NOW())";
		}else{
			$query = "insert into retur_toko(bukti, tanggal, barang_kode, kwt, harga, jumlah, toko_kode, keterangan, is_approve, is_hapus, user_id, waktu_insert, waktu_update) 
			values('".$data['bukti']."', '".$data['tanggal']."', '".$data['barang_kode']."', ".$data['kwt'].", ".$data['harga'].", ".$data['jumlah'].", '".$data['toko_kode']."', 
			'".$data['keterangan']."', '0', '0', '".$this->session->userdata('username')."', NOW(), NOW()) on duplicate key update tanggal='".$data['tanggal']."', 
			toko_kode='".$data['toko_kode']."', kwt=".$data['kwt'].", harga=".$data['harga'].", jumlah=".$data['jumlah'].", keterangan='".$data['keterangan']."', is_hapus='0'";
		}
		
		$this->db->query($query);
	}
	
	function getDataBarangReturToko($data){
		$query = "select a.bukti, a.tanggal, a.keterangan, a.barang_kode, b.nama_barang, b.satuan, a.kwt, a.harga, a.jumlah, a.toko_kode, d.nama as nama_toko, a.keterangan, a.is_approve, if(c.saldo_akhir_kwt is null, 0, c.saldo_akhir_kwt) as saldo_akhir_kwt, b.barcode  
		from retur_toko a left join barang b on a.barang_kode=b.kode left join (select * from saldo_barang_toko where bulan=month(NOW()) and tahun=year(NOW())) c on a.toko_kode=c.toko_kode and a.barang_kode=c.barang_kode left join toko d on a.toko_kode=d.kode 
		where a.bukti='".$data['bukti']."' and a.toko_kode='".$data['toko_kode']."' and a.is_hapus='0'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function HapusReturToko($data){
		$query = "update retur_toko set is_hapus='1', waktu_update=NOW(), user_id='".$this->session->userdata('username')."' where bukti='".$data['bukti']."'";
		if(isset($data['barang_kode'])){
			$query .= " and barang_kode='".$data['barang_kode']."'";
		}
		
		$this->db->query($query);
	}
	
	function getDataBarangSupplier($data){
		$query = "select a.kode, a.nama_barang, a.satuan, if(c.saldo_akhir_kwt is null, 0, c.saldo_akhir_kwt) as saldo_akhir_kwt, 
		d.supplier_kode, c.toko_kode from barang a left join barang_toko b on a.kode=b.barang_kode 
		left join (select * from saldo_barang_toko where toko_kode='".$data['toko_kode']."' and bulan=".date('m')." and tahun=".date('Y').") c on a.kode=c.barang_kode 
		left join barang_supplier d on a.kode=d.barang_kode 
		where d.supplier_kode='".$data['supplier_kode']."' and b.toko_kode='".$data['toko_kode']."' and a.is_hapus='0'";
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getSaldoBarangToko($data){
		$query = "select a.saldo_akhir_kwt from saldo_barang_toko a where a.toko_kode='".$data['toko_kode']."' 
		and a.barang_kode='".$data['barang_kode']."' and a.bulan=".date('m')." and a.tahun=".date('Y')."";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function TerimaRetur($data){
		$query = "update retur_toko set is_approve='1' where bukti='".$data['bukti']."'";
		
		$this->db->query($query);
	}

	function getRekapReturToko($data){
		$query = "select a.bukti, a.tanggal, sum(a.jumlah) as jumlah, a.toko_kode, c.nama as nama_toko, a.is_approve 
		from retur_toko a left join barang b on a.barang_kode=b.kode left join toko c on a.toko_kode=c.kode 
		where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.toko_kode='".$data['toko_kode']."' and a.is_hapus='0' group by a.bukti, a.tanggal, a.toko_kode, a.is_approve 
		order by a.tanggal, a.bukti";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}

	function getRekapKelompokReturToko($data){
		$query = "select b.kategori, c.nama, sum(a.jumlah) as jumlah from retur_toko a left join barang b on a.barang_kode=b.kode left join kategori_barang c on b.kategori=c.kode where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' and a.toko_kode='".$data['toko_kode']."' group by b.kategori";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}

	function BatalTerimaReturToko($data){
		$query = "update retur_toko set is_approve='0', waktu_update=NOW(), user_id='".$this->session->userdata('username')."' where bukti='".$data['bukti']."' and toko_kode='".$data['toko_kode']."'";
		
		$this->db->query($query);
	}

	function getDataTransferGudang($data){
		$query = "select * from transfer_toko where ref_ot='".$data['bukti_rt']."' and is_hapus='0'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}

	function SimpanTransferKeToko($data){
		$this->load->model('bukti_model');
		
		$Param = array();
		$Param['mode'] = "TG";
		$Param['tanggal'] = date("Y-m-d");
		$BuktiTG = $this->bukti_model->GenerateBukti($Param);
		
		$querytg = "insert into transfer_toko(bukti, barang_kode, toko_kode, tanggal, kwt, harga, jumlah, ref_ot, is_approve, user_id, waktu_insert, waktu_update, is_hapus, urut) select '".$BuktiTG."' as bukti, barang_kode, '".$data['toko_kode']."' as toko_kode, '".$Param['tanggal']."' as tanggal, kwt, harga, jumlah, bukti as ref_ot, '0' as is_approve, user_id, NOW() as waktu_insert, NOW() as waktu_update, '0' as is_hapus, urut from retur_toko where bukti='".$data['bukti_rt']."' and is_hapus='0'";
		$this->db->query($querytg);

		$Param = array();
		$Param['mode'] = "OT";
		$Param['tanggal'] = $data['tanggal'];
		$BuktiOT = $this->bukti_model->GenerateBukti($Param);
		
		$queryot = "insert into order_transfer(bukti, toko_kode, barang_kode, tanggal, kwt, harga, jumlah, keterangan, is_approve, is_hapus, user_id, waktu_insert, waktu_update, urut) select '".$BuktiOT."' as bukti, '".$data['toko_kode']."' as toko_kode, barang_kode, '".$Param['tanggal']."' as tanggal, kwt, harga, jumlah, bukti as keterangan, '1' as is_approve, '0' as is_hapus, user_id, NOW() as waktu_insert, NOW() as waktu_update, urut from retur_toko where bukti='".$data['bukti_rt']."' and is_hapus='0'";
		
		$this->db->query($queryot);
		
		return $BuktiTG;
	}
}