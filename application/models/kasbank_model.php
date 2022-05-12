<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kasbank_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataKB(){
		$query = "select kd_kb, keterangan from m_kb";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getDataCB($data){
		$query = "";
		if($data['mode'] == "KK" || $data['mode'] == "BK"){
			$query = "select kd_cb, keterangan from m_cb where substring(kd_cb,1,1)='2' and (status<>'1' or status is null)";
		}else{
			$query = "select kd_cb, keterangan from m_cb where substring(kd_cb,1,1)='1' and (status<>'1'  or status is null)";
		}
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getDataKasbank($data){
		$query = "select bukti, kd_cb, kd_kb, unit_kode, toko_kode, DATE_FORMAT(tanggal,'%Y-%m-%d') tanggal, kode_subject, nama_subject, keterangan, jumlah, nopol, ifnull(no_ref_dropping, '') as no_ref_dropping 
		from kasbank where date(tanggal)='".$data['tanggal']."' and unit_kode='".$data['unit_kode']."' and is_hapus='0'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getDataKasbankCetak($data){
		$query = "select a.bukti, a.kd_cb, a.kd_kb, b.keterangan as nama_kb, DATE_FORMAT(a.tanggal,'%Y-%m-%d') tanggal, a.kode_subject, 
		a.nama_subject, a.keterangan, a.jumlah, a.no_ref 
		from kasbank a left join m_kb b on a.kd_kb=b.kd_kb where a.bukti='".$data['bukti']."' and unit_kode='".$data['unit_kode']."'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function SimpanKasbank($data){
		$this->load->model('bukti_model');
		/**
		 * `bukti` varchar(10) NOT NULL,
		  `kd_kb` varchar(4) NOT NULL,
		  `kd_cb` varchar(4) NOT NULL,
		  `tanggal` datetime DEFAULT NULL,
		  `kode_subject` varchar(8) DEFAULT NULL,
		  `nama_subject` varchar(450) DEFAULT NULL,
		  `keterangan` varchar(450) DEFAULT NULL,
		  `jumlah` double DEFAULT NULL,
		  `no_ref` varchar(12) DEFAULT NULL,
		  `user_id` varchar(8) DEFAULT NULL,
		  `is_hapus` varchar(1) DEFAULT NULL,
		  `waktu_update` datetime DEFAULT NULL
		 */
		$bukti_kasbank = "";
		$username = $this->session->userdata('username');
		if($data['mode_form'] == "i"){
			if(!isset($data['toko_kode'])){
				$data['toko_kode'] = "";
			}
			if(!isset($data['nopol'])){
				$data['nopol'] = "";
			}
			$tanggalArr = explode("-", $data['tanggal']);
			$bukti_kasbank = $this->bukti_model->GenerateBukti($data);
			
			$query = "insert into kasbank(bukti, kd_kb, kd_cb, unit_kode, tanggal, kode_subject, nama_subject, keterangan, jumlah, no_ref, toko_kode, user_id, is_hapus, 
			waktu_update, nopol) values('".$bukti_kasbank."','".$data['kd_kb']."','".$data['kd_cb']."','".$data['unit_kode']."','".$data['tanggal']."',
			'".$data['kd_subject']."','".$this->db->escape_str($data['nama_subject'])."','".$this->db->escape_str($data['keterangan'])."',".$data['jumlah'].",
			'".$data['no_ref']."', '".$data['toko_kode']."', '".$username."','0',NOW(), '".$data['nopol']."')";
			
			$this->db->query($query);
			
			$this->HitungSaldoKasbank($data);
			
			if($data['kd_cb'] == "1911"){ // jika insert um penjualan otomatis insert transfer pusat
				$paramkasbank = array();
				$paramkasbank['mode'] = substr($data['mode'], 0, 1)."K";
				$paramkasbank['kd_cb'] = "2802";
				$paramkasbank['mode_form'] = "i";
				$paramkasbank['kd_kb'] = $data['kd_kb']; // dari kas besar
				$paramkasbank['tanggal'] = $data['tanggal'];
				$paramkasbank['kd_subject'] = "1111117";
				$paramkasbank['nama_subject'] = "KASIR PUSAT KWSG";
				$paramkasbank['keterangan'] = $data['keterangan'];
				$paramkasbank['jumlah'] = $data['jumlah'];
				$paramkasbank['no_ref'] = $bukti_kasbank;
				$paramkasbank['unit_kode'] = $data['unit_kode'];
				
				$bukti_kasbank = $this->bukti_model->GenerateBukti($paramkasbank);
				
				$query = "insert into kasbank(bukti, kd_kb, kd_cb, unit_kode, tanggal, kode_subject, nama_subject, keterangan, jumlah, no_ref, user_id, is_hapus, 
				waktu_update) values('".$bukti_kasbank."','".$paramkasbank['kd_kb']."','".$paramkasbank['kd_cb']."', '".$data['unit_kode']."','".$paramkasbank['tanggal']."',
				'".$paramkasbank['kd_subject']."','".$this->db->escape_str($paramkasbank['nama_subject'])."','".$this->db->escape_str(urldecode($paramkasbank['keterangan']))."',
				".$paramkasbank['jumlah'].",'".$paramkasbank['no_ref']."', '".$username."','0',NOW())";
				
				$this->db->query($query);
				
				$this->HitungSaldoKasbank($paramkasbank);
			}else if($data['kd_cb'] == "2921" || $data['kd_cb'] == "2951"){
				$paramkasbank = array();
				$paramkasbank['mode'] = substr($data['mode'], 0, 1)."M";
				$paramkasbank['kd_cb'] = "1802";
				$paramkasbank['mode_form'] = "i";
				$paramkasbank['kd_kb'] = $data['kd_kb']; // dari kas besar
				$paramkasbank['tanggal'] = $data['tanggal'];
				$paramkasbank['kd_subject'] = "1111151";
				$paramkasbank['nama_subject'] = "UNIT K-MART";
				$paramkasbank['keterangan'] = $data['keterangan'];
				$paramkasbank['jumlah'] = $data['jumlah'];
				$paramkasbank['no_ref'] = $bukti_kasbank;
				$paramkasbank['unit_kode'] = $data['unit_kode'];
				
				$bukti_kasbank = $this->bukti_model->GenerateBukti($paramkasbank);
				
				$query = "insert into kasbank(bukti, kd_kb, kd_cb, unit_kode, tanggal, kode_subject, nama_subject, keterangan, jumlah, no_ref, user_id, is_hapus, 
				waktu_update) values('".$bukti_kasbank."','".$paramkasbank['kd_kb']."','".$paramkasbank['kd_cb']."', '".$data['unit_kode']."','".$paramkasbank['tanggal']."',
				'".$paramkasbank['kd_subject']."','".$this->db->escape_str($paramkasbank['nama_subject'])."','".$this->db->escape_str(urldecode($paramkasbank['keterangan']))."',
				".$paramkasbank['jumlah'].",'".$paramkasbank['no_ref']."','".$username."','0',NOW())";
				
				$this->db->query($query);
				
				$this->HitungSaldoKasbank($paramkasbank);
			}else if($data['kd_cb'] == "2607"){ // jika bbm (276)
				$json_url = "http://101.50.1.205/serviceapp/bbmvmartresto.php?mode=saldobbm&tanggal=".$data['tanggal']."&nopol=".$data['nopol']."&jumlah=".$data['jumlah'];
				
				$json = file_get_contents($json_url);
			}
		}else if($data['mode_form'] == "u"){
			$bukti_kasbank = $data['bukti_kasbank'];
			
			$queryUpdate = "update kasbank set kd_cb='".$data['kd_cb']."', kd_kb='".$data['kd_kb']."', unit_kode='".$data['unit_kode']."', tanggal='".$data['tanggal']."', 
			kode_subject='".$data['kd_subject']."', nama_subject='".$this->db->escape_str($data['nama_subject'])."', keterangan='".$this->db->escape_str(urldecode($data['keterangan']))."', 
			jumlah=".$data['jumlah'].", no_ref='".$data['no_ref']."', toko_kode='".$data['toko_kode']."', user_id='".$username."', waktu_update=NOW() 
			where bukti='".$bukti_kasbank."'";
			
			$this->db->query($queryUpdate);
			
			$this->HitungSaldoKasbank($data);
		}else if($data['mode_form'] == "uh"){ // update hutang
			$bukti_kasbank = $data['bukti_kasbank'];
			
			$queryUpdate = "update kasbank set kd_kb='".$data['kd_kb']."', jumlah=".$data['jumlah'].", user_id='".$username."', waktu_update=NOW() 
			where bukti='".$bukti_kasbank."'";
			
			$this->db->query($queryUpdate);
			
			$this->HitungSaldoKasbank($data);
		}
		return $bukti_kasbank;
	}
	
	function HapusKasbank($data){
		$username = $this->session->userdata('username');
		if($data['bukti'] != ''){
			$query = "update kasbank set is_hapus='1', user_id='".$username."', waktu_update=NOW() where bukti='".$data['bukti']."' or no_ref='".$data['bukti']."'";
			
			$this->db->query($query);
			
			$this->HitungSaldoKasbank($data);

			if($data['kd_cb'] == "2607"){ // jika bbm (276)
				$json_url = "http://101.50.1.205/serviceapp/bbmvmartresto.php?mode=deletesaldo&bukti_kasbank=".$data['bukti']."&nopol=".$data['nopol'];
				
				$json = file_get_contents($json_url);
			}
		}
	}
	
	function HitungSaldoKasbank($data){
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
			$querygetsaldoawal = "select a.saldo_awal saldo_akhir from saldo_kasbank a where a.bulan=".$data['bulan']." 
			and a.tahun=".$data['tahun']." and a.kd_kb='".$data['kd_kb']."' and a.unit_kode='".$data['unit_kode']."'";
		}else{
			$querygetsaldoawal = "select a.saldo_akhir from saldo_kasbank a where a.bulan=".$bulansebelum." 
			and a.tahun=".$tahunsebelum." and a.kd_kb='".$data['kd_kb']."' and a.unit_kode='".$data['unit_kode']."'";
		}
		
		$Resultsa = $this->db->query($querygetsaldoawal);
		$ResultArrsa = $Resultsa->result_array();
		
		$querydebetkredit = "select SUBSTR(a.bukti,2,1) mode, sum(a.jumlah) jumlah 
		from kasbank a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." 
		and a.is_hapus='0' and a.kd_kb='".$data['kd_kb']."' and a.unit_kode='".$data['unit_kode']."' 
		group by SUBSTR(a.bukti,2,1)";
		
		$Resultdk = $this->db->query($querydebetkredit);
		$ResultArrdk = $Resultdk->result_array();
		
		$SaldoAwal = 0;
		$debet = 0;
		$kredit = 0;
		if(sizeof($ResultArrsa) > 0){
			$SaldoAwal = $ResultArrsa[0]['saldo_akhir'];
		}
		foreach ($ResultArrdk as $keydk => $valuedk) {
			if($valuedk['mode'] == "K"){
				$kredit = $valuedk['jumlah'];
			}else{
				$debet = $valuedk['jumlah'];
			}
		}
		$SaldoAkhir = $SaldoAwal + ($debet - $kredit);
		
		$querygetcurrent = "select * from saldo_kasbank a where a.bulan=".$data['bulan']." 
		and a.tahun=".$data['tahun']." and a.kd_kb='".$data['kd_kb']."' and a.unit_kode='".$data['unit_kode']."'";
		$Resultcurr = $this->db->query($querygetcurrent);
		$ResultArrcurr = $Resultcurr->result_array();
		
		if(sizeof($ResultArrcurr) > 0){
			$queryUpdate = "update saldo_kasbank set saldo_awal=".$SaldoAwal.", debet=".$debet.", kredit=".$kredit.", 
			saldo_akhir=".$SaldoAkhir." where bulan=".$data['bulan']." and tahun=".$data['tahun']." and kd_kb='".$data['kd_kb']."' and unit_kode='".$data['unit_kode']."'";
			$this->db->query($queryUpdate);
		}else{
			$queryInsert = "insert into saldo_kasbank(kd_kb, unit_kode, bulan, tahun, saldo_awal, debet, kredit, saldo_akhir, 
			waktu_update) values('".$data['kd_kb']."', '".$data['unit_kode']."', ".$data['bulan'].", ".$data['tahun'].", ".$SaldoAwal.", 
			".$debet.", ".$kredit.", ".$SaldoAkhir.", NOW())";
			
			$this->db->query($queryInsert);
		}
	}
	
	function getListDataSubject($data){
		$query = "(select kode as kd_subject, nama_pelanggan as nama_subject from pelanggan 
		where nama_pelanggan like '%".$data['q']."%' or kode like '%".$data['q']."%') 
		union 
		(select kode, nama_supplier from supplier where nama_supplier like '%".$data['q']."%' or kode like '%".$data['q']."%')";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
}