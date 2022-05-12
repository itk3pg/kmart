<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hutang_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function SimpanHutang($data){
		$unit_kode = "";
		if(isset($data['unit_kode'])){
			$unit_kode = $data['unit_kode'];
		}
		$query = "insert into hutang(ref_pengadaan, supplier_kode, unit_kode, tanggal, jumlah, jatuh_tempo, is_lunas) values('".$data['bukti']."', 
		'".$data['supplier_kode']."', '".$unit_kode."', '".$data['tanggal']."', ".$data['jumlah'].", '".$data['jatuh_tempo']."', '0') 
		on duplicate key update tanggal='".$data['tanggal']."', jumlah=".$data['jumlah'].", jatuh_tempo='".$data['jatuh_tempo']."'";
		
		$this->db->query($query);
	}
	
	function HapusHutang($data){
		$query = "delete from hutang where ref_pengadaan='".$data['bukti']."'";
		
		$this->db->query($query);
	}
	
	function setStatusTukarNota($data){
		$query = "update hutang set tukar_nota_bukti='".$data['tukar_nota_bukti']."', jatuh_tempo='".$data['jatuh_tempo']."' where ref_pengadaan='".$data['pengadaan_bukti']."' and supplier_kode='".$data['supplier_kode']."'";
		
		$this->db->query($query);
	}
	
	function HapusStatusTukarNota($data){
		$query = "update hutang set tukar_nota_bukti=NULL where tukar_nota_bukti='".$data['bukti']."'";
		$this->db->query($query);
	}
	
	function getDataHutang($data){
		$query = "select d.ref_pengadaan, d.supplier_kode, DATE_FORMAT(d.tanggal,'%d-%m-%Y') tanggal, d.jumlah, d.jatuh_tempo, d.is_lunas, d.nama_supplier, 
		sum(if(d.jumlah_bayar is null, 0, d.jumlah_bayar)) as jumlah_bayar from (select a.*, c.nama_supplier, 
		b.jumlah as jumlah_bayar, b.is_hapus from hutang a 
		left join (select * from pembayaran_hutang where is_hapus is null or is_hapus='0') b on a.ref_pengadaan = b.ref_pengadaan 
		left join supplier c on a.supplier_kode = c.kode 
		where a.tanggal<='".$data['tahun']."-".$data['bulan']."-31') d 
		group by d.ref_pengadaan, d.supplier_kode";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getListDataHutang($data){
		$query = "select a.ref_pengadaan, a.supplier_kode, a.jumlah from hutang a where a.supplier_kode='".$data['supplier_kode']."' and (a.ref_pengadaan like '".$data['q']."%')";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getListDataHutangPenyesuaian($data){
		$query = "select a.ref_pengadaan, a.supplier_kode, a.jumlah from hutang a where a.supplier_kode='".$data['supplier_kode']."' and a.ref_pengadaan like '".$data['q']."%' and (a.tukar_nota_bukti is null or a.tukar_nota_bukti='')";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getDetailPembayaran($data){
		$query = "select * from pembayaran_hutang where ref_pengadaan='".$data['kd_pengadaan']."' and is_hapus='0'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function SimpanPembayaran($data){
		$this->load->model('bukti_model');
		$this->load->model('kasbank_model');
		
		$username = $this->session->userdata('username');
		if($data['mode_form'] == 1){ // untuk insert pembayaran baru
			$ParamBukti = array();
			$ParamBukti['mode'] = "PH";
			$ParamBukti['tanggal'] = $data['tanggal'];
			$id_pembayaran = $this->bukti_model->GenerateBukti($ParamBukti);
			
			$query = "insert into pembayaran_hutang values('".$id_pembayaran."','".$data['ref_pengadaan']."','".$data['supplier_kode']."','".$data['tanggal']."',
			".$data['jumlah'].",'','0',NOW(),'".$username."')";
			
			$this->db->query($query);
			
			$this->HitungSaldoHutang($data);
			
			// insert into kasbank
			$paramkasbank = array();
			if($data['pembayaran_dari'] == "112"){ // dari cek/giro
				$paramkasbank['mode'] = "BK";
			}else{
				$paramkasbank['mode'] = "KK";
			}
			$paramkasbank['kd_cb'] = "2011"; //201
			$paramkasbank['mode_form'] = "i";
			$paramkasbank['unit_kode'] = 'VO0008';
			$paramkasbank['kd_kb'] = $data['pembayaran_dari'];
			$paramkasbank['tanggal'] = $data['tanggal'];
			$paramkasbank['kd_subject'] = $data['supplier_kode'];
			$paramkasbank['nama_subject'] = $data['nama_supplier'];
			$paramkasbank['keterangan'] = "PEMBAYARAN HUTANG ATAS ".$data['ref_pengadaan'];
			$paramkasbank['jumlah'] = $data['jumlah'];
			$paramkasbank['no_ref'] = $id_pembayaran;
			
			$bukti_kasbank = $this->kasbank_model->SimpanKasbank($paramkasbank);
			$queryUpdate = "update pembayaran_hutang set ref_kasbank='".$bukti_kasbank."' where id_pembayaran='".$id_pembayaran."'";
			$this->db->query($queryUpdate);
		}else{ // untuk edit pembayaran
			$query = "update pembayaran_hutang set jumlah=".$data['jumlah'].", tanggal_update=NOW(), user_id='".$username."' 
			where id_pembayaran='".$data['id_pembayaran']."'";
			
			$this->db->query($query);
			
			$this->HitungSaldoHutang($data);
			
			// edit data kasbank
			$paramkasbank['mode_form'] = "uh";
			$paramkasbank['kd_kb'] = $data['pembayaran_dari'];
			$paramkasbank['jumlah_lama'] = $data['jumlah_lama'];
			$paramkasbank['bukti_kasbank'] = $data['ref_kasbank'];
			
			$bukti_kasbank = $this->kasbank_model->SimpanKasbank($paramkasbank);
		}
		
		$ParamData = array();
		$ParamData['ref_pengadaan'] = $data['ref_pengadaan'];
		$ParamData['supplier_kode'] = $data['supplier_kode'];
		$this->CheckIsLunas($ParamData);
	}
	
	function HapusPembayaran($data){
		// $this->load->model('otomatis_model');
		$this->load->model('kasbank_model');
		
		$query = "update pembayaran_hutang set is_hapus='1', tanggal_update=NOW() where id_pembayaran='".$data['id_pembayaran']."'";
		
		$this->db->query($query);
		
		$this->HitungSaldoHutang($data);
		
		$ParamData = array();
		$ParamData['ref_pengadaan'] = $data['ref_pengadaan'];
		$ParamData['supplier_kode'] = $data['supplier_kode'];
		$this->CheckIsLunas($ParamData);
		
		// hapus kasbank
		$queryGetKasBank = "select kd_kb, tanggal from kasbank where no_ref='".$data['id_pembayaran']."'";
		$result = $this->db->query($queryGetKasBank);
		$resultArr = $result->result_array();
		
		//$this->db->close();
		$querykasbank = "update kasbank set is_hapus='1' where no_ref='".$data['id_pembayaran']."'";
		echo $querykasbank;
		$this->db->query($querykasbank);
		
		$data['kd_kb'] = $resultArr[0]['kd_kb'];
		$data['tanggal'] = $resultArr[0]['tanggal'];
		$this->kasbank_model->HitungSaldoKasbank($data);
	}
	
	function CheckIsLunas($data){
		$query = "select a.ref_pengadaan, a.supplier_kode, a.tanggal, a.jumlah as jml_hutang, sum(if(b.jumlah is null, 0, b.jumlah)) as jml_bayar 
		from hutang a left join pembayaran_hutang b on a.ref_pengadaan=b.ref_pengadaan and a.supplier_kode=b.supplier_kode 
		where a.ref_pengadaan='".$data['ref_pengadaan']."' and a.supplier_kode='".$data['supplier_kode']."' group by a.ref_pengadaan, a.supplier_kode";
		
		$result = $this->db->query($query);
		$resultArr = $result->result_array();
		
		$jml_hutang = $resultArr[0]['jml_hutang'];
		$jml_bayar = $resultArr[0]['jml_bayar'];
		
		$sisa = $jml_hutang - $jml_bayar;
		
		$queryUpdate = "";
		if($sisa == 0){
			$queryUpdate = "update hutang set is_lunas='1' where ref_pengadaan='".$data['ref_pengadaan']."' and supplier_kode='".$data['supplier_kode']."'";
		}else{
			$queryUpdate = "update hutang set is_lunas='0' where ref_pengadaan='".$data['ref_pengadaan']."' and supplier_kode='".$data['supplier_kode']."'";
		}
		$this->db->query($queryUpdate);
	}
	
	function HitungSaldoHutang($data){
		if(isset($data['tanggal'])){
			$dataArr = explode("-", $data['tanggal']);
			$data['bulan'] = intval($dataArr[1]);
			$data['tahun'] = intval($dataArr[0]);
		}
		
		$bulansebelum = $data['bulan'] - 1;
		$tahunsebelum = $data['tahun'];
		if($bulansebelum == 0){
			$bulansebelum = 12;
			$tahunsebelum = $data['tahun'] - 1;
		}
		$querygetsaldoawal = "";
		if($data['bulan'] == 5 && $data['tahun'] == 2016){
			$querygetsaldoawal = "select a.saldo_awal saldo_akhir from saldo_hutang a where a.bulan=".$data['bulan']." 
			and a.tahun=".$data['tahun']." and a.supplier_kode='".$data['supplier_kode']."'";
		}else{
			$querygetsaldoawal = "select a.saldo_akhir from saldo_hutang a where a.bulan=".$bulansebelum." 
			and a.tahun=".$tahunsebelum." and a.supplier_kode='".$data['supplier_kode']."'";
		}
		
		$Resultsa = $this->db->query($querygetsaldoawal);
		$ResultArrsa = $Resultsa->result_array();
		
		$queryHutang = "select supplier_kode, sum(jumlah) jumlah from hutang where month(tanggal)=".$data['bulan']." 
		and year(tanggal)=".$data['tahun']." 
		and supplier_kode='".$data['supplier_kode']."' group by supplier_kode";
		
		$Resulthutang = $this->db->query($queryHutang);
		$ResultArrhutang = $Resulthutang->result_array();
		
		$queryPembayaran = "select supplier_kode, sum(jumlah) jumlah from pembayaran_hutang where month(tanggal)=".$data['bulan']." 
		and year(tanggal)=".$data['tahun']." 
		and supplier_kode='".$data['supplier_kode']."' and is_hapus='0' group by supplier_kode";
		
		$ResultPembayaran = $this->db->query($queryPembayaran);
		$ResultArrpembayaran = $ResultPembayaran->result_array();
		
		$SaldoAwal = 0;
		$hutang = 0;
		$pembayaran = 0;
		if(sizeof($ResultArrsa) > 0){
			$SaldoAwal = $ResultArrsa[0]['saldo_akhir'];
		}
		if(sizeof($ResultArrhutang) > 0){
			$hutang = $ResultArrhutang[0]['jumlah'];
		}
		if(sizeof($ResultArrpembayaran) > 0){
			$pembayaran = $ResultArrpembayaran[0]['jumlah'];
		}
		$SaldoAkhir = $SaldoAwal + ($hutang - $pembayaran);
		
		$querygetcurrent = "select * from saldo_hutang a where a.bulan=".$data['bulan']." 
		and a.tahun=".$data['tahun']." and a.supplier_kode='".$data['supplier_kode']."'";
		$Resultcurr = $this->db->query($querygetcurrent);
		$ResultArrcurr = $Resultcurr->result_array();
		
		if(sizeof($ResultArrcurr) > 0){
			$queryUpdate = "update saldo_hutang set saldo_awal=".$SaldoAwal.", hutang=".$hutang.", bayar=".$pembayaran.", 
			saldo_akhir=".$SaldoAkhir." where bulan=".$data['bulan']." and tahun=".$data['tahun']." and supplier_kode='".$data['supplier_kode']."'";
			
			$this->db->query($queryUpdate);
		}else{
			$queryInsert = "insert into saldo_hutang(supplier_kode, bulan, tahun, saldo_awal, hutang, bayar, saldo_akhir, 
			waktu_update) values('".$data['supplier_kode']."', ".$data['bulan'].", ".$data['tahun'].", ".$SaldoAwal.", 
			".$hutang.", ".$pembayaran.", ".$SaldoAkhir.", NOW())";
			
			$this->db->query($queryInsert);
		}
	}
	
	function UpdateJatuhTempo($data){
		$query = "update piutang a set a.jatuh_tempo='".$data['jatuh_tempo']."' where a.ref_pengadaan='".$data['pengadaan_bukti']."' and a.supplier_kode='".$data['supplier_kode']."'";
		
		$this->db->query($query);
	}
	
	function HapusSemuaPembayaran($data){
		$queryGet = "select id_pembayaran, ref_kasbank from pembayaran_hutang where ref_pengadaan='".$data['bukti']."'";
		$Data = $this->db->query($queryGet);
		$DataArr = $Data->result_array();
		
		foreach($DataArr as $row => $value){
			$queryDeleteKasbank = "update kasbank set is_hapus='1' where bukti='".$value['ref_kasbank']."'";
			
			$this->db->query($queryDeleteKasbank);
			
			$queryDeletePembayaran = "update pembayaran_hutang set is_hapus='1' where id_pembayaran='".$value['id_pembayaran']."'";
			
			$this->db->query($queryDeletePembayaran);
		}
		
		$this->HitungSaldoHutang($data);
	}
}