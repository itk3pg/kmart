<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bukti_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function GenerateBukti($data){
		$mode = $data['mode'];
		$bulan = date('m');
		$tahun = date('Y');
		if(isset($data['tanggal'])){
			$tglArr = explode("-", $data['tanggal']);
			
			$bulan = $tglArr[1];
			$tahun = $tglArr[0];
		}
		$query = "";
		$kodebukti = "";
		switch($mode){
			case "OT" :
				$query = "select SUBSTRING(bukti, 7) urut from order_transfer where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "OT";
				break;
			case "RT" :
				$query = "select SUBSTRING(bukti, 7) urut from retur_toko where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "RT";
				break;
			case "UN" :
				$query = "select SUBSTRING(bukti, 7) urut from retur_toko_konsinyasi where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "UN";
				break;
			case "RS" :
				$query = "select SUBSTRING(bukti, 7) urut from retur_supplier where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "RS";
				break;
			case "RN" :
				$query = "select SUBSTRING(bukti, 7) urut from retur_supplier_konsinyasi where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "RN";
				break;
			case "YN" :
				$query = "select SUBSTRING(bukti, 7) urut from tau_keluar_konsinyasi where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "YN";
				break;
			case "OP" :
				$query = "select SUBSTRING(bukti, 7) urut from op where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "OP";
				break;
			case "BI" :
				$query = "select SUBSTRING(bukti, 7) urut from pengadaan_barang where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "BI";
				break;
			case "KN" :
				$query = "select SUBSTRING(bukti, 7) urut from pengadaan_barang_konsinyasi where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "KN";
				break;
			case "JI" :
				$query = "select SUBSTRING(bukti, 7) urut from pengadaan_jasa where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "JI";
				break;
			case "BO" :
				$query = "select SUBSTRING(bukti, 7) urut from pemakaian_barang where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "BO";
				break;
			case "SO" :
				$query = "select SUBSTRING(bukti, 7) urut from stok_opname where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "SO";
				break;
			case "PH" :
				$query = "select SUBSTRING(id_pembayaran, 7) urut from pembayaran_hutang where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(id_pembayaran, 7) desc limit 1";
				
				$kodebukti = "PH";
				break;
			case "PP" :
				$query = "select SUBSTRING(id_pembayaran, 7) urut from pembayaran_piutang where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(id_pembayaran, 7) desc limit 1";
				
				$kodebukti = "PP";
				break;
			case "KM" :
				$query = "select SUBSTRING(bukti, 9) urut from kasbank where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." and SUBSTRING(bukti, 1, 4)='KMVM' order by SUBSTRING(bukti, 9) desc limit 1";
				
				$kodebukti = "KM";
				break;
			case "KK" :
				$query = "select SUBSTRING(bukti, 9) urut from kasbank where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." and SUBSTRING(bukti, 1, 4)='KKVM' order by SUBSTRING(bukti, 9) desc limit 1";
				
				$kodebukti = "KK";
				break;
			case "BM" :
				$query = "select SUBSTRING(bukti, 9) urut from kasbank where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." and SUBSTRING(bukti, 1, 4)='BMVM' order by SUBSTRING(bukti, 9) desc limit 1";
				
				$kodebukti = "BM";
				break;
			case "BK" :
				$query = "select SUBSTRING(bukti, 9) urut from kasbank where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." and SUBSTRING(bukti, 1, 4)='BKVM' order by SUBSTRING(bukti, 9) desc limit 1";
				
				$kodebukti = "BK";
				break;
			case "TM" :
				$query = "select SUBSTRING(bukti, 7) urut from tau_masuk where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "TM";
				break;
			case "TK" :
				$query = "select SUBSTRING(bukti, 7) urut from tau_keluar where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "TK";
				break;
			case "TG" :
				$query = "select SUBSTRING(bukti, 7) urut from transfer_toko where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "TG";
				break;
			case "TN" :
				$query = "select SUBSTRING(bukti, 7) urut from transfer_toko_konsinyasi where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "TN";
				break;
			case "TT" :
				$query = "select SUBSTRING(bukti, 7) urut from tukar_nota where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "TT";
				break;
			case "PB" :
				$query = "select SUBSTRING(bukti, 7) urut from permintaan_pembayaran where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "PB";
				break;
			case "PL" :
				$query = "select SUBSTRING(bukti, 7) urut from pendapatan_lain where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "PL";
				break;
			case "HK" :
				$query = "select SUBSTRING(bukti, 7) urut from hutang_penyesuaian where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." and SUBSTRING(bukti, 1, 2)='HK' order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "HK";
				break;
			case "HM" :
				$query = "select SUBSTRING(bukti, 7) urut from hutang_penyesuaian where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." and SUBSTRING(bukti, 1, 2)='HM' order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "HM";
				break;
			case "KW" :
				$query = "select SUBSTRING(no_kuitansi, 1, 4) urut from piutang 
				where SUBSTRING(no_kuitansi, 14)= ".$bulan.".".$tahun." 
				order by SUBSTRING(no_kuitansi, 1, 4) desc limit 1";
				
				$kodebukti = "KW";
				break;
			case "BS" :
				$query = "select SUBSTRING(bukti, 7) urut from bad_stock where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "BS";
				break;
			case "TB" :
				$query = "select SUBSTRING(bukti, 7) urut from bo_bad_stock where MONTH(tanggal)=".$bulan." and 
				YEAR(tanggal)=".$tahun." order by SUBSTRING(bukti, 7) desc limit 1";
				
				$kodebukti = "TB";
				break;
		}
		
		$result = $this->db->query($query);
		$resultArr = $result->result_array();
		$urut = 1;
		if(sizeof($resultArr) > 0){
			$urut = intval($resultArr[0]['urut']) + 1;
		}
		
		$StrUrut = "";
		if($urut < 10){
			$StrUrut .= "000".$urut;
		}else if($urut < 100){
			$StrUrut .= "00".$urut;
		}else if($urut < 1000){
			$StrUrut .= "0".$urut;
		}else{
			$StrUrut .= "".$urut;
		}
		
		if($kodebukti == "KW"){
			return $StrUrut."/K3PG/".$bulan.".".$tahun;
		}else if($kodebukti == "KK" || $kodebukti == "KM" || $kodebukti == "BK" || $kodebukti == "BM"){
			return $kodebukti."VM".$bulan."".substr($tahun, 2, 2)."".$StrUrut;
		}else{
			return $kodebukti."".$bulan."".substr($tahun, 2, 2)."".$StrUrut;
		}
	}
	
	function Terbilang($a) {
	    $ambil = array("", "SATU", "DUA", "TIGA", "EMPAT", "LIMA", "ENAM", "TUJUH", "DELAPAN", "SEMBILAN", "SEPULUH", "SEBELAS");
	    if ($a < 12)
	        return " " . $ambil[$a];
	    elseif ($a < 20)
	        return $this->Terbilang($a - 10) . "BELAS";
	    elseif ($a < 100)
	        return $this->Terbilang($a / 10) . " PULUH" . $this->Terbilang($a % 10);
	    elseif ($a < 200)
	        return " SERATUS" . $this->Terbilang($a - 100);
	    elseif ($a < 1000)
	        return $this->Terbilang($a / 100) . " RATUS" . $this->Terbilang($a % 100);
	    elseif ($a < 2000)
	        return " SERIBU" . $this->Terbilang($a - 1000);
	    elseif ($a < 1000000)
	        return $this->Terbilang($a / 1000) . " RIBU" . $this->Terbilang($a % 1000);
	    elseif ($a < 1000000000)
	        return $this->Terbilang($a / 1000000) . " JUTA" . $this->Terbilang($a % 1000000);
	    elseif ($a < 1000000000000)
	        return $this->Terbilang($a / 1000000000) . " MILYAR" . $this->Terbilang($a % 1000000000);
	}
}