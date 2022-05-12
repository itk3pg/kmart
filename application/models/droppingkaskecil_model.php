<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Droppingkaskecil_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getDataDroppingKasKecil($data){
		$tahun = date("Y");
		if(isset($data['tahun'])){
			$tahun = $data['tahun'];
		}
		
		$bulan = date("m");
		if(isset($data['bulan'])){
			$bulan = $data['bulan'];
		}
			
		$userAkses = array("KW01033", "KW99004", "KW95130", "KW96156", "KW08022", "TK13074","KW10008", "KW94103");
		$query = "";
		//print_r($_SESSION);
		if(in_array($this->session->userdata('username'), $userAkses)){
			$query = "select a.*, b.nama from dropping_kaskecil a left join toko b on a.unit_kode=b.kode 
			where a.is_hapus='0' and a.unit_kode like '%".$data['unit_kode']."%' and (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."')";
			//echo $_SESSION['user'].$query;
		}else{
			$query = "select a.*, b.nama from dropping_kaskecil a left join toko b on a.unit_kode=b.kode 
			where a.unit_kode='".$data['unit_kode']."' and (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0'";
			//echo $_SESSION['user'].$query;
		}
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getDataDropping($data){
		$query = "select a.*, b.nama as nama_unit from dropping_kaskecil a left join toko b on a.unit_kode=b.kode where a.bukti='".$data['bukti']."' and a.unit_kode='".$data['unit_kode']."'";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getDataBankDropping($data){
		$query = "select substring(BUKTI, 2, 1) as `mode`, sum(a.jumlah) as jumlah from kasbank a where a.no_ref_dropping='".$data['bukti']."' and a.kd_cb<>'2804' and a.kd_cb<>'1802' and a.kd_cb<>'2800' and a.kd_cb<>'1800' and a.is_hapus='0' and a.kd_kb='223' and unit_kode='".$data['unit_kode']."' group by substring(BUKTI, 2, 1)";
		
		$result = $this->db->query($query);
		$resultArr = $result->result_array();
		
		$Return = array();
		$Return['saldo_bank_masuk'] = 0;
		$Return['saldo_bank_keluar'] = 0;
		if(sizeof($resultArr) > 0){
			foreach($resultArr as $key => $value){
				if($value['mode'] == "K"){
					$Return['saldo_bank_keluar'] = $value['jumlah'];
				}
				if($value['mode'] == "M"){
					$Return['saldo_bank_masuk'] = $value['jumlah'];
				}
			}
		}
		
		return $Return;
	}
	
	function getTahap($data){
		$query = "select tahap_pengajuan from dropping_kaskecil where YEAR(tanggal)=".date("Y")." and MONTH(tanggal)=".date("m")." and unit_kode='".$data['unit_kode']."' and is_hapus='0' order by tahap_pengajuan desc limit 1";
		
		$result =  $this->db->query($query);
		$resultArr = $result->result_array();
		
		$urut = 0;
		if(sizeof($resultArr) > 0){
			$urut = $resultArr[0]['tahap_pengajuan'];
		}
		
		return ($urut+1)."#".date("Y-m-d H:i:s");
	}
	
	function getSaldoKK($data){
		$tanggalTrue = explode(' ', $data['tanggal']);
		$tanggalArr = explode('-', $data['tanggal']);
		
		$query = "select saldo_awal, saldo_akhir from saldo_kasbank where tahun='".$tanggalArr[0]."' and 
		bulan='".$tanggalArr[1]."' and unit_kode='".$data['unit_kode']."' and kd_kb='111'";
		
		$result = $this->db->query($query);
		$saldoAwal = 0;
		$saldoAkhir = 0;
		$resultArr = $result->result_array();
		
		if(sizeof($resultArr) > 0){
			$saldoAwal = $resultArr[0]['saldo_awal'];
			$saldoAkhir = $resultArr[0]['saldo_akhir'];
		}
		 
		$query = "select substring(bukti, 2, 1) as jenis, sum(jumlah) as jumlah from kasbank where kd_kb='111' and unit_kode='".$data['unit_kode']."' and (tanggal between '".$tanggalArr[0]."-".$tanggalArr[1]."-01' and '".$tanggalTrue[0]."') and is_hapus='0' group by substring(bukti, 2, 1) order by bukti";
		
		$result = $this->db->query($query);
		$kk = 0;
		$km = 0;
		$resultArr = $result->result_array();
		foreach($resultArr as $key => $value){
			if($value['jenis'] == "K"){
				$kk = $value['jumlah'];
			}else{
				$km = $value['jumlah'];
			}
		}
		
		$jumlah = $saldoAwal + ($km - $kk);
		return $jumlah;
	}
	
	function getSaldoBankDropping($data){
		$tanggalTrue = explode(' ', $data['tanggal']);
		$tanggalArr = explode('-', $data['tanggal']);
		$query = "select saldo_awal, saldo_akhir from saldo_kasbank where tahun='".$tanggalArr[0]."' and bulan='".$tanggalArr[1]."' and unit_kode='".$data['unit_kode']."' and kd_kb='223'";
		//echo $query."<br/>";
		$result = $this->db->query($query);
		$saldoAwal = 0;
		$saldoAkhir = 0;
		$resultArr = $result->result_array();
		
		if(sizeof($resultArr) > 0){
			$saldoAwal = $resultArr[0]['saldo_awal'];
			$saldoAkhir = $resultArr[0]['saldo_akhir'];
		}
		
		$query = "select substring(bukti, 2, 1) as jenis, sum(jumlah) as jumlah from kasbank where kd_kb='223' and unit_kode='".$data['unit_kode']."' and (tanggal between '".$tanggalArr[0]."-".$tanggalArr[1]."-01' and '".$tanggalTrue[0]."') and is_hapus='0' group by substring(bukti, 2, 1) order by bukti";
		//echo $query;
		$result = $this->db->query($query);
		$kk = 0;
		$km = 0;
		$resultArr = $result->result_array();
		foreach($resultArr as $key => $value){
			if($value['jenis'] == "K"){
				$kk = $value['jumlah'];
			}else{
				$km = $value['jumlah'];
			}
		}
		
		$jumlah = $saldoAwal + ($km - $kk);
		
		echo $jumlah;
	}
	
	function getPlafon($data){
		/*$query = "select jumlah from m_plafon_kaskecil where kd_unit='".$_SESSION['kdunit']."'";
			
		$result = mysql_query($query);
		$jumlah = 0;
		while($arr = mysql_fetch_assoc($result)){
			$jumlah = $arr['jumlah'];
		}
		
		echo $jumlah;
		*/
		if($data['unit_kode'] == "VO0001"){ // segunting
			return 24500000;
		}else if($data['unit_kode'] == "VO0002"){ // bogorejo
			return 21000000;
		}else { // MD
			return 38000000;
		}
	}
	
	function SimpanDroppingKasKecil($data){
		$is_tutup_sebelumnya = 1;
		$tahun = intval(date('Y'));
		$bulan = intval(date('m'));
		
		if($data['ins_tahap_pengajuan'] == 1){
			$bulan = $bulan - 1;
			if($bulan == 0){
				$bulan = 12;
				$tahun = $tahun - 1;
			}
			$querycek = "select is_realisasi from dropping_kaskecil where year(tanggal)=".$tahun." and month(tanggal)=".$bulan." 
			and unit_kode='".$data['unit_kode']."' and is_hapus='0' order by tahap_pengajuan desc limit 1";
			
			$result = $this->db->query($querycek);
			$resultArr = $result->result_array();
			$jumlahRow = sizeof($resultArr);
			
			if($jumlahRow == 0){
				$is_tutup_sebelumnya = 1;
			}else if($resultArr[0]['is_realisasi'] == '1'){
				$is_tutup_sebelumnya = 1;
			}else{
				$is_tutup_sebelumnya = 0;
			}
		}else{
			$querycek = "select is_realisasi from dropping_kaskecil where year(tanggal)=".$tahun." and month(tanggal)=".$bulan." 
			and unit_kode='".$data['unit_kode']."' and is_hapus='0' and tahap_pengajuan='".($data['ins_tahap_pengajuan'] - 1)."'";
			
			$result = $this->db->query($querycek);
			$resultArr = $result->result_array();
			if($resultArr[0]['is_realisasi'] == '1'){
				$is_tutup_sebelumnya = 1;
			}else{
				$is_tutup_sebelumnya = 0;
			}
		}
		
		if($is_tutup_sebelumnya == 1){
			$query = "select SUBSTRING(bukti, 3, 8) as sub, SUBSTRING(bukti, 7, 4) as urutan FROM dropping_kaskecil where MONTH(tanggal)=".date('m')." and YEAR(tanggal)=".date('Y')." order by cast(sub as signed) desc limit 1";
			$result = $this->db->query($query);
			$resultArr = $result->result_array();
			$urutan = 0;
			if(sizeof($resultArr) > 0){
				$urutan = intval($resultArr[0]['urutan']);
			}
			$urutan += 1;
			if($urutan < 10){
				$urutan = '000'.$urutan;
			}else if($urutan < 100){
				$urutan = '00'.$urutan;
			}else if($urutan < 1000){
				$urutan = '0'.$urutan;
			}
			$noBukti = "DP".date('m').date('y').$urutan;
			
			/**
			 * 
			 * Name	Datatype	Comment
			 * no_bukti	varchar(9)	
			 * tanggal	datetime	
			 * k_unit	varchar(4)	
			 * tahap_pengajuan	varchar(1)	
			 * saldo_kas_kecil	double	
			 * jumlah	double	
			 * user_pengajuan	varchar(10)	
			 * is_app_dok	varchar(1)	
			 * user_app_dok	varchar(10)	
			 * is_verfikasi	varchar(1)	
			 * user_verifikasi	varchar(10)	
			 * is_ppu	varchar(1)	
			 * user_ppu	varchar(10)	
			 * is_realisasi	varchar(1)	
			 * user_realisasi	varchar(10)	
			 * is_hapus	varchar(1)	
			 * waktu_insert	datetime	
			 * waktu_app_dok	datetime	
			 * waktu_verifikasi	datetime	
			 * waktu_ppu	datetime	
			 * waktu_realisasi	datetime	
			 * 
			 */
			
			$query = "insert into dropping_kaskecil(bukti, unit_kode, tanggal, tahap_pengajuan, saldo_kas_kecil, jumlah, user_pengajuan, is_app_dok, user_app_dok, is_verifikasi, user_verifikasi, keterangan_verifikasi, is_ppu, user_ppu, is_realisasi, user_realisasi, is_hapus, waktu_insert, waktu_app_dok, waktu_verifikasi, waktu_ppu, waktu_realisasi) values('".$noBukti."','".$data['unit_kode']."','".$data['ins_tanggal']."','".$data['ins_tahap_pengajuan']."',".$data['ins_saldo_kkecil'].",".$data['ins_jumlah'].",'".$this->session->userdata('username')."','0', null,'0', null, null,'0', null,'0', null,'0', now(), null, null, null, null)";
			// if($_SERVER['REMOTE_ADDR'] == '172.20.110.46'){
				// echo $query;
				// exit;
			// }else{
				$this->db->query($query);
			// }
			
			// Insert no bukti dropping untuk transaksi terakhir
			$queryUpdateKasbank = "update kasbank set no_ref_dropping='".$noBukti."' where (kd_kb='111' or kd_kb='223') and (no_ref_dropping is null or no_ref_dropping='') and unit_kode='".$data['unit_kode']."'";
			$this->db->query($queryUpdateKasbank);
			
			return "{\"pesan\":\"Data berhasil disimpan dengan no bukti ".$noBukti."\", \"no_bukti\":\"".$noBukti."\"}";
		}else{
			return "{\"pesan\":\"gagal\", \"no_bukti\":\"-\"}";
			//echo "gagal";
		}
	}
	
	function setApproveDok($data){
		$query = "update dropping_kaskecil set is_app_dok='1', user_app_dok='".$this->session->userdata('username')."', waktu_app_dok=now() where bukti='".$data['bukti']."' and unit_kode='".$data['unit_kode']."'";
		
		$this->db->query($query);
	}
	
	function setVerifikasi($data){
		$queryDelete = "delete from temuan_dropping where dropping_kaskecil_bukti='".$data['bukti']."'";
		$this->db->query($queryDelete);
		for($i=0;$i<$data['jumlah_temuan'];$i++){
			$querytemuan = "insert into temuan_dropping(kode, dropping_kaskecil_bukti, keterangan, is_selesai, user_id, is_hapus, waktu_update) values(".($i+1).",'".$data['bukti']."','".$this->db->escape_str($data['temuan'.$i])."','0','".$this->session->userdata('username')."','0',NOW())";
			
			$this->db->query($querytemuan);
		}
		
		$query = "update dropping_kaskecil set is_verifikasi='1', user_verifikasi='".$this->session->userdata('username')."', waktu_verifikasi=now(), keterangan_verifikasi='' where bukti='".$data['bukti']."' and unit_kode='".$data['unit_kode']."'";
		
		$this->db->query($query);
	}
	
	function setPPU($data){
		$query = "update dropping_kaskecil set is_ppu='1', user_ppu='".$this->session->userdata('username')."', waktu_ppu=now() where bukti='".$data['bukti']."' and unit_kode='".$data['unit_kode']."'";
			
		$this->db->query($query);
	}
	
	function setRealisasi($data){
		$this->load->model('kasbank_model');
		
		$query = "update dropping_kaskecil set is_realisasi='1', user_realisasi='".$this->session->userdata('username')."', waktu_realisasi=now() where bukti='".$data['bukti']."' and unit_kode='".$data['unit_kode']."'";
			
		$this->db->query($query);
		
		// input kasbank
		$paramkasbank = array();
		$paramkasbank['mode'] = "BM";
		$paramkasbank['kd_cb'] = "1802"; // 190
		$paramkasbank['mode_form'] = "i";
		$paramkasbank['unit_kode'] = $data['unit_kode'];
		$paramkasbank['kd_kb'] = "223";
		$paramkasbank['tanggal'] = date('Y-m-d');
		$paramkasbank['kd_subject'] = "";
		$paramkasbank['nama_subject'] = "";
		$paramkasbank['keterangan'] = "DROPPING KAS KECIL ".$data['bukti'];
		$paramkasbank['jumlah'] = $data['jumlah'];
		$paramkasbank['no_ref'] = $data['bukti'];
		
		$bukti_kasbank = $this->kasbank_model->SimpanKasbank($paramkasbank);
	}
	
	function HapusDroppingKasKecil($data){
		$query = "update dropping_kaskecil set is_hapus='1' where bukti='".$data['bukti']."' and unit_kode='".$data['unit_kode']."'";
		
		$this->db->query($query);
		
		$queryUpdateKasbank = "update kasbank set no_ref_dropping=null where no_ref_dropping='".$data['bukti']."' and unit_kode='".$data['unit_kode']."'";
		$this->db->query($queryUpdateKasbank);
	}
	
	function getDataTemuan($data){
		$query = "select * from temuan_dropping where dropping_kaskecil_bukti='".$data['bukti']."'";
		
		$result = $this->db->query($query);
		
		return $result->result_array();
	}
	
	function getrinciankaskecil($data){
		$query = "select * from kasbank where no_ref_dropping='".$data['bukti']."' and unit_kode='".$data['unit_kode']."' and kd_kb='111' and substring(bukti, 2, 1)='K' and is_hapus='0' order by tanggal";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getpengeluaranbankdropping($data){
		$query = "select * from kasbank a where a.no_ref_dropping='".$data['bukti']."' and a.unit_kode='".$data['unit_kode']."' and a.kd_kb='223' and substring(a.bukti, 2, 1)='K' and a.kd_cb<>'2804' and a.kd_cb<>'1802' and a.kd_cb<>'2800' and a.is_hapus='0' order by a.tanggal";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getpemasukanbankdropping($data){
		$query = "select * from kasbank a where a.no_ref_dropping='".$data['bukti']."' and a.unit_kode='".$data['unit_kode']."' and a.kd_kb='223' and substring(a.bukti, 2, 1)='M' and kd_cb<>'2804' and a.kd_cb<>'1802' and a.kd_cb<>'2800' and a.kd_cb<>'1800' and a.is_hapus='0' order by a.tanggal";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
}

?>