<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(E_ALL);
set_time_limit(14400);
class Syncsaldo_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function SyncSaldoKasbank($data){
		//$querygetmunit = "select kode from toko where is_hapus<>'2'";
		//$Resultmunit = $this->db->query($querygetmunit);
		//$ResultArrmunit = $Resultmunit->result_array();
		
		$querygetmkb = "select kd_kb from m_kb";
		$Resultmkb = $this->db->query($querygetmkb);
		$ResultArrmkb = $Resultmkb->result_array();
		
		$bulansebelum = $data['bulan'] - 1;
		$tahunsebelum = $data['tahun'];
		if($bulansebelum == 0){
			$bulansebelum = 12;
			$tahunsebelum = $data['tahun'] - 1;
		}
		
		foreach ($ResultArrmkb as $key => $value) {
			$querygetsaldoawal = "";
			if($data['bulan'] == 10 && $data['tahun'] == 2018){
				$querygetsaldoawal = "select a.saldo_awal saldo_akhir from saldo_kasbank a where a.bulan=".$data['bulan']." 
				and a.tahun=".$data['tahun']." and a.kd_kb='".$value['kd_kb']."' and a.unit_kode='".$data['unit_kode']."'";
			}else{
				$querygetsaldoawal = "select a.saldo_akhir from saldo_kasbank a where a.bulan=".$bulansebelum." 
				and a.tahun=".$tahunsebelum." and a.kd_kb='".$value['kd_kb']."' and a.unit_kode='".$data['unit_kode']."'";
			}
			
			$Resultsa = $this->db->query($querygetsaldoawal);
			$ResultArrsa = $Resultsa->result_array();
			
			$querydebetkredit = "select SUBSTR(a.bukti,2,1) mode, sum(a.jumlah) jumlah 
			from kasbank a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." 
			and a.is_hapus='0' and a.kd_kb='".$value['kd_kb']."' and a.unit_kode='".$data['unit_kode']."' 
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
			and a.tahun=".$data['tahun']." and a.kd_kb='".$value['kd_kb']."' and a.unit_kode='".$data['unit_kode']."'";
			$Resultcurr = $this->db->query($querygetcurrent);
			$ResultArrcurr = $Resultcurr->result_array();
			
			if(sizeof($ResultArrcurr) > 0){
				$queryUpdate = "update saldo_kasbank set saldo_awal=".$SaldoAwal.", debet=".$debet.", kredit=".$kredit.", 
				saldo_akhir=".$SaldoAkhir." where bulan=".$data['bulan']." and tahun=".$data['tahun']." and kd_kb='".$value['kd_kb']."' and unit_kode='".$data['unit_kode']."'";
				$this->db->query($queryUpdate);
			}else{
				$queryInsert = "insert into saldo_kasbank(kd_kb, unit_kode, bulan, tahun, saldo_awal, debet, kredit, saldo_akhir, 
				waktu_update) values('".$value['kd_kb']."', '".$data['unit_kode']."', ".$data['bulan'].", ".$data['tahun'].", ".$SaldoAwal.", 
				".$debet.", ".$kredit.", ".$SaldoAkhir.", NOW())";
				
				$this->db->query($queryInsert);
			}
		}
		
		echo "..... Selesai Sync data saldo kasbank ....."."<br/>";
	}
	
	public function SyncSaldoHutang($data){
		$querygetmvendor = "select kode from supplier";
		$Resultmvendor = $this->db->query($querygetmvendor);
		$ResultArrmvendor = $Resultmvendor->result_array();
		
		$bulansebelum = $data['bulan'] - 1;
		$tahunsebelum = $data['tahun'];
		if($bulansebelum == 0){
			$bulansebelum = 12;
			$tahunsebelum = $data['tahun'] - 1;
		}
		
		foreach ($ResultArrmvendor as $key => $value) {
			if($data['bulan'] == 10 && $data['tahun'] == 2018){
				$querygetsaldoawal = "select a.saldo_awal saldo_akhir from saldo_hutang a where a.bulan=".$data['bulan']." 
				and a.tahun=".$data['tahun']." and a.supplier_kode='".$value['kode']."'";
			}else{
				$querygetsaldoawal = "select a.saldo_akhir from saldo_hutang a where a.bulan=".$bulansebelum." 
				and a.tahun=".$tahunsebelum." and a.supplier_kode='".$value['kode']."'";
			}
			
			$Resultsa = $this->db->query($querygetsaldoawal);
			$ResultArrsa = $Resultsa->result_array();
			
			$queryHutang = "select supplier_kode, sum(jumlah) jumlah from hutang where month(tanggal)=".$data['bulan']." 
			and year(tanggal)=".$data['tahun']." 
			and supplier_kode='".$value['kode']."' group by supplier_kode";
			
			$Resulthutang = $this->db->query($queryHutang);
			$ResultArrhutang = $Resulthutang->result_array();
			
			$queryPembayaran = "select supplier_kode, sum(jumlah) as jumlah from hutang where month(tanggal_lunas)=".$data['bulan']." and year(tanggal_lunas)=".$data['tahun']." and is_lunas='1' and supplier_kode='".$value['kode']."' group by supplier_kode";
			/*$queryPembayaran = "select supplier_kode, sum(jumlah) jumlah from pembayaran_hutang where month(tanggal)=".$data['bulan']." 
			and year(tanggal)=".$data['tahun']." 
			and supplier_kode='".$value['kode']."' and is_hapus='0' group by supplier_kode";*/
			
			$ResultPembayaran = $this->db->query($queryPembayaran);
			$ResultArrpembayaran = $ResultPembayaran->result_array();
			
			$queryRetur = "select supplier_kode, sum(jumlah) as jumlah from saldo_retur_supplier where month(tanggal)=".$data['bulan']." and year(tanggal)=".$data['tahun']." and supplier_kode='".$value['kode']."' group by supplier_kode";
			
			$ResultRetur = $this->db->query($queryRetur);
			$ResultArrRetur = $ResultRetur->result_array();
			
			$QueryRealisasiRetur = "select a.supplier_kode, sum(a.jumlah) as jumlah from saldo_retur_supplier a where a.status='2' and month(a.waktu_realisasi)=".$data['bulan']." and year(a.waktu_realisasi)=".$data['tahun']." and a.supplier_kode='".$value['kode']."' group by a.supplier_kode";
			$ResultRealisasiRetur = $this->db->query($QueryRealisasiRetur);
			$ResultArrRealisasiRetur = $ResultRealisasiRetur->result_array();
			
			$SaldoAwal = 0;
			$hutang = 0;
			$pembayaran = 0;
			$retur = 0;
			$realisasiretur = 0;
			if(sizeof($ResultArrsa) > 0){
				$SaldoAwal = $ResultArrsa[0]['saldo_akhir'];
			}
			if(sizeof($ResultArrhutang) > 0){
				$hutang = $ResultArrhutang[0]['jumlah'];
			}
			if(sizeof($ResultArrpembayaran) > 0){
				$pembayaran = $ResultArrpembayaran[0]['jumlah'];
			}
			if(sizeof($ResultArrRetur) > 0){
				$retur = $ResultArrRetur[0]['jumlah'];
			}
			if(sizeof($ResultArrRealisasiRetur) > 0){
				$realisasiretur = $ResultArrRealisasiRetur[0]['jumlah'];
			}
			$SaldoAkhir = $SaldoAwal + ($hutang - ($pembayaran - $realisasiretur) - $retur);
			
			$querygetcurrent = "select * from saldo_hutang a where a.bulan=".$data['bulan']." 
			and a.tahun=".$data['tahun']." and a.supplier_kode='".$value['kode']."'";
			$Resultcurr = $this->db->query($querygetcurrent);
			$ResultArrcurr = $Resultcurr->result_array();
			
			if(sizeof($ResultArrcurr) > 0){
				$queryUpdate = "update saldo_hutang set saldo_awal=".$SaldoAwal.", hutang=".$hutang.", bayar=".$pembayaran.", retur=".$retur.", 
				saldo_akhir=".$SaldoAkhir." where bulan=".$data['bulan']." and tahun=".$data['tahun']." and supplier_kode='".$value['kode']."'";
				$this->db->query($queryUpdate);
			}else{
				$queryInsert = "insert into saldo_hutang(supplier_kode, bulan, tahun, saldo_awal, hutang, bayar, retur, saldo_akhir, 
				waktu_update) values('".$value['kode']."', ".$data['bulan'].", ".$data['tahun'].", ".$SaldoAwal.", 
				".$hutang.", ".$pembayaran.", ".$retur.", ".$SaldoAkhir.", NOW())";
				
				$this->db->query($queryInsert);
			}
		}
		
		echo "..... Selesai Sync data saldo hutang ....."."<br/>";
	}
	
	public function SyncSaldoPiutang($data){
		// $querygetmpel = "select kode from pelanggan where jenis_pelanggan<>'1440822187'";
		$Datatoko = array();
		$Datatoko[0]['toko_kode'] = "VO0001";
		$Datatoko[1]['toko_kode'] = "VO0002";

		foreach ($Datatoko as $key => $valuetoko) {
			$querygetmpel = "select distinct f.pelanggan_kode as kode from piutang f where f.toko_kode='".$valuetoko['toko_kode']."'";
			$Resultmpel = $this->db->query($querygetmpel);
			$ResultArrmpel = $Resultmpel->result_array();
			
			$bulansebelum = $data['bulan'] - 1;
			$tahunsebelum = $data['tahun'];
			if($bulansebelum == 0){
				$bulansebelum = 12;
				$tahunsebelum = $data['tahun'] - 1;
			}
			
			foreach ($ResultArrmpel as $key => $value) {
				if($data['bulan'] == 10 && $data['tahun'] == 2018){
					$querygetsaldoawal = "select a.saldo_awal saldo_akhir from saldo_piutang a where a.bulan=".$data['bulan']." 
					and a.tahun=".$data['tahun']." and a.pelanggan_kode='".$value['kode']."' and toko_kode='".$valuetoko['toko_kode']."'";
				}else{
					$querygetsaldoawal = "select a.saldo_akhir from saldo_piutang a where a.bulan=".$bulansebelum." 
					and a.tahun=".$tahunsebelum." and a.pelanggan_kode='".$value['kode']."' and toko_kode='".$valuetoko['toko_kode']."'";
				}
				
				$Resultsa = $this->db->query($querygetsaldoawal);
				$ResultArrsa = $Resultsa->result_array();
				
				$queryPiutang = "select pelanggan_kode, sum(jumlah) jumlah from piutang where month(tanggal)=".$data['bulan']." 
				and year(tanggal)=".$data['tahun']." 
				and pelanggan_kode='".$value['kode']."' and toko_kode='".$valuetoko['toko_kode']."' group by pelanggan_kode";
				
				$Resultpiutang = $this->db->query($queryPiutang);
				$ResultArrpiutang = $Resultpiutang->result_array();
				
				$queryPembayaran = "select pelanggan_kode, sum(jumlah) jumlah from pembayaran_piutang where month(tanggal)=".$data['bulan']." 
				and year(tanggal)=".$data['tahun']." 
				and pelanggan_kode='".$value['kode']."' and toko_kode='".$valuetoko['toko_kode']."' and is_hapus='0' group by pelanggan_kode";
				
				$ResultPembayaran = $this->db->query($queryPembayaran);
				$ResultArrpembayaran = $ResultPembayaran->result_array();
				
				$SaldoAwal = 0;
				$piutang = 0;
				$pembayaran = 0;
				if(sizeof($ResultArrsa) > 0){
					$SaldoAwal = $ResultArrsa[0]['saldo_akhir'];
				}
				if(sizeof($ResultArrpiutang) > 0){
					$piutang = $ResultArrpiutang[0]['jumlah'];
				}
				if(sizeof($ResultArrpembayaran) > 0){
					$pembayaran = $ResultArrpembayaran[0]['jumlah'];
				}
				$SaldoAkhir = $SaldoAwal + ($piutang - $pembayaran);
				
				$querygetcurrent = "select * from saldo_piutang a where a.bulan=".$data['bulan']." 
				and a.tahun=".$data['tahun']." and a.pelanggan_kode='".$value['kode']."' and toko_kode='".$valuetoko['toko_kode']."'";
				$Resultcurr = $this->db->query($querygetcurrent);
				$ResultArrcurr = $Resultcurr->result_array();
				
				if(sizeof($ResultArrcurr) > 0){
					$queryUpdate = "update saldo_piutang set saldo_awal=".$SaldoAwal.", piutang=".$piutang.", bayar=".$pembayaran.", 
					saldo_akhir=".$SaldoAkhir." where bulan=".$data['bulan']." and tahun=".$data['tahun']." and pelanggan_kode='".$value['kode']."' and toko_kode='".$valuetoko['toko_kode']."'";
					$this->db->query($queryUpdate);
				}else{
					$queryInsert = "insert into saldo_piutang(pelanggan_kode, bulan, tahun, saldo_awal, piutang, bayar, saldo_akhir, 
					waktu_update, toko_kode) values('".$value['kode']."', ".$data['bulan'].", ".$data['tahun'].", ".$SaldoAwal.", 
					".$piutang.", ".$pembayaran.", ".$SaldoAkhir.", NOW(), '".$valuetoko['toko_kode']."')";
					
					$this->db->query($queryInsert);
				}
			}
		}
		
		echo "..... Selesai Sync data saldo piutang ....."."<br/>";
	}

	public function SyncSaldoBarang($data){
		$bulanSebelum = $data['bulan'] - 1;
		$tahunSebelum = $data['tahun'];
		if($bulanSebelum == 0){
			$bulanSebelum = 12;
			$tahunSebelum = $data['tahun'] - 1;
		}
		$queryPindahHpp = "INSERT INTO hpp (tahun, bulan, barang_kode, hpp, hpp_awal) SELECT ".$data['tahun']." as tahun, ".$data['bulan']." as bulan, a.barang_kode, a.hpp, a.hpp as hpp_awal from hpp a where a.bulan=".$bulanSebelum." and a.tahun=".$tahunSebelum." on duplicate key update hpp=a.hpp, hpp_awal=a.hpp";
		$this->db->query($queryPindahHpp);
		
		$a_date = $data['tahun']."-".$data['bulan']."-01";
		$querygethpp = "SELECT a.supplier_kode, a.barang_kode, a.tanggal, (a.harga + a.ppn) as harga FROM pengadaan_barang a INNER JOIN ( SELECT a.barang_kode, GROUP_CONCAT(a.waktu_update ORDER BY a.waktu_update DESC) grouped_year FROM pengadaan_barang a where a.is_hapus='0' AND a.tanggal<='".date("Y-m-t", strtotime($a_date))."' GROUP BY barang_kode) group_max ON a.barang_kode = group_max.barang_kode AND FIND_IN_SET(a.waktu_update, grouped_year) BETWEEN 1 AND 1 where a.is_hapus='0' AND a.tanggal<='".date("Y-m-t", strtotime($a_date))."' ORDER BY a.barang_kode, a.tanggal DESC";
		
		$Resulthpp = $this->db->query($querygethpp);
		$ResulthppArr = $Resulthpp->result_array();

		foreach ($ResulthppArr as $key => $value) {
			$queryUpdateHPPMBarang = "update barang set hpp=".$value['harga'].", waktu_hpp='".$value['tanggal']."' where kode='".$value['barang_kode']."'";
			$queryUpdateHargaSupplier = "update harga_barang_supplier set harga=".$value['harga'].", harga_periode=".$value['harga'].", periode='".$value['tanggal']."' where barang_kode='".$value['barang_kode']."' and supplier_kode='".$value['supplier_kode']."'";
			$queryUpdateHpp = "insert into hpp(bulan, tahun, barang_kode, hpp) value(".$data['bulan'].", ".$data['tahun'].", '".$value['barang_kode']."', ".$value['harga'].") on duplicate key update hpp=".$value['harga']."";

			$this->db->query($queryUpdateHPPMBarang);
			$this->db->query($queryUpdateHargaSupplier);
			$this->db->query($queryUpdateHpp);
		}

		$querygethpp = "SELECT a.supplier_kode, a.barang_kode, a.tanggal, (a.harga + a.ppn) as harga FROM pengadaan_barang_konsinyasi a INNER JOIN ( SELECT a.barang_kode, GROUP_CONCAT(a.waktu_update ORDER BY a.waktu_update DESC) grouped_year FROM pengadaan_barang_konsinyasi a where a.is_hapus='0' AND a.tanggal<='".date("Y-m-t", strtotime($a_date))."' GROUP BY barang_kode) group_max ON a.barang_kode = group_max.barang_kode AND FIND_IN_SET(a.waktu_update, grouped_year) BETWEEN 1 AND 1 where a.is_hapus='0' AND a.tanggal<='".date("Y-m-t", strtotime($a_date))."' ORDER BY a.barang_kode, a.tanggal DESC";

		$Resulthpp = $this->db->query($querygethpp);
		$ResulthppArr = $Resulthpp->result_array();

		foreach ($ResulthppArr as $key => $value) {
			$queryUpdateHPPMBarang = "update barang set hpp=".$value['harga'].", waktu_hpp='".$value['tanggal']."' where kode='".$value['barang_kode']."'";
			$queryUpdateHargaSupplier = "update harga_barang_supplier set harga=".$value['harga'].", harga_periode=".$value['harga'].", periode='".$value['tanggal']."' where barang_kode='".$value['barang_kode']."' and supplier_kode='".$value['supplier_kode']."'";
			$queryUpdateHpp = "insert into hpp(bulan, tahun, barang_kode, hpp) value(".$data['bulan'].", ".$data['tahun'].", '".$value['barang_kode']."', ".$value['harga'].") on duplicate key update hpp=".$value['harga']."";

			$this->db->query($queryUpdateHPPMBarang);
			$this->db->query($queryUpdateHargaSupplier);
			$this->db->query($queryUpdateHpp);
		}
		
		echo "..... Selesai Sync data hpp ....."."<br/>";
	}
	
	// public function SyncSaldoBarang($data){
	// 	$querygetmbarang = "select kode as barang_kode from barang where is_hapus='0'";
	// 	$Resultmbarang = $this->db->query($querygetmbarang);
	// 	$ResultArrmbarang = $Resultmbarang->result_array();
		
	// 	$bulansebelum = $data['bulan'] - 1;
	// 	$tahunsebelum = $data['tahun'];
	// 	if($bulansebelum == 0){
	// 		$bulansebelum = 12;
	// 		$tahunsebelum = $data['tahun'] - 1;
	// 	}
		
	// 	// remove saldo barang
	// 	$querydelete = "delete from saldo_barang where bulan=".$data['bulan']." and tahun=".$data['tahun']."";
	// 	$this->db->query($querydelete);
		
	// 	foreach ($ResultArrmbarang as $key => $value) {
	// 		$querygetsaldoawal = "select saldo_akhir_kwt, saldo_akhir_hsat, (saldo_akhir_kwt * saldo_akhir_hsat) jumlah, 
	// 		kwt_out from saldo_barang where barang_kode='".$value['barang_kode']."' and bulan=".$bulansebelum." 
	// 		and tahun=".$tahunsebelum." order by urut desc limit 1";
			
	// 		$Resultsa = $this->db->query($querygetsaldoawal);
	// 		$ResultArrsa = $Resultsa->result_array();
			
	// 		if(sizeof($ResultArrsa) == 0){
	// 			$ResultArrsa[0]['saldo_akhir_kwt'] = 0;
	// 			$ResultArrsa[0]['saldo_akhir_hsat'] = 0;
	// 			$ResultArrsa[0]['jumlah'] = 0;
	// 			$ResultArrsa[0]['kwt_out'] = 0;
	// 		}else{ // pindah saldo
	// 			$jumlah_saldo_awal = $ResultArrsa[0]['saldo_akhir_kwt'] * $ResultArrsa[0]['saldo_akhir_hsat'];
				
	// 			//echo $ResultArrsa[0]['saldo_akhir_kwt']."<br/>";
	// 			if($ResultArrsa[0]['saldo_akhir_kwt'] != 0){
	// 				$queryInsert = "insert into saldo_barang(ref_bukti, barang_kode, bulan, tahun, tanggal, saldo_awal_kwt, 
	// 				saldo_awal_hsat, jumlah_saldo_awal, kwt_in, hsat_in, jumlah_in, kwt_out, tau_out, hsat_out, jumlah_out, jumlah_tau_out, saldo_akhir_kwt, 
	// 				saldo_akhir_hsat, jumlah_saldo_akhir, tgl_update, urut) 
	// 				values('PI','".$value['barang_kode']."',".$data['bulan'].",".$data['tahun'].",'".$data['tahun']."-".$data['bulan']."-01',
	// 				".$ResultArrsa[0]['saldo_akhir_kwt'].",".$ResultArrsa[0]['saldo_akhir_hsat'].",".$jumlah_saldo_awal.",0,0,0,0,0,0,0,0,
	// 				".$ResultArrsa[0]['saldo_akhir_kwt'].",".$ResultArrsa[0]['saldo_akhir_hsat'].",".$jumlah_saldo_awal.", NOW(), 1)";
	// 				//echo $queryInsert."<br/>";
	// 				$this->db->query($queryInsert);
	// 			}
	// 		}
	 //k3pg-ppn		
	// 		$queryDataBarang = "select a.bukti, SUBSTR(a.bukti,1,2) as mode, a.barang_kode, a.tanggal, a.waktu_insert, a.harga, a.ppn, a.kwt from pengadaan_barang a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.barang_kode='".$value['barang_kode']."' 
	// 		union 
	// 		select a.fcode, SUBSTR(a.fcode,1,2) as mode, b.fitemkey as barang_kode, a.fdate as tanggal, a.fcreateddt as waktu_insert, round((b.fprice/1.11),2) as harga, round(((b.fprice/1.11)*0.11),2) as ppn, b.fqty as kwt from rst_fc_trans_header a left join rst_fc_trans_detail b on a.fcode=b.fcode and a.flokasi=b.flokasi where a.fstatuskey='1' and month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']." and b.fitemkey='".$value['barang_kode']."' and a.fname_payment<>'TAU' 
	// 		union 
	// 		select a.bukti, SUBSTR(a.bukti,1,2) as mode, a.barang_kode, a.tanggal, a.waktu_insert, a.harga, 0 as ppn, a.kwt from tau_keluar a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.barang_kode='".$value['barang_kode']."' and a.is_hapus='0' 
	// 		union 
	// 		select a.bukti, SUBSTR(a.bukti,1,2) as mode, a.barang_kode, a.tanggal, a.waktu_insert, 0 as harga, 0 as ppn, a.kwt from retur_supplier a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.barang_kode='".$value['barang_kode']."' and a.is_hapus='0' order by date(tanggal), mode";
			
	// 		$Resultdb = $this->db->query($queryDataBarang);
	// 		$ResultArrdb = $Resultdb->result_array();
	// 		$urut = 2;
	// 		$this->db->query('start transaction');
	// 		foreach ($ResultArrdb as $keydb => $valuedb) {
	// 			$tglArr = explode("-", $valuedb['tanggal']);
	// 			$kwt_in = 0;
	// 			$hsat_in = 0;
	// 			$kwt_out = 0;
	// 			$tau_out = 0;
	// 			$saldo_akhir_kwt = 0;
	// 			$saldo_akhir_hsat = 0;
				
	// 			if($valuedb['mode'] == "BI"){
	// 				$kwt_in = $valuedb['kwt'];
	// 				$hsat_in = $valuedb['harga'];
					
	// 				$saldo_akhir_kwt = $ResultArrsa[0]['saldo_akhir_kwt'] + $kwt_in;
	// 				if($saldo_akhir_kwt == 0){
	// 					$saldo_akhir_hsat = $ResultArrsa[0]['saldo_akhir_hsat'];
	// 				}else{
	// 					$saldo_akhir_hsat = (($ResultArrsa[0]['saldo_akhir_kwt'] * $ResultArrsa[0]['saldo_akhir_hsat']) + ($kwt_in * $hsat_in)) / ($ResultArrsa[0]['saldo_akhir_kwt'] + $kwt_in);
	// 				}
	// 			}else if($valuedb['mode'] == "BO" || $valuedb['mode'] == "RS"){
	// 				$kwt_out = $valuedb['kwt'];
					
	// 				$saldo_akhir_kwt = $ResultArrsa[0]['saldo_akhir_kwt'] - $kwt_out;
	// 				$saldo_akhir_hsat = $ResultArrsa[0]['saldo_akhir_hsat'];
	// 			}else if($valuedb['mode'] == "TK"){
	// 				$tau_out = $valuedb['kwt'];
					
	// 				$saldo_akhir_kwt = $ResultArrsa[0]['saldo_akhir_kwt'] - $tau_out;
	// 				$saldo_akhir_hsat = $ResultArrsa[0]['saldo_akhir_hsat'];
	// 			}
	// 			$jumlah_saldo_awal = $ResultArrsa[0]['saldo_akhir_kwt'] * $ResultArrsa[0]['saldo_akhir_hsat'];
	// 			$jumlah_in = $kwt_in * $hsat_in;
	// 			$jumlah_out = $kwt_out * $ResultArrsa[0]['saldo_akhir_hsat'];
	// 			$jumlah_tau_out = $tau_out * $ResultArrsa[0]['saldo_akhir_hsat'];
	// 			$jumlah_saldo_akhir = $saldo_akhir_kwt * $saldo_akhir_hsat;
				
	// 			$queryInsert = "insert into saldo_barang(ref_bukti, barang_kode, bulan, tahun, tanggal, saldo_awal_kwt, 
	// 			saldo_awal_hsat, jumlah_saldo_awal, kwt_in, hsat_in, jumlah_in, kwt_out, tau_out, hsat_out, jumlah_out, jumlah_tau_out, saldo_akhir_kwt, saldo_akhir_hsat, 
	// 			jumlah_saldo_akhir, tgl_update, urut) 
	// 			values('".$valuedb['bukti']."','".$valuedb['barang_kode']."',".$tglArr[1].",".$tglArr[0].",'".$valuedb['tanggal']."',
	// 			".$ResultArrsa[0]['saldo_akhir_kwt'].",".$ResultArrsa[0]['saldo_akhir_hsat'].",".$jumlah_saldo_awal.",".$kwt_in.",".$hsat_in.",
	// 			".$jumlah_in.",".$kwt_out.",".$tau_out.",".$ResultArrsa[0]['saldo_akhir_hsat'].",".$jumlah_out.",".$jumlah_tau_out.",
	// 			".$saldo_akhir_kwt.",".$saldo_akhir_hsat.",".$jumlah_saldo_akhir.", NOW(), ".$urut.")";
				
	// 			$this->db->query($queryInsert);
				
	// 			$ResultArrsa[0]['saldo_akhir_kwt'] = $saldo_akhir_kwt;
	// 			$ResultArrsa[0]['saldo_akhir_hsat'] = $saldo_akhir_hsat;
	// 			$urut++;
	// 		}
	// 		$this->db->query('commit');
	// 		$this->updateInfoHPP($value['barang_kode'], $ResultArrsa[0]['saldo_akhir_hsat']);
	// 	}
		
	// 	echo "..... Selesai Sync data saldo barang ....."."<br/>";
	// }
	
	function SyncSaldoBarangGudang($data){
		$querygetmtoko = "select kode as toko_kode from toko where is_hapus='0'";
		$Resultmtoko = $this->db->query($querygetmtoko);
		$ResultArrmtoko = $Resultmtoko->result_array();
		
		$querygetmbarang = "select kode from barang where is_hapus='0'";
		$Resultmbarang = $this->db->query($querygetmbarang);
		$ResultArrmbarang = $Resultmbarang->result_array();
		
		$bulansebelum = $data['bulan'] - 1;
		$tahunsebelum = $data['tahun'];
		if($bulansebelum == 0){
			$bulansebelum = 12;
			$tahunsebelum = $data['tahun'] - 1;
		}
		
		foreach ($ResultArrmtoko as $keytoko => $valuetoko) {
			foreach ($ResultArrmbarang as $key => $value) {
				$querygetsaldoawal = "";
				if($data['bulan'] == 10 && $data['tahun'] == 2018){
					$querygetsaldoawal = "select a.saldo_awal_kwt saldo_akhir_kwt from saldo_barang_toko a where a.bulan=".$data['bulan']." 
					and a.tahun=".$data['tahun']." and a.barang_kode='".$value['kode']."' and a.toko_kode='".$valuetoko['toko_kode']."'";
				}else{
					$querygetsaldoawal = "select a.saldo_akhir_kwt from saldo_barang_toko a where a.bulan=".$bulansebelum." 
					and a.tahun=".$tahunsebelum." and a.barang_kode='".$value['kode']."' and a.toko_kode='".$valuetoko['toko_kode']."'";
				}
				
				$Resultsa = $this->db->query($querygetsaldoawal);
				$ResultArrsa = $Resultsa->result_array();
				
				// get data Transfer Toko
				$querygetTG = "select sum(a.kwt) as kwt from transfer_toko a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." 
				and a.is_hapus='0' and a.barang_kode='".$value['kode']."' and a.toko_kode='".$valuetoko['toko_kode']."' and a.is_approve='1' group by a.barang_kode";
				$ResultTG = $this->db->query($querygetTG);
				$ResultArrTG = $ResultTG->result_array();
				
				// get data penjualan toko tertentu
				$querygetPB = "select b.fitemkey, sum(b.fqty) as kwt from rst_fc_trans_header a left join rst_fc_trans_detail b on a.fcode=b.fcode and a.flokasi=b.flokasi where a.fstatuskey='1' and month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']." and b.fitemkey='".$value['kode']."' and a.flokasi='".$valuetoko['toko_kode']."' group by b.fitemkey";
				$ResultPB = $this->db->query($querygetPB);
				$ResultArrPB = $ResultPB->result_array();
				
				// get data retur toko
				$querygetReturToko = "select sum(a.kwt) as kwt from retur_toko a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.is_approve='1' and a.toko_kode='".$valuetoko['toko_kode']."' and a.barang_kode='".$value['kode']."' group by a.barang_kode";
				$ResultRT = $this->db->query($querygetReturToko);
				$ResultArrRT = $ResultRT->result_array();
				
				// get data penyesuaian masuk
				$queryPenyesuaianMasuk = "select sum(a.kwt) as kwt from penyesuaian a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.`status`='0' and a.toko_kode='".$valuetoko['toko_kode']."' and a.barang_kode='".$value['kode']."' group by a.barang_kode";
				$ResultPM = $this->db->query($queryPenyesuaianMasuk);
				$ResultArrPM = $ResultPM->result_array();
				
				// get data penyesuaian keluar
				$queryPenyesuaianKeluar = "select sum(a.kwt) as kwt from penyesuaian a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.`status`='1' and a.toko_kode='".$valuetoko['toko_kode']."' and a.barang_kode='".$value['kode']."' group by a.barang_kode";
				$ResultPK = $this->db->query($queryPenyesuaianKeluar);
				$ResultArrPK = $ResultPK->result_array();
				
				$SaldoAwal = 0;
				$BarangMasuk = 0;
				$BarangKeluar = 0;
				if(sizeof($ResultArrsa) > 0){
					$SaldoAwal = $ResultArrsa[0]['saldo_akhir_kwt'];
				}
				foreach ($ResultArrTG as $keytg => $valuetg) {
					$BarangMasuk = $valuetg['kwt'];
				}
				foreach ($ResultArrPB as $keypb => $valuepb) {
					$BarangKeluar = $valuepb['kwt'];
				}
				foreach ($ResultArrRT as $keyrt => $valuert) {
					$BarangKeluar += $valuert['kwt'];
				}
				foreach ($ResultArrPM as $keypm => $valuepm) {
					$BarangMasuk += $valuepm['kwt'];
				}
				foreach ($ResultArrPK as $keypk => $valuepk) {
					$BarangKeluar += $valuepk['kwt'];
				}
				$SaldoAkhir = $SaldoAwal + ($BarangMasuk - $BarangKeluar);
				
				$querygetcurrent = "select * from saldo_barang_toko a where a.bulan=".$data['bulan']." 
				and a.tahun=".$data['tahun']." and a.barang_kode='".$value['kode']."' and a.toko_kode='".$valuetoko['toko_kode']."'";
				$Resultcurr = $this->db->query($querygetcurrent);
				$ResultArrcurr = $Resultcurr->result_array();
				
				if(sizeof($ResultArrcurr) > 0){
					$queryUpdate = "update saldo_barang_toko set saldo_awal_kwt=".$SaldoAwal.", kwt_in=".$BarangMasuk.", kwt_out=".$BarangKeluar.", 
					saldo_akhir_kwt=".$SaldoAkhir." where bulan=".$data['bulan']." and tahun=".$data['tahun']." and barang_kode='".$value['kode']."' 
					and toko_kode='".$valuetoko['toko_kode']."'";
					$this->db->query($queryUpdate);
				}else{
					$queryInsert = "insert into saldo_barang_toko(toko_kode, barang_kode, bulan, tahun, saldo_awal_kwt, kwt_in, kwt_out, saldo_akhir_kwt, 
					waktu_update) values('".$valuetoko['toko_kode']."', '".$value['kode']."', ".$data['bulan'].", ".$data['tahun'].", ".$SaldoAwal.", 
					".$BarangMasuk.", ".$BarangKeluar.", ".$SaldoAkhir.", NOW())";
					
					$this->db->query($queryInsert);
				}
			}
		}
		
		// echo "..... Selesai Sync data saldo barang toko ....."."<br/>";
	}
	
	function SyncSaldoBarangGudangUtama($data){
		$querygetmbarang = "select kode from barang where is_hapus='0'";
		$Resultmbarang = $this->db->query($querygetmbarang);
		$ResultArrmbarang = $Resultmbarang->result_array();
		
		$bulansebelum = $data['bulan'] - 1;
		$tahunsebelum = $data['tahun'];
		if($bulansebelum == 0){
			$bulansebelum = 12;
			$tahunsebelum = $data['tahun'] - 1;
		}
		
		foreach ($ResultArrmbarang as $key => $value) {
			$querygetsaldoawal = "";
			if($data['bulan'] == 10 && $data['tahun'] == 2018){
				$querygetsaldoawal = "select a.saldo_awal_kwt saldo_akhir_kwt from saldo_barang_toko a where a.bulan=".$data['bulan']." 
				and a.tahun=".$data['tahun']." and a.barang_kode='".$value['kode']."' and a.toko_kode='VO0006'";
			}else{
				$querygetsaldoawal = "select a.saldo_akhir_kwt from saldo_barang_toko a where a.bulan=".$bulansebelum." 
				and a.tahun=".$tahunsebelum." and a.barang_kode='".$value['kode']."' and a.toko_kode='VO0006'";
			}
			
			$Resultsa = $this->db->query($querygetsaldoawal);
			$ResultArrsa = $Resultsa->result_array();
			
			// get data BI
			$queryBI = "select sum(a.kwt) as kwt from pengadaan_barang a where a.barang_kode='".$value['kode']."' and a.is_hapus='0' 
			and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." group by a.barang_kode";
			$ResultBI = $this->db->query($queryBI);
			$ResultArrBI = $ResultBI->result_array();
			
			// get retur toko
			$queryRT = "select sum(a.kwt) as kwt from retur_toko a where a.barang_kode='".$value['kode']."' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.is_approve='1' group by a.barang_kode";
			$ResultRT = $this->db->query($queryRT);
			$ResultArrRT = $ResultRT->result_array();
			
			// get data Transfer Toko
			$querygetTG = "select sum(a.kwt) as kwt from transfer_toko a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." 
			and a.is_hapus='0' and a.barang_kode='".$value['kode']."' and a.is_approve='1' group by a.barang_kode";
			$ResultTG = $this->db->query($querygetTG);
			$ResultArrTG = $ResultTG->result_array();
			
			//data TAU keluar
			$querygetTK = "select sum(a.kwt) as kwt from tau_keluar a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.barang_kode='".$value['kode']."' and a.is_hapus='0' group by a.barang_kode";
			$ResultTK = $this->db->query($querygetTK);
			$ResultArrTK = $ResultTK->result_array();
			
			// get data retur supplier
			$queryRS = "select sum(a.kwt) as kwt from retur_supplier a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.barang_kode='".$value['kode']."' group by a.barang_kode";
			$ResultRS = $this->db->query($queryRS);
			$ResultArrRS = $ResultRS->result_array();
			
			// get data penyesuaian masuk
			$queryPenyesuaianMasuk = "select sum(a.kwt) as kwt from penyesuaian a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.`status`='0' and a.toko_kode='VO0006' and a.barang_kode='".$value['kode']."' group by a.barang_kode";
			$ResultPM = $this->db->query($queryPenyesuaianMasuk);
			$ResultArrPM = $ResultPM->result_array();
			
			// get data penyesuaian keluar
			$queryPenyesuaianKeluar = "select sum(a.kwt) as kwt from penyesuaian a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.`status`='1' and a.toko_kode='VO0006' and a.barang_kode='".$value['kode']."' group by a.barang_kode";
			$ResultPK = $this->db->query($queryPenyesuaianKeluar);
			$ResultArrPK = $ResultPK->result_array();
			
			$SaldoAwal = 0;
			$BarangMasuk = 0;
			$BarangKeluar = 0;
			$TAUKeluar = 0;
			$ReturSupplier = 0;
			$ReturToko = 0;
			$PenyesuaianMasuk = 0;
			$PenyesuaianKeluar = 0;
			if(sizeof($ResultArrsa) > 0){
				$SaldoAwal = $ResultArrsa[0]['saldo_akhir_kwt'];
			}
			foreach ($ResultArrBI as $keybi => $valuebi) {
				$BarangMasuk = $valuebi['kwt'];
			}
			foreach ($ResultArrTG as $keytg => $valuetg) {
				$BarangKeluar = $valuetg['kwt'];
			}
			foreach ($ResultArrTK as $keytk => $valuetk) {
				$TAUKeluar = $valuetk['kwt'];
			}
			foreach ($ResultArrRS as $keyrs => $valuers) {
				$ReturSupplier = $valuers['kwt'];
			}
			foreach ($ResultArrRT as $keyrt => $valuert) {
				$ReturToko = $valuert['kwt'];
			}
			foreach ($ResultArrPM as $keypm => $valuepm) {
				$PenyesuaianMasuk = $valuepm['kwt'];
			}
			foreach ($ResultArrPK as $keypk => $valuepk) {
				$PenyesuaianKeluar = $valuepk['kwt'];
			}
			
			$SaldoAkhir = $SaldoAwal + (($BarangMasuk + $ReturToko + $PenyesuaianMasuk) - ($BarangKeluar + $TAUKeluar + $ReturSupplier + $PenyesuaianKeluar));
			$BarangMasuk = $BarangMasuk + $ReturToko + $PenyesuaianMasuk;
			$BarangKeluar = $BarangKeluar + $TAUKeluar + $ReturSupplier + $PenyesuaianKeluar;
			$querygetcurrent = "select * from saldo_barang_toko a where a.bulan=".$data['bulan']." 
			and a.tahun=".$data['tahun']." and a.barang_kode='".$value['kode']."' and a.toko_kode='VO0006'";
			$Resultcurr = $this->db->query($querygetcurrent);
			$ResultArrcurr = $Resultcurr->result_array();
			
			if(sizeof($ResultArrcurr) > 0){
				$queryUpdate = "update saldo_barang_toko set saldo_awal_kwt=".$SaldoAwal.", kwt_in=".$BarangMasuk.", kwt_out=".$BarangKeluar.", 
				saldo_akhir_kwt=".$SaldoAkhir." where bulan=".$data['bulan']." and tahun=".$data['tahun']." and barang_kode='".$value['kode']."' 
				and toko_kode='VO0006'";
				$this->db->query($queryUpdate);
			}else{
				$queryInsert = "insert into saldo_barang_toko(toko_kode, barang_kode, bulan, tahun, saldo_awal_kwt, kwt_in, kwt_out, saldo_akhir_kwt, 
				waktu_update) values('VO0006', '".$value['kode']."', ".$data['bulan'].", ".$data['tahun'].", ".$SaldoAwal.", 
				".$BarangMasuk.", ".$BarangKeluar.", ".$SaldoAkhir.", NOW())";
				
				$this->db->query($queryInsert);
			}
		}
		
		echo "..... Selesai Sync data saldo barang Gudang Utama ....."."<br/>";
	}
	
	public function SyncSaldoBarangSpesifik($data){
		/*$querygetmbarang = "select kode as barang_kode from barang where is_hapus='0'";
		$Resultmbarang = $this->db->query($querygetmbarang);
		$ResultArrmbarang = $Resultmbarang->result_array();
		*/
		$bulansebelum = $data['bulan'] - 1;
		$tahunsebelum = $data['tahun'];
		if($bulansebelum == 0){
			$bulansebelum = 12;
			$tahunsebelum = $data['tahun'] - 1;
		}
		
		// remove saldo barang
		$querydelete = "delete from saldo_barang where bulan=".$data['bulan']." and tahun=".$data['tahun']." and barang_kode='".$data['barang_kode']."'";
		$this->db->query($querydelete);
		
		$querygetsaldoawal = "select saldo_akhir_kwt, saldo_akhir_hsat, (saldo_akhir_kwt * saldo_akhir_hsat) jumlah, 
		kwt_out from saldo_barang where barang_kode='".$data['barang_kode']."' and bulan=".$bulansebelum." 
		and tahun=".$tahunsebelum." order by urut desc limit 1";
		
		$Resultsa = $this->db->query($querygetsaldoawal);
		$ResultArrsa = $Resultsa->result_array();
		
		if(sizeof($ResultArrsa) == 0){
			$ResultArrsa[0]['saldo_akhir_kwt'] = 0;
			$ResultArrsa[0]['saldo_akhir_hsat'] = 0;
			$ResultArrsa[0]['jumlah'] = 0;
			$ResultArrsa[0]['kwt_out'] = 0;
		}else{ // pindah saldo
			$jumlah_saldo_awal = $ResultArrsa[0]['saldo_akhir_kwt'] * $ResultArrsa[0]['saldo_akhir_hsat'];
			
			//echo $ResultArrsa[0]['saldo_akhir_kwt']."<br/>";
			if($ResultArrsa[0]['saldo_akhir_kwt'] != 0){
				$queryInsert = "insert into saldo_barang(ref_bukti, barang_kode, bulan, tahun, tanggal, saldo_awal_kwt, 
				saldo_awal_hsat, jumlah_saldo_awal, kwt_in, hsat_in, jumlah_in, kwt_out, tau_out, hsat_out, jumlah_out, jumlah_tau_out, saldo_akhir_kwt, 
				saldo_akhir_hsat, jumlah_saldo_akhir, tgl_update, urut) 
				values('PI','".$data['barang_kode']."',".$data['bulan'].",".$data['tahun'].",'".$data['tahun']."-".$data['bulan']."-01',
				".$ResultArrsa[0]['saldo_akhir_kwt'].",".$ResultArrsa[0]['saldo_akhir_hsat'].",".$jumlah_saldo_awal.",0,0,0,0,0,0,0,0,
				".$ResultArrsa[0]['saldo_akhir_kwt'].",".$ResultArrsa[0]['saldo_akhir_hsat'].",".$jumlah_saldo_awal.", NOW(), 1)";
				//echo $queryInsert."<br/>";
				$this->db->query($queryInsert);
			}
		}
		
		$queryDataBarang = "select a.bukti, SUBSTR(a.bukti,1,2) as mode, a.barang_kode, a.tanggal, a.waktu_insert, a.harga, a.ppn, a.kwt from pengadaan_barang a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' 
		union 
		select a.fcode, SUBSTR(a.fcode,1,2) as mode, b.fitemkey as barang_kode, a.fdate as tanggal, a.fcreateddt as waktu_insert, round((b.fprice/1.11),2) as harga, round(((b.fprice/1.11)*0.11),2) as ppn, b.fqty as kwt from rst_fc_trans_header a left join rst_fc_trans_detail b on a.fcode=b.fcode and a.flokasi=b.flokasi where a.fstatuskey='1' and month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']." and b.fitemkey='".$data['barang_kode']."' and a.fname_payment<>'TAU' 
		union 
		select a.bukti, SUBSTR(a.bukti,1,2) as mode, a.barang_kode, a.tanggal, a.waktu_insert, a.harga, 0 as ppn, a.kwt from tau_keluar a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.barang_kode='".$data['barang_kode']."' and a.is_hapus='0' 
		union 
		select a.bukti, SUBSTR(a.bukti,1,2) as mode, a.barang_kode, a.tanggal, a.waktu_insert, 0 as harga, 0 as ppn, a.kwt from retur_supplier a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.barang_kode='".$data['barang_kode']."' and a.is_hapus='0' order by date(tanggal), mode";
		
		$Resultdb = $this->db->query($queryDataBarang);
		$ResultArrdb = $Resultdb->result_array();
		$urut = 2;
		$this->db->query('start transaction');
		foreach ($ResultArrdb as $keydb => $valuedb) {
			$tglArr = explode("-", $valuedb['tanggal']);
			$kwt_in = 0;
			$hsat_in = 0;
			$kwt_out = 0;
			$tau_out = 0;
			$saldo_akhir_kwt = 0;
			$saldo_akhir_hsat = 0;
			
			if($valuedb['mode'] == "BI"){
				$kwt_in = $valuedb['kwt'];
				$hsat_in = $valuedb['harga'];
				
				$saldo_akhir_kwt = $ResultArrsa[0]['saldo_akhir_kwt'] + $kwt_in;
				if($saldo_akhir_kwt == 0){
					$saldo_akhir_hsat = $ResultArrsa[0]['saldo_akhir_hsat'];
				}else{
					$saldo_akhir_hsat = (($ResultArrsa[0]['saldo_akhir_kwt'] * $ResultArrsa[0]['saldo_akhir_hsat']) + ($kwt_in * $hsat_in)) / ($ResultArrsa[0]['saldo_akhir_kwt'] + $kwt_in);
				}
			}else if($valuedb['mode'] == "BO"){
				$kwt_out = $valuedb['kwt'];
				
				$saldo_akhir_kwt = $ResultArrsa[0]['saldo_akhir_kwt'] - $kwt_out;
				$saldo_akhir_hsat = $ResultArrsa[0]['saldo_akhir_hsat'];
			}else if($valuedb['mode'] == "TB"){
				$tau_out = $valuedb['kwt'];
				
				$saldo_akhir_kwt = $ResultArrsa[0]['saldo_akhir_kwt'] - $tau_out;
				$saldo_akhir_hsat = $ResultArrsa[0]['saldo_akhir_hsat'];
			}
			$jumlah_saldo_awal = $ResultArrsa[0]['saldo_akhir_kwt'] * $ResultArrsa[0]['saldo_akhir_hsat'];
			$jumlah_in = $kwt_in * $hsat_in;
			$jumlah_out = $kwt_out * $ResultArrsa[0]['saldo_akhir_hsat'];
			$jumlah_tau_out = $tau_out * $ResultArrsa[0]['saldo_akhir_hsat'];
			$jumlah_saldo_akhir = $saldo_akhir_kwt * $saldo_akhir_hsat;
			
			$queryInsert = "insert into saldo_barang(ref_bukti, barang_kode, bulan, tahun, tanggal, saldo_awal_kwt, 
			saldo_awal_hsat, jumlah_saldo_awal, kwt_in, hsat_in, jumlah_in, kwt_out, tau_out, hsat_out, jumlah_out, jumlah_tau_out, saldo_akhir_kwt, saldo_akhir_hsat, 
			jumlah_saldo_akhir, tgl_update, urut) 
			values('".$valuedb['bukti']."','".$valuedb['barang_kode']."',".$tglArr[1].",".$tglArr[0].",'".$valuedb['tanggal']."',
			".$ResultArrsa[0]['saldo_akhir_kwt'].",".$ResultArrsa[0]['saldo_akhir_hsat'].",".$jumlah_saldo_awal.",".$kwt_in.",".$hsat_in.",
			".$jumlah_in.",".$kwt_out.",".$tau_out.",".$ResultArrsa[0]['saldo_akhir_hsat'].",".$jumlah_out.",".$jumlah_tau_out.",
			".$saldo_akhir_kwt.",".$saldo_akhir_hsat.",".$jumlah_saldo_akhir.", NOW(), ".$urut.")";
			
			$this->db->query($queryInsert);
			
			$ResultArrsa[0]['saldo_akhir_kwt'] = $saldo_akhir_kwt;
			$ResultArrsa[0]['saldo_akhir_hsat'] = $saldo_akhir_hsat;
			$urut++;
		}
		$this->db->query('commit');
		$this->updateInfoHPP($data['barang_kode'], $ResultArrsa[0]['saldo_akhir_hsat']);
		echo "..... Selesai Sync data saldo barang ....."."<br/>";
	}
	
	function updateInfoHPP($barang_kode, $hpp){
		$query = "update barang set hpp=".$hpp.", waktu_hpp=NOW() where kode='".$barang_kode."'";
		
		$this->db->query($query);
	}
	
	function SyncSaldoBarangGudangSpesifik($data){
		$bulansebelum = $data['bulan'] - 1;
		$tahunsebelum = $data['tahun'];
		if($bulansebelum == 0){
			$bulansebelum = 12;
			$tahunsebelum = $data['tahun'] - 1;
		}
		
		$querygetsaldoawal = "";
		if($data['bulan'] == 10 && $data['tahun'] == 2018){
			$querygetsaldoawal = "select a.saldo_awal_kwt saldo_akhir_kwt from saldo_barang_toko a where a.bulan=".$data['bulan']." 
			and a.tahun=".$data['tahun']." and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='".$data['toko_kode']."'";
		}else{
			$querygetsaldoawal = "select a.saldo_akhir_kwt from saldo_barang_toko a where a.bulan=".$bulansebelum." 
			and a.tahun=".$tahunsebelum." and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='".$data['toko_kode']."'";
		}
		
		$Resultsa = $this->db->query($querygetsaldoawal);
		$ResultArrsa = $Resultsa->result_array();
		
		// get data Transfer Toko
		$querygetTG = "select sum(a.kwt) as kwt from transfer_toko a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." 
		and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='".$data['toko_kode']."' and a.is_approve='1' group by a.barang_kode";
		$ResultTG = $this->db->query($querygetTG);
		$ResultArrTG = $ResultTG->result_array();
		
		// get data penjualan
		$querygetPB = "select b.fitemkey, sum(b.fqty) as kwt from rst_fc_trans_header a left join rst_fc_trans_detail b on a.fcode=b.fcode and a.flokasi=b.flokasi where a.fstatuskey='1' and month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']." and b.fitemkey='".$data['barang_kode']."' and a.flokasi='".$data['toko_kode']."' group by b.fitemkey";
		$ResultPB = $this->db->query($querygetPB);
		$ResultArrPB = $ResultPB->result_array();
		
		// get data retur toko
		$querygetReturToko = "select sum(a.kwt) as kwt from retur_toko a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.is_approve='1' and a.toko_kode='".$data['toko_kode']."' and a.barang_kode='".$data['barang_kode']."' group by a.barang_kode";
		$ResultRT = $this->db->query($querygetReturToko);
		$ResultArrRT = $ResultRT->result_array();
		
		// get data penyesuaian masuk
		$queryPenyesuaianMasuk = "select sum(a.kwt) as kwt from penyesuaian a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.`status`='0' and a.toko_kode='".$data['toko_kode']."' and a.barang_kode='".$data['barang_kode']."' group by a.barang_kode";
		$ResultPM = $this->db->query($queryPenyesuaianMasuk);
		$ResultArrPM = $ResultPM->result_array();
		
		// get data penyesuaian keluar
		$queryPenyesuaianKeluar = "select sum(a.kwt) as kwt from penyesuaian a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.`status`='1' and a.toko_kode='".$data['toko_kode']."' and a.barang_kode='".$data['barang_kode']."' group by a.barang_kode";
		$ResultPK = $this->db->query($queryPenyesuaianKeluar);
		$ResultArrPK = $ResultPK->result_array();
		
		$SaldoAwal = 0;
		$BarangMasuk = 0;
		$BarangKeluar = 0;
		$ReturToko = 0;
		if(sizeof($ResultArrsa) > 0){
			$SaldoAwal = $ResultArrsa[0]['saldo_akhir_kwt'];
		}
		foreach ($ResultArrTG as $keytg => $valuetg) {
			$BarangMasuk = $valuetg['kwt'];
		}
		foreach ($ResultArrPB as $keypb => $valuepb) {
			$BarangKeluar = $valuepb['kwt'];
		}
		foreach ($ResultArrRT as $keyrt => $valuert) {
			$BarangKeluar += $valuert['kwt'];
			$ReturToko = $valuert['kwt'];
		}
		foreach ($ResultArrPM as $keypm => $valuepm) {
			$BarangMasuk += $valuepm['kwt'];
		}
		foreach ($ResultArrPK as $keypk => $valuepk) {
			$BarangKeluar += $valuepk['kwt'];
		}
		$SaldoAkhir = $SaldoAwal + ($BarangMasuk - $BarangKeluar);
		
		$querygetcurrent = "select * from saldo_barang_toko a where a.bulan=".$data['bulan']." 
		and a.tahun=".$data['tahun']." and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='".$data['toko_kode']."'";
		$Resultcurr = $this->db->query($querygetcurrent);
		$ResultArrcurr = $Resultcurr->result_array();
		
		if(sizeof($ResultArrcurr) > 0){
			$queryUpdate = "update saldo_barang_toko set saldo_awal_kwt=".$SaldoAwal.", kwt_in=".$BarangMasuk.", kwt_out=".$BarangKeluar.", retur=".$ReturToko.", 
			saldo_akhir_kwt=".$SaldoAkhir." where bulan=".$data['bulan']." and tahun=".$data['tahun']." and barang_kode='".$data['barang_kode']."' 
			and toko_kode='".$data['toko_kode']."'";
			$this->db->query($queryUpdate);
		}else{
			$queryInsert = "insert into saldo_barang_toko(toko_kode, barang_kode, bulan, tahun, saldo_awal_kwt, kwt_in, kwt_out, retur, saldo_akhir_kwt, 
			waktu_update) values('".$data['toko_kode']."', '".$data['barang_kode']."', ".$data['bulan'].", ".$data['tahun'].", ".$SaldoAwal.", 
			".$BarangMasuk.", ".$BarangKeluar.", ".$ReturToko.", ".$SaldoAkhir.", NOW())";
			
			$this->db->query($queryInsert);
		}
		
		if(isset($data['mode'])){
			echo "..... Selesai Sync data saldo barang toko .....";
		}
	}

	function SyncSaldoBarangTokoKonsinyasiSpesifik($data){
		$bulansebelum = $data['bulan'] - 1;
		$tahunsebelum = $data['tahun'];
		if($bulansebelum == 0){
			$bulansebelum = 12;
			$tahunsebelum = $data['tahun'] - 1;
		}
		
		$querygetsaldoawal = "";
		if($data['bulan'] == 10 && $data['tahun'] == 2018){
			$querygetsaldoawal = "select a.saldo_awal_kwt saldo_akhir_kwt from saldo_barang_konsinyasi a where a.bulan=".$data['bulan']." 
			and a.tahun=".$data['tahun']." and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='".$data['toko_kode']."'";
		}else{
			$querygetsaldoawal = "select a.saldo_akhir_kwt from saldo_barang_konsinyasi a where a.bulan=".$bulansebelum." 
			and a.tahun=".$tahunsebelum." and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='".$data['toko_kode']."'";
		}
		
		$Resultsa = $this->db->query($querygetsaldoawal);
		$ResultArrsa = $Resultsa->result_array();
		
		// get data Transfer Toko
		$querygetTG = "select sum(a.kwt) as kwt from transfer_toko_konsinyasi a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." 
		and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='".$data['toko_kode']."' and a.is_approve='1' group by a.barang_kode";
		$ResultTG = $this->db->query($querygetTG);
		$ResultArrTG = $ResultTG->result_array();
		
		// get data penjualan
		$querygetPB = "select b.fitemkey, sum(b.fqty) as kwt from rst_fc_trans_header a left join rst_fc_trans_detail b on a.fcode=b.fcode and a.flokasi=b.flokasi where a.fstatuskey='1' and month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']." and b.fitemkey='".$data['barang_kode']."' and a.flokasi='".$data['toko_kode']."' group by b.fitemkey";
		$ResultPB = $this->db->query($querygetPB);
		$ResultArrPB = $ResultPB->result_array();
		
		// get data retur toko
		$querygetReturToko = "select sum(a.kwt) as kwt from retur_toko_konsinyasi a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.is_approve='1' and a.toko_kode='".$data['toko_kode']."' and a.barang_kode='".$data['barang_kode']."' group by a.barang_kode";
		$ResultRT = $this->db->query($querygetReturToko);
		$ResultArrRT = $ResultRT->result_array();

		// get data biaya keluar
		$querygetBiayaKonsinyasi = "select sum(a.kwt) as kwt from tau_keluar_konsinyasi a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.toko_kode='".$data['toko_kode']."' and a.barang_kode='".$data['barang_kode']."' group by a.barang_kode";
		$ResultYN = $this->db->query($querygetBiayaKonsinyasi);
		$ResultArrYN = $ResultYN->result_array();
		
		// get data penyesuaian masuk
		$queryPenyesuaianMasuk = "select sum(a.kwt) as kwt from penyesuaian a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.`status`='0' and a.toko_kode='".$data['toko_kode']."' and a.barang_kode='".$data['barang_kode']."' group by a.barang_kode";
		$ResultPM = $this->db->query($queryPenyesuaianMasuk);
		$ResultArrPM = $ResultPM->result_array();
		
		// get data penyesuaian keluar
		$queryPenyesuaianKeluar = "select sum(a.kwt) as kwt from penyesuaian a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.`status`='1' and a.toko_kode='".$data['toko_kode']."' and a.barang_kode='".$data['barang_kode']."' group by a.barang_kode";
		$ResultPK = $this->db->query($queryPenyesuaianKeluar);
		$ResultArrPK = $ResultPK->result_array();
		
		$SaldoAwal = 0;
		$BarangMasuk = 0;
		$BarangKeluar = 0;
		$ReturToko = 0;
		$TAUKeluar = 0;
		if(sizeof($ResultArrsa) > 0){
			$SaldoAwal = $ResultArrsa[0]['saldo_akhir_kwt'];
		}
		foreach ($ResultArrTG as $keytg => $valuetg) {
			$BarangMasuk = $valuetg['kwt'];
		}
		foreach ($ResultArrPB as $keypb => $valuepb) {
			$BarangKeluar = $valuepb['kwt'];
		}
		foreach ($ResultArrRT as $keyrt => $valuert) {
			$BarangKeluar += $valuert['kwt'];
			$ReturToko = $valuert['kwt'];
		}
		foreach ($ResultArrYN as $keyyn => $valueyn) {
			$BarangKeluar += $valueyn['kwt'];
			$TAUKeluar = $valueyn['kwt'];
		}
		foreach ($ResultArrPM as $keypm => $valuepm) {
			$BarangMasuk += $valuepm['kwt'];
		}
		foreach ($ResultArrPK as $keypk => $valuepk) {
			$BarangKeluar += $valuepk['kwt'];
		}

		$SaldoAkhir = $SaldoAwal + ($BarangMasuk - $BarangKeluar);
		
		$querygetcurrent = "select * from saldo_barang_konsinyasi a where a.bulan=".$data['bulan']." 
		and a.tahun=".$data['tahun']." and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='".$data['toko_kode']."'";
		$Resultcurr = $this->db->query($querygetcurrent);
		$ResultArrcurr = $Resultcurr->result_array();
		
		if(sizeof($ResultArrcurr) > 0){
			$queryUpdate = "update saldo_barang_konsinyasi set saldo_awal_kwt=".$SaldoAwal.", kwt_in=".$BarangMasuk.", kwt_out=".$BarangKeluar.", retur=".$ReturToko.", biaya=".$TAUKeluar.", 
			saldo_akhir_kwt=".$SaldoAkhir." where bulan=".$data['bulan']." and tahun=".$data['tahun']." and barang_kode='".$data['barang_kode']."' 
			and toko_kode='".$data['toko_kode']."'";
			$this->db->query($queryUpdate);
		}else{
			$queryInsert = "insert into saldo_barang_konsinyasi(toko_kode, barang_kode, bulan, tahun, saldo_awal_kwt, kwt_in, kwt_out, retur, biaya, saldo_akhir_kwt, 
			waktu_update) values('".$data['toko_kode']."', '".$data['barang_kode']."', ".$data['bulan'].", ".$data['tahun'].", ".$SaldoAwal.", 
			".$BarangMasuk.", ".$BarangKeluar.", ".$ReturToko.", ".$TAUKeluar.", ".$SaldoAkhir.", NOW())";
			
			$this->db->query($queryInsert);
		}
		
		if(isset($data['mode'])){
			echo "..... Selesai Sync data saldo barang toko konsinyasi .....";
		}
	}
	
	function SyncSaldoBarangGudangUtamaSpesifik($data){
		$bulansebelum = $data['bulan'] - 1;
		$tahunsebelum = $data['tahun'];
		if($bulansebelum == 0){
			$bulansebelum = 12;
			$tahunsebelum = $data['tahun'] - 1;
		}
		
		$querygetsaldoawal = "";
		if($data['bulan'] == 10 && $data['tahun'] == 2018){
			$querygetsaldoawal = "select a.saldo_awal_kwt saldo_akhir_kwt from saldo_barang_toko a where a.bulan=".$data['bulan']." 
			and a.tahun=".$data['tahun']." and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='VO0006'";
		}else{
			$querygetsaldoawal = "select a.saldo_akhir_kwt from saldo_barang_toko a where a.bulan=".$bulansebelum." 
			and a.tahun=".$tahunsebelum." and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='VO0006'";
		}
		
		$Resultsa = $this->db->query($querygetsaldoawal);
		$ResultArrsa = $Resultsa->result_array();
		
		// get data BI
		$queryBI = "select sum(a.kwt) as kwt from pengadaan_barang a where a.barang_kode='".$data['barang_kode']."' and a.is_hapus='0' 
		and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." group by a.barang_kode";
		$ResultBI = $this->db->query($queryBI);
		$ResultArrBI = $ResultBI->result_array();
		
		// get retur toko
		$queryRT = "select sum(a.kwt) as kwt from retur_toko a where a.barang_kode='".$data['barang_kode']."' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.is_approve='1' group by a.barang_kode";
		$ResultRT = $this->db->query($queryRT);
		$ResultArrRT = $ResultRT->result_array();
		
		// get data Transfer Toko
		$querygetTG = "select sum(a.kwt) as kwt from transfer_toko a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." 
		and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' and a.is_approve='1' group by a.barang_kode";
		$ResultTG = $this->db->query($querygetTG);
		$ResultArrTG = $ResultTG->result_array();
		
		//data TAU keluar
		$querygetTK = "select sum(a.kwt) as kwt from tau_keluar a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.barang_kode='".$data['barang_kode']."' and a.is_hapus='0' group by a.barang_kode";
		$ResultTK = $this->db->query($querygetTK);
		$ResultArrTK = $ResultTK->result_array();
		
		// get data retur supplier
		$queryRS = "select sum(a.kwt) as kwt from retur_supplier a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' group by a.barang_kode";
		$ResultRS = $this->db->query($queryRS);
		$ResultArrRS = $ResultRS->result_array();
		
		// get data penyesuaian masuk
		$queryPenyesuaianMasuk = "select sum(a.kwt) as kwt from penyesuaian a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.`status`='0' and a.toko_kode='VO0006' and a.barang_kode='".$data['barang_kode']."' group by a.barang_kode";
		$ResultPM = $this->db->query($queryPenyesuaianMasuk);
		$ResultArrPM = $ResultPM->result_array();
		
		// get data penyesuaian keluar
		$queryPenyesuaianKeluar = "select sum(a.kwt) as kwt from penyesuaian a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.`status`='1' and a.toko_kode='VO0006' and a.barang_kode='".$data['barang_kode']."' group by a.barang_kode";
		$ResultPK = $this->db->query($queryPenyesuaianKeluar);
		$ResultArrPK = $ResultPK->result_array();

		// get data pindah ke bad stock
		$queryPindahBadStock = "select sum(a.kwt) as kwt from bad_stock a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' group by a.barang_kode";
		$ResultBS = $this->db->query($queryPindahBadStock);
		$ResultArrBS = $ResultBS->result_array();

		// get data transfer dari bad stock
		$queryTransferDariBadStock = "select sum(a.kwt) as kwt from bo_bad_stock a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' and a.is_penyesuaian='0' group by a.barang_kode";
		$ResultReturBS = $this->db->query($queryTransferDariBadStock);
		$ResultArrReturBS = $ResultReturBS->result_array();
		
		$SaldoAwal = 0;
		$BarangMasuk = 0;
		$BarangKeluar = 0;
		$TAUKeluar = 0;
		$ReturSupplier = 0;
		$ReturToko = 0;
		$PenyesuaianMasuk = 0;
		$PenyesuaianKeluar = 0;
		$BadStock = 0;
		$ReturBadStock = 0;
		if(sizeof($ResultArrsa) > 0){
			$SaldoAwal = $ResultArrsa[0]['saldo_akhir_kwt'];
		}
		foreach ($ResultArrBI as $keybi => $valuebi) {
			$BarangMasuk = $valuebi['kwt'];
		}
		foreach ($ResultArrTG as $keytg => $valuetg) {
			$BarangKeluar = $valuetg['kwt'];
		}
		foreach ($ResultArrTK as $keytk => $valuetk) {
			$TAUKeluar = $valuetk['kwt'];
		}
		foreach ($ResultArrRS as $keyrs => $valuers) {
			$ReturSupplier = $valuers['kwt'];
		}
		foreach ($ResultArrRT as $keyrt => $valuert) {
			$ReturToko = $valuert['kwt'];
		}
		foreach ($ResultArrPM as $keypm => $valuepm) {
			$PenyesuaianMasuk = $valuepm['kwt'];
		}
		foreach ($ResultArrPK as $keypk => $valuepk) {
			$PenyesuaianKeluar = $valuepk['kwt'];
		}
		foreach ($ResultArrBS as $keybs => $valuebs) {
			$BadStock = $valuebs['kwt'];
		}
		foreach ($ResultArrReturBS as $keyrbs => $valuerbs) {
			$ReturBadStock = $valuerbs['kwt'];
		}
		
		$SaldoAkhir = 0;
		$SaldoAkhir = $SaldoAwal + (($BarangMasuk + $ReturToko + $PenyesuaianMasuk) - ($BarangKeluar + $TAUKeluar + $PenyesuaianKeluar + $ReturSupplier));
		$BarangMasuk = $BarangMasuk + $ReturToko + $PenyesuaianMasuk;
		$BarangKeluar = $BarangKeluar + $TAUKeluar + $PenyesuaianKeluar + $ReturSupplier;
		
		$querygetcurrent = "select * from saldo_barang_toko a where a.bulan=".$data['bulan']." 
		and a.tahun=".$data['tahun']." and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='VO0006'";
		$Resultcurr = $this->db->query($querygetcurrent);
		$ResultArrcurr = $Resultcurr->result_array();
		
		if(sizeof($ResultArrcurr) > 0){
			$queryUpdate = "update saldo_barang_toko set saldo_awal_kwt=".$SaldoAwal.", kwt_in=".$BarangMasuk.", kwt_out=".$BarangKeluar.", retur=".$ReturSupplier.", 
			saldo_akhir_kwt=".$SaldoAkhir." where bulan=".$data['bulan']." and tahun=".$data['tahun']." and barang_kode='".$data['barang_kode']."' 
			and toko_kode='VO0006'";
			$this->db->query($queryUpdate);
		}else{
			$queryInsert = "insert into saldo_barang_toko(toko_kode, barang_kode, bulan, tahun, saldo_awal_kwt, kwt_in, kwt_out, retur, saldo_akhir_kwt, 
			waktu_update) values('VO0006', '".$data['barang_kode']."', ".$data['bulan'].", ".$data['tahun'].", ".$SaldoAwal.", 
			".$BarangMasuk.", ".$BarangKeluar.", ".$ReturSupplier.", ".$SaldoAkhir.", NOW())";
			
			$this->db->query($queryInsert);
		}
		
		if(isset($data['mode'])){
			echo "..... Selesai Sync data saldo barang gudang utama .....";
		}
	}

	function SyncSaldoBarangGudangKonsinyasiSpesifik($data){
		$bulansebelum = $data['bulan'] - 1;
		$tahunsebelum = $data['tahun'];
		if($bulansebelum == 0){
			$bulansebelum = 12;
			$tahunsebelum = $data['tahun'] - 1;
		}
		
		$querygetsaldoawal = "";
		if($data['bulan'] == 10 && $data['tahun'] == 2018){
			$querygetsaldoawal = "select a.saldo_awal_kwt saldo_akhir_kwt from saldo_barang_konsinyasi a where a.bulan=".$data['bulan']." 
			and a.tahun=".$data['tahun']." and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='VO0006'";
		}else{
			$querygetsaldoawal = "select a.saldo_akhir_kwt from saldo_barang_konsinyasi a where a.bulan=".$bulansebelum." 
			and a.tahun=".$tahunsebelum." and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='VO0006'";
		}
		
		$Resultsa = $this->db->query($querygetsaldoawal);
		$ResultArrsa = $Resultsa->result_array();
		
		// get data BI
		$queryBI = "select sum(a.kwt) as kwt from pengadaan_barang_konsinyasi a where a.barang_kode='".$data['barang_kode']."' and a.is_hapus='0' 
		and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." group by a.barang_kode";
		$ResultBI = $this->db->query($queryBI);
		$ResultArrBI = $ResultBI->result_array();
		
		// get retur toko
		$queryRT = "select sum(a.kwt) as kwt from retur_toko_konsinyasi a where a.barang_kode='".$data['barang_kode']."' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.is_approve='1' group by a.barang_kode";
		$ResultRT = $this->db->query($queryRT);
		$ResultArrRT = $ResultRT->result_array();
		
		// get data Transfer Toko
		$querygetTG = "select sum(a.kwt) as kwt from transfer_toko_konsinyasi a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." 
		and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' and a.is_approve='1' group by a.barang_kode";
		$ResultTG = $this->db->query($querygetTG);
		$ResultArrTG = $ResultTG->result_array();
		
		// get data retur supplier
		$queryRS = "select sum(a.kwt) as kwt from retur_supplier_konsinyasi a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' group by a.barang_kode";
		$ResultRS = $this->db->query($queryRS);
		$ResultArrRS = $ResultRS->result_array();

		// get data penyesuaian masuk
		$queryPenyesuaianMasuk = "select sum(a.kwt) as kwt from penyesuaian a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.`status`='0' and a.toko_kode='VO0006' and a.barang_kode='".$data['barang_kode']."' group by a.barang_kode";
		$ResultPM = $this->db->query($queryPenyesuaianMasuk);
		$ResultArrPM = $ResultPM->result_array();
		
		// get data penyesuaian keluar
		$queryPenyesuaianKeluar = "select sum(a.kwt) as kwt from penyesuaian a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.`status`='1' and a.toko_kode='VO0006' and a.barang_kode='".$data['barang_kode']."' group by a.barang_kode";
		$ResultPK = $this->db->query($queryPenyesuaianKeluar);
		$ResultArrPK = $ResultPK->result_array();
		
		$SaldoAwal = 0;
		$BarangMasuk = 0;
		$BarangKeluar = 0;
		$ReturSupplier = 0;
		$ReturToko = 0;
		if(sizeof($ResultArrsa) > 0){
			$SaldoAwal = $ResultArrsa[0]['saldo_akhir_kwt'];
		}
		foreach ($ResultArrBI as $keybi => $valuebi) {
			$BarangMasuk = $valuebi['kwt'];
		}
		foreach ($ResultArrTG as $keytg => $valuetg) {
			$BarangKeluar = $valuetg['kwt'];
		}
		foreach ($ResultArrRS as $keyrs => $valuers) {
			$ReturSupplier = $valuers['kwt'];
		}
		foreach ($ResultArrRT as $keyrt => $valuert) {
			$ReturToko = $valuert['kwt'];
		}
		foreach ($ResultArrPM as $keypm => $valuepm) {
			$BarangMasuk += $valuepm['kwt'];
		}
		foreach ($ResultArrPK as $keypk => $valuepk) {
			$BarangKeluar += $valuepk['kwt'];
		}
		
		$SaldoAkhir = 0;
		$SaldoAkhir = $SaldoAwal + (($BarangMasuk + $ReturToko) - ($BarangKeluar + $ReturSupplier));
		$BarangMasuk = $BarangMasuk + $ReturToko;
		$BarangKeluar = $BarangKeluar + $ReturSupplier;

		$querygetcurrent = "select * from saldo_barang_konsinyasi a where a.bulan=".$data['bulan']." 
		and a.tahun=".$data['tahun']." and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='VO0006'";
		$Resultcurr = $this->db->query($querygetcurrent);
		$ResultArrcurr = $Resultcurr->result_array();
		
		if(sizeof($ResultArrcurr) > 0){
			$queryUpdate = "update saldo_barang_konsinyasi set saldo_awal_kwt=".$SaldoAwal.", kwt_in=".$BarangMasuk.", kwt_out=".$BarangKeluar.", retur=".$ReturSupplier.", 
			saldo_akhir_kwt=".$SaldoAkhir." where bulan=".$data['bulan']." and tahun=".$data['tahun']." and barang_kode='".$data['barang_kode']."' 
			and toko_kode='VO0006'";
			$this->db->query($queryUpdate);
		}else{
			$queryInsert = "insert into saldo_barang_konsinyasi(toko_kode, barang_kode, bulan, tahun, saldo_awal_kwt, kwt_in, kwt_out, retur, saldo_akhir_kwt, 
			waktu_update) values('VO0006', '".$data['barang_kode']."', ".$data['bulan'].", ".$data['tahun'].", ".$SaldoAwal.", 
			".$BarangMasuk.", ".$BarangKeluar.", ".$ReturSupplier.", ".$SaldoAkhir.", NOW())";
			
			$this->db->query($queryInsert);
		}
		
		//echo "..... Selesai Sync data saldo barang konsinyasi gudang utama ....."."<br/>";
	}

	function SyncSaldoBarangBadStockSpesifik($data){
		$bulansebelum = $data['bulan'] - 1;
		$tahunsebelum = $data['tahun'];
		if($bulansebelum == 0){
			$bulansebelum = 12;
			$tahunsebelum = $data['tahun'] - 1;
		}
		
		$querygetsaldoawal = "";
		if($data['bulan'] == 10 && $data['tahun'] == 2018){
			$querygetsaldoawal = "select a.saldo_awal_kwt saldo_akhir_kwt from saldo_barang_toko a where a.bulan=".$data['bulan']." 
			and a.tahun=".$data['tahun']." and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='".$data['gudang_bs']."'";
		}else{
			$querygetsaldoawal = "select a.saldo_akhir_kwt from saldo_barang_toko a where a.bulan=".$bulansebelum." 
			and a.tahun=".$tahunsebelum." and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='".$data['gudang_bs']."'";
		}
		
		$Resultsa = $this->db->query($querygetsaldoawal);
		$ResultArrsa = $Resultsa->result_array();

		// get data bi bad stock
		$queryPindahBadStock = "select sum(a.kwt) as kwt from bad_stock a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' and toko_kode='".$data['gudang_bs']."' group by a.barang_kode";
		$ResultBS = $this->db->query($queryPindahBadStock);
		$ResultArrBS = $ResultBS->result_array();

		// get data retur supplier
		$queryRS = "select sum(a.kwt) as kwt from retur_supplier a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' group by a.barang_kode";
		$ResultRS = $this->db->query($queryRS);
		$ResultArrRS = $ResultRS->result_array();

		// get data retur ke gs
		$queryBORGS = "select sum(a.kwt) as kwt from bo_bad_stock a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='".$data['gudang_bs']."' and a.is_penyesuaian='0' group by a.barang_kode";
		$ResultBORGS = $this->db->query($queryBORGS);
		$ResultArrBORGS = $ResultBORGS->result_array();

		// get data bo penyesuaian bs
		$queryBOPGS = "select sum(a.kwt) as kwt from bo_bad_stock a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='".$data['gudang_bs']."' and a.is_penyesuaian='1' group by a.barang_kode";
		$ResultBOPGS = $this->db->query($queryBOPGS);
		$ResultArrBOPGS = $ResultBOPGS->result_array();
		
		$SaldoAwal = 0;
		$BadStock = 0;
		$ReturSupplier = 0;
		$BOReturGS = 0;
		$BOPenyesuaianGS = 0;

		if(sizeof($ResultArrsa) > 0){
			$SaldoAwal = $ResultArrsa[0]['saldo_akhir_kwt'];
		}

		foreach ($ResultArrBS as $keybs => $valuebs) {
			$BadStock = $valuebs['kwt'];
		}

		$SaldoAkhir = 0;
		$BarangMasuk = $BadStock;
		$BarangKeluar = 0;
		if($data['gudang_bs'] == 'VO0009'){ // bo untuk bs retur
			foreach ($ResultArrRS as $keyrs => $valuers) {
				$ReturSupplier = $valuers['kwt'];
			}
			foreach ($ResultArrBORGS as $keyrgs => $valuergs) {
				$BOReturGS = $valuergs['kwt'];
			}

			$SaldoAkhir = $SaldoAwal + $BadStock - ($ReturSupplier+$BOReturGS);
			$BarangKeluar = ($ReturSupplier+$BOReturGS);
		}else if($data['gudang_bs'] == 'VO0010'){ // bo untuk bs non retur
			foreach ($ResultArrBORGS as $keyrgs => $valuergs) {
				$BOReturGS = $valuergs['kwt'];
			}
			foreach ($ResultArrBOPGS as $keypgs => $valuepgs) {
				$BOPenyesuaianGS = $valuepgs['kwt'];
			}

			$SaldoAkhir = $SaldoAwal + $BadStock - ($BOReturGS + $BOPenyesuaianGS);
			$BarangKeluar = ($BOReturGS + $BOPenyesuaianGS);
		}
		
		$querygetcurrent = "select * from saldo_barang_toko a where a.bulan=".$data['bulan']." 
		and a.tahun=".$data['tahun']." and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='".$data['gudang_bs']."'";
		$Resultcurr = $this->db->query($querygetcurrent);
		$ResultArrcurr = $Resultcurr->result_array();
		
		if(sizeof($ResultArrcurr) > 0){
			$queryUpdate = "update saldo_barang_toko set saldo_awal_kwt=".$SaldoAwal.", kwt_in=".$BarangMasuk.", kwt_out=".$BarangKeluar.", 
			saldo_akhir_kwt=".$SaldoAkhir." where bulan=".$data['bulan']." and tahun=".$data['tahun']." and barang_kode='".$data['barang_kode']."' 
			and toko_kode='".$data['gudang_bs']."'";
			$this->db->query($queryUpdate);
		}else{
			$queryInsert = "insert into saldo_barang_toko(toko_kode, barang_kode, bulan, tahun, saldo_awal_kwt, kwt_in, kwt_out, saldo_akhir_kwt, 
			waktu_update) values('".$data['gudang_bs']."', '".$data['barang_kode']."', ".$data['bulan'].", ".$data['tahun'].", ".$SaldoAwal.", 
			".$BarangMasuk.", ".$BarangKeluar.", ".$SaldoAkhir.", NOW())";
			
			$this->db->query($queryInsert);
		}
		
		//echo "..... Selesai Sync data saldo barang toko utama ....."."<br/>";
	}

	function GantiBarcode($data){
		$queryInsert = "INSERT INTO kwsg_vmart.barang (kode, barcode, kategori, nama_barang, satuan, is_ppn, bkl, print, hpp, waktu_hpp, waktu_insert, waktu_update, is_hapus, user_id, is_aktif) select '".$data['kode_baru']."' as kode, '".$data['kode_baru']."' as barcode, a.kategori, a.nama_barang, a.satuan, a.is_ppn, a.bkl, a.print, a.hpp, a.waktu_hpp, a.waktu_insert, NOW() as waktu_update, '0' as is_hapus, '".$this->session->userdata('username')."' as user_id, '1' as is_aktif from kwsg_vmart.barang a where a.kode='".$data['kode_lama']."'";

		$queryIns1 = "update barang_supplier a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns2 = "update barang_toko a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns3 = "update harga_barang_supplier a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns4 = "update harga_barang_toko a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns5 = "update hist_harga_barang a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns6 = "update op a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns7 = "update order_transfer a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns8 = "update pengadaan_barang a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns9 = "update pengadaan_barang_bkl a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns10 = "update penyesuaian a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns11 = "update planogram a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns12 = "update promo a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns13 = "update retur_supplier a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns14 = "update retur_toko a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns15 = "update rst_fc_trans_detail a set a.fitemkey='".$data['kode_baru']."' where a.fitemkey='".$data['kode_lama']."'";
		$queryIns16 = "update saldo_barang a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns17 = "update saldo_barang_all a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns18 = "update saldo_barang_toko a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns19 = "update stock_opname a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns20 = "update tau_keluar a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns21 = "update transfer_toko a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";
		$queryIns22 = "update minmax_stok_barang a set a.barang_kode='".$data['kode_baru']."' where a.barang_kode='".$data['kode_lama']."'";

		$queryIns23 = "update barang a set a.is_aktif='0', a.is_hapus='1' where a.kode='".$data['kode_lama']."'";

		$this->db->query($queryInsert);
		$this->db->query($queryIns1);
		$this->db->query($queryIns2);
		$this->db->query($queryIns3);
		$this->db->query($queryIns4);
		$this->db->query($queryIns5);
		$this->db->query($queryIns6);
		$this->db->query($queryIns7);
		$this->db->query($queryIns8);
		$this->db->query($queryIns9);
		$this->db->query($queryIns10);
		$this->db->query($queryIns11);
		$this->db->query($queryIns12);
		$this->db->query($queryIns13);
		$this->db->query($queryIns14);
		$this->db->query($queryIns15);
		$this->db->query($queryIns16);
		$this->db->query($queryIns17);
		$this->db->query($queryIns18);
		$this->db->query($queryIns19);
		$this->db->query($queryIns20);
		$this->db->query($queryIns21);
		$this->db->query($queryIns22);
		$this->db->query($queryIns23);

		echo "Kode selesai dirubah";
	}

	function SyncSaldoAwalBarang($data){
		$bulanLama = $data['bulan'] - 1;
		$tahunLama = $data['tahun'];
		if($bulanLama == 0){
			$bulanLama = 12;
			$tahunLama = $data['tahun'] - 1;
		}
		$query = "INSERT INTO db_wecode_smart.saldo_barang_toko (toko_kode, barang_kode, tahun, bulan, saldo_awal_kwt, kwt_in, kwt_out, retur, transfer_out_dc, saldo_akhir_kwt, waktu_update) select toko_kode, barang_kode, ".$data['tahun']." as tahun, ".$data['bulan']." as bulan, saldo_akhir_kwt as saldo_awal_kwt, 0 as kwt_in, 0 as kwt_out, 0 as retur, 0 as transfer_out_dc, saldo_akhir_kwt, NOW() as waktu_update from db_wecode_smart.saldo_barang_toko a where a.bulan=".$bulanLama." and a.tahun=".$tahunLama." on duplicate key update saldo_awal_kwt=a.saldo_akhir_kwt";

		$this->db->query($query);

		$query2 = "INSERT INTO db_wecode_smart.saldo_barang_konsinyasi (toko_kode, barang_kode, tahun, bulan, saldo_awal_kwt, kwt_in, kwt_out, retur, biaya, saldo_akhir_kwt, waktu_update) select toko_kode, barang_kode, ".$data['tahun']." as tahun, ".$data['bulan']." as bulan, saldo_akhir_kwt as saldo_awal_kwt, 0 as kwt_in, 0 as kwt_out, 0 as retur, 0 as biaya, saldo_akhir_kwt, NOW() as waktu_update from db_wecode_smart.saldo_barang_konsinyasi a where a.bulan=".$bulanLama." and a.tahun=".$tahunLama." on duplicate key update saldo_awal_kwt=a.saldo_akhir_kwt";

		$this->db->query($query2);

		$queryupdatesaldo = "UPDATE db_wecode_smart.saldo_barang_toko a set a.saldo_akhir_kwt=(a.saldo_awal_kwt+a.kwt_in-a.kwt_out) where a.saldo_akhir_kwt<>(a.saldo_awal_kwt+a.kwt_in-a.kwt_out) and a.bulan=".$data['bulan']." and a.tahun=".$data['tahun']."";
		$this->db->query($queryupdatesaldo);

		$queryupdatesaldo2 = "UPDATE db_wecode_smart.saldo_barang_konsinyasi a set a.saldo_akhir_kwt=(a.saldo_awal_kwt+a.kwt_in-a.kwt_out) where a.saldo_akhir_kwt<>(a.saldo_awal_kwt+a.kwt_in-a.kwt_out) and a.bulan=".$data['bulan']." and a.tahun=".$data['tahun']."";
		$this->db->query($queryupdatesaldo2);

		echo "Saldo Akhir Stok bulan ".$bulanLama."-".$tahunLama." sudah dipindahkan sebagai saldo awal bulan ".$data['bulan']."-".$data['tahun']."";	
	}

	function SyncAnggota(){
		$query = "insert into db_wecode_smart.pelanggan (kode, jenis_pelanggan, no_ang, nama_pelanggan, no_peg, no_peglm, kd_prsh, bagian, departemen) SELECT a.no_ang, '1440822187' as jenis_pelanggan, a.no_ang, a.nm_ang, a.no_peg, a.no_peglm, a.kd_prsh, a.nm_bagian, a.nm_dep FROM k3pg_sp.t_anggota a on duplicate key update no_peg=a.no_peg, no_peglm=a.no_peglm, kd_prsh=a.kd_prsh;";

		$this->db->query($query);

		echo "Data anggota berhasil disimpan";
	}
	
	function SyncHargaJualHpp($data){
		$querygetBarang = "select kode as barang_kode from barang where is_aktif='1' and is_hapus='0' and kategori not in ('KA', 'KB', 'KC', 'KD', 'KE')";
		$resultBarang = $this->db->query($querygetBarang);
		$resultBarangArr = $resultBarang->result_array();
		foreach($resultBarangArr as $key => $value){
			$queryGet = "select a.barang_kode, a.harga, a.ppn, a.supplier_kode, a.tanggal from pengadaan_barang a where a.barang_kode='".$value['barang_kode']."' order by a.tanggal desc limit 1";

			$result = $this->db->query($queryGet);
			$resultArr = $result->result_array();

			if(sizeof($resultArr) > 0){
				$ParamHarga = array();
				$ParamHarga['barang_kode'] = $resultArr[0]['barang_kode'];
				$ParamHarga['supplier_kode'] = $resultArr[0]['supplier_kode'];
				$ParamHarga['harga'] = $resultArr[0]['harga'] + $resultArr[0]['ppn'];
				$ParamHarga['tanggal'] = $resultArr[0]['tanggal'];
				$ParamHarga['toko_kode'] = $data['toko_kode'];

				$this->UpdateHargaJual($ParamHarga);
			}
		}
		
		echo "selesai sync harga jual sesuai margin";
	}
	
	function pembulatan($uang){
		$puluhan = substr($uang, -2);
		$akhir = $uang;
		if($puluhan<=50){
			if($puluhan > 0){
				$akhir = $uang + (50-$puluhan);
			}
		}else{
			$akhir = $uang + (100-$puluhan);
		}

		return $akhir;
	}
	
	function UpdateHargaJual($data){
		$queryGet = "SELECT a.kode, a.barcode, if(a.margin is null or a.margin <= 0, ifnull(b.margin_harga, 0), a.margin) as margin_harga, if(a.margin2 is null or a.margin2 <= 0, ifnull(b.margin_harga2, 0), a.margin2) as margin_harga2 FROM barang a left join kategori_barang b on a.kategori=b.kode where a.kode='".$data['barang_kode']."'";
		$resultget = $this->db->query($queryGet);
		$resultgetArr = $resultget->result_array();

		if(sizeof($resultgetArr) > 0){
			$Margin = ($data['harga'] * ($resultgetArr[0]['margin_harga']/100));
			$HargaJual = $data['harga'] + $Margin;
			$HargaJual = $this->pembulatan(round($HargaJual));

			$Margin2 = ($data['harga'] * ($resultgetArr[0]['margin_harga2']/100));
			$HargaJual2 = $data['harga'] + $Margin2;
			$HargaJual2 = $this->pembulatan(round($HargaJual2));

			$QueryUpdate = "UPDATE harga_barang_toko SET harga1=".$HargaJual.", harga2=".$HargaJual2.", waktu_update=NOW() where barang_kode='".$data['barang_kode']."' and toko_kode='".$data['toko_kode']."' and toko_kode<>'VO0005'";
			
			$this->db->query($QueryUpdate);
			
			if($data['toko_kode'] == "VO0005"){
				// untuk toko bunga margin + 5%
				$Margin = ($data['harga'] * (($resultgetArr[0]['margin_harga']+5)/100));
				$HargaJual = $data['harga'] + $Margin;
				$HargaJual = $this->pembulatan(round($HargaJual));

				$Margin2 = ($data['harga'] * (($resultgetArr[0]['margin_harga2']+5)/100));
				$HargaJual2 = $data['harga'] + $Margin2;
				$HargaJual2 = $this->pembulatan(round($HargaJual2));

				$QueryUpdate = "UPDATE harga_barang_toko SET harga1=".$HargaJual.", harga2=".$HargaJual2.", waktu_update=NOW() where barang_kode='".$data['barang_kode']."' and toko_kode='VO0005'";

				$this->db->query($QueryUpdate);
			}
		}
	}
}
