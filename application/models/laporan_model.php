<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//error_reporting(E_ALL);
//ini_set("error_reporting", E_ALL);
set_time_limit(14400);
//ini_set('memory_limit','50M');
class Laporan_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getSaldoAwal($data){
		$query = "select * from saldo_kasbank where kd_kb='".$data['kd_kb']."' and bulan=".$data['bulan']." and tahun=".$data['tahun']." and unit_kode='".$data['unit_kode']."'";
		
		$result = $this->db->query($query);
		$resultSaldo = $result->result_array();
		$this->db->close();
		
		$tanggal_awal = date('Y-m-d', strtotime('-1 days', strtotime($data['tanggal_awal'])));
		$queryKasbank = "select sum(if(SUBSTRING(bukti, 2, 1)='K', jumlah, 0)) as kredit, sum(if(SUBSTRING(bukti, 2, 1)='M', jumlah, 0)) as debet 
		from kasbank where tanggal between '".$data['tahun']."-".$data['bulan']."-01' and '".$tanggal_awal."' 
		and kd_kb='".$data['kd_kb']."' and unit_kode='".$data['unit_kode']."'";
		// echo $queryKasbank;
		$resultkasbank = $this->db->query($queryKasbank);
		$resultkasbank = $resultkasbank->result_array();
		
		$SaldoAwalBulan = 0;
		if(sizeof($resultSaldo) > 0){
			$SaldoAwalBulan = $resultSaldo[0]['saldo_awal'];
		}
		
		$saldoAwal = 0;
		if(sizeof($resultkasbank) > 0){
			$saldoAwal = $SaldoAwalBulan + $resultkasbank[0]['debet'] - $resultkasbank[0]['kredit'];
		}else{
			$saldoAwal = $SaldoAwalBulan;
		}
		
		$this->db->close();
		
