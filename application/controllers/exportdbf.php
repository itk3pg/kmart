<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exportdbf extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		$this->load->model('exportdbf_model');
	}
	
	public function index(){
		//$this->user_model->cekSession('');
		
		$this->load->view('general/header');
		$this->load->view('general/sidebar');
		$this->load->view('exportdbf/home');
		$this->load->view('general/footer');
	}
	
	public function pembeliankredit(){
		$def = array(
		  array("NO","N", 11, 0),
		  array("TANGGAL","C", 10),
		  array("BUKTI","C", 20),
		  array("KD_SUP","C", 20),
		  array("NM_SUP","C", 100),
		  array("DPP","N", 11, 2),
		  array("PPN","N", 11, 2),
		  array("TOTAL", "N", 11, 2)
		);
		if (!dbase_create("dbfdir/PK".$_POST['bulan'].substr($_POST['tahun'], 2, 2).".dbf", $def)) {
			//echo "Error, can't create the database\n";
		}else{
			//echo "Success, dbf berhasil dibuat\n";
		}
		
		$db = dbase_open("dbfdir/PK".$_POST['bulan'].substr($_POST['tahun'], 2, 2).".dbf", 2);
		if($db){
			$DataPembelianKredit = $this->exportdbf_model->getDataPembelianKredit($_POST);
			$inc = 1;
			foreach($DataPembelianKredit as $key => $value){
				$data = array(
							$inc,
							$value['tanggal'],
							$value['bukti'],
							$value['supplier_kode'],
							$value['nama_supplier'],
							$value['dpp'],
							$value['ppn'],
							$value['total']
							);
				dbase_add_record($db, $data);
				
				$inc++;
			}
			dbase_close($db);
			
			echo "PK".$_POST['bulan'].substr($_POST['tahun'], 2, 2).".dbf";
		}else{
			echo "Can't open database";
		}
	}
	
	public function pembeliantunai(){
		$def = array(
		  array("NO","N", 11, 0),
		  array("TANGGAL","C", 10),
		  array("BUKTI","C", 20),
		  array("KD_SUP","C", 20),
		  array("NM_SUP","C", 100),
		  array("DPP","N", 11, 2),
		  array("PPN","N", 11, 2),
		  array("TOTAL", "N", 11, 2)
		);
		if (!dbase_create("dbfdir/PT".$_POST['bulan'].substr($_POST['tahun'], 2, 2).".dbf", $def)) {
			//echo "Error, can't create the database\n";
		}else{
			//echo "Success, dbf berhasil dibuat\n";
		}
		
		$db = dbase_open("dbfdir/PT".$_POST['bulan'].substr($_POST['tahun'], 2, 2).".dbf", 2);
		if($db){
			$DataPembelianTunai = $this->exportdbf_model->getDataPembelianTunai($_POST);
			$inc = 1;
			foreach($DataPembelianTunai as $key => $value){
				$data = array(
							$inc,
							$value['tanggal'],
							$value['bukti'],
							$value['supplier_kode'],
							$value['nama_supplier'],
							$value['dpp'],
							$value['ppn'],
							$value['total']
							);
				dbase_add_record($db, $data);
				
				$inc++;
			}
			dbase_close($db);
			
			echo "PT".$_POST['bulan'].substr($_POST['tahun'], 2, 2).".dbf";
		}else{
			echo "Can't open database";
		}
	}
	
	public function retursupplier(){
		$def = array(
		  array("NO","N", 11, 0),
		  array("TANGGAL","C", 10),
		  array("BUKTI","C", 20),
		  array("KD_SUP","C", 20),
		  array("NM_SUP","C", 100),
		  array("DPP","N", 11, 2),
		  array("PPN","N", 11, 2),
		  array("TOTAL", "N", 11, 2)
		);
		if (!dbase_create("dbfdir/RS".$_POST['bulan'].substr($_POST['tahun'], 2, 2).".dbf", $def)) {
			//echo "Error, can't create the database\n";
		}else{
			//echo "Success, dbf berhasil dibuat\n";
		}
		
		$db = dbase_open("dbfdir/RS".$_POST['bulan'].substr($_POST['tahun'], 2, 2).".dbf", 2);
		if($db){
			$ReturSupplier = $this->exportdbf_model->getDataReturSupplier($_POST);
			$inc = 1;
			foreach($ReturSupplier as $key => $value){
				$data = array(
							$inc,
							$value['tanggal'],
							$value['bukti'],
							$value['supplier_kode'],
							$value['nama_supplier'],
							$value['dpp'],
							$value['ppn'],
							$value['total']
							);
				dbase_add_record($db, $data);
				
				$inc++;
			}
			dbase_close($db);
			
			echo "RS".$_POST['bulan'].substr($_POST['tahun'], 2, 2).".dbf";
		}else{
			echo "Can't open database";
		}
	}
	
	public function pembayaranhutang(){
		$def = array(
		  array("URUT","N", 11, 0),
		  array("TANGGAL","C", 10),
		  array("BUKTI","C", 20),
		  array("KD_SUP","C", 20),
		  array("NM_SUP","C", 100),
		  array("REF_RP","C", 20),
		  array("NO_NOTA","C", 20),
		  array("TOTAL_NOTA", "N", 11, 2),
		  array("TOTAL_BYR", "N", 11, 2),
		  array("BUKTI_BYR", "C", 20),
		  array("JML_HTANG", "N", 11, 2),
		  array("JML_RTUR", "N", 11, 2),
		  array("JML_LSTING", "N", 11, 2),
		  array("JML_BYR", "N", 11, 2),
		  array("KD_BANK", "C", 10),
		  array("NM_BANK", "C", 30),
		  array("SUB_KB", "C", 10),
		  array("URAIAN", "C", 10)
		);
		if (!dbase_create("dbfdir/PH".$_POST['bulan'].substr($_POST['tahun'], 2, 2).".dbf", $def)) {
			//echo "Error, can't create the database\n";
		}else{
			//echo "Success, dbf berhasil dibuat\n";
		}
		
		$db = dbase_open("dbfdir/PH".$_POST['bulan'].substr($_POST['tahun'], 2, 2).".dbf", 2);
		if($db){
			$DataPembayaranHutang = $this->exportdbf_model->getDataPembayaranHutang($_POST);
			$inc = 1;
			foreach($DataPembayaranHutang as $key => $value){
				$data = array(
							$inc,
							$value['tanggal'],
							$value['bukti'],
							$value['supplier_kode'],
							$value['nama_supplier'],
							$value['bukti'],
							$value['bukti'],
							$value['total_bayar'],
							$value['total_bayar'],
							$value['bukti'],
							$value['jumlah_hutang'],
							$value['jumlah_potong'],
							$value['jumlah_listing'],
							$value['total_bayar'],
							$this->getKodeBank($value['nama_bank']),
							$value['nama_bank'],
							$this->getKodeBank($value['nama_bank']),
							$value['realisasi_melalui']
						);
				dbase_add_record($db, $data);
				
				$inc++;
			}
			dbase_close($db);
			
			echo "PH".$_POST['bulan'].substr($_POST['tahun'], 2, 2).".dbf";
		}else{
			echo "Can't open database";
		}
	}
	
	public function droppingkaskecil(){
		$def = array(
			array("TANGGAL","C", 10),
			array("KB","C", 10),
			array("KD_SUBKB","C", 10),
			array("KD_UNIT","C", 10),
			array("SUB_AKUN","C", 10),
			array("AKUN","C", 10),
			array("NO_FORM","C", 10),
			array("JUMLAH", "N", 11, 0)
		);
		if (!dbase_create("dbfdir/PPUV".$_POST['bulan'].substr($_POST['tahun'], 2, 2).".dbf", $def)) {
			//echo "Error, can't create the database\n";
		}else{
			//echo "Success, dbf berhasil dibuat\n";
		}
		
		$db = dbase_open("dbfdir/PPUV".$_POST['bulan'].substr($_POST['tahun'], 2, 2).".dbf", 2);
		if($db){
			$DataKasbank = $this->exportdbf_model->getLaporanDBF($_POST);
			
			foreach($DataKasbank as $key => $value){
				$UnitKode = "";
				switch($value['unit_kode']){
					case "VO0001" : $UnitKode = "3201"; break;
					case "VO0002" : $UnitKode = "3203"; break;
					case "VO0003" : $UnitKode = "3205"; break;
					case "VO0004" : $UnitKode = "3206"; break;
					case "VO0005" : $UnitKode = "3207"; break;
					case "VO0008" : $UnitKode = "6106"; break;
				}
				$data = array(
							$value['tanggal'],
							"11204",
							"2401",
							$UnitKode,
							$UnitKode."000",
							"65555",
							$value['no_ref'],
							$value['jumlah']
							);
				dbase_add_record($db, $data);
			}
			dbase_close($db);
			
			echo "PPUV".$_POST['bulan'].substr($_POST['tahun'], 2, 2).".dbf";
		}else{
			echo "Can't open database";
		}
	}
	
	public function getKodeBank($namabank){
		$kodebank = "";
		
		switch($namabank){
			case "KB PUSAT" :
				$kodebank = "111101111";
				break;
			case "REK. BRI ADM" :
				$kodebank = "112012101";
				break;
			case "REK. BNI PUSAT" :
				$kodebank = "112022201";
				break;
			case "REK. NIAGA PUSAT" :
				$kodebank = "112032301";
				break;
			case "REK. MANDIRI" :
				$kodebank = "112042401";
				break;
			case "REK. BPD JATIM PUSAT" :
				$kodebank = "112052501";
				break;
			case "REK. LIPPO PUSAT" :
				$kodebank = "";
				break;
			case "REK. BCA PUSAT" :
				$kodebank = "112092801";
				break;
			case "REK. DANAMON PUSAT" :
				$kodebank = "112102901";
				break;
			case "REK. MUAMALAT PUSAT" :
				$kodebank = "112113101";
				break;
			case "REK. BII PUSAT" :
				$kodebank = "112123301";
				break;
			case "REK. SYARIAH MANDIRI" :
				$kodebank = "112163701";
				break;
			case "REK. DANAMON SYARIAH" :
				$kodebank = "112402901";
				break;
		}
		
		return $kodebank;
	}
	
	public function datadroppingkaskecil(){
		$DataResult = $this->exportdbf_model->getLaporanDroppingKasKecil($_GET);
		echo json_encode($DataResult);
	}
}