		return $saldoAwal;
	}
	
	function getMutasiKasbank($data){
		$query = "select a.bukti, a.kd_kb, a.kd_cb, b.keterangan as nama_cb, date(a.tanggal) as tanggal, a.kode_subject, a.nama_subject, a.keterangan, a.jumlah, a.no_ref from kasbank a left join m_cb b on a.kd_cb=b.kd_cb where date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."' and a.kd_kb='".$data['kd_kb']."' and a.unit_kode='".$data['unit_kode']."' and a.is_hapus='0' order by a.kd_cb, date(a.tanggal)";
		// a.kd_cb, date(a.tanggal)
		//echo $query;
		$result = $this->db->query($query);
		$this->db->close();
		return $result->result_array();
	}
	
	function getMutasiCashBudget($data){
		$query = "select a.kd_kb, a.kd_cb, b.keterangan, sum(a.jumlah) as jumlah from kasbank a left join m_cb b on a.kd_cb=b.kd_cb 
		where date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."' 
		and a.kd_kb='".$data['kd_kb']."' and a.unit_kode='".$data['unit_kode']."' and a.is_hapus='0' group by a.kd_kb, a.kd_cb order by a.kd_cb";
		// echo $query;
		$result = $this->db->query($query);
		$this->db->close();
		return $result->result_array();
	}
	
	function getMutasiPiutang($data){
		$tahunsebelum = $data['tahun'];
		$bulansebelum = $data['bulan'] - 1;
		if($bulansebelum == 0){
			$tahunsebelum = $data['tahun'] - 1;
		}
		
		$queryGet = "select a.kode, a.nama_pelanggan, b.saldo_awal as saldo_awal, c.jumlah as jm_piutang, d.jumlah as jm_bayar 
		from (select distinct f.pelanggan_kode as kode, g.nama_pelanggan from piutang f left join pelanggan g on f.pelanggan_kode=g.kode where f.toko_kode='".$data['toko_kode']."' and g.jenis_pelanggan<>'1440822187') a left join (select * from saldo_piutang where bulan=".$data['bulan']." and tahun=".$data['tahun']." and toko_kode='".$data['toko_kode']."') b on a.kode=b.pelanggan_kode left join (select pelanggan_kode, sum(jumlah) as jumlah from piutang where month(tanggal)=".$data['bulan']." and year(tanggal)=".$data['tahun']." and toko_kode='".$data['toko_kode']."' group by pelanggan_kode) c on a.kode=c.pelanggan_kode left join (select pelanggan_kode, sum(jumlah) as jumlah from pembayaran_piutang where month(tanggal)=".$data['bulan']." and year(tanggal)=".$data['tahun']." and is_hapus='0' and toko_kode='".$data['toko_kode']."' group by pelanggan_kode) d on a.kode=d.pelanggan_kode where (b.saldo_akhir is not null and b.saldo_akhir<>0) or (c.jumlah is not null or d.jumlah is not null) order by a.kode";
		
		$resultMutasi = $this->db->query($queryGet);
		$resultMutasi = $resultMutasi->result_array();
		
		return $resultMutasi;
	}
	
	function getMutasiHutang($data){
		$tahunsebelum = $data['tahun'];
		$bulansebelum = $data['bulan'] - 1;
		if($bulansebelum == 0){
			$tahunsebelum = $data['tahun'] - 1;
		}
		$data['bulan_lalu'] = $bulansebelum;
		$data['tahun_lalu'] = $tahunsebelum;
		
		$queryGet = "select a.kode, a.nama_supplier, b.saldo_awal as saldo_awal, c.jumlah as jm_hutang, (ifnull(d.jumlah, 0) - ifnull(g.jumlah, 0)) as jm_bayar, f.jumlah as jumlah_retur, g.jumlah as jumlah_realisasi_retur from supplier a left join (select * from saldo_hutang where bulan=".$data['bulan']." and tahun=".$data['tahun'].") b on a.kode=b.supplier_kode left join (select supplier_kode, sum(jumlah) as jumlah from hutang where month(tanggal)=".$data['bulan']." and year(tanggal)=".$data['tahun']." group by supplier_kode) c on a.kode=c.supplier_kode left join (select supplier_kode, sum(jumlah) as jumlah from hutang where month(tanggal_lunas)=".$data['bulan']." and year(tanggal_lunas)=".$data['tahun']." and is_lunas='1' group by supplier_kode ) d on a.kode=d.supplier_kode left join (select supplier_kode, sum(jumlah) as jumlah from saldo_retur_supplier where month(tanggal)=".$data['bulan']." and year(tanggal)=".$data['tahun']." group by supplier_kode) f on a.kode=f.supplier_kode left join (select a.supplier_kode, sum(a.jumlah) as jumlah from saldo_retur_supplier a where a.status='2' and month(waktu_realisasi)=".$data['bulan']." and year(waktu_realisasi)=".$data['tahun']." group by a.supplier_kode) g on a.kode=g.supplier_kode where (b.saldo_akhir is not null and b.saldo_akhir<>0) or (c.jumlah is not null or d.jumlah is not null) order by a.kode";
		
		$resultMutasi = $this->db->query($queryGet);
		$resultMutasi = $resultMutasi->result_array();
		
		return $resultMutasi;
	}
	
	function getMutasiBarang($data){
		/*$queryMutasi = "";
		$bulanSebelum = $data['bulan'] - 1;
		$tahunSebelum = $data['tahun'];
		if($bulanSebelum == 0){
			$bulanSebelum = 12;
			$tahunSebelum = $data['tahun'] - 1;
		}*/
		/*$where = " where d.is_intern<>'1'";
		if($data['bulan'] <= 2 && $data['tahun'] <= 2016){
			$where = "";
		}*/
		/*$queryMutasi = "select d.kode, d.nama_barang, f.saldo_awal_kwt, f.saldo_awal_hsat, f.jumlah_saldo_awal, e.kwt_in, (e.jumlah_in/e.kwt_in) as hsat_in, 
		e.jumlah_in, e.kwt_out, e.tau_out, (e.jumlah_out/e.kwt_out) as hsat_out, e.jumlah_out, (e.jumlah_tau_out/e.tau_out) as hsat_tau_out, 
		e.jumlah_tau_out, 
		h.saldo_akhir_kwt, h.saldo_akhir_hsat, h.jumlah_saldo_akhir from barang d left join (select a.barang_kode, 
		sum(a.kwt_in) as kwt_in, sum(a.jumlah_in) as jumlah_in, sum(a.kwt_out) as kwt_out, sum(a.tau_out) as tau_out, 
		sum(a.jumlah_out) as jumlah_out, sum(a.jumlah_tau_out) as jumlah_tau_out from saldo_barang a where a.bulan=".$data['bulan']." and a.tahun=".$data['tahun']." 
		group by a.barang_kode) e on d.kode=e.barang_kode left join (select * from (select b.barang_kode, b.saldo_akhir_kwt as saldo_awal_kwt, 
		b.saldo_akhir_hsat as saldo_awal_hsat, b.jumlah_saldo_akhir as jumlah_saldo_awal from saldo_barang b where b.bulan=".$bulanSebelum." and b.tahun=".$tahunSebelum." 
		order by b.urut desc) c group by c.barang_kode) f on d.kode=f.barang_kode left join (select * from (select barang_kode, saldo_akhir_kwt, 
		saldo_akhir_hsat, jumlah_saldo_akhir from saldo_barang where bulan=".$data['bulan']." and tahun=".$data['tahun']." order by urut desc) g 
		group by g.barang_kode) h on d.kode=h.barang_kode";*/
		$queryMutasi = "select a.barang_kode, a.bulan, a.tahun, a.saldo_awal_kwt, a.saldo_awal_hsat, a.jumlah_saldo_awal, a.kwt_in, a.hsat_in, a.jumlah_in, a.kwt_out, a.tau_out, a.hsat_out, a.jumlah_out, a.jumlah_tau_out, a.saldo_akhir_kwt, a.saldo_akhir_hsat, a.jumlah_saldo_akhir, a.tgl_update, a.nama_barang, a.is_ppn from saldo_barang_all a where a.bulan=".$data['bulan']." and a.tahun=".$data['tahun']." and ((a.jumlah_saldo_awal<>0 and a.jumlah_saldo_awal<>'') or (a.jumlah_in<>0 and a.jumlah_in<>'') or (a.jumlah_out<>0 and a.jumlah_out<>'') or (a.jumlah_tau_out<>0 and a.jumlah_tau_out<>'') or (a.jumlah_saldo_akhir<>0 and a.jumlah_saldo_akhir<>'') or (a.saldo_awal_kwt<>0 and a.saldo_awal_kwt<>'') or (a.saldo_akhir_kwt<>0 and a.saldo_akhir_kwt<>'')) order by a.barang_kode";
		//echo $queryMutasi;
		//exit;
		$result = $this->db->query($queryMutasi);
		$DataMutasi = $result->result_array();
		$this->db->close();
		
		return $DataMutasi;
	}
	
	function getDataBarangAll($data){
		$queryMutasi = "select kode, nama_barang from barang";
		
		$result = $this->db->query($queryMutasi);
		$DataMutasi = $result->result_array();
		
		return $DataMutasi;
	}
	
	function getDataKeluarMasukBarang($data){
		$queryMutasi = "select b.barang_kode, b.kwt_in, (b.jumlah_in/b.kwt_in) as hsat_in, b.jumlah_in, b.kwt_out, (b.jumlah_out/b.kwt_out) as hsat_out, b.jumlah_out from (select a.barang_kode, sum(a.kwt_in) as kwt_in, sum(a.jumlah_in) as jumlah_in, sum(a.kwt_out) as kwt_out, sum(a.jumlah_out) as jumlah_out from saldo_barang a where a.bulan=".$data['bulan']." and a.tahun=".$data['tahun']." and a.barang_kode='".$data['barang_kode']."' group by a.barang_kode) b order by b.barang_kode";
	
		$result = $this->db->query($queryMutasi);
		$DataMutasi = $result->result_array();
		
		return $DataMutasi;
	}
	
	function getDataSaldoAwalBarang($data){
		$bulanSebelum = $data['bulan'] - 1;
		$tahunSebelum = $data['tahun'];
		if($bulanSebelum == 0){
			$bulanSebelum = 12;
			$tahunSebelum = $data['tahun'] - 1;
		}
		
		$queryMutasi = "select * from (select b.barang_kode, b.saldo_akhir_kwt as saldo_awal_kwt, b.saldo_akhir_hsat as saldo_awal_hsat, b.jumlah_saldo_akhir as jumlah_saldo_awal from saldo_barang b where b.bulan=".$bulanSebelum." and b.tahun=".$tahunSebelum." and b.barang_kode='".$data['barang_kode']."' order by b.urut desc) c group by c.barang_kode order by c.barang_kode";
	
		$result = $this->db->query($queryMutasi);
		$DataMutasi = $result->result_array();
		
		return $DataMutasi;
	}
	
	function getDataSaldoAkhirBarang($data){
		$queryMutasi = "select * from (select barang_kode, saldo_akhir_kwt, saldo_akhir_hsat, jumlah_saldo_akhir from saldo_barang where bulan=".$data['bulan']." and tahun=".$data['tahun']." and barang_kode='".$data['barang_kode']."' order by urut desc) g group by g.barang_kode order by g.barang_kode";
	
		$result = $this->db->query($queryMutasi);
		$DataMutasi = $result->result_array();
		
		return $DataMutasi;
	}
	
	function getKartuPiutang($data){
		$queryKartu = "select d.*, (d.jumlah-d.bayar) sisa from (select a.*, DATE_FORMAT(a.tanggal,'%d-%m-%Y') tanggal_format, b.nama_pelanggan, sum(if(c.jumlah is null, 0, c.jumlah)) as bayar, date(c.tanggal) as tanggal_pembayaran from piutang a left join pelanggan b on a.pelanggan_kode=b.kode left join (select * from pembayaran_piutang where is_hapus='0' and tanggal <= '".$data['tahun']."-".$data['bulan']."-31') c on a.ref_penjualan=c.ref_penjualan and a.pelanggan_kode=c.pelanggan_kode and a.toko_kode=c.toko_kode where a.tanggal <= '".$data['tahun']."-".$data['bulan']."-31' and b.jenis_pelanggan<>'1440822187' and a.toko_kode='".$data['toko_kode']."' group by a.ref_penjualan, a.pelanggan_kode order by a.pelanggan_kode, a.tanggal desc) d where (month(d.tanggal_pembayaran)=".$data['bulan']." and year(d.tanggal_pembayaran)=".$data['tahun'].") or (d.tanggal_pembayaran is null)";
		
		$result = $this->db->query($queryKartu);
		$DataMutasi = $result->result_array();
		$this->db->close();
		
		return $DataMutasi;
	}
	
	function getKuitansiPiutang($data){
		$queryKartu = "select d.*, (d.jumlah-d.bayar) sisa from (select a.*, DATE_FORMAT(a.tanggal,'%d-%m-%Y') tanggal_format, b.nama_pelanggan, 
		sum(if(c.jumlah is null, 0, c.jumlah)) as bayar from piutang a left join pelanggan b on a.pelanggan_kode=b.kode 
		left join (select * from pembayaran_piutang where is_hapus='0' and tanggal <= '".$data['tahun']."-".$data['bulan']."-31') c on a.ref_penjualan=c.ref_penjualan and a.pelanggan_kode=c.pelanggan_kode 
		where a.tanggal <= '".$data['tahun']."-".$data['bulan']."-31' and a.toko_kode='".$data['toko_kode']."' and (a.no_kuitansi is not null or a.no_kuitansi<>'') 
		group by a.ref_penjualan, a.pelanggan_kode 
		order by a.pelanggan_kode, a.tanggal desc) d having sisa > 0;";
		
		$result = $this->db->query($queryKartu);
		$DataMutasi = $result->result_array();
		$this->db->close();
		
		return $DataMutasi;
	}
	
	function getKartuHutang($data){
		$queryKartu = "select d.*, (d.jumlah-d.bayar) sisa from (select a.ref_pengadaan, a.supplier_kode, a.unit_kode, a.tanggal, a.jumlah, a.tukar_nota_bukti, a.jatuh_tempo, a.is_lunas, a.tanggal_lunas, DATE_FORMAT(a.tanggal,'%d-%m-%Y') tanggal_format, b.nama_supplier, sum(if(c.jumlah is null, 0, c.jumlah)) as bayar from hutang a left join supplier b on a.supplier_kode=b.kode left join (select * from (select ref_pengadaan, supplier_kode, tanggal, sum(jumlah) as jumlah from pembayaran_hutang where tanggal <= '".$data['tahun']."-".$data['bulan']."-31' and is_hapus='0' group by ref_pengadaan, supplier_kode union select ref_pengadaan, supplier_kode, tanggal_lunas, sum(jumlah) as jumlah from hutang where tanggal_lunas <= '".$data['tahun']."-".$data['bulan']."-31' and is_lunas='1' group by ref_pengadaan, supplier_kode order by tanggal desc) v group by v.ref_pengadaan, v.supplier_kode) c on a.ref_pengadaan=c.ref_pengadaan and a.supplier_kode=c.supplier_kode where a.tanggal <= '".$data['tahun']."-".$data['bulan']."-31' group by a.ref_pengadaan, a.supplier_kode order by a.supplier_kode, a.tanggal desc) d having sisa > 0 
		union 
		select d.*, (d.jumlah-d.bayar) sisa from (select a.ref_bukti, a.supplier_kode, a.unit_kode, a.tanggal, a.jumlah, a.tukar_nota_bukti, '' as jatuh_tempo, '' as is_lunas, waktu_realisasi, DATE_FORMAT(a.tanggal,'%d-%m-%Y') tanggal_format, b.nama_supplier, sum(if(c.jumlah is null, 0, c.jumlah)) as bayar from saldo_retur_supplier a left join supplier b on a.supplier_kode=b.kode left join (select ref_bukti, supplier_kode, tanggal, sum(jumlah) as jumlah from saldo_retur_supplier where date(waktu_realisasi) <= '".$data['tahun']."-".$data['bulan']."-31' group by ref_bukti, supplier_kode) c on a.ref_bukti=c.ref_bukti and a.supplier_kode=c.supplier_kode where a.tanggal <= '".$data['tahun']."-".$data['bulan']."-31' group by a.ref_bukti, a.supplier_kode order by a.supplier_kode, a.tanggal desc) d having sisa > 0 order by supplier_kode, tanggal";
		$result = $this->db->query($queryKartu);
		$DataMutasi = $result->result_array();
		$this->db->close();
		
		return $DataMutasi;
	}
	
	function getUmurPiutang($data){
		$queryUmur = "select b.pelanggan_kode, b.nama_pelanggan, 
		sum(if(b.lama <= 14, b.sisa, 0)) as _14hari, 
		sum(if(b.lama >= 15 and b.lama <= 30, b.sisa, 0)) as _15hari, 
		sum(if(b.lama >= 31 and b.lama <= 45, b.sisa, 0)) as _31hari, 
		sum(if(b.lama >= 46 and b.lama <= 60, b.sisa, 0)) as _46hari, 
		sum(if(b.lama >= 61 and b.lama <= 90, b.sisa, 0)) as _61hari, 
		sum(if(b.lama >= 91 and b.lama <= 180, b.sisa, 0)) as _91hari, 
		sum(if(b.lama >= 181 and b.lama <= 365, b.sisa, 0)) as _181hari, 
		sum(if(b.lama >= 366 and b.lama <= 1095, b.sisa, 0)) as _366hari, 
		sum(if(b.lama >= 1096, b.sisa, 0)) as _1096hari 
		from (select e.*, (e.jumlah-e.bayar) sisa from (select a.*, c.nama_pelanggan, sum(if(d.jumlah is null, 0, d.jumlah)) bayar, (TO_DAYS('".$data['tanggal']."') - TO_DAYS(a.tanggal)) as lama 
		from piutang a left join pelanggan c on a.pelanggan_kode=c.kode 
		left join (select * from pembayaran_piutang where is_hapus='0' and tanggal<='".$data['tanggal']."') d 
		on a.ref_penjualan=d.ref_penjualan and a.pelanggan_kode=d.pelanggan_kode and a.toko_kode=d.toko_kode 
		where a.tanggal<='".$data['tanggal']."' and c.jenis_pelanggan<>'1440822187' and a.ref_penjualan<>'PENYESUAIAN' and a.toko_kode='".$data['toko_kode']."' 
		group by a.ref_penjualan, a.pelanggan_kode) e having sisa <> 0) b group by b.pelanggan_kode";
		
		$result = $this->db->query($queryUmur);
		$DataMutasi = $result->result_array();
		$this->db->close();
		
		return $DataMutasi;
	}

	function getPenjualanBulanan($data){
		$queryBulanan = "select DATE_FORMAT(a.fdate,'%d-%m-%Y') as fdate, sum(if(a.ftype=1, a.fbill_amount, 0)) as tunai, sum(if(a.ftype=2, a.fbill_amount, 0)) as kredit, sum(if(a.fname_payment='TAU', a.fbill_amount, 0)) as tau from rst_fc_trans_header a left join rst_fc_trans_detail b on a.fcode=b.fcode and a.flokasi=b.flokasi left join user c on a.fnocashier=c.username where month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']." and a.fbill_amount is not null and a.fstatuskey='1' group by date(a.fdate) order by a.fdate, a.fcode, a.fnocashier";
		
		$result = $this->db->query($queryBulanan);
		$DataMutasi = $result->result_array();
		$this->db->close();
		
		return $DataMutasi;
	}
	
	function getBarangMasuk($data){
		$queryBrgMasuk = "";
		if($data['mode'] == "barang"){
			/*$queryBrgMasuk = "(select a.bukti, a.barang_kode kd_item, c.nama_barang nama_item, a.supplier_kode, d.nama_supplier, a.tanggal, a.kwt_besar as kwt, a.harga, a.ppn, a.jumlah, a.status_pembayaran 
			from pengadaan_barang a left join barang c on a.barang_kode=c.kode left join supplier d on a.supplier_kode=d.kode 
			where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0') 
			union 
			(select a.bukti, a.barang_kode kd_item, b.nama_barang nama_item, a.supplier_kode, c.nama_supplier, a.tanggal, 
			a.kwt_besar as kwt, a.harga, '0' as ppn, a.jumlah, 'TAU' as status_pembayaran from pengadaan_barang_tau a left join barang b on a.barang_kode=b.kode 
			left join supplier c on a.supplier_kode=c.kode where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." 
			and a.is_hapus='0') order by supplier_kode";*/
			$queryBrgMasuk = "select a.bukti, a.barang_kode as kd_item, c.nama_barang as nama_item, c.satuan, a.supplier_kode, d.nama_supplier, a.tanggal, a.kwt, a.harga, a.ppn, a.jumlah, a.status_pembayaran, a.no_ref, a.ref_op 
			from pengadaan_barang a left join barang c on a.barang_kode=c.kode left join supplier d on a.supplier_kode=d.kode 
			where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' order by a.supplier_kode, a.bukti, a.urut";
			
			if($data['is_per_supplier'] == "1"){
				$queryBrgMasuk = "select a.supplier_kode, d.nama_supplier, sum(a.kwt * a.harga) as harga, sum(a.kwt * a.ppn) as ppn, 
				sum(a.jumlah) as jumlah 
				from pengadaan_barang a left join barang c on a.barang_kode=c.kode left join supplier d on a.supplier_kode=d.kode 
				where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' and c.kategori<>'VOUCHER' and c.kategori<>'1508470349' 
				group by a.supplier_kode order by a.supplier_kode";
			}
		}else if($data['mode'] == "pln"){
			$queryBrgMasuk = "select a.bukti, a.barang_kode kd_item, c.nama_barang nama_item, a.supplier_kode, d.nama_supplier, a.tanggal, a.kwt, a.harga, a.ppn, a.jumlah, a.status_pembayaran, e.tukar_nota_bukti 
			from pengadaan_barang a left join barang c on a.barang_kode=c.kode left join supplier d on a.supplier_kode=d.kode left join detail_tukar_nota e on a.bukti=e.pengadaan_bukti 
			where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and (c.kategori='VOUCHER' or c.kategori='1508470349') order by a.supplier_kode";
			
			if($data['is_per_supplier'] == "1"){
				$queryBrgMasuk = "select a.supplier_kode, d.nama_supplier, sum(a.kwt * a.harga) as harga, sum(a.kwt * a.ppn) as ppn, 
				sum(a.jumlah) as jumlah 
				from pengadaan_barang a left join barang c on a.barang_kode=c.kode left join supplier d on a.supplier_kode=d.kode 
				where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and (c.kategori='VOUCHER' or c.kategori='1508470349') 
				group by a.supplier_kode order by a.supplier_kode";
			}
		}
		
		$result = $this->db->query($queryBrgMasuk);
		$DataMutasi = $result->result_array();
		$this->db->close();
		
		return $DataMutasi;
	}
	
	function getPenjualanPelanggan($data){
		$queryPenjualan = "select a.fcode, DATE_FORMAT(a.fdate,'%d-%m-%Y') as fdate, a.fcustkey, a.fcustname, a.fname_payment, a.fbill_amount, a.fcash as fpayment, a.fkupon, a.fshu, a.fdebet, a.fkredit, a.fcash_change as fchange from rst_fc_trans_header a left join rst_fc_trans_detail b on a.fcode=b.fcode and a.flokasi=b.flokasi where month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']." and a.fbill_amount is not null and a.fstatuskey='1' order by a.fcustkey, date(a.fdate)";
		/*if($data['mode'] == "barang"){
			$queryPenjualan = "(select a.bukti, a.kd_pelanggan, c.nama_pelanggan, a.kd_barang kd_item, b.nama_barang nama_item, DATE_FORMAT(a.tanggal,'%d-%m-%Y') tanggal, a.kwt, a.harga, a.ppn 
			from penjualan_barang a left join m_barang b on a.kd_barang=b.kd_barang 
			left join m_pelanggan c on a.kd_pelanggan=c.kd_pelanggan 
			where (a.ref_order='' or a.ref_order is null) and a.is_hapus='0' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun'].")";
		}else if($data['mode'] == "jasa"){
			$queryPenjualan = "(select d.bukti, d.kd_pelanggan, f.nama_pelanggan, d.kd_jasa kd_item, e.nama_jasa nama_item, DATE_FORMAT(d.tanggal,'%d-%m-%Y') tanggal, d.kwt, d.harga, d.ppn 
			from penjualan_jasa d left join m_jasa e on d.kd_jasa=e.kd_jasa 
			left join m_pelanggan f on d.kd_pelanggan=f.kd_pelanggan 
			where (d.ref_order='' or d.ref_order is null) and month(d.tanggal)=".$data['bulan']." and year(d.tanggal)=".$data['tahun'].") 
			union 
			(select h.bukti, g.kd_pelanggan, m.nama_pelanggan, h.kd_event kd_item, n.nama_event nama_item, DATE_FORMAT(h.tanggal_event,'%d-%m-%Y') tanggal, \"1\" kwt, ((h.dpp + h.fee) * (g.persentase/100)) jumlah, if(g.is_tau='0',(h.ppn * (g.persentase/100)),0) as ppn 
			from `order` h left join detail_pelanggan_order g on h.bukti=g.order_bukti left join m_pelanggan m on g.kd_pelanggan=m.kd_pelanggan left join m_event n on h.kd_event=n.kd_event
			where month(h.tanggal_event)=".$data['bulan']." and year(h.tanggal_event)=".$data['tahun']." and h.is_hapus='0' and h.is_realisasi='1') 
			order by kd_pelanggan, tanggal, bukti";
		}else{
			$queryPenjualan = "(select a.bukti, a.kd_pelanggan, c.nama_pelanggan, a.kd_barang kd_item, b.nama_barang nama_item, DATE_FORMAT(a.tanggal,'%d-%m-%Y') tanggal, a.kwt, a.harga, a.ppn 
			from penjualan_barang a left join m_barang b on a.kd_barang=b.kd_barang 
			left join m_pelanggan c on a.kd_pelanggan=c.kd_pelanggan 
			where (a.ref_order='' or a.ref_order is null) and a.is_hapus='0' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun'].") 
			union 
			(select d.bukti, d.kd_pelanggan, f.nama_pelanggan, d.kd_jasa kd_item, e.nama_jasa nama_item, DATE_FORMAT(d.tanggal,'%d-%m-%Y') tanggal, d.kwt, d.harga, d.ppn 
			from penjualan_jasa d left join m_jasa e on d.kd_jasa=e.kd_jasa 
			left join m_pelanggan f on d.kd_pelanggan=f.kd_pelanggan 
			where (d.ref_order='' or d.ref_order is null) and month(d.tanggal)=".$data['bulan']." and year(d.tanggal)=".$data['tahun'].") 
			union 
			(select h.bukti, g.kd_pelanggan, m.nama_pelanggan, h.kd_event kd_item, n.nama_event nama_item, DATE_FORMAT(h.tanggal_event,'%d-%m-%Y') tanggal, \"1\" kwt, ((h.dpp + h.fee) * (g.persentase/100)) jumlah, if(g.is_tau='0',(h.ppn * (g.persentase/100)),0) as ppn 
			from `order` h left join detail_pelanggan_order g on h.bukti=g.order_bukti left join m_pelanggan m on g.kd_pelanggan=m.kd_pelanggan left join m_event n on h.kd_event=n.kd_event
			where month(h.tanggal_event)=".$data['bulan']." and year(h.tanggal_event)=".$data['tahun']." and h.is_hapus='0' and h.is_realisasi='1') 
			union 
			(select m.bukti, '0000004' as kd_pelanggan, 'SEMEN INDONESIA (PERSERO) TBK, PT' as nama_pelanggan, 
			'' as kd_item, concat('PROGRAM POIN KITA SAHABAT TAHUN 2013 DISTRIBUTOR ',n.nama_dist) as nama_item, DATE_FORMAT(m.tanggal,'%d-%m-%Y') tanggal, '1' as kwt, n.jumlah as harga, (n.jumlah * 0.11) as ppn 
			from jasa_poin m left join jasa_poin_detail n on m.bukti=n.bukti where m.is_hapus='0' and month(m.tanggal)=".$data['bulan']." and year(m.tanggal)=".$data['tahun'].") 
			order by kd_pelanggan, tanggal, bukti";
		}*/
		
		$result = $this->db->query($queryPenjualan);
		$DataMutasi = $result->result_array();
		$this->db->close();
		
		return $DataMutasi;
	}
	
	function getPenjualanTAU($data){
		$queryPenjualan = "";
		if($data['mode'] == "barang"){
			$queryPenjualan = "(select a.bukti, a.kd_pelanggan, c.nama_pelanggan, a.kd_barang kd_item, b.nama_barang nama_item, DATE_FORMAT(a.tanggal,'%d-%m-%Y') tanggal, a.kwt, a.harga, a.ppn 
			from penjualan_barang_tau a left join m_barang b on a.kd_barang=b.kd_barang 
			left join m_pelanggan c on a.kd_pelanggan=c.kd_pelanggan 
			where (a.ref_order='' or a.ref_order is null) and a.is_hapus='0' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun'].")";
		}else if($data['mode'] == "jasa"){
			$queryPenjualan = "(select d.bukti, d.kd_pelanggan, f.nama_pelanggan, d.kd_jasa kd_item, e.nama_jasa nama_item, DATE_FORMAT(d.tanggal,'%d-%m-%Y') tanggal, d.kwt, d.harga, d.ppn 
			from penjualan_jasa_tau d left join m_jasa e on d.kd_jasa=e.kd_jasa 
			left join m_pelanggan f on d.kd_pelanggan=f.kd_pelanggan 
			where (d.ref_order='' or d.ref_order is null) and month(d.tanggal)=".$data['bulan']." and year(d.tanggal)=".$data['tahun'].") 
			union 
			(select h.bukti, g.kd_pelanggan, m.nama_pelanggan, h.kd_event kd_item, n.nama_event nama_item, DATE_FORMAT(h.tanggal_event,'%d-%m-%Y') tanggal, \"1\" kwt, ((h.dpp + h.fee) * (g.persentase/100)) jumlah, if(g.is_tau='0',(h.ppn * (g.persentase/100)),0) as ppn 
			from `order` h left join detail_pelanggan_order g on h.bukti=g.order_bukti left join m_pelanggan m on g.kd_pelanggan=m.kd_pelanggan left join m_event n on h.kd_event=n.kd_event
			where month(h.tanggal_event)=".$data['bulan']." and year(h.tanggal_event)=".$data['tahun']." and h.is_hapus='0' and h.is_realisasi='1' and g.is_tau='1') 
			order by kd_pelanggan, tanggal, bukti";
		}else{
			$queryPenjualan = "(select a.bukti, a.kd_pelanggan, c.nama_pelanggan, a.kd_barang kd_item, b.nama_barang nama_item, DATE_FORMAT(a.tanggal,'%d-%m-%Y') tanggal, a.kwt, a.harga, a.ppn 
			from penjualan_barang_tau a left join m_barang b on a.kd_barang=b.kd_barang 
			left join m_pelanggan c on a.kd_pelanggan=c.kd_pelanggan 
			where (a.ref_order='' or a.ref_order is null) and a.is_hapus='0' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun'].") 
			union 
			(select d.bukti, d.kd_pelanggan, f.nama_pelanggan, d.kd_jasa kd_item, e.nama_jasa nama_item, DATE_FORMAT(d.tanggal,'%d-%m-%Y') tanggal, d.kwt, d.harga, d.ppn 
			from penjualan_jasa_tau d left join m_jasa e on d.kd_jasa=e.kd_jasa 
			left join m_pelanggan f on d.kd_pelanggan=f.kd_pelanggan 
			where (d.ref_order='' or d.ref_order is null) and month(d.tanggal)=".$data['bulan']." and year(d.tanggal)=".$data['tahun'].") 
			union 
			(select h.bukti, g.kd_pelanggan, m.nama_pelanggan, h.kd_event kd_item, n.nama_event nama_item, DATE_FORMAT(h.tanggal_event,'%d-%m-%Y') tanggal, \"1\" kwt, (h.dpp + h.fee) jumlah, h.ppn 
			from `order` h left join detail_pelanggan_order g on h.bukti=g.order_bukti left join m_pelanggan m on g.kd_pelanggan=m.kd_pelanggan left join m_event n on h.kd_event=n.kd_event
			where month(h.tanggal_event)=".$data['bulan']." and year(h.tanggal_event)=".$data['tahun']." and h.is_hapus='0' and h.is_realisasi='1' and g.is_tau='1') 
			order by kd_pelanggan, tanggal, bukti";
		}
		
		$result = $this->db->query($queryPenjualan);
		$DataMutasi = $result->result_array();
		$this->db->close();
		
		return $DataMutasi;
	}
	
	function getTransaksiPenjualan($data){
		//$query = "";
		/*if($data['tanggal'] == ""){
			$query = "select a.fcode, DATE_FORMAT(a.fdate,'%d-%m-%Y') as fdate, a.fcustkey, a.fcustname, a.fcreatedby, c.nama as nama_kasir, b.fbill_amount, b.fpayment, b.fkupon, b.fshu, b.fdebet, b.fkredit, a.fcash_change 
			from rst_fc_trans_header a left join rst_fc_payment b on a.fcode=b.ftranskey left join user c on a.fcreatedby=c.username 
			where month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']." and b.fname_payment='".$data['mode']."' 
			and b.fbill_amount is not null order by a.fdate, a.fcode, a.fcreatedby";
		}else{*/
			$whereKasir = "";
			if(!isset($data['kasir_kode']) || $data['kasir_kode'] == ""){
				$whereKasir = "";
			}else{
				$whereKasir = "and a.fcodecashier='".$data['kasir_kode']."'";
			}
			 //k3pg-ppn
			$query = "select a.fcode, date(a.fdate) as fdate, a.fcustkey, a.fcustname, a.fcodecashier as fcreatedby, c.nama as nama_kasir, sum(a.fbill_amount + a.fvat + a.fpembulatan + a.fpos_tax_count + a.fpoint) as fbill_amount, sum(a.fcash-a.fcash_change) as fpayment, sum(if(a.fbank_name='MANDIRI', a.fdebet, 0)) as kartu_debit_mandiri, sum(if(a.fbank_name='BRI', a.fdebet, 0)) as kartu_debit_bri, sum(if(a.fbank_name='BNI', a.fdebet, 0)) as kartu_debit_bni, sum(a.fkredit) as kartu_kredit, sum(if(a.ftype=2, (a.fbill_amount + a.fvat), 0)) as kredit, sum(a.fshu) as fshu, sum(a.fkupon) as fkupon, sum(a.fpotga) as kredit_anggota, sum(a.fvoucher) as voucher, sum(a.fpembulatan) as pembulatan from rst_fc_trans_header a left join `user` c on a.fcodecashier=c.username where (date(a.fdate) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.fbill_amount is not null and a.flokasi='".$data['toko_kode']."' and a.fstatuskey='1' ".$whereKasir." group by a.fcode, a.fdate, a.fcustkey, a.fcodecashier, a.fcustname order by a.fdate, a.fcodecashier, a.fcode";
			
			$query = "
			select
				a.fcode,
				date(a.fdate) as fdate,
				a.fcustkey,
				a.fcustname,
				a.fcodecashier as fcreatedby,
				c.nama as nama_kasir,
				sum(a.fbill_amount + a.fvat + a.fpembulatan + a.fpos_tax_count + a.fpoint) as fbill_amount,
				sum(a.fcash-a.fcash_change) as fpayment,
				sum(if(a.fbank_name = 'MANDIRI', a.fdebet, 0)) as kartu_debit_mandiri,
				sum(if(a.fbank_name = 'BRI', a.fdebet, 0)) as kartu_debit_bri,
				sum(if(a.fbank_name = 'BNI', a.fdebet, 0)) as kartu_debit_bni,
				sum(if(a.fbank_name = 'TRANSFER BNI', a.fdebet, 0)) as transfer_bni,
				sum(if(a.fbank_name = 'TRANSFER MANDIRI', a.fdebet, 0)) as transfer_mandiri,
				sum(a.fkredit) as kartu_kredit,
				sum(if(a.ftype = 2, (a.fbill_amount + a.fvat), 0)) as kredit,
				sum(a.fshu) as fshu,
				sum(a.fkupon) as fkupon,
				sum(a.fpotga) as kredit_anggota,
				sum(a.fvoucher) as voucher,
				coalesce(sum(a.fpembulatan),0) as pembulatan
			from
				rst_fc_trans_header a
			left join `user` c on
				a.fcodecashier = c.username
			where
				(date(a.fdate) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."')
				and a.fbill_amount is not null
				and a.flokasi = '".$data['toko_kode']."'
				and a.fstatuskey = '1' ".$whereKasir."
			group by
				a.fcode,
				a.fdate,
				a.fcustkey,
				a.fcodecashier,
				a.fcustname
			order by
				a.fdate,
				a.fcodecashier,
				a.fcode
			";
		//}
		
		$result = $this->db->query($query);
		return $result->result_array();
	}

	 //k3pg-ppn
	function getRekapPiutangInstansi($data){
		$query = "select a.fcode, DATE_FORMAT(a.fdate,'%d-%m-%Y') as fdate, a.fcustkey, a.fcustname, b.fitemkey, e.nama_barang, b.fqty, b.fprice, b.ftotal, if(e.is_ppn='1', (b.ftotal/1.11), b.ftotal) as dpp, if(e.is_ppn='1', ((b.ftotal/1.11) * 0.11), 0) as ppn from rst_fc_trans_header a left join user c on a.fcodecashier=c.username left join rst_fc_trans_detail b on a.fcode=b.fcode and a.flokasi=b.flokasi left join pelanggan d on a.fcustkey=d.kode left join barang e on b.fitemkey=e.kode where (date(a.fdate) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.fname_payment='KREDIT INSTANSI' and a.fcustkey like '%".$data['pelanggan_kode']."%' and a.fbill_amount is not null and a.fstatuskey='1' and b.fstatuskey='1' and a.flokasi='".$data['toko_kode']."' order by a.fcustkey, date(a.fdate), a.fcode";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}

	 //k3pg-ppn
	function getRekapBarangPenjualan($data){
		$query = "select a.fcode, DATE_FORMAT(a.fdate,'%d-%m-%Y') as fdate, a.fcustkey, a.fcustname, b.fitemkey, e.nama_barang, b.fqty, b.fprice, b.ftotal, if(e.is_ppn='1', (b.ftotal/1.11), b.ftotal) as dpp, if(e.is_ppn='1', ((b.ftotal/1.11) * 0.11), 0) as ppn from rst_fc_trans_header a left join user c on a.fcodecashier=c.username left join rst_fc_trans_detail b on a.fcode=b.fcode and a.flokasi=b.flokasi left join pelanggan d on a.fcustkey=d.kode left join barang e on b.fitemkey=e.kode where (date(a.fdate) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.fbill_amount is not null and a.fstatuskey='1' and b.fstatuskey='1' and a.fcustkey like '%".$data['pelanggan_kode']."%' and a.flokasi='".$data['toko_kode']."' order by a.fcustkey, date(a.fdate), a.fcode";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getTransaksiPenjualanAll($data){
		$query = "select a.fcode, DATE_FORMAT(a.fdate,'%d-%m-%Y') as fdate, b.fname_payment, a.fcustkey, a.fcustname, a.fcreatedby, c.nama as nama_kasir, b.fbill_amount, b.fpayment, b.fkupon, b.fshu, b.fdebet, b.fkredit, a.fcash_change as fchange 
		from rst_fc_trans_header a left join rst_fc_payment b on a.fcode=b.ftranskey left join user c on a.fcreatedby=c.username 
		where (date(a.fdate) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') 
		and b.fbill_amount is not null order by date(a.fdate), a.fcreatedby, a.fcode";
		
		$result = $this->db->query($query);
		return $result->result_array();
	}
	
	function getSaldoUMPembelian($data){
		$tahunSebelum = $data['tahun'];
		$bulanSebelum = $data['bulan'];
		$bulanSebelum = $bulanSebelum - 1;
		
		if($bulanSebelum == 0){
			$bulanSebelum = 12;
			$tahunSebelum = $tahunSebelum - 1;
		}
		
		$kd_cb_realisasi = "";
		if($data['kd_cb'] == "2921"){
			$kd_cb_realisasi = "1921";
		}else{
			$kd_cb_realisasi = "1931";
		}
		
		$querySaldoUM = "select if(e.kode_subject_1 is null,f.kode_subject_2,e.kode_subject_1) as kode_subject, 
		if(e.nama_subject_1 is null,f.nama_subject_2,e.nama_subject_1) as nama_subject, 
		if(e.um_bulan_sebelum is null, 0, e.um_bulan_sebelum) as um_bulan_sebelum, 
		if(e.realisasi_bulan_sebelum is null, 0, e.realisasi_bulan_sebelum) as realisasi_bulan_sebelum, 
		if(f.um is null, 0, f.um) as um, if(f.realisasi is null, 0, f.realisasi) as realisasi from supplier g 
		left join (select a.kode_subject as kode_subject_1, a.nama_subject as nama_subject_1, 
		sum(if(a.kd_cb='".$data['kd_cb']."', a.jumlah, 0)) um_bulan_sebelum, 
		sum(if(a.kd_cb='".$kd_cb_realisasi."', a.jumlah, 0)) as realisasi_bulan_sebelum 
		from kasbank a  
		where (a.kd_cb='".$data['kd_cb']."' or a.kd_cb='".$kd_cb_realisasi."') and a.is_hapus='0' and date(a.tanggal)<='".$tahunSebelum."-".$bulanSebelum."-31' 
		group by a.kode_subject order by a.kode_subject) e on g.kd_vendor=e.kode_subject_1 
		left join 
		(select c.kode_subject as kode_subject_2, c.nama_subject as nama_subject_2, 
		sum(if(c.kd_cb='".$data['kd_cb']."', c.jumlah, 0)) um, sum(if(c.kd_cb='".$kd_cb_realisasi."', c.jumlah, 0)) as realisasi 
		from kasbank c  
		where (c.kd_cb='".$data['kd_cb']."' or c.kd_cb='".$kd_cb_realisasi."') and c.is_hapus='0' and date(c.tanggal)>='".$data['tahun']."-".$data['bulan']."-01' and date(c.tanggal)<='".$data['tahun']."-".$data['bulan']."-31' 
		group by c.kode_subject order by c.kode_subject) f on g.kd_vendor=f.kode_subject_2 
		where kode_subject_1 is not null or kode_subject_2 is not null";
		 // echo $querySaldoUM;
		$result = $this->db->query($querySaldoUM);
		$DataMutasi = $result->result_array();
		$this->db->close();
		
		return $DataMutasi;
	}
	
	function getDataTAUMasuk($data){
		$query = "select a.bukti, a.barang_kode, b.nama_barang, a.supplier_kode, c.nama_supplier, a.tanggal, 
		a.kwt_besar, a.harga, a.jumlah from pengadaan_barang_tau a left join barang b on a.barang_kode=b.kode 
		left join supplier c on a.supplier_kode=c.kode where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." 
		and a.is_hapus='0' 
		order by a.tanggal, a.tgl_update";
		
		$result = $this->db->query($query);
		$DataMutasi = $result->result_array();
		$this->db->close();
		
		return $DataMutasi;
	}

	function getMasterSupplierBarang(){
		$query = "select a.barang_kode, a.supplier_kode, b.nama_supplier from harga_barang_supplier a left join supplier b on a.supplier_kode=b.kode";
		
		$result = $this->db->query($query);
		$DataMutasi = $result->result_array();
		
		$FinalResult = array();
		foreach ($DataMutasi as $key => $value) {
			$FinalResult[$value['barang_kode']] = $value;
		}

		return $FinalResult;
	} 
	
	function getSaldoBarangGudang($data){
		$mode_urut = "order by b.".$data['mode_urut'];
		if($data['mode_urut'] == ""){
			$mode_urut = "order by b.kode";
		}
		$addwhere = "and b.kategori = '".$data['kategori_kode']."'";
		if($data['kategori_kode'] == ""){
			$addwhere = "";
		}

		$query = "select a.toko_kode, d.nama as nama_toko, a.barang_kode, b.nama_barang, b.satuan, b.kategori, f.nama as nama_kategori, a.saldo_awal_kwt, a.kwt_in, a.kwt_out, a.retur, a.saldo_akhir_kwt, e.hpp, (e.hpp * a.saldo_akhir_kwt) as jumlah_hpp 
			from barang_toko c 
			left join saldo_barang_toko a on c.barang_kode=a.barang_kode and c.toko_kode=a.toko_kode 
			left join barang b on a.barang_kode=b.kode  
			left join toko d on a.toko_kode=d.kode 
			left join (select barang_kode, hpp from hpp where bulan=".$data['bulan']." and tahun=".$data['tahun'].") e on c.barang_kode=e.barang_kode 
			left join kategori_barang f on b.kategori=f.kode 
			where b.kategori not in ('KA', 'KB', 'KC', 'KD', 'KE') and a.tahun=".$data['tahun']." and a.bulan=".$data['bulan']." and a.toko_kode='".$data['toko_kode']."' and (a.barang_kode like '".$data['barang_kode']."%' or b.nama_barang like '".$data['barang_kode']."%') ".$addwhere." ".$mode_urut."";
		 
		if($data['toko_kode'] == "VO0006" || $data['toko_kode'] == "VO0009" || $data['toko_kode'] == "VO0010"){
			$query = "select a.toko_kode, d.nama as nama_toko, a.barang_kode, b.nama_barang, b.satuan, b.kategori, f.nama as nama_kategori, a.saldo_awal_kwt, a.kwt_in, a.kwt_out, a.retur, a.saldo_akhir_kwt, e.hpp, (e.hpp * a.saldo_akhir_kwt) as jumlah_hpp 
			from saldo_barang_toko a 
			left join barang b on a.barang_kode=b.kode  
			left join toko d on a.toko_kode=d.kode 
			left join (select barang_kode, hpp from hpp where bulan=".$data['bulan']." and tahun=".$data['tahun'].") e on a.barang_kode=e.barang_kode 
			left join kategori_barang f on b.kategori=f.kode 
			where b.kategori not in ('KA', 'KB', 'KC', 'KD', 'KE') and a.tahun=".$data['tahun']." and a.bulan=".$data['bulan']." and a.toko_kode='".$data['toko_kode']."' and (a.barang_kode like '".$data['barang_kode']."%' or b.nama_barang like '".$data['barang_kode']."%') ".$addwhere." ".$mode_urut."";
		}

		if(isset($data['cetak'])){
			$query = "select a.toko_kode, d.nama as nama_toko, a.barang_kode, b.nama_barang, b.satuan, b.kategori, f.nama as nama_kategori, a.saldo_awal_kwt, a.kwt_in, a.kwt_out, a.retur, a.saldo_akhir_kwt, e.hpp, (e.hpp * a.saldo_akhir_kwt) as jumlah_hpp 
				from barang_toko c 
				left join saldo_barang_toko a on c.barang_kode=a.barang_kode and c.toko_kode=a.toko_kode 
				left join barang b on a.barang_kode=b.kode  
				left join toko d on a.toko_kode=d.kode 
				left join (select barang_kode, hpp from hpp where bulan=".$data['bulan']." and tahun=".$data['tahun'].") e on c.barang_kode=e.barang_kode 
				left join kategori_barang f on b.kategori=f.kode 
				where b.kategori not in ('KA', 'KB', 'KC', 'KD', 'KE') and a.tahun=".$data['tahun']." and a.bulan=".$data['bulan']." and a.toko_kode='".$data['toko_kode']."' and (a.saldo_awal_kwt<>0 or a.kwt_in<>0 or a.kwt_out<>0 or a.saldo_akhir_kwt<>0) and (a.barang_kode like '".$data['barang_kode']."%' or b.nama_barang like '".$data['barang_kode']."%') ".$addwhere." ".$mode_urut."";

			if($data['toko_kode'] == "VO0006" || $data['toko_kode'] == "VO0009" || $data['toko_kode'] == "VO0010"){
				$query = "select a.toko_kode, d.nama as nama_toko, a.barang_kode, b.nama_barang, b.satuan, b.kategori, f.nama as nama_kategori, a.saldo_awal_kwt, a.kwt_in, a.kwt_out, a.retur, a.saldo_akhir_kwt, e.hpp, (e.hpp * a.saldo_akhir_kwt) as jumlah_hpp 
				from saldo_barang_toko a 
				left join barang b on a.barang_kode=b.kode  
				left join toko d on a.toko_kode=d.kode 
				left join (select barang_kode, hpp from hpp where bulan=".$data['bulan']." and tahun=".$data['tahun'].") e on a.barang_kode=e.barang_kode 
				left join kategori_barang f on b.kategori=f.kode 
				where b.kategori not in ('KA', 'KB', 'KC', 'KD', 'KE') and a.tahun=".$data['tahun']." and a.bulan=".$data['bulan']." and a.toko_kode='".$data['toko_kode']."' and (a.saldo_awal_kwt<>0 or a.kwt_in<>0 or a.kwt_out<>0 or a.saldo_akhir_kwt<>0) and (a.barang_kode like '".$data['barang_kode']."%' or b.nama_barang like '".$data['barang_kode']."%') and b.is_aktif='1' ".$addwhere." ".$mode_urut."";
			}
		}
		
		$result = $this->db->query($query);
		$resultSaldo = $result->result_array();
		
		return $resultSaldo;
	}

	function getSaldoBarangGudangKonsinyasi($data){
		$query = "select a.kode as barang_kode, a.nama_barang, a.kategori, b.nama as nama_kategori, c.supplier_kode, d.nama_supplier, ifnull(e.saldo_awal_kwt, 0) as saldo_awal_kwt, ifnull(e.kwt_in, 0) as kwt_in, ifnull(e.kwt_out, 0) as kwt_out, ifnull(e.retur, 0) as retur, ifnull(e.biaya, 0) as biaya, ifnull(e.saldo_akhir_kwt, 0) as saldo_akhir_kwt, ifnull(f.hpp, 0) as harga_beli, ifnull(d.fee_konsinyasi, 0) as fee_konsinyasi 
		from barang a 
		left join kategori_barang b on a.kategori=b.kode 
		left join harga_barang_supplier c on a.kode=c.barang_kode 
		left join supplier d on c.supplier_kode=d.kode 
		left join (select * from saldo_barang_konsinyasi where bulan=".$data['bulan']." and tahun=".$data['tahun']." and toko_kode='".$data['toko_kode']."') e on a.kode=e.barang_kode 
		left join (select bulan, tahun, barang_kode, hpp from hpp where bulan=".$data['bulan']." and tahun=".$data['tahun'].") f on a.kode=f.barang_kode 
		where a.kategori in ('KA', 'KB', 'KC', 'KD', 'KE') and c.supplier_kode='".$data['supplier_kode']."' order by c.supplier_kode, a.kategori, a.nama_barang";

		if(isset($data['cetak'])){
			$query = "select a.kode as barang_kode, a.nama_barang, a.kategori, b.nama as nama_kategori, c.supplier_kode, d.nama_supplier, ifnull(e.saldo_awal_kwt, 0) as saldo_awal_kwt, ifnull(e.kwt_in, 0) as kwt_in, ifnull(e.kwt_out, 0) as kwt_out, ifnull(e.retur, 0) as retur, ifnull(e.biaya, 0) as biaya, ifnull(e.saldo_akhir_kwt, 0) as saldo_akhir_kwt, ifnull(f.hpp, 0) as harga_beli, ifnull(d.fee_konsinyasi, 0) as fee_konsinyasi 
			from barang a 
			left join kategori_barang b on a.kategori=b.kode 
			left join harga_barang_supplier c on a.kode=c.barang_kode 
			left join supplier d on c.supplier_kode=d.kode 
			left join (select * from saldo_barang_konsinyasi where bulan=".$data['bulan']." and tahun=".$data['tahun']." and toko_kode='".$data['toko_kode']."') e on a.kode=e.barang_kode 
			left join (select bulan, tahun, barang_kode, hpp from hpp where bulan=".$data['bulan']." and tahun=".$data['tahun'].") f on a.kode=f.barang_kode 
			where a.kategori in ('KA', 'KB', 'KC', 'KD', 'KE') and (saldo_awal_kwt<>0 or kwt_in<>0 or kwt_out<>0 or saldo_akhir_kwt<>0) and c.supplier_kode='".$data['supplier_kode']."' order by c.supplier_kode, a.kategori, a.nama_barang";
		}
		
		$result = $this->db->query($query);
		$resultSaldo = $result->result_array();
		
		return $resultSaldo;
	}

	function getKelompokSaldoBarangKonsinyasi($data){
		$query = "select a.kategori, b.nama as nama_kategori, sum(ifnull(e.saldo_awal_kwt, 0) * ifnull(c.harga, 0)) as saldo_awal_kwt, sum(ifnull(e.kwt_in, 0) * ifnull(c.harga, 0)) as kwt_in, sum(ifnull(e.kwt_out, 0) * ifnull(c.harga, 0)) as kwt_out, sum(ifnull(e.retur, 0) * ifnull(c.harga, 0)) as retur, sum(ifnull(e.biaya, 0) * ifnull(c.harga, 0)) as biaya, sum(ifnull(e.saldo_akhir_kwt, 0) * ifnull(c.harga, 0)) as saldo_akhir_kwt from barang a left join kategori_barang b on a.kategori=b.kode left join harga_barang_supplier c on a.kode=c.barang_kode left join supplier d on c.supplier_kode=d.kode left join (select * from saldo_barang_konsinyasi where bulan=".$data['bulan']." and tahun=".$data['tahun']." and toko_kode='".$data['toko_kode']."') e on a.kode=e.barang_kode where a.kategori in ('KA', 'KB', 'KC', 'KD', 'KE') and c.supplier_kode='".$data['supplier_kode']."' group by a.kategori";

		$result = $this->db->query($query);
		$resultSaldo = $result->result_array();
		
		return $resultSaldo;
	}
	
	function getDetailSaldo($data){
		$query = "";
		if($data['toko_kode'] == "VO0006"){ // dc
			$query = "select a.tanggal, a.bukti, '' as toko_kode, '1' as mode, a.barang_kode, sum(a.kwt) as kwt from pengadaan_barang a where a.barang_kode='".$data['barang_kode']."' and a.is_hapus='0' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." group by a.bukti, a.barang_kode 
			union 
			select a.tanggal, a.bukti, a.toko_kode, '1' as mode, a.barang_kode, sum(a.kwt) as kwt from retur_toko a where a.barang_kode='".$data['barang_kode']."' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.is_approve='1' group by a.bukti, a.barang_kode 
			union 
			select a.tanggal, a.bukti, a.toko_kode, '1' as mode, a.barang_kode, sum(a.kwt) as kwt from penyesuaian a where a.barang_kode='".$data['barang_kode']."' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.toko_kode='VO0006' and a.`status`='0' group by a.bukti, a.barang_kode 
			union 
			select a.tanggal, a.bukti, a.toko_kode, '1' as mode, a.barang_kode, sum(a.kwt) as kwt from bo_bad_stock a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' and a.is_penyesuaian='0' group by a.bukti, a.barang_kode
			union 
			select a.tanggal, a.bukti, a.toko_kode, '2' as mode, a.barang_kode, sum(a.kwt) as kwt from transfer_toko a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' and a.is_approve='1' group by a.bukti, a.barang_kode 
			union 
			select a.tanggal, a.bukti, '' as toko_kode, '2' as mode, a.barang_kode, sum(a.kwt) as kwt from tau_keluar a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.barang_kode='".$data['barang_kode']."' and a.is_hapus='0' group by a.bukti, a.barang_kode 
			union 
			select a.tanggal, a.bukti, '' as toko_kode, '2' as mode, a.barang_kode, sum(a.kwt) as kwt from penyesuaian a where a.barang_kode='".$data['barang_kode']."' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.toko_kode='VO0006' and a.`status`='1' group by a.bukti, a.barang_kode 
			union 
			select a.tanggal, a.bukti, a.toko_kode, '2' as mode, a.barang_kode, sum(a.kwt) as kwt from bad_stock a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' group by a.bukti, a.barang_kode 
			order by tanggal";
			if(intval($data['tahun']) <= 2016 || (intval($data['bulan']) == 1 && intval($data['tahun']) == 2017)){ // perhitungan lama
				$query = "select a.tanggal, a.bukti, '' as toko_kode, '1' as mode, a.barang_kode, sum(a.kwt) as kwt from pengadaan_barang a where a.barang_kode='".$data['barang_kode']."' and a.is_hapus='0' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." group by a.bukti, a.barang_kode 
				union 
				select a.tanggal, a.bukti, a.toko_kode, '1' as mode, a.barang_kode, sum(a.kwt) as kwt from retur_toko a where a.barang_kode='".$data['barang_kode']."' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.is_approve='1' group by a.bukti, a.barang_kode 
				union 
				select a.tanggal, a.bukti, a.toko_kode, '1' as mode, a.barang_kode, sum(a.kwt) as kwt from penyesuaian a where a.barang_kode='".$data['barang_kode']."' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.toko_kode='VO0006' and a.`status`='0' group by a.bukti, a.barang_kode
				union 
				select a.tanggal, a.bukti, a.toko_kode, '2' as mode, a.barang_kode, sum(a.kwt) as kwt from transfer_toko a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' and a.is_approve='1' group by a.bukti, a.barang_kode 
				union 
				select a.tanggal, a.bukti, '' as toko_kode, '2' as mode, a.barang_kode, sum(a.kwt) as kwt from tau_keluar a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.barang_kode='".$data['barang_kode']."' and a.is_hapus='0' group by a.bukti, a.barang_kode 
				union 
				select a.tanggal, a.bukti, a.toko_kode, '2' as mode, a.barang_kode, sum(a.kwt) as kwt from penyesuaian a where a.barang_kode='".$data['barang_kode']."' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.toko_kode='VO0006' and a.`status`='1' group by a.bukti, a.barang_kode 
				union 
				select a.tanggal, a.bukti, '' as toko_kode, '2' as mode, a.barang_kode, sum(a.kwt) as kwt from retur_supplier a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.barang_kode='".$data['barang_kode']."' and a.is_hapus='0' group by a.bukti, a.barang_kode
				order by tanggal";
			}
		}else if($data['toko_kode'] == "VO0009"){ // dc bs retur
			$query = "select a.tanggal, a.bukti, a.toko_kode, '1' as mode, a.barang_kode, sum(a.kwt) as kwt from bad_stock a where a.barang_kode='".$data['barang_kode']."' and a.is_hapus='0' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.toko_kode='VO0009' group by a.bukti, a.barang_kode 
			union 
			select a.tanggal, a.bukti, a.toko_kode, '2' as mode, a.barang_kode, sum(a.kwt) as kwt from bo_bad_stock a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.is_penyesuaian='0' and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='VO0009' group by a.bukti, a.barang_kode
			union 
			select a.tanggal, a.bukti, '' as toko_kode, '2' as mode, a.barang_kode, sum(a.kwt) as kwt from retur_supplier a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' group by a.bukti, a.barang_kode  
			order by tanggal";
		}else if($data['toko_kode'] == "VO0010"){ // dc bs non retur
			$query = "select a.tanggal, a.bukti, a.toko_kode, '1' as mode, a.barang_kode, sum(a.kwt) as kwt from bad_stock a where a.barang_kode='".$data['barang_kode']."' and a.is_hapus='0' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.toko_kode='VO0010' group by a.bukti, a.barang_kode 
			union 
			select a.tanggal, a.bukti, a.toko_kode, '2' as mode, a.barang_kode, sum(a.kwt) as kwt from bo_bad_stock a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='VO0010' group by a.bukti, a.barang_kode 
			order by tanggal";
		}else{ // toko
			$query = "select a.tanggal, a.bukti, a.toko_kode, '1' as mode, a.barang_kode, sum(a.kwt) as kwt from transfer_toko a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.barang_kode='".$data['barang_kode']."' and a.toko_kode='".$data['toko_kode']."' and a.is_approve='1' group by a.tanggal, a.bukti, a.barang_kode 
			union 
			select a.fdate, a.fcode, a.flokasi, '2' as mode, b.fitemkey, sum(b.fqty) as kwt from rst_fc_trans_header a left join rst_fc_trans_detail b on a.fcode=b.fcode and a.flokasi=b.flokasi where a.fstatuskey='1' and month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']." and b.fitemkey='".$data['barang_kode']."' and a.flokasi='".$data['toko_kode']."' group by a.fdate, a.fcode, b.fitemkey 
			union 
			select a.tanggal, a.bukti, a.toko_kode, '2' as mode, a.barang_kode, sum(a.kwt) as kwt from retur_toko a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.is_approve='1' and a.toko_kode='".$data['toko_kode']."' and a.barang_kode='".$data['barang_kode']."' group by a.tanggal, a.bukti, a.barang_kode 
			union 
			select a.tanggal, a.bukti, a.toko_kode, if(a.`status`='0', '1', '2') as mode, a.barang_kode, sum(a.kwt) as kwt from penyesuaian a where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.toko_kode='".$data['toko_kode']."' and a.barang_kode='".$data['barang_kode']."' group by a.tanggal, a.bukti, a.barang_kode 
			order by tanggal";
		}
		
		$result = $this->db->query($query);
		$resultSaldo = $result->result_array();
		
		return $resultSaldo;
	}
	
	function getKartuBarang($data){
		$query = "select a.ref_bukti, a.barang_kode, b.nama_barang, a.bulan, a.tahun, a.tanggal, a.saldo_awal_kwt, a.saldo_awal_hsat, a.jumlah_saldo_awal, 
		a.kwt_in, a.hsat_in, a.jumlah_in, a.kwt_out, a.tau_out, a.hsat_out, a.jumlah_out, a.jumlah_tau_out, a.saldo_akhir_kwt, a.saldo_akhir_hsat, 
		a.jumlah_saldo_akhir from saldo_barang a left join barang b on a.barang_kode=b.kode where a.barang_kode='".$data['barang_kode']."' and a.bulan=".$data['bulan']." and a.tahun=".$data['tahun']." 
		order by a.urut;";
		
		$result = $this->db->query($query);
		$resultSaldo = $result->result_array();
		
		return $resultSaldo;
	}
	
	function getDataPenjualan($data){
		$query = "select date(a.fdate) as fdate, sum(a.fbill_amount + a.fvat + a.fpembulatan + a.fpos_tax_count + a.fpoint) as fbill_amount, sum(a.fcash-a.fcash_change) as fpayment, sum(if(a.fbank_name='MANDIRI', a.fdebet, 0)) as kartu_debit_mandiri, sum(if(a.fbank_name='BRI', a.fdebet, 0)) as kartu_debit_bri, sum(if(a.fbank_name='BNI', a.fdebet, 0)) as kartu_debit_bni, sum(a.fkredit) as kartu_kredit, sum(if(a.ftype=2, (a.fbill_amount + a.fvat), 0)) as kredit, sum(a.fshu) as fshu, sum(a.fkupon) as fkupon, sum(a.fpotga) as kredit_anggota, sum(a.fvoucher) as voucher, sum(a.fpembulatan) as pembulatan from rst_fc_trans_header a where month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']." and a.fbill_amount is not null and a.flokasi='".$data['toko_kode']."' and a.fstatuskey='1' group by date(a.fdate) order by date(a.fdate)";
		// switch($data['mode']){
		// 	case 'umum' :
		// 		$query = "select date(a.fdate) as fdate, sum(a.fbill_amount + a.fvat) as fbill_amount, 
		// 		sum(a.fcash-a.fcash_change) as fpayment, 0 as kupon_kwsg, 0 as kupon_ptsi, 0 as kupon_ptsg, 0 as kupon_unknown, sum(a.fshu) as fshu, 
		// 		sum(a.fdebet) as kartu_debit, sum(a.fkredit) as kartu_kredit, 
		// 		sum(if(a.ftype=2, (a.fbill_amount + a.fvat), 0)) as kredit, sum(a.fvoucher) as voucher 
		// 		from rst_fc_trans_header a left join (select fcode, flokasi, fitemkey from rst_fc_trans_detail where flokasi='".$data['toko_kode']."' group by flokasi, fcode) b on a.fcode=b.fcode and a.flokasi=b.flokasi left join barang d on b.fitemkey=d.kode left join pelanggan c on a.fcustkey=c.kode 
		// 		where month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']." 
		// 		and a.fbill_amount is not null and a.flokasi='".$data['toko_kode']."' and a.fstatuskey='1' and (a.fcustname='UMUM' or a.fcustkey='0') and d.kategori<>'VOUCHER' and d.kategori<>'1508470349' group by date(a.fdate) 
		// 		order by date(a.fdate)";
		// 		break;
		// 	case 'anggota' :
		// 		$query = "select date(a.fdate) as fdate, sum(a.fbill_amount + a.fvat) as fbill_amount, sum(a.fcash-a.fcash_change) as fpayment, sum(if(c.kd_prsh='07', a.fkupon, 0)) as kupon_kwsg, sum(if(c.kd_prsh='01', a.fkupon, 0)) as kupon_ptsi, sum(if(c.kd_prsh='22', a.fkupon, 0)) as kupon_ptsg, sum(if(c.kd_prsh<>'07' and c.kd_prsh<>'01' and c.kd_prsh<>'22', a.fkupon, 0)) as kupon_unknown, sum(a.fshu) as fshu, sum(a.fdebet) as kartu_debit, sum(a.fkredit) as kartu_kredit, sum(if(a.ftype=2, (a.fbill_amount + a.fvat), 0)) as kredit, sum(a.fvoucher) as voucher from rst_fc_trans_header a left join (select fcode, flokasi, fitemkey from rst_fc_trans_detail where flokasi='".$data['toko_kode']."' group by flokasi, fcode) b on a.fcode=b.fcode and a.flokasi=b.flokasi left join barang d on b.fitemkey=d.kode left join pelanggan c on a.fcustkey=c.kode where month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']." and a.fbill_amount is not null and a.flokasi='".$data['toko_kode']."' and a.fstatuskey='1' and c.jenis_pelanggan='1440822187' and d.kategori<>'VOUCHER' and d.kategori<>'1508470349' group by date(a.fdate) order by date(a.fdate)";
		// 		break;
		// 	case 'instansi' :
		// 		$query = "select date(a.fdate) as fdate, sum(a.fbill_amount + a.fvat) as fbill_amount, sum(a.fcash-a.fcash_change) as fpayment, 0 as kupon_kwsg, 0 as kupon_ptsi, 0 as kupon_ptsg, 0 as kupon_unknown, sum(a.fshu) as fshu, sum(a.fdebet) as kartu_debit, sum(a.fkredit) as kartu_kredit, sum(if(a.ftype=2, (a.fbill_amount + a.fvat), 0)) as kredit, sum(a.fvoucher) as voucher from rst_fc_trans_header a left join (select fcode, flokasi, fitemkey from rst_fc_trans_detail where flokasi='".$data['toko_kode']."' group by flokasi, fcode) b on a.fcode=b.fcode and a.flokasi=b.flokasi left join barang d on b.fitemkey=d.kode left join pelanggan c on a.fcustkey=c.kode where month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']." and a.fbill_amount is not null and a.flokasi='".$data['toko_kode']."' and a.fcustname<>'UMUM' and a.fcustkey<>'0' and a.fstatuskey='1' and c.jenis_pelanggan<>'1440822187' and d.kategori<>'VOUCHER' and d.kategori<>'1508470349' group by date(a.fdate) order by date(a.fdate)";
		// 		break;
		// 	case 'all' :
		// 		$query = "select date(a.fdate) as fdate, sum(a.fbill_amount + a.fvat) as fbill_amount, sum(a.fcash-a.fcash_change) as fpayment, sum(if(c.kd_prsh='07', a.fkupon, 0)) as kupon_kwsg, sum(if(c.kd_prsh='01', a.fkupon, 0)) as kupon_ptsi, sum(if(c.kd_prsh='22', a.fkupon, 0)) as kupon_ptsg, sum(if(c.kd_prsh<>'07' and c.kd_prsh<>'01' and c.kd_prsh<>'22', a.fkupon, 0)) as kupon_unknown, sum(a.fshu) as fshu, sum(a.fdebet) as kartu_debit, sum(a.fkredit) as kartu_kredit, sum(if(a.ftype=2, (a.fbill_amount + a.fvat), 0)) as kredit, sum(a.fvoucher) as voucher from rst_fc_trans_header a left join (select fcode, flokasi, fitemkey from rst_fc_trans_detail where flokasi='".$data['toko_kode']."' group by flokasi, fcode) b on a.fcode=b.fcode and a.flokasi=b.flokasi left join barang d on b.fitemkey=d.kode left join pelanggan c on a.fcustkey=c.kode where month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']." and a.fbill_amount is not null and a.flokasi='".$data['toko_kode']."' and a.fstatuskey='1' and d.kategori<>'VOUCHER' and d.kategori<>'1508470349' group by date(a.fdate) order by date(a.fdate)";
		// 		break;
		// 	case 'pln' :
		// 		$query = "select date(a.fdate) as fdate, sum(a.fbill_amount + a.fvat) as fbill_amount, sum(a.fcash-a.fcash_change) as fpayment, sum(if(c.kd_prsh='07', a.fkupon, 0)) as kupon_kwsg, sum(if(c.kd_prsh='01', a.fkupon, 0)) as kupon_ptsi, sum(if(c.kd_prsh='22', a.fkupon, 0)) as kupon_ptsg, sum(if(c.kd_prsh<>'07' and c.kd_prsh<>'01' and c.kd_prsh<>'22', a.fkupon, 0)) as kupon_unknown, sum(a.fshu) as fshu, sum(a.fdebet) as kartu_debit, sum(a.fkredit) as kartu_kredit, sum(if(a.ftype=2, (a.fbill_amount + a.fvat), 0)) as kredit, sum(a.fvoucher) as voucher from rst_fc_trans_header a left join (select fcode, flokasi, fitemkey from rst_fc_trans_detail where flokasi='".$data['toko_kode']."' group by flokasi, fcode) b on a.fcode=b.fcode and a.flokasi=b.flokasi left join barang d on b.fitemkey=d.kode left join pelanggan c on a.fcustkey=c.kode where month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']." and a.fbill_amount is not null and a.flokasi='".$data['toko_kode']."' and a.fstatuskey='1' and (d.kategori='VOUCHER' or d.kategori='1508470349') group by date(a.fdate) order by date(a.fdate)";
		// 		break;
		// }
		
		$result = $this->db->query($query);
		$resultPenjualan = $result->result_array();
		
		return $resultPenjualan;
	}
	
	function getDataTAUKeluar($data){
		$query = "select a.bukti, a.pelanggan_kode, b.nama_pelanggan, a.barang_kode, c.nama_barang, c.satuan, a.unit_kode, a.tanggal, a.kwt, 
		a.harga, a.jumlah from tau_keluar a left join pelanggan b on a.pelanggan_kode=b.kode left join barang c on a.barang_kode=c.kode 
		where month(a.tanggal)='".$data['bulan']."' and year(a.tanggal)='".$data['tahun']."' and a.pelanggan_kode like '%".$data['pelanggan_kode']."%' and a.is_hapus='0' order by a.pelanggan_kode, a.tanggal, a.bukti";
		
		$result = $this->db->query($query);
		$resultTAUKeluar = $result->result_array();
		
		return $resultTAUKeluar;
	}
	
	function getDataKreditAnggota($data){
		$query = "select a.fcustkey, c.no_ang, c.no_peg, a.fcustname, d.nm_prsh, sum(a.fbill_amount + a.fvat + a.fpos_tax_count) as fbill_amount, sum(a.fbill_amount + a.fvat + a.fpos_tax_count) as kredit from rst_fc_trans_header a left join pelanggan c on a.fcustkey=c.kode left join tbl_prsh d on c.kd_prsh=d.kd_prsh where month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']." and (a.fname_payment='KREDIT ANGSURAN' or a.fname_payment='KREDIT BUKU') and a.fbill_amount is not null and a.flokasi='".$data['toko_kode']."' and a.fstatuskey='1' group by a.fcustkey order by d.kd_prsh";
		
		$result = $this->db->query($query);
		$resultKreditAnggota = $result->result_array();
		
		return $resultKreditAnggota;
	}
	
	function getDataKreditInstansi($data){
		$query = "select a.fcustkey, a.fcustname, sum(a.fbill_amount) as fbill_amount, sum(a.fbill_amount) as kredit from rst_fc_trans_header a left join pelanggan c on a.fcustkey=c.kode where month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']." and a.fname_payment='KREDIT INSTANSI' and a.fbill_amount is not null and a.flokasi='".$data['toko_kode']."' and a.fstatuskey='1' group by a.fcustkey order by a.fcustkey";
		
		$result = $this->db->query($query);
		$resultKreditInstansi = $result->result_array();
		
		return $resultKreditInstansi;
	}
	
	function getDataBarangPOS($data){
		$TambahanQuery = "";
		if($data['mode'] == "dibawah_hargabeli"){
			$TambahanQuery = "and (c.harga1 <= d.harga or c.harga1 <= b.hpp)";
		}
		$TambahanQuery .= " group by a.barang_kode";
		$query = "select a.barang_kode, b.nama_barang, b.satuan, d.harga as harga_beli, b.hpp, c.harga1 as harga_jual_1, c.harga2 as harga_jual_2 from barang_toko a left join harga_barang_toko c on a.barang_kode=c.barang_kode and a.toko_kode=c.toko_kode left join barang b on a.barang_kode=b.kode left join barang_supplier e on a.barang_kode=e.barang_kode left join harga_barang_supplier d on e.barang_kode=d.barang_kode and e.supplier_kode=d.supplier_kode where a.toko_kode='".$data['toko_kode']."' and (a.barang_kode like '%".$data['barang_kode']."%' or b.nama_barang like '%".$data['barang_kode']."%') ".$TambahanQuery;
		
		$result = $this->db->query($query);
		$resultBarangPOS = $result->result_array();
		
		return $resultBarangPOS;
	}
	
	function getDataBarangSupplier($data){
		$query = "select b.kode, b.barcode, b.nama_barang, b.satuan, b.kategori, d.nama as nama_kategori, a.supplier_kode, c.nama_supplier, a.harga from harga_barang_supplier a left join barang b on a.barang_kode=b.kode left join supplier c on a.supplier_kode=c.kode left join kategori_barang d on b.kategori=d.kode where a.supplier_kode='".$data['supplier_kode']."' and (b.kode like '%".$data['barang_kode']."%' or b.barcode like '%".$data['barang_kode']."%' or b.nama_barang like '%".$data['barang_kode']."%')";
		// echo $query;
		// $query = "select a.kode, a.barcode, a.nama_barang, a.satuan, group_concat(c.supplier_kode separator '#') as supplier_kode, group_concat(d.nama_supplier separator '#') as nama_supplier, group_concat(c.harga separator '#') as harga from barang a left join harga_barang_supplier c on a.kode=c.barang_kode left join supplier d on c.supplier_kode=d.kode where a.is_hapus='0' and (a.kode like '%".$data['barang_kode']."%' or a.barcode like '%".$data['barang_kode']."%' or a.nama_barang like '%".$data['barang_kode']."%') group by a.kode order by a.kode";
		
		$result = $this->db->query($query);
		$resultBarangSupplier = $result->result_array();
		
		return $resultBarangSupplier;
	}
	
	function getPenjualanPerbarang($data){
		$kategori = "and c.kategori ='".$data['kategori']."'";
		if($data['kategori'] == ""){
			$kategori = "";
		}
		$query = "select a.fitemkey, c.nama_barang, sum(a.fqty) as qty, sum(a.ftotal) as total from rst_fc_trans_detail a left join rst_fc_trans_header b on a.fcode=b.fcode and a.flokasi=b.flokasi left join barang c on a.fitemkey=c.kode where (date(b.fdate) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and b.fstatuskey='1' and a.flokasi='".$data['toko_kode']."' and (a.fitemkey like '%".$data['barang_kode']."%' or c.nama_barang like '%".$data['barang_kode']."%') ".$kategori." group by a.fitemkey";
		
		$result = $this->db->query($query);
		$resultPenjualanPerbarang = $result->result_array();
		
		return $resultPenjualanPerbarang;
	}

	function getBarangTidakTerjual($data){
		$tanggalArr = explode("-", $data['tanggal_akhir']);
		$query = "select a.barang_kode, a.toko_kode, b.nama_barang, c.saldo_akhir_kwt, d.saldo_akhir_hsat from db_wecode_smart.barang_toko a left join barang b on a.barang_kode=b.kode left join (select barang_kode, toko_kode, tahun, bulan, saldo_akhir_kwt from saldo_barang_toko where bulan=".$tanggalArr[1]." and tahun=".$tanggalArr[0]." and toko_kode='".$data['toko_kode']."') c on a.barang_kode=c.barang_kode left join (select barang_kode, tahun, bulan, saldo_akhir_hsat from saldo_barang_all where bulan=".$tanggalArr[1]." and tahun=".$tanggalArr[0].") d on a.barang_kode=d.barang_kode where a.barang_kode NOT IN (select DISTINCT(a.fitemkey) as itemkey from rst_fc_trans_detail a left join rst_fc_trans_header b on a.fcode=b.fcode and a.flokasi=b.flokasi where (date(b.fdate) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and b.fstatuskey='1' and a.flokasi='".$data['toko_kode']."') and a.toko_kode='".$data['toko_kode']."'  having c.saldo_akhir_kwt > 0";

		if($data['toko_kode'] == ""){
			$query = "select a.kode as barang_kode, a.nama_barang from barang a where a.kode NOT IN (select DISTINCT(a.fitemkey) as itemkey from rst_fc_trans_detail a left join rst_fc_trans_header b on a.fcode=b.fcode and a.flokasi=b.flokasi where (date(b.fdate) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and b.fstatuskey='1')";
		}
		
		$result = $this->db->query($query);
		$resultPenjualanPerbarang = $result->result_array();
		
		return $resultPenjualanPerbarang;
	}
	
	function getDataOmzetPPN($data){
		$query = "select b.fdate, d.fvat, sum(a.ftotal) as total_omzet, sum(if(c.is_ppn='1', a.ftotal, 0)) as omzet_kena_pajak, sum(if(c.is_ppn='1', 0, a.ftotal)) as omzet_tidak_kena_pajak from rst_fc_trans_detail a left join rst_fc_trans_header b on a.fcode=b.fcode and a.flokasi=b.flokasi left join barang c on a.fitemkey=c.kode left join (select fdate, sum(fvat) as fvat from rst_fc_trans_header where flokasi='".$data['toko_kode']."' and fvat<>0 and month(fdate)=".$data['bulan']." and year(fdate)=".$data['tahun']." and fstatuskey='1' group by fdate) d on b.fdate=d.fdate where month(b.fdate)=".$data['bulan']." and year(b.fdate)=".$data['tahun']." and b.fstatuskey='1' and a.fstatuskey='1' and a.flokasi='".$data['toko_kode']."' and c.kategori<>'VOUCHER' and c.kategori<>'1508470349' group by b.fdate order by b.fdate";
		
		$result = $this->db->query($query);
		$resultOmzetPPN = $result->result_array();
		
		return $resultOmzetPPN;
	}
	
	 //k3pg-ppn
	function getDataOmzetHPP($data){
		$query = "select d.fdate, d.fvat, d.total_omzet as total_omzet_inc, d.omzet_kena_pajak, d.ppn, (d.total_omzet - d.ppn) as total_omzet_exc, d.hpp, ((((d.total_omzet - d.ppn) - d.hpp)/d.hpp)*100) as gpm from (select h.fdate, h.fvat, sum(h.ftotal) as total_omzet, sum(if(h.is_ppn='1', h.ftotal, 0)) as omzet_kena_pajak, sum(if(h.is_ppn='1', 0, h.ftotal)) as omzet_tidak_kena_pajak, sum(if(h.is_ppn='1', ((h.ftotal/1.11)*0.11), 0)) as ppn, sum(h.fqty * h.hpp) as hpp from (select b.fdate, e.fvat, a.ftotal, c.is_ppn, a.fqty, c.saldo_akhir_hsat as hpp from rst_fc_trans_detail a left join rst_fc_trans_header b on a.fcode=b.fcode and a.flokasi=b.flokasi left join saldo_barang_all c on a.fitemkey=c.barang_kode left join (select fdate, sum(fvat) as fvat from rst_fc_trans_header where flokasi='".$data['toko_kode']."' and fvat<>0 and month(fdate)=".$data['bulan']." and year(fdate)=".$data['tahun']." and fstatuskey='1' group by fdate) e on b.fdate=e.fdate left join barang f on a.fitemkey=f.kode where month(b.fdate)=".$data['bulan']." and year(b.fdate)=".$data['tahun']." and b.fstatuskey='1' and a.flokasi='".$data['toko_kode']."' and a.fstatuskey='1' and c.bulan=".$data['bulan']." and c.tahun=".$data['tahun']." and f.kategori<>'VOUCHER' and f.kategori<>'1508470349') h group by h.fdate) d order by d.fdate";
		
		$result = $this->db->query($query);
		$resultOmzetHPP = $result->result_array();
		
		return $resultOmzetHPP;
	}
	
	function getHPPPerbulan($data){
		$query = "select barang_kode as kode, is_ppn, saldo_akhir_hsat as hpp from saldo_barang_all where bulan=".$data['bulan']." and tahun=".$data['tahun']."";
		
		$result = $this->db->query($query);
		$resultHPP = $result->result_array();
		$resultHPPArr = array();
		
		foreach($resultHPP as $key => $value){
			$resultHPPArr[$value['kode']] = $value['saldo_akhir_hsat'];
		}
		
		return $resultHPPArr;
	}
	
	function getAnalisaPembelianTunai($data){
		$query = "select a.tanggal, a.bukti, a.supplier_kode, b.nama_supplier, sum(a.kwt * a.harga) as dpp, sum(a.kwt * a.ppn) as ppn, sum(a.jumlah) as total, c.bukti as bukti_kasbank, c.jumlah as jumlah_kasbank, c.is_hapus from pengadaan_barang a left join supplier b on a.supplier_kode=b.kode left join (select * from kasbank where is_hapus='0') c on a.bukti=c.no_ref where a.is_hapus='0' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.status_pembayaran='T' group by a.bukti, a.supplier_kode order by a.tanggal, a.bukti";
		
		$result = $this->db->query($query);
		$dataPembelianTunai = $result->result_array();
		
		return $dataPembelianTunai;
	}
	
	function getKasKecilMini($data){
		$query = "select * from kasbank a where a.kd_kb='111' and unit_kode='VO0008' and month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.toko_kode='".$data['toko_kode']."' and SUBSTR(a.bukti,2,1)='K' and a.is_hapus='0' order by a.kd_cb, a.tanggal";
		
		$result = $this->db->query($query);
		$dataKasKeclMini = $result->result_array();
		
		return $dataKasKeclMini;
	}
	
	function getKategoriBarang(){
		$query = "select kode, nama from kategori_barang";
		
		$result = $this->db->query($query);
		$resultKategori = $result->result_array();
		
		return $resultKategori;
	}
	
	function getDataBarang($data){
		$query = "select a.kode, a.barcode, a.nama_barang, a.satuan, a.hpp, b.harga1 as harga_jual from barang a left join (select barang_kode, harga1 from harga_barang_toko group by barang_kode) b on a.kode=b.barang_kode where a.kategori like '%".$data['kategori_kode']."%' and (a.kode like '".$data['barang_kode']."%' or a.nama_barang like '%".$data['barang_kode']."%') and a.is_hapus='0' and a.is_aktif='1'";
		
		$result = $this->db->query($query);
		$resultDataBarang = $result->result_array();
		
		return $resultDataBarang;
	}
	
	function getDataHarga($data){
		$query = "select a.kode, b.toko_kode, c.nama as nama_toko, b.harga1, a.hpp from barang a left join harga_barang_toko b on a.kode=b.barang_kode left join toko c on b.toko_kode=c.kode where a.kode='".$data['barang_kode']."' and a.is_hapus='0'";
		
		$result = $this->db->query($query);
		$resultDataHarga = $result->result_array();
		
		return $resultDataHarga;
	}
	
	function getDetailMutasiBarangToko($data){
		$query = "select a.kode as barang_kode, a.nama_barang, a.satuan, if(b.kwt is null, 0, b.kwt) as kwt_transfer, if(c.kwt is null, 0, c.kwt) as kwt_penjualan, if(d.kwt is null, 0, d.kwt) as kwt_retur from barang a left join (select barang_kode, sum(kwt) as kwt from transfer_toko where (date(tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and is_hapus='0' and toko_kode='".$data['toko_kode']."' and is_approve='1' group by barang_kode) b on a.kode=b.barang_kode left join (select b.fitemkey as barang_kode, sum(b.fqty) as kwt from rst_fc_trans_header a left join rst_fc_trans_detail b on a.fcode=b.fcode and a.flokasi=b.flokasi where a.fstatuskey='1' and (date(a.fdate) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.flokasi='".$data['toko_kode']."' group by b.fitemkey) c on a.kode=c.barang_kode left join (select a.barang_kode, sum(a.kwt) as kwt from retur_toko a where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' and a.is_approve='1' and a.toko_kode='".$data['toko_kode']."' group by a.barang_kode) d on a.kode=d.barang_kode where b.kwt is not null or c.kwt is not null or d.kwt is not null and (a.kode like '".$data['barang_kode']."%' or a.nama_barang like '".$data['barang_kode']."%') and a.is_hapus='0'";
		
		$result = $this->db->query($query);
		$resultMutasiBarangToko = $result->result_array();
		
		return $resultMutasiBarangToko;
	}
	
	function getDetailMutasiBarangDC($data){
		$query = "select a.kode as barang_kode, a.nama_barang, a.satuan, if(b.kwt is null, 0, b.kwt) as kwt_pengadaan, if(c.kwt is null, 0, c.kwt) as kwt_returtoko, if(d.kwt is null, 0, d.kwt) as kwt_transfertoko, if(e.kwt is null, 0, e.kwt) as kwt_taukeluar, if(f.kwt is null, 0, f.kwt) as kwt_retursupplier from barang a left join (select a.barang_kode, sum(a.kwt) as kwt from pengadaan_barang a where a.is_hapus='0' and (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') group by a.barang_kode) b on a.kode=b.barang_kode left join (select a.barang_kode, sum(a.kwt) as kwt from retur_toko a where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' and a.is_approve='1' group by a.barang_kode) c on a.kode=c.barang_kode left join (select a.barang_kode, sum(a.kwt) as kwt from transfer_toko a where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' and a.is_approve='1' group by a.barang_kode) d on a.kode=d.barang_kode left join (select a.barang_kode, sum(a.kwt) as kwt from tau_keluar a where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' group by a.barang_kode) e on a.kode=e.barang_kode left join (select a.barang_kode, sum(a.kwt) as kwt from retur_supplier a where (date(a.tanggal) between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' group by a.barang_kode) f on a.kode=f.barang_kode where b.kwt is not null or c.kwt is not null or d.kwt is not null or e.kwt is not null or f.kwt is not null and (a.kode like '%".$data['barang_kode']."%' or a.nama_barang like '%".$data['barang_kode']."%') and a.is_hapus='0'";
		
		$result = $this->db->query($query);
		$resultMutasiBarangToko = $result->result_array();
		
		return $resultMutasiBarangToko;
	}
	
	function getRekapReturSupplier($data){
		$query = "";
		if($data['mode'] == "supplier"){
			$query = "select a.bukti, a.supplier_kode, b.nama_supplier, a.tanggal, sum(if(d.is_ppn='1', (a.kwt * a.harga), (a.kwt * (a.harga + a.ppn)))) as dpp, sum(if(d.is_ppn='1', a.kwt * a.ppn, 0)) as ppn, sum(a.jumlah) as total, a.tukar_nota_bukti, c.nama as nama_user from retur_supplier a left join supplier b on a.supplier_kode=b.kode left join user c on a.user_id=c.username left join barang d on a.barang_kode=d.kode where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' group by a.bukti order by a.supplier_kode";
		}else{
			$query = "select a.bukti, a.supplier_kode, b.nama_supplier, a.tanggal, sum(if(d.is_ppn='1', (a.kwt * a.harga), (a.kwt * (a.harga + a.ppn)))) as dpp, sum(if(d.is_ppn='1', a.kwt * a.ppn, 0)) as ppn, sum(a.jumlah) as total, a.tukar_nota_bukti, c.nama as nama_user from retur_supplier a left join supplier b on a.supplier_kode=b.kode left join user c on a.user_id=c.username left join barang d on a.barang_kode=d.kode where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' group by a.bukti order by a.tanggal, a.bukti";
		}
		
		$result = $this->db->query($query);
		$resultReturSupplier = $result->result_array();
		
		return $resultReturSupplier;
	}
	
	function getDataTable($data){
		$query = "select a.ftablekey, a.fname, a.ftranskey, b.fcode, b.fdate, b.fcreatedby, b.fcustname, a.fstatus, b.fstatuskey from rst_table_management a left join rst_fc_trans_header b on a.ftranskey=b.fpkey where (a.ftranskey='".$data['key']."' or b.fcode='".$data['key']."')";
		
		$result = $this->db->query($query);
		$resultTable = $result->result_array();
		
		return $resultTable;
	}
	
	function CloseTable($data){
		$querytable = "update rst_table_management set fstatus='0' where ftranskey='".$data['ftranskey']."'";
		$this->db->query($querytable);
		
		$queryheader = "update rst_fc_trans_header set fstatuskey='1' where fpkey='".$data['ftranskey']."'";
		$this->db->query($queryheader);
	}
	
	function AktifkanKasbankPembelianTunai($data){
		$username = $this->session->userdata('username');
		$query = "update kasbank set is_hapus='0', user_id='".$username."', waktu_update=NOW() where no_ref='".$data['bukti']."'";
		
		$this->db->query($query);
	}
	
	function getDataPerubahanHarga($data){
			$query = "SELECT b.* from harga_barang_toko a left join (SELECT x.barang_kode, b.nama_barang, b.barcode, x.toko_kode, group_concat(x.harga1 order by x.waktu_insert desc ) as group_harga, group_concat(x.waktu_insert order by x.waktu_insert desc ) as group_waktu FROM db_wecode_smart.harga_barang_toko x left join barang b on x.barang_kode=b.kode WHERE toko_kode='".$data['toko_kode']."' and date(x.waktu_insert) <= '".$data['tanggal']."' GROUP BY x.barang_kode having POSITION(',' in group_harga)) b on a.barang_kode=b.barang_kode and a.toko_kode=b.toko_kode where a.toko_kode='".$data['toko_kode']."' and date(a.waktu_insert)='".$data['tanggal']."' and b.barang_kode is not null";

		if($data['barang_kode'] != ""){
			$KodeBarangArr = explode(";", $data['barang_kode']);
			$kodein = "";
			foreach ($KodeBarangArr as $key => $value) {
				$kodein .= "'".$value."',";
			}
			$kodein = substr($kodein, 0, strlen($kodein) - 1);
			$query = "SELECT b.kode as barang_kode, b.nama_barang, b.barcode, x.toko_kode, group_concat(x.harga1 order by x.waktu_insert desc ) as group_harga, group_concat(x.waktu_insert order by x.waktu_insert desc ) as group_waktu, c.harga1 FROM barang b left join (select * from db_wecode_smart.harga_barang_toko where toko_kode='".$data['toko_kode']."') x on b.kode=x.barang_kode left join (select * from harga_barang_toko where toko_kode='".$data['toko_kode']."') c on b.kode=c.barang_kode WHERE (b.kode in (".$kodein.") or b.barcode in (".$kodein.")) group by b.kode";
		}
		// echo $query;
		$result = $this->db->query($query);
		$resultTable = $result->result_array();
		
		return $resultTable;
	}
	
	function getDataPromo($data){
		$query = "select a.kode, a.toko_kode, a.barang_kode, b.nama_barang, a.persentase_promo, a.harga_promo, a.kwt_kondisi, a.tanggal_awal, a.tanggal_akhir, a.user_id from promo a left join barang b on a.barang_kode=b.kode where a.toko_kode='".$data['toko_kode']."' and a.is_aktif='1'";
		
		$result = $this->db->query($query);
		$resultTable = $result->result_array();
		
		return $resultTable;
	}
	
	function getLaporanStockOpname($data){
		// $query = "select c.*, ((c.stok_fisik + c.revisi) - c.stok_sistem) as selisih, (c.hpp * ((c.stok_fisik + c.revisi) - c.stok_sistem)) as jumlah_selisih from (select a.barang_kode, b.nama_barang, a.stok_sistem, sum(a.stok_opname) as stok_fisik, if(a.revisi is null, 0, a.revisi) as revisi, a.hpp, GROUP_CONCAT(a.rak separator ' || ') as rak from stock_opname a left join barang b on a.barang_kode=b.kode where a.toko_kode='".$data['toko_kode']."' and a.bukti='".$data['bukti']."' group by a.barang_kode) c order by selisih";
		$query = "select c.*, ((c.stok_fisik + c.revisi) - c.stok_sistem) as selisih, (c.hpp * ((c.stok_fisik + c.revisi) - c.stok_sistem)) as jumlah_selisih from (select a.barang_kode, b.nama_barang, a.stok_sistem, sum(a.stok_opname) as stok_fisik, if(a.revisi is null, 0, a.revisi) as revisi, round(a.hpp,2) hpp, GROUP_CONCAT(a.rak separator ' || ') as rak from stock_opname a left join barang b on a.barang_kode=b.kode where a.toko_kode='".$data['toko_kode']."' and a.bukti='".$data['bukti']."' group by a.barang_kode) c order by selisih";
		$result = $this->db->query($query);
		$resultTable = $result->result_array();
		
		return $resultTable;
	}

	function getLaporanPenjualanPulsa($data){
		$query = "SELECT a.kode, a.nama_barang, b.kwt as kwt_jual, c.kwt as kwt_bi, b.fprice, a.hpp FROM db_wecode_smart.barang a LEFT JOIN (SELECT a.flokasi, a.fitemkey, c.nama_barang, a.fprice, SUM(a.fqty) as kwt FROM db_wecode_smart.rst_fc_trans_detail a LEFT JOIN db_wecode_smart.rst_fc_trans_header b ON a.fcode=b.fcode AND a.flokasi=b.flokasi LEFT JOIN db_wecode_smart.barang c on a.fitemkey=c.kode WHERE (DATE(b.fdate) BETWEEN '".$data['tanggal_awal']."' AND '".$data['tanggal_akhir']."') AND a.fstatuskey='1' AND b.fstatuskey='1' AND c.kategori='VOUCHER EL' GROUP BY a.fitemkey) b ON a.kode=b.fitemkey LEFT JOIN (SELECT a.barang_kode, b.nama_barang, SUM(a.kwt) as kwt FROM db_wecode_smart.pengadaan_barang a LEFT JOIN db_wecode_smart.barang b ON a.barang_kode=b.kode WHERE (DATE(a.tanggal) BETWEEN '".$data['tanggal_awal']."' AND '".$data['tanggal_akhir']."') AND a.is_hapus='0' and b.kategori='VOUCHER EL' GROUP BY a.barang_kode) c ON a.kode=c.barang_kode WHERE a.kategori='VOUCHER EL';";

		$result = $this->db->query($query);
		$resultTable = $result->result_array();
		
		return $resultTable;
	}

	function getLaporanFeePLN($data){
		$query = "select a.fcode, b.fdate, a.flokasi, a.fitemkey, c.nama_barang, a.fqty from db_wecode_smart.rst_fc_trans_detail a LEFT JOIN db_wecode_smart.rst_fc_trans_header b ON a.fcode=b.fcode AND a.flokasi=b.flokasi LEFT JOIN db_wecode_smart.barang c on a.fitemkey=c.kode WHERE (DATE(b.fdate) BETWEEN '".$data['tanggal_awal']."' AND '".$data['tanggal_akhir']."') AND a.fstatuskey='1' AND b.fstatuskey='1' AND c.kategori='VOUCHER' and b.flokasi='".$data['toko_kode']."' order by b.fdate";

		$result = $this->db->query($query);
		$resultTable = $result->result_array();
		
		return $resultTable;
	}

	function getPenjualanKasir($data){
		$query = "select date(a.fdate) as fdate, sum(a.fbill_amount + a.fvat + a.fpembulatan + a.fpos_tax_count) as fbill_amount, sum(a.fcash-a.fcash_change) as fpayment, sum(if(a.fbank_name='MANDIRI', a.fdebet, 0)) as kartu_debit_mandiri, sum(if(a.fbank_name='BRI', a.fdebet, 0)) as kartu_debit_bri, sum(if(a.fbank_name='BNI', a.fdebet, 0)) as kartu_debit_bni, sum(a.fkredit) as kartu_kredit, sum(if(a.ftype=2, (a.fbill_amount + a.fvat), 0)) as kredit, sum(a.fshu) as fshu, sum(a.fkupon) as fkupon, sum(a.fpotga + a.fvat +a.fpembulatan + a.fpos_tax_count) as kredit_anggota, sum(a.fvoucher) as voucher from rst_fc_trans_header a where (DATE(a.fdate) BETWEEN '".$data['tanggal_awal']."' AND '".$data['tanggal_akhir']."') and a.fbill_amount is not null and a.flokasi='".$data['toko_kode']."' and a.fstatuskey='1' and a.fcodecashier='".$data['kasir_kode']."' group by date(a.fdate) order by date(a.fdate)";

		$result = $this->db->query($query);
		$resultTable = $result->result_array();
		
		return $resultTable;
	}

	function getPenjualanKasirPerKel($data){
		$query = "select c.kategori, d.nama, sum(a.ftotal) as jumlah from rst_fc_trans_detail a left join rst_fc_trans_header b on a.fcode=b.fcode and a.flokasi=b.flokasi left join barang c on a.fitemkey=c.kode left join kategori_barang d on c.kategori=d.kode where (date(b.fdate) BETWEEN '".$data['tanggal_awal']."' AND '".$data['tanggal_akhir']."') and a.fstatuskey='1' and b.fstatuskey='1' and b.flokasi='".$data['toko_kode']."' and b.fcodecashier='".$data['kasir_kode']."' group by c.kategori";

		$result = $this->db->query($query);
		$resultTable = $result->result_array();
		
		return $resultTable;
	}

	function getBarangLakuKonsinyasi($data){
		$tglArr = explode("-", $data['tanggal_awal']);

		$query = "select a.fitemkey as barang_kode, c.nama_barang, c.kategori, sum(a.fqty) as qty, sum(a.fqty * f.hpp) as total, ifnull(e.fee_konsinyasi, 0) as fee_konsinyasi from rst_fc_trans_detail a left join rst_fc_trans_header b on a.fcode=b.fcode and a.flokasi=b.flokasi left join barang c on a.fitemkey=c.kode left join harga_barang_supplier d on a.fitemkey=d.barang_kode left join supplier e on d.supplier_kode=e.kode left join (select * from hpp where bulan=".$tglArr[1]." and tahun=".$tglArr[0].") f on a.fitemkey=f.barang_kode where a.fstatuskey='1' and b.fstatuskey='1' and (b.fdate BETWEEN '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and b.flokasi='".$data['toko_kode']."' and e.kode='".$data['supplier_kode']."' group by a.fitemkey order by c.kategori, c.nama_barang";
		// echo $query;
		$result = $this->db->query($query);
		$resultTable = $result->result_array();
		
		return $resultTable;
	}

	function getRekapitulasiBarangKonsinyasi($data){
		$TanggalArr = explode("-", $data['tanggal_awal']);
		$data['bulan'] = $TanggalArr[1];
		$data['tahun'] = $TanggalArr[0];

		$from_unix_time = mktime(0, 0, 0, $TanggalArr[1], $TanggalArr[2], $TanggalArr[0]);
		$day_before = strtotime("yesterday", $from_unix_time);
		$HariKemaren = date('Y-m-d', $day_before);

		$query = "select a.kategori, i.nama as nama_kategori, j.supplier_kode, k.nama_supplier, sum(ifnull(b.saldo_awal_kwt, 0) * ifnull(l.hpp, 0)) as saldo_awal_kwt, sum(ifnull(c.kwt, 0) * ifnull(l.hpp, 0)) as kwt_in_awal, sum(ifnull(d.kwt, 0) * ifnull(l.hpp, 0)) as kwt_out_awal, sum(ifnull(e.kwt, 0) * ifnull(l.hpp, 0)) as kwt_retur_awal, sum(ifnull(m.kwt, 0) * ifnull(l.hpp, 0)) as kwt_biaya_awal, sum(ifnull(f.kwt, 0) * ifnull(l.hpp, 0)) as kwt_in, sum(ifnull(g.kwt, 0) * ifnull(l.hpp, 0)) as kwt_out, sum(ifnull(h.kwt, 0) * ifnull(l.hpp, 0)) as retur, sum(ifnull(n.kwt, 0) * ifnull(l.hpp, 0)) as biaya, ifnull(k.fee_konsinyasi, 0) as fee_konsinyasi 
		from barang a 
		left join (select * from saldo_barang_konsinyasi where bulan=".$data['bulan']." and tahun=".$data['tahun']." and toko_kode='".$data['toko_kode']."') b on a.kode=b.barang_kode 
		left join (select a.barang_kode, sum(a.kwt) as kwt from transfer_toko_konsinyasi a where (date(a.tanggal) BETWEEN '".$data['tahun']."-".$data['bulan']."-01' and '".$HariKemaren."') and a.is_hapus='0' and a.toko_kode='".$data['toko_kode']."' and a.is_approve='1' group by a.barang_kode) c on a.kode=c.barang_kode 
		left join (select b.fitemkey as barang_kode, sum(b.fqty) as kwt from rst_fc_trans_header a left join rst_fc_trans_detail b on a.fcode=b.fcode and a.flokasi=b.flokasi where a.fstatuskey='1' and b.fstatuskey='1' and (date(a.fdate) BETWEEN '".$data['tahun']."-".$data['bulan']."-01' and '".$HariKemaren."') and a.flokasi='".$data['toko_kode']."' group by b.fitemkey) d on a.kode=d.barang_kode 
		left join (select a.barang_kode, sum(a.kwt) as kwt from retur_toko_konsinyasi a where (date(a.tanggal) BETWEEN '".$data['tahun']."-".$data['bulan']."-01' and '".$HariKemaren."') and a.is_hapus='0' and a.is_approve='1' and a.toko_kode='".$data['toko_kode']."' group by a.barang_kode) e on a.kode=e.barang_kode 
		left join (select a.barang_kode, sum(a.kwt) as kwt from tau_keluar_konsinyasi a where (date(a.tanggal) BETWEEN '".$data['tahun']."-".$data['bulan']."-01' and '".$HariKemaren."') and a.is_hapus='0' and a.toko_kode='".$data['toko_kode']."' group by a.barang_kode) m on a.kode=m.barang_kode 
		left join (select a.barang_kode, sum(a.kwt) as kwt from transfer_toko_konsinyasi a where (date(a.tanggal) BETWEEN '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' and a.toko_kode='".$data['toko_kode']."' and a.is_approve='1' group by a.barang_kode) f on a.kode=f.barang_kode 
		left join (select b.fitemkey as barang_kode, sum(b.fqty) as kwt from rst_fc_trans_header a left join rst_fc_trans_detail b on a.fcode=b.fcode and a.flokasi=b.flokasi where a.fstatuskey='1' and b.fstatuskey='1' and (date(a.fdate) BETWEEN '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.flokasi='".$data['toko_kode']."' group by b.fitemkey) g on a.kode=g.barang_kode 
		left join (select a.barang_kode, sum(a.kwt) as kwt from retur_toko_konsinyasi a where (date(a.tanggal) BETWEEN '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' and a.is_approve='1' and a.toko_kode='".$data['toko_kode']."' group by a.barang_kode) h on a.kode=h.barang_kode 
		left join (select a.barang_kode, sum(a.kwt) as kwt from tau_keluar_konsinyasi a where (date(a.tanggal) BETWEEN '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') and a.is_hapus='0' and a.toko_kode='".$data['toko_kode']."' group by a.barang_kode) n on a.kode=n.barang_kode 
		left join kategori_barang i on a.kategori=i.kode 
		left join harga_barang_supplier j on a.kode=j.barang_kode 
		left join supplier k on j.supplier_kode=k.kode 
		left join (select bulan, tahun, barang_kode, hpp from hpp where bulan=".$data['bulan']." and tahun=".$data['tahun'].") l on a.kode=l.barang_kode 
		where a.kategori in ('KA', 'KB', 'KC', 'KD', 'KE') and (b.saldo_awal_kwt <> 0 or c.kwt <> 0 or d.kwt <> 0 or e.kwt <> 0 or f.kwt <> 0 or g.kwt <> 0 or h.kwt <> 0 or m.kwt <> 0 or n.kwt <> 0) group by j.supplier_kode, a.kategori order by a.kategori, k.nama_supplier";
		// echo $query;
		$result = $this->db->query($query);
		$resultTable = $result->result_array();
		
		return $resultTable;
	}

	function getSaldoGudangAll($data){
		$query = "select a.barang_kode, a.nama_barang, a.kategori, a.satuan, sum(a.saldo_toko1) as saldo_toko1, sum(a.saldo_toko2) as saldo_toko2, sum(a.saldo_toko4) as saldo_toko4, sum(a.saldo_toko5) as saldo_toko5, sum(a.saldo_toko11) as saldo_toko11, sum(a.saldo_gudang) as saldo_gudang, a.hpp from (select a.barang_kode, b.nama_barang, b.satuan, b.kategori, if(a.toko_kode='VO0001', a.saldo_akhir_kwt, 0) as saldo_toko1, if(a.toko_kode='VO0002', a.saldo_akhir_kwt, 0) as saldo_toko2, if(a.toko_kode='VO0004', a.saldo_akhir_kwt, 0) as saldo_toko4, if(a.toko_kode='VO0005', a.saldo_akhir_kwt, 0) as saldo_toko5, if(a.toko_kode='VO0011', a.saldo_akhir_kwt, 0) as saldo_toko11, if(a.toko_kode='VO0006', a.saldo_akhir_kwt, 0) as saldo_gudang, e.hpp, (e.hpp * a.saldo_akhir_kwt) as jumlah_hpp from saldo_barang_toko a left join barang b on a.barang_kode=b.kode left join toko d on a.toko_kode=d.kode left join (select barang_kode, hpp from hpp where bulan=".$data['bulan']." and tahun=".$data['tahun'].") e on a.barang_kode=e.barang_kode where a.tahun=".$data['tahun']." and a.bulan=".$data['bulan']." and (a.barang_kode like '".$data['barang_kode']."%' or b.nama_barang like '".$data['barang_kode']."%') and b.is_aktif='1' group by a.barang_kode, a.toko_kode) a group by a.barang_kode order by a.nama_barang";

		$result = $this->db->query($query);
		$resultTable = $result->result_array();
		
		return $resultTable;
	}

	function getRekapPenjualanNonAnggota($data){
		$query = "select a.fcustkey, a.fcustname, e.kategori, g.nama as nama_kategori, sum(b.ftotal) as total, sum(b.fqty * f.hpp) as hpp from rst_fc_trans_header a left join rst_fc_trans_detail b on a.fcode=b.fcode and a.flokasi=b.flokasi left join pelanggan d on a.fcustkey=d.kode left join barang e on b.fitemkey=e.kode left join (select * from hpp where bulan=".$data['bulan']." and tahun=".$data['tahun'].") f on b.fitemkey=f.barang_kode left join kategori_barang g on e.kategori=g.kode where month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']." and d.jenis_pelanggan<>'1440822187' and a.fstatuskey='1' and b.fstatuskey='1' and a.flokasi='".$data['toko_kode']."' group by a.fcustkey, e.kategori order by a.fcustkey, e.kategori";

		$result = $this->db->query($query);
		$resultTable = $result->result_array();
		
		return $resultTable;
	}

	function getKelPenjualanNonAnggota($data){
		$query = "select e.kategori, g.nama as nama_kategori, sum(b.ftotal) as total, sum(b.fqty * f.hpp) as hpp from rst_fc_trans_header a left join rst_fc_trans_detail b on a.fcode=b.fcode and a.flokasi=b.flokasi left join pelanggan d on a.fcustkey=d.kode left join barang e on b.fitemkey=e.kode left join (select * from hpp where bulan=".$data['bulan']." and tahun=".$data['tahun'].") f on b.fitemkey=f.barang_kode left join kategori_barang g on e.kategori=g.kode where month(a.fdate)=".$data['bulan']." and year(a.fdate)=".$data['tahun']." and d.jenis_pelanggan<>'1440822187' and a.fstatuskey='1' and b.fstatuskey='1' and a.flokasi='".$data['toko_kode']."' group by e.kategori order by e.kategori";

		$result = $this->db->query($query);
		$resultTable = $result->result_array();
		
		return $resultTable;
	}
	//day(a.tanggal)>=".$data['awal']." and day(a.tanggal)<=".$data['akhir']." and 
	//sum(c.hpp)
	function getPerubahanHargaBeli($data){
		$query = "select a.bukti, a.tanggal, a.waktu_update, a.barang_kode, b.kategori, b.nama_barang, a.kwt, (a.harga+a.ppn) as harga, 
		c.hpp as hpp from pengadaan_barang a left join barang b on a.barang_kode=b.kode left join (select * from hpp where bulan=".$data['bulan']."
		and tahun=".$data['tahun'].") c on a.barang_kode=c.barang_kode where month(a.tanggal)=".$data['bulan']." and 
		year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' and a.barang_kode in (select m.barang_kode from (select a.barang_kode, b.nama_barang,
		sum((a.harga+a.ppn)) as harga, sum(c.hpp) as hpp from pengadaan_barang a left join barang b on a.barang_kode=b.kode left 
		join (select * from hpp where bulan=".$data['bulan']." and tahun=".$data['tahun'].") c on a.barang_kode=c.barang_kode 
		where month(a.tanggal)=".$data['bulan']." and year(a.tanggal)=".$data['tahun']." and a.is_hapus='0' group by a.barang_kode 
		having round(harga, 2)<>round(hpp, 2)) m) order by b.kategori, a.barang_kode, a.waktu_update";

		$result = $this->db->query($query);
		$resultTable = $result->result_array();
		
		return $resultTable;
	}

	function RekapDetailPenjualanHarian($data){
		// $queryAtas = "SELECT p.flokasi, UPPER(t.nama) as nama_toko, t.alamat ,DATE(p.fdate) as tanggal, p.fshift, SUM(IFNULL(p.fgrand_total,0)) AS fgrand_total , SUM(IFNULL(p.fcash,0)) AS fcash, SUM(IFNULL(p.fcash_change,0)) AS 'Kembalian', SUM(IFNULL(p.fcash-p.fcash_change,0)) AS 'UangTunai', SUM(IFNULL(p.fkupon,0)) AS fkupon, SUM(IFNULL(p.fshu,0)) AS fshu , SUM(IFNULL(p.fdebet + p.fpos_serviceCharge,0))AS fdebet , SUM(IF(p.fbank_name='LINKAJA', p.fdebet + p.fpos_serviceCharge, 0)) AS link_aja, SUM(IF(p.fbank_name='MANDIRI', p.fdebet + p.fpos_serviceCharge, 0)) AS kartu_debit_mandiri, SUM(IF(p.fbank_name='BCA', p.fdebet + p.fpos_serviceCharge, 0)) AS kartu_debit_bca, SUM(IF(p.fbank_name='BRI', p.fdebet + p.fpos_serviceCharge, 0)) AS kartu_debit_bri, SUM(IF(p.fbank_name='BNI', p.fdebet + p.fpos_serviceCharge, 0)) AS kartu_debit_bni, SUM(IF(p.fbank_name='BANK DKI', p.fdebet + p.fpos_serviceCharge, 0)) AS kartu_debit_dki, SUM(IF(p.fbank_name='AGEN-BNI46', p.fdebet + p.fpos_serviceCharge, 0)) AS agenbni46, SUM(IF(p.fbank_name='TRANSFER', p.fdebet + p.fpos_serviceCharge, 0)) AS transfer, SUM(IF(p.funit='MANDIRI', p.fkredit, 0)) AS kartu_kredit_mandiri, SUM(IF(p.funit='BCA', p.fkredit, 0)) AS kartu_kredit_bca, SUM(IF(p.funit='BRI', p.fkredit, 0)) AS kartu_kredit_bri, SUM(IF(p.funit='BNI', p.fkredit, 0)) AS kartu_kredit_bni, SUM(IFNULL(p.fvoucher,0)) AS fvoucher, SUM(IFNULL(p.fpoint,0)) AS fpoint , SUM(IFNULL(p.fkredit,0)) AS fkredit , SUM(IFNULL(p.fpotga,0)) AS fpotga , SUM(IFNULL(p.ftau,0)) AS ftau , SUM((p.fcash-p.fcash_change)+p.fkupon+p.fshu+p.fdebet + p.fpos_serviceCharge +p.fvoucher+p.fpoint+p.ftau) AS 'komposisi', SUM(IFNULL(u.jumlah,0)) AS 'Piutang', SUM(IF(p.fname_payment='KREDIT BUKU', u.jumlah, 0)) AS kredit_buku, SUM(IF(p.fname_payment='KREDIT INSTANSI', u.jumlah, 0)) AS kredit_perusahaan, SUM(IFNULL(k.jml_kredit,0)) AS 'KreditAngs', SUM(IF(p.fcash> 0 , 1, 0)) AS Countfcash, SUM(IF(p.fkupon> 0 , 1, 0)) AS Countfkupon, SUM(IF(p.fshu> 0 , 1, 0)) AS Countfshu, SUM(IF(p.fdebet> 0 , 1, 0)) AS Countfdebet, SUM(IF(p.fvoucher> 0 , 1, 0)) AS Countfvoucher, SUM(IF(p.fpoint> 0 , 1, 0)) AS Countfpoint, SUM(IF(p.fkredit> 0 , 1, 0)) AS Countfkredit, SUM(IF(p.fpotga> 0 , 1, 0)) AS Countfpotga, SUM(IF(p.ftau> 0 , 1, 0)) AS Countftau, SUM(IF(u.jumlah> 0 , 1, 0)) AS CountfPiutang, SUM(IF(p.fname_payment='KREDIT BUKU' , 1, 0)) AS Countfjml_kreditBuku, SUM(IF(p.fname_payment='KREDIT INSTANSI' , 1, 0)) AS Countfjml_kreditIns, SUM(IF(p.fname_payment='KREDIT ANGS' , 1, 0)) AS Countfjml_kreditAngs, o.jabatan AS JabatanMgr, o.nama AS NamaMgr, d.jabatan AS jabatanKabid, d.nama AS NamaKabid, n.jabatan AS jabatanUnit, n.nama AS NamaUnit FROM rst_fc_trans_header p LEFT JOIN piutang u ON p.fcode=u.ref_penjualan AND u.toko_kode=p.flokasi LEFT JOIN t_kredit_anggota k ON p.fcode=k.ref_bukti_bo AND k.kd_toko=p.flokasi LEFT JOIN ttd_kaunit n ON p.flokasi=n.kd_unit, toko t, `user` a, ttd_mgr_op o, ttd_kabid d WHERE p.flokasi=t.kode AND a.username=p.fcodecashier AND (p.fdate between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') AND p.fstatuskey='1' AND p.flokasi='".$data['toko_kode']."' group by p.fdate";

		$queryAtas = "
		select
			p.flokasi,
			upper(t.nama) as nama_toko,
			t.alamat ,
			date(p.fdate) as tanggal,
			p.fshift,
			sum(IFNULL(p.fgrand_total, 0)) as fgrand_total ,
			sum(IFNULL(p.fcash, 0)) as fcash,
			sum(IFNULL(p.fcash_change, 0)) as 'Kembalian',
			sum(IFNULL(p.fcash-p.fcash_change, 0)) as 'UangTunai',
			sum(IFNULL(p.fkupon, 0)) as fkupon,
			sum(IFNULL(p.fshu, 0)) as fshu ,
			sum(IFNULL(p.fdebet + p.fpos_serviceCharge, 0))as fdebet ,
			sum(if(p.fbank_name = 'LINKAJA', p.fdebet + p.fpos_serviceCharge, 0)) as link_aja,
			sum(if(p.fbank_name = 'MANDIRI', p.fdebet + p.fpos_serviceCharge, 0)) as kartu_debit_mandiri,
			sum(if(p.fbank_name = 'BCA', p.fdebet + p.fpos_serviceCharge, 0)) as kartu_debit_bca,
			sum(if(p.fbank_name = 'BRI', p.fdebet + p.fpos_serviceCharge, 0)) as kartu_debit_bri,
			sum(if(p.fbank_name = 'BNI', p.fdebet + p.fpos_serviceCharge, 0)) as kartu_debit_bni,
			sum(if(p.fbank_name = 'BANK DKI', p.fdebet + p.fpos_serviceCharge, 0)) as kartu_debit_dki,
			sum(if(p.fbank_name = 'AGEN-BNI46', p.fdebet + p.fpos_serviceCharge, 0)) as agenbni46,
			sum(if(p.fbank_name = 'TRANSFER', p.fdebet + p.fpos_serviceCharge, 0)) as transfer,
			sum(if(p.fbank_name = 'TRANSFER BNI', p.fdebet + p.fpos_serviceCharge, 0)) as transfer_bni,
			sum(if(p.fbank_name = 'TRANSFER MANDIRI', p.fdebet + p.fpos_serviceCharge, 0)) as transfer_mandiri,
			sum(if(p.funit = 'MANDIRI', p.fkredit, 0)) as kartu_kredit_mandiri,
			sum(if(p.funit = 'BCA', p.fkredit, 0)) as kartu_kredit_bca,
			sum(if(p.funit = 'BRI', p.fkredit, 0)) as kartu_kredit_bri,
			sum(if(p.funit = 'BNI', p.fkredit, 0)) as kartu_kredit_bni,
			sum(IFNULL(p.fvoucher, 0)) as fvoucher,
			sum(IFNULL(p.fpoint, 0)) as fpoint ,
			sum(IFNULL(p.fkredit, 0)) as fkredit ,
			sum(IFNULL(p.fpotga, 0)) as fpotga ,
			sum(IFNULL(p.ftau, 0)) as ftau ,
			sum((p.fcash-p.fcash_change)+ p.fkupon + p.fshu + p.fdebet + p.fpos_serviceCharge + p.fvoucher + p.fpoint + p.ftau) as 'komposisi',
			sum(IFNULL(u.jumlah, 0)) as 'Piutang',
			sum(if(p.fname_payment = 'KREDIT BUKU', u.jumlah, 0)) as kredit_buku,
			sum(if(p.fname_payment = 'KREDIT INSTANSI', u.jumlah, 0)) as kredit_perusahaan,
			sum(IFNULL(k.jml_kredit, 0)) as 'KreditAngs',
			sum(if(p.fcash> 0 , 1, 0)) as Countfcash,
			sum(if(p.fkupon> 0 , 1, 0)) as Countfkupon,
			sum(if(p.fshu> 0 , 1, 0)) as Countfshu,
			sum(if(p.fdebet> 0 , 1, 0)) as Countfdebet,
			sum(if(p.fvoucher> 0 , 1, 0)) as Countfvoucher,
			sum(if(p.fpoint> 0 , 1, 0)) as Countfpoint,
			sum(if(p.fkredit> 0 , 1, 0)) as Countfkredit,
			sum(if(p.fpotga> 0 , 1, 0)) as Countfpotga,
			sum(if(p.ftau> 0 , 1, 0)) as Countftau,
			sum(if(u.jumlah> 0 , 1, 0)) as CountfPiutang,
			sum(if(p.fname_payment = 'KREDIT BUKU' , 1, 0)) as Countfjml_kreditBuku,
			sum(if(p.fname_payment = 'KREDIT INSTANSI' , 1, 0)) as Countfjml_kreditIns,
			sum(if(p.fname_payment = 'KREDIT ANGS' , 1, 0)) as Countfjml_kreditAngs,
			o.jabatan as JabatanMgr,
			o.nama as NamaMgr,
			d.jabatan as jabatanKabid,
			d.nama as NamaKabid,
			n.jabatan as jabatanUnit,
			n.nama as NamaUnit,
			concat(p.fcodecashier, ' - ', ks.nama) as kasir
		from
			rst_fc_trans_header p
		left join piutang u on
			p.fcode = u.ref_penjualan
			and u.toko_kode = p.flokasi
		left join t_kredit_anggota k on
			p.fcode = k.ref_bukti_bo
			and k.kd_toko = p.flokasi
		left join `user` ks on ks.username = p.fcodecashier
		left join ttd_kaunit n on
			p.flokasi = n.kd_unit,
			toko t,
			`user` a,
			ttd_mgr_op o,
			ttd_kabid d
		where
			p.flokasi = t.kode
			and a.username = p.fcodecashier
			and (p.fdate between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."')
			and p.fstatuskey = '1'
			and p.flokasi = '".$data['toko_kode']."' ";
		if ($data['kasir_kode'] != ''){
			$queryAtas.="and p.fcodecashier = '".$data['kasir_kode']."' ";
		}
		$queryAtas.="group by p.fdate ";
		$result = $this->db->query($queryAtas);
		$resultTable = $result->result_array();
		
		return $resultTable;
	}

	function RekapDetailPenjualanHarianBawah($data){
		$queryAtas = "select a.kode_akun, a.kategori, a.nama_kategori, (ifnull(a.total, 0) + ifnull(b.biaya, 0)) as total, a.JabatanMgr, a.NamaMgr, a.jabatanKabid, a.NamaKabid, a.jabatanUnit, a.NamaUnit from ( select IFNULL(e.kode_akun, '') as kode_akun, c.kategori, d.nama as nama_kategori, SUM(a.ftotal) as total, '' as JabatanMgr, '' as NamaMgr, '' as jabatanKabid, '' as NamaKabid, '' as jabatanUnit, '' as NamaUnit from rst_fc_trans_detail a left join rst_fc_trans_header b on a.fcode = b.fcode and a.flokasi = b.flokasi left join barang c on a.fitemkey = c.kode left join kategori_barang d on c.kategori = d.kode left join ( select * from kategori_barang_akun where toko_kode = '".$data['toko_kode']."') e on d.kode = e.kategori_barang_kode where a.fstatuskey = '1' and b.fstatuskey = '1' and b.flokasi = '".$data['toko_kode']."' and (b.fdate between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') group by c.kategori) a left join ( select a.kategori, sum(a.biaya) as biaya from ( select a.fcode, a.flokasi, b.fitemkey, c.kategori, (a.fpos_serviceCharge + a.fvat + fpos_tax_count) as biaya from rst_fc_trans_header a left join rst_fc_trans_detail b on a.fcode = b.fcode and a.flokasi = b.flokasi left join barang c on b.fitemkey = c.kode where a.fstatuskey = '1' and a.flokasi = '".$data['toko_kode']."' and (a.fdate between '".$data['tanggal_awal']."' and '".$data['tanggal_akhir']."') group by a.fcode, a.flokasi having biaya > 0) a group by a.kategori) b on a.kategori = b.kategori union select '', '', '', 0 as total, o.jabatan as JabatanMgr, o.nama as NamaMgr, k.jabatan as jabatanKabid, k.nama as NamaKabid, n.jabatan as jabatanUnit, n.nama as NamaUnit from ttd_kaunit n , ttd_mgr_op o, ttd_kabid k where n.kd_unit = '".$data['toko_kode']."'";

		$result = $this->db->query($queryAtas);
		$resultTable = $result->result_array();
		
		return $resultTable;
	}
}

// SELECT a.supplier_kode, a.barang_kode, a.tanggal, round(a.harga) as harga, round(b.hpp) as hpp FROM (SELECT a.supplier_kode, a.barang_kode, a.tanggal, (a.harga + a.ppn) as harga FROM pengadaan_barang a INNER JOIN ( SELECT a.barang_kode, GROUP_CONCAT(a.waktu_update ORDER BY a.waktu_update DESC) grouped_year FROM pengadaan_barang a where is_hapus='0' GROUP BY barang_kode) group_max ON a.barang_kode = group_max.barang_kode AND FIND_IN_SET(a.waktu_update, grouped_year) BETWEEN 1 AND 1 where a.is_hapus='0' ORDER BY a.barang_kode, a.tanggal DESC) a left join (select bulan, tahun, barang_kode, hpp from hpp where bulan=11 and tahun=2018) b on a.barang_kode=b.barang_kode where round(a.harga)<>round(b.hpp);

// SELECT a.supplier_kode, a.barang_kode, a.tanggal, round(a.harga) as harga, round(b.hpp) as hpp FROM (SELECT a.supplier_kode, a.barang_kode, a.tanggal, (a.harga + a.ppn) as harga FROM pengadaan_barang_konsinyasi a INNER JOIN ( SELECT a.barang_kode, GROUP_CONCAT(a.waktu_update ORDER BY a.waktu_update DESC) grouped_year FROM pengadaan_barang_konsinyasi a where a.is_hapus='0' GROUP BY barang_kode) group_max ON a.barang_kode = group_max.barang_kode AND FIND_IN_SET(a.waktu_update, grouped_year) BETWEEN 1 AND 1 where a.is_hapus='0' ORDER BY a.barang_kode, a.tanggal DESC) a left join (select bulan, tahun, barang_kode, hpp from hpp where bulan=11 and tahun=2018) b on a.barang_kode=b.barang_kode where round(a.harga)<>round(b.hpp);